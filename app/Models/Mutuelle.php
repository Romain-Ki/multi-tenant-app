<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutuelle extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string'; // UUID

    protected $fillable = ['nom', 'email_contact'];

    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function offres()
    {
        return $this->hasMany(OffreSante::class);
    }
}
