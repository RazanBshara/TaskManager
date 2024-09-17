<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkspacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('createdby');
            $table->integer('companyid');
            $table->integer('managerid');
            $table->string('isactive')->default('nonactive');
            $table->string('updatingfor')->nullable();
            $table->string('isdeleted')->nullable();
            $table->timestamps();

            //$table->foreign('companyid')->references('id')->on('companies');
            //$table->foreign('userid')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workspaces');
    }
}
