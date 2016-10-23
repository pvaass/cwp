<?php namespace pvaass\BlogBlocks;

use Backend\Widgets\Form;
use Event;
use October\Rain\Database\Model;
use pvaass\BlogBlocks\Models\BlogBlock;
use RainLab\Blog\Controllers\Posts;
use RainLab\Blog\Models\Post;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use System\Classes\PluginBase;

/**
 * Editable Plugin Information File
 */
class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

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
            'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload' => [
                'label' => 'File upload',
                'code' => 'validatablefileupload'
            ]
        ];
    }

    public function registerComponents()
    {
        return [
            'pvaass\BlogBlocks\Components\BlogBlock' => 'blogBlock'
        ];
    }

    protected function registerBlogListener()
    {
//        Posts::extendFormFields(function($form, $model, $context) {
//            $form->addFields(
//                [
//                    'blogblock[block_image_big]' => [
//                        'label' => 'Voorpagina (groot)',
//                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
//                        'mode' => 'image',
//                        'imageWidth' => 184,
//                        'imageHeight' => 100,
//                        'tab' => 'rainlab.blog::lang.post.tab_manage',
//                        'span' => 'inline-block',
//                        'cssClass' => 'blogblock-image-picker'
//                    ],
//                    'blogblock[block_image_small]' => [
//                        'label' => 'Voorpagina (klein)',
//                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
//                        'mode' => 'image',
//                        'imageWidth' => 100,
//                        'imageHeight' => 87,
//                        'tab' => 'rainlab.blog::lang.post.tab_manage',
//                        'span' => 'inline-block',
//                        'cssClass' => 'blogblock-image-picker'
//                    ],
//                    'blogblock[header_image]' => [
//                        'label' => 'Header',
//                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
//                        'mode' => 'image',
//                        'imageWidth' => 652,
//                        'imageHeight' => 87,
//                        'tab' => 'rainlab.blog::lang.post.tab_manage',
//                        'span' => 'inline-block',
//                        'cssClass' => 'blogblock-image-picker'
//                    ]
//                ],
//                'secondary'
//            );
//        });
        // Extend all backend form usage
        Event::listen('backend.form.extendFields', function (Form $widget) {
            if (!$widget->getController() instanceof Posts || !$widget->model instanceof Post) {
                return;
            }
            if($widget->getContext() != 'update') return;
//
//            $p = new Post();
//            var_dump($p->hasOne);
//            die();
            $widget->getController()->addCss('/plugins/pvaass/blogblocks/assets/css/main.css');

            $widget->addFields(
                [
                    'blogblock[block_image_big]' => [
                        'label' => 'Voorpagina (groot)',
                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
                        'mode' => 'image',
                        'imageWidth' => 184,
                        'imageHeight' => 100,
                        'tab' => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ],
                    'blogblock[block_image_small]' => [
                        'label' => 'Voorpagina (klein)',
                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
                        'mode' => 'image',
                        'imageWidth' => 100,
                        'imageHeight' => 87,
                        'tab' => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ],
                    'blogblock[header_image]' => [
                        'label' => 'Header',
                        'type' => 'pvaass\BlogBlocks\FormWidgets\ValidatableFileUpload',
                        'mode' => 'image',
                        'imageWidth' => 652,
                        'imageHeight' => 87,
                        'tab' => 'rainlab.blog::lang.post.tab_manage',
                        'span' => 'inline-block',
                        'cssClass' => 'blogblock-image-picker'
                    ]
                ],
                'secondary'
            );

        });
    }

    protected function registerFileUploadListener() {
        // Extend all backend form usage
        Event::listen('pvaass.blogblocks.file.beforeUpload', function ($formField, UploadedFile $file) {
            if ($formField === 'blogblock[block_image_big]') {
                $imageSize = getimagesize($file->getRealPath());
                if ($imageSize[0] !== 555 || $imageSize[1] !== 303) {
                    throw new \Exception("Afbeelding moet 555x303 zijn");
                }

            }
            if ($formField === 'blogblock[block_image_small]') {
                $imageSize = getimagesize($file->getRealPath());
                if ($imageSize[0] !== 263 || $imageSize[1] !== 301) {
                    throw new \Exception("Afbeelding moet 263x301 zijn");
                }
            }

            if ($formField === 'blogblock[header_image]') {
                $imageSize = getimagesize($file->getRealPath());
                if ($imageSize[0] < 1350 || $imageSize[1] < 180) {
                    throw new \Exception("Afbeelding moet minstens 1350x180 zijn");
                }
            }
        });
    }

    public function boot()
    {
        // Local event hook that affects all users
        Post::extend(function (Model $model) {
            $model->hasOne['blogblock'] = ['pvaass\BlogBlocks\Models\BlogBlock', 'key' => 'post_id'];
            $model->bindEvent('model.afterSave', function() use ($model) {
               if(!$model->blogblock) {
                   BlogBlock::create([
                       'post_id' => $model->id
                   ]);
               }
            });
        });

        $this->registerBlogListener();
        $this->registerFileUploadListener();
    }
}