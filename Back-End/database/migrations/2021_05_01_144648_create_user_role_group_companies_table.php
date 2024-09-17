<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleGroupCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_group_companies', function (Blueprint $table) {
            $table->integer('userid');
            $table->integer('rolegroupcompanyid');
            $table->timestamps();

            //$table->foreign('userid')->references('id')->on('users'); 
            //$table->foreign('rolegroupcompanyid')->references('id')->on('role_group_companies'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role_group_companies');
    }
}
