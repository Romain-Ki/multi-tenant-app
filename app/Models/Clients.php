<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Clients extends Authenticatable
{
    use HasFactory;

    protected $table = 'clients';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $hidden = ['password'];

    protected $fillable = [
        'id',
        'mutuelle_id', 'nom', 'prenom', 'numero_securite_sociale_encrypted', 'numero_securite_sociale_hashed',
        'email', 'password', 'telephone', 'adresse', 'rib_encrypted', 'historique_medical_encrypted',
    ];

    public function mutuelle()
    {
        return $this->belongsTo(Mutuelles::class);
    }

    public function demandes()
    {
        return $this->hasMany(DemandeRemboursements::class);
    }
}
