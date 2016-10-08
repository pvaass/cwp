<?php namespace pvaass\BlogBlocks;

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
            'name' => 'BlogBlocks',
            'description' => 'Extends Blog plugin',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\BlogBlocks\Components\BlogBlock' => 'blogBlock'
        ];
    }


    public function boot()
    {
    }
}