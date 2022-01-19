<?php namespace Matat\Happygift\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateIndicesTable Migration
 */
class CreateIndicesTable extends Migration
{
    public function up()
    {
        Schema::create('matat_happygift_indices', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matat_happygift_indices');
    }
}
