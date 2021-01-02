<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // prodects


    // Add Products
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


    // Add offers  // delete and edit
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

  



    public function notifications(Request $request)
    {
        //dd($request->user());
        $notifications = $request->user()->notifications()->with('order')->latest()->paginate(20);

        return count($notifications) ? responseJson(1 , 'success' , $notifications->load('order'))
                                     : responseJson(0 , 'لا يوجد إشعارات  ');
    }

    //orders acceptOrder & rejectOrder

    public function acceptOrder(Request $request)
    {

        $client = $request->user();

        $rules = [
            'order_id'  => 'required|exists:orders,id'
        ];

        $messages = [
            'order_id.required' => 'يجب إدخال الطلب' , 
            'order_id.exists'   => 'الطلب غير موجود'
        ];


        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        // check if order with user
        $order = Order::where([
                    ['id' , $request->order_id] , 
                    ['restaurant_id' , $request->user()->id]
                ])->first();

        if(!$order)
        {
            return responseJson(0 , 'هذا الطلب لا يتبع للمطعم');
        }

        // check if order pending or  accepted   
        if(!($order->status === 'pending'))
        {
            return responseJson(0 , 'لايمكن قبول هذا الطلب الان ' );
        }

        // Accepted the order
        $order->status = 'accepted';
        $order->save();

        // Make a notification 
        $order->restaurant->notifications()->create([
                            'title' => 'تم قبول الطلب من قبل  المطعم' , 
                            'content'  => '  تم قبول الطلب من قبل المطعم   ' . $client->name,
                            'order_id' => $order->id
                        ]);

        // Send Notification
        $tokens = $order->restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
        $data = [
            'user_type' => 'client' , 
            'action'    => 'accetp_order' , 
            'order'     =>  $order
        ];
        // $send = notifyByFirebase($notification->title , $notification->body , $tokens , $data );
        return responseJson(1 , 'تم قبول الطلب' , $data);

    }

    // rejectOrder
    public function rejectOrder(Request $request)
    {

        $client = $request->user();

        $rules = [
            'order_id'  => 'required|exists:orders,id'
        ];

        $messages = [
            'order_id.required' => 'يجب إدخال الطلب' , 
            'order_id.exists'   => 'الطلب غير موجود'
        ];


        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        // check if order with user
        $order = Order::where([
                    ['id' , $request->order_id] , 
                    ['restaurant_id' , $request->user()->id]
                ])->first();

        if(!$order)
        {
            return responseJson(0 , 'هذا الطلب لا يتبع للمطعم');
        }

        // check if order pending or  accepted   
        if(!($order->status === 'pending'))
        {
            return responseJson(0 , 'لايمكن قبول هذا الطلب الان ' );
        }

        // Rejected the order
        $order->status = 'rejected';
        $order->save();

        // Make a notification 
        $order->restaurant->notifications()->create([
                            'title' => 'تم رفض الطلب من قبل  المطعم' , 
                            'content'  => '  تم رفض الطلب من قبل المطعم   ' . $client->name,
                            'order_id' => $order->id
                        ]);

        // Send Notification
        $tokens = $order->restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
        $data = [
            'user_type' => 'client' , 
            'action'    => 'reject_order' , 
            'order'     =>  $order
        ];
        // $send = notifyByFirebase($notification->title , $notification->body , $tokens , $data );
        return responseJson(1 , 'تم رفض الطلب' , $data);

    }


}
