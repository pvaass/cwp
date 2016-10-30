<?php namespace pvaass\Stickers\Models;

use DB;
use Model;

class Sticker extends Model
{
    use \October\Rain\Database\Traits\Validation;
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pvaass_stickers_stickers';
    /**
     * @var array Guarded fields
     */
    protected $guarded = [];

    public $rules = [
        'text' => 'required',
        'url' => 'required'
    ];

    public function beforeSave()
    {
        if($this->active) {
            DB::table($this->table)->update(['active' => false]);
        }
    }
}