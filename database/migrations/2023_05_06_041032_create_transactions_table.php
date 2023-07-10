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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_from')->nullable();
            $table->decimal('previous_balance',10,2)->default(0.00);
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->decimal('current_balance',10,2)->default(0.00);
            $table->string('currency')->nullable();
            $table->string('transaction_to')->nullable();
            $table->string('action')->nullable();
            $table->string('method')->nullable();
            $table->decimal('fees',10,2)->default(0.00);
            $table->string('reference')->nullable();
            $table->string('status')->default('Pending');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('branche_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('cash_register_id')->nullable();
            $table->timestamps();
            $table->foreign('branche_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('cash_register_id')->references('id')->on('cash_registers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
