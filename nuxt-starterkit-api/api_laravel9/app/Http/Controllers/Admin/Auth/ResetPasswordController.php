<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\PasswordReset;

use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    /**
     * Send mail has link reset mail.
     *
     * @return response
     */
    protected function checkTokenExpired(Request $request){
        $token = $request->token;
        if ($token) {
            $checkAdminToken = PasswordReset::where('token', $token)->first();
            $tokenDate = new Carbon($checkAdminToken->created_at);
            $now = Carbon::now();
            $duration = $tokenDate->diffInMinutes($now);
            if ($duration > 60) {
                return errorResponse('token is expired');
            }
            return successResponse($checkAdminToken);
        }
    }

    /**
     * Send reset and confirmation response
     *
     * @return response
     */
    protected function sendResetResponse(Request $request)
    {
        // Get credentials
        $credentials = $request->only(
            'email',
            'token', 
            'password', 
            'confirmPassword'
        );
        
        $validator = Validator::make($credentials, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->all());
        }

        // Change for new password
        $newPassword = [
            'password' => Hash::make($request->password)
        ];

        $updateAdminPassword = Admin::where('email', $request->email)->first();
        $updateAdminPassword->update($newPassword);

        if($updateAdminPassword){
            $message = "Password reset successfully";
            $deleteToken = PasswordReset::where('token', $request->token);
            $deleteToken->delete();
        }else{
            $message = "Password reset failed";
        }
        
        return successResponse($message);
    }
}
