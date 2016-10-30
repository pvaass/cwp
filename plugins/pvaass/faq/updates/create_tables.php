<?php namespace pvaass\Faq\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('pvaass_faq_questions', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('question');
            $table->longText('answer');
            $table->string('category');
            $table->integer('position');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pvaass_faq_questions');
    }
}