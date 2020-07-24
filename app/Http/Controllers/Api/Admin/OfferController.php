<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
class OfferController extends Controller
{
    use GeneralTrait;
    //  return All salons
    public function getAllOffers()
    {
        try{
            $offers=Offer::selection()->get();
            return $this->returnData('offers',$offers,"تم استرجاع البيانات بنجاح");
           }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function store(Request $request)
    {
       
        try{
          
            $rules = [
                'title'       =>"required|max:255|min:3",
                'discount'    => 'required',
                'banner'    => 'mimes:jpeg,bmp,png',
                'service_id'     => 'required|exists:services,id',
                'salon_id'     => 'required|exists:salons,id'
            ];
            $file_path="";
            if($request->has('banner')){
                $file_path=saveImage('offers',$request->banner);
            }
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $offers= Offer::create([
            'title' => $request->get('title'),
            'banner' =>  $file_path,
            'discount' => $request->get('discount'),
            'service_id' => $request->get('service_id'),
            'salon_id' =>$request->get('salon_id'),
           ]);
            return $this->returnData('offers',$offers,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $rules = [
                'title'       =>"max:255|min:3",
                'banner'    => 'mimes:jpeg,bmp,png',
                'service_id'     => 'exists:services,id',
                'salon_id'     => 'exists:salons,id'
            ];
           
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $offer =Offer::find($request->id);
            if(!$offer){
              return $this->returnError('001',"عفوا لا توجد هذا العرض ");
            }
            $file_path=$offer->banner;
            if($request->has('banner')){
                $file_path=saveImage('offers',$request->banner);
            }
            if(!$request->has('discount')){
                $request->request->add(['discount'=>$offer->discount]);
            }
            if(!$request->has('title')){
                $request->request->add(['title'=>$offer->title]);
            }
            if(!$request->has('service_id')){
                $request->request->add(['service_id'=>$offer->service_id]);
            }
            if(!$request->has('salon_id')){
                $request->request->add(['salon_id'=>$offer->salon_id]);
            }
           $offer->update([
            'title' => $request->get('title'),
            'banner' =>  $file_path,
            'discount' => $request->get('discount'),
            'service_id' =>$request->get('service_id'),
            'salon_id' =>$request->get('salon_id'),
              
           ]);
            return $this->returnData('offer',$offer,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            try{
                $offer =Offer::find( $request->id);
                if(!$offer){
                    return $this->returnError('001',"عفوا لا توجد هذه الفئة ");
                }
                $offer->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
