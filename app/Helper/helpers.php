<?php 

function responseJson($status, $massage, $data=null)
{
    $response = [
        'status '   =>  $status,
        'message'   =>  $massage,
        'data'      =>  $data
    ];
    return response()->json($response); // all work return front end one style 
}

function settings()
{
    $settings = \App\Models\Setting::find(1);
    if($settings)
    {
        return $settings;
    }else{
        return new \App\Models\Setting;
    }
}