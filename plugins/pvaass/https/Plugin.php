<?php namespace Pvaass\Https;

use App;
use Backend;
use System\Classes\PluginBase;

/**
 * https Plugin Information File
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
            'name'        => 'https',
            'description' => 'No description provided yet...',
            'author'      => 'pvaass',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        App::before(function($request)
        {
            // Set all urls schemas equals to "https://" if HTTP_X_FORWARDED_PROTO is passed by nginx
            if (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") {
                $this->app['url']->forceSchema("https");
            }
        });
    }
}
