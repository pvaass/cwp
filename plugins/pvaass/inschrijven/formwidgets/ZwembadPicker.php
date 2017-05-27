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
        $compat = json_decode($this->formField->value, true);

        if(is_array($compat)) {
            return $this->makePartial('zwembadpicker_compat', [
                'field' => $this->formField,
                'value' => $compat['type'] . ", " . $compat['bad'] . ", " . $compat['dag']
            ]);
        }
        if(!empty($this->formField->value)) {
            return $this->makePartial('zwembadpicker_compat', [
                'field' => $this->formField,
                'value' => $this->formField->value
            ]);
        }

        return $this->makePartial('zwembadpicker');
    }
}