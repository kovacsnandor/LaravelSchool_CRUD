<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    /** @use HasFactory<\Database\Factories\SportsFactory> */
    use HasFactory;

    protected $fillable = [
        'id',
        'sportNev',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
