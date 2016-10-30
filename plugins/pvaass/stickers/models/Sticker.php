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
        'url' => 'required',
        'color' => 'required'
    ];

    public function beforeSave()
    {
        if($this->active) {
            DB::table($this->table)
                ->where('id', "!=", $this->id ? $this->id : 0)
                ->update(['active' => false]);
        }
    }

    public function getColorOptions() {
        return [
            "#006600" => "Groen",
            "#000066" => "Blauw"
        ];
    }
}