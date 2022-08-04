<?php

namespace App\Http\Controllers;

use App\Http\RequestHandlers\LoginRequestHandler;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'email' => 'required|email',
                'role' => 'required|string',
                'password' => 'required',
            ]);

            $user = new User;
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->role = $request['role'];
            $user->password = bcrypt($request['password']);
            DB::transaction(function () use ($user) {
                $user->save();
            });
            return response()->json(['message' => 'User registered succesfully', $user], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }

    public function login(LoginRequestHandler $request)
    {
        try {
            $login = $request->validated();
            if (!Auth::attempt($login)) {
                return response()->json(['message' => 'Unauthorized user..!', 'status' => 401]);
            }
            $accessToken = $request->user()->createToken('Auth Token')->accessToken;
            $user = Auth::user();
            $user->roles;
            $data = [
                'user' => $user,
                'access_token' => $accessToken];
            return response()->json(['message' => 'Login success', $data], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }

    public function logout(Request $request)
    {
        try {
            $token = $request->user()->token();
            $token->revoke();
            return response()->json(['message' => 'User has been Logout..!'], 200);
        } catch (Exception $exception) {
            return response()->json(['message' => 'Something went wrong!', $exception]);
        }
    }

}
