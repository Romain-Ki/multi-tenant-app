<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeRemboursement extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'client_id', 'offre_id', 'statut', 'montant', 'date_demande',
        'type_soin', 'justificatif_path', 'justificatif_encrypted', 'commentaire',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function offre()
    {
        return $this->belongsTo(OffreSante::class);
    }

    public function echanges()
    {
        return $this->hasMany(EchangeDossier::class, 'demande_id');
    }
}
