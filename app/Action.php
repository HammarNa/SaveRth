<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Resources\AssociationUserActionResource;

class Action extends Model
{

    protected $fillable = [
        'name', 'description', 'address', 'user_id'
    ];

    /**
     * The author (initiator) of the Action
     * 
     * @return User
     */
public function initiator()
{
    return $this->belongsTo('App\User', 'user_id', 'id');
}
    /**
     *  The function that return the participants to the action
     * 
     * @return users
     */
public function participants()
{
    $participants = DB::table('association_user_actions')->where('action_id', $this->id)->get();

    return $participants;
}
}
