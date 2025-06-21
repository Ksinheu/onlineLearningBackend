<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;
    protected $fillable=[
        'course_id',
        'lesson_id',
        'session',
        'expect_result',
        'Lesson_content',
        'activity',
        'Evaluate'
    ];
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }

    public function lesson(){
        return $this->belongsTo(Lession::class,'lesson_id');
    }
}
