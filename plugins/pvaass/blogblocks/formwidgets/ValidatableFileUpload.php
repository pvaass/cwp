<?php namespace pvaass\BlogBlocks\FormWidgets;


use Event;
use Input;
use Request;
use Response;

class ValidatableFileUpload extends \Backend\FormWidgets\FileUpload
{

    protected $viewPath = '/modules/backend/formwidgets/fileupload/partials';

    public function getViewPath($fileName, $viewPath = null)
    {
        return '/var/www/html/modules/backend/formwidgets/fileupload/partials/' . $fileName;
    }

    /**
     * {@inheritDoc}
     */
    protected function loadAssets()
    {
        $this->addCss('/modules/backend/formwidgets/fileupload/css/fileupload.css', 'core');
        $this->addJs('/modules/backend/formwidgets/fileupload/js/fileupload.js', 'core');
    }

    /**
     *
     */
    protected function checkUploadPostback()
    {
        if (!($uniqueId = Request::header('X-OCTOBER-FILEUPLOAD')) || $uniqueId != $this->getId()) {
            return;
        }
        try {
            $uploadedFile = Input::file('file_data');
            Event::fire('pvaass.blogblocks.file.beforeUpload', [$this->valueFrom, $uploadedFile]);
        } catch (\Exception $e) {
            Response::json([$e->getMessage()], 400)->send();
            exit;
        }
        finally {
            return parent::checkUploadPostback();
        }
    }


}