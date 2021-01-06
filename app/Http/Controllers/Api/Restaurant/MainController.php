<?php

namespace App\Http\Controllers\Api\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class MainController extends Controller
{
    // get products

    public function products(Request $request)
    {
        $get = Product::where('restaurant_id', '=', auth()->user()->id)->paginate(10);
        return responseJson(1,'المنتجات الخاصة بالمطعم ',$get);
    }

    // Add Products
    public function addProduct(Request $request){

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

    // Edit Products
    public function editProduct(Request $request){

        // validator Data
        $rules = [
            'product_id'            => 'required|exists:products,id',
            'name'                  => Rule::requiredIf($request->has('name')),
            'image'                 => Rule::requiredIf($request->has('image')),
            'description'           => Rule::requiredIf($request->has('description')),
            'price'                 => Rule::requiredIf($request->has('price')),
            'offer_price'           => Rule::requiredIf($request->has('offer_price')),
        ];

        $messages = [

            'product_id.required'           => 'يجب ادخال المعرف الخاص بالمطعم ',
            'product_id.exists'             => 'هذا المعرف غير موجود',
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
        
        $product = Product::where([
            ['id', $request->product_id] , 
            ['restaurant_id' , $request->user()->id]
        ])->first();
                
        if (!$product)
        {
            return responseJson(0,'لايوجد منتج ');
        }

        $product->update($request->all()); 

        $request->merge(['restaurant_id' => $request->user()->id]);

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

        return responseJson(1, 'تم تعديل المنتج بنجاح', $product);
    }

    // Delete Products
    public function deleteProduct(Request $request){

        // validator Data
        $rules = [
            'product_id'            => 'required|exists:products,id',
        ];

        $messages = [
            'product_id.required'           => 'يجب ادخال المعرف الخاص بالمطعم ',
            'product_id.exists'             => 'هذا المعرف غير موجود',
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $product = Product::where([
            ['id', $request->product_id] , 
            ['restaurant_id' , $request->user()->id]
        ])->first();
                
        if (!$product)
        {
            return responseJson(0,'لايوجد منتج ');
        }

        $product->delete();

        return responseJson(1, 'تم حذف المنتج بنجاح');
    }

    // get offers

    public function offers(Request $request)
    {
        $get = Product::where('restaurant_id', '=', auth()->user()->id)->paginate(10);
        return responseJson(1,'العروض الخاصة بالمطعم ',$get);
    }

    // Add offers  // delete and edit
    public function addOffer(Request $request){

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

    // edit offer
    public function editOffer(Request $request){

        // validator Data
        $rules = [
            'offer_id'              => 'required|exists:offers,id',
            'name'                  => 'required',
            'image'                 => 'required|image:jpeg,png,jpg,gif,svg|max:2048',
            'description'           => 'required',
            'price'                 => 'required|numeric',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
        ];

        $messages = [
            'offer_id.required'             => 'يجب إدخال معرف العرض',
            'offer_id.exists'               => 'هذا المعرف غير موجود',
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

        $offer = Offer::where([
            ['id', $request->offer_id] , 
            ['restaurant_id' , $request->user()->id]
        ])->first();
                
        if (!$offer)
        {
            return responseJson(0,'لايوجد عرض مع هذا المعرف ');
        }

        $offer->update($request->all()); 

        $request->merge(['restaurant_id' => $request->user()->id]);

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
                
        return responseJson(1, 'تم تعديل العرض بنجاح', [
            'offer'    => $offer
        ]);
    }


    // Delete offer 
    public function deleteOffer(Request $request){

        // validator Data
        $rules = [
            'offer_id'              => 'required|exists:offers,id',
        ];

        $messages = [
            'offer_id.required'             => 'يجب إدخال معرف العرض',
            'offer_id.exists'               => 'هذا المعرف غير موجود',
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $offer = Offer::where([
            ['id', $request->offer_id] , 
            ['restaurant_id' , $request->user()->id]
        ])->first();
                
        if (!$offer)
        {
            return responseJson(0,'لايوجد عرض مع هذا المعرف ');
        }

        $offer->delete(); 
                
        return responseJson(1, 'تم حذف العرض بنجاح', [
            'offer'    => $offer
        ]);
    }


    // orders  restaurant

    public function orders(Request $request)
    {
        $orders = Order::where('restaurant_id', '=',$request->user()->id)
                        ->where('status', '=', 'pending')
                        ->orderBy('created_at', 'desc')
                        ->paginate(10);
        return responseJson(1, 'success', $orders);
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
        $order->client->notifications()->create([
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
            'order_id.exists'   => 'المعرف غير موجود'
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


    // notifications
    public function notifications(Request $request)
    {
        $notifications = $request->user()->notifications()->with('order')->orderBy('created_at', 'desc')->paginate(20);

        return responseJson(1, 'الاشعارات ', [
            'عدد الاشعارات' => count($notifications),
            'اشعارات المستخدم' => $notifications
        ]);
    }


    // commissions
    public function commissions(Request $request)
    {

        // count order
        $count = $request->user()->orders()->where('status','accepted')->count();
        // total order
        $total = $request->user()->orders()->where('status','accepted')->sum('total_cost');
        // total commission
        $commission = $request->user()->orders()->where('status','accepted')->sum('commission');

        //setting 
        $commissionApp = settings()->commission;
        $idBank = settings()->id_bank;
        $aboutCommission = settings()->about_commission;

        //dd($count, $total, $commission, $commissionApp, $idBank, $aboutCommission);    

        return responseJson(1, 'العمولة ', [
            'عدد الطلبات'           => $count,
            'مجموع الطلبات'         => $total,
            'مجموع حساب العمولة '   => $commission,
            'نسبة التطبيق'          => $commissionApp,
            'عن العملة '            => $aboutCommission,
            'معلومات البنك'         => $idBank
        ]);



    }


}
