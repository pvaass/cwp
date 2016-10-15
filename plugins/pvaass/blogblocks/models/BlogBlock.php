<?php namespace pvaass\BlogBlocks\Models;


use League\Flysystem\Exception;
use October\Rain\Database\Model;
use Validator;

class BlogBlock extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pvaass_blogblocks_blogblock';
    protected $jsonable = ['zwembad'];
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    public $attachOne = [
        'block_image_big' => ['System\Models\File', 'order' => 'sort_order'],
        'block_image_small' => ['System\Models\File', 'order' => 'sort_order'],
        'header_image' => ['System\Models\File', 'order' => 'sort_order'],
    ];
}