<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('teacher_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('teacher_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('subject_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('section_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('grade_level');

            $table->unique(['teacher_id', 'subject_id', 'section_id', 'grade_level'], 'teacher_assign_unique');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('teacher_assignments');
    }
};
