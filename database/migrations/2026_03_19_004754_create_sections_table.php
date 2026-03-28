<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('grade_level'); // e.g., Grade 9
            $table->string('name');        // e.g., Narra
            $table->unsignedBigInteger('adviser_id');
            $table->timestamps();

            $table->foreign('adviser_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
