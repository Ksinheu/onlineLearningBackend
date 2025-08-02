<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lession extends Model
{
    use HasFactory;
    protected $fillable=[
        'course_id',
        'title',
    ];
    public function course(){
        return $this->BelongsTo(Course::class,'course_id');
    }
    
    public function exercise(){
        return $this->hasMany(Exercise::class);
    }
     public function content(){
        return $this->hasMany(Content::class, 'lesson_id');
    }
}
