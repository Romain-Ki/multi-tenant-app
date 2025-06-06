<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class Mutuelles extends Authenticatable
{
    use HasFactory;

    protected $table = 'mutuelles';

    public $incrementing = false;

    protected $keyType = 'string'; // UUID

//    protected $fillable = ['id','nom', 'email_contact'];
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

    public function findOrFail($id)
    {
        return $this->hasOne('App\Models\Mutuelles', 'id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
