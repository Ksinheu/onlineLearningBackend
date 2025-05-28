<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_id',
        'course_id',
        'pay_slip',
        'purchase_date',
        'payment_status',
    ];
    public function customer(){
        return $this->belongsTo(Customer::class,'user_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
