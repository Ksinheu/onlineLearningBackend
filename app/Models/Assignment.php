<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable=[
        'course_id',
        'title',
        'description',
        'due_date',
        'max_score',
    ];
    public function course(){
        return $this->belongsTo(Course::class,'course_id');
    }
    public function submission(){
        return $this->hasMany(Submission::class);
    }
}
