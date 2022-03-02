<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Response;
use Theme;
use Illuminate\Support\Facades\Auth;
use App\CustomerCart;
class CartController extends Controller
{
    public function __construct()
    {
        // $this->middleware('customerLogoutAfterSomeDays',['only' => ['view_cart']]);
        
        // $this->middleware('salesLogoutAfterSomeDays',['only' => ['salse_view_cart']]);
       
       
       
        
    }
    //view_cart
    public function view_cart(Request $request)
    {
      
        $theme = Theme::uses('default')->layout('layout');
    
        //dd($bannerLists);
        getCustomerCart();
        $cartCollection = \Cart::getContent()->sort();
        //pr(count($cartCollection));
        if(count($cartCollection) > 0){
            return $theme->scope('front.viewCart')->render();
        }else{
            return $theme->scope('empty_cart')->render();
        }
    }

    public function view_cart_customer($customer_id)
    {
        
        $customer_id = \Crypt::decrypt($customer_id);
        $customerCartLists = CustomerCart::where('customer_id', $customer_id)
        //->groupBy('customer_id')
        ->get();
        //pr($customerCartLists);
        $theme = Theme::uses('default')->layout('layout');
    
        //dd($bannerLists);
        
            return $theme->scope('front.viewCart', compact('customerCartLists'))->render();
        
    }

    //view_cart

    //salse_view_cart
    public function salse_view_cart(Request $request)
    {
        $theme = Theme::uses('sales')->layout('layout');
    
        $cartCollection = \Cart::getContent()->sort();
        if(count($cartCollection) > 0){
            return $theme->scope('salesViewCart')->render();
        }else{
            return $theme->scope('empty_cart_sales')->render();
        }
      
        
    }

    //salse_view_cart

    //setIncreseQTY
    public function setIncreseQTY(Request $request)
    {

        \Cart::remove($request->itemID);        
        $itemDataArr = DB::table('tbl_items')->where('item_id', $request->itemID)->first();
        $qty=($request->itemQTY)+1;

        if(!empty($itemDataArr->set_of) && $qty !=0){

            // $set_of=($request->set_of) * $qty;
            $set_of=($itemDataArr->set_of) * $qty;
        }else{
            $set_of="";
        }
        
        //echo $request->set_of;exit;
        \Cart::add(array(
            'id' => $itemDataArr->item_id, // inique row ID
            'name' => $itemDataArr->item_name,
            'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
            'quantity' =>intVal($qty),
            'attributes' => array(
                'set_of' =>intVal($set_of),
                
            ),
           
        ));

        if(@Auth::user()->id){
            CustomerCart::where('customer_id', Auth::user()->id)
            ->where('item_id', $request->itemID)
            ->update([
                'qty' =>intVal($qty),
                'set_of' =>intVal($set_of),
            ]);
        }

        $returnViewCustomerViewCart = view('customerViewCartForAppend')->render();

        //return response()->json(array('status' => 1, 'msg'=>"Updated cart succesfuly",'viewCartHtml' => $returnViewCustomerViewCart));

        // \Cart::update($request->itemID, array(
        //     'quantity' =>1, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        //   ));
        return Response::json([
            'status' => 1,
            'msg'=>"Updated cart succesfuly",
            'viewCartHtml' => $returnViewCustomerViewCart
        ], 200);

        // \Cart::update($request->itemID, array(
        //     'quantity' =>1, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        //   ));
        //   return Response::json([
        //     'status' => 1,
        //     'msg'=>"Updated cart succesfuly"
        // ], 200);

    }

