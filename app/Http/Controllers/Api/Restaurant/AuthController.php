<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
 
    // Get Restaurant Register Test
    public function getRestaurants()
    {
        $getRestaurants =  Restaurant::paginate(10);
        return responseJson(1, 'success', $getRestaurants);

    }

    // Register Restaurant
    public function register(Request $request){

        // validator Data
        $rules = [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:restaurants,email',
            'phone'                 => 'required|numeric|unique:restaurants,phone',
            'whatsapp'              => 'required|numeric',
            'password'              => 'required|confirmed',
            'image'                 => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'status'                => 'required',
            'minimum_order'         => 'required|numeric',
            'delivery_cost'         => 'required|numeric',
            'region_id'             => 'required|exists:regions,id', // 'exists' = if user entered date and did not select option
            'categories'            => 'required|array|exists:categories,id'

        ];

        $messages = [
            'name.required'                  => 'يجب إدخال إسم المطعم ',
            'email.required'                 => 'يجب إدخال بريد إلكتروني ',
            'email.email'                    => 'رجاء إدخال عنوان بريد إلكتروني صحيح ',
            'email.unique'                   => 'هذا البريد الإلكتروني موجود بالفعل ',
            'phone.required'                 => 'يجب إدخال رقم الجوال ',
            'phone.unique'                   => 'هذا الجوال موجود بالفعل',
            'phone.numeric'                  => 'يجب إدخال قيمة رقمية',
            'whatsapp.required'              => 'يجب إدخال رقم الواتس',
            'whatsapp.numeric'               => 'يجب إدخال قيمة رقمية',
            'password.required'              => 'يجب إدخال كلمة السر',
            'password.confirmed'             => 'كملة السر غير متطابقة',
            'image.required'                 => 'يجب إدخال صورة المطعم ',
            'image.image'                    => 'يجب ان تكون القيمة صورة  ',
            'status.required'                => 'يجب إدخال حالة المطعم ',
            'minimum_order.required'         => 'يجب إدخال الحد الأدنى للطلب ',
            'minimum_order.numeric'          => 'يجب إدخال قيمة رقمية ',
            'delivery_cost.required'         => 'يجب إدخال قيمة التوصيل ',
            'delivery_cost.numeric'          => 'يجب إدخال قيمة رقمية ',
            'region_id.required'             => 'يجب إدخال اسم الحي ',
            'region_id.exists'               => 'اسم الحي غير صحيح',
            'categories.required'            => 'يجب إدخال تصنيفات المطعم',
            'categories.exists'              => 'اسم التصنيف غير موجود'
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $restaurant = Restaurant::create($request->all());
        $restaurant->api_token = Str::random(60);
        $restaurant->save();

        // attach categories
        $restaurant->categories()->attach($request->categories);

        // Check and upload image
        if($request->hasFile('image'))
        {
            $image = $request->file('image'); // get image request
            $extension = $image->getClientOriginalExtension(); // get extension image
            $name = time() . '.' . $extension; // name image time and extension
            $destinationPath = public_path('/images/restaurants/'); // path save images
            $image->move($destinationPath, $name);  // save path and name
            $restaurant->update(['image' => 'images/restaurants/' . $name]); //update
        }
              
        return responseJson(1, 'عملية ناجحة', [
            'api_token'     => $restaurant->api_token,
            'restaurant'    => $restaurant
        ]);
    }

    // Login
    public function login(Request $request)
    {
        // Validator Data
        $rules = [
            'email'         => 'required',
            'password'      => 'required',
        ];

        $messages = [
            'email.required'         => 'يجب إدخال البريد الإلكتروني',
            'password.required'      => 'يجب إدخال كلمة السر',
        ];

        $validatorData  = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $restaurant = Restaurant::where('email', $request->email)->first();
        
        if($restaurant)
        {
            if(Hash::check($request->password, $restaurant->password))
            {
                return responseJson(1, 'تم تسجيل الدخول بنجاح', [
                    'Api Token' => $restaurant->api_token,
                    'Client'    => $restaurant
                ]);
            }else 
            {
                return responseJson(0, 'بيانات الدخول غير صحيحة '); 
            }
        }
        else 
        {
            return responseJson(0, 'بيانات الدخول غير صحيحة '); 
        }
    }

    //Profile
    public function profile(Request $request)
    {

        $restaurant =  $request->user()->id;

        $rules = [
            'name'                  => Rule::requiredIf($request->has('name')),
            'email'                 => Rule::requiredIf($request->has('email'))         . '|email|unique:restaurants,email,'.$restaurant,
            'phone'                 => Rule::requiredIf($request->has('phone'))         . '|numeric|unique:restaurants,phone,'.$restaurant,
            'whatsapp'              => Rule::requiredIf($request->has('whatsapp'))      . '|numeric',
            'password'              => Rule::requiredIf($request->has('password'))      . '|confirmed',
            'image'                 => Rule::requiredIf($request->has('image'))         . '|image:jpeg,png,jpg,gif,svg|max:2048',
            'status'                => Rule::requiredIf($request->has('status')),
            'minimum_order'         => Rule::requiredIf($request->has('minimum_order')) . '|numeric',
            'delivery_cost'         => Rule::requiredIf($request->has('delivery_cost')) . '|numeric',
            'region_id'             => Rule::requiredIf($request->has('region_id'))     . '|exists:regions,id', // 'exists' = if user entered date and did not select option
            'categories'            => Rule::requiredIf($request->has('categories'))    . '|array|exists:categories,id'

        ];

        $messages = [

        ];


        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge([]);

        
        $request->user()->update($request->all());
        

        if($request->has('categories'))
        {
            $request->user()->categories()->sync($request->categories);
        }

        if($request->has('password'))
        {
            $request->user()->password = bcrypt($request->password);
        }

        if($request->has('image'))
        {
            $image = $request->file('image'); // get image request
            $extension = $image->getClientOriginalExtension(); // get extension image
            $name = time() . '.' . $extension; // name image time and extension
            $destinationPath = public_path('/images/restaurants/'); // path save images
            $image->move($destinationPath, $name);  // save path and name
            $request->user()->update(['image' => 'images/restaurants/' . $name]); //update
        }
        
        
        $request->user()->save();

        $data = [
            'restaurant' => $request->user()->load('region','categories')
        ];

        return responseJson(1 , 'تم التعديل بنجاح' , $data);


    }


}
