<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('phonenumber')->nullable();
            $table->dateTimeTz('birthday')->nullable();
            $table->rememberToken()->nullable();
            $table->string('img')->nullable();
            $table->unsignedBigInteger('companyid');
            $table->unsignedBigInteger('departmentid');
            $table->unsignedBigInteger('unitid');
            $table->unsignedBigInteger('sectionid');
            $table->timestamps();

            /*$table->foreign('companyid')->references('id')->on('companies');
            $table->foreign('departmentid')->references('id')->on('departments');
            $table->foreign('unitid')->references('id')->on('units');
            $table->foreign('sectionid')->references('id')->on('sections');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
