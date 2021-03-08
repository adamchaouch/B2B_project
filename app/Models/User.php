<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Model implements AuthenticatableContract, AuthorizableContract,JWTSubject
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'first_name', 'last_name'
    ];


    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'pivot'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */


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
        return [
            'first_name'      => $this->first_name,
            'last_name'       => $this->last_name,
            'email'           => $this->email,
            'contact'         => $this->contact,
            'confirmed'       => $this->confirmed,
        ];
    }


    public function productBase()
    {
        return $this->hasMany(Product_base::class, 'supplier_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function product_images() {
        return $this->hasMany(product_Images::class, 'user_id');
    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {
        // var_dump($this->role()->where('name', $role)->first());
        if ($this->role()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }




    public static $createRules = [
        'email' => 'required|unique:users|max:255',
        'password' => 'required|min:8',
    ];

}
