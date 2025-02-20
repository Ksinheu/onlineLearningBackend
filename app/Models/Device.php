<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    protected $fillable=[
        'customer_id',
        'device_type',
        'operating_system',
        'browser_name',
        'browser_version',
        'screen_resolution',
        'ip_address',
        'location',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
