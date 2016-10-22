<?php namespace pvaass\Faq;

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
            'name' => 'F.A.Q.',
            'description' => 'Frequently Asked Questions',
            'author' => 'pvaass',
            'icon' => 'icon-leaf'
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\Faq\Components\Faq' => 'faq'
        ];
    }
}