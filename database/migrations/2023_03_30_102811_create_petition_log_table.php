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
        Schema::create('petition_log', function (Blueprint $table) {
            $table->bigInteger('sn')->primary();
            $table->string('state');
            $table->string('gpz');
            $table->string('petition_number');
            $table->string('election_type');
            $table->string('ept_type');
            $table->string('petitioners_name');
            $table->string('petitioners_pol');
            $table->string('respondent_pol');
            $table->string('grounds_of_petition');
            $table->string('stage');
            $table->string('judgement');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('petition_log');
    }
};
