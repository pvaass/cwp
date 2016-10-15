<?php namespace Acme\Blog\Updates;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('pvaass_inschrijven_inschrijvingen', function(Blueprint $table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('voornaam');
            $table->string('achternaam');
            $table->string('geslacht');
            $table->dateTime('geboortedatum');
            $table->string('adres');
            $table->string('huisnummer');
            $table->string('plaatsnaam');
            $table->string('postcode');
            $table->string('telefoonnummer');
            $table->string('zwembad');
            $table->string('email');
            $table->string('zwemdiplomas')->nullable();
            $table->string('vorige_vereninging')->nullable();
            $table->text('ziektes')->nullable();
            $table->text('opmerkingen')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pvaass_inschrijven_inschrijvingen');
    }
}