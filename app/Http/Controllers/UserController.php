<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create(array_merge(
            $request->only('name', 'email'),
            ['password' => bcrypt($request->get('password'))]
        ));
        $token = JWTAuth::fromUser($user);

        $response = new \stdClass();
        $response->user = $user;
        $response->token = $token;

        return $this->sendResponse(200, $response, null);
    }

    /**
     * @param LoginRequest $request
     * @return mixed
     */
    public function login(LoginRequest $request)
    {
        if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {

            return $this->sendResponse(400, null, ['error' => 'Invalid Credentials Provided.'], 400);
        }

        $response = new \stdClass();
        $response->token = $token;

        return $this->sendResponse(200, $response, null);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws JWTException
     */
    public function show()
    {
        return response()->json(JWTAuth::parseToken()->authenticate());
    }
}
