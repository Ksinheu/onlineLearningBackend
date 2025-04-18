<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'lesson_id',
        'completed',
        'completed_at'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function lession(){
        return $this->belongsTo(Lession::class,'lesson_id');
    }
}
