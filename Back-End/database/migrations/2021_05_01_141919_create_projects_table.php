<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('createdby');        
            $table->string('status')->default('new');
            $table->dateTimeTz('startdate');
            $table->dateTimeTz('enddate')->nullable();            
            $table->integer('workspaceid');
            $table->integer('pmid');
            $table->string('isactive')->default('nonactive');
            $table->string('updatingfor')->nullable();
            $table->string('isdeleted')->nullable();
            $table->string('label')->default('No Label');                     
            $table->timestamps();

            //$table->foreign('workspaceid')->references('id')->on('workspaces');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
