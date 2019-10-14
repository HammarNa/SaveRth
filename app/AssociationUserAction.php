<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssociationUserAction extends Model
{
    protected $fillable = [
        'action_id', 'user_id'
    ];
}


