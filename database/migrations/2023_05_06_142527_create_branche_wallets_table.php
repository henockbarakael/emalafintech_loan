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
        Schema::create('branche_wallets', function (Blueprint $table) {
            $table->id();
            $table->string('w_code')->index()->unique();
            $table->decimal('w_cdf',10,2)->default(0.00);
            $table->decimal('w_usd',10,2)->default(0.00);
            $table->string('w_type')->nullable();
            $table->string('status')->default('Active');
            $table->bigInteger('branche_id')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('branche_id')->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branche_wallets');
    }
};
