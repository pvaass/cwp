<?php namespace pvaass\Stickers\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('pvaass_stickers_stickers', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('text');
            $table->string('url');
            $table->boolean('active')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pvaass_stickers_stickers');
    }
}