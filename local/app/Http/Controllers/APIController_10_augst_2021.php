<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use App\paymentStatus;
use Session;
use Razorpay\Api\Api;
include 'Crypto.php';

class APIController extends Controller
{

    public function ccPaymentResponce(Request $request){

        //pr($request->all());
        //error_reporting ( 0 );
    
        $workingKey = '3401118941EDF8147D680B7092BACC82'; // Working Key should be provided here.
                //Working Key should be provided here.
        $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server

        $rcvdString=decryptA($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
        $order_status="";
        $decryptValues=explode('&', $rcvdString);
        $dataSize=sizeof($decryptValues);
        $ex = explode("=",$decryptValues[0]);
        $orderID=$ex[1];

        $jsonRe = json_encode($decryptValues);
        $up = DB::table('tbl_payment_status')->where('item_order_id', $orderID)->update([
                'payment_gateway_info' => $jsonRe
        ]);
        echo "Success";die;

        
        echo "<center>";

        for($i = 0; $i < $dataSize; $i++) 
        {
            $information=explode('=',$decryptValues[$i]);
            if($i==3)	$order_status=$information[1];
        }
        
        if($order_status==="Success")
        {
            echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
            
        }
        else if($order_status==="Aborted")
        {
            echo "<br>Thank you for shopping with us. We will keep you posted regarding the status of your order through e-mail";

        }
        else if($order_status==="Failure")
        {
            echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
        }
        else
        {
            echo "<br>Security Error. Illegal access detected";

        }

        echo "<br><br>";

        echo "<table cellspacing=4 cellpadding=4>";
        for($i = 0; $i < $dataSize; $i++) 
        {
            $information=explode('=',$decryptValues[$i]);
                echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
        }

        echo "</table><br>";
        echo "</center>";
        die;

    }

    public function ccPaymentCancelResponce(Request $request){

    }
   public function ccpay(Request $request){
    print_r($request->all());
   }
    public function afterPaymentByLinkCron()
    {
        $pendingOrders = DB::table('tbl_payment_status')->where('status', 0)->get();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        foreach($pendingOrders as $pendingOrder){
            if(!empty($pendingOrder->payment_invoice_id)){
                
                //$invoice  = $api->invoice->fetch('inv_GlEIpCQ0pHw41i');
                //$invoice->cancel();
                //$invoice->notifyBy('sms');
                //$invoice->notifyBy('email');
                //echo $invoice['amount_paid'];pr($invoice);
                $invoice  = $api->invoice->fetch($pendingOrder->payment_invoice_id);
                if($invoice->amount_paid !=0)
                {

                    $invoiceArray = (array) @$invoice;
                    if($invoice['amount_due'] ==0 && $invoice['amount_paid'] !=0){
                        $status = 1;
                        $pending_amount = 0;
                      
                    }else{
                        $status = 0; 
                        $pending_amount = $invoice['amount_due'];
                    }
                    $paymntStausUpdate =  paymentStatus::where('payment_invoice_id', $pendingOrder->payment_invoice_id)
                    ->update([
                        'paid_amount' => $invoice['paid_amount'],
                        'status' => $status,
                        'pending_amount' => $pending_amount,
                        'payment_info_pay_by_link' => json_encode($invoiceArray),
                    ]);

                    if($invoice['amount_due'] ==0 && $invoice['amount_paid'] !=0){
                        $invoice->cancel();
                    }
        
                }
                
                
            }
        }

    }

    public function sendOtp(Request $request)
    {
        
        // $this->validate($request, [
        //     'mobile' => 'required|digits:10',
        // ]);
        $validator = Validator::make($request->all(),[
            'mobile' => 'required|digits:10',
        ]);
        if ($validator->fails()) {
            $res_arr = array(
                'status' => 0,
                'mobile' => $request->mobile,
                'Message' => 'Invalid Mobile Number.',
                'coreCode' => 'OTP-01',
              );
            return response()->json($res_arr);
        }

        $otp = generateOtp(6);
        
       
            
            $customer = User:: updateOrCreate([
                'mobile' => $request->mobile
                
            ],[
                'mobile' => $request->mobile,
                'otp' => $otp
            ]);
            //dd($request->all());
            if($customer){
                
                $sms = sendSms($request->mobile, $otp." is the OTP to login into your Subhiksh account. Please enter OTP to proceed.");
                
                session()->forget('customer');
                
                $request->session()->put('customer', $customer);
                $res_arr = array(
                    'status' => 1,
                    'otp' => $otp,
                    'mobile' => $request->mobile,
                    'Message' => 'OTP send succesfully.',
                    'coreCode' => 'OTP-01',
                    );
                return response()->json($res_arr);
            }else{
                $res_arr = array(
                    'status' => 0,
                    'otp' => @$otp,
                    'mobile' => $request->mobile,
                    'Message' => 'Something is wrong try again.',
                    'coreCode' => 'OTP-01',
                    );
                return response()->json($res_arr);
            }
            
        
        
        
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mobile' => 'required|digits:10',
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            $res_arr = array(
                'status' => 0,
                'data' => '',
                'Message' => 'Invalid Mobile Number Or OTP.',
                'coreCode' => 'OTP-01',
            );
            return response()->json($res_arr);
        }

        $customer = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
        if ($customer)
        { 
            Auth::login($customer);
            // if($customer->profile == 0){

            //     return Response::json(array('status' => 'success', 'msg' => 'You are login successfull.', 'url' => route('dashboard')));
            // }
            //return Response::json(array('status' => 'success', 'msg' => 'You are login successfull.', 'url' => route('home')));
            $res_arr = array(
                'status' => 1,
                'data' => $customer,
                'Message' => 'You are login successfull.',
                'coreCode' => 'Login-01',
                );
            
            
        }else{
            $res_arr = array(
                'status' => 0,
                'otp' => $otp,
                'mobile' => $request->mobile,
                'Message' => 'Please enter valid otp.',
                'coreCode' => 'Login-01',
                );
           
           
        }
        return response()->json($res_arr);
    }

