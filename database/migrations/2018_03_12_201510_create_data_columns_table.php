<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDataColumnsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_columns', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('data_source_id');
            $table->string('name');
            $table->string('alias')->nullable();
            $table->string('edit')->nullable();
            $table->string('filter')->nullable();
            $table->string('un_search')->nullable();
            $table->string('html')->nullable();
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
        Schema::drop('data_columns');
    }
}
