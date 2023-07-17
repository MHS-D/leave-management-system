<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\AuthService;
use Exception;
use JavaScript;

class AuthController extends Controller
{

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function loginView()
    {
        return view('auth::views.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->checkUserCredentials($request->only('username', 'password'), $request->boolean('remember'));

            throw_if(!$user, new Exception(__('auth.failed')));

            session()->put('role', $user->role);

            return $this->authService->redirectAfterAuthentication($user);
        } catch (Exception $e) {
            throw $e;
        }
    }


    public function logout()
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}
