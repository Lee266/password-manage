<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255);

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');

            $table->date('meeting_date');
            $table->string('location');

            $table->string('location_image_url', 255)->nullable();
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
        Schema::dropIfExists('meetings');
    }
};
