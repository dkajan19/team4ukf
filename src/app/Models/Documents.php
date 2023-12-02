<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Documents extends Model
{
    use HasFactory;

    protected $table = 'dokumenty';

    protected $fillable = [
        'typ_dokumentu',
        'dokument',
        
    ];

    public function internships(): HasMany
{
    return $this->hasMany(Internship::class);
}
}
