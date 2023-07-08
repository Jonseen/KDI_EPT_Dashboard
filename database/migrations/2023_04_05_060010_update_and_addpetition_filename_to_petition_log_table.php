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
        Schema::table("petition_log", function(Blueprint $table){
            $table->after("judgement", function(Blueprint $table){
                $table->string('petition_filename')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table("petition_log", function(Blueprint $table){
            $table->dropColumn("petition_filename");
        });
    }
};
