<?php namespace pvaass\GitContent;

use Cms\Classes\Content;
use Cms\Classes\Layout;
use Cms\Classes\Page;
use Cms\Classes\Partial;
use Doctrine\Common\Util\Debug;
use Symfony\Component\Process\Process;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    protected function addThemeListener($name, $class, callable $function){
        \Event::listen('halcyon.' . $name . ': ' . $class, $function);
    }

    const CMS_SAVED_EVENT = 'saved';
    public function boot() {
//        $process = new Process('git add themes');

        $callable = function($event) {
            $process = new Process('git add themes && git commit -am "HOOK: Auto saved theme"');
            $process->run();
        };

        $this->addThemeListener(static::CMS_SAVED_EVENT, Content::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Layout::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Page::class, $callable);
        $this->addThemeListener(static::CMS_SAVED_EVENT, Partial::class, $callable);

        Content::extend(function(Content $model) {
           $model->bindEvent('model.saved', function($attribute, $value) {
              die('waowowowow');
           });
        });
//        $process = new Process('whoami');
//        $process->run();
//        die($process->getOutput());
    }
}