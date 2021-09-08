<?php

namespace App\Models;

use App\Models\User;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cantine extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'batiment'
    ];
    public $timestamps = false;

    public function users()
    {
        return $this->belongsTo(User::class); 
    }

    public function factures()
    {
        return $this->hasMany(Facture::class);
    }
}
