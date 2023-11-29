<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Find a user by username.
     *
     * @param string $username
     * @return \App\Models\User|null
     */
    public static function findByUsername($username)
    {
        return self::where('username', $username)->first();
    }

    // Relationship to UserEventMapping
    public function userEventMappings() {
        return $this->hasMany(UserEventMapping::class, 'user_id');
    }

    // Relationship to Organizer
    public function organizers() {
        return $this->hasMany(Organizer::class, 'user_id');
    }

    // Relationship to Event
    public function events() {
        return $this->belongsToMany(Event::class, 'user_event_mappings', 'user_id', 'event_id');
    }
}
