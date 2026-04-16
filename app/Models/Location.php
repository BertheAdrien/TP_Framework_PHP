<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

#[Fillable(['film_id', 'user_id', 'name', 'description', 'city', 'country', 'upvotes_count'])]
class Location extends Model
{
    use HasFactory, Notifiable;
}
