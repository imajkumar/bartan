<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Theme;
use Cart;
use Auth;
use DB;
use App\User;
use Response;


class SalesPersionController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        // if (Auth::user()) {   
        //   $this->middleware('auth');
        // } else {
        //     $this->middleware('guest');

        // }

        $sales = session()->get('sales');
        
        if (!$sales) {
           
            $this->middleware('salesCheckLogin');
            
        }

    }

    public function myOrderListBySales(){
        $sales = session()->get('sales');
       
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('.tbl_item_orders.saler_id', $sales->user_id)
        ->get();
        
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
       
        $theme = Theme::uses('sales')->layout('layout');
       return $theme->scope('order_customer_by_sales', compact('itemOrders'))->render();
    }

    public function viewOrderSales($orderId)
    {
        $itemOrders = DB::table('tbl_item_orders')
            ->where('order_id', $orderId)
            ->get();

        $theme = Theme::uses('sales')->layout('layout');
        return $theme->scope('view_order_sales', compact('itemOrders'))->render();
    
    
    }

    public function SalesDashboard(){
             
        $theme = Theme::uses('sales')->layout('layout');     
        //$brands = get_items($flag = '', $limit = -1);
        // $brands = DB::table('tbl_items')
        //             ->leftJoin('tbl_item_category', function ($joinItemCat) {
        //             $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
        //         })->leftJoin('tbl_brands', function ($brand) {
        //             $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
        //         })
        //         ->leftJoin('tbl_group', function ($group) {
        //             $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
        //         })
        //         ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
        //             )
        //             ->Where('tbl_items.is_visible', 1)
        //     ->orderBy('tbl_items.item_id', 'desc')
            
        //     ->paginate(6);
     
            
        //return $theme->scope('seller_item', compact('brands'))->render();   
           
       
        return $theme->scope('index')->render();      
        
    }
    public function salesPersonItems()
    {
        // $customer = DB::table('tbl_customers')
        // ->leftjoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')
        // ->where('tbl_customers.id', $customerId=34)
        
        // ->first();
        $brands = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                    )
                    ->Where('tbl_items.is_visible', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            
            ->get();
            $theme = Theme::uses('sales')->layout('layout'); 
            return $theme->scope('sales_item', compact('brands'))->render();
    }

    public function getItemsWithCustomerBySeller(Request $request)
    {
        
        //pr($request->all());
        Cart::clear();
        $customer = DB::table('tbl_customers')
                    ->leftjoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')
                    ->where('tbl_customers.id', $request->customerId)
                    ->select('tbl_businesses.*', 'tbl_businesses.id as customerBissiness_id', 'tbl_customers.*')
                    ->first();
                    //pr($customer);
                 $request->session()->put('customerForSalesPanel', $customer);

        $brands = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                    )
                    ->Where('tbl_items.is_visible', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            
            //->paginate();
            ->get();
           
            // return $theme->scope('sales_item', compact('brands', 'customer'))->render();
            $returnView = view('salesItemAppend', compact('brands'))->render();

        return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    

    public function salesProductDetail($item_id)
    {
        //$sms = sendSms('8281834736',"test massege dfh uhgfd");
        
        $theme = Theme::uses('sales')->layout('layout');
        $item = get_item_detail_by_item_id($item_id);
        return $theme->scope('sales_item_detail', compact('item'))->render();

    }
}
