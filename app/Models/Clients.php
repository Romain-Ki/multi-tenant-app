<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    use HasFactory;

    protected $table = 'clients';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'mutuelle_id', 'nom', 'prenom', 'numero_securite_sociale_encrypted',
        'email', 'telephone', 'adresse', 'rib_encrypted', 'historique_medical_encrypted',
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
