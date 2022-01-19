<?php namespace Matat\HappyGift\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateRequestHandlersTable Migration
 */
class CreateRequestHandlersTable extends Migration
{
    public function up()
    {
        Schema::create('matat_happygift_request_handlers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('matat_happygift_request_handlers');
    }
}
