<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photos_gallery;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;
class Photos_galleryController extends Controller
{
    
    use GeneralTrait;
    //  return All cities
    public function getAllPhotos()
    {
        $photos=Photos_gallery::selection()->get();
        return $this->returnData('photos',$photos,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
        try{
          
            $rules = [
                'photo'   => 'required|mimes:png,jpg,jpeg',
                'salon_id'     => 'required|exists:salons,id'
            ];
            $file_path="";
            if($request->has('photo')){
                $file_path=saveImage('gallery',$request->photo);
            }
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $photo= Photos_gallery::create([
            'salon_id' => $request->get('salon_id'),
            'photo' => $file_path ,
           ]);
            return $this->returnData('photo',$photo,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
           
            $photo =Photos_gallery::find($request->id);
            
            if(!$photo){
              return $this->returnError('001',"عفوا لا توجد هذه المدينه   ");
            }
            if(!$request->has('salon_id')){
                $request->request->add(['salon_id'=>$photo->salon_id]);
            }
           
            $file_path=$photo->photo;
            if($request->has('photo')){
                $file_path=saveImage('gallery',$request->photo);
            }
           $photo->update([
            'salon_id' => $request->get('salon_id'),
            'photo' => $file_path ,
           ]);
            return $this->returnData('photo',$photo,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            
           
            
            try{
                $photo =Photos_gallery::find( $request->id);
                if(!$photo){
                    return $this->returnError('001',"عفوا لا توجد هذه الصوره ");
                }
                $photo->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