    public function increseQTYOnKeyPress(Request $request)
    {

        \Cart::remove($request->itemID);        
        $itemDataArr = DB::table('tbl_items')->where('item_id', $request->itemID)->first();
        $qty=($request->itemQTY < $itemDataArr->item_invt_min_order) ? $itemDataArr->item_invt_min_order : $request->itemQTY;
        @$set_of=($itemDataArr->set_of) * $qty;
        
        \Cart::add(array(
            'id' => $itemDataArr->item_id, // inique row ID
            'name' => $itemDataArr->item_name,
            'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
            'quantity' =>intVal($qty),
            
            'attributes' => array(
                'set_of' =>intVal($set_of),
                
            ),
           
        ));

        // \Cart::update($request->itemID, array(
        //     'quantity' =>1, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        //   ));

        if(@Auth::user()->id){
            CustomerCart::where('customer_id', Auth::user()->id)
            ->where('item_id', $request->itemID)
            ->update([
                'qty' =>intVal($qty),
                'set_of' =>intVal($set_of)
            ]);
        }
        // return Response::json([
        //     'status' => 1,
        //     'msg'=>"Updated cart succesfuly"
        // ], 200);

        $returnViewCustomerViewCart = view('customerViewCartForAppend')->render();
        return Response::json([
            'status' => 1,
            'msg'=>"Updated cart succesfuly",
            'viewCartHtml' => $returnViewCustomerViewCart
        ], 200);

    }
    //setIncreseQTY
     //setDecreaseQTY
     public function setDecreaseQTY(Request $request)
     {
       
        \Cart::remove($request->itemID);        
        $itemDataArr = DB::table('tbl_items')->where('item_id', $request->itemID)->first();
        
        $qty=($request->itemQTY)-1;
        if(!empty($itemDataArr->set_of) && $qty !=0){
        // if(!empty($itemDataArr->set_of) && ($request->set_of > $itemDataArr->set_of)){

            // $set_of=($request->set_of)-$itemDataArr->set_of;
            $set_of=($itemDataArr->set_of) * $qty;
        }else{
            $set_of="";
        }
        
       
       
        
        if($qty > 0){
        \Cart::add(array(
            'id' => $itemDataArr->item_id, // inique row ID
            'name' => $itemDataArr->item_name,
            'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
            'quantity' =>intVal($qty),
            
            'attributes' => array(
                'set_of' =>intVal($set_of),
                
            ),
            

        ));
    

        if(@Auth::user()->id){
        CustomerCart::where('customer_id', Auth::user()->id)
        ->where('item_id', $request->itemID)
        ->update([
            'qty' =>intVal($qty),
            'set_of' =>intVal($set_of),
        ]);
        }
    }else{

        if(@Auth::user()->id){
            CustomerCart::where('customer_id', Auth::user()->id)
            ->where('item_id', $request->itemID)
            ->delete();
            }

    }
           //\Cart::remove(5);
        //    $dataArr=\Cart::get($request->itemID);
        //    $iQTYCurr=$dataArr->quantity;
        //    if($iQTYCurr==1){
        //       \Cart::remove($request->itemID);
        //    }else{
        //     $iQ=intVal($request->itemQTY);
        //     $iQM=$iQ-1;

        //  \Cart::update($request->itemID, array(
        //     'quantity' => - $iQM, // so if the current product has a quantity of 4, another 2 will be added so this will result to 6
        //   ));

        //    }

        





        //    return Response::json([
        //      'status' => 1,
        //      'msg'=>"Updated cart succesfuly"
        //  ], 200);
        $returnViewCustomerViewCart = view('customerViewCartForAppend')->render();



           return Response::json([
             'status' => 1,
             'msg'=>"Updated cart succesfuly",
             'viewCartHtml' => $returnViewCustomerViewCart
         ], 200);
 
     }
     //setDecreaseQTY
     

     //setAddToCart
     public function setAddToCart(Request $request)
     {
             
      
        \Cart::remove($request->itemID);
        //  $itemDataArr=getItembyID($request->itemID);      
        $itemDataArr = DB::table('tbl_items')->where('item_id', $request->itemID)->first();
       
       
        
        \Cart::add(array(
            'id' => $itemDataArr->item_id, // inique row ID
            'name' => $itemDataArr->item_name,
            'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
            'quantity' => $itemDataArr->item_invt_min_order,
            
            'attributes' => array(
                'set_of' => (!empty($itemDataArr->set_of) && !empty($itemDataArr->item_invt_min_order))? $itemDataArr->set_of * $itemDataArr->item_invt_min_order : 0,
            )
        ));
    
        $cartCollection = \Cart::getContent();
            
        $dataCartInArr=$cartCollection->toArray();
        
        //pr($dataCartInArr);
        $html='';
        foreach ($dataCartInArr as $key => $rowData) {
            // echo $rowData['attributes']['set_of'];
            // pr($rowData['attributes']);
            // exit;
            CustomerCart::updateOrCreate([
                'customer_id' => Auth::user()->id,
                'item_id' => $rowData['id'],
                
            ],
            [
                'customer_id' => Auth::user()->id,
                'item_id' => $rowData['id'],
                'qty' => $rowData['quantity'],
                'set_of' => $rowData['attributes']['set_of'],
            ]
        );
            $item = DB::table('tbl_items')->where('item_id', $rowData['id'])->first();
            
            @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
            @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
            @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
            
            $totalOff = $custCatDiscount + $custClassDiscount;

            $itemImages = get_item_default_img_item_id($rowData['id']);

            if($itemImages)
            {

                $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                
            } else {

                $itemImg = FRONT.'img/product/product-iphone.png';
            }
        
            $html .='<li>
                    <div class="cart-item-image"><img src="'.$itemImg.'" alt="'.$rowData['name'].'" /></div>
                    <div class="cart-item-info">
                        <h4>'.\Str::limit(strip_tags($rowData['name']),30,'...').'</h4>
                        <p class="price">
                        <i class="fa fa-inr" aria-hidden="true"></i>
                        '.@$AfterDiscountPrice.'
                        </p>
                    </div>
                    <div class="cart-item-close">
                        <a href="#" onclick="removeItemFromCart('.$rowData['id'].')" data-toggle="tooltip" data-title="Remove">&times;</a>
                    </div>
                </li>';
        }

        return Response::json([
            'status' => 1,
            'msg'=>"Added cart succesfuly",
            'htmlItemData'=>$html,
            'totalItem'=>$cartCollection->count(),
        ], 200);




      
    }

