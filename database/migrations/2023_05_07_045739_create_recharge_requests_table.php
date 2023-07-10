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
        Schema::create('recharge_requests', function (Blueprint $table) {
            $table->id();
            $table->string('wallet_code')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('currency')->nullable();
            $table->bigInteger('branche_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('branche_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recharge_requests');
    }
};
