<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'icon_data',
        'description',
        'start',
        'end',
        'location',
        'capacity',
    ];
    
    // Relationship to EventImage
    public function eventImages() {
        return $this->hasMany(EventImage::class, 'event_id');
    }

    // Relationship to UserEventMapping
    public function userEventMappings() {
        return $this->hasMany(UserEventMapping::class, 'event_id');
    }

    // Relationship to Organizer
    public function organizers() {
        return $this->hasMany(Organizer::class, 'event_id');
    }
}
