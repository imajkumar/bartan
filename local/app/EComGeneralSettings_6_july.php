<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use DB;
use App\User;
use Auth;
use paginate;

class ECOMGeneralSettings extends Model
{
    protected $systemDateFormat    = "yyyy/mm/dd";

    protected $countries        = array();

    public function getDateFormat()
    {
        return $this->systemDateFormat;
    }
    public function getUnderGroup()
    {
        $data = DB::table('tbl_group')->get();
        return $data;
    }

    public function getItemCategory()
    {
        // echo "dddd";exit;
        $data = DB::table('tbl_item_category')
        //->join('tbl_items','tbl_items.cat_id','=','tbl_item_category.id')
        ->select('tbl_item_category.*')
        ->distinct('tbl_item_category.item_name')
        //->where('tbl_items.is_visible', 1)
        ->get();
        return $data;
    }

    public function getItemCategoryForGroup()
    {
        // echo "dddd";exit;
        $data = DB::table('tbl_item_category')
        // ->join('tbl_items','tbl_items.cat_id','=','tbl_item_category.id')
        ->join('tbl_group','tbl_group.g_id','=','tbl_item_category.item_under_group_id')
        ->select('tbl_item_category.*', 'tbl_group.*')
        //->orderBy('tbl_group.priority')
        ->orderByRaw('IF(priority = 1, null, 0)')
        ->groupBy('tbl_item_category.item_under_group_id')
        //->where('tbl_items.is_visible', 1)
        ->get();
        return $data;
    }

   

    public function getBarndsByCustomer($brandId = array())
    {
        //pr($brandId);
        $data = DB::table('tbl_brands')
        ->join('tbl_items','tbl_items.brand_id','=','tbl_brands.id')
        // ->join('customer_wise_brands','customer_wise_brands.brand_id','=','tbl_brands.id')
        ->select('tbl_brands.*')
        ->distinct('tbl_brands.name')
        ->where('tbl_items.is_visible', 1);
        if(count($brandId) > 0){
            $data = $data->whereIn('tbl_brands.id', $brandId);
        }
        //->get();

        $data = $data->get();
        
        //pr($data);
        return $data;


    }

    public function getBarnds()
    {
        $data = DB::table('tbl_brands')
        ->join('tbl_items','tbl_items.brand_id','=','tbl_brands.id')
        ->select('tbl_brands.*')
        ->distinct('tbl_brands.name')
        ->where('tbl_items.is_visible', 1)
        ->get();
        // echo "dd";
        // pr($data);
        return $data;


    }
//cart system Helper
function getItembyID($id)
{
    $attribute = DB::table('tbl_items')->where('id', $id)->first();
    
    return $attribute;
}

//cart system Helper

    public function getCountry()
    {
        $data = DB::table('countries')->orderBy('id', 'DESC')->get();
        return $data;
    }

    public function getCountryByCountryId($country_id)
    {
        $data = DB::table('countries')->where('id', $country_id)->first();
        return $data;
    }
    
    public function getAttributeAdminNameByAttrCodeV1($attr_code)
    {
        $data = DB::table('tbl_attributes')->where('attribute_code', $attr_code)->first();
        return $data;
    }

   



    function get_group_by_g_id($g_id)
    {
        $data  = DB::table('tbl_group')->where('g_id', $g_id)->first();
        return $data;
    }


    public function getItemAttributes()
    {
        $data = DB::table('tbl_attribute')->get();
        return $data;
    }

    public function get_item_by_item_id($item_id)
    {
        $data = DB::table('tbl_items')->where('item_id',  $item_id)->first();
        
        return $data;
    }

    public function statesByCountry($country_id)
    {
        $data = DB::table('states')->where('country_id', $country_id)->get();
        return $data;
    }

    public function cityesByState($state_id)
    {
        $data = DB::table('cities')->where('state_id', $state_id)->get();
        return $data;
    }

    public function get_cityNameByCityId($city_id)
    {
        $data = DB::table('cities')->where('id', $city_id)->first();
        return $data;
    }

    public function get_stateNameByStateId($state_id)
    {
        $data = DB::table('states')->where('id', $state_id)->first();
        return $data;
    }

    public function get_banners()
    {
        $data = DB::table('tbl_banners')->get();
        return $data;
    }

