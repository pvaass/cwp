<?php namespace Pvaass\AzureFileDriver;

use Pvaass\AzureFileDriver\Provider\AzureServiceProvider;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Azure Filesystem Driver',
            'description' => 'Driver for Microsoft Azure Blob Storage',
            'author' => 'pvaass',
            'icon' => 'icon-key'
        ];
    }

    public function boot() {
        \App::register(AzureServiceProvider::class);
    }
}
