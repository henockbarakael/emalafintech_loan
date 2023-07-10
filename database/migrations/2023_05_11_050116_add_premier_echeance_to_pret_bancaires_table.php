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
        Schema::table('pret_bancaires', function (Blueprint $table) {
            $table->timestamp('premier_echeance')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pret_bancaires', function (Blueprint $table) {
            $table->dropColumn('premier_echeance');
        });
    }
};
