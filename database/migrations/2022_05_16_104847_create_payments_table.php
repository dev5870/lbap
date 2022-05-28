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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedTinyInteger('status')->default(\App\Enums\PaymentStatus::CREATE);
            $table->unsignedTinyInteger('type');
            $table->unsignedDecimal('full_amount', 10, 8)->nullable();
            $table->unsignedDecimal('amount', 10, 8)->nullable();
            $table->unsignedDecimal('commission_amount', 10, 8)->nullable();
            $table->timestamp('paid_at')->nullable();
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
        Schema::dropIfExists('payments');
    }
};
