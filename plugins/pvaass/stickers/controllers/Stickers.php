<?php namespace pvaass\Stickers\Controllers;

use BackendMenu;

class Stickers extends \Backend\Classes\Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('pvaass.Stickers', 'stickers', 'all_stickers');
    }


    public function index()
    {
        $this->asExtension('ListController')->index();
    }


    public function create()
    {
        BackendMenu::setContextSideMenu('new_sticker');

        return $this->asExtension('FormController')->create();
    }

    public function update($recordId = null, $context = null)
    {
        BackendMenu::setContextSideMenu('new_sticker');
        return $this->asExtension('FormController')->update($recordId, $context);
    }

    public function listGetConfig($definition)
    {
        $config = parent::listGetConfig($definition);

        if (!$this->user->hasAccess('pvaass.stickers.update')) {
            $config->recordUrl = null;
        }

        return $config;
    }
}