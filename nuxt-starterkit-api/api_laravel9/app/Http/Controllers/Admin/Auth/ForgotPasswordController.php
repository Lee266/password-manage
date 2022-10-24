<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use App\Models\PasswordReset;
use App\Models\Admin;
use App\Mail\Admin\ForgotPassword;

use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
     /**
     * Send mail has link reset mail.
     *
     * @return response
     */
    protected function sendResetLinkResponse(Request $request)
    {
        // Get credentials
        $credentials = $request->only('email');
        $validator = Validator::make($credentials, [
            'email' => "required|email"
        ]);

        if ($validator->fails()) {
            return errorResponse($validator->errors()->all());
        }

        // Check email registered
        $checkEmail = Admin::where('email', $request->email)->first();
        if (!$checkEmail) {
            return errorResponse('Email is not registered', 422);
        }
        
        // Generate token
        $token = $this->createToken();
        
        PasswordReset::insert([
            'email' => $request->email, 
            'token' => $token, 
            'created_at' => Carbon::now()
        ]);

        // Send mail for link reset mail
        $getOrigins = env('CORS_ALLOWED_ORIGINS');
        $getAdminHost = explode(',', $getOrigins)[1]; // Get admin domain host 
        $mailData = [
            'reset_link' => $getAdminHost.'/password/confirm?token=' . $token
        ];
        $sendMail = Mail::to($request->email)->send(new ForgotPassword($mailData));

        if($sendMail){
            $message = "Email reset password send successfully";
        }else{
            $message = "Email could not be sent to this email address";
        }

        return successResponse($message);
    }

     /**
     * Create token
     *
     * @return string
     */
    private function createToken()
    {
        return base64_encode(serialize([
            'token' => hash('sha256', Str::random(40)),
        ]));
    }
}
