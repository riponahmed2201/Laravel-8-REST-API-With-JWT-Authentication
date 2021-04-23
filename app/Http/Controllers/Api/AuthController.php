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
        try {
            $user =  User::findOrFail($id);

            return response()->json([
                'success' => true,
                "message" => 'Display the specified resource.',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                "message" => 'Something wrong.',
            ]);
        }
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

            $user =  User::findOrFail($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                "data" => $user,
                "success" => true,
                "errors"=>"User updated successfully."
            ],200);

       } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "errors"=>"Somthing wrong"
            ],204);
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
        // return User::destroy($id);

        try {
            $user =  User::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                "message" => 'User deleted successfully.',
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                "message" => 'Something wrong.',
            ]);
        }


    }
}
