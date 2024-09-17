<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('workspaceid');
            $table->integer('departmentid');
            $table->integer('hou');
            $table->string('isactive')->default('nonactive');
            $table->string('updatingfor')->nullable();
            $table->string('isdeleted')->nullable();
            $table->timestamps();

            //$table->foreign('workspaceid')->references('id')->on('workspaces');
            //$table->foreign('departmentid')->references('id')->on('departments');            

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
}
