<?php namespace pvaass\BlogBlocks\Updates;

use Doctrine\DBAL\Schema\Table;
use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('pvaass_blogblocks_blogblock', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('post_id', false, true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pvaass_blogblocks_blogblock');
    }
}