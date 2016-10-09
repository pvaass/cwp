<?php namespace pvaass\Inschrijven\Components;


use Cms\Classes\ComponentBase;
use pvaass\Inschrijven\Controllers\Inschrijvingen;
use pvaass\Inschrijven\Models\Inschrijving;

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
        $this->addCss('/modules/backend/assets/css/controls.css', 'core');

        $this->addCss('/modules/system/assets/ui/storm.css?v1', 'core');

    }


    public function onRender()
    {
    }

    public function onSave()
    {
        return ['error' => Inschrijving::create(post('Inschrijving'))];
    }
}