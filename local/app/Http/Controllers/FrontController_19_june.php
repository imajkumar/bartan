<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Theme;
use DB;
use Illuminate\Support\Facades\Auth;
use Response;
use Session;
use paginate;
use File;
use App\User;
use App\CustomerCart;
use Hash;
use PDF;




class FrontController extends Controller
{
    public $login;
    public $kyc;
    public function __construct()
    {
        // $this->middleware('customerLogoutAfterSomeDays',['only' => ['paymentSuccess']]);
        

        //pr(Auth::user());
        if(Auth::user()){

            $this->login="true";

            if(Auth::user()->user_type ==0){
        
                if(Auth::user()->profile == 1){
        
                    $this->kyc = 'true';
        
                }else{
        
                    $this->kyc = 'false';
                }
                $isAdmin = "no";
            }else{
                $isAdmin = "yes";
                $this->kyc = 'true';
            }
        
        
        }else{
        
            $this->kyc = 'false';
            $this->login="false";

            
        }

      
    }
    
   

    public function paymentSuccess($orderId){

        $orderId= \Crypt::decrypt($orderId);
        $itemOrders = DB::table('tbl_payment_status')
        ->leftjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->leftjoin('tbl_items','tbl_items.item_id','=','tbl_item_orders.item_id')
        ->where('tbl_payment_status.item_order_id', $orderId)

        ->select('tbl_items.item_id', 'tbl_items.item_name', 'tbl_item_orders.*', 'tbl_payment_status.*')
        ->get();

        
        $theme = Theme::uses('default')->layout('layout');
       return $theme->scope('thankYou', compact('itemOrders'))->render();
        
    }

    public function genrateItemOrderPdf($orderId){

        //$orderId= \Crypt::decrypt($orderId);
        $itemOrders = DB::table('tbl_payment_status')
        ->leftjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->leftjoin('tbl_items','tbl_items.item_id','=','tbl_item_orders.item_id')
        ->where('tbl_payment_status.item_order_id', $orderId)

        ->select('tbl_items.item_id', 'tbl_items.item_name', 'tbl_item_orders.*', 'tbl_payment_status.*')
        ->get();

        $pdf = PDF::loadView('pdf.itemOrderPdf', compact('itemOrders'));
       
       //return $pdf->setPaper('a4')->stream();
        return $pdf->download('Order.pdf');
    }

    public function customerOrderFront(){

        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        
        ->where('tbl_item_orders.customer_id', Auth::user()->id)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
       
        //pr($itemOrders);
        $theme = Theme::uses('default')->layout('layout');
       return $theme->scope('customerOrder', compact('itemOrders'))->render();
        
    }

    public function viewOrderCustumerFront($orderId){

        $itemOrders = DB::table('tbl_item_orders')
            ->where('customer_id', Auth::user()->id)
            ->where('order_id', $orderId)
            ->get();
        
        $theme = Theme::uses('default')->layout('layout');
       return $theme->scope('viewOrderCustumerFront', compact('itemOrders'))->render();
        
    }

