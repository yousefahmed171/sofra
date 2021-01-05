<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Contacte;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Region;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;

class MainController extends Controller
{

    // contact 
    public function contact(Request $request){

        // validator Data
        $rules = [
            'name'          => 'required',
            'email'         => 'required|email',
            'phone'         => 'required|numeric',
            'massage'       => 'required', 
            'type'          => 'required|in:complaint,suggestion,Enquiry'
        ];

        $messages = [

            'name.required'             => 'يجب ادخال الاسم   ',
            'email.required'            => 'يجب ادخال البريد الإلكتروني ',
            'phone.required'            => 'يجب إدخال رقم الهاتف  ',
            'phone.numeric'             => 'يجب إدخال قيمة رقمية ',
            'massage.required'          => 'يجب ادخال رساله نصيه  ',
            'type.required'             => 'يجب اختيار النوع ',
            'type.in'                   => 'اختيار خاطئ ',


        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

       
        $contact  = Contacte::create($request->all());
        return responseJson(1, 'تم ارسال الرساله بنجاح', $contact);

    }

    // get restaurant
    public function restaurants()
    {
        $get = Restaurant::with('reviews')->paginate(10);
        return count($get) ? responseJson(1 , 'success' , $get)
        : responseJson(0 , 'no data');
    }

    // list Product of restaurant
    public function product(Request $request)
    {
        //dd($request->restaurant_id);
        $get = Product::where('restaurant_id', $request->restaurant_id)->paginate(10);
        return responseJson(1,'المنتجات الخاصة بالمطعم ',$get);
    }

    // Get Categories
    public function categories()
    {
        $get = Category::all();
        return count($get) ? responseJson(1 , 'success' , $get)
        : responseJson(0 , 'no data');
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

    // Get Setting
    public function setting()
    {
        $get = Setting::get();
        return count($get) ? responseJson(1 , 'success' , $get)
        : responseJson(0 , 'no data');
    }

    // Get Offers
    public function offers()
    {
        $get = Offer::orderBy('created_at', 'desc')->paginate(10);
        return count($get) ? responseJson(1 , 'success' , $get)
        : responseJson(0 , 'no data');
    }

    

}
