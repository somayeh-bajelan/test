<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable , HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * Returns all users base on current level of user ,
     * @return array
     */
    public static function getAllAccessibleUsers(): array
    {
        if(Auth::user()->hasAnyPermission(['create task for all', 'edit task for all'] ))
        {
            return User::get()->Pluck('email', 'id')->toArray();
        }
        else
        {
            return [Auth::user()->id =>Auth::user()->email ];
        }
    }
}
