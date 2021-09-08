<?php

namespace App\Models;

use App\Models\User;
use App\Models\Role_User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'libelle'
    ];
    public $timestamps = false;

    public function roleUserId()
    {
        return $this->hasMany(User::class);
    }
}
