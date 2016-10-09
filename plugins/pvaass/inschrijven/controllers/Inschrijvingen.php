<?php namespace pvaass\Inschrijven\Controllers;


use BackendMenu;

class Inschrijvingen extends \Backend\Classes\Controller
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

        BackendMenu::setContext('pvaass.Inschrijven', 'formulier', 'posts');
    }


    public function index()
    {
        $this->asExtension('ListController')->index();
    }



    public function create()
    {
        BackendMenu::setContextSideMenu('new_inschrijving');

        $this->bodyClass = 'compact-container';

        return $this->asExtension('FormController')->create();
    }
}