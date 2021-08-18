<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AuthenticationController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json(['users'=>$users], 200);
    }


    public function register(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:191',
            'last_name' =>'required|string|max:191',
            'password' => 'required|string',
            'role_name' => 'required|string',
            'email' => 'required|email|max:191|unique:users,email',
            'mobile' => 'required',
            'birthday' => 'required',
            'tasks' => 'required',
        ]);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($data['password']),
            'role_name'=> $data['role_name'],
            'email'=> $data['email'],
            'mobile'=> $data['mobile'],
            'birthday'=> $data['birthday'],
            'tasks'=> $data['tasks'],
            //'last_login' => Carbon::now()->toDateTimeString()
        ]);

        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return response($response, 201);
    }

    public function login(Request $request)
    {
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
                $token => $token,
            ];

            return response($response, 200);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response(['message' => 'Logged Out']);
    }
}
