<?php namespace pvaass\Inschrijven\Models;

use Doctrine\DBAL\Types\DateType;
use Illuminate\Mail\Message;
use Model;
use Validator;

class Inschrijving extends Model
{
    use \October\Rain\Database\Traits\Validation;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pvaass_inschrijven_inschrijvingen';
    protected $jsonable = ['zwembad'];
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    protected $appends = ['zwembad_string'];

    public $rules = [
        'algemene_voorwaarden' => 'required|accepted',
        'zwembad' => 'required|notInvalid',
        'voornaam' => 'required',
        'achternaam' => 'required',
        'geslacht' => 'required|in:man,vrouw',
        'geboortedatum' => 'required|date_format:d/m/Y',
        'adres' => 'required',
        'huisnummer' => 'required',
        'postcode' => 'required',
        'email' => 'required|email',
        'telefoonnummer' => 'required',
    ];

    public function getZwembadStringAttribute()
    {
        return sprintf("%s, %s, %s", $this->zwembad['type'], $this->zwembad['bad'], $this->zwembad['dag']);
    }

    public function beforeValidate()
    {
        Validator::extend('notInvalid', function ($attr, $val, $params) {
            return $val['type'] !== 'invalid'
                && array_key_exists('bad', $val)
                && array_key_exists('dag', $val);
        }, 'Selecteer waar u wilt zwemmen');
    }

    public function beforeSave()
    {
        unset($this->algemene_voorwaarden);
        $this->geboortedatum = \DateTime::createFromFormat('d/m/Y', $this->geboortedatum)->format('Y-m-d H:i:s');
        $zwembadReference = json_decode(InschrijfSettings::get('zwembaden'), true);
        $oldZwembad = $this->zwembad;
        $this->zwembad = [
            'type' => $zwembadReference['zwembaden'][$oldZwembad['type']]['name'],
            'bad' => $zwembadReference['zwembaden'][$oldZwembad['type']]['fields'][$oldZwembad['bad']]['name'],
            'dag' => $zwembadReference['zwembaden'][$oldZwembad['type']]['fields'][$oldZwembad['bad']]['fields'][$oldZwembad['dag']]['name']
        ];
    }

    public function afterCreate()
    {
        // If everything is fine - send an email
        \Mail::send('pvaass.inschrijven::emails.message',
            [
                'zwembad' => implode(", " , $this->zwembad),
                'naam' => $this->voornaam . ' ' . $this->achternaam,
                'geslacht' => $this->geslacht,
                'geboortedatum' => \DateTime::createFromFormat('Y-m-d H:i:s', $this->geboortedatum)->format('d/m/Y'),
                'adres' => $this->adres . ' ' . $this->huisnummer,
                'plaats' => $this->postcode . ' ' . $this->plaatsnaam,
                'email' => $this->email,
                'telefoon' => $this->telefoonnummer,
                'diplomas' => $this->zwemdiplomas,
                'vorige_ver' => $this->vorige_vereninging,
                'ziektes' => $this->ziektes,
                'opmerkingen' => $this->opmerkingen,
                'link' => '/backend/pvaass/inschrijven/inschrijvingen/preview/' . $this->id
            ],
            function (Message $message) {
                $message
                    ->to(InschrijfSettings::get('email'))
                    ->subject('Nieuwe inschrijving van CWP.nu - ' . $this->voornaam . ' ' . $this->achternaam);
            }
        );
    }
}