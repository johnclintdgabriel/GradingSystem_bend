<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'assignment_id',
        'quarter',
        'scores'
    ];

    protected $casts = [
        'scores' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}