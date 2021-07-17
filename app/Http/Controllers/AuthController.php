<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Repository\UserRepositoryInterface;
use App\Traits\ApiResponser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 *
 * @unauthenticated
 */
class AuthController extends Controller
{
    use ApiResponser;
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * Register Endpoint.
     *
     * @bodyParam   name    string  required    The name of the  user.      Example: John Doe
     * @bodyParam   email    string  required    The email of the  user.      Example: johndoe@example.com
     * @bodyParam   password    string  required    The password of the  user.   Example: secret
     * @bodyParam   password_confirmation    string  required    The password_confirmation of the  user.   Example: secret
     * @bodyParam   ref_code    string  nullable    The reference code of the  user.   Example: S60F2EC85AFAEF
     *
     * @response 201 {"error":false,"message":"User Created","data":{"token":"19|gyNm065OjWn48CCkSGQpM4KGmR9NLaSRWr9uXUlC","user":{"name":"John Doe","email":"johndoe@example.com","created_at":"2021-07-17 15:49:05"},"wallet":{"amount":0,"currency":"TRY"}}}
     * @response 400 {"error":true,"message":"Reference number not found","data":null}
     * @response 422 {"error":true,"message":"StoreUserRequest validation failed","data":{"email":["The email has already been taken."]}}
     */
    public function register(StoreUserRequest $request)
    {
        return $this->userRepository->storeUser($request);
    }

    /**
     * Login Endpoint.
     *
     * @bodyParam   email    string  required    The email of the  user.      Example: johndoe@example.com
     * @bodyParam   password    string  required    The password of the  user.   Example: secret
     *
     * @response 200 {"error": false,"message": "User logged in","data": {"token": "17|v2G5z7HrbrY1aLmvZnOxBO7pUl1K9KnTUvBpb79f"}}
     * @response 400 {"error":true,"message":"Credentials not match","data":null}
     * @response 400 {"error":true,"message":"StoreUserRequest validation failed","data":{"password":["The password field is required."]}}
     *
     */
    public function login(LoginUserRequest $request)
    {
        return $this->userRepository->loginUser($request);
    }
}
