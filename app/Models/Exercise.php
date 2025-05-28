<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable=[
        'lesson_id',
        'exercise_element',
    ];

    public function lesson(){
        return $this->belongsTo(Lession::class, 'lesson_id');
     }
    public function exerciseImage(){
        return $this->hasMany(ExerciseImage::class);
    }

}
