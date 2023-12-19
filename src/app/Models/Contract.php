<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'zmluva';

    protected $fillable = [
        'zmluva',
        'firma_id',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'firma_id');
    }

    public function praxee(): HasOne
    {
        return $this->hasOne(Internship::class, 'id');
    }

}
