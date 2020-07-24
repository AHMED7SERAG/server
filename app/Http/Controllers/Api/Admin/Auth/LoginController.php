<?php

namespace App\Http\Controllers\Api\Admin\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
class LoginController extends Controller
{
   use GeneralTrait;

   public function __construct()
    {
        $this->middleware('auth:admins', ['except' => ['login']]);
    }
   public function login(Request $request)
        {
            
            $credentials = $request->only('email', 'password');

            try {
              
                $rules = [

                "password" => "required",
                "email" => "required|exists:admins,email"
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
               
                //login
                if($token = auth()->guard('admins')->attempt($credentials)){
                    $admin=Admin::where('email',$request->email)->get();
                    return $this->returnSuccessMessage("تم تسجيل الدخول بنجاح","000",$token);
                  //  return $this->returnData('admin',$admin,"تم تسجيل الدخول بنجاح");
                   
                 }
                 else
                 return $this->returnError("هناك خطأ فى البيانات" ,"001");
            }catch (\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());
            }
    
        }
        public function logout()
        {
            auth()->logout();
            return $this->returnSuccessMessage( '000','تم تسجيل الخروج بنجاح');
        }
    public function me()
    {
        
        return response()->json(auth()->user());
    
    }

}
