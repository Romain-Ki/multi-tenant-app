<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutuelles extends Model
{
    use HasFactory;

    protected $table = 'mutuelles';

    public $incrementing = false;

    protected $keyType = 'string'; // UUID

    protected $fillable = ['nom', 'email_contact'];

    public function clients()
    {
        return $this->hasMany(Clients::class);
    }

    public function offres()
    {
        return $this->hasMany(OffreSantes::class);
    }
}
