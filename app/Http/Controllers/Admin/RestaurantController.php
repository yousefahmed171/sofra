<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class RestaurantController extends Controller
{
    public function index()
    {
        //
        $record = Restaurant::with('region')->get();
        return view('admin.restaurants.index', compact('record'));
    }

    public function active($id)
    {
        $settings = Restaurant::findOrFail($id);
        $settings->activated = 1 ;
        $settings->save();
        return back();
    }

    public function deActive($id)
    {
        //
        $settings = Restaurant::findOrFail($id);
        $settings->activated = 0 ;
        $settings->save();
        return back();
    }
}
