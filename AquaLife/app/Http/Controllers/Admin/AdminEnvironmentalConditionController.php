<?php
// Created by: Daniel Felipe Gomez Martinez

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnvironmentalCondition;
use App\Models\Fish;
Use Exception;
use Illuminate\Http\Request;

class AdminEnvironmentalConditionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            return $next($request);
        });
    }

    public function create()
    {
        $data = []; 
        $data["title"] = __('environmentalCondition_create.title');
        $data["environmental_condition"] = EnvironmentalCondition::all();
        $data["fish"] = Fish::all();

        return view('admin.environmentalCondition.create')->with("data",$data);

    }

    public function save(Request $request)
    {
         EnvironmentalCondition::validate($request);

        try{
            $newEnvironmentalCondition = new EnvironmentalCondition();
            $newEnvironmentalCondition->setPhLR($request->input('ph_lr'));
            $newEnvironmentalCondition->setPhHR($request->input('ph_hr'));
            $newEnvironmentalCondition->setTemperatureLR($request->input('temperature_lr'));
            $newEnvironmentalCondition->setTemperatureHR($request->input('temperature_hr'));
            $newEnvironmentalCondition->setHardnessLR($request->input('hardness_lr'));
            $newEnvironmentalCondition->setHardnessHR($request->input('hardness_hr'));
            $newEnvironmentalCondition->setFishId($request->input('fish_id'));
            $newEnvironmentalCondition->save();
        }catch(Exception $e){
            return back()->with('fail', __('environmentalCondition_create.fail'));
        }
         
         return back()->with('success', __('environmentalCondition_create.succesful'));
    }

    public function show($id)
    {
        $data = []; 
        
        try{
            $environmental_condition = EnvironmentalCondition::findOrFail($id);
            $fish = Fish::where("id",$environmental_condition->getFishId())->select('name')->get();
            $fishName = $fish->pluck('name')->get(0);
            
        }catch(Exception $e){
            return redirect()->route('home.index');
        }
        
        $data["title"] =  __('environmentalCondition_show.title');;
        $data["environmental_condition"] = $environmental_condition;
        $data["fish_name"] = $fishName;
        return view('admin.environmentalCondition.show')->with("data",$data);
    }

    public function delete(Request $request){
        $environmental_condition = EnvironmentalCondition::find($request['id']);
        $environmental_condition->delete();
        return redirect()->route('admin.environmentalCondition.list');
    }

    public function list()
    {
        $data = []; //to be sent to the view
        $data["title"] =  __('environmentalCondition_list.title');
        $data["environmental_condition"] = EnvironmentalCondition::orderBy('id')->get();

        return view('admin.environmentalCondition.list')->with("data",$data);
    }

    public function update(Request $request)
    {
        $data = [];
        $data["title"] = __('environmentalCondition_update.title');

        try{
            $environmental_condition = EnvironmentalCondition::findOrFail($request->input('id'));
        }catch(Exception $e){
            return redirect()->route('admin.environmentalCondition.list');
        }

        $data["environmental_condition"] = $environmental_condition;

        return view('admin.environmentalCondition.update')->with("data", $data);
    }

    public function updateSave(Request $request){

        try{
            $environmental_condition = EnvironmentalCondition::findOrFail($request->input('id'));
            EnvironmentalCondition::validate($request);
        }catch(Exception $e){
            return redirect()->route('admin.environmentalCondition.list');
        }
        
        if($environmental_condition->getPhLR() != $request->input('ph_lr')){
            $environmental_condition->setPhLR($request->input('ph_lr'));
        }
        if($environmental_condition->getPhHR() != $request->input('ph_hr')){
            $environmental_condition->setPhHR($request->input('ph_hr'));
        }
        if($environmental_condition->getTemperatureLR() != $request->input('temperature_lr')){
            $environmental_condition->setTemperatureLR($request->input('temperature_lr'));
        }
        if($environmental_condition->getTemperatureHR() != $request->input('temperature_hr')){
            $environmental_condition->setTemperatureHR($request->input('temperature_hr'));
        }
        if($environmental_condition->getHardnessLR() != $request->input('hardness_lr')){
            $environmental_condition->setHardnessLR($request->input('hardness_lr'));
        }
        if($environmental_condition->getHardnessHR() != $request->input('hardness_hr')){
            $environmental_condition->setHardnessHR($request->input('hardness_hr'));
        }
        

        $environmental_condition->save();
        
        return back()->with('success', __('environmentalCondition_update.succesful'));

    }
}