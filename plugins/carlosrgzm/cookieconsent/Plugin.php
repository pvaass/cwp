<?php namespace Carlosrgzm\CookieConsent;

use Backend;
use System\Classes\PluginBase;

/**
 * CookieConsent Plugin Information File
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
            'name' => 'carlosrgzm.cookieconsent::lang.strings.plugin_name',
            'description' => 'carlosrgzm.cookieconsent::lang.strings.plugin_desc',
            'author' => 'Carlos Rodríguez',
            'icon' => 'icon-leaf',
            'homepage' => 'https://github.com/carlosrgzm/CookieConsent'
        ];
    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {
        return [
            'Carlosrgzm\CookieConsent\Components\CookieConsent' => 'cookieConsent',
        ];
    }
}
