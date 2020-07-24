<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;
class BankController extends Controller
{
    use GeneralTrait;
    //  return All cities
    public function getAllBanks()
    {
        $banks=Bank::with('admin')->selection()->get();
        return $this->returnData('banks',$banks,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
        try{
          
            $rules = [
                'name' =>"required",
                'iban' => 'required|string|max:255'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $bank= Bank::create([
            'name' => $request->get('name'),
            'iban' => $request->get('iban'),
            'admin_id' => $request->get('admin_id')
           ]);
            return $this->returnData('bank',$bank,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
           
            $bank =Bank::find($request->id);
            if(!$bank){
              return $this->returnError('001',"عفوا لا توجد معلومات  لهذا البنك");
            }
           $bank->update($request->except(['id','_token']));
            return $this->returnData('city',$bank,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            
           
            
            try{
                $bank =Bank::find( $request->id);
                if(!$bank){
                    return $this->returnError('001',"عفوا لا توجد معلومات  لهذا البنك");
                }
                $bank->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
