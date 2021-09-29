<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostdeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postdeliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('companyId')->unsigned();
            $table->foreign('companyId')->nullable()->references('id')->on('companies');
            $table->integer('cityId')->unsigned();
            $table->foreign('cityId')->nullable()->references('id')->on('cities');
            $table->string('status', 100)->nullable();
            $table->text('address')->nullable();
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('customers');
            $table->string('createdBy', 30)->nullable();
            $table->integer('updatedBy')->nullable();
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
        Schema::dropIfExists('postdeliveries');
    }
}
