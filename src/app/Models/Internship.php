<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Internship extends Model
{
    use HasFactory;

    protected $table = 'prax';

    protected $fillable = [
        'popis_praxe',
        'datum_zaciatku',
        'datum_konca',
        'aktualny_stav',
        'predmety_id',
    ];

    public function prax_prepojenia(): BelongsTo
    {
        return[ $this->belongsTo(User::class,'student_id'),
                $this->belongsTo(User::class,'veduci_pracoviska_id'),
                $this->belongsTo(User::class,'pracovnik_fpvai_id'),
                $this->belongsTo(User::class,'kontaktna_osoba_id'),
                $this->belongsTo(Documents::class,'dokumenty_id'),
                $this->belongsTo(SchoolSubject::class,'predmety_id'),
                $this->belongsTo(Contract::class,'zmluva_id'),
        ];
    }

    public function schoolSubject(): BelongsTo
    {
        return $this->belongsTo(SchoolSubject::class, 'predmety_id');
    }
    
}
