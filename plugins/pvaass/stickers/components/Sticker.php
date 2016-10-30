<?php namespace pvaass\Stickers\Components;


use Cms\Classes\ComponentBase;

class Sticker extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'Sticker',
            'description' => 'Het is een sticker!'
        ];
    }

    public function onRender()
    {
        $this->page['text'] = 'Korting met Ooievaarspas!';
        $this->page['link'] = 'https://google.com';
    }
}