<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitrecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitrecords', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('title', 100)->nullable();
            $table->string('time', 100)->nullable();
            $table->string('status', 100)->nullable();
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
        Schema::dropIfExists('visitrecords');
    }
}
