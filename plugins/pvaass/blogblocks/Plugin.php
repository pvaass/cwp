<?php namespace pvaass\BlogBlocks;

use App;
use Backend\Classes\WidgetBase;
use Backend\Widgets\Form;
use Cms\Classes\Content;
use Config;
use Event;
use October\Rain\Database\Model;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
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
        // Local event hook that affects all users
        Post::extend(function(Model $model) {
            $model->hasOne['blogblock'] = ['pvaass\BlogBlocks\Models\BlogBlock'];
        });
        // Extend all backend form usage
        Event::listen('backend.form.extendFields', function(Form $widget) {

            if(!$widget->getController() instanceof Posts) {
                return;
            }
            if(!$widget->model instanceof Post) {
                return;
            }


            $widget->addFields(
                [
                    'blogblock[block_image_big]' => [
                        'label'   => 'Voorpagina (groot)',
                        'type' => 'fileupload',
                        'mode' => 'image',
                        'imageWidth' => 200,
                        'imageHeight' => 200,
                        'tab'     => 'rainlab.blog::lang.post.tab_manage'
                    ]
                ],
                'secondary'
            );

            var_dump(get_class($widget->model));

        });
    }
}