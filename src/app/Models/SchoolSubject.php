<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolSubject extends Model
{
    use HasFactory;

    protected $table = 'predmety';

    protected $fillable = [
        'nazov',
        'skratka',
        'studijny_program_id',
    ];

    public function study_programs(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class,'studijny_program_id');
    }
    
    public function praxess(): HasMany
    {
        return $this->hasMany(Internship::class);
    }

}

