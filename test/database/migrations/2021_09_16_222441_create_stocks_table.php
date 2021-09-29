<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('companyId')->unsigned();
            $table->foreign('companyId')->nullable()->references('id')->on('companies');
            $table->string('status', 100)->nullable();
            $table->integer('stockPrice')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('invested')->nullable();
            $table->integer('userId')->unsigned();
            $table->foreign('userId')->nullable()->references('id')->on('customers');
            $table->string('createdBy', 100)->nullable();
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
        Schema::dropIfExists('stocks');
    }
}
