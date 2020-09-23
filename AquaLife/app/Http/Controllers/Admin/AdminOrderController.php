<?php
// Created by: Yhoan Alejandro Guzman

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
Use Exception;
use App\Models\Order;
use App\Models\AccessoryOrder;
use App\Models\FishOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if(Auth::user()->getRole()=="Customer"){
                return redirect()->route('home.index');
            }
            return $next($request);
        });
    }

    public function show($id)
    {
        $data = []; //to be sent to the view
        
        try{
            $order = Order::findOrFail($id);
        }catch(Exception $e){
            return redirect()->route('home.index');
        }
        $accessories = $order->accessories()->get();
        $fish = $order->fish()->get();
        $data["title"] = __('order_update.title').' '.$order->getId();
        $data["order"] = $order;
        $data["accessories"] = $accessories;
        $data["fish"] = $fish;
        return view('admin.order.show')->with("data",$data);
    }

    public function list()
    {
        $data = []; //to be sent to the view
        $data["title"] =  __('order_list.title');
        $data["order"] = Order::orderBy('created_at')->get();

        return view('admin.order.list')->with("data",$data);

    }

    public function listByStatus($value)
    {
        $data = [];
        $data["title"] =  __('order_list.title');
        $data["order"] = Order::orderBy('created_at')->where('status', $value)->get();

        return view('admin.order.list')->with("data",$data);
    }
    public function update(Request $request)
    {
        $data = [];
        $data["title"] = __('order_update.title');

        try{
            $order = Order::findOrFail($request->input('id'));
        }catch(Exception $e){
            return redirect()->route('admin.order.list');
        }

        $data["order"] = $order;

        return view('admin.order.update')->with("data", $data);
    }

    public function updateSave(Request $request){



        $order = Order::findOrFail($request->input('id'));

        Order::validate($request);
        if($order->getStatus() != $request->input('status')){
            $order->setStatus($request->input('status'));
        }

        $order->save();

        if($request->input('status') == "Canceled"){
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
        }

        return redirect()->route('admin.order.list')->with('success', __('order_update.succesful'));

    }

}