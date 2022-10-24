<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Traits\LogActivityTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    use LogActivityTrait;

    // The default authentication guard
    public $guard = 'user';

    public function __construct($guard)
    {
        $this->guard = $guard;
    }

    // Handle login
    public function login(Request $request)
    {
        // Default response
        $response = new \stdClass;
        $response->authenticated = false;

        // If the request specifies locale, set the app locale
        if (!empty($request->locale)) {
            App::setLocale($request->locale);
        }

        // Take only email and password
        $credentials = $request->only('email', 'password');

        // Validate the credentials
        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required',
        ]);

        // If validation fails
        if ($validator->fails()) {
            $errors = $validator->errors();
            $response->errors = $errors->all();
            return response()->json($response, 422);
        }

        // Remember me option
        $remember = $request->remember ?? false;

        // Do the login attempt, return 401 when unauthenticated
        $loginAttempt = Auth::guard($this->guard)->attempt($credentials, $remember);
        if (!$loginAttempt) {
            $this->saveLog('User login failed', 'Email = ' . $request->email . ', Password = ' . $request->password);
            return response()->json($response, 401);
        }

        // Default response on success
        $response->authenticated = true;
        
        if( $this->guard == 'admin' ){
            $user = Auth::guard('admin')->user();
            $this->saveLog('User login succeed', 'Email = ' . $user->email . ', User Name = ' . $user->name, $user->id);
        }

        return response()->json($response, 200);
    }

    // Handle logout
    public function logout()
    {
        Auth::guard($this->guard)->logout();
    }

    public function account()
    {
        return Auth::guard($this->guard)->user();
    }
}
