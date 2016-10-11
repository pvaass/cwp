<?php namespace pvaass\BlogBlocks;

use App;
use Backend\Classes\WidgetBase;
use Backend\Widgets\Form;
use Cms\Classes\Content;
use Config;
use Event;
use League\Flysystem\Exception;
use October\Rain\Database\Model;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

    public function registerFormWidgets()
    {
        return [
            'vaass\BlogBlocks\FormWidgets\ValidatableFileUpload' => [
                'label' => 'File upload',
                'code'  => 'validatablefileupload'
            ]
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
                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
                        'mode' => 'image',
                        'imageWidth' => 184,
                        'imageHeight' => 100,
                        'tab'     => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ],
                    'blogblock[block_image_small]' => [
                        'label'   => 'Voorpagina (klein)',
                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
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

        // Extend all backend form usage
        Event::listen('pvaass.blogblocks.file.beforeUpload', function($formField, UploadedFile $file) {
            if($formField === 'blogblock[block_image_big]') {
                $imageSize = getimagesize($file->getRealPath());
                if($imageSize[0] !== 555 || $imageSize[1] !== 303) {
                    throw new \Exception("Afbeelding moet 555x303 zijn");
                }

            }
            if($formField === 'blogblock[block_image_small]') {
                $imageSize = getimagesize($file->getRealPath());
                if($imageSize[0] !== 263 || $imageSize[1] !== 301) {
                    throw new \Exception("Afbeelding moet 263x301 zijn");
                }
            }
        });
    }
}