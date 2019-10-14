<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Action;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

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
     * The fonction that return actions lunched by thisUser
     * 
     * @return actions
     */
    public function initiatedActions()
    {
        return $this->hasMany('App\Action' , 'user_id' , 'id');
    }

    /**
     *  The function that return the actions the user participate on
     * 
     * @return actions
     */
    public function actionsParticipated()
    {
        $actions = DB::table('association_user_actions')->where('user_id', $this->id);

        return $actions;
    }

    /**
     * The JWT's functions 
     * 
     */

    public function getJWTIdentifier()
    {
      return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
      return [];
    }
}