    public function saveCustomerProfileDetails(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cutomer_fname' => 'required|string|max:120',
            'cutomer_lname' => 'required|string|max:120',
           // 'f_name' => 'required|string|max:120',
           // 'l_name' => 'required|string|max:120',
           'email' => 'required|string|max:50',
           //'gender' => 'required',
           //'dob' => 'max:15',
           // 'mobile' => 'required|integer|digits:10',
           'mobile' => 'required|digits:10',
           // 'street_address' => 'required|string',
           'business_street_address' => 'required',
           'business_country' => 'required',
            'store_name' => 'required',
            'customer_type' => 'required',
            'business_state' => 'required',
            'business_city' => 'required',
          
            'business_postal_code' => 'required|integer',
            'business_gst_number' => 'required',
            'gst_certificate' => 'required',
            'shop_establishment_license' => 'required',
            'msme_udyog_adhar' => 'required',
            'FSSAI_certificate' => 'required',
            'Trade_certificate' => 'required',
           
       ], [
        'cutomer_fname.required' => 'First name is required.',
        'cutomer_fname.string' => 'First name should be string.',
        'cutomer_fname.max' => 'First name should not be grater than 120 Character.',
        
        'cutomer_lname.required' => 'Last name is required.',
        'cutomer_lname.string' => 'Last name should be string.',
        'cutomer_lname.max' => 'Last name should not be grater than 120 Character.',
        // 'f_name.required' => 'First name is required.',
        // 'f_name.string' => 'First name should be string.',
        // 'f_name.max' => 'First name should not be grater than 120 Character.',

        'mobile.required' => 'Mobile number is required.',
        'mobile.integer' => 'Mobile number should be number.',
        'mobile.digit' => 'Mobile number should not be grater than 10 Character.',

        // 'l_name.required' => 'Last name is required.',
        // 'l_name.string' => 'Last name should be string.',
        // 'l_name.max' => 'Last name should not be grater than 120 Character.',
        //'dob.max' => 'Date of birth should not be grater than 15 Character.',
        
        //'gender.required' => 'Gender is required.',
        'email.required' => 'Email is required.',
        'email.string' => 'Email should be string.',
        'email.max' => 'Email should not be grater than 50 Character.',

         'store_name.required' => 'Store name is required.',
         'customer_type.required' => 'Customer type is required.',
         'business_street_address.required' => 'Address is required.',
         'business_country.required' => 'Country is required.',
         'business_state.required' => 'State is required.',
         'business_city.required' => 'City is required.',
       
        
        'business_postal_code.required' => 'Postal code is required.',
        'business_postal_code.integer' => 'Postal code should be number.',
        'business_gst_number.required' => 'GST number is required.',
        // 'business_gst_number.regex' => 'GST number format is not valid.',
        'gst_certificate.required' => 'GST Certificate is required.',
        'shop_establishment_license.required' => 'Shop establishment license is required.',
        'msme_udyog_adhar.required' => 'MSME udyog adhar is required.',
        'FSSAI_certificate.required' => 'FSSAI certificate is required.',
        'Trade_certificate.required' => 'Trade certificate is required.',
       
        
    ]);
       if ($validator->fails()) {
            $res_arr = array(
                'status' => 0,
                'errorMsg' => $validator->errors()->all(),
                //'Message' => 'Invalid Mobile Number Or OTP.',
                'coreCode' => 'saveCustomerProfileDetails-01',
            );
            return response()->json($res_arr);
        }
             //pr($request->all());
              $query = 0;
               $status = 0;
               $customerData = DB::table('tbl_customers')->updateOrInsert(
                   [
                       'user_id' => $request->customer_id,
                   ],[
                   'cutomer_fname' => $request->cutomer_fname,
                   'cutomer_lname' => $request->cutomer_lname,
                   'email' => $request->email,
                   //'gender' => $request->gender,
                   //'dob' => $request->dob,
                   'phone' => $request->mobile,
                   'status' => $status,
                   'customer_type' => $request->customer_type,
                   'cutomer_state' => $request->business_state,
                   
               ]);
       
               if ($customerData) {
                   $query = 1;
               }
               
               $parent_code = get_unique_code();
               // if($request->parent_code){
               //      $parent_code = get_unique_code();
               // }else{
               //     $parent_code = '';
               // }
       
               $customer = DB::table('tbl_customers')->where('user_id', $request->customer_id)->first();
       
               $businessData = DB::table('tbl_businesses')->updateOrInsert(
                   [
                       'busines_user_id' => $request->customer_id,
                       'customer_id' => $customer->id,
                   ],[
                   'store_name' => $request->store_name,
                   'business_street_address' => $request->business_street_address,
                   'business_gst_number' => $request->business_gst_number,
                   'business_country' => $request->business_country,
                   'business_state' => $request->business_state,
                   'business_city' => $request->business_city,
                   'business_postal_code' => $request->business_postal_code,
                   'parent_code' => $parent_code,
               ]);
       
               if ($businessData) {
                   $query = 1;
               }
       
               $gst_name = '';
                   $license_name = '';
                   $msme_udyog_adhar_name = '';
                   $FSSAI_certificate_name = '';
                   $Trade_certificate_name = '';
                   if ($request->hasFile('gst_certificate')) 
                   {
                       $img = $request->file('gst_certificate');
                       $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                       $destinationPath = ITEM_IMG_PATH;
                       $gst_name = 'GST_'.date('mdis').$name;
                       $img->move($destinationPath, $gst_name);
       
                       //$customerdetail = get_custumer_by_user_id($customer->id);
                       if (File::exists($destinationPath.'/'.$request->gst_certificate_old)) {
                           File::delete($destinationPath.'/'.$request->gst_certificate_old);
                       }
                   }
       
                   if ($request->hasFile('shop_establishment_license')) 
                   {
                       $img = $request->file('shop_establishment_license');
                       $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                       $destinationPath = ITEM_IMG_PATH;
                       $license_name = 'Shop_license_'.date('mdis').$name;
                       $img->move($destinationPath, $license_name);
       
                       if (File::exists($destinationPath.'/'.$request->shop_establishment_license_old)) {
                           File::delete($destinationPath.'/'.$request->shop_establishment_license_old);
                       
                       }
                   }
       
                   if ($request->hasFile('msme_udyog_adhar')) 
                   {
                       $img = $request->file('msme_udyog_adhar');
                       $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                       $destinationPath = ITEM_IMG_PATH;
                       $msme_udyog_adhar_name = 'Udyog_adhar_'.date('mdis').$name;
                       $img->move($destinationPath, $msme_udyog_adhar_name);
       
                       if (File::exists($destinationPath.'/'.$request->msme_udyog_adhar_old)) {
                           File::delete($destinationPath.'/'.$request->msme_udyog_adhar_old);
                       }
                   }
       
                   if ($request->hasFile('FSSAI_certificate')) 
                   {
                       $img = $request->file('FSSAI_certificate');
                       $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                       $destinationPath = ITEM_IMG_PATH;
                       $FSSAI_certificate_name = 'FSSAI_certificate_'.date('mdis').$name;
                       $img->move($destinationPath, $FSSAI_certificate_name);
       
                       if (File::exists($destinationPath.'/'.$request->FSSAI_certificate_old)) {
                           File::delete($destinationPath.'/'.$request->FSSAI_certificate_old);
                       }
                   }
       
                   if ($request->hasFile('Trade_certificate')) 
                   {
                       $img = $request->file('Trade_certificate');
                       $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                       $destinationPath = ITEM_IMG_PATH;
                       $Trade_certificate_name = 'Trade_certificate_'.date('mdis').$name;
                       $img->move($destinationPath, $Trade_certificate_name);
       
                       if (File::exists($destinationPath.'/'.$request->Trade_certificate_old)) {
                           File::delete($destinationPath.'/'.$request->Trade_certificate_old);
                       }
                   }
       
                   $documents = DB::table('tbl_customer_documents')->updateOrInsert(
                       [
                           'customer_id' => $customer->id,
                           'customer_docs_user_id' => $request->customer_id,
                       ],[
                           'gst_certificate' => ($gst_name) ? $gst_name : $request->gst_certificate_old,
       
                           'shop_establishment_license' => ($license_name) ? $license_name : $request->shop_establishment_license_old,
                           
                           'msme_udyog_adhar' => ($msme_udyog_adhar_name) ? $msme_udyog_adhar_name : $request->msme_udyog_adhar_old,
                           
                           'FSSAI_certificate' => ($FSSAI_certificate_name) ? $FSSAI_certificate_name : $request->FSSAI_certificate_old,
                           
                           'Trade_certificate' => ($Trade_certificate_name) ? $Trade_certificate_name : $request->Trade_certificate_old,
                       ]);
           
                       if ($documents)
                       {
                       
                           $query = 1;
                       }
       
                   
                   //Start code for documents
                    
                    //End code for documents
               
               if ($query ==1) {
       
                   $user = User::find($request->customer_id);
                   $user->profile = 0;
                   $user->mobile = $request->mobile;
                   $user->name = $request->cutomer_fname.' '.$request->cutomer_lname;
                   $user->email = $request->email;
                   $user->save();
       
                //    $customer = session()->get('customer'); 
                //    $customer->profile = 0;
                //    $customer->mobile = $request->mobile;
                //    $customer->save();
                   
                   $res_arr = array(
                    'status' => 1,
                    'data' => $customer,
                    'Message' => 'Customer Profile save successfully.',
                    'coreCode' => 'saveCustomerProfileDetails-01',
                    );
                   
               } else {

                    $res_arr = array(
                        'status' => 0,
                        'Message' => 'Something is wrong try again.',
                        'coreCode' => 'saveCustomerProfileDetails-01',
                        );
                   
               }

               return response()->json($res_arr);
       
    }

    public function getcustomerProfileByUserId($user_id)
    {
       $customer = get_customer_and_address_by__user_id($user_id);
        
        if($customer){
            $res_arr = array(
                'status' => 1,
                'data' => $customer,
                'Message' => 'Customer Profile.',
                'coreCode' => 'getcustomerProfileByUserId-01',
                );
        }else{
            $res_arr = array(
                'status' => 0,
                'Message' => 'Customer Profile not found.',
                'coreCode' => 'getcustomerProfileByUserId-01',
                );
        }
        return response()->json($res_arr);
       
    }
    

    // public function login(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'mobile' => 'required|digits:10',
    //         'otp' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         $res_arr = array(
    //             'status' => 0,
    //             'data' => '',
    //             'Message' => 'Invalid Mobile Number.',
    //             'coreCode' => 'OTP-01',
    //         );
    //         return response()->json($res_arr);
    //     }
       

    //     $customer = User::where('mobile', $request->mobile)->where('otp', $request->otp)->first();
    //     if ($customer)
    //     { 
    //         Auth::login($customer);
    //         // if($customer->profile == 0){

    //         //     return Response::json(array('status' => 'success', 'msg' => 'You are login successfull.', 'url' => route('dashboard')));
    //         // }
    //         return Response::json(array('status' => 'success', 'msg' => 'You are login successfull.', 'url' => route('home')));
    //         $res_arr = array(
    //             'status' => 1,
    //             'data' => $customer,
    //             'Message' => 'You are login successfull.',
    //             'coreCode' => 'Login-01',
    //             );
            
            
    //     }else{
    //         $res_arr = array(
    //             'status' => 1,
    //             'otp' => $otp,
    //             'mobile' => $request->mobile,
    //             'Message' => 'Please enter valid otp.',
    //             'coreCode' => 'Login-01',
    //             );
           
           
    //     }
    //     return response()->json($res_arr);

    // }

    // public function register(Request $request)
    // {
    //     $validator = Validator::make($request->all(),[
    //         'mobile' => 'required|digits:10',
    //         'otp' => 'required',
    //     ]);
    //     if ($validator->fails()) {
    //         $res_arr = array(
    //             'status' => 0,
    //             'data' => '',
    //             'Message' => 'Invalid Mobile Number Or OTP.',
    //             'coreCode' => 'OTP-01',
    //         );
    //         return response()->json($res_arr);
    //     }
        

    //     $customer = User:: updateOrCreate([
    //         'mobile' => $request->mobile
            
    //     ],[
    //         'mobile' => $request->mobile,
    //         'otp' => $otp
    //     ]);
        
    //     if ($customer)
    //     { 
           
    //         return Response::json(array('status' => 'success', 'msg' => 'You are register successfull.'));
    //         $res_arr = array(
    //             'status' => 1,
    //             //'data' => $customer,
    //             'Message' => 'You are register successfull.',
    //             'coreCode' => 'Register-01',
    //             );
            
            
    //     }else{
    //         $res_arr = array(
    //             'status' => 0,
                
    //             'Message' => 'Somthing is wrong.',
    //             'coreCode' => 'Register-01',
    //             );
           
           
    //     }
    //     return response()->json($res_arr);

    // }

        //response 
        // $res_arr = array(
        //     'status' => 0,
        //     'data' => '',
        //     'Message' => 'Invalid Login',
        //     'coreCode' => 'login-01',
        //   );
        // return response()->json($res_arr);
        //response 

    
}
