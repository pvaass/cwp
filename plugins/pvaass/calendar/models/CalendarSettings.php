<?php namespace pvaass\Calendar\Models;

use Google_Client;
use Google_Service_Calendar;
use Model;

class CalendarSettings extends Model
{
    public $implement = [
        'System.Behaviors.SettingsModel'
    ];

    public $settingsCode = 'pvaass_calendar';

    public $settingsFields = 'fields.yaml';


    public function beforeSave()
    {
        $original = json_decode($this->original['value']);
        $current = json_decode($this->attributes['value']);

        if(json_decode($current->token) === null) {
            $client = new Google_Client();
            $client->setApplicationName($this->application_name);

            $client->setScopes(implode(' ', array(
                Google_Service_Calendar::CALENDAR_READONLY)
            ));

            $client->setAuthConfig(json_decode($original->config, true));
            $client->setAccessType('offline');

            $accessToken = $client->fetchAccessTokenWithAuthCode($current->token);

            $current->token = json_encode($accessToken);

            $this->attributes['value'] = json_encode($current);
        }
    }
}