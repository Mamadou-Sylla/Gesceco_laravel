<?php

namespace App\Models;

use App\Models\User;
use App\Models\Cantine;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory;
    protected $fillable = [
        'numero',
        'montant',
        'date'
    ];
    public $timestamps = false;

    public function UsersFacture()
    {
        return $this->belongsTo(User::class); 
    }

    public function cantines()
    {
        return $this->belongsTo(Cantine::class); 
    }
}