     //setSalesAddToCart
     public function setSalesAddToCart(Request $request)
     {
             
      
     
        //  $itemDataArr=getItembyID($request->itemID);      
        $itemDataArr = DB::table('tbl_items')->where('item_id', $request->itemID)->first();
        
        //pr($itemDataArr);
        \Cart::add(array(
            'id' => $itemDataArr->item_id, // inique row ID
            'name' => $itemDataArr->item_name,
            //'description' => $itemDataArr->description,
            'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
            'quantity' => $itemDataArr->item_invt_min_order,
            'attributes' => array(
                'set_of' => (!empty($itemDataArr->set_of))? $itemDataArr->set_of : 0,
            )
        ));
    
        $cartCollection = \Cart::getContent();
            
        $dataCartInArr=$cartCollection->toArray();

        $html='';
        @$customer = session()->get('customerForSalesPanel');
        foreach ($dataCartInArr as $key => $rowData) {

            $item = DB::table('tbl_items')->where('item_id', $rowData['id'])->first();
            
            @$custClassDiscount = getCustomerClassDiscount(@$customer->user_id, $item->cat_id);
            @$custCatDiscount = getCustomerCategoryDiscount(@$customer->user_id, $item->cat_id);
            @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
            
            $totalOff = $custCatDiscount + $custClassDiscount;


            $itemImages = get_item_default_img_item_id($rowData['id']);

            if($itemImages)
            {

                $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                
            } else {

                $itemImg = FRONT.'img/product/product-iphone.png';
            }
        
            $html .='<a href="javascript:;" class="dropdown-item media" ><div class="media-left">
								<img src="'.$itemImg.'" class="media-object" alt="'.$rowData['name'].'" />
								
							</div>
							<div class="media-body">
							
								<h6 class="media-heading">'.\Str::limit(strip_tags($rowData['name']),30,'...').'</h6>
								
								<div class="text-muted2">

									<i class="fa fa-inr" aria-hidden="true"></i>
                                    '.@$AfterDiscountPrice.'
											
								</div>
							
                      
							</div>
							<span onclick="removeItemFromCartSales('.$rowData['id'].')" >&times;</span></a>';
        }

        return Response::json([
            'status' => 1,
            'msg'=>"Added cart succesfuly",
            'htmlItemData'=>$html,
            'totalItem'=>$cartCollection->count(),
        ], 200);




      
    }
     //setSalesAddToCart

     //removeItemFromCart
     public function removeItemFromCart(Request $request)
     {
             
      
        \Cart::remove($request->itemID);
        CustomerCart::where('customer_id', Auth::user()->id)
        ->where('item_id', $request->itemID)
        ->delete();

        $cartCollection = \Cart::getContent()->sort();
        //pr(count($cartCollection));
        if(count($cartCollection) <= 0){
            //exit('ggg');
            return redirect()->route('view_cart');
            //return $theme->scope('front.viewCart')->render();
            return Response::json([
                'status' => 0,
                'msg'=>"Item remove from cart succesfuly",
                'url' => route('view_cart')
            ], 200);
        }

        $CartHtml = view('addToCartAppend')->render();
        $returnViewCustomerViewCart = view('customerViewCartForAppend')->render();
        
        return Response::json([
            'status' => 1,
            'msg'=>"Item remove from cart succesfuly",
            'CartHtml' => $CartHtml,
            'viewCartHtml' => $returnViewCustomerViewCart
        ], 200);

        // return Response::json([
        //     'status' => 1,
        //     'msg'=>"Item remove from cart succesfuly"
        // ], 200);




      
    }

    public function removeItemFromCartSales(Request $request)
     {
             
      
        \Cart::remove($request->itemID);
        // CustomerCart::where('customer_id', Auth::user()->id)
        // ->where('item_id', $request->itemID)
        // ->delete();
        return Response::json([
            'status' => 1,
            'msg'=>"Item remove from cart succesfuly"
        ], 200);




      
    }
     //removeItemFromCart

}
