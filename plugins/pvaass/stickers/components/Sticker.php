<?php namespace pvaass\Stickers\Components;

use pvaass\Stickers\Models\Sticker as StickerModel;
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
        $sticker = StickerModel::where('active', true)->first();

        if(empty($sticker)) {
            return false;
        }

        $this->page['color'] = $sticker->color;
        $this->page['text'] = $sticker->text;
        $this->page['link'] = $sticker->url;
    }
}