<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Mutuelles extends Authenticatable
{
    use HasFactory;

    protected $table = 'mutuelles';

    public $incrementing = false;

    protected $keyType = 'string'; // UUID

    protected $hidden = ['password'];

    protected $fillable = ['id', 'nom', 'password', 'email_contact'];

    public function clients()
    {
        return $this->hasMany(Clients::class, 'mutuelle_id');
    }

    public function offres()
    {
        return $this->hasMany(OffreSantes::class);
    }
}
