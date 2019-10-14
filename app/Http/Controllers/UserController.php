<?php

namespace App\Http\Controllers;


use App\User;
use Illuminate\Http\Request;


use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // complete the securisation with role middleware
    public function __construct()
    {
        $this->middleware('jwt.verify')->except(['index', 'show', 'deleteCurrentUser' , 'update']);
    }
   


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
    
        return UserResource::collection(User::paginate(5));

    }

    /**
     * Store a newly created user with higner privilege in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::Create(
            [
                'name' => $request->name,
                'password' => $request->password,
                'email' => $request->email, 
            ]
        );
            return new UserResource ($user);       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource (User::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name','password', 'email']));
        return new UserResource ($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //only for admin. Must Create User's roles
            $user = User::find($id);
            $user->delete();
            return response()->json(null,204);
    }

    /**
     * Delete currentUser Account
     * 
     * @return \Illuminqte\http\Response
     */
    public function deleteCurrentUser(){
       
        $user =Auth::user();
        $user->delete();
        return response()->json(null,204);
    }
}
