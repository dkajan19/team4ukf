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
        // Add other fields if needed
    ];
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}