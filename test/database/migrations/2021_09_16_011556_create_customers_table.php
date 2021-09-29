<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150)->nullable();
            $table->string('email', 150)->nullable();
            $table->integer('age')->nullable();
            $table->text('address')->nullable();
            $table->enum('gender', ['M', 'F', 'O'])->default('M');
            $table->integer('city_id')->unsigned();
            $table->foreign('city_id')->nullable()->references('id')->on('cities');
            $table->string('phonenumber1', 150)->nullable();
            $table->string('phonenumber2', 150)->nullable();
            $table->integer('customerGroupID')->unsigned();
            $table->foreign('customerGroupID')->nullable()->references('id')->on('customergroups');
            $table->string('stockBroker', 150)->nullable();
            $table->string('accountNumber', 150)->nullable();
            $table->integer('routesOfKnownID')->unsigned();
            $table->foreign('routesOfKnownID')->nullable()->references('id')->on('routeknowns');
            $table->integer('createdBy')->unsigned();
            $table->foreign('createdBy')->nullable()->references('id')->on('users');
            $table->integer('updatedBy')->unsigned();
            $table->foreign('updatedBy')->nullable()->references('id')->on('users');
            $table->enum('isActive', ['Y', 'N'])->default('Y');
            $table->enum('isDelete', ['Y', 'N'])->default('N');
            $table->enum('isApproved', ['Y', 'N'])->default('Y');
            $table->integer('groupid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
