<?php namespace pvaass\BlogBlocks\Models;


use October\Rain\Database\Model;

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


    public $attachMany = [
        'block_image_big' => ['System\Models\File', 'order' => 'sort_order'],
    ];
}