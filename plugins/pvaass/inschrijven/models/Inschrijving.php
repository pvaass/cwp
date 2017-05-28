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

    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    protected $appends = ['zwembad_string', 'geboortedatum_string'];

    public $rules = [
        'algemene_voorwaarden' => 'required|accepted',
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
        $backwardsCompat = json_decode($this->zwembad, true);
        if(json_last_error() == JSON_ERROR_NONE && is_array($backwardsCompat)) {
            return sprintf("%s, %s, %s", $backwardsCompat['type'], $backwardsCompat['bad'], $backwardsCompat['dag']);
        }

        return $this->zwembad;
    }
    public function getGeboortedatumStringAttribute()
    {
        try {
            return \DateTime::createFromFormat('Y-m-d H:i:s', $this->geboortedatum)->format('d/m/Y');
        } catch (\Throwable $e) {}

        return $this->geboortedatum;
    }

    public function beforeSave()
    {
        $this->zwembad = \Request::get('zwembad');
        unset($this->algemene_voorwaarden);
        $this->geboortedatum = \DateTime::createFromFormat('d/m/Y', $this->geboortedatum)->format('Y-m-d H:i:s');
    }

    public function afterCreate()
    {
        // If everything is fine - send an email
        \Mail::send('pvaass.inschrijven::emails.message',
            [
                'zwembad' => $this->zwembad,
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