<?php namespace pvaass\Azure;

use Cms\Classes\Content;
use Cms\Classes\Layout;
use Cms\Classes\Page;
use Cms\Classes\Partial;
use League\Flysystem\Exception;
use Log;
use Symfony\Component\Process\Process;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Azure Connectors',
            'description' => ''
        ];
    }
}