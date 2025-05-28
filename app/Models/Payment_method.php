<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment_method extends Model
{
    use HasFactory;
    protected $fillable=[
'name_bank',
'number_bank',
'QR_code',
'phone_number',
'status'
    ];
}
