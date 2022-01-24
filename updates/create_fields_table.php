<?php namespace Matat\Happygift\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateFieldsTable Migration
 */
class CreateFieldsTable extends Migration
{
    public function up()
    {
        Schema::create('hg_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key')->nullable();
            $table->string('value')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('hg_settings');
    }
}
