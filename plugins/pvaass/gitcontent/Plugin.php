<?php namespace pvaass\GitContent;

use Cms\Classes\Content;
use Cms\Classes\Layout;
use Cms\Classes\Page;
use Cms\Classes\Partial;
use League\Flysystem\Exception;
use Symfony\Component\Process\Process;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    const CMS_SAVED_EVENT = 'saved';

    public function pluginDetails()
    {
        return [
            'name' => 'Auto git commit',
            'description' => ''
        ];
    }


    protected function addThemeListener($name, $class, callable $function){
        \Event::listen('halcyon.' . $name . ': ' . $class, $function);
    }
    public function boot() {
        if(config('app.debug', false) === true) {
            return;
        }
        $callable = function($event) {
            $command = 'git add themes && git commit -m "HOOK: Auto saved theme" && git push origin HEAD';
            $process = new Process($command, null, ['HOME' => '/var/www']);
            $process->run();
        };

        $this->addThemeListener(static::CMS_SAVED_EVENT, Content::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Layout::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Page::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Partial::class, $callable);
    }
}