<?php namespace pvaass\Inschrijven\Components;


use Cms\Classes\ComponentBase;
use pvaass\Inschrijven\Controllers\Inschrijvingen;
use pvaass\Inschrijven\Models\Inschrijving;
use Redirect;

class Formulier extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Inschrijf formulier',
            'description' => 'Het CWP inschrijf formulier'
        ];
    }

    public function onRun()
    {
        // Build a back-end form with the context of ‘frontend’
        $formController = new Inschrijvingen();
        $formController->create('frontend');
        // Append the formController to the page
        $this->page['form'] = $formController;

        //$this->addCss('/modules/system/assets/ui/storm.css?v1', 'core');

    }


    public function onRender()
    {
    }

    public function onSave()
    {
        Inschrijving::create(post('Inschrijving'));
        return Redirect::to('inschrijven/success');
    }
}