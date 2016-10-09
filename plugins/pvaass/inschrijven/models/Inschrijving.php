<?php namespace pvaass\Inschrijven\Models;

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
        'zwembad' => 'required|notInvalid',
        'voornaam' => 'required',
        'achternaam' => 'required',
        'geslacht' => 'required|in:man,vrouw',
        'geboortedatum' => 'required|date|date_format:d/m/Y',
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

    public function beforeValidate() {
        Validator::extend('notInvalid', function($attr, $val, $params) {
            return $val['type'] !== 'invalid'
            && array_key_exists('bad', $val)
            && array_key_exists('dag', $val);
        }, 'Selecteer waar u wilt zwemmen');
    }

    public function beforeSave()
    {
        $zwembadReference = json_decode(InschrijfSettings::get('zwembaden'), true);
        $oldZwembad = $this->zwembad;
        $this->zwembad = [
            'type' => $zwembadReference['zwembaden'][$oldZwembad['type']]['name'],
            'bad' => $zwembadReference['zwembaden'][$oldZwembad['type']]['fields'][$oldZwembad['bad']]['name'],
            'dag' => $zwembadReference['zwembaden'][$oldZwembad['type']]['fields'][$oldZwembad['bad']]['fields'][$oldZwembad['dag']]['name']
        ];
    }
}