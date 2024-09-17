<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleGroupCompanyPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_group_company_permissions', function (Blueprint $table) {
            $table->integer('rolegroupcompanyid');
            $table->integer('permissionid');
            $table->timestamps();

            //$table->foreign('rolegroupcompanyid')->references('id')->on('role_group_companies');
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
        Schema::dropIfExists('role_group_company_permissions');
    }
}
