<?php

namespace App\Repository;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Http\Request;

interface UserRepositoryInterface
{
    /**
     * Create | Update user
     *
     * @param   \App\Http\Requests\StoreUserRequest    $request
     *
     * @method  POST    api/auth/register       For Create
     * @access  public
     */
    public function storeUser(StoreUserRequest $request);

    public function createAuthToken($model);

    public function loginUser(LoginUserRequest $request);
}
