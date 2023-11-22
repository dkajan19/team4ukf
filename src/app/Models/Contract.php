<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    
    protected $table = 'zmluva';

    protected $fillable = [
        'zmluva',
        
    ];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'firma_id');
    }

    public function praxee(): HasOne
    {
        return $this->hasOne(Internship::class);
    }
}
