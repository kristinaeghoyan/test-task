<?php

namespace App\Http\Controllers\Api;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ApiController;
use Illuminate\Validation\Validator;
use function MongoDB\BSON\toJSON;

class AuthController extends ApiController
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
         $rules = [
                'email' => 'required|string|email',
                'password' => 'required|string',
                'remember_me' => 'boolean'
            ];

            $validator = \Illuminate\Support\Facades\Validator::make($request->all(), $rules);

            if ($validator->fails()) {
               return $this->errorResponse('Credentials Error', $validator->messages(),  400);
            }


            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return $this->errorResponse('Invalid Credentials', null, 400);
            }

            $user = $request->user();
            $tokenResult = $user->createToken('Personal Access Token');
            $token = $tokenResult->token;

            if ($request->remember_me)
                $token->expires_at = Carbon::now()->addWeeks(1);
            $token->save();

            return $this->successResponse([
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);

    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }


}

