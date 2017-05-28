<?php namespace pvaass\Inschrijven\Components;


use Cms\Classes\ComponentBase;
use October\Rain\Exception\ValidationException;
use pvaass\Inschrijven\Controllers\Inschrijvingen;
use pvaass\Inschrijven\Models\InschrijfSettings;
use pvaass\Inschrijven\Models\Inschrijving;
use Redirect;
use Response;

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
    }


    public function onRender()
    {
        $this->addJs('assets/javascript/zwembaden.js');

        if ($this->controller->getRouter()->getUrl() === "inschrijven/kinderen")
            return $this->renderPartial("inschrijfFormulier::zwembad-picker");
    }

    public function onSave()
    {
        Inschrijving::create(post('Inschrijving'));
        return Redirect::to('inschrijven/success');
    }

    public function onTypeSubmit($back = true)
    {
        return [
            "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::zwembad-picker",
                [
                    'zwembaden' => json_decode(InschrijfSettings::get('zwembaden'), true),
                    'zwembad_type' => \Request::get('type')
                ]
            ),
            '.guide' => $this->renderPartial("inschrijfFormulier::guide", [
                'selected' => 2
            ])
        ];
    }

    public function onZwembadSubmit($back = false) {
        $zwembad = \Request::get('zwembad-info');

        if(empty($zwembad)) {
            throw new ValidationException(['name' => 'Je moet eerst een zwembad en een tijd selecteren.']);
        }

        // Build a back-end form with the context of ‘frontend’
        $formController = new Inschrijvingen();
        $formController->create('frontend');

        return [
            "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::form", [
                'form' => $formController,
                'zwembad_type' => \Request::get('type'),
                'zwembad_all' => \Request::get('zwembad-info')
            ]),
            '.guide' => $this->guide(3)
        ];
    }


    public function onBack() {
        $back = \Request::get('back');

        if($back == 1) {
            return [
                "#inschrijven-content" => $this->renderPartial("inschrijfFormulier::type"),
                '.guide' => $this->guide(1)
            ];
        }

        if($back == 2) {
            return $this->onTypeSubmit(true);
        }
        if($back == 3) {
            return $this->onZwembadSubmit(true);
        }
    }

    private function guide($selected) {
        return $this->renderPartial("inschrijfFormulier::guide", [
            'selected' => $selected
        ]);
    }
}