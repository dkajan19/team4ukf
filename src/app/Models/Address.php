<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $table = 'adresa';

    protected $fillable = [
        'mesto',
        'PSČ',
        'ulica',
        'č_domu',
        'firma_id',
    ];

    public function companiess(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'firma_id');
    }
    
}
