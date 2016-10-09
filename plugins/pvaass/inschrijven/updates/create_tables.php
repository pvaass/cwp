<?php namespace Acme\Blog\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTables extends Migration
{
    public function up()
    {
        Schema::create('pvaass_inschrijven_inschrijvingen', function($table)
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
            $table->string('zwemdiplomas');
            $table->string('vorige_vereninging');
            $table->text('ziektes');
            $table->text('opmerkingen');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('pvaass_inschrijven_inschrijvingen');
    }
}