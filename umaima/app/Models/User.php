<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // In User model (User.php)
        protected $fillable = [
            'fname', 'lname', 'username', 'email', 'password', 'status',
        ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role)
    {
        // Assuming a roles relationship, check for the role
        return $this->roles->contains('name', $role);
    }


    public function roles()
{
return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
}

public function permissions()
{
return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id');
}
}
