<?php namespace pvaass\Inschrijven\Models;

use Model;

class Inschrijving extends Model
{
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

    public function getZwembadStringAttribute()
    {
        return sprintf("%s, %s, %s", $this->zwembad['type'], $this->zwembad['bad'], $this->zwembad['dag']);
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