<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Salon;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
class SalonController extends Controller
{
    use GeneralTrait;
    //  return All salons
    public function getAllSalons()
    {
        $salons=Salon::with('services')->selection()->get();
        
        return $this->returnData('salons',$salons,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
       
        try{
          
            $rules = [
                'name'       =>"required|max:255|min:3",
                'password'    => 'required|string|min:8',
                 'username'   => 'required|string|max:255|unique:salons',
                 'email'      => 'required|string|email|max:255|unique:salons',
                 'logo'      => 'required|mimes:png,jpg,jpeg',
                 'home_service' => 'in:0,1',
                  'payment'     => 'in:0,1' ,
                  'Latitude'    => 'required|string',
                  'Longitude'   => 'required|string',
                  'booking'     => 'required|in:0,1',
                  'city_id'     => 'required|exists:cities,id'
            ];
            if(!$request->has('payment')){
                $request->request->add(['payment'=>'0']);
            }
            if(!$request->has('booking')){
                $request->request->add(['booking'=>'0']);
            }
            if(!$request->has('home_service')){
                $request->request->add(['home_service'=>'0']);
            }
            $file_path="";
            if($request->has('logo')){
                $file_path=saveImage('salons',$request->logo);
            }
           
            $validator = Validator::make($request->all(), $rules);
           
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $salons= Salon::create([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'home_service' => $request->get('home_service'),
            'payment' => $request->get('payment'),
            'Latitude' => $request->get('Latitude'),
            'Longitude' => $request->get('Longitude'),
            'booking' => $request->get('booking'),
            'logo' => $file_path,
            'city_id' => $request->get('city_id'),
           ]);
            return $this->returnData('salons',$salons,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $salon =Salon::find($request->id);
            if(!$salon){
              return $this->returnError('001',"عفوا لا توجد هذا الصالون ");
            }
            if(!$request->has('name')){
                $request->request->add(['name'=>$salon->name]);
            }
            if(!$request->has('username')){
                $request->request->add(['username'=>$salon->username]);
            }
            if(!$request->has('email')){
                $request->request->add(['email'=>$salon->email]);
            }
            if(!$request->has('Longitude')){
                $request->request->add(['Longitude'=>$salon->Longitude]);
            }
            if(!$request->has('Latitude')){
                $request->request->add(['Latitude'=>$salon->Latitude]);
            }
            if(!$request->has('city_id')){
                $request->request->add(['city_id'=>$salon->city_id]);
            }
            if(!$request->has('payment')){
                $request->request->add(['payment'=>$salon->payment]);
            }
            if(!$request->has('booking')){
                $request->request->add(['booking'=>$salon->booking]);
            }
            if(!$request->has('home_service')){
                $request->request->add(['home_service'=>$salon->home_service]);
            }
            $file_path=$salon->logo;
            if($request->has('logo')){
                $file_path=saveImage('salons',$request->logo);
            }
           $salon->update([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'home_service' => $request->get('home_service'),
            'payment' => $request->get('payment'),
            'Latitude' => $request->get('Latitude'),
            'Longitude' => $request->get('Longitude'),
            'booking' => $request->get('booking'),
            'logo' => $file_path,
            'city_id' => $request->get('city_id'),
              
           ]);
            return $this->returnData('salon',$salon,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            try{
                $salon =Salon::find( $request->id);
                if(!$salon){
                    return $this->returnError('001',"عفوا لا توجد هذه الفئة ");
                }
                $salon->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
