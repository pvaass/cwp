<?php namespace pvaass\InfiniteModelNesting;

use Cms\Classes\CmsObject;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    public function pluginDetails()
    {
        return [
            'name' => 'Infinite Model Nesting',
            'description' => 'Allows infinite directory nesting of Halcyon models'
        ];
    }

    public function boot() {
        CmsObject::extend(function(CmsObject $model) {
            $r = new \ReflectionProperty(get_class($model), 'maxNesting');
            $r->setAccessible(true);
            $r->setValue($model, null);
        });
    }
}