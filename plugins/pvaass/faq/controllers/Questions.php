<?php namespace pvaass\Faq\Controllers;

use BackendMenu;

class Questions extends \Backend\Classes\Controller
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

        BackendMenu::setContext('pvaass.Faq', 'faq', 'all_questions');
    }

    public function index()
    {
        $this->asExtension('ListController')->index();
    }

    public function create()
    {
        BackendMenu::setContextSideMenu('new_question');

        return $this->asExtension('FormController')->create();
    }

    public function update($recordId = null, $context = null)
    {
        BackendMenu::setContextSideMenu('new_question');
        return $this->asExtension('FormController')->update($recordId, $context);
    }
}