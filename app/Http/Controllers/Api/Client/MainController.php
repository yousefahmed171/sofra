<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Contacte;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{

    // Create New Order
    public function newOrder(Request $request){


        $client = $request->user();

        // validator Data
        $rules = [

            'address'               => 'required',
            'payment_method'        => 'required',
            'restaurant_id'         => 'required|numeric',
            'products.*.product_id' => 'required|exists:products,id' , 
            'products.*.quantity'   => 'required'
        ];

        $messages = [

            'address.required'              => 'يجب إدخال العنوان المرسل اليه  ',
            'payment_method.required'       => 'يجب إختيار نوع الدفع  ',
            'restaurant_id.required'        => 'يجب إدخال المطعم ',
            'restaurant_id.numeric'         => 'يجب إدخال قيمة رقمية '

        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        // Get restaurant
        $restaurant = Restaurant::find($request->restaurant_id);

        // test if restaurant open or not
        if($restaurant->status === 'closed') 
        {
            return responseJson(0 , 'المطعم غير متاح الآن ');
        }

        // test if restaurant Active or not
        if( $restaurant->activated == 0) 
        {
            return responseJson(0 , 'المطعم غير مفعل الآن ');
        }

        //dd($request->user());

        $order  = Order::create([
            'restaurant_id'     => $request->restaurant_id, 
            'client_id'         => $request->user()->id,
            'address'           => $request->address, 
            'notes'             => isset($request->notes) ? $request->notes : '' , 
            'payment_method'    => $request->payment_method, 
            'status'            => 'pending'
        ]);

        
        //1 - Get All Product 

        
        $cost = 0;

        $delivery_cost = $restaurant->delivery_cost;

        //dd($restaurant->delivery_cost);

        foreach($request->products as $p)
        {
            $product = Product::where([
                                        ['id' , $p['product_id']] , 
                                        ['restaurant_id' , $request->restaurant_id]
                                    ])->first();

            if(!$product)
            {
                $order->products()->delete();
                $order->delete();
                return responseJson(0 , 'المنتج لا يتبع للمطعم ! ');         
            }

            $readyItem = [
                $product->id => [
                    'quantity'      =>  $p['quantity'] , 
                    'price'         =>  $product->price, 
                    'note'          =>  isset($p['note']) ? $p['note'] : ''
                ]
            ];

            $order->products()->attach($readyItem);

            $cost +=  ($product->price * $p['quantity']);   

        }

        // minimum charge
        if($cost >= $restaurant->minimum_charge)
        {
            $total         = $cost + $delivery_cost ;
            $commission    = settings()->commission * $cost ; // 0.1  not 10 if use 10 -- /100
            $net           = $total - $commission ;
            
            //Update the order

            $order->cost = $cost;
            $order->delivery_cost = $delivery_cost;
            $order->total_cost = $total;
            $order->commission = $commission;
            $order->net = $net;

            $order->save();

            //$request->user()->cart()->detach();  

            //create a notification 
            $notification = $restaurant->notifications()->create([
                                'title'     => 'لديك طلب جديد ' , 
                                'content'      => 'لديك طلب جديد من العميل ' . $client->name ,
                                'order_id'  => $order->id
                        ]);

            $tokens = $restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
            $data   = [
                    'order' => $order->fresh()->load('products') // load => same ->with('products)
            ]; 
            //$send = notifyByFirebase($notification->title , $notification->body , $tokens , $data);
            return responseJson(1 , 'تم إرسال الطلب للمطعم' , $data);
        }
        else 
        {
            $order->products()->delete();
            $order->delete();
            return responseJson(0 , 'الطلب لا يمكن أن يكون أقل من : ' . $restaurant->minimum_charge);
        }
    }

    // orders  client

    public function orders(Request $request)
    {
        dd($request->user()->id);
        $order =  DB::table('orders')->where('client_id', '=', $request->user()->id)
                                    //->where('status', '=', 'delivered')
                                    ->paginate(10);
        return responseJson(1, 'success', $order);

    }


    // deliver Order

    public function deliverOrder(Request $request)
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
                    ['client_id' , $request->user()->id]
                ])->first();

        if(!$order)
        {
            return responseJson(0 , 'هذا الطلب لا يتبع للعميل');
        }

        // check if order pending or  accepted   
        if(!($order->status === 'pending' || $order->status === 'accepted'))
        {
            return responseJson(0 , 'لايمكن توصيل هذا الطلب للعميل ' );
        }

        // Decline the order
        $order->status = 'delivered';
        $order->save();

        // Make a notification 
        $order->restaurant->notifications()->create([
                            'title' => 'تم توصيل الطلب بنجاح' , 
                            'content'  => '  تم توصيل الطلب بنجاح   ' . $client->name,
                            'order_id' => $order->id
                        ]);

        // Send Notification
        $tokens = $order->restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
        $data = [
            'user_type' => 'restaurant' , 
            'action'    => 'decline_order' , 
            'order'     =>  $order
        ];
       // $send = notifyByFirebase($notification->title , $notification->body , $tokens , $data );
        return responseJson(1 , 'تم توصيل الطلب بنجاح' , $data);

    }


    // Dcline Order

    public function declineOrder(Request $request)
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
                    ['client_id' , $request->user()->id]
                ])->first();

        if(!$order)
        {
            return responseJson(0 , 'هذا الطلب لا يتبع للعميل');
        }

        // check if order pending or  accepted   
        if(!($order->status === 'pending' || $order->status === 'accepted'))
        {
            return responseJson(0 , 'لايمكن رفض هذا الطلب الان ' );
        }

        // Decline the order
        $order->status = 'declined';
        $order->save();

        // Make a notification 
        $order->restaurant->notifications()->create([
                            'title' => 'تم رفض الطلب من قبل  العميل' , 
                            'content'  => '  تم رفض الطلب من قبل العميل   ' . $client->name,
                            'order_id' => $order->id
                        ]);

        // Send Notification
        $tokens = $order->restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
        $data = [
            'user_type' => 'restaurant' , 
            'action'    => 'decline_order' , 
            'order'     =>  $order
        ];
        // $send = notifyByFirebase($notification->title , $notification->body , $tokens , $data );
        return responseJson(1 , 'تم رفض الطلب' , $data);

    }

    // review

    public function review(Request $request)
    {

        $rules = [
            'restaurant_id'     => 'required|exists:restaurants,id',
            'comment'           => 'required',
            'rate'              => 'required|numeric|max:5',
        ];

        $messages = [
            'restaurant_id.required'    => 'يجب إدخال معرف المطعم' , 
            'restaurant_id.exists'      => 'المعرف غير موجود',
            'comment.required'          => 'يجب كتابة تعليق',
            'rate.required'             => 'يجب اختيار تقيم ',
            'rate.numeric'              => 'يجب ان يكون رقم صحيح ',
            'rate.max'                  => 'الرقم المدخل يجب ان يكون من 1 الى 5  ',
        ];


        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }
 
        
        //  client 
        $client = Client::find($request->user()->id);

        //dd($restaurant);

        $request->merge(['client_id' => $request->user()->id]);

        $review = $client->reviews()->create($request->all());

        return responseJson(1, 'تم التقييم بنجاح', [

            'review' => $review->load('client','restaurant')
        ]);

    }

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

}
