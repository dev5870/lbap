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
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->unsignedTinyInteger('status')->default(\App\Enums\PaymentStatus::CREATE);
            $table->unsignedTinyInteger('payment_type_id');
            $table->unsignedTinyInteger('method');
            $table->decimal('full_amount', 18, 8)->nullable();
            $table->decimal('amount', 18, 8)->nullable();
            $table->decimal('commission_amount', 18, 8)->nullable();
            $table->string('description', 200);
            $table->unsignedTinyInteger('parent_id')->nullable();
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
