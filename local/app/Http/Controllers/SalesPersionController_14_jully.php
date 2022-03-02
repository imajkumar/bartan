<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Theme;
use Cart;
use Auth;
use DB;
use App\User;
use Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use File;



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
        //pr(session()->get('sales'));SalesDashboard
        //$this->middleware('salesLogoutAfterSomeDays',['except' => ['SalesDashboard']]);
        
        $sales = session()->get('sales');
       //echo $sales;exit;
        if (!$sales) {
           
            $this->middleware('salesCheckLogin');
            
        }
        
    }


    public function itemListLayoutSales()
    { //viewLayout
        DB::enableQueryLog();
        $theme = Theme::uses('sales')->layout('layout');
        $dataObjArr = DB::table('tbl_items')->leftJoin('tbl_group', function ($join) {
            $join->on('tbl_items.group_id', '=', 'tbl_group.g_id');
        })->leftJoin('tbl_item_gallery', function ($join) {
            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
            $join->DISTINCT('tbl_items.item_id');
            //$join->orderBy('tbl_items.item_id','DESC');
            $join->where('tbl_item_gallery.default', 1);
            // SELECT DISTINCT(column_name) FROM table_name ORDER BY column_name DESC limit 2,1;
            //$join->orderBy('tbl_items.item_id','DESC');
            $join->limit(2, 1);
        })->leftjoin('tbl_brands', function ($brand) {
            $brand->on('tbl_items.brand_id', '=', 'tbl_brands.id');
        })
            ->orderBy('tbl_items.item_id', 'DESC')

            ->select('tbl_items.*', 'tbl_brands.id as brandId', 'tbl_brands.name as brandName', 'tbl_group.g_id', 'tbl_group.g_name', 'tbl_item_gallery.img_name', 'tbl_item_gallery.default')
            ->get();
        //echo"<pre>"; print_r($dataObjArr);exit;
        $galleryImages = DB::table('tbl_item_gallery')->rightJoin('tbl_items', function ($join) {
            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
        })->get();

        return $theme->scope('item_by_sales_list', compact('dataObjArr', 'galleryImages'))->render();
    }

    public function itemMasterLayoutSales()
    { //viewLayout
        DB::enableQueryLog();
        $theme = Theme::uses('sales')->layout('layout');
        $dataObjArr = DB::table('tbl_items')->leftJoin('tbl_group', function ($join) {
            $join->on('tbl_items.group_id', '=', 'tbl_group.g_id');
        })->leftJoin('tbl_item_gallery', function ($join) {
            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
            $join->DISTINCT('tbl_items.item_id');
            $join->orderBy('tbl_items.item_id', 'DESC');
            $join->where('tbl_item_gallery.default', 1);
            // SELECT DISTINCT(column_name) FROM table_name ORDER BY column_name DESC limit 2,1;
            // $join->orderBy('tbl_items.item_id','DESC');
            $join->limit(2, 1);
        })
            //->orderBy('DESC')

            ->select('tbl_items.*', 'tbl_group.g_id', 'tbl_group.g_name', 'tbl_item_gallery.img_name', 'tbl_item_gallery.default')
            ->get();

        $brands = DB::table('tbl_brands')->get();
        //echo"<pre>"; print_r(DB::getQueryLog());exit;
        $galleryImages = DB::table('tbl_item_gallery')->rightJoin('tbl_items', function ($join) {
            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
        })->get();

        //$attrFamilys = DB::table('tbl_attribute_families')->where('status', 1)->get();

        return $theme->scope('item_master_sales', compact('dataObjArr', 'galleryImages', 'brands'))->render();
    }

    public function saveChangesProductDetailsSales(Request $request)
    {
        //     pr($request->all());
        //    echo $request->product_discription;exit;


        $itemData = DB::table('tbl_items')->where('item_id', $request->txtItemID)->update([
            'item_name' => $request->item_name,
            'slug' => str::slug($request->item_name, '-'),
            'brand_id' => $request->brand_id,
            'description' => $request->product_discription,
            'invt_unit' => $request->invt_unit,
            'item_sku' => $request->item_sku,

            'regular_price' => $request->regular_price,
            'ori_country' => $request->ori_country,
            'invt_unit' => $request->invt_unit,
            'invt_qty' => $request->invt_qty,
            'invt_saleunit' => $request->invt_saleunit,
            'item_invt_lengh' => $request->item_invt_lengh,
            'item_invt_width' => $request->item_invt_width,
            'item_invt_weight' => $request->item_invt_weight,
            'item_invt_min_order' => $request->item_invt_min_order,
            'item_invt_height' => $request->item_invt_height,
            'barcode' => $request->barcode,

        ]);

        if ($request->productTag) {
            DB::table('tbl_item_tags')->where('item_id', $request->txtItemID)->delete();
            foreach ($request->productTag as $key => $rowData) {
                $tagData = DB::table('tbl_item_tags')->Insert(
                    [
                        'item_id' => $request->txtItemID,
                        'tag_name' => $request->productTag[$key],


                    ]
                );
            }
        }
        //return back()->withInput();

        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }

    public function itemEditLayoutSales($item_id)
    {
        $theme = Theme::uses('sales')->layout('layout');

        $item = DB::table('tbl_items')->leftJoin('tbl_item_category', function ($join) {
            $join->on('tbl_items.cat_id', '=', 'tbl_item_category.id');
        })->leftJoin('tbl_brands', function ($brand) {
            $brand->on('tbl_items.brand_id', '=', 'tbl_brands.id');
        })->select('tbl_items.*', 'tbl_items.item_name as itemName', 'tbl_brands.name as brandName', 'tbl_item_category.id', 'tbl_item_category.item_name')
            ->where('tbl_items.item_id', '=', $item_id)
            ->first();

        $sku = get_sku_by_item_id($item_id);

        $attributeAndOptions = DB::table('tbl_item_attributes')->where('item_id', $item_id)->get();
        $attributeAndOptions = json_decode(json_encode($attributeAndOptions), true);
        //pr($attributeAndOptions);


        $itemImages = DB::table('tbl_items')->leftJoin('tbl_item_gallery', function ($join) {
            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
        })->select('tbl_items.*', 'tbl_item_gallery.img_name', 'tbl_item_gallery.id', 'tbl_item_gallery.default')
            ->where('tbl_items.item_id', '=', $item_id)
            ->get();

        $brands = DB::table('tbl_brands')->get();

        //get attributes by itemcate id 
        $users = DB::table('users')->select('name', 'email as user_email')->get();
        $itemCatID = $item->cat_id;
        $attrArr = DB::table('tbl_items_attributes_data')->where('item_id', $item_id)->get();



        //get attributes by itemcate id 


        return $theme->scope('itemEditBySales', compact('sku', 'attributeAndOptions', 'brands', 'item', 'itemImages', 'attrArr'))->render();
    }


    public function updateItemSales(Request $request, $item_id)
    {


        //echo"<pre>".$item_id; print_r(json_decode($request->categorys));exit;
        $this->validate($request, [
            'item_name' => 'required|string|max:120',
            'item_sku' => 'required|string',
            //'group_id' => 'required|integer',
            'brand_id' => 'required',
            'open_qty' => 'required|integer',
            'min_qty' => 'required|integer',
            'sale_price' => 'integer',
            'regular_price' => 'integer',
            'categorys' => 'required',
        ], [
            'item_name.required' => 'Item name is required.',
            'item_name.string' => 'Item name should be string.',
            'item_name.max' => 'Item name Should be Minimum of 120 Character.',
            'item_sku.required' => 'Item sku is required.',
            'item_sku.string' => 'Item sku should be string.',
            //'group_id.required' => 'Group field is required.',
            'brand_id.required' => 'Brand field is required.',
            'open_qty.required' => 'Open quantity field is required.',
            'open_qty.integer' => 'Open quantity field should be number.',
            'min_qty.required' => 'Min quantity field is required.',
            'min_qty.integer' => 'Min quantity field should be number.',
            'sale_price.integer' => 'Sale price field should be number.',
            'regular_price.integer' => 'Regular price field should be number.',
            'regular_price.required' => 'Category field is required.',
        ]);
        $user_id = Auth::user()->id;
        $query = 0;
        $itemData = DB::table('tbl_items')->where('item_id', $item_id)->update([
            'item_name' => $request->item_name,
            'item_sku' => $request->item_sku,
            //'group_id' => $request->group_id,
            'brand_id' => $request->brand_id,
            'description' => $request->description,
            'sale_price' => $request->sale_price,
            'regular_price' => $request->regular_price,
            'open_qty' => $request->open_qty,
            'min_qty' => $request->min_qty,
        ]);

        if ($itemData) {
            $query = 1;
        }
        if ($request->categorys) {
            $cats = json_decode($request->categorys);
            //echo count($cats); dd($cats);
            DB::table('tbl_item_groups')->where('item_id', $item_id)->delete();
            for ($i = 0; $i < count($cats); $i++) {
                DB::table('tbl_item_groups')->insert([
                    'item_id' => $item_id,
                    'g_id' => $cats[$i],
                ]);
            }
            $query = 1;
        }


        if (count($request->option) > 0) {

            foreach ($request->option as $code => $attrOptions) {
                DB::table('tbl_item_attributes')->where('item_id', $item_id)->where('attr_code', $code)->delete();
                //echo $code;
                foreach ($attrOptions as $attrOption) {
                    DB::table('tbl_item_attributes')->insert([
                        'item_id' => $item_id,
                        'attr_code' => $code,
                        'attr_option' => $attrOption,
                    ]);
                }
            }
            $query = 1;
        }
        if ($query == 1) {
            return Response::json(array('status' => 'success', 'msg' => 'Item updated successfully.', 'url' => route('itemListLayoutSales')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('itemEditLayoutSales', $item_id)));
        }

        
    }

    public function deleteItemImgByAjaxSales(Request $request)
    {
        $itemData = DB::table('tbl_item_gallery')->where('id', $request->imgId)
            ->where('item_id', $request->itemId)->delete();
        if ($itemData) {
            return Response::json(array('status' => 'success', 'msg' => 'Item image deleted successfull.'));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function addPrimaryImgByAjaxSales(Request $request)
    {
        if ($request->defaultVal == 1) {
            $removeAnyPrimary =  DB::table('tbl_item_gallery')->where('item_id', $request->itemId)->update(['default' => 0]);
        }
        $itemData = DB::table('tbl_item_gallery')->where('id', $request->imgId)
            ->where('item_id', $request->itemId)->update(['default' => $request->defaultVal]);
        if ($itemData) {
            return Response::json(array('status' => 'success', 'msg' => 'Item image have been changed successfull.'));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function get_attributesSales()
    {
        $attributes = get_attributes();
        $html = '<option value="" disabled selected>Choose atrribute</option>';

        foreach ($attributes as $attribute) {

            $html .= '<option value="' . $attribute['id'] . '">' . $attribute['admin_name_lable'] . '</option>';
        }
        return $html;
    }

    public function getAttributeOptionsSales(Request $request)
    {
        $options = get_attributes_option_by_attr_id($request->attr_id);
        
        $html = '<option value="" disabled selected>Choose option</option>';

        foreach ($options as $attribute) {

            $html .= '<option value="' . $attribute['id'] . '">' . $attribute['attribute_option_name'] . '</option>';
        }
        return $html;
    }

    public function saveItemSales(Request $request)
    {
        $this->validate($request, [
            'item_name' => 'required|string|max:255',
            'itemCategory' => 'required'

        ], [

            'item_name.required' => 'Product name is required.',
            'itemCategory.string' => 'Select Category',

        ]);
        //$user_id = Auth::user()->id;
        $itemData = DB::table('tbl_items')->insertGetId([
            'item_name' => $request->item_name,
            'slug' => str::slug($request->item_name, '-'),
            'cat_id' => $request->itemCategory
        ]);
       
        // save attribute by category

        if ($itemData) {
            return Response::json(array('status' => 'success', 'msg' => 'Save successfully', 'url' => route('itemEditLayoutSales', $itemData)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function getItembyAjaxSales()
    {
        $dataObjArr = DB::table('tbl_items')->leftJoin('tbl_group', function ($join) {
            $join->on('tbl_items.group_id', '=', 'tbl_group.g_id');
        })->leftJoin('tbl_item_gallery', function ($join) {

            $join->on('tbl_items.item_id', '=', 'tbl_item_gallery.item_id');
            $join->where('tbl_item_gallery.default', 1);
        })->select('tbl_items.*', 'tbl_group.g_id', 'tbl_group.g_name', 'tbl_item_gallery.img_name', 'tbl_item_gallery.default')
            ->get();
        $galleryImages = DB::table('tbl_item_gallery')->get();
        return Response::json(array(
            'status' => 'success',
            'dataForTable' => $dataObjArr,
            'galleryImages' => $galleryImages
        ));
    }

    public function saveChangesProductAttribueSales(Request $request)
    {
        //dd($request->all());

        $sales = session()->get('sales');
        $txtItemID = $request->txtItemID;
        $selectProductCatID = $request->selectProductCatID;

        @$containsKey = Str::contains($request->productAttribute, '_');
        //if ($containsKey) {

        @$dataExp = explode("_", $request->productAttribute);
        @$attributeOptionId = $dataExp[0];
        @$attributeId = $dataExp[1];
        // if(@$request->productAttributeForText){
        if (!empty(@$request->productAttribute_text) && !empty(@$request->productAttributeForText)) {

            $data_arrDataForText = DB::table('tbl_attributes')->where('id', $request->productAttributeForText)->first();
            //$data_arrOptionData = DB::table('tbl_attribute_options')->where('id', $attributeOptionId)->first();

            // if ($data_arrDataForText->type != 'select') {
            if (trim(strtolower($data_arrDataForText->type)) != 'select') {

                DB::table('tbl_items_attributes_data')->updateOrInsert(
                    ['item_id' => $txtItemID, 'item_attr_code' => $data_arrDataForText->attribute_code],
                    [
                        'item_cat_id' => $selectProductCatID,
                        'item_attr_id' => $request->productAttributeForText,

                        'item_attr_value' => $request->productAttribute_text,
                        'item_attr_admin_label' => $data_arrDataForText->admin_name_lable,
                        'created_by' => @$sales->user_id,
                        'created_on' => date('Y-m-d H:i:s'),

                    ]
                );
            }
        }
        if (@$request->productAttribute) {

            $data_arrData = DB::table('tbl_attributes')->where('id', $attributeId)->first();
            $data_arrOptionData = DB::table('tbl_attribute_options')->where('id', $attributeOptionId)->first();

            //dd($data_arrOptionData);
            //$data_arrData = DB::table('tbl_attributes')->where('attribute_code', $attr_codeName)->first();

            DB::table('tbl_items_attributes_data')->updateOrInsert(
                ['item_id' => $txtItemID, 'item_attr_code' => $data_arrData->attribute_code],
                [
                    'item_cat_id' => $selectProductCatID,
                    'item_attr_id' => $attributeId,

                    'item_attr_value' => $data_arrOptionData->attribute_option_name,
                    'item_attr_admin_label' => $data_arrData->admin_name_lable,
                    'created_by' => @$sales->user_id,
                    'created_on' => date('Y-m-d H:i:s'),

                ]
            );
        }

        //}
        $itemCatUpDate = DB::table('tbl_items')->where('item_id', $txtItemID)->update(['cat_id' => $selectProductCatID]);
        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }

    public function saveChangesProductRelationSales(Request $request)
    {

        $itemData = DB::table('tbl_items')->where('item_id', $request->txtItemID)->update([
            'product_up_sale' => $request->product_up_sale,

            'product_cross_sale' => $request->product_cross_sale,
            'product_unit_sale' => $request->product_unit_sale,
            'product_status' => $request->product_status,
            'is_allow_backover' => $request->is_allow_backover,
            'is_visible' => $request->is_visible
        ]);

        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }

    public function saveChangesProductTaxationSales(Request $request)
    {
        $txtItemID = $request->txtItemID;
        $hsn_code = $request->hsn_code;
        $igst = $request->igst;
        $cgst = $request->cgst;
        $sgst = $request->sgst;

        $itemData = DB::table('tbl_items')->where('item_id', $request->txtItemID)->update([
            'hsn_code' => $request->hsn_code,
            'igst' => $request->igst,
            'cgst' => $request->cgst,
            'sgst' => $request->sgst
        ]);



        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }

    public function deleteItemAttrOptionSales(Request $request)
    {
        $attrOtion = DB::table('tbl_items_attributes_data')->where('id', $request->attrOptionId)->first();

        $option = DB::table('tbl_items_attributes_data')->where('id', $request->attrOptionId)->delete();
        if ($option) {
            return Response::json(array('status' => 'success', 'msg' => 'Attribute option deleted successfully.', 'url' => route('itemEditLayoutSales', $attrOtion->item_id)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function getAjaxAttriubeByCatIDSales(Request $request)
    {
        $selectedProductCatID = $request->selectedProductCatID;
        $catAttrChildArr = DB::table('tbl_item_category_child')->where('item_category_id', $selectedProductCatID)->get();
        $HTML = '';
        foreach ($catAttrChildArr as $key => $rowData) {
            $catAttrChildArrr = DB::table('tbl_attributes')->where('id', $rowData->item_attr_id)->first();
            $HTML .= '<option value="' . $rowData->item_attr_id . '">' . @$catAttrChildArrr->admin_name_lable . '</option>';
        }
        echo $HTML;
    }

    public function getAjaxSelectedAttributeValueSales(Request $request)
    {

        $selectAttrID = $request->selectAttrID;
        $catAttrChildArr = DB::table('tbl_attributes')->where('id', $selectAttrID)->first();

        switch ($catAttrChildArr->type) {
            case 'Select':
            case 'select':
                $HTML = '';
                $catAttrChildArrData = DB::table('tbl_attribute_options')->where('attribute_id', $selectAttrID)->get();
                //$HTML .= '<h3>' . $catAttrChildArr->admin_name_lable . ' Attribute</h3>';
                $option = '';

                foreach ($catAttrChildArrData as $key => $rowData) {
                    $opName = $rowData->attribute_id . '_' . $catAttrChildArr->attribute_code . "[]";

                    $option .= '<option value="' . $rowData->id . '_' . $rowData->attribute_id . '">' . $rowData->attribute_option_name . '</option>';
                }

                $HTML = '                  
                            <div class="row">
                            
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">' . ucwords($catAttrChildArr->admin_name_lable) . '</label>
                                    <select class="form-control productAttribute" id="productAttribute" name="productAttribute" placeholder="Please select attribute">                            
                                     "' . $option . '"
                                    </select>
                                </div>
                            </div>
                            
                            </div>
                         ';
                //echo $HTML;exit;
                return Response::json(array('type' => 'select', 'HTML' => $HTML));


                break;


            case 'Text':
            case 'text':
                $HTML = '';



                $HTML .= '                  
                                <div class="row">
                               
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">' . ucwords($catAttrChildArr->admin_name_lable) . '</label>
                                        <input type="text" class="form-control productAttribute" id="productAttribute" name="productAttribute_text" placeholder="Please attribute"/>                                                      
                                        <input type="hidden" class="form-control productAttribute" id="productAttributeForText" name="productAttributeForText" value="' . $selectAttrID . '"/>                        
                                        
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">                    
                                        <button type="button" style="margin-top: 27px;" id="" class="btn btn-sm btn-danger m-r-5 remove_field_Attr">X </button>
                                    </div>
                                </div>
                                </div>
                            ';

                $HTML .= '';

                return Response::json(array('type' => 'text', 'HTML' => $HTML));

                break;
        }
    }

    public function itemActiveSales(Request $request)
    {

        $bannerActive = DB::table('tbl_items')->where('item_id', $request->itemId)
            ->update(['is_visible' => 1]);

        if ($bannerActive) {

            return Response::json(array('status' => 'success', 'msg' => 'Item Active successfull.', 'url' => route('itemListLayoutSales')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function itemDeactiveSales(Request $request)
    {

        $bannerActive = DB::table('tbl_items')->where('item_id', $request->itemId)
            ->update(['is_visible' => 0]);

        if ($bannerActive) {

            return Response::json(array('status' => 'success', 'msg' => 'Item Deactive successfull.', 'url' => route('itemListLayoutSales')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    //End Sales item

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
        $brandId = array();
        $allowBrandOption = '<option value="">Select brand</option>';
			
            $customerBrands = DB::table('customer_wise_brands')->where('customer_id', $request->customerId)->get();
            ///echo "cc";pr($customerBrands);
            if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                   
                   

                }
            }
			$brandsListArr = DB::table('tbl_brands')->whereIn('tbl_brands.id', $brandId)->get();
            foreach($brandsListArr as $brandsList){

                $allowBrandOption .= '<option value="' . $brandsList->id . '">' . $brandsList->name . '</option>';
            }
            
        Cart::clear();
        $customer = DB::table('tbl_customers')
                    ->leftjoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')
                    ->where('tbl_customers.id', $request->customerId)
                    ->select('tbl_businesses.*', 'tbl_businesses.id as customerBissiness_id', 'tbl_customers.*')
                    ->first();
                    //pr($customer);
                 $request->session()->put('customerForSalesPanel', $customer);

        $brandData = DB::table('tbl_items')
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
            ->orderBy('tbl_items.item_id', 'desc');

            //if(count($brandId) > 0){
                $brands = $brandData->whereIn('tbl_items.brand_id', $brandId);
            //}
            
            //->paginate();
            $brands = $brandData->get();
           
            // return $theme->scope('sales_item', compact('brands', 'customer'))->render();
            $returnView = view('salesItemAppend', compact('brands'))->render();

        return response()->json(array('success' =>true, 'ordeHtml' =>$returnView, 'allowBrandOption' => $allowBrandOption));
    }

    public function getItemsWithCustomerBySeller_old_7_jully(Request $request)
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


    public function salesItemByBrand(Request $request)
    {
        $customer = session()->get('customerForSalesPanel');
                         $brandId = array();
                         if(!empty($customer)){
                             $customerBrands = DB::table('customer_wise_brands')->where('user_id', $customer->user_id)->get();
                             if(count($customerBrands) > 0){
                                 foreach($customerBrands as $customerBrand){
                                     $brandId[] = $customerBrand->brand_id;
                                 }
                             }
                         }

        $brandData = DB::table('tbl_items')
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
                    ->Where('tbl_items.brand_id', $request->brandId)
            ->orderBy('tbl_items.item_id', 'desc');

            //if(count($brandId) > 0){
                $brands = $brandData->whereIn('tbl_items.brand_id', $brandId);
            //}
            
            //->paginate();
            $brands = $brandData->get();
           
            // return $theme->scope('sales_item', compact('brands', 'customer'))->render();
            $returnView = view('salesItemAppend', compact('brands'))->render();

        return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    public function salesItemByCategory(Request $request)
    {
        $customer = session()->get('customerForSalesPanel');
        $brandId = array();
        if(!empty($customer)){
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', $customer->user_id)->get();
            if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }
        }
        
        $brandData = DB::table('tbl_items')
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
                    //->Where('tbl_items.brand_id', $request->brandId)
                    ->Where('tbl_items.cat_id', $request->catId)
            ->orderBy('tbl_items.item_id', 'desc');
            
            //if(count($brandId) > 0){
                $brands = $brandData->whereIn('tbl_items.brand_id', $brandId);
            //}
            
            //->paginate();
            $brands = $brandData->get();
            //->paginate();
            // ->get();
           
            // return $theme->scope('sales_item', compact('brands', 'customer'))->render();
            $returnView = view('salesItemAppend', compact('brands'))->render();

        return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    public function salesItemSeach(Request $request)
    {
        $customer = session()->get('customerForSalesPanel');
        $brandId = array();
        if(!empty($customer)){
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', $customer->user_id)->get();
            if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }
        }
        //pr($brandId);
        //echo $customer->user_id;exit;
        $searchKey = filter_search($request->salesItemSeach);
        $keyword = $request->salesItemSeach;

        $brandData = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })
                    ->leftJoin('tbl_item_category_child', function ($group) {
                    $group->on('tbl_item_category_child.item_category_id', '=', 'tbl_item_category.id');
            
                })
                ->leftJoin('tbl_attributes', function ($group) {
                    $group->on('tbl_attributes.id', '=', 'tbl_item_category_child.item_attr_id');
            
                })
                ->leftJoin('tbl_attribute_options', function ($group) {
                    $group->on('tbl_attribute_options.attribute_id', '=', 'tbl_attributes.id');
            
                })

            //end attr

            ->leftJoin('tbl_item_tags', function ($tag) {
                $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                //$tag->orderBy('tbl_item_tags.item_id', 'desc');
                //$tag->distinct('tbl_item_tags.item_id');
            })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                    )
                    ->Where('tbl_items.is_visible', 1)
                    //->Where('tbl_items.brand_id', $request->brandId)
                    
                    //->Where('tbl_items.item_name', 'like', $request->salesItemSeach . '%')
                    // ->Where('tbl_items.item_name', 'like', '%' .$request->salesItemSeach . '%')
            
                    ->Where(function($query) use ($searchKey, $brandId){
                        foreach ($searchKey as $value) {
                           
                            $query->Where('tbl_items.item_name', 'like', "%{$value}%");
                            
                            // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                            // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_group.g_name', 'like', "%{$value}%");
                        }
                        $query->whereIn('tbl_items.brand_id', $brandId);
                    })
        
                    ->Where(function($query) use ($searchKey, $brandId){
                        foreach ($searchKey as $value) {
                           
                            $query->Where('tbl_items.item_name', 'like', "%{$value}%");
                            $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                            $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                            $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', "%{$value}%");
                            $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                            $query->orWhere('tbl_group.g_name', 'like', "%{$value}%");
                        }
                        $query->whereIn('tbl_items.brand_id', $brandId);
                    })

                    ->orWhere(function($query) use ($keyword, $brandId){
                        //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                        $query->whereIn('tbl_items.brand_id', $brandId);
                    })
                    
                    ->distinct('tbl_items.item_id');
                    //->orderBy('tbl_items.item_id', 'desc');
            //if(count($brandId) > 0){
                $brands = $brandData->whereIn('tbl_items.brand_id', $brandId);
            //}
            
            //->paginate();
            $brands = $brandData->get();
            
            //->paginate();
            // ->get();
           //pr($brands);
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
