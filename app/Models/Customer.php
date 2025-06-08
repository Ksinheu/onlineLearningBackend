<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $fillable=[
        'username',
        'email',
        'gender',
        'phone',
        'password',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function Devices(){
        return $this->hasMany(Device::class,'customer_id');
    }

    public function purchases(){
        return $this->hasMany(Purchase::class);
    }
}
