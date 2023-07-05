<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Orders;
use App\Models\Status;
use App\Models\Country;
use App\Models\City;
use App\Models\Drivers;
use App\Models\CarList;
use App\Models\Cars;
use App\Models\PersonalInfo;
use Carbon\Carbon;


use App\Http\Requests\OrderRequest;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $model = Orders::all();

        return view('order.index', [
            'model' => $model
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Orders::find($id);
        
        return view('order.show', [
            'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $model = Orders::findOrfail($id);
        $modelStatus = Status::all();
        $modelCarsList = CarList::all();
        $modelCity = City::where(['country_id' => 234, 'type' => 'city'])->get();

        return view('order.edit', [
            'model' => $model,
            'modelStatus' => $modelStatus,
            'modelCarsList' => $modelCarsList,
            'modelCity' => $modelCity,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrderRequest $request, string $id)
    {
        $data = $request->validated();

        $order = Orders::findOrFail($id);
        $order->update($request->all());
        $order->seats = json_encode($data['seats']);
        $order->save();
        
        return redirect()->route('order.index'); // ->with('updated', translate('Data successfully updated'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Orders::findOrFail($id);
        $order->delete();
        
        return redirect()->route('order.index'); // ->with('updated', translate('Data successfully updated'));
    }


    public function searchTaxi()
    {
        $datetime="03-06-2023";
        $date=Carbon::parse($datetime)->addDays(-2)->format('Y-m-d');
        $dates=[];
        $aa=[];

        for ($i=1; $i <= 5; $i++) {
            $oncedate=Carbon::parse($date)->addDays($i)->format('Y-m-d');
            // dd($oncedate);
            $list=[];
            $orders=Orders::where('start_date',$oncedate)->get();
            // dd($orders);
            foreach ($orders as $order) {
                $personalInfo=PersonalInfo::where('id',Drivers::where('id',$order->driver_id)->first()->personal_info_id)->first();
                // dd($personalInfo);
                $options=[
                    'adwadwadaw'=>true,
                    'efsefsef'=>false,
                    'fesfsefsef'=>true,                       
                 ];
                $data=[
                    'start_date'=>$order->start_date ,
                    'price'=>$order->price,
                    'name'=>$personalInfo->first_name,
                    'avatar'=>$personalInfo->avatar,
                    'options'=>$options
                ];
                // dd($data);
                array_push($list,$data);
            }
            $aa[$oncedate] = $list;
            // $dates[$oncedate]=0;        
        }
       
        dd($aa);

    }

    public function orderShow(Request $request){
        
        // $order_id=$request->order_id;
         $order_id=2;
         $order=Orders::where('id',$order_id)->first();
        //  dd($order);
         $driver=Drivers::where('id',$order->driver_id)->first();
         $car_list=CarList::where('id',$order->cars_list_id)->first();
        //  dd($car_list);
         $car=Cars::where('car_list_id',$car_list->id)->first();
         $driver_information=[
            'name'=>$driver->first_name,
            'avatar'=>$driver->avatar
         ];
         $car_information=[
            'name'=>$car_list->name,
            'avater'=>$car->images

             
         ];
         $list=[
          'price'=>$order->price,
          'price_type'=>$order->price_type,
          'seats'=>$order->seats,
          'driver_information'=>$driver_information,
          'car_information'=>$car_information
         ];
         dd($list);

    }
}
