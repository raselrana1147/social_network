<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageFollowersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_followers', function (Blueprint $table) {
           $table->id();
           $table->unsignedBigInteger('person_id');
           $table->unsignedBigInteger('page_id');
           $table->timestamps();
           $table->foreign('person_id')->references('id')->on('persons')->onDelete('cascade');
           $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_followers');
    }
}
