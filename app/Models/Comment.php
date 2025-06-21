<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
     protected $fillable = [
        'course_id',
        'customer_id',
        'comment',
        'read_status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
