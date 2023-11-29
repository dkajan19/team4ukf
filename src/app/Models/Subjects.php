<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subjects extends Model
{
    use HasFactory;

    protected $table = 'predmety';

    protected $fillable = [
        'nazov',
        'skratka',
        'studijny_program_id',
    ];

    public function StudyProgram(): BelongsTo
    {
        return $this->belongsTo(StudyProgram::class, 'studijny_program_id');
    }

    public function praxee(): HasOne
    {
        return $this->hasOne(Internship::class);
    }


}
