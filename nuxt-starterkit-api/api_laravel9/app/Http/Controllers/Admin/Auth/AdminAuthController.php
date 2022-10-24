<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AdminAuthController extends Controller
{

    // Login endpoint
    public function login(Request $request)
    {
        $authService = new AuthService('admin');
        return $authService->login($request);
    }

    // Logout endpoint
    public function logout()
    {
        $authService = new AuthService('admin');
        return $authService->logout();
    }

    // User endpoint
    // Returns currently authenticated admin account
    public function account()
    {
        $auth = new AuthService('admin');
        return $auth->account();
    }
}
