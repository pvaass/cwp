<?php namespace pvaass\Inschrijven\FormWidgets;


use Backend\Classes\FormWidgetBase;
use pvaass\Inschrijven\Models\InschrijfSettings;

class ZwembadPicker extends FormWidgetBase
{

    public $formJson = "";

    /**
     * Returns information about this component, including name and description.
     */
    public function widgetDetails()
    {
        return [
            'name' => 'Inschrijf formulier',
            'description' => 'Het CWP inschrijf formulier'
        ];
    }

    public function render()
    {
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['zwembaden'] = InschrijfSettings::get('zwembaden');
        return $this->makePartial('zwembadpicker');
    }
}