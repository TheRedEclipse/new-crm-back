<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends BaseModel implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract,
    JWTSubject
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'email',
        'email_signature',
        'password',
        'type_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'updated_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guard_name = 'api';

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->search_fields = [
            'id',
            'name',
            'last_name',
            'email',
        ];
        $this->order_fields = [
            'id',
            'name',
            'created_at',
            'last_joined_at'
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
     public function getJWTIdentifier()
     {
         return $this->getKey();
     }
 
     /**
      * Return a key value array, containing any custom claims to be added to the JWT.
      *
      * @return array
      */
     public function getJWTCustomClaims()
     {
         return [];
     }
}
