<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OffreSantes extends Model
{
    use HasFactory;

    protected $table = 'offre_santes';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'mutuelle_id', 'titre', 'description', 'type_soin',
        'remboursement_max', 'date_debut', 'date_fin',
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
