<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documents extends Model
{
    use HasFactory;

    protected $table = 'dokumenty';

    protected $fillable = [
        'typ_dokumentu',
        
    ];

    public function praxe(): HasMany
    {
        return $this->hasMany(Internship::class);
    }
}
