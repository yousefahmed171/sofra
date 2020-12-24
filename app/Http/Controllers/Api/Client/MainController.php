<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Restaurant;
use App\Models\Setting;
use Illuminate\Http\Request;

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


    // Dcline Order

    public function declineOrder(Request $request)
    {
        $rules = [
            'order_id'  => 'required|exists:orders,id'
        ];

        $messages = [
            'order_id.required' => 'يجب إدخال الطلب' , 
            'order_id.exists'   => 'الطلب غير موجود'
        ];

        $validator = validator()->make($request->all() , $rules , $messages);

        if($validator->fails())
        {
            return responceJson( 0 , $validator->errors()->first() , $validator->errors());
        }

        //Get the Order and make sure that it belongs to that client
        $order = Order::where([
                    ['id' , $request->order_id] , 
                    ['client_id' , $request->user()->id]
                ])->first();

        if(!$order)
        {
            return responceJson(0 , 'هذا الطلب لا يتبع للعميل');
        }
        //Make sure that the state of order was pending or accepted
        if(!($order->state == 'pending' || $order->state == 'accepted'))
        {
            return responceJson(0 , 'لا يمكن رفض هذا الطلب' );
        }

        //Decline the order
        $order->state = 'declined';
        $order->save();
        //Make a notification 
        $notification = $order->restaurant->notifications()->create([
                            'title' => 'تم رفض الطلب من العميل' , 
                            'body'  => '  تم رفض الطلب من العميل   ' . $order->client->name ,
                            'order_id' => $order->id
                        ]);
        //Send a notification
        $tokens = $order->restaurant->tokens()->where('token' , '!=' , '')->pluck('token')->toArray();
        $data = [
            'user_type' => 'restaurant' , 
            'action'    => 'decline_order' , 
            'order'     =>  $order
        ];
        $send = notifyByFirebase($notification->title , $notification->body , $tokens , $data );
        return responceJson(1 , 'تم رفض الطلب' , $data);

    }
}
