<?php namespace pvaass\Calendar;

use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Calendar',
            'description' => 'Google Calendar in October',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\Calendar\Components\Calendar' => 'calendar'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'pvaass\Calendar\FormWidgets\GoogleAuth' => [
                'label' => 'Google Authenticatie',
                'code'  => 'googleauth'
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Agenda authenticeren',
                'description' => 'Log in op je agenda via Google',
                'category'    => 'Agenda',
                'icon'        => 'icon-pencil',
                'class'       => 'pvaass\Calendar\Models\CalendarSettings',
                'order'       => 1,
                'permissions' => ['pvaass.calendar.settings.edit']
            ]
        ];
    }


    public function registerPermissions()
    {
        return [
            'pvaass.calendar.refresh' => [
                'label' => 'Agenda verversen',
                'tab' => 'Agenda'
            ],
            'pvaass.calendar.settings.edit' => [
                'label' => 'Agenda instellingen aanpassen',
                'tab' => 'Agenda'
            ]
        ];
    }

}