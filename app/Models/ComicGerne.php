<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComicGerne extends Model
{
    use HasFactory;
    protected $fillable = [
        'genre_id',
        'comic_id',
    ];
}
