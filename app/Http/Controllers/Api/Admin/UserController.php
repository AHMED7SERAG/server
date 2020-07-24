<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use App\User;
use Validator;
class UserController extends Controller
{
    
    use GeneralTrait;
    //  return All salons
    public function getAllUsers()
    {
        $users=User::selection()->get();
        
        return $this->returnData('users',$users,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
       
        try{
          
            $rules = [
                'name'       =>"required|max:255|min:3",
                'password'    => 'required|string|min:8',
                 'username'   => 'required|string|max:255|unique:users',
                 'email'      => 'required|string|email|max:255|unique:users',
                 'mobile'      => 'required|unique:users',
            ];
           
            $validator = Validator::make($request->all(), $rules);
           
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $user= User::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'mobile' => $request->get('mobile'),
           
           ]);
            return $this->returnData('user',$user,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $user =User::find($request->id);
            if(!$user){
              return $this->returnError('001',"عفوا لا توجد هذا الصالون ");
            }
            
                $rules = [
                    'name'       =>"string|max:255|min:3",
                    'password'    => 'string|min:8',
                     'username'   => 'string|max:255|unique:users',
                     'email'      => 'string|email|max:255|unique:users',
                     'mobile'      => 'unique:users',
                ];
               
                $validator = Validator::make($request->all(), $rules);
               
                if ($validator->fails()) {
                    $code = $this->returnCodeAccordingToInput($validator);
                    return $this->returnValidationError($code, $validator);
                }
           
                if(!$request->has('name')){
                    $request->request->add(['name'=>$user->name]);
                }
                if(!$request->has('username')){
                    $request->request->add(['username'=>$user->username]);
                }
                if(!$request->has('email')){
                    $request->request->add(['email'=>$user->email]);
                }
            
            if(!$request->has('password')){
                $request->request->add(['password'=>$user->password]);
            }
            if(!$request->has('mobile')){
                $request->request->add(['mobile'=>$user->mobile]);
            }
           
           $user->update([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'mobile' => $request->get('mobile'),
              
           ]);
            return $this->returnData('user',$user,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            try{
                $user =User::find( $request->id);
                if(!$user){
                    return $this->returnError('001'," عفوا لا يوجد هذا المستخدم  ");
                }
                $user->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
