<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;
use DB;
use Validator;
use session;
use Theme;
use File;
use App\User;
use Auth;
use App\Mail\CustomerRegistrationProfilSubmitMail;
use Illuminate\Support\Facades\Mail;


class CustomerController extends Controller
{
    public function __construct()
    {
        // $this->middleware(function ($request, $next) {
        //     $this->checkCustomer = session()->get('customer');
        //     if(empty($this->checkCustomer)){
                
        //         //pr($this->checkSales);
        //         return redirect()->route('showCustomerLoginForm');
        //     }
        //     return $next($request);
        // });
        
        // $this->middleware('auth');
        // if (Auth::user()) {   
        //   $this->middleware('auth');
        // } else {
        //     $this->middleware('guest');

        // }
        //$this->middleware('customerLogoutAfterSomeDays');
        // $this->middleware('customerLogoutAfterSomeDays',['except' => ['login','showCustomerLoginForm','salesLoginLayout','dashboard','home']]);

        $customer = session()->get('customer');
        
        if (!$customer) {
           
            $this->middleware('customerCheckLogin');
            
        }

    }

    public function viewOrderCustumer($orderId){

        $itemOrders = DB::table('tbl_item_orders')
            ->where('customer_id', Auth::user()->id)
            ->where('order_id', $orderId)
            ->get();
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.view_order_custumer', compact('itemOrders'))->render();
        
    }

    // public function viewOrderAdmin($orderId){
        

    //     $itemOrders = DB::table('tbl_item_orders')
    //         ->where('order_id', $orderId)
    //         ->get();
            
    //     $theme = Theme::uses('backend')->layout('layout');
    //    return $theme->scope('admin.view_order_admin', compact('itemOrders'))->render();
        
    // }

    public function myOrderList(){

        
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        //pr($itemOrders);
        // $itemOrders = DB::table('tbl_item_orders')
        //     ->where('customer_id', Auth::user()->id)
        //     ->get();
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();
        
    }

