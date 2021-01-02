<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $record = Client::with('region')->get();
        return view('admin.clients.index', compact('record'));
    }

    public function active($id)
    {
        $settings = Client::findOrFail($id);
        $settings->active = 1 ;
        $settings->save();
        return back();
    }

    public function deActive($id)
    {
        //
        $settings = Client::findOrFail($id);
        $settings->active = 0 ;
        $settings->save();
        return back();
    }


}
