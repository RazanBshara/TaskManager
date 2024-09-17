<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTimeTz('startdate');
            $table->dateTimeTz('enddate')->nullable();
            $table->integer('createdby');        
            $table->string('type');
            $table->string('label');
            $table->integer('projectid')->nullable();
            $table->integer('priority');
            $table->string('status')->default('new');;
            $table->string('isactive')->default('nonactive');
            $table->string('updatingfor')->nullable();
            $table->string('isdeleted')->nullable();            
            $table->string('relatedto')->nullable();
            $table->integer('relatedid')->nullable();  
            $table->integer('dependontask')->nullable();   
            $table->nestedSet();       
            $table->timestamps();


            //$table->foreign('projectid')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropNestedSet();
        });
    }
}
