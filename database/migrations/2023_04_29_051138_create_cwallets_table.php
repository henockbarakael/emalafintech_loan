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
        Schema::create('cwallets', function (Blueprint $table) {
            $table->id();
            $table->string('w_code')->index()->unique();
            $table->decimal('amount',10,2)->default(0.00);
            $table->string('currency')->nullable();
            $table->string('w_type')->nullable();
            $table->string('status')->default('Active');
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('branche_id')->unsigned()->nullable();
            $table->foreign('branche_id')->references('id')->on('branches');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('cwallets');
    }
};
