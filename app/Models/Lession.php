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
        'content',
        'video_url',
        'order_num',
    ];
    public function course(){
        return $this->BelongsTo(Course::class,'course_id');
    }
    public function progress(){
        return $this->hasMany(Progress::class);
    }
}
