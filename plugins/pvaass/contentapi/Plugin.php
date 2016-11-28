<?php namespace Pvaass\ContentApi;

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
            'name'        => 'Content Api',
            'description' => 'Exposes API endpoints to output CMS data',
            'author'      => 'pvaass',
            'icon'        => 'icon-leaf'
        ];
    }
}
