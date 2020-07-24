<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Validator;
class CategoryController extends Controller
{  use GeneralTrait;
    //  return All Categories
    public function getAllCategories()
    {
        $categories=Category::selection()->get();
        return $this->returnData('categories',$categories,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
       
        try{
          
            $rules = [
                'name' =>"required",
                'icon' => 'mimes:jpeg,bmp,png',
                'details' =>'required|max:255'
            ];
            $file_path="";
            if($request->has('icon')){
                $file_path=saveImage('categories',$request->icon);
            }
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $category= Category::create([
            'name' => $request->get('name'),
            'icon' =>$file_path,
            'details' => $request->get('details'),
           ]);
            return $this->returnData('category',$category,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $category =Category::find($request->id);
            if(!$category){
              return $this->returnError('001',"عفوا لا توجد هذه الفئة   ");
            }
            $file_path=$category->icon;
            if($request->has('icon')){
                $file_path=saveImage('categories',$request->icon);
            }
            if(!$request->has('name')){
                $request->request->add(['name'=>$category->name]);
            }
            if(!$request->has('details')){
                $request->request->add(['details'=>$category->details]);
            }

           $category->update([
               'name' => $request->name,
               'details' => $request->details,
               'icon' =>$file_path,
           ]);
            return $this->returnData('category',$category,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            try{
                $category =Category::find( $request->id);
                if(!$category){
                    return $this->returnError('001',"عفوا لا توجد هذه الفئة ");
                }
                $category->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
