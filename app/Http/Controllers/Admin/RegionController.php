<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $record = Region::with('city')->get();

        return view('admin.regions.index', compact('record'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $record = City::pluck('name', 'id');

        return view('admin.regions.create', compact('record'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules      = [ 
            'name'              => 'required',
            'city_id'           => 'required'  
        ];
        $massage    = [
            'name.required'              => 'يجب ادخال اسم المنطقة ',
            'city_id.required'           => 'يجب ادختيار اسم المدينة'  
        ];
        $this->validate($request, $rules, $massage);

        $record = Region::create($request->all());

        flash('Success create New Region')->success();
        return redirect('admin/regions'); //return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $record = Region::findOrFail($id);

        $cities = Region::with('city')->get();
        foreach($cities as $city)
        {
            $categoriesArray[$city->city_id] = $city->city->name;
        }

        return view('admin.regions.edit', compact('record', 'categoriesArray'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $record = Region::findOrFail($id);
        $record->update($request->all());
        flash('Success Update Region')->success();
        return redirect('admin/regions'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $record = Region::findOrFail($id);
        $record->delete();
        flash('Sucess Delete Region')->success();
        return redirect('admin/regions');

    }
}
