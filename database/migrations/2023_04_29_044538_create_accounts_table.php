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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('acnumber')->index()->unique();
            $table->decimal('balance',10,2)->default(0.00);
            $table->string('currency')->nullable();
            $table->string('actype')->nullable();
            $table->string('status')->default('Active');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('branche_id')->unsigned()->nullable();
            $table->foreign('branche_id')->references('id')->on('branches');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
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
        Schema::dropIfExists('accounts');
    }
};
