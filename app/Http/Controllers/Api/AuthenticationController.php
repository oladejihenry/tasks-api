<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\CustomerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
    //Display all the users
    public function index()
    {
        //Get all the users, display it and return status code 200
        $users = User::all();
        return response()->json(['users'=>$users], 200);
    }


    public function register(CustomerRequest $request)
    {
        //Creates new user
        $user = User::create($request->validated());
        //issue a token after loggin in and get the plain text
        $token = $user->createToken('userToken')->plainTextToken;

        //Display all the details of user created with the token
        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
        //Validates the request
        $data = $request->validate([
            'email' => 'required|email|max:191',
            'password' => 'required|string',
        ]);

        
        $user = User::where('email', $data['email'])->first();

        if(!$user || !Hash::check($data['password'], $user->password))
        {
            return response(['message' => 'Invalid Customer Details'], 401);
        }
        else{
            $token = $user->createToken('userTokenLogin')->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token,
            ];

            $user->update(['last_login' => now()]);

            return response($response, 200);
        }
    }

    //This update the authenticated user details
    public function update(CustomerRequest $request, $id)
    {   
        //Find the user with the id and update there details
        $user = User::find($id);

        //check if exists then update there details with status code
        if($user){
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->role_name = $request->role_name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->birthday = $request->birthday;
            $user->tasks = $request->tasks;
            $user->is_notify = $request->is_notify;
            $user->update();

            $user->update(['last_login' => now()]);

            return response()->json(['message'=>'Customer Updated Successfully'], 200); 
        }
        //else return customer not found
        else{
            return response()->json(['message'=>'No Customer Found'], 404); 
        }
    }

    //This logs the autheticated user out and delete the token
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged Out']);
    }
}
