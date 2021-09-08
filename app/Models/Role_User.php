<?php

namespace App\Models;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role_User extends Model
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $table = 'role_users';
    
    public $timestamps = false;

    public function UsersRole()
    {
        return $this->belongsTo(User::class); 
    }

    public function UsersRoleId()
    {
        return $this->belongsTo(Role::class); 
    }
}
