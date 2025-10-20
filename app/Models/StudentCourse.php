<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourse extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'level_id',
        'session_id',
        'semester_id',
        'course_id',
        'score',
        'is_result_sent'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function semester(){
        return $this->belongsTo(Semester::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
    
}
