<?php namespace pvaass\Inschrijven\Models;

use Model;

class InschrijfSettings extends Model
{
    public $implement = [
        'System.Behaviors.SettingsModel'
    ];

    public $settingsCode = 'pvaass_inschrijven_formulier';

    public $settingsFields = 'fields.yaml';
}