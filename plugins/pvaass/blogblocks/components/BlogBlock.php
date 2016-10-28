<?php namespace pvaass\BlogBlocks\Components;


use Backend\FormWidgets\FileUpload;
use Cms\Classes\ComponentBase;
use Model;
use RainLab\Blog\Models\Category;
use RainLab\Blog\Models\Post;

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

    public function defineProperties()
    {
        return [
            'size' => [
                'title' => 'Size of blogblock',
                'description' => 'large/small',
                'type' => 'string'
            ],
            'offset' => [
                'title' => 'Offset of post',
                'description' => 'Offset of post',
                'type' => 'integer'
            ]
        ];
    }

    public function onRender()
    {

        $frontPage = Category::where('id', 2)->first();
        if(!$frontPage) {
            $this->page['render'] = false;
            return false;
        }
        $post = $frontPage->posts()
            ->where('published', 1)
            ->orderBy('published_at')
            ->skip($this->property('offset', 0))
            ->first();


        if (!$this->isValid($post)) {
            $this->page['render'] = false;
            return;
        }

        $this->page['render'] = true;
        $this->page['title'] = $post->title;
        $this->page['summary'] = $post->summary;
        $this->page['entry_date'] = $post->updated_at;
        $this->page['slug'] = $post->slug;

        $size = $this->property('size', 'small');
        $this->page['big'] = $size === 'large';

        $this->page['image'] = $size === 'large' ?
            $post->blogblock->block_image_big->getPath()
            : $post->blogblock->block_image_small->getPath();

    }

    protected function isValid(Post $post)
    {
        return !empty($post) && is_object($post->blogblock)
        && is_object($post->blogblock->block_image_big)
        && is_object($post->blogblock->block_image_small);
    }

}