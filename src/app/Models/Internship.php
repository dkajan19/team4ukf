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
        'popis_praxe', //nema byt string
        'datum_zaciatku',
        'datum_konca',
        'aktualny_stav',
        'predmety_id',
        'student_id',
        'veduci_pracoviska_id',
        'pracovnik_fpvai_id',
        'kontaktna_osoba_id',
        'dokumenty_id',
        'predmety_id',
        'zmluva_id',
    ];

    protected $attributes = [
        'predmety_id'=>839,
        'aktualny_stav'=>"vytvorená",
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

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class,'zmluva_id');
    }
    
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'firma_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function head(): BelongsTo
    {
        return $this->belongsTo(User::class, 'veduci_pracoviska_id');
    }

    public function worker(): BelongsTo
    {
        return $this->belongsTo(User::class,'pracovnik_fpvai_id');
    }

    public function documents(): BelongsTo
    {
        return $this->belongsTo(Documents::class,'dokumenty_id');
    }
}
