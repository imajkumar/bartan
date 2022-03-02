<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Mail\CustomerRegistrationOtpMail;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Sellers;
use Response;
use DB;
use Auth;
use Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function sendOtpForSales(Request $request){
       
        // Auth::logout();
        // session()->forget('customer');
        // session()->forget('sales');
        // session()->forget('customerForSalesPanel');

        
        $this->validate($request, [
            'mobile' => 'required',
        ]);
        //echo "<pre>";print_r($request->all());exit;
        //$otp = 123456;
       $otp = generateOtp(6);
    //    $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->orWhere('email', $request->mobile)->where('user_type', 2)->first();
        if (filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false) {
            $this->validate($request, [
                'mobile' => 'email',
            ]);
           
            
            // $customer = User::where('email', $request->mobile)->update([
            //     'otp' => $otp
            // ]);
            $afterRegisterCustomerDetail = User::where('email', $request->mobile)->where('user_type', 2)->first();
           
            if(!empty($afterRegisterCustomerDetail)){
                
                $customer = User::where('email', $request->mobile)->where('user_type', 2)->update([
                    'otp' => $otp
                ]);

                $afterRegisterCustomerDetailforEmail = User::where('email', $request->mobile)->where('user_type', 2)->first();

                if(!empty(@$afterRegisterCustomerDetailforEmail->mobile)){
                    $sms = sendSms(@$afterRegisterCustomerDetailforEmail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                    
                }
                if(@$afterRegisterCustomerDetailforEmail->email){
                    Mail::to(@$afterRegisterCustomerDetailforEmail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetailforEmail));
                }
                //session()->forget('customer');
                //dd($customer);
                //$request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your email successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }

        }else{

            $this->validate($request, [
                'mobile' => 'required|digits:10',
            ]);
            
            $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->where('user_type', 2)->first();
            if(!empty($afterRegisterCustomerDetail)){
                $customer = User::where('mobile', $request->mobile)->where('user_type', 2)->update([
                    'otp' => $otp
                ]);

                $afterRegisterCustomerDetailForMobile = User::where('mobile', $request->mobile)->where('user_type', 2)->first();

                if(!empty($afterRegisterCustomerDetailForMobile->mobile)){

                    $sms = sendSms($afterRegisterCustomerDetailForMobile->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                }
                
                if($afterRegisterCustomerDetailForMobile->email){
                    Mail::to($afterRegisterCustomerDetailForMobile->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetailForMobile));
   
                }
               
                //session()->forget('customer');
                
                //$request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your mobile successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }
        }
       
        
    }


    public function resendOtpForSales(Request $request){
        //pr($request->all());
        $this->validate($request, [
            'mobile' => 'required',
        ]);
        //echo "<pre>";print_r($request->all());exit;
        //$otp = 123456;
       $otp = generateOtp(6);
    //    $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->orWhere('email', $request->mobile)->where('user_type', 2)->first();
        if (filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false) {
            $this->validate($request, [
                'mobile' => 'email',
            ]);
           
            $afterRegisterCustomerDetail = User::where('email', $request->mobile)->where('user_type', 2)->first();
            if(!empty($afterRegisterCustomerDetail)){
                $customer = User::where('email', $request->mobile)->where('user_type', 2)->update([
                    'otp' => $otp
                ]);

                $afterRegisterCustomerDetailFormail = User::where('email', $request->mobile)->where('user_type', 2)->first();
                
                if(!empty(@$afterRegisterCustomerDetailFormail->mobile)){
                    $sms = sendSms(@$afterRegisterCustomerDetailFormail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                    
                   

                }
                if(@$afterRegisterCustomerDetailFormail->email){
                    Mail::to(@$afterRegisterCustomerDetailFormail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetailFormail));
                }
                //session()->forget('customer');
                //dd($customer);
                //$request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your email successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }

        }else{

            $this->validate($request, [
                'mobile' => 'required|digits:10',
            ]);
            // $customer = User::where('mobile', $request->mobile)->update([
            //     'otp' => $otp
            // ]);
            $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->where('user_type', 2)->first();
            if(!empty($afterRegisterCustomerDetail)){
                $customer = User::where('mobile', $request->mobile)->where('user_type', 2)->update([
                    'otp' => $otp
                ]);

                $afterRegisterCustomerDetailForMobile = User::where('mobile', $request->mobile)->where('user_type', 2)->first();

                if(!empty($afterRegisterCustomerDetailForMobile->mobile)){

                    $sms = sendSms($afterRegisterCustomerDetailForMobile->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                }
                
                if($afterRegisterCustomerDetailForMobile->email){
                    Mail::to($afterRegisterCustomerDetailForMobile->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetailForMobile));
   
                }
               
                //session()->forget('customer');
                
                //$request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your mobile successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }
        }
       
        
    }


    public function verifyOtpForSales(Request $request){
        //pr($request->all());
        $this->validate($request, [
            'otp' => 'required',
            'mobile' => 'required',
            'password' => 'required',
        ]);
        
        if(filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false){
            $field = 'email';
        }else{
            $field = 'mobile';
        }

        $salesOtpCheck = User::where($field, $request->mobile)
        ->where('otp', $request->otp)
        //->where('password', Hash::make($request->password))
        ->where('user_type', 2)
        ->first();

        if(filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false){
            $fields = 'seller_email';
        }else{
            $fields = 'seller_phone';
        }
        $seller = Sellers::where($fields, $request->mobile)
        ->where('seller_password', $request->password)
        ->where('user_type', 2)
        ->first();
        
        // $seller = Sellers::where($field, $request->mobile)
        // ->where('seller_password', $request->password)
        // ->first();
        // if (Hash::check($request->password, $salesOtpCheck->password)) {
        //     pr($salesOtpCheck);
        // }
        // echo $salesOtpCheck->password;pr($salesOtpCheck);
        if ($salesOtpCheck && $seller)
        { 
            if($seller->status == 0){

                return Response::json(array('status' => 'success', 'msg' => 'Your account is deactive.', 'url' => route('salesLoginLayout')));
                //return redirect()->route('salesLoginLayout')->with('msg','Your account is deactive.');
            }else{

                
                //Auth::login($seller);
                $request->session()->put('sales', $seller);
                //echo "vvv";pr(session()->get('sales'));
                return Response::json(array('status' => 'success', 'msg' => 'You are successfully logged in.', 'url' => route('SalesDashboard')));
                //return redirect()->route('SalesDashboard');
            }
            
            
        }else{
            return Response::json(array('status' => 'warning', 'msg' => 'Somthing is wrong please check your login detail.', 'url' => route('salesLoginLayout')));
            //return redirect()->route('salesLoginLayout')->with('msg','Invalid Email Or Password.');
           
        }

        // if ($seller)
        // { 
        //     Auth::login($customer);
        //     if($customer->profile == 0){

        //         return Response::json(array('status' => 'success', 'msg' => 'You are successfully logged in.', 'url' => route('dashboard')));
        //     }
        //     return Response::json(array('status' => 'success', 'msg' => 'You are successfully logged in.', 'url' => route('home')));
            
        // }else{
        //     return Response::json(array('status' => 'warning', 'msg' => 'Please enter valid otp', 'mobile' =>$request->mobile));
        // }

    }


    // public function salesLogin(Request $request){
        
    //     $this->validate($request, [
    //         'email' => 'required',
    //         'password' => 'required',
    //     ]);
    //     //pr($request->all());seller_phone
    //     $seller = Sellers::where('seller_email', $request->email)
        
    //     ->where('seller_password', $request->password)
    //     ->where('seller_password', $request->password)
    //     ->first();

    //     //$seller = User::where('email', $request->email)->first();
    //        //pr($seller);
    //      //if (Hash::check($request->password, $seller->password))
    //     if ($seller)
    //     { 
    //         if($seller->status == 0){

    //             return redirect()->route('salesLoginLayout')->with('msg','Your account is deactive.');
    //         }else{

    //             //Auth::login($seller);

    //             $request->session()->put('sales', $seller);
            
    //             return redirect()->route('SalesDashboard');
    //         }
            
            
    //     }else{
    //         return redirect()->route('salesLoginLayout')->with('msg','Invalid Email Or Password.');
           
    //     }

    // }

    public function logout(Request $request)
    {
        Auth::logout();
        session()->forget('customer');
        session()->forget('sales');
        session()->forget('customerForSalesPanel');
        //$request->session()->regenerate();

        return redirect('/');
    }
}
