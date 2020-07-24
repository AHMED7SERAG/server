<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Traits\GeneralTrait;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Validator;
class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;
    use GeneralTrait; 
    public function reset(Request $request)
    {
       
        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];

        $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        $code = $this->returnCodeAccordingToInput($validator);
        return $this->returnValidationError($code, $validator);
    }
          $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($request, $response)
                    : $this->sendResetFailedResponse($request, $response);
    }

    public function broker()
    {
        return Password::broker('admins');
    }
    
    protected function sendResetResponse(Request $request, $response)
    {
        return response(['message'=> trans($response)],200);
    }

   
    protected function sendResetFailedResponse(Request $request, $response)
    {
        return response(['error'=>trans($response)],442);
    }
}
