<?php namespace pvaass\Inschrijven;

use App;
use Backend;
use Backend\Classes\NavigationManager;
use Cms\Classes\Content;
use Config;
use Event;
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
            'name' => 'Inschrijfformulier',
            'description' => 'Voor CWP',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\Inschrijven\Components\Formulier' => 'inschrijfFormulier'
        ];
    }

    public function registerFormWidgets()
    {
        return [
            'pvaass\Inschrijven\FormWidgets\ZwembadPicker' => [
                'label' => 'Zwembad Picker',
                'code'  => 'zwembadpicker'
            ],
            'Backend\FormWidgets\DatePicker' => [
                'label' => 'Date picker',
                'code'  => 'datepicker'
            ]
        ];
    }


    public function registerNavigation()
    {
        return [
            'formulier' => [
                'label' => 'Inschrijvingen',
                'url' => Backend::url('pvaass/inschrijven/inschrijvingen'),
                'icon' => 'icon-pencil',
                'permissions' => ['pvaass.inschrijven.*'],
                'order' => 30,
                'sideMenu' => [
                    'new_inschrijving' => [
                        'label'       => 'Nieuwe inschrijving',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('pvaass/inschrijven/inschrijvingen/create'),
                        'permissions' => ['pvaass.inschrijven.create'],
                    ]
                ]
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Inschrijfformulier',
                'description' => 'Wijzig hier het inschrijfformulier',
                'category'    => 'Inschrijven',
                'icon'        => 'icon-pencil',
                'class'       => 'pvaass\Inschrijven\Models\InschrijfSettings',
                'order'       => 1
            ]
        ];
    }
}