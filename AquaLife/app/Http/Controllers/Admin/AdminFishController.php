<?php
// Created by: Yhoan Alejandro Guzman

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
Use Exception;
use App\Models\Fish;
use App\Models\EnvironmentalCondition;
use App\Models\WishListFish;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class AdminFishController extends Controller
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
            $fish = Fish::findOrFail($id);
        }catch(Exception $e){
            return redirect()->route('home.index');
        }

        $data["title"] = $fish->getName();
        $data["fish"] = $fish;
        return view('admin.fish.show')->with("data",$data);
    }

    public function list()
    {
        $data = []; //to be sent to the view
        $data["title"] =  __('fish_list.title');
        $data["fish"] = Fish::orderBy('id')->get();

        return view('admin.fish.list')->with("data",$data);

    }

    public function create()
    {
        $data = []; //to be sent to the view
        $data["title"] =  __('fish_create.title');
        $data["fish"] = Fish::all();
        $data["environmental_condition"] = EnvironmentalCondition::where([["fish_id",0]])->get();
        if (empty($data["environmental_condition"]->toArray())) {
            return redirect()->route('admin.environmental_condition.create')->withErrors(__('fish_create.create_environmental_condition'));;
        }
        return view('admin.fish.create')->with("data",$data);

    }

    public function update(Request $request)
    {
        $data = [];
        $data["title"] = __('fish_update.title');

        try{
            $fish = Fish::findOrFail($request->input('id'));
        }catch(Exception $e){
            return redirect()->route('admin.fish.list');
        }

        $data["fish"] = $fish;

        return view('admin.fish.update')->with("data", $data);
    }

    public function updateSave(Request $request){
        $fish = Fish::findOrFail($request->input('id'));
        $name = Fish::validate($request);
        if($fish->getName() != $request->input('name')){
            $fish->setName($request->input('name'));
        }
        if($fish->getSpecies() != $request->input('species')){
            $fish->setSpecies($request->input('species'));
        }
        if($fish->getPrice() != $request->input('price')){
            $fish->setPrice($request->input('price'));
        }

        if($fish->getFamily() != $request->input('family')){
            $fish->setFamily($request->input('family'));
        }

        if($fish->getColor() != $request->input('color')){
            $fish->setColor($request->input('color'));
        }

        if($fish->getSize() != $request->input('size')){
            $fish->setSize($request->input('size'));
        }

        if($fish->getTemperament() != $request->input('temperament')){
            $fish->setTemperament($request->input('temperament'));
        }

        if($fish->getInStock() != $request->input('in_stock')){
            $fish->setInStock($request->input('in_stock'));
        }

        if($request->hasFile('new_image')){
            File::delete(asset('/images/'.$fish->getImage()));
            $file = $request->file('new_image');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/', $name);
            $fish->setImage($name);
        }

        $fish->save();

        return back()->with('success', __('fish_update.succesful'));

    }

    public function save(Request $request)
    {
         Fish::validate($request);

         if($request->hasFile('image')){
            $file = $request->file('image');
            $imageName = time().$file->getClientOriginalName();
            $file->move(public_path().'/images/', $imageName);
        }

         $newFish = new Fish();
         $newFish->setName($request->input('name'));
         $newFish->setSpecies($request->input('species'));
         $newFish->setPrice($request->input('price'));
         $newFish->setFamily($request->input('family'));
         $newFish->setColor($request->input('color'));
         $newFish->setSize($request->input('size'));
         $newFish->setTemperament($request->input('temperament'));
         $newFish->setInStock($request->input('in_stock'));
         $newFish->setImage($imageName);
         $newFish->setEnvironmentalConditionId($request->input('environmental_condition_id'));
         $newFish->save();
         $environmental_condition = EnvironmentalCondition::findOrFail($request->input('environmental_condition_id'));
         $environmental_condition->setFishId($newFish->getId());
         $environmental_condition->save();
         return redirect()->route('admin.fish.list')->with('success', __('fish_create.succesful'));
    }

    public function delete(Request $request){
        
        try{
            $fish = Fish::find($request['id']);
            WishListFish::where('fish_id',$request['id'])->delete();
            EnvironmentalCondition::where('fish_id',$request['id'])->delete();
            $fish->delete();
        }catch(Exception $e){
            return redirect()->route('admin.fish.list');
        }
        return redirect()->route('admin.fish.list');
    }

}