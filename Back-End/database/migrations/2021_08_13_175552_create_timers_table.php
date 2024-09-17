<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->Integer('task_id')->nullable();
            $table->Integer('user_id');
            $table->time('duration')->nullable();
            $table->dateTimeTz('started_at');
            $table->dateTimeTz('stopped_at')->default(null)->nullable();
            $table->string('isactive');
            $table->timestamps(); 

            //$table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('task_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timers');
    }
}
