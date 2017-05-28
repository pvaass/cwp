<?php namespace pvaass\Inschrijven\FormWidgets;


use Backend\Classes\FormWidgetBase;
use pvaass\Inschrijven\Models\InschrijfSettings;

class BetterCheckbox extends FormWidgetBase
{

    public $formJson = "";

    /**
     * Returns information about this component, including name and description.
     */
    public function widgetDetails()
    {
        return [
            'name' => 'Better checkbox',
            'description' => 'Better checkbox'
        ];
    }

    public function render()
    {
        $this->formField->type = 'checkbox';
        $this->vars['field'] = $this->formField;
        return $this->makePartial('bettercheckbox');
    }
}