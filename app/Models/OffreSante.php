<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreSante extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'mutuelle_id', 'titre', 'description', 'type_soin',
        'remboursement_max', 'date_debut', 'date_fin',
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
