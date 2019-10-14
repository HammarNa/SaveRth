<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;
use App\AssociationUserAction;

use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AssociationUserActionResource;

class AssociationUserActionController extends Controller
{
    /**
     * 
     * API Securisation
     */
    public function __construct()
    {
      $this->middleware('auth:api');
    }


    public function newParticipation(Request $request, $id)
    {
        $association = AssociationUserAction::firstOrCreate(
            [ 
                'user_id' => Auth::user()->id,
                'action_id' => $request->action_id,
            ]    
            );
                return new AssociationUserActionResource($association);
    }
}
