<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
        * @OA\Post(
        * path="/api/login",
        * operationId="authLogin",
        * tags={"Auth"},
        * summary="User Login",
        * description="Login User Here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"email", "password"},
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="password", type="password")
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Login Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
    */

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $token = Auth::attempt($credentials);
        if (!$token) {
            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }

        $response['user'] = Auth::user();
        $response['authorization']['token'] = $token;
        $response['authorization']['type'] = 'bearer';

        return $this->sendResponse($response, 'User login successfully.');
    }

     /**
        * @OA\Post(
        * path="/api/register",
        * operationId="Register",
        * tags={"Auth"},
        * summary="User Register",
        * description="User Register here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"name","email","password"},
        *               @OA\Property(property="name", type="text"),
        *               @OA\Property(property="email", type="email"),
        *               @OA\Property(property="password", type="password"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Register Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
    */

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        if(!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user = User::create($data);
        $token = Auth::login($user);

        $response['user'] = $user;
        $response['authorization']['token'] = $token;
        $response['authorization']['type'] = 'bearer';

        return $this->sendResponse($response, 'User created successfully.');
    }

    /**
        * @OA\Post(
        * path="/api/logout",
        * operationId="Logout",
        * tags={"Auth"},
        * security={{"jwt":{}}},
        * summary="Logout",
        * description="Logout",
        *      @OA\Response(
        *          response=201,
        *          description="Logout Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Logout Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
    */

    public function logout()
    {
        Auth::logout();
        return $this->sendResponse([], 'Successfully logged out.');
    }

     /**
        * @OA\Post(
        * path="/api/refresh",
        * operationId="Refresh Token",
        * tags={"Auth"},
        * security={{"jwt":{}}},
        * summary="Refresh Token",
        * description="Refresh Token",
        *      @OA\Response(
        *          response=201,
        *          description="Refresh Token Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Refresh Token Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
    */

    public function refresh()
    {
        $response['user'] = Auth::user();
        $response['authorization']['token'] = Auth::refresh();
        $response['authorization']['type'] = 'bearer';

        return $this->sendResponse($response, '');
    }
}