    public function getCustomerOrder(Request $request){
        if($request->stage != '10'){

            $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', $request->stage)
            ->where('.tbl_item_orders.customer_id', $request->customer_id)
            ->get();
        
            
        }else{
            
            $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            
            ->where('.tbl_item_orders.customer_id', $request->customer_id)
            ->get();
            
        }
        
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        //pr($itemOrders);

        if(count($itemOrders)>0){
            $html = '';
            
                $i=0;
                foreach($itemOrders as $itemOrder){
                    
                    $itemOrder = (object) $itemOrder;
                    $item = get_item_detail($itemOrder->item_id);
                    $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)->first();
                    $itemImages = get_item_default_img_item_id($itemOrder->item_id);

					if($itemImages)
					{

						$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
					} else {

						$itemImg = FRONT.'img/product/product-iphone.png';
                    }

                    if(@$paymntStaus->status == 1)
                    {
                        $paymntStausVal ='<span class="badge badge-md badge-success">Success</span>';

                    }elseif(@$paymntStaus->status == 0){

                        $paymntStausVal ='<span class="badge badge-md badge-danger">Pending</span>';

                                    
                    }

                    if($itemOrder->stage == 1)
                    {
                        $stage = '<span class="badge badge-md badge-success">Processed</span>';

                    }elseif($itemOrder->stage == 0){

                        $stage = '<span class="badge badge-md badge-danger">Pending</span>';

                    }elseif($itemOrder->stage == 2){


                        $stage = '<span class="badge badge-md badge-danger">Packaging</span>';

                
                    }elseif($itemOrder->stage == 3){

                        $stage = '<span class="badge badge-md badge-danger">Shipping</span>';

                    
                    } elseif($itemOrder->stage == 4){

                    
                        $stage = '<span class="badge badge-md badge-danger">Delivered</span>';
                    
                    }elseif($itemOrder->stage == 5){

                        $stage = '<span class="badge badge-md badge-danger">Hold</span>';
                    
                    }elseif($itemOrder->stage == 6){

                        $stage = '<span class="badge badge-md badge-danger">Cancel</span>';

                    }else{
                        $stage = '<span class="badge badge-md badge-danger">Return</span>';
                
                    }

                    $itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();
                    
                $html .='<tr>
                            <td class="value">'.$itemOrder->order_id.'</td>
                            <td class="value">'.date("d-m-Y", strtoTime(@$paymntStaus->created_at)).'</td>
                          
                            <td class="value">'.$itemOrdersCount.'</td>
                            <td class="value">'.$itemOrder->total_amount.'</td>
                            <td class="value">'.$stage.'</td>
                            
                            <td class="value">'.$paymntStausVal.'</td>
                            <td>
								<a href="'.route('viewOrderCustumerFront', $itemOrder->order_id).'" class="btn btn-primary"><i class="fas fa-lg fa-fw m-r-10 fa-eye"></i>View</a>
							</td>
                        </tr>';
                           
                $i++;   
                
            }
               

            $data = array(
                'status' => 'success',
                'msg' => 'success',
                'orders' => $itemOrders,
                'ordeHtml' => $html,
                
            );
        }else{
            $data = array(
                'status' => 'fail',
                'msg' => 'Order not found.',
                'orders' => $itemOrders,
                
            );
        }
        
