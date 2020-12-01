<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //

    public function categories()
    {
        $get = Category::all();
        return responseJson(1, 'success', $get);
    }
}
