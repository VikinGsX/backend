<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('socials', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            //$table->string('id')->primary();
            $table->bigIncrements('id');
            $table->uuid('uuid');
            $table->string('user_id')->nullable(); //foreign_key
            $table->string('email');
            $table->string('password')->nullable();
            $table->string('name');
            $table->string('nick_name')->nullable();
            $table->string('provider_user_id');
            $table->string('provider');
            $table->string('avatar');

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
        Schema::dropIfExists('socials');
    }
}
