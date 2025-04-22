<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'mutuelle_id', 'nom', 'prenom', 'numero_securite_sociale_encrypted',
        'email', 'telephone', 'adresse', 'rib_encrypted', 'historique_medical_encrypted',
    ];

    public function mutuelle()
    {
        return $this->belongsTo(Mutuelle::class);
    }

    public function demandes()
    {
        return $this->hasMany(DemandeRemboursement::class);
    }
}
