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
        Schema::create('user_params', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->uuid('user_uuid')->nullable();
            $table->string('username', 15)->nullable();
            $table->string('about', 25)->nullable();
            $table->string('skill', 25)->nullable();
            $table->string('city', 25)->nullable();
            $table->string('telegram', 25)->nullable();
            $table->string('description', 300)->nullable();
            $table->boolean('mfa')->default(false)->nullable();
            $table->boolean('login_notify')->default(false)->nullable();
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
        Schema::dropIfExists('user_params');
    }
};
