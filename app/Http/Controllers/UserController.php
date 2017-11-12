<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use JWTAuth;
use App\User;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $field = filter_var($request->usernameOrEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = $request->only($field, 'password');

        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            // something went wrong whilst attempting to encode the token
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        // all good so return the token
        return response()->json(compact('token'));
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        // the token is valid and we have found the user via the sub claim
        return response()->json(compact('user'));
    }

    public function RegisterUser(Request $request) {

        try {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->noHP = $request->noHP;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['code'=>'SUCCESS','message'=>'register success','content'=>null]);
        } catch (QueryException $exception) {
            return response()->json(['code'=>'FAILED','message'=>'User already exist']);
        }
    }

    public function logout() {
        try{
            JWTAuth::invalidate(JWTAuth::getToken());
            return 'ok';
        } catch (JWTException $exceptione) {
            return response()->json(['token_absent'], $exceptione->getStatusCode());
        }

    }
}
