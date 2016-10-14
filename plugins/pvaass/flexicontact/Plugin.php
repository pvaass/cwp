<?php

namespace pvaass\FlexiContact;

use System\Classes\PluginBase;

class Plugin extends PluginBase{

    /**
     * Returns information about this plugin, including plugin name and developer name.
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Flexi Contact',
            'description' => 'pvaass.flexicontact::lang.strings.plugin_desc',
            'author'      => 'Lamin Sanneh',
            'icon'        => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\FlexiContact\Components\ContactForm' => 'contactForm',
        ];
    }

    public function registerPermissions()
    {
        return [
            'pvaass.flexicontact.access_settings' => [
                'tab'   => 'pvaass.flexicontact::lang.permissions.tab',
                'label' => 'pvaass.flexicontact::lang.permissions.settings'
            ],
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'pvaass.flexicontact::lang.strings.settings_label',
                'description' => 'pvaass.flexicontact::lang.strings.settings_desc',
                'category'    => 'Marketing',
                'icon'        => 'icon-cog',
                'class'       => 'pvaass\FlexiContact\Models\Settings',
                'permissions' => ['pvaass.flexicontact.access_settings'],
                'order'       => 100
            ]
        ];
    }

    public function registerMailTemplates()
    {
        return [
            'pvaass.flexicontact::emails.message' => 'pvaass.flexicontact::lang.strings.email_desc',
        ];
    }
}
