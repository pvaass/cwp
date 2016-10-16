<?php namespace pvaass\Inschrijven\Controllers;


use BackendMenu;
use Doctrine\Common\Util\Debug;

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

    public function preview($recordId = null, $context = null)
    {
        BackendMenu::setContextSideMenu('new_inschrijving');
        $this->bodyClass = 'compact-container';
        $return = $this->asExtension('FormController')->preview($recordId, $context);
        return $return;
    }

    public function getZwembadValues() {

        Debug::dump($this->formWidgets);
    }
}