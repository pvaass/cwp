<?php namespace pvaass\FixStupid;

use App;
use Cms\Classes\Content;
use Config;
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
            'name' => 'Fix stupid october shit',
            'description' => 'fuck you',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function boot()
    {
        var_dump('WADUP');
    }
}