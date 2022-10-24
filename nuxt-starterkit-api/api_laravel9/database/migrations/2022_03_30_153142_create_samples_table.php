<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSamplesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('avatar')->nullable();
            $table->date('birthday')->nullable();
            $table->text('hobby')->nullable();
            $table->boolean('gender')->nullable();
            $table->string('postcode');
            $table->unsignedBigInteger('prefecture_id')->index('fk_user_prefecture')->nullable();
            $table->text('address')->nullable();
            $table->time('active_hour')->nullable();
            $table->string('email')->unique('email_UNIQUE');
            $table->string('password');
            $table->bigInteger('price');
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
        Schema::dropIfExists('samples');
    }
}
