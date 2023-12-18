<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'pouzivatel';


    protected $fillable = [
        'meno',
        'priezvisko',
        'tel_cislo',
        'email',
        'password',
        'rola_pouzivatela_id',
        'firma_id',
    ];
     
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function user_roles(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'rola_pouzivatela_id');
    }
    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class,'firma_id');
    }

    public function prax(): HasMany
    {
        return $this->hasMany(Internship::class, 'student_id');
    }

    public function praxe(): HasMany
    {
        return $this->hasMany(Internship::class, 'veduci_pracoviska_id');
    }

    public function praxea(): HasMany
    {
        return $this->hasMany(Internship::class, 'pracovnik_fpvai_id');
    }

    public function praxeb(): HasMany
    {
        return $this->hasMany(Internship::class, 'kontaktna_osoba_id');
    }   

}