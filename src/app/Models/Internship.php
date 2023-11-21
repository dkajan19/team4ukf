<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    use HasFactory;

    protected $table = 'prax';

    protected $fillable = [
        'popis_praxe',
        'datum_zaciatku',
        'datum_konca',
        'aktualny_stav',
        
    ];
}
