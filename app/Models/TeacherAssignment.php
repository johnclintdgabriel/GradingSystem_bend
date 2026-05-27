<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeacherAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'section_id',
        'grade_level',
    ];

    // 👨‍🏫 Teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    // 📘 Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // 🏫 Section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // 🔥 GENERATED SUBJECT CODE (English7)
    public function getSubjectCodeAttribute()
    {
        return $this->subject->name . $this->grade_level;
    }
}