    return($data);
        
    }

    
    
    public function getItemsByCatOrBrandIdByAjax(Request $request)
    {
        
        
        if(Auth::user()){

            $login="true";

            if(Auth::user()->user_type ==0){
        
                if(Auth::user()->profile == 1){
        
                    $kyc = 'true';
        
                }else{
        
                    $kyc = 'false';
                }
                $isAdmin = "no";
            }else{
                $isAdmin = "yes";
                $kyc = 'true';
            }
        
        
        }else{
        
            $kyc = 'false';
            $login="false";

            
        }

        $items = get_itemsByCatOrBrandId($flag='', $limit=-1, $request->catOrBrandId, $page='6');
        if(count($items)>0){
            $html = '<div class="item-row">';
            
                $i=0;
                foreach($items as $item){
                    if($item->is_visible == 1)
                    {

                    $itemImages = get_item_default_img_item_id($item->item_id);

					if($itemImages)
					{

						$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
					} else {

						$itemImg = FRONT.'img/product/product-iphone.png';
                    }

                   

                    @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
                    @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
                    @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
                    
                    $totalOff = $custCatDiscount + $custClassDiscount;
                    $Price = '';
                    if($totalOff == 0){
                       
                        if($item->regular_price){

                            //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                            if($item->item_mrp){
                               
                                $Price = '<div class="item-price">???'.$item->regular_price.'</div>
                                <div class="item-discount-price">???'.$item->item_mrp.'</div>';
									
									
                            }else{
                                $Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                            }

                        }else{

                            $Price = '<div class="item-price">???0</div>';
                        }
                    }else{

                        $Price ='<div class="item-price">???'.$AfterDiscountPrice.'</div>';
                        $Price .='<div class="item-discount-price">???'.$item->regular_price.'</div>';
                    }

					if($totalOff != 0){
                        $offPercenteg = '<div class="discount">'.$totalOff.'% OFF </div>';
                    			
                    }else{
                        $offPercenteg = '';
                    }

                    if(($i != 1) && ($i != 0)&& ($i % 3==0)){

                        $html .='</div><div class="item-row">';
                    }

                    if($kyc == "true" && $login=="true" && @$isAdmin != "yes")
                    {

                        $html .='<div class="item item-thumbnail">
                            <a href="'.route("productDetail", $item->slug).'" class="item-image">
                                <img src="'.$itemImg.'" alt="" />
                               '.$offPercenteg.'
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
                                </h4>
                                <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
                               '.$Price.'
                                <a href="javascript:void();" onclick="add_to_cart('.$item->item_id.')" class="btn btn-inverse">ADD TO CART</a>
                            </div>
                        </div>';
                    }else{

                        $html .='<div class="item item-thumbnail">
                            <a href="'.route("productDetail", $item->slug).'" class="item-image">
                                <img src="'.$itemImg.'" alt="" />
                                '.$offPercenteg.'
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
                                </h4>
                                <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
                                
                            </div>
                        </div>';

                    }
                    
                 $i++;   
                }
            }
                $html .='</div>';
                // $html .='<ul class="pagination justify-content-center m-t-0">';
                // $html .= $items->links();
                // $html .= '</ul>';

            $data = array(
                'status' => 'success',
                'msg' => 'success',
                'items' => $items,
                'itemHtml' => $html,
                
            );
        }else{
            $data = array(
                'status' => 'fail',
                'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
                'items' => $items,
                
            );
        }
        
    return($data);
    }


    public function productDetail($item_id)
    {
        //$sms = sendSms('8281834736',"test massege dfh uhgfd");
        
        $theme = Theme::uses('default')->layout('layout');
        $item = get_item_detail_by_item_id($item_id);
        return $theme->scope('item_detail', compact('item'))->render();

    }

    public function getItemsByCatId($catId)
    {
        $items = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $catId, $page='');
        // pr($items);
        $category = DB::table('tbl_item_category')->where('id', $catId)->first();
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('productsByCategory', compact('items', 'category'))->render();

    }

    public function thanks()
    {
       
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('thanks')->render();

    }

    public function getItemsByBrandId($BrandId)
    {
        $brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='');
        $theme = Theme::uses('default')->layout('layout');
        $brandDetail = DB::table('tbl_brands')->where('id', $BrandId)->first();
        return $theme->scope('productsByBrand', compact('brands', 'brandDetail'))->render();


    }

    public function filterByAjax(Request $request)
    {
        if(Auth::user()){

            $login="true";

            if(Auth::user()->user_type ==0){
        
                if(Auth::user()->profile == 1){
        
                    $kyc = 'true';
        
                }else{
        
                    $kyc = 'false';
                }
                $isAdmin = "no";
            }else{
        
                $isAdmin = "yes";
                $kyc = 'true';
            }
        
        
        }else{
        
            $kyc = 'false';
            $login="false";

            
        }
        //echo $request->byType;
        $items = filter($flag=$request->byType, $limit='-1', $keyword=$request->keyword, $priceFrom=$request->priceFrom, $priceTo=$request->priceTo, $page='');
       //pr($items);
        if(count($items)>0){
            $html = '<div class="item-row">';
            
                $i=0;
                foreach($items as $item){
                    if($item->is_visible == 1)
                    {

                    $itemImages = get_item_default_img_item_id($item->item_id);

					if($itemImages)
					{

						$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
					} else {

						$itemImg = FRONT.'img/product/product-iphone.png';
                    }
                    @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
                    @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
                    @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
                    
                    $totalOff = $custCatDiscount + $custClassDiscount;

                    if($totalOff == 0){
                       
                        if($item->regular_price){

                            //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                        
                            if($item->item_mrp){
                               
                                $Price = '<div class="item-price">???'.$item->regular_price.'</div>
                                <div class="item-discount-price">???'.$item->item_mrp.'</div>';
									
									
                            }else{
                                $Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                            }

                        
                        }else{

                            $Price = '<div class="item-price">???0</div>';
                        }
                    }else{

                        $Price ='<div class="item-price">???'.$AfterDiscountPrice.'</div>'.
                        '<div class="item-discount-price">???'.$item->regular_price.'</div>';
                    }

					if($totalOff != 0){
                        $offPercenteg = '<div class="discount">'.$totalOff.'% OFF </div>';
                    			
                    }else{
                        $offPercenteg = '';
                    }

                    

                    
                    if(($i != 1) && ($i != 0)&& ($i % 3==0)){

                        $html .='</div><div class="item-row">';
                    }

                    if(($kyc == "true") && ($login=="true") && $isAdmin != "yes")
                    {
                        
                        

                        $html .='<div class="item item-thumbnail">
                            <a href="'.route("productDetail", $item->slug).'" class="item-image">
                                <img src="'.$itemImg.'" alt="" />
                                '.$offPercenteg.'
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
                                </h4>
                                <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
                                '.$Price.'
                                <a href="javascript:void();" onclick="add_to_cart('.$item->item_id.')" class="btn btn-inverse">ADD TO CART</a>
                            </div>
                        </div>';
                    }else{
                        
                       
                        $html .='<div class="item item-thumbnail">
                            <a href="'.route("productDetail", $item->slug).'" class="item-image">
                                <img src="'.$itemImg.'" alt="" />
                                '.$offPercenteg.'
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
                                </h4>
                                <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
                                
                            </div>
                        </div>';

                    }
                 $i++;   
                }
            }
                $html .='</div>';

            $data = array(
                'status' => 'success',
                'msg' => 'success',
                'items' => $items,
                'itemHtml' => $html,
                
            );
        }else{
            $data = array(
                'status' => 'fail',
                'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
                'items' => $items,
                
            );
        }
        
        return($data);


    }

    public function searchKeyword(Request $request)
    {
        $keyword = $request->query('keyword');
        if( $request->has('keyword') && !empty($keyword) ) 
        {
           
            $items = searching($limit='-1', $keyword=$keyword, $page='9');
            // $items = searching($limit='-1', $keyword=$keyword, $page='');

            
        }else{

            $items =array();
           
        }
        //pr($items);
        $theme = Theme::uses('default')->layout('layout');
            
        return $theme->scope('search', compact('items','keyword'))->render();
    }

    public function contactUs()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('contact_us')->render();

    }
    public function saveContactUs(Request $request)
    {
        //pr($request->all());
        $this->validate($request, [
           
            'g-recaptcha-response' => 'required|recaptcha'
        ]);
        
        $contacData = DB::table('contact_us')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'subject' => $request->subject,
            'message' => $request->message,
            
        ]);
        if($contacData){
            return Response::json(array('status' => 1, 'msg' => 'Your request has been successfully submitted, our team will contact you soon.'));
        }else {
            return Response::json(array('status' => 0, 'msg' => 'Something is wrong try again.'));

        }
    }

    public function privacyPolicy()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('privacy_policy')->render();

    }

    public function termsOfUse()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('terms_of_use')->render();

    }
    public function careers()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('careers')->render();

    }
    public function salesRefund()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('sales_refund')->render();

    }

    public function support()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('support')->render();

    }

    public function faq()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('faq')->render();

    }

    public function aboutUs()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('aboutUs')->render();

    }

    public function information()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('information')->render();

    }

    public function refundPolicy()
    {
        $theme = Theme::uses('default')->layout('layout');
        return $theme->scope('refundPolicy')->render();

    }



    public function getItemsByCatOrBrandIdByAjaxForPagination(Request $request)
    {
        
        
        if(Auth::user()){

            $login="true";

            if(Auth::user()->user_type ==0){
        
                if(Auth::user()->profile == 1){
        
                    $kyc = 'true';
        
                }else{
        
                    $kyc = 'false';
                }
                $isAdmin = "no";
            }else{
                $isAdmin = "yes";
                $kyc = 'true';
            }
        
        
        }else{
        
            $kyc = 'false';
            $login="false";

            
        }

        $items = get_itemsByCatOrBrandId($flag='', $limit=-1, $request->catOrBrandId, $page='6');
       
        $returnViewPaginateFile = view('test_pagination', compact('items'))->render();

        return response()->json(array('success' => true, 'ordeHtml' => $returnViewPaginateFile));
            // $data = array(
            //     'status' => 'success',
            //     'msg' => 'success',
            //     'items' => $items,
            //     'itemHtml' => $html,
                
            // );
        // }else{
        //     $data = array(
        //         'status' => 'fail',
        //         'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
        //         'items' => $items,
                
        //     );
        // }
        
    //return($data);
    }
}
