<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $table = 'rola_pouzivatela';

    protected $fillable = [
        'rola',
      
    ];
    
    public function userss(): HasMany
    {
        return $this->hasMany(User::class);
    }
    
<<<<<<< HEAD
}
=======
}
>>>>>>> feature/rola_pouzivatela
