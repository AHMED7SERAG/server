<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;
class CityController extends Controller
{
    use GeneralTrait;
    //  return All cities
    public function getAllCities()
    {
        $cities=City::selection()->get();
        return $this->returnData('cities',$cities,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
        try{
          
            $rules = [
                'name' =>"required",
                'location' => 'required|string|max:255'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $city= City::create([
            'name' => $request->get('name'),
            'location' => $request->get('location'),
           ]);
            return $this->returnData('city',$city,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
           
            $city =City::find($request->id);
            if(!$city){
              return $this->returnError('001',"عفوا لا توجد هذه المدينه   ");
            }
           $city->update($request->except(['id','_token']));
            return $this->returnData('city',$city,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            
           
            
            try{
                $city =City::find( $request->id);
                if(!$city){
                    return $this->returnError('001',"عفوا لا توجد هذه المدينه ");
                }
                $city->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
