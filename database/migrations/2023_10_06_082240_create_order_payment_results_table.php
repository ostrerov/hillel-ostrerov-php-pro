<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_payment_result', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('payment_system');
            $table->string('order_id');
            $table->string('payment_id');
            $table->boolean('success');
            $table->float('amount');
            $table->integer('currency');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_payment_result');
    }
};