    public function myPendingOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 0)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myConfirmOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 1)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myCancelOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 6)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myShipping()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 3)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myPacked()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 2)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myReturnOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 7)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myDeliveredOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 4)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    public function myHoldOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('tbl_item_orders.stage', 5)
        ->where('.tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_customer', compact('itemOrders'))->render();

    }

    
    public function checksms(Request $request){
       
        $sms = sendSms('8218526749', "Your OTP is 1222");
        pr($sms);
    }

    public function customerProfileWizard(){

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.customerProfileWizard')->render();
    }

   public function saveCustomerProfileDetails(Request $request)
    {
        
         pr($request->all());
        //$request->gst_certificate_old;
        // $request->customer_id
        // $checkDoc = DB::table('tbl_customer_documents')->where('id', $request->docs_id)->first();
        // if(empty($checkDoc->gst_certificate) && !$request->hasFile('gst_certificate')){
        //     $this->validate($request, [
                
                //'gst_certificate' => 'required',
                //'shop_establishment_license' => 'required',
                //'msme_udyog_adhar' => 'required',
                //'FSSAI_certificate' => 'required',
                //'Trade_certificate' => 'required',
               
        //    ]);
        // }
        $this->validate($request, [
             'cutomer_fname' => 'required|string|max:120',
             'cutomer_lname' => 'required|string|max:120',
            // 'f_name' => 'required|string|max:120',
            // 'l_name' => 'required|string|max:120',
            //'email' => 'required|string|max:50',
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
             //'business_gst_number' => 'required',
             //'gst_certificate' => 'required',
             'gst_certificate' => 'max:500000',
             'shop_establishment_license' => 'max:500000',
             //'shop_establishment_license' => 'required',
             //'msme_udyog_adhar' => 'required',
             //'FSSAI_certificate' => 'required',
             //'Trade_certificate' => 'required',
             //'payment_option' => 'required',

             'FSSAI_certificate' => 'max:500000',
             'Trade_certificate' => 'max:500000',
             'adhar_card' => 'max:500000',
            //  'driving_license' => 'max:500000',
             'cancel_bank_cheque' => 'max:500000',
             'dealer_photo' => 'max:500000',
             'other_document' => 'max:500000',
            
            
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
            'gst_certificate.max' => 'GST Certificate max size 5MB.',
            'shop_establishment_license.required' => 'Shop establishment license is required.',
            //'msme_udyog_adhar.required' => 'MSME udyog adhar is required.',
            'FSSAI_certificate.required' => 'FSSAI certificate is required.',
            'Trade_certificate.required' => 'Trade certificate is required.',
            //'payment_option.required' => 'Payment option is required.',
            'FSSAI_certificate.max' => 'PAn Copy max size 5MB.',
            'adhar_card.max' => 'Adhar Card max size 5MB.',
            'shop_establishment_license.max' => 'Shop establishment license max size 5MB.',
            'Trade_certificate.max' => 'Trade certificate max size 5MB.',
            'driving_license.max' => 'Trade certificate max size 5MB.',
            'cancel_bank_cheque.max' => 'Cancel bank cheque max size 5MB.',
            'dealer_photo.max' => 'Dealer photo max size 5MB.',
            'other_document.max' => 'Other document max size 5MB.',
            
            
        ]);
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
            
            'phone' => $request->mobile,
            'status' => $status,
            'customer_type' => $request->customer_type,
            'cutomer_state' => $request->business_state,
            //'payment_option' => $request->payment_option,
            'dob' => $request->dob,
            'supouse_name' => $request->supouse_name,
            'anniversary_date' => $request->anniversary_date,
            'shop_estable_date' => $request->shop_estable_date,

            'geo_location' => $request->geo_location,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            
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

            'business_gst_number' => @$request->business_gst_number,
            'pan_number' => @$request->pan_number,
            'adhar_number' => @$request->adhar_number,
            //'dl_number' => @$request->dl_number,
            'cancel_check' => @$request->cancel_check,
            'shop_establishment_number' => @$request->shop_establishment_number,
            'Trade_certificate_number' => @$request->Trade_certificate_number,

            'business_country' => $request->business_country,
            'business_state' => $request->business_state,
            'business_city' => $request->business_city,
            'business_postal_code' => $request->business_postal_code,
            'parent_code' => $parent_code,

            'shop_number' => $request->shop_number,
            'street' => $request->street,
        ]);

        if ($businessData) {
            $query = 1;
        }

        

        // $addressData = DB::table('tbl_addresses')->updateOrInsert(
        //     [
        //         'customer_id' => $customer->id,
        //         'id' => $request->address_id,
        //         'check_page' => 0,
        //     ],[
        //         //'f_name' => $request->f_name,
        //         //'l_name' => $request->l_name,
        //         'customer_id' => $customer->id,
        //         'address_user_id' => $request->customer_id,
        //         //'company_name' => $request->company_name,
        //         'street_address' => $request->street_address,
        //         'gst_number' => $request->gst_number,
        //         'country' => $request->country,
        //         'state' => $request->state,
        //         'city' => $request->city,
        //         'postal_code' => $request->postal_code,
           
        //      ]);

            // if ($addressData)
            // {
            
            //     $query = 1;
            // }
         
            //  if(!empty($request->addr2_fname) && !empty($request->addr2_lname) && !empty($request->addr2_street_address))
            //  {
            //      DB::table('tbl_addresses')->where('customer_id', $customer->id)
            //         ->where('address_user_id', $request->customer_id)
            //         ->where('id', '!=', $request->address_id)->delete();

            //     $address2Data = DB::table('tbl_addresses')->Insert(
            //         // [
            //         //     'customer_id' => $customer->id,
            //         //     'id' => $request->address_id,
            //         //     'default_address' => 0,
            //         //     'check_page' => 0,
            //         // ],
            //         [
            //             'f_name' => $request->addr2_fname,
            //             'l_name' => $request->addr2_lname,
            //             'customer_id' => $customer->id,
            //             'address_user_id' => $request->customer_id,
            //             'street_address' => $request->addr2_street_address,
            //             // 'country' => $request->country,
            //             // 'state' => $request->state,
            //             // 'city' => $request->city,
            //             // 'postal_code' => $request->postal_code,
                   
            //          ]);
            //          if ($address2Data) {
            
            //             $query = 1;
            //         }
            //  }



            // Start code for team
            //  if(count($request->team_name) > 0 && count($request->team_mobile) > 0 && count($request->team_email) > 0)
            //  {
            //     $detTeams = DB::table('tbl_teams')->where('customer_id', $customer->id)
            //     ->where('team_user_id', $request->customer_id)->delete();
            //     for($n = 0; $n < count($request->team_name); $n++)
            //     {

            //     //    echo  $request->team_name[$n];
            //     //    pr($request->team_name);
                    

            //         $teamData = DB::table('tbl_teams')->insert(
            //             [
            //                 'customer_id' => $customer->id,
            //                 'team_user_id' =>$request->customer_id,
            //                 'team_name' => $request->team_name[$n],
            //                 'team_mobile' => $request->team_mobile[$n],
            //                 'team_email' => $request->team_email[$n],
                            
            //             ]);
            //     }

            //     if ($teamData) {
            
            //         $query = 1;
            //     }
            //  }
            // End code for team

            $gst_name = '';
            $license_name = '';
            $msme_udyog_adhar_name = '';
            $FSSAI_certificate_name = '';
            $Trade_certificate_name = '';
            $driving_license_name = '';
            $cancel_bank_cheque_name = '';
            $dealer_photo_name = '';
            $other_document_name = '';

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

            // if ($request->hasFile('msme_udyog_adhar')) 
            // {
            //     $img = $request->file('msme_udyog_adhar');
            //     $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
            //     $destinationPath = ITEM_IMG_PATH;
            //     $msme_udyog_adhar_name = 'Udyog_adhar_'.date('mdis').$name;
            //     $img->move($destinationPath, $msme_udyog_adhar_name);

            //     if (File::exists($destinationPath.'/'.$request->msme_udyog_adhar_old)) {
            //         File::delete($destinationPath.'/'.$request->msme_udyog_adhar_old);
            //     }
            // }

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

            if ($request->hasFile('adhar_card')) 
            {
                $img = $request->file('adhar_card');
                $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                $destinationPath = ITEM_IMG_PATH;
                $adhar_card_name = 'adhar_card_'.date('mdis').$name;
                $img->move($destinationPath, $adhar_card_name);

                if (File::exists($destinationPath.'/'.$request->adhar_card_old)) {
                    File::delete($destinationPath.'/'.$request->adhar_card_old);
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

            // if ($request->hasFile('driving_license')) 
            // {
            //     $img = $request->file('driving_license');
            //     $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
            //     $destinationPath = ITEM_IMG_PATH;
            //     $driving_license_name = 'driving_license_'.date('mdis').$name;
            //     $img->move($destinationPath, $driving_license_name);

            //     if (File::exists($destinationPath.'/'.$request->driving_license_old)) {
            //         File::delete($destinationPath.'/'.$request->driving_license_old);
            //     }
            // }

            if ($request->hasFile('cancel_bank_cheque')) 
            {
                $img = $request->file('cancel_bank_cheque');
                $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                $destinationPath = ITEM_IMG_PATH;
                $cancel_bank_cheque_name = 'cancel_bank_cheque_'.date('mdis').$name;
                $img->move($destinationPath, $cancel_bank_cheque_name);

                if (File::exists($destinationPath.'/'.$request->cancel_bank_cheque_old)) {
                    File::delete($destinationPath.'/'.$request->cancel_bank_cheque_old);
                }
            }
            if ($request->hasFile('dealer_photo')) 
            {
                $img = $request->file('dealer_photo');
                $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                $destinationPath = ITEM_IMG_PATH;
                $dealer_photo_name = 'dealer_photo_'.date('mdis').$name;
                $img->move($destinationPath, $dealer_photo_name);

                if (File::exists($destinationPath.'/'.$request->dealer_photo_old)) {
                    File::delete($destinationPath.'/'.$request->dealer_photo_old);
                }
            }

            if ($request->hasFile('other_document')) 
            {
                $img = $request->file('other_document');
                $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                $destinationPath = ITEM_IMG_PATH;
                $other_document_name = 'other_document_'.date('mdis').$name;
                $img->move($destinationPath, $other_document_name);

                if (File::exists($destinationPath.'/'.$request->other_document_old)) {
                    File::delete($destinationPath.'/'.$request->other_document_old);
                }
            }

            $documents = DB::table('tbl_customer_documents')->updateOrInsert(
                [
                    'customer_id' => $customer->id,
                    'customer_docs_user_id' => $request->customer_id,
                ],[
                    'gst_certificate' => ($gst_name) ? $gst_name : $request->gst_certificate_old,

                    'shop_establishment_license' => ($license_name) ? $license_name : $request->shop_establishment_license_old,
                    
                    //'msme_udyog_adhar' => ($msme_udyog_adhar_name) ? $msme_udyog_adhar_name : $request->msme_udyog_adhar_old,
                    
                    
                    'Trade_certificate' => ($Trade_certificate_name) ? $Trade_certificate_name : $request->Trade_certificate_old,
                    
                    'FSSAI_certificate' => ($FSSAI_certificate_name) ? $FSSAI_certificate_name : $request->FSSAI_certificate_old,
                    //'driving_license' => ($driving_license_name) ? $driving_license_name : $request->driving_license_old,
                    'adhar_card' => ($adhar_card_name) ? $adhar_card_name : $request->adhar_card_old,
                    'cancel_bank_cheque' => ($cancel_bank_cheque_name) ? $cancel_bank_cheque_name : $request->cancel_bank_cheque_old,
                    'dealer_photo' => ($dealer_photo_name) ? $dealer_photo_name : $request->dealer_photo_old,
                    'other_document' => ($other_document_name) ? $other_document_name : $request->other_document_old,
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
            $user->alternate_phone = $request->alternate_phone;
            $user->save();

            $customer = session()->get('customer'); 
            $customer->profile = 0;
            $customer->mobile = $request->mobile;
            $customer->save();

            $CustomerRegistrationProfilSubmitMail = User::where('mobile', $request->mobile)->Where('email', $request->email)->first();
            if($CustomerRegistrationProfilSubmitMail){

                if($request->mobile){

                    sendSms($request->mobile, "Your Subhiksh profile has been successfully submitted, Our team will contact you shortly.");
                }
                if ($request->email) {
                    Mail::to($request->email)->send(new CustomerRegistrationProfilSubmitMail($CustomerRegistrationProfilSubmitMail));
                }
            }
                
            return Response::json(array('status' => 'success', 'msg' => 'Profile save successfully.', 'url' => route('dashboard')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }

    }


   public function updateCustomerProfileDetails(Request $request)
    {
        
        // pr($request->all());
        $this->validate($request, [
            'cutomer_fname' => 'required|string|max:120',
            'cutomer_lname' => 'required|string|max:120',
            'email' => 'required|string|max:50',
            //'mobile' => 'required|integer|digits:10',
            'mobile' => 'required|digits:10',
            'business_street_address' => 'required|string',
            'business_country' => 'required',
            'business_state' => 'required',
            'business_city' => 'required',
            'business_postal_code' => 'required|integer',
            
            'customer_type' => 'required',
            'store_name' => 'required|max:120',
            'business_gst_number' => 'required|max:60',
            // 'gst_certificate' => 'required',
            // 'shop_establishment_license' => 'required',
            // 'msme_udyog_adhar' => 'required',
            // 'FSSAI_certificate' => 'required',
            // 'Trade_certificate' => 'required',
            
            
        ], [

            // 'gst_certificate.required' => 'GST Certificate is required.',
            // 'shop_establishment_license.required' => 'Shop establishment license is required.',
            // 'msme_udyog_adhar.required' => 'MSME Udyog adhar is required.',
            // 'FSSAI_certificate.required' => 'FSSAI Certificate is required.',
            // 'Trade_certificate.required' => 'Trade certificate is required.',

            'customer_type.required' => 'Customer type is required.',
           

            'cutomer_fname.required' => 'First name is required.',
            'cutomer_fname.string' => 'First name should be string.',
            'cutomer_fname.max' => 'First name should not be grater than 120 Character.',

            'store_name.required' => 'Store name is required.',
            'store_name.max' => 'Store name should not be grater than 120 Character.',

            'business_gst_number.required' => 'GST Number is required.',
            'business_gst_number.max' => 'GST Number should not be grater than 120 Character.',

            'mobile.required' => 'Phone name is required.',
            'mobile.integer' => 'Phone number should be number.',
            'mobile.digit' => 'Phone should not be grater than 10 Character.',

            'cutomer_lname.required' => 'Last name is required.',
            'cutomer_lname.string' => 'Last name should be string.',
            'cutomer_lname.max' => 'Last name should not be grater than 120 Character.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email should be string.',
            'email.max' => 'Email should not be grater than 50 Character.',

            'business_street_address.required' => 'Street adrress is required.',
            'business_street_address.string' => 'Street adrress should be string.',
            
            'business_postal_code.required' => 'Postal code is required.',
            'business_postal_code.integer' => 'Postal code should be number.',
            'business_country.required' => 'Country is required.',
            'business_state.required' => 'State is required.',
            'business_city.required' => 'City is required.',
            
        ]);
        $query = 0;
        $status = 3;
        $customerData = DB::table('tbl_customers')->updateOrInsert(
            [
                'user_id' => $request->user_id,
            ],[
            'cutomer_fname' => $request->cutomer_fname,
            'cutomer_lname' => $request->cutomer_lname,
            'user_id' => $request->user_id,
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
        
        

        $customer = DB::table('tbl_customers')->where('user_id', $request->user_id)->first();

        $businessData = DB::table('tbl_businesses')->updateOrInsert(
            [
                'busines_user_id' => $request->user_id,
                'customer_id' => $customer->id,
            ],[
            'store_name' => $request->store_name,
            'store_name' => $request->store_name,
            'business_street_address' => $request->business_street_address,
            'business_gst_number' => $request->business_gst_number,
            'business_country' => $request->business_country,
            'business_state' => $request->business_state,
            'business_city' => $request->business_city,
            'business_postal_code' => $request->business_postal_code,
        ]);

        if ($businessData) {
            $query = 1;
        }

        

        // $addressData = DB::table('tbl_addresses')->updateOrInsert(
        //     [
        //         'customer_id' => $customer->id,
        //         'id' => $request->address_id,
        //         'check_page' => 0,
        //     ],[
        //         'f_name' => $request->f_name,
        //         'l_name' => $request->l_name,
        //         'customer_id' => $customer->id,
        //         'address_user_id' => $request->user_id,
        //         //'company_name' => $request->company_name,
        //         'street_address' => $request->street_address,
        //         'gst_number' => $request->gst_number,
        //         'country' => $request->country,
        //         'state' => $request->state,
        //         'city' => $request->city,
        //         'postal_code' => $request->postal_code,
           
        //      ]);

        //     if ($addressData)
        //     {
            
        //         $query = 1;
        //     }
         
            
            // if(count($request->team_name) > 0 && count($request->team_mobile) > 0 && count($request->team_email) > 0)
            //  {
            //     $detTeams = DB::table('tbl_teams')->where('customer_id', $customer->id)
            //     ->where('team_user_id', $request->customer_id)->delete();
            //     for($n = 0; $n < count($request->team_name); $n++)
            //     {
            //         $teamData = DB::table('tbl_teams')->insert(
            //         [
            //             'customer_id' => $customer->id,
            //             'team_user_id' =>$request->user_id,
            //             'team_name' => $request->team_name[$n],
            //             'team_mobile' => $request->team_mobile[$n],
            //             'team_email' => $request->team_email[$n],
                            
            //         ]);
            //     }

            //     if ($teamData) {
            
            //         $query = 1;
            //     }
            //  }

            
            //Start code for documents

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
                    'customer_docs_user_id' => $request->user_id,
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

             //End code for documents
        
        if ($query ==1) {

            $user = User::find($request->user_id);
            $user->name = $request->cutomer_fname.' '.$request->cutomer_lname;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            $customer = session()->get('customer'); 
            //$customer->profile = 0;
            $customer->mobile = $request->mobile;
            $user->email = $request->email;
            $customer->save();

            return Response::json(array('status' => 'success', 'msg' => 'Profile save successfully.', 'url' => route('customerProfile')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }

    }

    public function addresses()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $customer = session()->get('customer'); 
        if($customer)
        {
            $addresses = get_addresses_by_user_id($customer->id);
            $customer = DB::table('tbl_customers')->where('user_id', $customer->id)->first();
            return $theme->scope('admin.address_list', compact('addresses', 'customer'))->render();
        }
    }

    public function businesses()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $customer = session()->get('customer'); 
        if($customer)
        {
            $addresses = get_addresses_by_user_id($customer->id);
            ///$customer = DB::table('tbl_customers')->where('user_id', $customer->id)->first();
            return $theme->scope('admin.address_list', compact('addresses', 'customer'))->render();
        }
    }

    public function saveProfilePic(Request $request)
    {
        $this->validate($request, [
            'customer_pic' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $customer = session()->get('customer'); 
        if($customer)
        {
            if ($request->hasFile('customer_pic')) 
            {
                $img = $request->file('customer_pic');
                $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $img->getClientOriginalName());
                $destinationPath = ITEM_IMG_PATH;
                $image_name = 'profile_'.date('mdis').$name;
                $img->move($destinationPath, $image_name);

                $customerdetail = get_custumer_by_user_id($customer->id);
                if (File::exists($destinationPath.'/'.$customerdetail->profile_pic)) {
                    File::delete($destinationPath.'/'.$customerdetail->profile_pic);
                }
            }
            $customerData = DB::table('tbl_customers')->where('user_id', $customer->id)->update([

                'profile_pic' => $image_name,
            ]);

            if ($customerData) {

                return Response::json(array('status' => 'success', 'msg' => 'Profile pic save successfully.', 'picPath' =>asset('/'.ITEM_IMG_PATH.'/'.$image_name)));
            } else {

                return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
            }
        }
    }

    public function customerProfile(Request $request)
    {
        $theme = Theme::uses('backend')->layout('layout');
        
        $customer = get_customer_and_address_by__user_id(Auth::user()->id);
        // if(Auth::user()->profile == 0){
        //     return redirect()->route('dashboard');
        // }
        return $theme->scope('admin.customer_profile', compact('customer'))->render();
       
    }

}
