<?php namespace pvaass\Inschrijven;

use App;
use Backend;
use Backend\Classes\NavigationManager;
use Cms\Classes\Content;
use Config;
use Event;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use System\Controllers\Settings;

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

    public function boot()
    {
        Event::listen('backend.page.beforeDisplay', function( $manager = null) {
            if($manager instanceof Settings) {
                $this->addPermissionsToSEOExt();
            }
        });
    }

    public function addPermissionsToSEOExt() {
        foreach(\BackendAuth::getUser()->groups as $group) {
            if($group->code === 'owners') {
                return;
            }
        }
        $items = SettingsManager::instance()->listItems();
        $reflection = new \ReflectionProperty(SettingsManager::instance(), 'items');
        $reflection->setAccessible(true);
        foreach($items[SettingsManager::CATEGORY_MYSETTINGS] as $key => &$value ) {
            if($value->label === 'anandpatel.seoextension::lang.settings.label') {
                unset($items[SettingsManager::CATEGORY_MYSETTINGS][$key]);
            }
        }
        $reflection->setValue(SettingsManager::instance(), $items);
    }
}