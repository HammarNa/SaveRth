<?php

namespace App\Http\Controllers;

use App\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ActionResource;

class ActionController extends Controller
{

    public function __construct()
    {
      $this->middleware('jwt.verify')->except(['index', 'show']);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ActionResource::collection(Action::paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $action = Action::firstOrCreate(
            [
                'name' => $request->name,
                'user_id' => Auth::user()->id,
            ],
            [
                'description' => $request->description,
                'address' => $request->address,
            ],
        );
            return new ActionResource ($action);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            return new ActionResource (Action::find($id));
        }else{
            abort(404 , 'resource not found.');
            
        }
     
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //check if currentUser is the creator of the action
        $action = Action::find($id);
        if( Auth::user()->id !== $action->user_id){
            return response()->json(['error' => 'You can only edit your own actions.'], 403);
        }else {
            $action->update($request->only(['name','description','address']));
            return new ActionResource ($action);
        }
      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
         $action = Action::find($id)->first();
        if($action->user_id !== Auth::user()->id){
            return reponse()->json(['error' => 'You can only edit your own actions.'], 403);
        }else {
            $action = Action::find($id)->first();
            $action->delete();
            return response()->json(null,204);
        }
        
    }
}
