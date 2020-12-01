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