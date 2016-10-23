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

    protected $fillable = ['post_id'];

    public $attachOne = [
        'block_image_big' => ['System\Models\File'],
        'block_image_small' => ['System\Models\File'],
        'header_image' => ['System\Models\File'],
    ];
}