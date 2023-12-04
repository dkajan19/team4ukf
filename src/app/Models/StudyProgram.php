<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyProgram extends Model
{
    use HasFactory;

    protected $table = 'studijny_program';

    protected $fillable = [
        'nazov',
        'skratka',
    ];
    
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function schoolSubjects()
    {
        return $this->hasMany(SchoolSubject::class, 'studijny_program_id');
    }
}