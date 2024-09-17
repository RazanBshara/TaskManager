<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_groups', function (Blueprint $table) {
            $table->integer('userid');
            $table->integer('rolegroupid');
            $table->timestamps();

            //$table->foreign('userid')->references('id')->on('users'); 
            //$table->foreign('rolegroupid')->references('id')->on('role_groups'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_groups');
    }
}
