<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){
        $regions= Region::all();
        $cities = City::all();
        return view('admin.city.index',compact('regions', 'cities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'region_id' => 'required',
        ]);
        City::create([
            'name'=>$request->name,
             'region_id'=>$request->region_id
        ]);
        return redirect()->route('cities.index');

    }
    public function update(Request $request, $id)
    {
        $city=City::findOrFail($id);

        $request->validate([
            'name' => 'required',
        ]);

        $city->update([
            'name'=>$request->name,
        ]);
        return redirect()->route('cities.index');


    }
    public function destroy($id)
    {
        $city=City::findOrFail($id);
        $city->delete();
        return redirect()->route('cities.index');
    }
}
