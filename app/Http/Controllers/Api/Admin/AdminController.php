<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
class AdminController extends Controller
{
    use GeneralTrait;
    //  return All admins
    public function getAdmins()
    {
        $admins=Admin::selection()->get();
        return $this->returnData('admins',$admins,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
        try{
          
            $rules = [
                'username' =>"required",
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'password' => 'required|string|min:6',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $file_path="";
            if($request->has('photo')){
                $file_path=saveImage('admin_photo',$request->photo);
            }
        
           $admin= Admin::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
            'photo' => $file_path,
           ]);
            return $this->returnData('admin',$admin,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
           
            $admin =Admin::find($request->id);
            if(!$admin){
              return $this->returnError('001',"عفوا لايوجد هذا الأدمن");
            }
            $file_path=$admin->photo;
            if($request->has('photo')){
                $file_path=saveImage('admin_photo',$request->photo);
                
            }
            if(!$request->has('name')){
                $request->request->add(['name'=>$admin->name]);
            }
            if(!$request->has('username')){
                $request->request->add(['username'=>$admin->username]);
            }
            if(!$request->has('email')){
                $request->request->add(['email'=>$admin->email]);
            }
            if(!$request->has('password')){
                $request->request->add(['password'=>$admin->password]);
            }
            
           $admin->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
            'photo' => $file_path,
           ]);
            return $this->returnData('admin',$admin,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            
           
            
            try{
                $admin =Admin::find( $request->id);
                if(!$admin){
                    return $this->returnError('001',"عفوا لايوجد هذا الأدمن");
                }
                $admin->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
