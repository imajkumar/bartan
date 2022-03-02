<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\ItemOrder;
use App\Items;
use App\paymentStatus;
use Session;
use Redirect;
use DB;
use App\Mail\AfterOrderPlaceMentMail;
use App\Mail\AfterOrderPlaceMentFailMail;
use App\Mail\SendPaymentLinkToCustomerMail;
use Illuminate\Support\Facades\Mail;
include 'Crypto.php';
use Theme;
use Auth;
use App\CustomerCart;


class PaymentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('customerLogoutAfterSomeDays',['only' => ['payment','codOrCreditOrderByCustomer']]);
        
        // $this->middleware('salesLogoutAfterSomeDays',['only' => ['codOrCreditOrderBySales','paymentBySales']]);
        
    }

    public function defaultPaymentOption(Request $request){
        //pr($request->all());
        if($request->payment_type =="Online payment"){
            return $this->payment($request);
        }else{
            return $this->codOrCreditOrderByCustomer($request);
        }
    }

    public function paynow(Request $request){
        // $orderId= \Crypt::decrypt($orderId);
        //$orderId= $orderId;
        //pr($request->all());
        $allReq=$request->all();
        
pr($allReq);
         //echo $orderId;die;
        // $itemOrders = DB::table('tbl_payment_status')
        // ->leftjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        // ->leftjoin('tbl_items','tbl_items.item_id','=','tbl_item_orders.item_id')
        // ->where('tbl_payment_status.item_order_id', $orderId)

        // ->select('tbl_items.item_id', 'tbl_items.item_name', 'tbl_item_orders.*', 'tbl_payment_status.*')
        // ->first()->toArray();
        // pr($itemOrders);die;
        $theme = Theme::uses('default')->layout('layout');
        
        return $theme->scope('payment', compact('allReq'))->render();
    }

    public function payment(Request $request)
    {
        
    
        $input = $request->all();
       

        $customer = session()->get('customer'); 
        //pr($customer);
        if($customer){
            $customer_id = $customer->id;
            $users = DB::table('tbl_customers')->where('user_id', $customer_id)->first();
        }else{
            $customer_id = 1;
            // \Session::flash('error','Please login');
            // return redirect()->back();
        }
       
        $order = getNextOrderNumber();
        foreach($request->itemIdForOder as $item_id)
        {
            foreach($request->quantityForOder[$item_id] as $quantity)
            {
                foreach($request->totalPrice[$item_id] as $totalPricePerItem)
                {
                    foreach($request->prices[$item_id] as $price)
                    {
                        foreach($request->units[$item_id] as $unit)
                        {
                            
                            foreach($request->netRates[$item_id] as $netRate)
                                {
                                    if(count($request->discounts)>0){

                                        $discount = $request->discounts[$item_id];

                                    }else{

                                        $discount = 0;
                                    }
                                    $cgst = 0;
                                    $sgst = 0;
                                    $igst = 0;
                                    if ($users->cutomer_state == 10) {

                                        if(count($request->cgst)){

                                            $cgst = $request->cgst[$item_id];

                                        }else{

                                            $cgst = 0;
                                        }

                                        if(count($request->sgst)){

                                            $sgst = $request->sgst[$item_id];

                                        }else{

                                            $sgst = 0;
                                        }
                                      
                                    }else{

                                        if(count($request->igst)>0){

                                            $igst = $request->igst[$item_id];

                                        }else{

                                            $igst = 0;
                                        }
                            
                                    }
                                    
                                                
                                        $forOrder = explode('_', $request->razorpay_payment_id);
                                        $ItemOrder = new ItemOrder();

                                        $ItemOrder->order_id = $order;
                                        $ItemOrder->payment_order = $request->razorpay_payment_id;
                                        $ItemOrder->customer_id = $customer_id;
                                        $ItemOrder->stage = 0;
                                        //$ItemOrder->status = 0;
                                        $ItemOrder->total_amount = $request->totalAmount[$item_id];
                                        $ItemOrder->grand_total = $request->grandTotal;
                                        $ItemOrder->subTotalAmt = $request->subTotalAmt;
                                        $ItemOrder->taxAmtIGST = $request->taxAmtIGST;
                                        $ItemOrder->taxAmtCGST = $request->taxAmtCGST;
                                        $ItemOrder->taxAmtSGST = $request->taxAmtSGST;
                                    
                                        $ItemOrder->item_id = $item_id;
                                        $ItemOrder->quantity = $quantity;
                                        $ItemOrder->set_of = $request->setOfForOrder[$item_id];
                                        $ItemOrder->total_price = $totalPricePerItem;
                                        $ItemOrder->item_price = $price;

                                        $ItemOrder->unit = $unit;
                                        $ItemOrder->discount = $discount;
                                        $ItemOrder->net_rate = $netRate;
                                        $ItemOrder->cgst = $cgst;
                                        $ItemOrder->sgst = $sgst;
                                        $ItemOrder->igst = $igst;

                                         //start charges delivery and packing charges save
                                         $ItemOrder->deliveryChargRate = $request->deliveryChargRate;
                                         $ItemOrder->deliveryChargDiscount = $request->deliveryChargDiscount;
                                         $ItemOrder->deliveryChargNetRate = $request->deliveryChargNetRate;
                                         $ItemOrder->deliveryChargBasic = $request->deliveryChargBasic;
                                         $ItemOrder->deliveryChargCGST = $request->deliveryChargCGST;
                                         $ItemOrder->deliveryChargSGST = $request->deliveryChargSGST;
                                         $ItemOrder->deliveryChargIGST = $request->deliveryChargIGST;
                                         $ItemOrder->deliveryChargAmount = $request->deliveryChargAmount;
 
                                         $ItemOrder->packingChargRate = $request->packingChargRate;
                                         $ItemOrder->packingChargDiscount = $request->packingChargDiscount;
                                         $ItemOrder->packingChargNetRate = $request->packingChargNetRate;
                                         $ItemOrder->packingChargBasic = $request->packingChargBasic;
                                         $ItemOrder->packingChargCGST = $request->packingChargCGST;
                                         $ItemOrder->packingChargSGST = $request->packingChargSGST;
                                         $ItemOrder->packingChargIGST = $request->packingChargIGST;
                                         $ItemOrder->packingChargAmount = $request->packingChargAmount;
                                         //end charges delivery and packing charges save
                                         

                                        $ItemOrder->save();
                                    
                                }
                            
                        }
                    }
                    
                }

            }
        }

        $paymntStaus = new paymentStatus();
        $paymntStaus->item_order_id = $order;
        //$paymntStaus->amount = $request->totalAmount;
        $paymntStaus->payment_option = @$users->payment_option;
        $paymntStaus->status = 0;
        $paymntStaus->save();


        $input['order_idd'] = $order;
        $allReq =$input;
        $theme = Theme::uses('default')->layout('layout');
        
        return $theme->scope('payment', compact('allReq'))->render();
        // pr($input);
        //$order= \Crypt::encrypt($order);
        //return redirect()->route('paynow', $input);
        //return redirect()->route('paymentSuccess', $order);
    }


    public function payment_old_9_augst_razor(Request $request)
    {
        
        
        $input = $request->all();
        //pr($input);

        $customer = session()->get('customer'); 
        //pr($customer);
        if($customer){
            $customer_id = $customer->id;
            $users = DB::table('tbl_customers')->where('user_id', $customer_id)->first();
        }else{
            $customer_id = 1;
            // \Session::flash('error','Please login');
            // return redirect()->back();
        }
       
        $order = getNextOrderNumber();
        foreach($request->itemIdForOder as $item_id)
        {
            foreach($request->quantityForOder[$item_id] as $quantity)
            {
                foreach($request->totalPrice[$item_id] as $totalPricePerItem)
                {
                    foreach($request->prices[$item_id] as $price)
                    {
                        foreach($request->units[$item_id] as $unit)
                        {
                            
                            foreach($request->netRates[$item_id] as $netRate)
                                {
                                    if(count($request->discounts)>0){

                                        $discount = $request->discounts[$item_id];

                                    }else{

                                        $discount = 0;
                                    }
                                    $cgst = 0;
                                    $sgst = 0;
                                    $igst = 0;
                                    if ($users->cutomer_state == 10) {

                                        if(count($request->cgst)){

                                            $cgst = $request->cgst[$item_id];

                                        }else{

                                            $cgst = 0;
                                        }

                                        if(count($request->sgst)){

                                            $sgst = $request->sgst[$item_id];

                                        }else{

                                            $sgst = 0;
                                        }
                                      
                                    }else{

                                        if(count($request->igst)>0){

                                            $igst = $request->igst[$item_id];

                                        }else{

                                            $igst = 0;
                                        }
                            
                                    }
                                    
                                                
                                        $forOrder = explode('_', $request->razorpay_payment_id);
                                        $ItemOrder = new ItemOrder();

                                        $ItemOrder->order_id = $order;
                                        $ItemOrder->payment_order = $request->razorpay_payment_id;
                                        $ItemOrder->customer_id = $customer_id;
                                        $ItemOrder->stage = 0;
                                        //$ItemOrder->status = 0;
                                        $ItemOrder->total_amount = $request->totalAmount[$item_id];
                                        $ItemOrder->grand_total = $request->grandTotal;
                                        $ItemOrder->subTotalAmt = $request->subTotalAmt;
                                        $ItemOrder->taxAmtIGST = $request->taxAmtIGST;
                                        $ItemOrder->taxAmtCGST = $request->taxAmtCGST;
                                        $ItemOrder->taxAmtSGST = $request->taxAmtSGST;
                                    
                                        $ItemOrder->item_id = $item_id;
                                        $ItemOrder->quantity = $quantity;
                                        $ItemOrder->total_price = $totalPricePerItem;
                                        $ItemOrder->item_price = $price;

                                        $ItemOrder->unit = $unit;
                                        $ItemOrder->discount = $discount;
                                        $ItemOrder->net_rate = $netRate;
                                        $ItemOrder->cgst = $cgst;
                                        $ItemOrder->sgst = $sgst;
                                        $ItemOrder->igst = $igst;

                                         //start charges delivery and packing charges save
                                         $ItemOrder->deliveryChargRate = $request->deliveryChargRate;
                                         $ItemOrder->deliveryChargDiscount = $request->deliveryChargDiscount;
                                         $ItemOrder->deliveryChargNetRate = $request->deliveryChargNetRate;
                                         $ItemOrder->deliveryChargBasic = $request->deliveryChargBasic;
                                         $ItemOrder->deliveryChargCGST = $request->deliveryChargCGST;
                                         $ItemOrder->deliveryChargSGST = $request->deliveryChargSGST;
                                         $ItemOrder->deliveryChargIGST = $request->deliveryChargIGST;
                                         $ItemOrder->deliveryChargAmount = $request->deliveryChargAmount;
 
                                         $ItemOrder->packingChargRate = $request->packingChargRate;
                                         $ItemOrder->packingChargDiscount = $request->packingChargDiscount;
                                         $ItemOrder->packingChargNetRate = $request->packingChargNetRate;
                                         $ItemOrder->packingChargBasic = $request->packingChargBasic;
                                         $ItemOrder->packingChargCGST = $request->packingChargCGST;
                                         $ItemOrder->packingChargSGST = $request->packingChargSGST;
                                         $ItemOrder->packingChargIGST = $request->packingChargIGST;
                                         $ItemOrder->packingChargAmount = $request->packingChargAmount;
                                         //end charges delivery and packing charges save
                                         

                                        $ItemOrder->save();
                                    
                                }
                            
                        }
                    }
                    
                }

            }
        }

        $paymntStaus = new paymentStatus();
        $paymntStaus->item_order_id = $order;
        //$paymntStaus->amount = $request->totalAmount;
        $paymntStaus->payment_option = @$users->payment_option;
        $paymntStaus->status = 0;
        $paymntStaus->save();



        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        

        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        //echo "<pre>";print_r($payment); 
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
                //echo "<pre>";print_r($payment); die;
                $paymntStausUpdate =  paymentStatus::where('item_order_id',  $order)
                ->update([
                    'amount' => $response['amount'],
                    'status' => 1,
                    'payment_gateway_info' => json_encode(@$response)
                ]);
                foreach($request->itemIdForOder as $item_id)
                {

                    $itemOrderCount = Items::where('item_id',  $item_id)->first();
                    if(isset($itemOrderCount)){
                        Items::where('item_id',  $item_id)->update(['item_order_count' => $itemOrderCount->item_order_count + 1]);
                        // $itemOrderCount->increment('item_order_count');
                    }
                    
                   
                }
                
                $sms = sendSms($users->phone, "Thank you for shopping with us!
                We'd like to let you know that Subhiksh has received your order, and is preparing it for shipment.
                ");
                   
                if ($users->email) {
                    Mail::to(@$users->email)->send(new AfterOrderPlaceMentMail($order));
                }
                //pr($response);
            } catch (\Exception $e) {
                return  $e->getMessage();
               
                \Session::flash('error',$e->getMessage());
                $sms = sendSms(@$users->phone, "Order Failed!
                Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
                ");
                return redirect()->back();
            }
        }else{
            $sms = sendSms(@$users->phone, "Order Failed!
            Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
            ");
        }
        $paymntStausCheck =  paymentStatus::where('item_order_id',  $order)->first();
        if(@$paymntStausCheck->status != 1){

            $sms = sendSms(@$users->phone, "Order Failed!
            Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
            ");
            if($users->email){

                Mail::to(@$users->email)->send(new AfterOrderPlaceMentFailMail($order));
            }
        }
        \Cart::clear();
               
        // \Session::flash('success', 'Payment successful');
        $order= \Crypt::encrypt($order);
        return redirect()->route('paymentSuccess', $order);
    }

    public function paymentBySales(Request $request)
    {
        $input = $request->all();
        //pr($input);

        $sales = session()->get('sales'); 
        if($sales){
            $saler_id = $sales->user_id;
            $saler = DB::table('users')->where('id', $saler_id)->first();
        }else{
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }

        //pr($saler);
        $customer = session()->get('customerForSalesPanel'); 
        if($customer){
            $customer_id = $customer->user_id;
            $users = DB::table('tbl_customers')->where('user_id', $customer_id)->first();
        }else{
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }
       //pr($users);
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        $link  = $api->invoice->create(
            array(
                'type'=>'link',
                'amount'=>($request->grandTotal)*100,
                'description'=>'Please pay',               
                'customer'=>array(
                    'email'=>@$users->email
                    
                )
            )
        );
        // echo @$link->id;
        
        //pr($link);
        $order = getNextOrderNumber();
        foreach($request->itemIdForOder as $item_id)
        {
            foreach($request->quantityForOder[$item_id] as $quantity)
            {
                foreach($request->totalPrice[$item_id] as $totalPricePerItem)
                {
                    foreach($request->prices[$item_id] as $price)
                    {
                        foreach($request->units[$item_id] as $unit)
                        {
                            
                            foreach($request->netRates[$item_id] as $netRate)
                                {
                                    if(count($request->discounts)>0){

                                        $discount = $request->discounts[$item_id];

                                    }else{

                                        $discount = 0;
                                    }
                                    $cgst = 0;
                                    $sgst = 0;
                                    $igst = 0;
                                    if ($users->cutomer_state == 10) {

                                        if(count($request->cgst)){

                                            $cgst = $request->cgst[$item_id];

                                        }else{

                                            $cgst = 0;
                                        }

                                        if(count($request->sgst)){

                                            $sgst = $request->sgst[$item_id];

                                        }else{

                                            $sgst = 0;
                                        }
                                      
                                    }else{

                                        if(count($request->igst)>0){

                                            $igst = $request->igst[$item_id];

                                        }else{

                                            $igst = 0;
                                        }
                            
                                    }
                                    
                                                
                                        $forOrder = explode('_', $request->razorpay_payment_id);
                                        $ItemOrder = new ItemOrder();

                                        $ItemOrder->order_id = $order;
                                        $ItemOrder->payment_order = $request->razorpay_payment_id;
                                        $ItemOrder->customer_id = $customer_id;
                                        $ItemOrder->stage = 0;
                                        //$ItemOrder->status = 0;
                                        $ItemOrder->total_amount = $request->totalAmount[$item_id];
                                        $ItemOrder->grand_total = $request->grandTotal;
                                        $ItemOrder->subTotalAmt = $request->subTotalAmt;
                                        $ItemOrder->taxAmtIGST = $request->taxAmtIGST;
                                        $ItemOrder->taxAmtCGST = $request->taxAmtCGST;
                                        $ItemOrder->taxAmtSGST = $request->taxAmtSGST;
                                    
                                        $ItemOrder->item_id = $item_id;
                                        $ItemOrder->quantity = $quantity;
                                        $ItemOrder->total_price = $totalPricePerItem;
                                        $ItemOrder->item_price = $price;

                                        $ItemOrder->unit = $unit;
                                        $ItemOrder->discount = $discount;
                                        $ItemOrder->net_rate = $netRate;
                                        $ItemOrder->cgst = $cgst;
                                        $ItemOrder->sgst = $sgst;
                                        $ItemOrder->igst = $igst;
                                        $ItemOrder->saler_id = $saler_id;
                                        $ItemOrder->payment_invoice_id = @$link->id;

                                         //start charges delivery and packing charges save
                                         $ItemOrder->deliveryChargRate = $request->deliveryChargRate;
                                         $ItemOrder->deliveryChargDiscount = $request->deliveryChargDiscount;
                                         $ItemOrder->deliveryChargNetRate = $request->deliveryChargNetRate;
                                         $ItemOrder->deliveryChargBasic = $request->deliveryChargBasic;
                                         $ItemOrder->deliveryChargCGST = $request->deliveryChargCGST;
                                         $ItemOrder->deliveryChargSGST = $request->deliveryChargSGST;
                                         $ItemOrder->deliveryChargIGST = $request->deliveryChargIGST;
                                         $ItemOrder->deliveryChargAmount = $request->deliveryChargAmount;
 
                                         $ItemOrder->packingChargRate = $request->packingChargRate;
                                         $ItemOrder->packingChargDiscount = $request->packingChargDiscount;
                                         $ItemOrder->packingChargNetRate = $request->packingChargNetRate;
                                         $ItemOrder->packingChargBasic = $request->packingChargBasic;
                                         $ItemOrder->packingChargCGST = $request->packingChargCGST;
                                         $ItemOrder->packingChargSGST = $request->packingChargSGST;
                                         $ItemOrder->packingChargIGST = $request->packingChargIGST;
                                         $ItemOrder->packingChargAmount = $request->packingChargAmount;
                                         //end charges delivery and packing charges save

                                        $ItemOrder->save();
                                    
                                }
                            
                        }
                    }
                    
                }

            }
        }

        $paymntStaus = new paymentStatus();
        $paymntStaus->item_order_id = $order;
        $paymntStaus->saler_id = $saler_id;
        $paymntStaus->amount = $request->grandTotal;
        $paymntStaus->payment_option = @$users->payment_option;
        // $paymntStaus->payment_option = @$request->payment_option;
        $paymntStaus->saler_id = $saler_id;
        $paymntStaus->payment_invoice_id = @$link->id;
        $paymntStaus->payment_link = @$link->short_url;

        $linkArray = (array) @$link;
        $paymntStaus->payment_gateway_info = json_encode($linkArray);
       
        $paymntStaus->status = 0;
        // $paymntStaus->save();
        if($paymntStaus->save()){
            if(@$users->phone){

                $sms = sendSms(@$users->phone, $link->short_url." is the Link for payment.");
            }
            
            if($users->email){
    
                Mail::to(@$users->email)->send(new SendPaymentLinkToCustomerMail($order));
            }
    
            \Cart::clear();
            return response()->json(array(
                'success' =>1, 
                'msg' =>'Payment Link Send Successfully.',
                'url' =>route('salesPersonItems')
            ));
        }else{
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }
        
               
        // \Session::flash('success', 'Link Send Successfully.');
        // $order= \Crypt::encrypt($order);
        // return redirect()->route('salesPersonItems');
       
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
                        $invoice->cancel();
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

    //Start code for COD and Creadit card Order FOr sales persion
    public function codOrCreditOrderBySales(Request $request)
    {
        $input = $request->all();
        //pr($input);

        $sales = session()->get('sales'); 
        if($sales){
            $saler_id = $sales->user_id;
            $saler = DB::table('users')->where('id', $saler_id)->first();
        }else{
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }

        //pr($saler);
        $customer = session()->get('customerForSalesPanel'); 
        if($customer){
            $customer_id = $customer->user_id;
            $users = DB::table('tbl_customers')->where('user_id', $customer_id)->first();
        }else{
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }
       //pr($users);
        // $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));
        // $link  = $api->invoice->create(
        //     array(
        //         'type'=>'link',
        //         'amount'=>($request->grandTotal)*100,
        //         'description'=>'Please pay',               
        //         'customer'=>array(
        //             'email'=>@$users->email
                    
        //         )
        //     )
        // );
        // echo @$link->id;
        
        //pr($link);
        $order = getNextOrderNumber();
        foreach($request->itemIdForOder as $item_id)
        {
            foreach($request->quantityForOder[$item_id] as $quantity)
            {
                foreach($request->totalPrice[$item_id] as $totalPricePerItem)
                {
                    foreach($request->prices[$item_id] as $price)
                    {
                        foreach($request->units[$item_id] as $unit)
                        {
                            
                            foreach($request->netRates[$item_id] as $netRate)
                                {
                                    if(count($request->discounts)>0){

                                        $discount = $request->discounts[$item_id];

                                    }else{

                                        $discount = 0;
                                    }
                                    $cgst = 0;
                                    $sgst = 0;
                                    $igst = 0;
                                    if ($users->cutomer_state == 10) {

                                        if(count($request->cgst)){

                                            $cgst = $request->cgst[$item_id];

                                        }else{

                                            $cgst = 0;
                                        }

                                        if(count($request->sgst)){

                                            $sgst = $request->sgst[$item_id];

                                        }else{

                                            $sgst = 0;
                                        }
                                      
                                    }else{

                                        if(count($request->igst)>0){

                                            $igst = $request->igst[$item_id];

                                        }else{

                                            $igst = 0;
                                        }
                            
                                    }
                                    
                                                
                                        $forOrder = explode('_', $request->razorpay_payment_id);
                                        $ItemOrder = new ItemOrder();

                                        $ItemOrder->order_id = $order;
                                        $ItemOrder->payment_order = $request->razorpay_payment_id;
                                        $ItemOrder->customer_id = $customer_id;
                                        $ItemOrder->stage = 0;
                                        //$ItemOrder->status = 0;
                                        $ItemOrder->total_amount = $request->totalAmount[$item_id];
                                        $ItemOrder->grand_total = $request->grandTotal;
                                        $ItemOrder->subTotalAmt = $request->subTotalAmt;
                                        $ItemOrder->taxAmtIGST = $request->taxAmtIGST;
                                        $ItemOrder->taxAmtCGST = $request->taxAmtCGST;
                                        $ItemOrder->taxAmtSGST = $request->taxAmtSGST;
                                    
                                        $ItemOrder->item_id = $item_id;
                                        $ItemOrder->quantity = $quantity;
                                        $ItemOrder->set_of = $request->setOfForOrder[$item_id];
                                        
                                        $ItemOrder->total_price = $totalPricePerItem;
                                        $ItemOrder->item_price = $price;

                                        $ItemOrder->unit = $unit;
                                        $ItemOrder->discount = $discount;
                                        $ItemOrder->net_rate = $netRate;
                                        $ItemOrder->cgst = $cgst;
                                        $ItemOrder->sgst = $sgst;
                                        $ItemOrder->igst = $igst;
                                        $ItemOrder->saler_id = $saler_id;
                                        //$ItemOrder->payment_invoice_id = @$link->id;

                                         //start charges delivery and packing charges save
                                         $ItemOrder->deliveryChargRate = $request->deliveryChargRate;
                                         $ItemOrder->deliveryChargDiscount = $request->deliveryChargDiscount;
                                         $ItemOrder->deliveryChargNetRate = $request->deliveryChargNetRate;
                                         $ItemOrder->deliveryChargBasic = $request->deliveryChargBasic;
                                         $ItemOrder->deliveryChargCGST = $request->deliveryChargCGST;
                                         $ItemOrder->deliveryChargSGST = $request->deliveryChargSGST;
                                         $ItemOrder->deliveryChargIGST = $request->deliveryChargIGST;
                                         $ItemOrder->deliveryChargAmount = $request->deliveryChargAmount;
 
                                         $ItemOrder->packingChargRate = $request->packingChargRate;
                                         $ItemOrder->packingChargDiscount = $request->packingChargDiscount;
                                         $ItemOrder->packingChargNetRate = $request->packingChargNetRate;
                                         $ItemOrder->packingChargBasic = $request->packingChargBasic;
                                         $ItemOrder->packingChargCGST = $request->packingChargCGST;
                                         $ItemOrder->packingChargSGST = $request->packingChargSGST;
                                         $ItemOrder->packingChargIGST = $request->packingChargIGST;
                                         $ItemOrder->packingChargAmount = $request->packingChargAmount;
                                         //end charges delivery and packing charges save

                                        $ItemOrder->save();
                                    
                                }
                            
                        }
                    }
                    
                }

            }
        }

        $paymntStaus = new paymentStatus();
        $paymntStaus->item_order_id = $order;
        //$paymntStaus->saler_id = $saler_id;
        $paymntStaus->amount = $request->grandTotal;
        $paymntStaus->payment_option = @$users->payment_option;
        // $paymntStaus->payment_option = @$request->payment_option;
        $paymntStaus->saler_id = $saler_id;
        //$paymntStaus->payment_invoice_id = @$link->id;
        //$paymntStaus->payment_link = @$link->short_url;

        //$linkArray = (array) @$link;
        //$paymntStaus->payment_gateway_info = json_encode($linkArray);
       
        $paymntStaus->status = 0;
        // $paymntStaus->save();
        if($paymntStaus->save()){
            if(@$users->phone){

                $sms = sendSms(@$users->phone,"Thank you for shopping with us!
                We'd like to let you know that Subhiksh has received your order, and is preparing it for shipment.
                ");
            }
            
            if($users->email){
                Mail::to(@$users->email)->send(new AfterOrderPlaceMentMail($order));
                //Mail::to(@$users->email)->send(new SendPaymentLinkToCustomerMail($order));
            }
    
            \Cart::clear();
            return response()->json(array(
                'success' =>1, 
                'msg' =>'Order Placed Successfully.',
                'url' =>route('salesPersonItems')
            ));
        }else{
            if($users->phone){
            $sms = sendSms(@$users->phone, "Order Failed!
                Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
                ");
            }
            if($users->email){

                Mail::to(@$users->email)->send(new AfterOrderPlaceMentFailMail($order));
            }
            return response()->json(array(
                'success' =>0, 
                'msg' =>'Something is wrong try again..',
                'url' =>route('salse_view_cart')
            ));
        }
        
               
        // \Session::flash('success', 'Link Send Successfully.');
        // $order= \Crypt::encrypt($order);
        // return redirect()->route('salesPersonItems');
       
    }
    //END code for COD and Creadit card Order FOr sales persion


    //Start for COD and Credit card Order customer
    public function codOrCreditOrderByCustomer(Request $request)
    {
        
        //pr($request->all());
        $input = $request->all();
        //pr($input);

        $customer = session()->get('customer'); 
        
        if($customer){
            $customer_id = $customer->id;
            $users = DB::table('tbl_customers')->where('user_id', $customer_id)->first();
        }else{
            $customer_id = 1;
            // \Session::flash('error','Please login');
            // return redirect()->back();
        }
       
        $order = getNextOrderNumber();
        foreach($request->itemIdForOder as $item_id)
        {
            foreach($request->quantityForOder[$item_id] as $quantity)
            {
                foreach($request->totalPrice[$item_id] as $totalPricePerItem)
                {
                    foreach($request->prices[$item_id] as $price)
                    {
                        foreach($request->units[$item_id] as $unit)
                        {
                            
                            foreach($request->netRates[$item_id] as $netRate)
                                {
                                    if(count($request->discounts)>0){

                                        $discount = $request->discounts[$item_id];

                                    }else{

                                        $discount = 0;
                                    }
                                    $cgst = 0;
                                    $sgst = 0;
                                    $igst = 0;
                                    if ($users->cutomer_state == 10) {

                                        if(count($request->cgst)){

                                            $cgst = $request->cgst[$item_id];

                                        }else{

                                            $cgst = 0;
                                        }

                                        if(count($request->sgst)){

                                            $sgst = $request->sgst[$item_id];

                                        }else{

                                            $sgst = 0;
                                        }
                                      
                                    }else{

                                        if(count($request->igst)>0){

                                            $igst = $request->igst[$item_id];

                                        }else{

                                            $igst = 0;
                                        }
                            
                                    }
                                    
                                                
                                        // $forOrder = explode('_', $request->razorpay_payment_id);
                                        $ItemOrder = new ItemOrder();

                                        $ItemOrder->order_id = $order;
                                        //$ItemOrder->payment_order = $request->razorpay_payment_id;
                                        $ItemOrder->customer_id = $customer_id;
                                        $ItemOrder->stage = 0;
                                        //$ItemOrder->status = 0;
                                        $ItemOrder->total_amount = $request->totalAmount[$item_id];
                                        $ItemOrder->grand_total = $request->grandTotal;
                                        $ItemOrder->subTotalAmt = $request->subTotalAmt;
                                        $ItemOrder->taxAmtIGST = $request->taxAmtIGST;
                                        $ItemOrder->taxAmtCGST = $request->taxAmtCGST;
                                        $ItemOrder->taxAmtSGST = $request->taxAmtSGST;
                                    
                                        $ItemOrder->item_id = $item_id;
                                        $ItemOrder->quantity = $quantity;
                                        $ItemOrder->set_of = $request->setOfForOrder[$item_id];
                                        $ItemOrder->total_price = $totalPricePerItem;
                                        $ItemOrder->item_price = $price;

                                        $ItemOrder->unit = $unit;
                                        $ItemOrder->discount = $discount;
                                        $ItemOrder->net_rate = $netRate;
                                        $ItemOrder->cgst = $cgst;
                                        $ItemOrder->sgst = $sgst;
                                        $ItemOrder->igst = $igst;

                                        //start charges delivery and packing charges save
                                        $ItemOrder->deliveryChargRate = $request->deliveryChargRate;
                                        $ItemOrder->deliveryChargDiscount = $request->deliveryChargDiscount;
                                        $ItemOrder->deliveryChargNetRate = $request->deliveryChargNetRate;
                                        $ItemOrder->deliveryChargBasic = $request->deliveryChargBasic;
                                        $ItemOrder->deliveryChargCGST = $request->deliveryChargCGST;
                                        $ItemOrder->deliveryChargSGST = $request->deliveryChargSGST;
                                        $ItemOrder->deliveryChargIGST = $request->deliveryChargIGST;
                                        $ItemOrder->deliveryChargAmount = $request->deliveryChargAmount;

                                        $ItemOrder->packingChargRate = $request->packingChargRate;
                                        $ItemOrder->packingChargDiscount = $request->packingChargDiscount;
                                        $ItemOrder->packingChargNetRate = $request->packingChargNetRate;
                                        $ItemOrder->packingChargBasic = $request->packingChargBasic;
                                        $ItemOrder->packingChargCGST = $request->packingChargCGST;
                                        $ItemOrder->packingChargSGST = $request->packingChargSGST;
                                        $ItemOrder->packingChargIGST = $request->packingChargIGST;
                                        $ItemOrder->packingChargAmount = $request->packingChargAmount;
                                        //end charges delivery and packing charges save

                                        $ItemOrder->save();
                                    
                                }
                            
                        }
                    }
                    
                }

            }
        }

        $paymntStaus = new paymentStatus();
        $paymntStaus->item_order_id = $order;
        //$paymntStaus->amount = $request->totalAmount;
        $paymntStaus->amount = $request->grandTotal;
        $paymntStaus->payment_option = @$users->payment_option;
        $paymntStaus->status = 0;
        if($paymntStaus->save()){

            try {

                foreach($request->itemIdForOder as $item_id)
                {

                    $itemOrderCount = Items::where('item_id',  $item_id)->first();
                    if(isset($itemOrderCount)){
                        Items::where('item_id',  $item_id)->update(['item_order_count' => $itemOrderCount->item_order_count + 1]);
                        // $itemOrderCount->increment('item_order_count');
                    }
                    
                   
                }
                
                $sms = sendSms($users->phone, "Thank you for shopping with us!
                We'd like to let you know that Subhiksh has received your order, and is preparing it for shipment.
                ");
                   
                if ($users->email) {
                    Mail::to(@$users->email)->send(new AfterOrderPlaceMentMail($order));
                }
                //pr($response);
                $cartCollection = \Cart::getContent();
                $dataCartInArr = $cartCollection->toArray();
                foreach ($dataCartInArr as $key => $rowData) {

                    $customerCartLists = CustomerCart::where('customer_id', Auth::user()->id)
                    ->where('item_id', $rowData['id'])
                    ->delete();
                }
                
                \Cart::clear();
            } catch (\Exception $e) {
                return  $e->getMessage();
               
                \Session::flash('error',$e->getMessage());
                $sms = sendSms(@$users->phone, "Order Failed!
                Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
                ");
                return redirect()->back();
            }
        }else{
            $sms = sendSms(@$users->phone, "Order Failed!
            Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
            ");
        }
        $paymntStausCheck =  paymentStatus::where('item_order_id',  $order)->first();
        if(@$paymntStausCheck->status != 1){

            $sms = sendSms(@$users->phone, "Order Failed!
            Your payment against the above order has failed,order will not be processed until successful payment. Kindly place another order or contact Subhiksh team
            ");
            if($users->email){

                Mail::to(@$users->email)->send(new AfterOrderPlaceMentFailMail($order));
            }
        }
        \Cart::clear();
               
        // \Session::flash('success', 'Payment successful');
        $order= \Crypt::encrypt($order);
        return redirect()->route('paymentSuccess', $order);
    }
    //End for COD and Credit card Order customer

    
}
