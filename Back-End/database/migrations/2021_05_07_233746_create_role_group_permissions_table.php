<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleGroupPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_group_permissions', function (Blueprint $table) {
            $table->integer('rolegroupid');
            $table->integer('permissionid');
            $table->timestamps();

            //$table->foreign('rolegroupid')->references('id')->on('role_groups');
            //$table->foreign('permissionid')->references('id')->on('permissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_group_permissions');
    }
}
