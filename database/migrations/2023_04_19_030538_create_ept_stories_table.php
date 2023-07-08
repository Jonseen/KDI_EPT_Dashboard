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
        Schema::create('ept_stories', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("title");
            $table->string("reporter");
            $table->string("image");
            $table->text("body")->nullable();
            // a story must have at least one paragraph
            $table->text("paragraphs");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ept_stories');
    }
};
