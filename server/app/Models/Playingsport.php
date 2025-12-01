<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Playingsport extends Model
{
    /** @use HasFactory<\Database\Factories\PlayingsportsFactory> */
    use HasFactory;
     protected $fillable = [
        'studentId',
        'sportId',
    ];

    protected $hidden =[
        'created_at',
        'updated_at',
    ];
}
