<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class UserAuthController extends Controller
{

    // Login endpoint
    public function login(Request $request)
    {
        $auth = new AuthService('user');
        return $auth->login($request);
    }

    // Logout endpoint
    public function logout()
    {
        $auth = new AuthService('user');
        return $auth->logout();
    }

    // User endpoint
    // Returns currently authenticated user account
    public function account()
    {
        $auth = new AuthService('user');
        return $auth->account();
    }
}
