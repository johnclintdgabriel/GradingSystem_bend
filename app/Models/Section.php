<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_level',
        'name',
        'adviser_id',
    ];

    // Adviser relationship
    public function adviser()
    {
        return $this->belongsTo(User::class, 'adviser_id');
    }

    // Students relationship (example)
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
