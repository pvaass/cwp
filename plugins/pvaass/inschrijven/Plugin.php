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

    public function registerPermissions()
    {
        return [
            'pvaass.inschrijven.inschrijving.view' => [
                'label' => 'Inschrijvingen inzien',
                'tab' => 'Inschrijvingen'
            ],
            'pvaass.inschrijven.settings.edit' => [
                'label' => 'Inschrijfformulier aanpassen',
                'tab' => 'Inschrijvingen'
            ]
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
                'permissions' => ['pvaass.inschrijven.inschrijving.view'],
                'order' => 30,
                'sideMenu' => [
                    'all_inschrijving' => [
                        'label'       => 'Alle inschrijvingen',
                        'icon'        => 'icon-list',
                        'url'         => Backend::url('pvaass/inschrijven/inschrijvingen'),
                        'permissions' => ['pvaass.inschrijven.inschrijving.view'],
                    ],
                    'new_inschrijving' => [
                        'label'       => 'Nieuwe inschrijving',
                        'icon'        => 'icon-plus',
                        'url'         => Backend::url('pvaass/inschrijven/inschrijvingen/create'),
                        'permissions' => ['pvaass.inschrijven.*'],
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
                'order'       => 1,
                'permissions' => ['pvaass.inschrijven.settings.edit'],
            ]
        ];
    }

    public function boot()
    {
        Event::listen('backend.menu.extendItems', function(NavigationManager $manager) {
            $settingsItem = $manager->listMainMenuItems()['OCTOBER.SYSTEM.SYSTEM'];
            $settingsItem->iconSvg = null;
            $manager->removeMainMenuItem('October.System', 'system');
            $manager->addMainMenuItem('October.System', 'system', json_decode(json_encode($settingsItem), true));

            $blogItem = $manager->listMainMenuItems()['RAINLAB.BLOG.BLOG'];

            $blogItem->label = 'Nieuws';
            $blogItem->iconSvg = null;
            $blogItem->icon = 'icon-comments';
            $manager->removeMainMenuItem('RainLab.Blog', 'blog');

            $manager->addMainMenuItem('RainLab.Blog', 'blog', json_decode(json_encode($blogItem), true));
        });
    }
}