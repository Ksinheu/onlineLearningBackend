<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'course_name',
        'imgCourse',
        'description',
        'price',
        'price_normal',
        
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function lession(){
        return $this->hasMany(Lession::class);
    }
    public function assignment(){
        return $this->hasMany(Assignment::class);
    }
    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
}
