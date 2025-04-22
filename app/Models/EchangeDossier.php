<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EchangeDossier extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'demande_id', 'auteur', 'message',
        'piece_jointe_path', 'piece_jointe_encrypted', 'date_echange',
    ];

    public function demande()
    {
        return $this->belongsTo(DemandeRemboursement::class, 'demande_id');
    }
}
