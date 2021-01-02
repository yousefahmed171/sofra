<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $record = Order::all();

        return view('admin.orders.index', compact('record'));
    }

    public function show($id)
    {
        
        $record = Order::with('restaurant','products','client')->findOrFail($id);

         return view('admin.orders.show',compact('record'));
    }



}
