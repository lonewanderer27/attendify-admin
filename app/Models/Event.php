<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo',
        'description',
        'start',
        'end',
        'location',
        'capacity',
        'organizer',
        'organizer_email',
        'user_id',
        'invite_code'
    ];

    // Relationship to user
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship to Attendee
    public function attendee() {
        return $this->hasMany(Attendee::class, 'event_id');
    }
}
