<?php
// Created by: Yhoan Alejandro Guzman

namespace App\Http\Controllers\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CustomerOrderController extends Controller
{
    public function show($id)
    {
        $data = []; //to be sent to the view
        
        try{
            $order = Order::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return redirect()->route('home.index');
        }

        $accessories = $order->accessories()->select('accessory_orders.*', 'accessories.name', 'accessories.price')->join('accessories',  'accessory_orders.accessory_id', '=', 'accessories.id')->get();
        $fish = $order->fish()->select('fish_orders.*', 'fish.name', 'fish.price')->join('fish',  'fish_orders.fish_id', '=', 'fish.id')->get();
        $data["title"] = __('order_show.update').' '.$order->getId();
        $data["order"] = $order;
        $data["accessories"] = $accessories;
        $data["fish"] = $fish;
        //dd($fish);
        return view('customer.order.show')->with("data",$data);
    }

    public function list()
    {
        $data = []; //to be sent to the view
        $data["title"] =  __('order_list.title');
        $data["order"] = order::orderBy('id')->get();

        return view('customer.order.list')->with("data",$data);

    }


    public function cancel(Request $request){
        $order = Order::findOrFail($request->input('id'));
        $order->setStatus('Canceled');
        $order->save();

        $accessory_orders = $order->accessories;
        
        foreach($accessory_orders as $accessory_order){
            $accessory = $accessory_order->accessory;
            $accessory->setInStock($accessory->getInStock() + $accessory_order->getQuantity());
            $accessory->save();
        }

        $fish_orders = $order->fish;

        foreach($fish_orders as $fish_order){
            $fish = $fish_order->fish;
            $fish->setInStock($fish->getInStock() + $fish_order->getQuantity());
            $fish->save();
        }

        return redirect()->route('customer.order.list')->with('success', __('order_update.cancel_succesful'));

    }

}