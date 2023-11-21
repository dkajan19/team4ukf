<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'firma';

    protected $fillable = [
        'nazov_firmy',
        'IČO',
        'meno_kontaktnej_osoby',
        'priezvisko_kontaktnej_osoby',
        'email',
        'tel_cislo',
    ];
}
