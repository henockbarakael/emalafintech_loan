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
        Schema::create('pret_bancaires', function (Blueprint $table) {
            $table->id();
            $table->string('control_number')->nullable();
            $table->decimal('loan_amount',10,2)->default(0.00);
            $table->string('loan_currency')->nullable();
            $table->string('loan_status')->nullable();
            $table->string('loan_duration')->nullable();
            $table->string('loan_type')->nullable();
            $table->string('objet')->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('branche_id')->unsigned()->nullable();
            $table->bigInteger('processed_by')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('branche_id')->references('id')->on('branches');
            $table->foreign('processed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pret_bancaires');
    }
};
