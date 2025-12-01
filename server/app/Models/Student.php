<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentsFactory> */
    use HasFactory;
    protected $fillable = [
        'diakNev',
        'schoolclassId',
        'neme',
        'iranyitoszam',
        'lakHelyseg',
        'lakCim',
        'szulHelyseg',
        'szulDatum',
        'igazolvanyszam',
        'atlag',
        'osztondij',
    ];
}
