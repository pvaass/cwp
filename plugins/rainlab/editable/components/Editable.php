<?php namespace RainLab\Editable\Components;

use App;
use File;
use BackendAuth;
use Cms\Classes\Content;
use Cms\Classes\ComponentBase;
use Model;

class Editable extends ComponentBase
{
    public $content;
    public $isEditor;
    public $file;
    public $fileMode;

    public function componentDetails()
    {
        return [
            'name' => 'rainlab.editable::lang.component_editable.name',
            'description' => 'rainlab.editable::lang.component_editable.description',
        ];
    }

    public function defineProperties()
    {
        return [
            'file' => [
                'title' => 'rainlab.editable::lang.component_editable.property_file.title',
                'description' => 'rainlab.editable::lang.component_editable.property_file.description',
                'default' => '',
                'type' => 'dropdown',
            ],
            'tag' => [
                'title' => 'Tag to use for editable element',
                'description' => 'See title',
                'default' => 'div',
                'type' => 'text'
            ],
            'class' => [
                'title' => 'Class',
                'description' => 'Class',
                'default' => '',
                'type' => 'text'
            ],
            'extras' => [
                'title' => 'Extras',
                'description' => '',
                'default' => '{}',
                'type' => 'text'
            ]
        ];
    }

    public function getFileOptions()
    {
        return Content::sortBy('baseFileName')->lists('baseFileName', 'fileName');
    }

    public function onRun()
    {
        $this->isEditor = $this->checkEditor();

        if ($this->isEditor) {
            $this->addCss('assets/vendor/redactor/redactor.css');
            $this->addJs('assets/vendor/redactor/redactor.js');

            $this->addCss('assets/css/editable.css');
            $this->addJs('assets/js/editable.js');
        }
    }

    public function onRender()
    {
        $this->file = $this->property('file');
        $this->fileMode = File::extension($this->property('file'));

        /*
         * Compatability with RainLab.Translate
         */
        if (class_exists('\RainLab\Translate\Classes\Translator')){
            $locale = \RainLab\Translate\Classes\Translator::instance()->getLocale();
            $fileName = substr_replace($this->file, '.'.$locale, strrpos($this->file, '.'), 0);
            if (($content = Content::loadCached($this->page->controller->getTheme(), $fileName)) !== null)
                $this->file = $fileName;
        }

        $this->page['tag'] = $this->property('tag');
        $this->page['class'] = $this->property('class');
        $this->page['extras'] = json_decode($this->property('extras'), true);
        $this->page['isEditor'] = $this->isEditor;

        $this->content = $this->renderContent($this->file);
    }

    public function onSave()
    {
        if (!$this->checkEditor())
            return;

        $fileName = post('file');
        $template = Content::load($this->getTheme(), $fileName);
        $template->fill(['markup' => post('content')]);
        $template->save();
    }

    public function checkEditor()
    {
        $backendUser = BackendAuth::getUser();
        return $backendUser && $backendUser->hasAccess('cms.manage_content');
    }

}