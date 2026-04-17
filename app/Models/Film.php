<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

#[Fillable(['title', 'release_year', 'synopsis'])]
class Film extends Model
{
    use HasFactory, Notifiable;

    public function locations()
    {
        return $this->hasMany(Location::class);
    }
}
