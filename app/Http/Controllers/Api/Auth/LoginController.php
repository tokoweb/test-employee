<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Validations\Api\Auth\LoginValidation;
use App\Services\Api\Auth\LoginService;

class LoginController extends Controller
{
    /**
     * Validation instance.
     *
     * @var \App\Validations\Api\Auth\LoginValidation
     */
    protected $loginValidation;

    /**
     * Service instance.
     *
     * @var \App\Services\Api\Auth\LoginService
     */
    protected $loginService;

    /**
     * Create a new service instance.
     *
     * @return void
     */
    public function __construct(LoginValidation $loginValidation, LoginService $loginService)
    {
        $this->loginValidation = $loginValidation;
        $this->loginService = $loginService;
    }

    /**
     * Index.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validation = $this->loginValidation->index($request);

        if (!$validation->status) {
            return $this->sendResponse($validation);
        }

        $result = $this->loginService->index($request);

        return $this->sendResponse($result);
    }

    /**
     * Logout.
     *
     * @param  \App\Http\Requests\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $result = $this->loginService->logout($request);

        return $this->sendResponse($result);
    }
}
