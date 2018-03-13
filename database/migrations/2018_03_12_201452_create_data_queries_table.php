<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataQueriesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_queries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('data_source_id');
            $table->integer('parent')->nullable();
            $table->string('command');
            $table->string('column')->nullable();
            $table->string('operator')->nullable();
            $table->string('value')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('data_queries');
    }
}
