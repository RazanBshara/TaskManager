<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->integer('taskid');
            $table->integer('ticketid');
            $table->integer('typeid');
            $table->integer('userid');
            $table->integer('priority');
            $table->string('status')->default('new');
            $table->string('description')->nullable();            
            $table->string('isactive')->default('nonactive');
            $table->timestamps();

            /*$table->foreign('taskid')->references('id')->on('tasks');
            $table->foreign('ticketid')->references('id')->on('tickets');
            $table->foreign('typeid')->references('id')->on('process_types');
            $table->foreign('userid')->references('id')->on('users');*/

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processes');
    }
}
