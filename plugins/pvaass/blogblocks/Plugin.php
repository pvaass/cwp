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

            $widget->getController()->addCss('/plugins/pvaass/blogblocks/assets/css/main.css');

            $widget->addFields(
                [
                    'blogblock[block_image_big]' => [
                        'label'   => 'Voorpagina (groot)',
                        'type' => 'fileupload',
                        'mode' => 'image',
                        'imageWidth' => 184,
                        'imageHeight' => 100,
                        'tab'     => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ],
                    'blogblock[block_image_small]' => [
                        'label'   => 'Voorpagina (klein)',
                        'type' => 'fileupload',
                        'mode' => 'image',
                        'imageWidth' => 100,
                        'imageHeight' => 87,
                        'tab'     => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ]
                ],
                'secondary'
            );

        });
    }
}