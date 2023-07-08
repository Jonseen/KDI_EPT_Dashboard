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
        Schema::create('petition_scores', function (Blueprint $table) {
            $table->integer('sn')->primary();
            $table->string('state');
            $table->integer('presidential');
            $table->integer('senatorial');
            $table->integer('house_of_reps');
            $table->integer('governorship');
            $table->integer('state_house_of_reps');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petition_scores');
    }
};
