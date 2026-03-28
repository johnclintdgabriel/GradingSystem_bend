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
        Schema::create('grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_assignment_id')->constrained()->cascadeOnDelete();

            $table->decimal('written_work', 5, 2)->nullable();
            $table->decimal('performance_task', 5, 2)->nullable();
            $table->decimal('quarter_exam', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2)->nullable();

            $table->integer('quarter');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grades');
    }
};
