<?php

namespace App\Http\Controllers\Api\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Client;
use App\Mail\ResetPassword;
use App\Models\Token;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{

    // Register client
    public function register(Request $request){

        // validator Data
        $rules = [
            'name'                  => 'required',
            'email'                 => 'required|email|unique:clients,email',
            'phone'                 => 'required|numeric|unique:clients,phone',
            'password'              => 'required|confirmed',
            'region_id'             => 'required|exists:regions,id', // 'exists' = if user entered date and did not select option

        ];

        $messages = [
            'name.required'                  => 'يجب إدخال إسم المطعم ',
            'email.required'                 => 'يجب إدخال البريد إلكتروني ',
            'email.email'                    => 'رجاء إدخال عنوان البريد الإلكتروني صحيح ',
            'email.unique'                   => 'هذا البريد الإلكتروني موجود بالفعل ! ',
            'phone.required'                 => 'يجب إدخال رقم الجوال ',
            'phone.unique'                   => 'هذا الجوال موجود بالفعل',
            'phone.numeric'                  => 'يجب إدخال قيمة رقمية',
            'password.required'              => 'يجب إدخال كلمة السر',
            'password.confirmed'             => 'كملة السر غير متطابقة',
            'region_id.required'             => 'يجب إدخال اسم الحي ',
            'region_id.exists'               => 'اسم الحي غير صحيح'
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = Str::random(60);
        $client->save();

                
        return responseJson(1, 'عملية ناجحة', [
            'api_token'     => $client->api_token,
            'client'        => $client
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

        $client = Client::where('email', $request->email)->first();
        
        if($client)
        {
            if(Hash::check($request->password, $client->password))
            {
                return responseJson(1, 'تم تسجيل الدخول بنجاح', [
                    'Api Token' => $client->api_token,
                    'Client'    => $client
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

    // edit Profile
    public function profile(Request $request)
    {

        $client =  $request->user()->id;

        $rules = [
            'name'                  => Rule::requiredIf($request->has('name')),
            'email'                 => Rule::requiredIf($request->has('email'))         . '|email|unique:clients,email,'.$client,
            'phone'                 => Rule::requiredIf($request->has('phone'))         . '|numeric|unique:clients,phone,'.$client,
            'region_id'             => Rule::requiredIf($request->has('region_id'))     . '|exists:regions,id', // 'exists' = if user entered date and did not select option
            'password'              => 'confirmed'

        ];

        $messages = [
            'name.required'                  => 'يجب إدخال إسم المطعم ',
            'email.required'                 => 'يجب إدخال البريد إلكتروني ',
            'email.email'                    => 'رجاء إدخال عنوان البريد الإلكتروني صحيح ',
            'email.unique'                   => 'هذا البريد الإلكتروني موجود بالفعل ! ',
            'phone.required'                 => 'يجب إدخال رقم الجوال ',
            'phone.unique'                   => 'هذا الجوال موجود بالفعل',
            'phone.numeric'                  => 'يجب إدخال قيمة رقمية',
            'password.confirmed'             => 'كملة السر غير متطابقة',
            'region_id.required'             => 'يجب إدخال اسم الحي ',
            'region_id.exists'               => 'اسم الحي غير صحيح'
       
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $request->merge([]);

        
        $request->user()->update($request->all());
        
        if($request->has('password'))
        {
            $request->user()->password = bcrypt($request->password);
        }
        $request->user()->save();

        $data = [
            'client' => $request->user()->load('region')
        ];

        return responseJson(1 , 'تم التعديل بنجاح' , $data);

    }

      
    //Reset Password
    public function resetPassword(Request $request)
    {

        // validator Data
        $rules = [
            'phone'                 => 'required|numeric',       
        ];

        $messages = [
            'phone.required'                 => 'يجب إدخال رقم الجوال ',
            'phone.numeric'                  => 'يجب إدخال قيمة رقمية',
        ];

        $validatorData = validator()->make($request->all(), $rules, $messages);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        } 

        //dd($request->all());
        $sofra = Client::where('phone', $request->phone)->first();
        
        if($sofra)
        {
            $code = rand(1111,9999);
            $update = $sofra->update(['pin_code' => $code]);

            if($update)
            {
                //send SMS

                //Send Email 

                Mail::to($sofra->email)
                    ->bcc("yousefahmed171@gmail.com")
                    ->send(new ResetPassword($sofra));

                return responseJson(1, 'رقم الهاتف صحيح  ', 
                [
                    'client'            => $sofra , 
                    'update'            => $update, 
                    'code'              => $code,
                    'email'             => $sofra->email,
                ]);

            }else 
            {
                return responseJson(0, 'بيانات الهاتف غير صحيحة '); 
            }
        }
        else 
        {
            return responseJson(0, 'بيانات الهاتف غير صحيحة '); 
        }
    }

    //New Password
    public function newPassword(Request $request)
    {

        $validatorData  = validator()->make($request->all(),
        [
            'pin_code'         =>   'required',
            'phone'            =>   'required',
            'password'         =>   'required|confirmed',
            
        ]);

        if($validatorData->fails())
        {
            $errors = $validatorData->errors();
            return responseJson(0, $validatorData->errors()->first(), $errors);
        }

        $user = Client::where('pin_code', $request->pin_code)
                            ->where('pin_code', '!=',0)
                            ->where('phone', $request->phone)->first();

        if($user)
        {
            $user->password = bcrypt($request->password);

            $user->pin_code = null;

            if($user->save())
            {
                return responseJson(1, 'تم تغير كلمة المرور بنجاح  '); 
            }else {
                return responseJson(0, 'حدث خطأ , حاول مره آخرى  '); 
            }
        }else {
            return responseJson(00, 'هذه الكود غير صالح   '); 

        }


    }

    public function registerToken(Request $request)
    {
        $validatorData = validator()->make($request->all(),[

            'token'         => 'required',
            'type'          => 'required|in:android,ios'

        ]);

        if($validatorData->fails())
        {
        return responseJson(0, $validatorData->errors()->first(), $validatorData->errors());
        }

        Token::where('token', $request->token)->delete();

        $request->user()->tokens()->create($request->all());

        return responseJson(1, 'تم التسجيل بنجاح ');

    }

    public function removeToken(Request $request)
    {
        $validatorData = validator()->make($request->all(),[

            'token'         => 'required'
        ]);

        if($validatorData->fails())
        {
        return responseJson(0, $validatorData->errors()->first(), $validatorData->errors());
        }

        Token::where('token', $request->token)->delete();

        return responseJson(1,'تم الحذف بنجاح ');
    }
    
}
