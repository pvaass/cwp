<?php namespace pvaass\Stickers\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class AddColor extends Migration
{
    public function up()
    {
        Schema::table('pvaass_stickers_stickers', function(Blueprint $table) {
            $table->string('color')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pvaass_stickers_stickers', function(Blueprint $table) {
            $table->dropColumn('color');
        });
    }
}