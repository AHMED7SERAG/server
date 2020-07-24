<?php

namespace  App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
 
    public function broker()
    {
        return Password::broker('admins');
    }
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message'=> trans($response)],200);
    }

  
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response(['error'=>trans( $response)],442);
    }
}
