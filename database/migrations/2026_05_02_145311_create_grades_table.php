<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            
            // 1. Student ID (Index optimized, tracks student or 0 for HPS layout row)
            $table->unsignedBigInteger('student_id')->index();
            
            // 2. Teacher Assignment ID Context (Points to teacher_assignments)
            $table->foreignId('assignment_id')
                  ->constrained('teacher_assignments')
                  ->cascadeOnDelete();
                  
            // 3. Quarter Context (e.g., "1st", "2nd")
            $table->string('quarter');

            // 4. Flexible JSON Scores Storage
            $table->json('scores')->nullable();

            $table->timestamps();

            // 5. Composite Unique Constraint
            // Guarantees strict data isolation. A student can only have ONE entry 
            // per teacher-subject-section combination per quarter.
            $table->unique(['student_id', 'assignment_id', 'quarter'], 'student_assign_quarter_uidx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};