<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[Fillable(['film_id', 'user_id', 'name', 'description', 'city', 'country', 'upvotes_count'])]
class Location extends Model
{
    use HasFactory, Notifiable;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function film()
    {
        return $this->belongsTo(Film::class);
    }

    public function upvotes()
    {
        return $this->hasMany(Upvote::class);
    }
}
