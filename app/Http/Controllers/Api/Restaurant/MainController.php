<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    
    // Create Products
    public function products(Request $request){

        // validator Data
        $rules = [

            'name'                  => 'required',
            'image'                 => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'description'           => 'required',
            'price'                 => 'required|numeric',
            'offer_price'           => 'numeric',
        ];

        $messages = [

            'name.required'                 => 'يجب إدخال إسم المطعم ',
            'image.required'                => 'يجب إدخال صورة المطعم ',
            'image.image'                   => 'يجب ان تكون القيمة صورة  ',
            'description.required'          => 'يجب إدخال وصف المطعم ',
            'price.required'                => 'يجب إدخال سعر الطعام ',
            'price.numeric'                 => 'يجب إدخال قيمة رقمية ',
            'offer_price.numeric'           => 'يجب إدخال قيمة رقمية '

        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge(['restaurant_id' => $request->user()->id]); 
        $product = Product::create($request->all());
        $product->save();



        // Check and upload image
        if($request->hasFile('image'))
        {
            $image = $request->file('image'); // get image request
            $extension = $image->getClientOriginalExtension(); // get extension image
            $name = rand(1111, 9999) . time() . '.' . $extension; // name image time and extension
            $destinationPath = public_path('/images/restaurants/products'); // path save images
            $image->move($destinationPath, $name);  // save path and name
            $product->update(['image' =>  $name]); //update
        }
                
        return responseJson(1, 'تم إضافة المنتج بنجاح', [
            'restaurant'    => $product
        ]);
    }


    // Create Products
    public function offers(Request $request){

        // validator Data
        $rules = [

            'name'                  => 'required',
            'image'                 => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'description'           => 'required',
            'price'                 => 'required|numeric',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
        ];

        $messages = [

            'name.required'                 => 'يجب إدخال إسم المطعم ',
            'image.required'                => 'يجب إدخال صورة المطعم ',
            'image.image'                   => 'يجب ان تكون القيمة صورة  ',
            'description.required'          => 'يجب إدخال وصف المطعم ',
            'price.required'                => 'يجب إدخال سعر الطعام ',
            'price.numeric'                 => 'يجب إدخال قيمة رقمية ',
            'start_date.required'           => 'يجب إدخال قيمة رقمية ',
            'start_date.date'               => 'يجب إدخال قيمة تاريخ صحيحة 20-12-2020 ',
            'end_date.required'             => 'يجب إدخال قيمة رقمية ',
            'end_date.date'                 => 'يجب إدخال قيمة تاريخ صحيحة 20-12-2020'

        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge(['restaurant_id' => $request->user()->id]); 
        $offer = Offer::create($request->all());
        $offer->save();



        // Check and upload image
        if($request->hasFile('image'))
        {
            $image = $request->file('image'); // get image request
            $extension = $image->getClientOriginalExtension(); // get extension image
            $name = rand(1111, 9999) . time() . '.' . $extension; // name image time and extension
            $destinationPath = public_path('/images/restaurants/offers'); // path save images
            $image->move($destinationPath, $name);  // save path and name
            $offer->update(['image' =>  $name]); //update
        }
                
        return responseJson(1, 'تم اضافة العرض بنجاح', [
            'restaurant'    => $offer
        ]);
    }


}
