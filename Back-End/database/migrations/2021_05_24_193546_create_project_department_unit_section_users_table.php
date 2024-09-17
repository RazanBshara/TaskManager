<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDepartmentUnitSectionUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_department_unit_section_users', function (Blueprint $table) {    
            $table->integer('projectid');
            $table->integer('departmentid');
            $table->integer('unitid');
            $table->integer('sectionid');
            $table->integer('userid');
            $table->timestamps();

            /*$table->foreign('projectid')->references('id')->on('projects');
            $table->foreign('departmentid')->references('id')->on('departments');
            $table->foreign('unitid')->references('id')->on('unitits');
            $table->foreign('sectionid')->references('id')->on('sections');
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
        Schema::dropIfExists('project_department_unit_section_users');
    }
}
