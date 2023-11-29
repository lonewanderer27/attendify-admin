<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'code'
    ];
    protected $table = 'otp'; // Replace 'otp' with the actual table name

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
