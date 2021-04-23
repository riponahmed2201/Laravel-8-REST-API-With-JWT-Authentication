<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return response()->json([
            "success" => true,
            "message" => 'Display a listing of the resource.',
            "data" => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
       $validator = Validator::make($request->all(),[
        'name' => 'required|string',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6',
       ]);

       if($validator->fails()){
            return response()->json([
                "success" => false,
                "errors"=>$validator->errors()
            ],401);
       }

       try {
        $user = User::create([
                'name'=> $request->name,
                'email'=> $request->email,
                'password'=> Hash::make($request->password),
            ]);

            return response()->json([
                "data" => $user,
                "success" => true,
                "errors"=>"User created successfully."
            ],400);

       } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "errors"=>"Somthing wrong"
            ],400);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $user = User::find($id);

        return response()->json([
            "message" => 'Display the specified resource.',
            "data" => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return User::destroy($id);
        $user =  User::find($id)->delete();
        return response()->json([
            "message" => 'Remove the specified resource from storage.',
            "data" => $user
        ]);
    }
}
