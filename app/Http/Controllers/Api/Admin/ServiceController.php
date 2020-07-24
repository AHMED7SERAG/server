<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Service_Catgory;
use App\Models\Service_Salon;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\DB;
use Validator;
class ServiceController extends Controller
{
    use GeneralTrait;
    //  return All salons
    public function getAllServices()
    {
       try{
        $services=Service::with('salons')->selection()->get();
        return $this->returnData('services',$services,"تم استرجاع البيانات بنجاح");
       }catch (\Exception $ex){
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
        
    }
    public function store(Request $request)
    {
       
        try{
          
            $rules = [
                'name'       =>"required|max:255|min:3",
                'details'    => 'required|string|min:8',
                'icon'   => 'required|mimes:png,jpg,jpeg',
                'price'      => 'required|string',
                'home_service' => 'in:0,1',
                'payment'     => 'in:0,1' ,
                'bonus'    => 'required|string',
                'estimated_time'   => 'required|string',
                'booking_before'     => 'in:0,1',
                'category_id'     => 'required|exists:categories,id',
                'salon_id'     => 'required|exists:salons,id'
            ];
            if(!$request->has('payment')){
                $request->request->add(['payment'=>'0']);
            }
            if(!$request->has('booking_before')){
                $request->request->add(['booking_before'=>'0']);
            }
            if(!$request->has('home_service')){
                $request->request->add(['home_service'=>'0']);
            }
            $file_path="";
            if($request->has('icon')){
                $file_path=saveImage('services',$request->icon);
            }
          
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            DB::beginTransaction();

            $serviceId=Service::insertGetId([
                'name' => $request->get('name'),
                'details' => $request->get('details'),
                'icon' => $file_path,
                'price' => $request->get('price'),
                'home_service' => $request->get('home_service'),
                'payment' => $request->get('payment'),
                'bonus' => $request->get('bonus'),
                'estimated_time' => $request->get('estimated_time'),
                'booking_before' => $request->get('booking_before'),
                'category_id' => $request->get('category_id'),
                
           ]);
           Service_Salon::create([
            'salon_id'  => $request->salon_id,
            'service_id' => $serviceId
           ]);
           $service =Service::find($serviceId);
           DB::commit();
            return $this->returnData('service',$service,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            DB::rollback();
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $service =Service::find($request->id);
            $file_path=$service->icon;
            if($request->has('icon')){
                $file_path=saveImage('services',$request->icon);
            }
            if(!$service){
              return $this->returnError('001',"عفوا لا توجد هذا الصالون ");
            }
            if(!$request->has('name')){
                $request->request->add(['name'=>$service->name]);
            }
            if(!$request->has('details')){
                $request->request->add(['details'=>$service->details]);
            }
            if(!$request->has('price')){
                $request->request->add(['price'=>$service->price]);
            }
            if(!$request->has('bonus')){
                $request->request->add(['bonus'=>$service->bonus]);
            }
            if(!$request->has('estimated_time')){
                $request->request->add(['estimated_time'=>$service->estimated_time]);
            }
            if(!$request->has('category_id')){
                $request->request->add(['category_id'=>$service->category_id]);
            }
            if(!$request->has('payment')){
                $request->request->add(['payment'=>$service->payment]);
            }
            if(!$request->has('booking_before')){
                $request->request->add(['booking_before'=>$service->booking_before]);
            }
            if(!$request->has('home_service')){
                $request->request->add(['home_service'=>$service->home_service]);
            }
           $service->update([
            'name' => $request->get('name'),
            'details' => $request->get('details'),
            'icon' => $file_path,
            'price' => $request->get('price'),
            'home_service' => $request->get('home_service'),
            'payment' => $request->get('payment'),
            'bonus' => $request->get('bonus'),
            'estimated_time' => $request->get('estimated_time'),
            'booking_before' => $request->get('booking_before'),
            'category_id' => $request->get('category_id'),
              
           ]);
            return $this->returnData('service',$service,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            try{
                $service =Service::find( $request->id);
                if(!$service){
                    return $this->returnError('001',"عفوا لا توجد هذه الفئة ");
                }
                $service->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
