<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'gender',
        'section_id'
    ];

    // Relationship
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
