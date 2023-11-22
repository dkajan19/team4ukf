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
    public function contracts(): HasMany
    {
        return[ 
            $this->hasMany(Contract::class),
            $this->hasMany(Address::class),
            $this->hasMany(User::class),
        ];
    }

    
}
