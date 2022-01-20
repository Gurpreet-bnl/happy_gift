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
        Schema::create('matat_happygift_fields', function (Blueprint $table) {
            $table->increments('id');
            $table->string('api_url')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matat_happygift_fields');
    }
}
