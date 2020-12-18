<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\Request;

class MainController extends Controller
{

    // Get Categories
    public function categories()
    {
        $get = Category::all();
        return responseJson(1, 'success', $get);
    }

    // Get Cities
    public function cities()
    {
        $get = City::paginate(10);
        return responseJson(1, 'success', $get);
    }

    // Get Regions
    public function regions()
    {
        $get = Region::paginate(10);
        return responseJson(1, 'success', $get);
    }

    

}
