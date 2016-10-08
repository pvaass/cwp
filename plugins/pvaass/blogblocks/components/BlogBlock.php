<?php namespace pvaass\BlogBlocks\Components;


use Cms\Classes\ComponentBase;

class BlogBlock extends ComponentBase
{

    /**
     * Returns information about this component, including name and description.
     */
    public function componentDetails()
    {
        return [
            'name' => 'BlogBlock',
            'description' => 'Does a thing'
        ];
    }


}