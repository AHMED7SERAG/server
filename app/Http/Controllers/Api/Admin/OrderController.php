<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Validator;
class OrderController extends Controller
{
    use GeneralTrait;
    //  return All cities
    public function getAllOrders()
    {
        $orders=Order::selection()->get();
        return $this->returnData('orders',$orders,"تم استرجاع البيانات بنجاح");
    }
    public function store(Request $request)
    {
        try{
          
            $rules = [
                'title' =>"required",
                'address' => 'string',
                'service_id'     => 'required|exists:services,id',
                'salon_id'     => 'required|exists:salons,id',
                'employee_id'     => 'required|exists:employees,id',
                'type'    => 'in:0,1',
                'payment' =>'in:0,1',
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
           $order= Order::create([
            'title' => $request->get('title'),
            'address' => $request->get('address'),
            'service_id' => $request->get('service_id'),
            'salon_id' => $request->get('salon_id'),
            'employee_id' => $request->get('employee_id'),
            'type' => $request->get('type'),
            'payment' => $request->get('payment'),


           ]);
            return $this->returnData('order',$order,"تم  الحفظ بنجاح");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
      
    }
    public function update(Request $request)
    {
        try{
            $order =Order::find($request->id);
            if(!$order){
              return $this->returnError('001',"عفوا لا توجد بيانات هذا الطلب    ");
            }
            $rules = [
                'title' =>"string",
                'address' => 'string',
                'service_id'     => 'exists:services,id',
                'salon_id'     => 'exists:salons,id',
                'employee_id'     => 'exists:employees,id',
                'type'    => 'in:0,1',
                'payment' =>'in:0,1',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            if(!$request->has('title')){
                $request->request->add(['title'=>$order->title]);
            }
            if(!$request->has('address')){
                $request->request->add(['address'=>$order->address]);
            }
            if(!$request->has('service_id')){
                $request->request->add(['service_id'=>$order->service_id]);
            }
            if(!$request->has('salon_id')){
                $request->request->add(['salon_id'=>$order->salon_id]);
            }
            if(!$request->has('employee_id')){
                $request->request->add(['employee_id'=>$order->employee_id]);
            }
            if(!$request->has('type')){
                $request->request->add(['type'=>$order->type]);
            }
            if(!$request->has('payment')){
                $request->request->add(['payment'=>$order->payment]);
            }
           $order->update([
            'title' => $request->get('title'),
            'address' => $request->get('address'),
            'service_id' => $request->get('service_id'),
            'salon_id' => $request->get('salon_id'),
            'employee_id' => $request->get('employee_id'),
            'type' => $request->get('type'),
            'payment' => $request->get('payment'),

           ]);
            return $this->returnData('order',$order,"تم  تحديث البيانات بنجاح ");
        }catch (\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }
    public function destroy(Request $request)
        {
            
           
            
            try{
                $order =Order::find( $request->id);
                if(!$order){
                    return $this->returnError('001',"عفوا لا توجد بيانات لهذا الطلب ");
                }
                $order->delete();
                  return $this->returnSuccessMessage('000',"تم  الحذف  بنجاح ");
            }
            catch(\Exception $ex){
                return $this->returnError($ex->getCode(), $ex->getMessage());

            }
        }
}
