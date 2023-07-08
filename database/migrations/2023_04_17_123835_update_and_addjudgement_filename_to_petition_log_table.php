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
        Schema::table('petition_log', function (Blueprint $table) {
            $table->after('petition_filename', function(Blueprint $table){
                $table->string('judgement_filename')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('petition_log', function (Blueprint $table) {
            $table->dropColumn('judgement_filename');
        });
    }
};
