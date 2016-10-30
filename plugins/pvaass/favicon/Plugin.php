<?php namespace Pvaass\Favicon;

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
            'name'        => 'favicon',
            'description' => 'No description provided yet...',
            'author'      => 'pvaass',
            'icon'        => 'icon-leaf'
        ];
    }
}
