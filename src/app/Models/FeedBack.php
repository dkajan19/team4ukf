<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'feedback';

    protected $fillable = [
        'feedback',
        'prax_id',
    ];



    public function internship(): BelongsTo
    {
        return $this->belongsTo(Internship::class,'prax_id');
    }

}
