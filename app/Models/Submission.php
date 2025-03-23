<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $fillable=[
        'assignment_id',
        'user_id',
        'submission_date',
        'grade',
        'feedback',
    ];
    public function assignment(){
        return $this->belongsTo(Assignment::class,'assignment_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
