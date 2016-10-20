<?php namespace pvaass\Calendar\FormWidgets;


use Backend\Classes\FormWidgetBase;
use Google_Client;
use Google_Service_Calendar;
use pvaass\Calendar\Models\CalendarSettings;

class GoogleAuth extends FormWidgetBase
{

    public $formJson = "";

    /**
     * Returns information about this component, including name and description.
     */
    public function widgetDetails()
    {
        return [
            'name' => 'Google Authentication',
            'description' => ''
        ];
    }

    public function render()
    {
        $token = CalendarSettings::get('token');
        if(!empty($token)) {
            return $this->makePartial('already_authenticated');
        }
        $requiredSettings = [
            'app' => CalendarSettings::get('application_name'),
            'config' => CalendarSettings::get('config')
        ];
        foreach($requiredSettings as $setting) {
            if(empty($setting)) {
                return $this->makePartial('need_more_settings');
            }
        }
        $client = new Google_Client();
        $client->setApplicationName($requiredSettings['app']);
        $client->setScopes(implode(' ', array(
                Google_Service_Calendar::CALENDAR_READONLY)
        ));
        $client->setAuthConfig(json_decode($requiredSettings['config'], true));
        $client->setAccessType('offline');

        return $this->makePartial('googleauth', ['link' => $client->createAuthUrl()]);
    }
}