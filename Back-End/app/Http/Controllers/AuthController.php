<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

use App\Traits\LoginTimer;

use App\Models\UserRoleGroup;
use App\Models\RoleGroup;


class AuthController extends Controller
{
    use LoginTimer;

    public function __construct()
    {
        $this->middleware('auth:sanctum')->only('logout');
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            //'phonenumber' => 'required',
        ]);

        $user = User::create([
            'firstname' => $fields['firstname'],
            'lastname' => $fields['lastname'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password']),
            //'phonenumber' => $fields['phonenumber'],
            //'birthday' => $fields['birthday']
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];


        $rolegroup = RoleGroup::where('adjictive' , 'LIKE' , 'user')->first();

        $userrolegroup = new UserRoleGroup;
        $userrolegroup->rolegroupid = $rolegroup->id;
        $userrolegroup->userid = $user->id;
        $userrolegroup->save();

        return response($response, 201);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        $this->UserTimerStore($user->id, $user->firstname. ' ' . $user->lastname . 'Login started');

        return response($response, 201);
    }

    public function logout(Request $request) {

        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
