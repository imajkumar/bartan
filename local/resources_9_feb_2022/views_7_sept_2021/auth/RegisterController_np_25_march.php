<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use App\Mail\CustomerRegistrationOtpMail;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function sendOtp(Request $request){
        //echo "<pre>";print_r($request->all());exit;
        //$otp = 123456;
       $otp = generateOtp(6);
       $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->orWhere('email', $request->mobile)->where('user_type',0)->first();
        if (filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false) {
            $this->validate($request, [
                'mobile' => 'email',
                // 'mobile' => 'email|unique:users,email',
            ]);
           
            
            $customer = User:: updateOrCreate([
                'email' => $request->mobile,
                'user_type' => 0
                
            ],[
                'email' => $request->mobile,
                'otp' => $otp
            ]);
           
           
            if($customer){
                
                if(!empty($afterRegisterCustomerDetail)){
                    $sms = sendSms($afterRegisterCustomerDetail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                    
                    Mail::to($afterRegisterCustomerDetail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetail));

                }else{
                    Mail::to($customer->email)->send(new CustomerRegistrationOtpMail($customer));

                }
                session()->forget('customer');
                //dd($customer);
                $request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your email successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }

        }else{

            $this->validate($request, [
                'mobile' => 'required|digits:10',
                // 'mobile' => 'required|digits:10|unique:users,mobile',
            ]);
            $customer = User:: updateOrCreate([
                'mobile' => $request->mobile,
                'user_type' =>0
                
            ],[
                'mobile' => $request->mobile,
                'otp' => $otp
            ]);
       
            if($customer){

                if(!empty($afterRegisterCustomerDetail)){

                    $sms = sendSms($afterRegisterCustomerDetail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                   
                    Mail::to($afterRegisterCustomerDetail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetail));
   
                   }else{
                    $sms = sendSms($request->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                        
                }
               
                session()->forget('customer');
                
                $request->session()->put('customer', $customer);
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your mobile successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }
        }
       
        
       
        
        
    }

    public function resendOtp(Request $request){
        $customer = session()->get('customer');
       // $otp = 123456;
        $otp = generateOtp(6);
        //  echo $customer->mobile; 
        //  dd($request->all());
        $afterRegisterCustomerDetail = User::where('mobile', $request->mobile)->orWhere('email', $request->mobile)->where('user_type',0)->first();
        if (filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false) {
            
            // $this->validate($request, [
            //     'mobile' => 'email|unique:users,email',
            // ]);
            $customer = User:: updateOrCreate([
                'email' => $request->mobile,
                'user_type' => 0,

                
            ],[
                'email' => $request->mobile,
                'otp' => $otp
            ]);
            
            
            if($customer){
                if(!empty($afterRegisterCustomerDetail)){
                    $sms = sendSms($afterRegisterCustomerDetail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                    
                    Mail::to($afterRegisterCustomerDetail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetail));

                }else{
                    Mail::to($customer->email)->send(new CustomerRegistrationOtpMail($customer));

                }
                $customer = session()->get('customer'); 
                $customer->otp = $otp;
                $customer->save();
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your email successfully.','mobile' =>$request->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }

        }else{

            // $this->validate($request, [
            //     'mobile' => 'required|digits:10|unique:users,mobile',
            // ]);

            $customer = User:: updateOrCreate([
                'mobile' => $customer->mobile,
                'user_type' =>0
                
            ],[
                'mobile' => $customer->mobile,
                'otp' => $otp
            ]);
           

            if($customer){
               
                if(!empty($afterRegisterCustomerDetail)){

                    $sms = sendSms($afterRegisterCustomerDetail->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                   
                    Mail::to($afterRegisterCustomerDetail->email)->send(new CustomerRegistrationOtpMail($afterRegisterCustomerDetail));
   
                   }else{
                    $sms = sendSms($request->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                        
                }
                //$sms = sendSms($customer->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                
                $customer = session()->get('customer'); 
                $customer->otp = $otp;
                $customer->save();
                return Response::json(array('status' => 'success', 'msg' => 'OTP send to your mobile successfully.','mobile' =>$customer->mobile));
            }else{
                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again.'));
            }
        }
       
        
        
    }

   
    public function verifyOtp(Request $request){
        $this->validate($request, [
            'otp' => 'required',
        ]);
        
        if(filter_var($request->mobile, FILTER_VALIDATE_EMAIL) !== false){
            $field = 'email';
        }else{
            $field = 'mobile';
        }

        $customer = User::where($field, $request->mobile)->where('otp', $request->otp)->where('user_type', 0)->first();
        if ($customer)
        { 
            Auth::login($customer);
            if($customer->profile == 0){

                return Response::json(array('status' => 'success', 'msg' => 'You are successfully logged in.', 'url' => route('dashboard')));
            }
            return Response::json(array('status' => 'success', 'msg' => 'You are successfully logged in.', 'url' => route('home')));
            
        }else{
            return Response::json(array('status' => 'warning', 'msg' => 'Please enter valid otp', 'mobile' =>$request->mobile));
        }

    }
}