    public function get_group_category_cat_id($cat_id)
    {
       
        $data = DB::table('tbl_item_category')
                    ->leftjoin('tbl_group', function($group){
                        $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                        
                    })
                    ->where('tbl_item_category.id', $cat_id)
                    
                    ->first();
                   // pr( $data);
                    $groups=array();
                    $groupStr='';
        // $groups = $data = DB::table('tbl_group')->where('g_id', $data->grp_id)->get();  
       
        // if(count($groups)>0){
        //     foreach($groups as $groupe){
               
        //         $groupStr .= $groupe->g_name;
        //     }
        // }
        
                    $groupStr .= @$data->g_name.'  ->  '.@$data->item_name;
                    // echo $groupStr;
                    // exit;
                   
        return $groupStr;
    }
    //taxation 
    public function getTaxAppliedByProductID($customerID,$itemID,$itemQTY)
    {
        //$user_arr=User::find($customerID);
        $itemArr = DB::table('tbl_items')->where('item_id',$itemID)->first();
        $regular_price=$itemArr->regular_price;
//echo $itemArr->igst;pr($itemArr);
        $IGST=(($regular_price *$itemArr->igst)/100)*$itemQTY;
        $CGST=(($regular_price *$itemArr->cgst)/100)*$itemQTY;
        $SGST=(($regular_price *$itemArr->sgst)/100)*$itemQTY;
        



        $users = DB::table('tbl_customers')->where('user_id',$customerID)->first();
       
        if($users->cutomer_state==10){
            $taxAmout=($CGST+$SGST);
            $data=array(
                'taxAmt'=>$taxAmout,
                'igst'=>0,
                'cgst'=>$CGST,
                'sgst'=>$SGST,
                'igst_p'=>$itemArr->igst,
                'cgst_p'=>$itemArr->cgst,
                'sgst_p'=>$itemArr->sgst,
            );

        }else{
            $taxAmout=$IGST;
            $data=array(
                'taxAmt'=>$taxAmout,
                'igst'=>$IGST,
                'cgst'=>0,
                'sgst'=>0,
                'igst_p'=>$itemArr->igst,
                'cgst_p'=>$itemArr->cgst,
                'sgst_p'=>$itemArr->sgst,
            );

        }
        
        return $data; 


    }

    public function getAllItemCategory()
    {
        $data = DB::table('tbl_item_category')
        //->join('tbl_items','tbl_items.cat_id','=','tbl_item_category.id')
        ->select('tbl_item_category.*')
        ->distinct('tbl_item_category.item_name')
        //->where('tbl_items.is_visible', 1)
        ->get();
        return $data;
    }
    
    //Discout applied  
    public function getDiscountAppliedByProductID($customerID,$itemID,$itemQTY)
    {

        @$itemArr = DB::table('tbl_items')->where('item_id',@$itemID)->first();
        @$regular_price=$itemArr->regular_price;


        $users = DB::table('tbl_customers')->where('user_id',$customerID)->first();
        @$customer_class_discount=@$users->customer_class_discount;
        @$customer_cat_discount=@$users->customer_cat_discount;       
        
        @$usersD1Arr = DB::table('tbl_customer_class_discount')->where('id',@$customer_class_discount)->first();      

        $usersD2Arr = DB::table('tbl_customer_category_discount')->where('id',@$customer_cat_discount)->first();
        @$disAmt1=(@$regular_price * @$usersD1Arr->discount_percentage)/100;
        @$disAmt2=(@$regular_price* @$usersD2Arr->discount_percentage)/100;
        return @$disAmt1+@$disAmt2;

       
        


    }
    


    public function get_gallery_img_by_item_id($item_id)
    {
        $data = DB::table('tbl_item_gallery')->where('item_id', $item_id)->get();
        return $data;
    }

    public function get_item_detail_by_item_id($item_id)
    {
        $data =$data = DB::table('tbl_items')
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
            ->where('tbl_items.slug', $item_id)
            ->first();
            //pr( $data);
           
        return $data;

        
    }


    //Start Retail price calculation
    public function getRetailPrice($customerID,$itemID,$AfterDiscountPrice,$itemQTY=1)
    {
        $itemArr = DB::table('tbl_items')->where('item_id',$itemID)->first();
        $regular_price=$itemArr->regular_price;
        $IGST=(($regular_price *$itemArr->igst)/100)*$itemQTY;
        $CGST=(($regular_price *$itemArr->cgst)/100)*$itemQTY;
        $SGST=(($regular_price *$itemArr->sgst)/100)*$itemQTY;
        
        $users = DB::table('tbl_customers')->where('user_id',$customerID)->first();
       
        //Retail margin formulae= MRP-Sales price with GST after discount)/MRP *100
        $mrp = $itemArr->item_mrp;

        if($itemArr->is_tax_included == 0){
            if($users->cutomer_state==10){
                $taxAmout=($CGST+$SGST);
                $priceWithCgstSgstWithDiscount = ($AfterDiscountPrice+$taxAmout);
                
                $retailPrice = ($mrp - $priceWithCgstSgstWithDiscount)/$mrp*100;

            }else{
                $taxAmout=$IGST;
                $priceWithIgstWithDiscount = ($AfterDiscountPrice+$taxAmout);
                
                $retailPrice = ($mrp - $priceWithIgstWithDiscount)/$mrp*100;

            }
        }else{

            $retailPrice = ($mrp - $AfterDiscountPrice)/$mrp*100;
        }
        
        return round($retailPrice); 


    }
    //EndRetail price calculation

   
    
    

    
    
}
