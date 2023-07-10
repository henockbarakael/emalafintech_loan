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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('bname')->nullable();
            $table->string('bcode')->nullable();
            $table->string('bphone')->nullable();
            $table->string('bemail')->nullable();
            $table->string('btownship')->nullable();
            $table->string('bcity')->nullable();
            $table->string('btype')->nullable();
            $table->string('status')->default('Inactive');
            $table->integer('bmember')->default(3);
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
        Schema::dropIfExists('branches');
    }
};
