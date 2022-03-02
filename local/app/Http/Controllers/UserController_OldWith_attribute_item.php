<?php

namespace App\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;
use Theme;
use DB;
use Illuminate\Support\Facades\Auth;
use Response;
use Session;
use File;
use App\User;
use App\SellerType;
use Illuminate\Support\Str;
use App\ItemCategory;
use App\Mail\CustomerApproveMail;
use App\Mail\CustomerRejectedMail;
use App\Mail\SalesPersonSendPassword;
use Illuminate\Support\Facades\Mail;
use Hash;
use Redirect;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // if (Auth::user()) {   
        //   $this->middleware('auth');
        // } else {
        //     $this->middleware('guest');

        // }

    }
   

    // getAjaxAttriubeByCatID
    public function getAjaxAttriubeByCatID(Request $request)
    {
        $selectedProductCatID = $request->selectedProductCatID;
        $catAttrChildArr = DB::table('tbl_item_category_child')->where('item_category_id', $selectedProductCatID)->get();
        $HTML = '';
        foreach ($catAttrChildArr as $key => $rowData) {
            $catAttrChildArr = DB::table('tbl_attributes')->where('id', $rowData->item_attr_id)->first();
            $HTML .= '<option value="' . $rowData->item_attr_id . '">' . $catAttrChildArr->admin_name_lable . '</option>';
        }
        echo $HTML;
    }
    // getAjaxAttriubeByCatID
    //getAjaxSelectedAttributeValue
    public function getAjaxSelectedAttributeValue(Request $request)
    {
        $selectAttrID = $request->selectAttrID;

        $catAttrChildArr = DB::table('tbl_attributes')->where('id', $selectAttrID)->first();
        // print_r($catAttrChildArr->attribute_code);
        // print_r($catAttrChildArr->admin_name_lable);
        // print_r($catAttrChildArr->id);
        // print_r($catAttrChildArr->type);
        $attrID = $catAttrChildArr->id . "_" . $catAttrChildArr->attribute_code;

        switch ($catAttrChildArr->type) {
            case 'select':
                $HTML = '';
                $catAttrChildArrData = DB::table('tbl_attribute_options')->where('attribute_id', $selectAttrID)->get();
                $HTML .= '<h3>' . $catAttrChildArr->admin_name_lable . ' Attribute</h3>';
                foreach ($catAttrChildArrData as $key => $rowData) {
                    $opName = $rowData->attribute_id . '_' . $catAttrChildArr->attribute_code . "[]";

                    $HTML .= '                  
                    <div class="row">
                    <input type="hidden" name="code_aj_' . $attrID . '" value="' . $attrID . '">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label for="exampleInputEmail1">' . ucwords($catAttrChildArr->admin_name_lable) . '</label>
                            <select class="form-control productAttribute" id="productAttribute" name="productAttribute' . $opName . '" placeholder="Please select attribute">                            <option value="' . $rowData->id . '">' . $rowData->attribute_option_name . '</option>                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">                    
                            <button type="button" style="margin-top: 27px;" id="" class="btn btn-sm btn-danger m-r-5 remove_field_Attr">X </button>
                        </div>
                    </div>
                    </div>
                    </div>     
                ';
                }
                $HTML .= '';

                echo $HTML;

                break;


                case 'text':
                    $HTML = '';
                    $catAttrChildArrData = DB::table('tbl_attribute_options')->where('attribute_id', $selectAttrID)->get();
                    $HTML .= '<h3>' . $catAttrChildArr->admin_name_lable . ' Attribute</h3>';
                    foreach ($catAttrChildArrData as $key => $rowData) {
                        $opName = $rowData->attribute_id . '_' . $catAttrChildArr->attribute_code . "[]";
    
                        $HTML .= '                  
                        <div class="row">
                        <input type="hidden" name="code_aj_' . $attrID . '" value="' . $attrID . '">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="exampleInputEmail1">' . ucwords($catAttrChildArr->admin_name_lable) . '</label>
                                <input type="text" class="form-control productAttribute" id="productAttribute" name="productAttribute' . $opName . '" placeholder="Please attribute"/>                            <option value="' . $rowData->id . '">' . $rowData->attribute_option_name . '</option>                           
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">                    
                                <button type="button" style="margin-top: 27px;" id="" class="btn btn-sm btn-danger m-r-5 remove_field_Attr">X </button>
                            </div>
                        </div>
                        </div>
                        </div>     
                    ';
                    }
                    $HTML .= '';
    
                    echo $HTML;
    
                    break;
        }
    }
    //getAjaxSelectedAttributeValue

    public function bannerListLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $bannerLists = DB::table('tbl_banners')->leftjoin('tbl_banner_size', function ($join) {
            $join->on('tbl_banners.size', '=', 'tbl_banner_size.id');
        })
            ->select('tbl_banner_size.id as banner_size_id', 'tbl_banner_size.banner_size', 'tbl_banners.*')
            ->get();
        //dd($bannerLists);
        return $theme->scope('admin.banner.banner_list', compact('bannerLists'))->render();
    }

    public function brandListLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $brandLists = DB::table('tbl_brands')->get();
        //dd($bannerLists);
        return $theme->scope('admin.brand.brand_list', compact('brandLists'))->render();
    }

    public function itemCategories()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $brandLists = DB::table('tbl_brands')->get();
        //dd($bannerLists);
        return $theme->scope('admin.item_category_list', compact('brandLists'))->render();
    }

    public function addCategoryLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $brandLists = DB::table('tbl_brands')->get();
        //dd($bannerLists);
        return $theme->scope('admin.item_category_add', compact('brandLists'))->render();
    }

    public function addBannerLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $bannerSizes = DB::table('tbl_banner_size')->get();
        return $theme->scope('admin.banner.banner_add', compact('bannerSizes'))->render();
    }

    public function addBrandLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.brand.brand_add')->render();
    }

    public function editBannerLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $bannerSizes = DB::table('tbl_banner_size')->get();
        $banner = DB::table('tbl_banners')->where('id', $id)->first();
        return $theme->scope('admin.banner.banner_edit', compact('bannerSizes', 'banner'))->render();
    }

    public function editBrandLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $brand = DB::table('tbl_brands')->where('id', $id)->first();

        return $theme->scope('admin.brand.brand_edit', compact('brand'))->render();
    }

    public function saveBanner(Request $request)
    {
        $this->validate($request, [
            'banner' => 'required|image',
            'size' => 'required',
            //'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $banner = $request->file('banner');

        $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $banner->getClientOriginalName());
        $destinationPath = ITEM_IMG_PATH;
        $image_name = 'banner_' . date('mdis') . $name;
        $banner->move($destinationPath, $image_name);

        $user_id = Auth::user()->id;
        $bannerData = DB::table('tbl_banners')->insert([
            'banner' => $image_name,
            'item_id' => $request->item_id,
            'size' => $request->size,
            'banner_title' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'btn_name' => $request->btn_name,
            'btn_link' => $request->btn_link,
            'status' => ($request->status)? $request->status:0,
            'created_by' => $user_id
        ]);

        if ($bannerData) {
            $request->session()->flash('message', 'Banner save successfully.');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('bannerListLayout');
        } else {
            $request->session()->flash('message', 'Something is wrong try again.');
            $request->session()->flash('message-type', 'warning');
            return redirect()->route('addBannerLayout');
        }
    }

    public function saveBrand(Request $request)
    {
        $this->validate($request, [
            'brand_img' => 'required|image',
            'name' => 'required|max:120',
            //'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        $banner = $request->file('brand_img');

        $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $banner->getClientOriginalName());
        $destinationPath = ITEM_IMG_PATH;
        $image_name = 'brand_' . date('mdis') . $name;
        $banner->move($destinationPath, $image_name);

        $user_id = Auth::user()->id;
        $bannerData = DB::table('tbl_brands')->insert([
            'brand_img' => $image_name,
            'name' => $request->name,
            'description' => $request->description

        ]);

        if ($bannerData) {
            $request->session()->flash('message', 'Brand save successfully.');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('brandListLayout');
        } else {
            $request->session()->flash('message', 'Something is wrong try again.');
            $request->session()->flash('message-type', 'warning');
            return redirect()->route('addBrandLayout');
        }
    }

    public function updateBrand(Request $request, $id)
    {
        $this->validate($request, [
            //'brand_img' => 'required|image',
            'name' => 'required|max:120',
            //'banner' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ($request->hasFile('brand_img')) {
            $banner = $request->file('brand_img');
            $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $banner->getClientOriginalName());
            $destinationPath = ITEM_IMG_PATH;
            $image_name = 'brand_' . date('mdis') . $name;
            $banner->move($destinationPath, $image_name);
            if (File::exists($destinationPath . '/' . $request->input('old_brand'))) {
                File::delete($destinationPath . '/' . $request->input('old_brand'));
            }
        } else {
            $image_name = $request->input('old_brand');
        }

        $user_id = Auth::user()->id;
        $bannerData = DB::table('tbl_brands')->where('id', $id)->update([
            'brand_img' => $image_name,
            'name' => $request->name,
            'description' => $request->description

        ]);

        if ($bannerData) {
            $request->session()->flash('message', 'Brand updated successfully.');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('brandListLayout');
        } else {
            $request->session()->flash('message', 'Something is wrong try again.');
            $request->session()->flash('message-type', 'warning');
            return redirect()->route('editBrandLayout', $id);
        }
    }

    public function updateBanner(Request $request, $id)
    {
        $this->validate($request, [
            //'banner' => 'required|image',
            'size' => 'required',
        ]);

        if ($request->hasFile('banner')) {
            $banner = $request->file('banner');
            $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $banner->getClientOriginalName());
            $destinationPath = ITEM_IMG_PATH;
            $image_name = 'banner_' . date('mdis') . $name;
            $banner->move($destinationPath, $image_name);
            if (File::exists($destinationPath . '/' . $request->input('old_banner'))) {
                File::delete($destinationPath . '/' . $request->input('old_banner'));
            }
        } else {
            $image_name = $request->input('old_banner');
        }
        $user_id = Auth::user()->id;
        $data = [
            'banner' => $image_name,
            'size' => $request->size,
            'btn_name' => $request->btn_name,
            'btn_link' => $request->btn_link,
            'banner_title' => $request->banner_title,
            'banner_desc' => $request->banner_desc,
            'item_id' => $request->item_id,
            'status' => $request->status,

            'created_by' => $user_id
        ];

        $bannerData = DB::table('tbl_banners')->where('id', $id)->update($data);

        if ($bannerData) {

            $request->session()->flash('message', 'Banner updated successfully.');
            $request->session()->flash('message-type', 'success');
            return redirect()->route('bannerListLayout');
        } else {

            $request->session()->flash('message', 'Something is wrong try again.');
            $request->session()->flash('message-type', 'warning');
            return redirect()->route('editBannerLayout', $id);
        }
    }

    public function deleteBanner($id)
    {
        $bannerimg = DB::table('tbl_banners')->where('id', $id)->first();
        $bannerImgForDel = $bannerimg->banner;
        $banner = DB::table('tbl_banners')->where('id', $id)->delete();
        if ($banner) {
            $destinationPath = ITEM_IMG_PATH;
            if (File::exists($destinationPath . '/' . $bannerImgForDel)) {
                File::delete($destinationPath . '/' . $bannerImgForDel);
            }
            return redirect()->route('bannerListLayout')
                ->with(['message' => 'Banner deleted successfully.', 'message-type' => 'success']);
        } else {

            return redirect()->route('bannerListLayout')
                ->with(['message' => 'Something is wrong try again.', 'message-type' => 'warning']);
        }
    }

    public function deleteBrand($id)
    {
        $brandimg = DB::table('tbl_brands')->where('id', $id)->first();
        $brandImgForDel = $brandimg->brand_img;
        $brand = DB::table('tbl_brands')->where('id', $id)->delete();
        if ($brand) {
            $destinationPath = ITEM_IMG_PATH;
            if (File::exists($destinationPath . '/' . $brandImgForDel)) {
                File::delete($destinationPath . '/' . $brandImgForDel);
            }
            return redirect()->route('brandListLayout')
                ->with(['message' => 'Brand deleted successfully.', 'message-type' => 'success']);
        } else {

            return redirect()->route('brandListLayout')
                ->with(['message' => 'Something is wrong try again.', 'message-type' => 'warning']);
        }
    }

    public function uploadGalleryImage(Request $request)  //item gallary uploads
    {
        $photos = $request->file('files');

        $destinationPath = ITEM_IMG_PATH;
        for ($i = 0; $i < count($photos); $i++) {
            $photo = $photos[$i];
            //$name = sha1(date('YmdHis') . microtime());
            $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $photo->getClientOriginalName()) . '_' . $i;

            $image_name = $name . '.' . $photo->getClientOriginalExtension();
            $photo->move($destinationPath, $image_name);

            $user_id = Auth::user()->id;
            $itemData = DB::table('tbl_item_gallery')->insert([
                'item_id' => $request->item_id,
                'img_name' => $image_name,
                'alt_tag' => $photo->getClientOriginalName(),
                'created_by' => $user_id,
            ]);
        }
        $defaultImg = DB::table('tbl_item_gallery')->where('item_id', $request->item_id)->first();
        DB::table('tbl_item_gallery')->where('item_id', $request->item_id)->where('id', $defaultImg->id)
            ->update(['default' => 1]);

        return Response::json([
            'message' => 'Image saved Successfully'
        ], 200);
    }

    // public function addItenImage(Request $request)  //item gallary uploads
    // {
    //     $photos = $request->file('files');

    //     $destinationPath = ITEM_IMG_PATH;
    //     for ($i = 0; $i < count($photos); $i++) {
    //         $photo = $photos[$i];
    //         //$name = sha1(date('YmdHis') . microtime());
    //         $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $photo->getClientOriginalName()).'_'.$i;

    //         $image_name = $name . '.' . $photo->getClientOriginalExtension();
    //         $photo->move($destinationPath, $image_name);

    //         $user_id = Auth::user()->id;
    //         $itemData = DB::table('tbl_item_gallery')->insert([
    //             'item_id' => $request->item_id,
    //             'img_name' => $image_name,
    //             'alt_tag' => $photo->getClientOriginalName(),
    //             'created_by' => $user_id,
    //         ]);


    //     }
    //     $defaultImg = DB::table('tbl_item_gallery')->where('item_id', $request->item_id)->first();
    //     DB::table('tbl_item_gallery')->where('item_id', $request->item_id)->where('id', $defaultImg->id)
    //     ->update(['default'=> 1]);

    //     return Response::json([
    //         'message' => 'Image saved Successfully'
    //     ], 200);
    // }

    public function saveAttribute(Request $request)
    {
        $this->validate($request, [
            'attr_name' => 'required|string|unique:tbl_attribute|max:120',
        ], [
            'attr_name.required' => 'Attribute name is required.',
            'attr_name.string' => 'Attribute name should be string.',
            'attr_name.max' => 'Attribute name Should be Minimum of 120 Character.',
        ]);
        $attrTable = 'tbl_' . strtolower(trim($request->attr_name));
        $itemData = DB::table('tbl_attribute')->insert([
            'attr_name' => ucfirst($request->attr_name),
            'table_name' => $attrTable,

        ]);
        if ($itemData) {
            Schema::create($attrTable, function ($table) {
                $table->increments('id');
                $table->string('attr_name');
                $table->integer('is_active')->default(1);
            });
            return Response::json(array('status' => 'success', 'msg' => 'New Attribute added successfully.'));
        } else {
            return Response::json(array('status' => 'wrong', 'msg' => 'Something is wrong try again.'));
        }
    }
    //saveChangesProductTaxation

    //saveChangesProductTaxation
    public function saveChangesProductTaxation(Request $request)
    {
       
         $txtItemID=$request->txtItemID;
         $hsn_code=$request->hsn_code;
         $igst=$request->igst;
         $cgst=$request->cgst;
         $sgst=$request->sgst;

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

    
    //saveChangesProductRelation
    public function saveChangesProductRelation(Request $request)
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
    //saveChangesProductRelation

    //itemCategoriesEdit
    public function itemCategoriesEdit($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $category = DB::table('tbl_item_category')->where('id', $id)->first();
        $categoryAttributes = DB::table('tbl_item_category_child')->where('item_category_id', $category->id)->get();
        
        return $theme->scope('admin.item_category_edit', compact('category', 'categoryAttributes'))->render();
    }
    //itemCategoriesEdit
    //saveChangesProductDetails
    public function saveChangesProductDetails(Request $request)
    {
        //pr($request->all());
       //echo $request->product_discription;exit;tags


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
        
        if($request->productTag){
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
    //saveChangesProductDetails

    public function checkUniBarcode(Request $request)
    {
        $check = DB::table('tbl_items')->where('barcode', $request->barcode)->count();
        if($check > 0){
            return Response::json(array(
                'status' => 1,
                'msg' => 'Barcode already exist.'
    
            ));
        }else{
            return Response::json(array(
                'status' => 0,
                'msg' => 'Barcode not exist.'
    
            ));
        }
    }

    public function saveItem(Request $request)
    {
        $this->validate($request, [
            'item_name' => 'required|string|max:255',
            'itemCategory' => 'required'

        ], [

            'item_name.required' => 'Product name is required.',
            'itemCategory.string' => 'Select Category',

        ]);
        $user_id = Auth::user()->id;
        $itemData = DB::table('tbl_items')->insertGetId([
            'item_name' => $request->item_name,
            'slug' => str::slug($request->item_name, '-'),
            'cat_id' => $request->itemCategory
        ]);
        // save attribute by category
        // DB::table('bl_items_attributes_data')->where('item_id', '>', 100)->delete();

        // $attributeArr = DB::table('tbl_item_category_child')->where('item_category_id', $request->itemCategory)->get();

        // foreach ($attributeArr as $key => $rowData) {
        //     DB::table('tbl_items_attributes_data')->updateOrInsert(
        //         ['item_id' => $itemData, 'item_attr_id' => $rowData->item_attr_id],
        //         [

        //             'item_attr_id' => $rowData->item_attr_id,
        //             'is_required' => $rowData->is_required,
        //             'is_unique' => $rowData->is_unique,
        //             'is_compareable' => $rowData->is_compareable,

        //         ]
        //     );
        // }
        //ha di
        // $txtItemID = $request->txtItemID;
        // $attribute = $request->attribute;
        // $is_required = $request->is_required;
        // $is_unique = $request->is_unique;
        // $is_comparable = $request->is_comparable;

        // foreach ($attribute as $key => $row) {
        //     $attrID = $attribute[$key];
        //     $is_requiredVal = $is_required[$key];
        //     $is_uniqueVal = $is_unique[$key];
        //     $is_comparableVal = $is_comparable[$key];
        //     DB::table('tbl_items_attributes_data')->updateOrInsert(
        //         ['item_id' => $txtItemID, 'item_attr_id' => $attrID],
        //         [
        //             'item_id' => $txtItemID,
        //             'item_attr_id' => $attrID,
        //             'is_required' => $is_requiredVal,
        //             'is_unique' => $is_uniqueVal,
        //             'is_compareable' => $is_comparableVal,

        //         ]
        //     );
        // }

        // save attribute by category

        if ($itemData) {
            return Response::json(array('status' => 'success', 'msg' => 'Save successfully', 'url' => route('itemEditLayout', $itemData)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function deleteItemImgByAjax(Request $request)
    {
        $itemData = DB::table('tbl_item_gallery')->where('id', $request->imgId)
            ->where('item_id', $request->itemId)->delete();
        if ($itemData) {
            return Response::json(array('status' => 'success', 'msg' => 'Item image deleted successfull.'));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function addPrimaryImgByAjax(Request $request)
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



    public function updateItem(Request $request, $item_id)
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
            return Response::json(array('status' => 'success', 'msg' => 'Item updated successfully.', 'url' => route('itemListLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('itemEditLayout', $item_id)));
        }

        // if ($itemData) {
        //     $request->session()->flash('message', 'Item updated successfully.');
        //     $request->session()->flash('message-type', 'success');

        //     return redirect()->route('itemEditLayout', $item_id);
        //     //return Response::json(array('status' => 'success', 'msg' => 'Item details updated successfull.'));
        // } else {
        //     $request->session()->flash('message', 'Something is wrong try again.');
        //     $request->session()->flash('message-type', 'warning');
        //     return redirect()->route('itemEditLayout', $item_id);
        //     //return Response::json(array('status' => 'wrong', 'msg' => 'Something is wrong try again'));
        // }
    }

    public function itemMasterLayout()
    { //viewLayout
        DB::enableQueryLog();
        $theme = Theme::uses('backend')->layout('layout');
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

        return $theme->scope('admin.item_master', compact('dataObjArr', 'galleryImages', 'brands'))->render();
    }

    public function itemListLayout()
    { //viewLayout
        DB::enableQueryLog();
        $theme = Theme::uses('backend')->layout('layout');
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

        return $theme->scope('admin.item_list', compact('dataObjArr', 'galleryImages'))->render();
    }

    public function getItembyAjax()
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

    public function addGalleryImage($item_id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $data = ['item_id' => $item_id];
        return $theme->scope('admin.add_gallery', $data)->render();
    }

    public function masterSettingsLayout()
    { //viewLayout
       
        $theme = Theme::uses('backend')->layout('layout');
        $data = ['data' => ''];


        return $theme->scope('admin.master_settings', $data)->render();
    }

    

    public function customerListLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $dataObjArr = DB::table('tbl_customers')->orderBy('created_at', 'DESC')->get();

        return $theme->scope('admin.customer_list', compact('dataObjArr'))->render();
    }

    public function addressListLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $addresses = DB::table('tbl_addresses')->orderBy('id', 'DESC')->where('customer_id', $id)->get();
        $customer = DB::table('tbl_customers')->where('id', $id)->first();

        return $theme->scope('admin.address_list', compact('addresses', 'customer'))->render();
    }

    public function addAddressLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $customer = DB::table('tbl_customers')->where('id', $id)->first();

        return $theme->scope('admin.address_add', compact('customer'))->render();
    }

    public function editAttributeLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $attribute = DB::table('tbl_attributes')->where('id', $id)->first();
        $attributeOptions = DB::table('tbl_attribute_options')->where('attribute_id', $attribute->id)->get();
        return $theme->scope('admin.attribute.attribute_edit', compact('attribute', 'attributeOptions'))->render();
    }

    public function attributesLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $attributes = DB::table('tbl_attributes')->get();
        //pr($customers);
        return $theme->scope('admin.attribute.attributes', compact('attributes'))->render();
    }

    public function attributeFamiliesLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $attributeFamilies = DB::table('tbl_attribute_families')->get();
        //pr($customers);
        return $theme->scope('admin.attribute.attribute_families', compact('attributeFamilies'))->render();
    }

    public function addAttrFamilyLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $attributes = DB::table('tbl_attributes')->get();
        return $theme->scope('admin.attribute.attribute_families_add', compact('attributes'))->render();
    }

    public function editAttributeFamilyLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $attrFamily = DB::table('tbl_attribute_families')->where('id', $id)->first();

        $attrFamilyGroups = DB::table('tbl_attribute_families_group')->where('attribute_family_id', $attrFamily->id)->get();
        $attrFamilyGroups = json_decode(json_encode($attrFamilyGroups), true);

        $attrFamily = DB::table('tbl_attribute_families')->where('id', $id)->first();
        $attributes = DB::table('tbl_attributes')->get();

        return $theme->scope('admin.attribute.edit_attribute_family', compact('attributes', 'attrFamily', 'attrFamilyGroups'))->render();
    }

    public function addAttributeLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');

        return $theme->scope('admin.attribute.attribute_add')->render();
    }

    public function updateAttribute(Request $request)
    {
        $this->validate($request, [
            'attribute_code' => 'required|string|max:191',
            'type' => 'required|max:191',
            'admin_name_lable' => 'required|string|max:191',
        ], [
            'attribute_code.required' => 'Attribute code is required.',
            'attribute_code.string' => 'Attribute code should be string.',
            'attribute_code.max' => 'Attribute code should not be grater than 191 Character.',

            'admin_name_lable.required' => 'Lable is required.',
            'admin_name_lable.string' => 'Lable should be string.',
            'admin_name_lable.max' => 'Lable should not be grater than 191 Character.',

            'type.required' => 'Type is required.',
            'type.max' => 'Last name should not be grater than 191 Character.',

        ]);
        $addressData = DB::table('tbl_attributes')->where('id', $request->attribute_id)->update([
            'attribute_code' => $request->attribute_code,
            'type' => $request->type,
            'admin_name_lable' => $request->admin_name_lable,
            'is_required' => $request->is_required,
            'is_unique' => $request->is_unique,
            'input_validation' => $request->input_validation,
            'is_comparable' => $request->is_comparable,
            'is_visible_on_front' => $request->is_visible_on_front,

        ]);

        if ($addressData) {
            $delOption = DB::table('tbl_attribute_options')->where('attribute_id', $request->attribute_id)->delete();

            for ($i = 0; $i < count($request->options); $i++) {
                $option = DB::table('tbl_attribute_options')->insert([
                    'attribute_option_name' => $request->options[$i],
                    'attribute_id' => $request->attribute_id,
                ]);
            }
            return Response::json(array('status' => 'success', 'msg' => 'Attribute updated successfully.', 'url' => route('attributesLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editAttributeLayout', $request->attribute_id)));
        }
    }

    public function updateAttributeFamily(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|string|max:191',
            'name' => 'required|string|max:191',
        ]);

        $addressData = DB::table('tbl_attribute_families')->where('id', $request->attribute_families_id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,

        ]);

        if ($addressData) {
            $delFamilyGroup = DB::table('tbl_attribute_families_group')->where('attribute_family_id', $request->attribute_families_id)->delete();

            $attr = $request->request->get('attributes');
            for ($i = 0; $i < count($attr); $i++) {
                $option = DB::table('tbl_attribute_families_group')->insert([
                    'attribute_id' => $attr[$i],
                    'attribute_family_id' => $request->attribute_families_id,
                ]);
            }

            return Response::json(array('status' => 'success', 'msg' => 'Attribute Family updated successfully.', 'url' => route('attributeFamiliesLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editAttributeFamilyLayout', $request->attribute_families_id)));
        }
    }

    public function addAttributeFamily(Request $request)
    {

        $this->validate($request, [
            'code' => 'required|string|max:191|unique:tbl_attribute_families,code',
            'name' => 'required|string|max:191|unique:tbl_attribute_families,name',
        ]);

        $addressData = DB::table('tbl_attribute_families')->insertGetId([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,

        ]);

        if ($addressData) {
            $attr = $request->request->get('attributes');
            for ($i = 0; $i < count($attr); $i++) {
                //echo $attr[$i];
                $option = DB::table('tbl_attribute_families_group')->insert([
                    'attribute_id' => $attr[$i],
                    'attribute_family_id' => $addressData,
                ]);
            }

            return Response::json(array('status' => 'success', 'msg' => 'Attribute Family saved successfully.', 'url' => route('attributeFamiliesLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function addAttribute(Request $request)
    {

        $this->validate($request, [
            'attribute_code' => 'required|string|max:191|unique:tbl_attributes,attribute_code',
            'type' => 'required|max:191',
            'admin_name_lable' => 'required|string|max:191|unique:tbl_attributes,admin_name_lable',
        ], [
            'attribute_code.required' => 'Attribute code is required.',
            'attribute_code.string' => 'Attribute code should be string.',
            'attribute_code.max' => 'Attribute code should not be grater than 191 Character.',

            'admin_name_lable.required' => 'Lable is required.',
            'admin_name_lable.string' => 'Lable should be string.',
            'admin_name_lable.max' => 'Lable should not be grater than 191 Character.',

            'type.required' => 'Type is required.',
            'type.max' => 'Last name should not be grater than 191 Character.',

        ]);

        $addressData = DB::table('tbl_attributes')->insertGetId([
            'attribute_code' => $request->attribute_code,
            'type' => $request->type,
            'admin_name_lable' => $request->admin_name_lable,
            // 'is_required' => $request->is_required,
            // 'is_unique' => $request->is_unique,
            // 'input_validation' => $request->input_validation,
            // 'is_comparable' => $request->is_comparable,
            // 'is_visible_on_front' => $request->is_visible_on_front,

        ]);

        if ($addressData) {
            for ($i = 0; $i < count($request->options); $i++) {
                $option = DB::table('tbl_attribute_options')->insertGetId([
                    'attribute_option_name' => $request->options[$i],
                    'attribute_id' => $addressData,
                ]);
            }


            return Response::json(array('status' => 'success', 'msg' => 'Attribute saved successfully.', 'url' => route('attributesLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('addAttributeLayout')));
        }
    }

    public function editAddressLayout($id)
    {

        $theme = Theme::uses('backend')->layout('layout');
        //$customer = DB::table('tbl_customers')->where('id', $id)->first();
        $address = DB::table('tbl_addresses')->where('id', $id)->first();
        $address = json_decode(json_encode($address), true);
        //echo "<pre>";print_r($address);exit;
        return $theme->scope('admin.address_edit', compact('address'))->render();
    }

    public function editCustomerLayout($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $customer = DB::table('tbl_customers')->where('id', $id)->first();

        // $customerProfile = DB::table('tbl_customers')->where('tbl_customers.id', $id)
        // //->rightjoin('tbl_customers','tbl_customers.user_id','=','users.id')
        // ->rightjoin('tbl_addresses','tbl_addresses.customer_id','=','tbl_customers.id')
        // ->select('tbl_customers.*', 'tbl_customers.f_name as cutomer_fname', 'tbl_customers.l_name as cutomer_lname', 
        // 'tbl_addresses.id as address_id',  'tbl_addresses.company_name', 'tbl_addresses.street_address', 'tbl_addresses.country',
        // 'tbl_addresses.state','tbl_addresses.city','tbl_addresses.postal_code')
        // ->first();
        $customerProfile = DB::table('tbl_customers')->where('tbl_customers.id', $id)
            ->leftjoin('tbl_businesses', 'tbl_businesses.customer_id', '=', 'tbl_customers.id')

            ->leftjoin('tbl_addresses', 'tbl_addresses.customer_id', '=', 'tbl_customers.id')
            ->leftjoin('tbl_customer_documents', 'tbl_customer_documents.customer_id', '=', 'tbl_customers.id')
            ->select(
                'tbl_customers.id as cust_id',
                'tbl_customers.*',
                'tbl_addresses.id as address_id',
                'tbl_addresses.*',
                'tbl_businesses.*',
                'tbl_customer_documents.id as docs_id',
                'tbl_customer_documents.*'
            )
            ->first();



        $user = DB::table('users')->where('id', $customerProfile->user_id)->first();
        return $theme->scope('admin.customer_edit', compact('customer', 'customerProfile', 'user'))->render();
    }

    public function addAddress(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'f_name' => 'required|string|max:120',
            'l_name' => 'required|string|max:120',
            'street_address' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            //'phone' => 'required|integer',
            'postal_code' => 'required|integer',

        ], [
            'f_name.required' => 'First name is required.',
            'f_name.string' => 'First name should be string.',
            'f_name.max' => 'First name should not be grater than 120 Character.',

            'street_address.required' => 'Street adrress is required.',
            'street_address.string' => 'Street adrress should be string.',


            //'phone.required' => 'Phone number is required.',
            //'phone.integer' => 'Phone number should be number.',
            'postal_code.required' => 'Postal code is required.',
            'postal_code.integer' => 'Postal code should be number.',

            'l_name.required' => 'Last name is required.',
            'l_name.string' => 'Last name should be string.',
            'l_name.max' => 'Last name should not be grater than 120 Character.',

            'country.required' => 'Country is required.',
            'state.required' => 'State is required.',
            'city.required' => 'City is required.',
        ]);

        $checks = DB::table('tbl_addresses')->where('customer_id', $request->customer_id)->where('default_address', 1)->get();
        if (count($checks) > 0) {
            DB::table('tbl_addresses')->where('customer_id', $request->customer_id)->update([
                'default_address' => 0,
            ]);
        }
        $addressData = DB::table('tbl_addresses')->insertGetId([
            'customer_id' => $request->customer_id,
            'address_user_id' => $request->user_id,
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            //'company_name' => $request->company_name,
            'street_address' => $request->street_address,
            'country' => $request->country,
            //'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'default_address' => ($request->default_address) ? 1 : 0,
        ]);

        if ($addressData) {
            return Response::json(array('status' => 'success', 'msg' => 'Address saved successfully.', 'url' => route('addressListLayout', $request->customer_id)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('addAddressLayout', $request->customer_id)));
        }
    }

    public function updateAddress(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'f_name' => 'required|string|max:120',
            'l_name' => 'required|string|max:120',
            'street_address' => 'required|string',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            //'phone' => 'required|integer',
            'postal_code' => 'required|integer',

        ], [
            'f_name.required' => 'First name is required.',
            'f_name.string' => 'First name should be string.',
            'f_name.max' => 'First name should not be grater than 120 Character.',

            'street_address.required' => 'Street adrress is required.',
            'street_address.string' => 'Street adrress should be string.',


            // 'phone.required' => 'Phone number is required.',
            // 'phone.integer' => 'Phone number should be number.',
            'postal_code.required' => 'Postal code is required.',
            'postal_code.integer' => 'Postal code should be number.',

            'l_name.required' => 'Last name is required.',
            'l_name.string' => 'Last name should be string.',
            'l_name.max' => 'Last name should not be grater than 120 Character.',

            'country.required' => 'Country is required.',
            'state.required' => 'State is required.',
            'city.required' => 'City is required.',
        ]);

        $checks = DB::table('tbl_addresses')->where('customer_id', $request->customer_id)
            ->where('default_address', 1)->get();

        if (count($checks) > 0 && $request->default_address == 1) {
            DB::table('tbl_addresses')->where('customer_id', $request->customer_id)->update([
                'default_address' => 0,
            ]);
        }


        $addressData = DB::table('tbl_addresses')->where('id', $request->address_id)->update([
            'customer_id' => $request->customer_id,
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'address_user_id' => $request->address_user_id,
            //'company_name' => $request->company_name,
            'street_address' => $request->street_address,
            'country' => $request->country,
            //'phone' => $request->phone,
            'state' => $request->state,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'default_address' => ($request->default_address) ? 1 : 0,
        ]);

        if ($addressData) {
            return Response::json(array('status' => 'success', 'msg' => 'Address saved successfully.', 'url' => route('addressListLayout', $request->customer_id)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editAddressLayout', $request->address_id)));
        }
    }

    public function addNewCustomer(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'f_name' => 'required|string|max:120',
            'l_name' => 'required|string|max:120',
            'email' => 'required|string|max:50',
            'gender' => 'required',
            'dob' => 'max:15',
            //'phone' => 'required|integer|max:10',
            // 'min_qty' => 'required|integer',
        ], [
            'f_name.required' => 'First name is required.',
            'f_name.string' => 'First name should be string.',
            'f_name.max' => 'First name should not be grater than 120 Character.',

            'phone.required' => 'Phone name is required.',
            'phone.integer' => 'Phone number should be number.',
            //'phone.max' => 'Phone should not be grater than 10 Character.',

            'l_name.required' => 'Last name is required.',
            'l_name.string' => 'Last name should be string.',
            'l_name.max' => 'Last name should not be grater than 120 Character.',
            'dob.max' => 'Date of birth should not be grater than 15 Character.',

            'gender.required' => 'Gender is required.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email should be string.',
            'email.max' => 'Email should not be grater than 50 Character.',

        ]);
        $user_id = Auth::user()->id;
        $customerData = DB::table('tbl_customers')->insertGetId([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'customer_type' => $request->customer_type,

        ]);

        if ($customerData) {
            return Response::json(array('status' => 'success', 'msg' => 'Customer save successfully.', 'url' => route('customerListLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('addNewCustomerLayout')));
        }
        //return $theme->scope('admin.customer_list', $dataObjArr)->render();
    }

    public function updateCustomer(Request $request)
    {
        //dd($request->all());
        $this->validate($request, [
            'f_name' => 'required|string|max:120',
            'l_name' => 'required|string|max:120',
            'email' => 'required|string|max:50',
            'gender' => 'required',
            'dob' => 'max:15',
            //'phone' => 'required|integer|max:10',
            // 'min_qty' => 'required|integer',
        ], [
            'f_name.required' => 'First name is required.',
            'f_name.string' => 'First name should be string.',
            'f_name.max' => 'First name should not be grater than 120 Character.',

            'phone.required' => 'First name is required.',
            'phone.integer' => 'Phone number should be number.',
            //'phone.max' => 'Phone should not be grater than 10 Character.',

            'l_name.required' => 'Last name is required.',
            'l_name.string' => 'Last name should be string.',
            'l_name.max' => 'Last name should not be grater than 120 Character.',
            'dob.max' => 'Date of birth should not be grater than 15 Character.',

            'gender.required' => 'Gender is required.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email should be string.',
            'email.max' => 'Email should not be grater than 50 Character.',

        ]);
        $user_id = Auth::user()->id;
        $customerData = DB::table('tbl_customers')->where('id', $request->customer_id)->update([
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'email' => $request->email,
            'gender' => $request->gender,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'customer_type' => $request->customer_type,

        ]);

        if ($customerData) {
            return Response::json(array('status' => 'success', 'msg' => 'Customer updated successfully.', 'url' => route('customerListLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editCustomerLayout', $request->customer_id)));
        }
    }

    public function discountNeeraj(Request $request)
    {
        echo "ccc";pr($request->all());
        $option = DB::table('tbl_customer_class_discount')->where('id', $request->classDiscountId)->delete();

        
        if ($option) {
            return Response::json(array('status' => 'success', 'msg' => 'Discount deleted successfully.', 'url' => route('discountLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }
    
    public function deleteCategoryDiscount(Request $request)
    {
        pr($request->all());
        $option = DB::table('tbl_customer_category_discount')->where('id', $request->categoryDiscountId)->delete();

        
        if ($option) {
            return Response::json(array('status' => 'success', 'msg' => 'Discount deleted successfully.', 'url' => route('discountLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function deleteItemAttrOption(Request $request)
    {
        $attrOtion = DB::table('tbl_items_attributes_data')->where('id', $request->attrOptionId)->first();

        $option = DB::table('tbl_items_attributes_data')->where('id', $request->attrOptionId)->delete();
        if ($option) {
            return Response::json(array('status' => 'success', 'msg' => 'Attribute option deleted successfully.', 'url' => route('itemEditLayout', $attrOtion->item_id)));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function deleteCustomer(Request $request)
    {

        $customer = DB::table('tbl_customers')->where('id', $request->customer_id)->delete();
        if ($customer) {
            return Response::json(array('status' => 'success', 'msg' => 'Customer deleted successfully.', 'url' => route('customerListLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function addNewCustomerLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $dataObjArr = ['data' => ''];

        return $theme->scope('admin.customer_add', $dataObjArr)->render();
    }

    public function get_attributes()
    {
        $attributes = get_attributes();
        $html = '<option value="" disabled selected>Choose atrribute</option>';

        foreach ($attributes as $attribute) {

            $html .= '<option value="' . $attribute['id'] . '">' . $attribute['admin_name_lable'] . '</option>';
        }
        return $html;
    }

    //getAjaxAttributes
    public function getAjaxAttributes(Request  $request)
    {

        $attributes = get_attributes();
        $html = "";
        foreach ($attributes as $attribute) {
            $html .= '<option value=' . $attribute['id'] . '>' . $attribute['admin_name_lable'] . '</option>';
        }

        return $html;
    }
    //getAjaxAttributes

    //saveItemCategory
    public function saveItemCategory(Request  $request)
    {
        $item_category_name = $request->item_category_name;
        $UnderGroup = $request->UnderGroup;
        $desc_message = $request->message;

        $attribute = $request->attribute;
        $is_required = $request->is_required;
        $is_unique = $request->is_unique;
        $is_comparable = $request->is_comparable;

        $itemcatObject = new ItemCategory();
        $itemcatObject->item_name = $item_category_name;
        $itemcatObject->item_under_group_id = $UnderGroup;
        $itemcatObject->item_description = $desc_message;
        $itemcatObject->created_by = Auth::user()->id;
        $itemcatObject->save();
        $itemCatID = $itemcatObject->id;

        foreach ($attribute as $key => $row) {
            $attrID = $attribute[$key];
            $is_requiredVal = $is_required[$key];
            $is_uniqueVal = $is_unique[$key];
            $is_comparableVal = $is_comparable[$key];
            DB::table('tbl_item_category_child')->insert(
                [
                    'item_category_id' => $itemCatID,
                    'item_attr_id' => $attrID,
                    'is_required' => $is_requiredVal,
                    'is_unique' => $is_uniqueVal,
                    'is_compareable' => $is_comparableVal,

                ]
            );
        }

        $res_arr = array(
            'status' => 1,
            'msg' => 'Save Successfully',
            'url' => route('itemCategories')

        );
        return response()->json($res_arr);
    }

    public function updateItemCategory(Request  $request)
    {
        $item_category_name = $request->item_category_name;
        $UnderGroup = $request->UnderGroup;
        $desc_message = $request->message;

        $attribute = $request->attribute;
        $is_required = $request->is_required;
        $is_unique = $request->is_unique;
        $is_comparable = $request->is_comparable;

        $itemcatObject = ItemCategory::find($request->item_cat_id);
        $itemcatObject->item_name = $item_category_name;
        $itemcatObject->item_under_group_id = $UnderGroup;
        $itemcatObject->item_description = $desc_message;
        $itemcatObject->created_by = Auth::user()->id;
        $itemcatObject->save();
        $itemCatID = $itemcatObject->id;

        DB::table('tbl_group')->where('g_id', $UnderGroup)->update(['is_used' => 1]);
   
        DB::table('tbl_item_category_child')->where('item_category_id', $itemCatID)->delete();
        foreach ($attribute as $key => $row) {
            $attrID = $attribute[$key];
            $is_requiredVal = $is_required[$key];
            $is_uniqueVal = $is_unique[$key];
            $is_comparableVal = $is_comparable[$key];
            DB::table('tbl_item_category_child')->insert(
                [
                    'item_category_id' => $itemCatID,
                    'item_attr_id' => $attrID,
                    'is_required' => $is_requiredVal,
                    'is_unique' => $is_uniqueVal,
                    'is_compareable' => $is_comparableVal,

                ]
            );
        }

        $res_arr = array(
            'status' => 1,
            'msg' => 'Update Successfully',
            'url' => route('itemCategories')

        );
        return response()->json($res_arr);
    }
    //saveItemCategory

    public function getAttributeOptions(Request $request)
    {
        $options = get_attributes_option_by_attr_id($request->attr_id);
        // $html = '';

        // foreach($options as $attribute){
        //     $html .= '<label class="">'.$attribute['attribute_option_name'].'</label>';
        //     $html .= '<input type="checkbox" name="option[]" value="'.$attribute['id'].'" class="" multiple/>';


        // }
        // return $html;
        $html = '<option value="" disabled selected>Choose option</option>';

        foreach ($options as $attribute) {

            $html .= '<option value="' . $attribute['id'] . '">' . $attribute['attribute_option_name'] . '</option>';
        }
        return $html;
    }

    public function itemEditLayout($item_id)
    {
        $theme = Theme::uses('backend')->layout('layout');

        $item = DB::table('tbl_items')->leftJoin('tbl_item_category', function ($join) {
            $join->on('tbl_items.cat_id', '=', 'tbl_item_category.id');
        })->leftJoin('tbl_brands', function ($brand) {
            $brand->on('tbl_items.brand_id', '=', 'tbl_brands.id');
        })->select('tbl_items.*', 'tbl_items.item_name as itemName','tbl_brands.name as brandName', 'tbl_item_category.id', 'tbl_item_category.item_name')
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


        return $theme->scope('admin.item_edit', compact('sku','attributeAndOptions', 'brands', 'item', 'itemImages', 'attrArr'))->render();
    }
    //saveChangesProductAttribue
    public function saveChangesProductAttribue(Request $request)
    {
         //print_r($request->all());

        $txtItemID = $request->txtItemID;
        $selectProductCatID = $request->selectProductCatID;
        foreach ($request->except('_token') as $key => $part) {
            $containsKey = Str::contains($key, 'code_aj');
            if ($containsKey) {

                $dataExp = explode("code_aj_", $key);
                $dataExpNew = explode("_", $dataExp[1]);
                $attr_codeName = $dataExpNew[1];
                $reqFiled = "productAttribute" . $dataExp[1];
                //echo $attr_codeName."/";
                //exit($reqFiled);
              
                    foreach ($request->$reqFiled as $key => $attr_code) {
                        //exit($attr_code);                   
                       //$data_arr = DB::table('tbl_attribute_options')->where('id', $attr_code)->first();
                      // print_r($data_arr->attribute_option_name);
                      $data_arrData = DB::table('tbl_attributes')->where('attribute_code', $attr_codeName)->first();
                        
                      if($data_arrData->type != 'select'){

                            DB::table('tbl_items_attributes_data')->updateOrInsert(
                                ['item_id' => $txtItemID, 'item_attr_code' => $attr_codeName],
                                [
                                    'item_cat_id' => $selectProductCatID,
                                    'item_attr_id' => $data_arrData->id,
                                    //'item_attr_code' => $attr_codeName,
                                    'item_attr_value' => $attr_code,
                                    'item_attr_admin_label' => $data_arrData->admin_name_lable,
                                    'created_by' =>Auth::user()->id,
                                    'created_on' => date('Y-m-d H:i:s'),
                
                                ]
                                );
                        }else{

                            $data_arr = DB::table('tbl_attribute_options')->where('id', $attr_code)->first();
                   
                            //$data_arrData = DB::table('tbl_attributes')->where('attribute_code', $attr_codeName)->first();
        
                            DB::table('tbl_items_attributes_data')->updateOrInsert(
                                ['item_id' => $txtItemID, 'item_attr_value' => $data_arr->attribute_option_name],
                                [
                                    'item_cat_id' => $selectProductCatID,
                                    'item_attr_id' => $data_arr->attribute_id,
                                    'item_attr_code' => $attr_codeName,
                                    'item_attr_admin_label' => $data_arrData->admin_name_lable,
                                    'created_by' =>Auth::user()->id,
                                    'created_on' => date('Y-m-d H:i:s'),
                
                                ]
                            );

                        }
                       
    
    
                    }
               

                    
           
        }
    }


        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }

    public function saveChangesProductAttribueA(Request $request)
    {
        $txtItemID = $request->txtItemID;
        $attribute = $request->attribute;
        $is_required = $request->is_required;
        $is_unique = $request->is_unique;
        $is_comparable = $request->is_comparable;

        foreach ($attribute as $key => $row) {
            $attrID = $attribute[$key];
            $is_requiredVal = $is_required[$key];
            $is_uniqueVal = $is_unique[$key];
            $is_comparableVal = $is_comparable[$key];
            DB::table('tbl_items_attributes_data')->updateOrInsert(
                ['item_id' => $txtItemID, 'item_attr_id' => $attrID],
                [
                    'item_id' => $txtItemID,
                    'item_attr_id' => $attrID,
                    'is_required' => $is_requiredVal,
                    'is_unique' => $is_uniqueVal,
                    'is_compareable' => $is_comparableVal,

                ]
            );
        }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Save changes successfuly'

        ));
    }
    //saveChangesProductAttribue

    public function saveGroupAttribute(Request $request)
    {

        foreach ($request->UnderGroupAttrSelected as $key => $row) {

            DB::table('tbl_group_attribute')->insert(
                [
                    'g_id' => $request->UnderGroupAttr,
                    'attr_id' => $row
                ]
            );
        }
    }

    public function saveAttributeValue(Request $request)
    {

        $attribute = DB::table('tbl_attribute')->find($request->attribute_id);
        DB::table($attribute->table_name)->updateOrInsert(
            [
                'attr_name' => ucwords($request->attr_name),

            ]
        );
    }

    public function getTreeView(Request $request)
    {
        $dataObjArr = DB::table('tbl_group')->get();
        $folders_arr = array();
        foreach ($dataObjArr as $key => $rowData) {
            $parentid = $rowData->grp_id;
            if ($parentid == '0') $parentid = "#";
            $selected = false;
            $opened = false;
            if ($rowData->g_id == 2) {
                $selected = true;
                $opened = true;
            }
            $folders_arr[] = array(
                "id" => $rowData->g_id,
                "parent" => $parentid,
                "text" => $rowData->g_name,
                "state" => array("selected" => $selected, "opened" => $opened)
            );
        }
        return json_encode($folders_arr);
    }

    public function getTreeViewFrEdit(Request $request)
    {
        $item = DB::table('tbl_item_groups')->where('item_id', $request->itemId)->get();

        $item = json_decode(json_encode($item), true);
        //echo $item['group_id'];exit;
        $dataObjArr = DB::table('tbl_group')->get();
        $folders_arr = array();

        foreach ($dataObjArr as $key => $rowData) {
            $parentid = $rowData->grp_id;
            if ($parentid == '0') $parentid = "#";
            $selected = false;
            $opened = false;
            if (count($item) > 0) {
                for ($n = 0; $n < count($item); $n++) {
                    if ($rowData->g_id == $item[$n]['g_id']) {
                        $selected = true;
                        $opened = true;
                    }
                }
            }

            $folders_arr[] = array(
                "id" => $rowData->g_id,
                "parent" => $parentid,
                "text" => $rowData->g_name,
                "state" => array("selected" => $selected, "opened" => $opened)
            );
        }
        return json_encode($folders_arr);
    }

    public function saveMasterGroup(Request $request)
    {
        switch ($request->action) {
            case 1:
                if ($request->primaryGroup == 1) {
                    $grouplavel = DB::table('tbl_group')->where('g_id', $request->UnderGroup)->first();
                    DB::table('tbl_group')->insert(
                        [
                            'g_name' => $request->group_name,
                            'g_details' => $request->alias_name,
                            'grp_id' => $request->UnderGroup,
                            'g_lavel' =>  intVal($grouplavel->g_lavel + 1),
                            'type_id' => 1, //inventry
                            'alias' => $request->alias_name,
                            'created_by' => Auth::user()->id,

                        ]
                    );
                } else {
                    DB::table('tbl_group')->insert(
                        [
                            'g_name' => $request->group_name,
                            'g_details' => $request->alias_name,
                            'grp_id' => 0,
                            'g_lavel' => 0,
                            'type_id' => 1, //inventry
                            'alias' => $request->alias_name,
                            'created_by' => Auth::user()->id,

                        ]
                    );
                }



                break;
        }
    }

    public function updateMasterGroup(Request $request)
    {
        switch ($request->action) {
            case 1:
                if ($request->primaryGroup == 1) {
                    $grouplavel = DB::table('tbl_group')->where('g_id', $request->group_id)->first();
                    DB::table('tbl_group')->where('g_id', $request->group_id)->update(
                        [
                            'g_name' => $request->group_name,
                            'g_details' => $request->alias_name,
                            'grp_id' => $request->UnderGroup,
                            'g_lavel' =>  intVal($grouplavel->g_lavel + 1),
                            'type_id' => 1, //inventry
                            'alias' => $request->alias_name,
                            'created_by' => Auth::user()->id,

                        ]
                    );
                } else {
                    DB::table('tbl_group')->where('g_id', $request->group_id)->update(
                        [
                            'g_name' => $request->group_name,
                            'g_details' => $request->alias_name,
                            'grp_id' => 0,
                            'g_lavel' => 0,
                            'type_id' => 1, //inventry
                            'alias' => $request->alias_name,
                            'created_by' => Auth::user()->id,

                        ]
                    );
                }



                break;
        }
    }

    public function saveCustomerApproval(Request $request)
    {
        //pr($request->all());
        $this->validate($request, [
            // 'f_name' => 'required|string|max:120',
            // 'l_name' => 'required|string|max:120',
            'email' => 'required|string|max:50',
            //'gender' => 'required',
            //'dob' => 'max:15',
            //'mobile' => 'required|integer|digits:10',
            'mobile' => 'required|digits:10',
            
            // 'street_address' => 'required|string',
             'store_name' => 'required',
            // 'country' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'postal_code' => 'required|integer',

        ], [
            // 'f_name.required' => 'First name is required.',
            // 'f_name.string' => 'First name should be string.',
            // 'f_name.max' => 'First name should not be grater than 120 Character.',

            'mobile.required' => 'Phone name is required.',
            'mobile.integer' => 'Phone number should be number.',
            'mobile.digit' => 'Phone should not be grater than 10 Character.',

            // 'l_name.required' => 'Last name is required.',
            // 'l_name.string' => 'Last name should be string.',
            // 'l_name.max' => 'Last name should not be grater than 120 Character.',
            //'dob.max' => 'Date of birth should not be grater than 15 Character.',

            //'gender.required' => 'Gender is required.',
            'email.required' => 'Email is required.',
            'email.string' => 'Email should be string.',
            'email.max' => 'Email should not be grater than 50 Character.',

            // 'street_address.required' => 'Street adrress is required.',
            // 'street_address.string' => 'Street adrress should be string.',

            // 'postal_code.required' => 'Postal code is required.',
            // 'postal_code.integer' => 'Postal code should be number.',
            // 'country.required' => 'Country is required.',
            // 'state.required' => 'State is required.',
            // 'city.required' => 'City is required.',

        ]);
        $query = 0;
        $status = 'Pending';
        $remark = '';
        $profile = 0;
        if ($request->status == 1) {
            $status = 'Approved';
            $profile = 1;
        }
        if ($request->status == 2) {
            $status = 'Rejected';
            $profile = 0;
            $remark = $request->remark;
        }

        $customerData = DB::table('tbl_customers')->updateOrInsert(
            [
                'user_id' => $request->customer_id,
            ],
            [
                'cutomer_fname' => $request->cutomer_fname,
                'cutomer_lname' => $request->cutomer_lname,
                'email' => $request->email,
                //'gender' => $request->gender,
                //'dob' => $request->dob,
                'phone' => $request->mobile,
                'status' => $request->status,
                'remark' => $remark,
                'customer_type' => $request->customer_type,
                'cutomer_state' => $request->business_state,

            ]
        );

        if ($customerData) {
            $query = 1;
        }

        $customer = DB::table('tbl_customers')->where('user_id', $request->customer_id)->first();

        $businessData = DB::table('tbl_businesses')->updateOrInsert(
            [
                'busines_user_id' => $request->customer_id,
                'customer_id' => $customer->id,
            ],
            [
                'store_name' => $request->store_name,
                    
                'business_street_address' => $request->business_street_address,
                'business_gst_number' => $request->business_gst_number,
                'business_country' => $request->business_country,
                'business_state' => $request->business_state,
                'business_city' => $request->business_city,
                'business_postal_code' => $request->business_postal_code,
               
              
                //'parent_code' => $request->parent_code,
            ]
        );

        if ($businessData) {
            $query = 1;
        }



        // $addressData = DB::table('tbl_addresses')->updateOrInsert(
        //     [
        //         'customer_id' => $customer->id,
        //         'id' => $request->address_id,
        //         'check_page' => 0,
        //     ],
        //     [
        //         'f_name' => $request->f_name,
        //         'l_name' => $request->l_name,
        //         'customer_id' => $customer->id,
        //         'address_user_id' => $request->customer_id,
        //         //'company_name' => $request->company_name,
        //         'street_address' => $request->street_address,
        //         'gst_number' => $request->gst_number,
        //         'country' => $request->country,
        //         'state' => $request->state,
        //         'city' => $request->city,
        //         'postal_code' => $request->postal_code,

        //     ]
        // );

        // if ($addressData) {

        //     $query = 1;
        // }



        if ($query == 1) {

            $user = User::find($customer->user_id);
            $user->profile = $profile;
            $user->mobile = $request->mobile;
            $user->email = $request->email;
            $user->save();

            if ($request->status == 1) {

                Mail::to($request->email)->send(new CustomerApproveMail($request->all()));
                return Response::json(array('status' => 'success', 'msg' => 'Customer ' . $status, 'url' => route('customerListLayout')));
            }
            if ($request->status == 2) {

                Mail::to($request->email)->send(new CustomerRejectedMail($request->all()));
                return Response::json(array('status' => 'success', 'msg' => 'Customer ' . $status, 'url' => route('customerListLayout')));
            }
            return Response::json(array('status' => 'success', 'msg' => 'Customer ' . $status, 'url' => route('customerListLayout')));
        } else {
            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editCustomerLayout', $request->customer_id)));
        }


    }

    public function bannerDeactive(Request $request)
    {

        $bannerDeleted = DB::table('tbl_banners')->where('id', $request->bannerId)
            ->update(['status' => 0]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Banner Deactive successfull.', 'url' => route('bannerListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function activeClass(Request $request)
    {

        $bannerDeleted = DB::table('tbl_customer_classes')->where('id', $request->id)
            ->update(['status' => 1]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Active successfull.', 'url' => route('customerClass')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function deactiveClass(Request $request)
    {

        $bannerDeleted = DB::table('tbl_customer_classes')->where('id', $request->id)
            ->update(['status' => 0]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Deactiva successfull.', 'url' => route('customerClass')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function deactiveCustomerCategory(Request $request)
    {

        $bannerDeleted = DB::table('tbl_customer_categories')->where('id', $request->id)
            ->update(['status' => 0]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Deactiva successfull.', 'url' => route('customerCategories')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function activeCustomerCategory(Request $request)
    {

        $bannerDeleted = DB::table('tbl_customer_categories')->where('id', $request->id)
            ->update(['status' => 1]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Active successfull.', 'url' => route('customerCategories')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function activeHsn(Request $request)
    {

        $bannerDeleted = DB::table('tbl_hsn')->where('id', $request->hsnId)
            ->update(['status' => 1]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'HSN Activate successfull.', 'url' => route('hsnMaster')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function deactiveHsn(Request $request)
    {

        $bannerDeleted = DB::table('tbl_hsn')->where('id', $request->hsnId)
            ->update(['status' => 0]);

        if ($bannerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'HSN Deactive successfull.', 'url' => route('hsnMaster')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function bannerActive(Request $request)
    {

        $bannerActive = DB::table('tbl_banners')->where('id', $request->bannerId)
            ->update(['status' => 1]);

        if ($bannerActive) {

            return Response::json(array('status' => 'success', 'msg' => 'Banner Active successfull.', 'url' => route('bannerListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function deleteMasterGroup(Request $request)
    {

        $delGroup = DB::table('tbl_group')->where('g_id', $request->group_id)
        ->where('is_used', 0)
            ->delete();

        if ($delGroup) {

            return Response::json(array('status' => 1, 'msg' => 'Group deleted successfull.', 'url' => route('masterSettingsLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function editMasterGroup(Request $request)
    {

        $gorupForEdit = DB::table('tbl_group')->where('g_id', $request->group_id)
                    ->first();

            $dataObjArr = getUnderGroup();
           
            $optionData ='';
            foreach ($dataObjArr as $rowData){
                if($rowData->g_id != $request->group_id){
                    $optionData .= '<option value="'.$rowData->g_id.'">'.$rowData->g_name.'</option>';

                }
            }
           
                    $groupEditHtml = '
                    <div class="col-md-4 col-sm-8">

                        <div class="form-group row m-b-15">
                            <label class="col-form-label col-md-12 col-sm-4">Group</label>
                            <div class="col-md-12 col-sm-8">
                                <input type="text" name="group_name" id="edit_group_name" value="'.$gorupForEdit->g_name.'" class="form-control m-b-5" placeholder="Enter group" />
                                <input type="hidden" name="group_id" id="group_id" value="'.$request->group_id.'" class="form-control m-b-5" placeholder="Enter group" />

                            </div>
                        </div>
                        
                        <div class="form-group row m-b-15">
                            <label class="col-form-label col-md-12 col-sm-4">Under Group</label>
                            <div class="col-md-12 col-sm-8">
                                <select class="form-control mb-3" id="Edit_UnderGroup" disabled>
                                   '.$optionData.'
                                </select>
                            </div>
                        </div>
                        

                        
                    </div>

                    <div class="col-md-4 col-sm-8">
                        <div class="form-group row m-b-15">
                            <label class="col-md-12 col-sm-4 col-form-label">Alias</label>
                            <div class="col-md-12 col-sm-8">
                                <input type="text" name="alias_name" id="edit_alias_name" value="'.$gorupForEdit->alias.'" class="form-control m-b-5" placeholder="Enter Alias" />

                            </div>
                        </div>
                        
                    </div>

                    <div class="col-md-4 col-sm-8">

                        <div class="form-group row m-b-15">
                            <label class="col-md-12 col-sm-4 col-form-label">Primay Group (Y/N)</label>
                            <div class="col-md-12 col-sm-8">
                                <select class="form-control mb-3 primaryGroup" id="primaryGroup_edit">
                                    <option selected="selected" value="0">NO</option>
                                    <option value="1">YES</option>

                                </select>
                            </div>
                        </div>
                        
                        </div>';

        if ($gorupForEdit) {

            return Response::json(array('status' => 1, 'msg' => 'Group deleted successfull.', 'groupEditHtml' => $groupEditHtml));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function itemActive(Request $request)
    {

        $bannerActive = DB::table('tbl_items')->where('item_id', $request->itemId)
            ->update(['is_visible' => 1]);

        if ($bannerActive) {

            return Response::json(array('status' => 'success', 'msg' => 'Item Active successfull.', 'url' => route('itemListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function itemDeactive(Request $request)
    {

        $bannerActive = DB::table('tbl_items')->where('item_id', $request->itemId)
            ->update(['is_visible' => 0]);

        if ($bannerActive) {

            return Response::json(array('status' => 'success', 'msg' => 'Item Deactive successfull.', 'url' => route('itemListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }
    
    public function customerDeactive(Request $request)
    {

        $customerDeleted = DB::table('tbl_customers')->where('id', $request->customerId)
            ->update(['deleted_at' => 0]);

        if ($customerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Customer deleted successfull.', 'url' => route('customerListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }
    }

    public function sellerDeactive(Request $request)
    {

        $customerDeleted = DB::table('tbl_sellers')->where('id', $request->customerId)
            ->update(['status' => 0]);

        if ($customerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Sales person deleted successfull.', 'url' => route('salesPersions')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function sellerActive(Request $request)
    {

        $customerDeleted = DB::table('tbl_sellers')->where('id', $request->customerId)
            ->update(['status' => 1]);

        if ($customerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Sales person is active successfull.', 'url' => route('salesPersions')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    public function customerActive(Request $request)
    {

        $customerDeleted = DB::table('tbl_customers')->where('id', $request->customerId)
            ->update(['deleted_at' => 1]);

        if ($customerDeleted) {

            return Response::json(array('status' => 'success', 'msg' => 'Customer active successfull.', 'url' => route('customerListLayout')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again'));
        }


    }

    

    public function statesByCountry(Request $request)
    {
        $states = statesByCountry($request->country);
        $states_option = '';

        foreach ($states as $state) {

            $states_option .= '<option value="' . $state->id . '">' . $state->name . '</option>';
        }

        return $states_option;


    }

    public function cityByState(Request $request)
    {

        $cityes = cityesByState($request->state_id);
        $citye_option = '';

        foreach ($cityes as $citye) {

            $citye_option .= '<option value="' . $citye->id . '">' . $citye->name . '</option>';
        }

        return $citye_option;


    }

    public function salesPersions()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $dataObjArr = DB::table('tbl_sellers')->get();
        return $theme->scope('admin.sales.sales_list', compact('dataObjArr'))->render();
    
    
    }

    public function editSalesPersionLayout($seller_id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $seller = DB::table('tbl_sellers')->where('id', $seller_id)->first();
        $sellerTpes = SellerType::get();
        return $theme->scope('admin.sales.sales_edit', compact('seller','sellerTpes'))->render();
    
    
    }

    public function addSlaesPersionLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $sellerTpes = SellerType::get();
       
        return $theme->scope('admin.sales.sales_add', compact('sellerTpes'))->render();
    
    
    }

    public function addSlaesPersion(Request $request)
    {
        $this->validate($request, [
            'seller_name' => 'required|max:190',
            'seller_email' => 'required|unique:tbl_sellers|max:100',
            'seller_type' => 'required',
            'seller_phone' => 'required',
        ], [
            'seller_name.required' => 'Namer is required.',
            'seller_phone.required' => 'Mobile number is required.',
            'seller_email.required' => 'Email is required.',
            'seller_type.required' => 'Sales type is required.',
            
        ]);
        $password = randomPassword();
        $request['seller_password'] = $password;
        $request['salesLoginUrl'] = route('salesLoginLayout');

            $user = new User;
            $user->user_type = 2;
            $user->name = $request->seller_name;
            $user->email = $request->seller_email;
            $user->mobile = $request->seller_phone;
            $user->password =  Hash::make($password);
            

        
           
        if ($user->save()) {
            
            $sellerData = DB::table('tbl_sellers')->insertGetId([
                'user_id' => $user->id,
                'seller_type_id' => $request->seller_type,
                'user_type' => 2,
                'seller_name' => $request->seller_name,
                'seller_email' => $request->seller_email,
                'seller_phone' => $request->seller_phone,
                //'seller_password' => Hash::make($password),
                'seller_password' => $password,
                
    
            ]);

            Mail::to($request->seller_email)->send(new SalesPersonSendPassword($request->all()));
            return Response::json(array('status' => 'success', 'msg' => 'Sales persion save successfully.', 'url' => route('salesPersions')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('addSlaesPersionLayout')));
        }
    
    
    }

    public function UpdateSalesPersion(Request $request)
    {
        $this->validate($request, [
            'seller_name' => 'required|max:190',
            'seller_email' => 'required|max:100',
            'seller_type' => 'required',
            'seller_phone' => 'required',
        ], [
            'seller_name.required' => 'Namer is required.',
            'seller_phone.required' => 'Mobile number is required.',
            'seller_email.required' => 'Email is required.',
            'seller_type.required' => 'Sales type is required.',
            
        ]);
       

        $user =  User::find($request->user_id);
            $user->user_type = 2;
            $user->name = $request->seller_name;
            $user->email = $request->seller_email;
            $user->mobile = $request->seller_phone;
            
            
        if ($user->save()) {
            
            $sellerData = DB::table('tbl_sellers')->where('id', $request->seller_id)
                ->where('user_id', $request->user_id)
                ->update([
                'user_id' => $user->id,
                'user_type' => 2,
                'seller_type_id' => $request->seller_type,
                'seller_name' => $request->seller_name,
                'seller_email' => $request->seller_email,
                'seller_phone' => $request->seller_phone,
                //'seller_password' => Hash::make($password),
                
                
    
            ]);

            return Response::json(array('status' => 'success', 'msg' => 'Sales persion updated successfully.', 'url' => route('salesPersions')));
        } else {

            return Response::json(array('status' => 'warning', 'msg' => 'Something is wrong try again', 'url' => route('editSalesPersionLayout', $request->seller_id)));
        }
    
    
    }

    public function itemRating(Request $request)
    {
        
       pr($request->all());

        
    
    
    }

    public function orderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function pendingOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 0)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function approvedOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 1)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function packagingOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 2)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function shippingOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 3)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        //$itemOrders = json_decode(json_encode($itemOrders), true), 'item_order_id');
        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function returnOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 7)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function cancelOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 6)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function holdOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 5)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function deliveredOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        ->where('stage', 4)
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function editOrderStageAdmin($orderId)
    {
       
        $itemOrders = DB::table('tbl_item_orders')->where('order_id', $orderId)->get();
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.edit_order_admin', compact('itemOrders'))->render();

    }

    public function updateOrderStageAdmin(Request $request)
    {
       $updateOrder = DB::table('tbl_item_orders')->where('order_id',  $request->itemOrderId)->update([
            'stage' => $request->stage
        ]);

       
        $itemOrders = DB::table('tbl_item_orders')->get();
    
        $theme = Theme::uses('backend')->layout('layout');
        return Redirect::back();
        

        
        
    }

    public function updateOrderStageAdminByItem(Request $request)
    {
       $updateOrder = DB::table('tbl_item_orders')->where('id',  $request->itemOrderId)->update([
            'stage' => $request->stage
        ]);

       
        $itemOrders = DB::table('tbl_item_orders')->get();
    
        $theme = Theme::uses('backend')->layout('layout');
        return Redirect::back();
        

        
        
    }

    public function updateCustomerDiscount(Request $request)
    {
        $updateOrder = DB::table('tbl_customers')->where('id',  $request->customerId)->update([
            'customer_cat_discount' => $request->customer_cat_discount,
            'customer_class_discount' => $request->customer_class_discount,
        ]);

       $itemOrders = DB::table('tbl_item_orders')->get();
    
        $theme = Theme::uses('backend')->layout('layout');
        return Redirect::back();
        

        
    }

    

    public function hello(Request $request)
    {
        
        echo "ttttttt";exit;
    }
    public function editClassDiscount(Request $request)
    {
        
       
        $discountData = DB::table('tbl_customer_class_discount')->where('id', $request->classDiscountId)->first();
            $disountClassHtmlEdit = '';
            

           
            $itemCategories = DB::table('tbl_item_category')->get();
            $itemCat = '';
            $catSelected = '';
            foreach($itemCategories as $itemCategorie)
            {
                if($itemCategorie->id == $discountData->item_cat){
                    $catSelected = 'selected';
                }else{
                    $catSelected = '';
                }
       
                $itemCat .= '<option value="'.$itemCategorie->id.'" '.$catSelected.'>'.$itemCategorie->item_name.'</option>';

       
            }

            $customerTypes = [1 => 'Dealer', 2 => 'Wholesaller', 3 => 'Distibuter'];
            $customerTypesOption = '';
            $customerTypeSelected = '';
            foreach($customerTypes as $customerTypeKey => $customerType)
            {
                if($customerTypeKey == $discountData->customer_type){
                    $customerTypeSelected = 'selected';
                }else{
                    $customerTypeSelected = '';
                }

                $customerTypesOption .= '<option value="'.$customerTypeKey.'" '.$customerTypeSelected.'>'.$customerType.'</option>';
            }

            //$customerClasses = ['DL' => 'DL', 'UP' => 'UP'];
            $customerClasses = get_customer_classes();
            $customerClassesOption = '';
            $customerClassesSelected = '';
            
            foreach($customerClasses as $customerClasseKey => $customerClasse)
            {
               
                if($customerClasse->id == $discountData->customer_class){
                    $customerClassesSelected = 'selected';
                }else{
                    $customerClassesSelected = '';
                }

                $customerClassesOption .= '<option value="'.$customerClasse->id.'" '.$customerClassesSelected.'>'.$customerClasse->cust_class_name.'</option>';
            }

            
                $category = get_group_category_cat_id($discountData->item_cat);
                
                $disountClassHtmlEdit .= '<form action="'.route('updateClassDiscount').'" method="post" class="" id="updateClassDiscount">
                       <input type="hidden" name="classDiscountId" value="'.$request->classDiscountId.'">
                  
                       <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer type</label>
                           <select  name="customer_type" id="customer_type" class="form-control">
                           <option value="">Select customer type</option>
                           '.$customerTypesOption.'
                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Customer class</label>
                            <select  name="customer_class" id="customer_class" class="form-control">
                            <option value="">Select Customer class</option>
                                '.$customerClassesOption.'
                            
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Item category</label>
                           <select  name="item_cat" id="item_cat" class="form-control">
                                <option value="">Select item category</option>
                                '.$itemCat.'

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Discount(%)</label>
                            <input type="text" class="form-control" name="discount_percentage" value="'.$discountData->discount_percentage.'">
                        
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Applicable from</label>
                            <input type="text" class="form-control date" name="applicable_from" value="'.date("d-m-Y", strtotime($discountData->applicable_from)).'" id="applicable_from">
                        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Expired on</label>
                            <input type="text"  class="form-control date" name="expired_on" value="'.date("d-m-Y", strtotime($discountData->expired_on)).'" id="expired_on">
                        
                        </div>
                    </div>
                    
                    
                </div>


                <fieldset style="margin-top:35px;">
                    <input type="button" onclick="updateClassDiscountBtn()" value="UPDATE" class="btn btn-sm btn-primary m-r-5 " />

                </fieldset>
                

                
            </form>';
            
            //pr($disountClassHtmlEdit);
        return Response::json(array(
            'status' => 1,
            'disountClassHtmlEdit' => html_entity_decode($disountClassHtmlEdit)

        ));
        

        
    }

    public function editCategoryDiscount(Request $request)
    {
        
        
        $discountData = DB::table('tbl_customer_category_discount')->where('id', $request->categoryDiscountId)->first();
            $disountClassHtmlEdit = '';
            

           
            $itemCategories = DB::table('tbl_item_category')->get();
            $itemCat = '';
            $catSelected = '';
            foreach($itemCategories as $itemCategorie)
            {
                if($itemCategorie->id == $discountData->item_cat){
                    $catSelected = 'selected';
                }else{
                    $catSelected = '';
                }
       
                $itemCat .= '<option value="'.$itemCategorie->id.'" '.$catSelected.'>'.$itemCategorie->item_name.'</option>';

       
            }

            // $customerTypes = ['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'];
            // $customerTypesOption = '';
            // $customerTypeSelected = '';
            // foreach($customerTypes as $customerTypeKey => $customerType)
            // {
            //     if($customerTypeKey == $discountData->customer_type){
            //         $customerTypeSelected = 'selected';
            //     }else{
            //         $customerTypeSelected = '';
            //     }

            //     $customerTypesOption .= '<option value="'.$customerTypeKey.'" '.$customerTypeSelected.'>'.$customerType.'</option>';
            // }

            $customerClasses = getCustomerCategoryList();
            $customerClassesOption = '';
            $customerClassesSelected = '';
            
            foreach($customerClasses as $customerClasse)
            {
                if($customerClasse->id == $discountData->cat_class){
                    $customerClassesSelected = 'selected';
                }else{
                    $customerClassesSelected = '';
                }

                $customerClassesOption .= '<option value="'.$customerClasse->id.'" '.$customerClassesSelected.'>'.$customerClasse->cust_category_name.'</option>';
            }

            
                $category = get_group_category_cat_id($discountData->item_cat);
                
                $disountClassHtmlEdit .= '<form action="'.route('updateCategoryDiscount').'" method="post" class="" id="updateCategoryDiscount">
                       <input type="hidden" name="categoryDiscountId" value="'.$request->categoryDiscountId.'">
                  
                       <div class="row">
                   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Customer class</label>
                            <select  name="cat_class" id="cat_class" class="form-control">
                            <option value="">Select Customer class</option>
                                '.$customerClassesOption.'
                            
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Item category</label>
                           <select  name="item_cat" id="item_cat" class="form-control">
                                <option value="">Select item category</option>
                                '.$itemCat.'

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Discount(%)</label>
                            <input type="text" class="form-control" name="discount_percentage" value="'.$discountData->discount_percentage.'">
                        
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Applicable from</label>
                            <input type="text" class="form-control date" name="applicable_from" value="'.date("d-m-Y", strtotime($discountData->applicable_from)).'" id="applicable_from">
                        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Expired on</label>
                            <input type="text"  class="form-control date" name="expired_on" value="'.date("d-m-Y", strtotime($discountData->expired_on)).'" id="expired_on">
                        
                        </div>
                    </div>
                    
                    
                </div>


                <fieldset style="margin-top:35px;">
                    <input type="button" onclick="updateCategoryDiscountBtn()" value="UPDATE" class="btn btn-sm btn-primary m-r-5 " />

                </fieldset>
                

                
            </form>';
            
            //pr($disountClassHtmlEdit);
        return Response::json(array(
            'status' => 1,
            'disountClassHtmlEdit' => html_entity_decode($disountClassHtmlEdit)

        ));
        

        
    }

    public function discountLayout()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $discountClassDatas = DB::table('tbl_customer_class_discount')->get();
        $discountCategoryDatas = DB::table('tbl_customer_category_discount')->get();
        
        return $theme->scope('admin.discountPage', compact('discountCategoryDatas', 'discountClassDatas'))->render();
        

        
    }

    public function updateCategoryDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_category_discount')
            ->where('cat_class', $request->cat_class)
           ->where('item_cat', $request->item_cat)
           ->where('id', '!=', $request->categoryDiscountId)
          ->first();
            
            if($check){
                pr($check);
                return Response::json(array(
                    'status' => 0,
                    'msg' => 'This type discount already exist.',
                    'url' => route('discountLayout')
        
                ));
                
            }
       $discountDataSave = DB::table('tbl_customer_category_discount')->where('id', $request->categoryDiscountId)->update([
            //'customer_type' => $request->customer_type,
            'cat_class' => $request->cat_class,
            'discount_percentage' => $request->discount_percentage,
            'applicable_from' => date("d-m-Y", strtotime($request->applicable_from)),
            'expired_on' => date("d-m-Y", strtotime($request->expired_on)),
            'item_cat' => $request->item_cat,
            ]);
          
            $discountDatas = DB::table('tbl_customer_category_discount')->get();
            $disountHtml = '';
            foreach($discountDatas as $discountData){

                

                $category = get_group_category_cat_id($discountData->item_cat);
                @$customerCategory = getCustomerCategoryById(@$discountData->cat_class);
                $disountHtml .= '<tr>

                    <td>'.$discountData->id.'</td>
                    <td>'.@$customerCategory->cust_category_name.'</td>
                    
                    <td>'.$category.'</td>
                    <td>'.$discountData->discount_percentage.'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->applicable_from)).'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->expired_on)).'</td>
                   
                    <td>
                        <a class="btn btn-primary" id="'.$discountData->id.'" onclick="editCategoryDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                        
                    </td>
                
                </tr>';
            }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Update class discount successfuly',
            'appendDiscount' => $disountHtml

        ));


    }
    public function updateClassDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_class_discount')
            ->where('customer_type', $request->customer_type)
            ->where('customer_class', $request->customer_class)
            ->where('item_cat', $request->item_cat)
            ->where('id', '!=', $request->classDiscountId)
            ->first();
            
            if($check){
                //pr($check);
                return Response::json(array(
                    'status' => 0,
                    'msg' => 'This type discount already exist.',
                    'url' => route('discountLayout')
        
                ));
                
            }
       $discountDataSave = DB::table('tbl_customer_class_discount')->where('id', $request->classDiscountId)->update([
            'customer_type' => $request->customer_type,
            'customer_class' => $request->customer_class,
            'discount_percentage' => $request->discount_percentage,
            'applicable_from' => date("d-m-Y", strtotime($request->applicable_from)),
            'expired_on' => date("d-m-Y", strtotime($request->expired_on)),
            'item_cat' => $request->item_cat,
            ]);
          
            $discountDatas = DB::table('tbl_customer_class_discount')->get();
            $disountHtml = '';
            foreach($discountDatas as $discountData){

                if ($discountData->customer_type == 1) {
                    $customerType = 'Dealer';

                }else if ($discountData->customer_type == 2) {
                    $customerType = 'Wholesaller';

                }else{
                    $customerType = 'Distibuter';
                }

                $category = get_group_category_cat_id($discountData->item_cat);
                $customer_class = get_customer_class_by_id($discountData->customer_class);
               
                $disountHtml .= '<tr>

                    <td>'.$discountData->id.'</td>
                    <td>'. $customerType.'</td>
                    <td>'.$customer_class->cust_class_name.'</td>
                    <td>'.$category.'</td>
                    <td>'.$discountData->discount_percentage.'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->applicable_from)).'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->expired_on)).'</td>
                   
                    <td>
                        <a class="btn btn-primary" id="'.$discountData->id.'" onclick="editClassDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                        
                    </td>
                
                </tr>';
            }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Update class discount successfuly',
            'appendDiscount' => $disountHtml

        ));


    }

    public function saveClassDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_class_discount')
            ->where('customer_type', $request->customer_type)
            ->where('customer_class', $request->customer_class)
            ->where('item_cat', $request->item_cat)
            ->first();
            
            if($check){
                //pr($check);
                return Response::json(array(
                    'status' => 0,
                    'msg' => 'This type discount already exist.',
                    'url' => route('discountLayout')
        
                ));
                
            }
        $discountDataSave = DB::table('tbl_customer_class_discount')->insert([
            'customer_type' => $request->customer_type,
            'customer_class' => $request->customer_class,
            'discount_percentage' => $request->discount_percentage,
            'applicable_from' => date("d-m-Y", strtotime($request->applicable_from)),
            'expired_on' => date("d-m-Y", strtotime($request->expired_on)),
            'item_cat' => $request->item_cat,
            ]);
          
            $discountDatas = DB::table('tbl_customer_class_discount')->get();
            $disountHtml = '';
            foreach($discountDatas as $discountData){

                if ($discountData->customer_type == 1) {
                    $customerType = 'Dealer';

                }else if ($discountData->customer_type == 2) {
                    $customerType = 'Wholesaller';

                }else{
                    $customerType = 'Distibuter';
                }

                $category = get_group_category_cat_id($discountData->item_cat);
                $customer_class = get_customer_class_by_id($discountData->customer_class);
               
                $disountHtml .= '<tr>

                    <td>'.$discountData->id.'</td>
                    <td>'. $customerType.'</td>
                    <td>'.$customer_class->cust_class_name.'</td>
                    <td>'.$category.'</td>
                    <td>'.$discountData->discount_percentage.'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->applicable_from)).'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->expired_on)).'</td>
                   
                    <td>
                        <a class="btn btn-primary" id="'.$discountData->id.'" onclick="editClassDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                        
                    </td>
                
                </tr>';
            }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Save class discount successfuly',
            'appendDiscount' => $disountHtml

        ));


    }
    public function saveCategoryDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_category_discount')
            ->where('cat_class', $request->cat_class)
           ->where('item_cat', $request->item_cat)
          ->first();
            
            if($check){
                //pr($check);
                return Response::json(array(
                    'status' => 0,
                    'msg' => 'This type discount already exist.',
                    'url' => route('discountLayout')
        
                ));
                
            }
       $discountData = DB::table('tbl_customer_category_discount')->insert([
            
            'cat_class' => $request->cat_class,
            'discount_percentage' => $request->discount_percentage,
            'applicable_from' => date("d-m-Y", strtotime($request->applicable_from)),
            'expired_on' => date("d-m-Y", strtotime($request->expired_on)),
            'item_cat' => $request->item_cat,
            ]);
          
            

            $discountDatas = DB::table('tbl_customer_category_discount')->get();
            $disountHtml = '';
            foreach($discountDatas as $discountData){

                

                $category = get_group_category_cat_id($discountData->item_cat);
                @$customerCategory = getCustomerCategoryById(@$discountData->cat_class);
                $disountHtml .= '<tr>

                    <td>'.$discountData->id.'</td>
                    <td>'.@$customerCategory->cust_category_name.'</td>
                    <td>'.$category.'</td>
                    <td>'.$discountData->discount_percentage.'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->applicable_from)).'</td>
                    <td>'.date("d-m-Y", strtotime($discountData->expired_on)).'</td>
                   
                   <td>
                    <a class="btn btn-primary"  id="'.$discountData->id.'" onclick="editCategoryDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                    
                    </td>
                
                </tr>';
            }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Save category discount successfuly',
            'appendDiscount' => $disountHtml

        ));


    }

    public function hsnMaster()
    { //viewLayout
       
        $theme = Theme::uses('backend')->layout('layout');
        $hsnDatas = DB::table('tbl_hsn')->get();
         return $theme->scope('admin.hsnList', compact('hsnDatas'))->render();

    }

    

    public function saveHSN(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_hsn')->insert([
            'hsn_name' => $request->hsn_name,
            
        ]);

      return Redirect::back();

    }

    public function saveCustomerClass(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_customer_classes')->insert([
            'cust_class_name' => $request->cust_class_name,
            
        ]);

      return Redirect::back();

    }

    public function saveCustomerCategory(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_customer_categories')->insert([
            'cust_category_name' => $request->cust_category_name,
            
        ]);

      return Redirect::back();

    }

    public function updateCustomerClass(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_customer_classes')->where('id', $request->customerClassId)->update([
            'cust_class_name' => $request->cust_class_name,
            
        ]);

      return Redirect::back();

    }

    public function updateCustomerCategory(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_customer_categories')->where('id', $request->customerCategoryId)->update([
            'cust_category_name' => $request->cust_category_name,
            
        ]);

      return Redirect::back();

    }

    public function updateHsn(Request $request)
    { 
       
       $updateOrder = DB::table('tbl_hsn')->where('id', $request->hsnId)->update([
            'hsn_name' => $request->hsn_name,
            
        ]);

      return Redirect::back();

    }

    public function customerClass()
    { //viewLayout
       
        $theme = Theme::uses('backend')->layout('layout');
        $customerClassLists = DB::table('tbl_customer_classes')->get();
         return $theme->scope('admin.customerClassList', compact('customerClassLists'))->render();

    }

    public function customerCategories()
    { 
       
        $theme = Theme::uses('backend')->layout('layout');
        $customerCategories = DB::table('tbl_customer_categories')->get();
        return $theme->scope('admin.customer_category_list', compact('customerCategories'))->render();

    }

    public function adminOrderBackend(){

        $itemOrders = DB::table('tbl_payment_status')
        ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->orderBy('tbl_payment_status.id', 'desc')
        
        ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
       
        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.adminOrderTabPage', compact('itemOrders'))->render();
        
    }

    public function getAdminOrder(Request $request){
        if($request->stage != '10'){

            $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', $request->stage)
            ->get();
        
            
        }else{
            
            $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->get();
            
        }
        
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        
        //pr($itemOrders);

    //     if(count($itemOrders)>0){
    //         $html = '';
            
    //             $i=0;
    //             foreach($itemOrders as $itemOrder){
                    
    //                 $itemOrder = (object) $itemOrder;
    //                 $item = get_item_detail($itemOrder->item_id);
    //                 $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)->first();
    //                 $itemImages = get_item_default_img_item_id($itemOrder->item_id);

	// 				if($itemImages)
	// 				{

	// 					$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
	// 				} else {

	// 					$itemImg = FRONT.'img/product/product-iphone.png';
    //                 }

    //                 if(@$paymntStaus->status == 1)
    //                 {
    //                     $paymntStausVal ='<span class="badge badge-md badge-success">Success</span>';

    //                 }elseif(@$paymntStaus->status == 0){

    //                     $paymntStausVal ='<span class="badge badge-md badge-danger">Pending</span>';

                                    
    //                 }

    //                 if($itemOrder->stage == 1)
    //                 {
    //                     $stage = '<span class="badge badge-md badge-success">Processed</span>';

    //                 }elseif($itemOrder->stage == 0){

    //                     $stage = '<span class="badge badge-md badge-danger">Pending</span>';

    //                 }elseif($itemOrder->stage == 2){


    //                     $stage = '<span class="badge badge-md badge-danger">Packaging</span>';

                
    //                 }elseif($itemOrder->stage == 3){

    //                     $stage = '<span class="badge badge-md badge-danger">Shipping</span>';

                    
    //                 } elseif($itemOrder->stage == 4){

                    
    //                     $stage = '<span class="badge badge-md badge-danger">Delivered</span>';
                    
    //                 }elseif($itemOrder->stage == 5){

    //                     $stage = '<span class="badge badge-md badge-danger">Hold</span>';
                    
    //                 }elseif($itemOrder->stage == 6){

    //                     $stage = '<span class="badge badge-md badge-danger">Cancel</span>';

    //                 }else{
    //                     $stage = '<span class="badge badge-md badge-danger">Return</span>';
                
    //                 }

    //                 $itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();
                    
    //             $html .='<tr>
    //                         <td class="value">'.$itemOrder->order_id.'</td>
    //                         <td class="value">'.date("d-m-Y", strtoTime(@$paymntStaus->created_at)).'</td>
                          
    //                         <td class="value">'.$itemOrdersCount.'</td>
    //                         <td class="value">'.$itemOrder->total_amount.'</td>
    //                         <td class="value">'.$stage.'</td>
                            
    //                         <td class="value">'.$paymntStausVal.'</td>
    //                         <td>
	// 							<a href="'.route('viewOrderCustumerFront', $itemOrder->order_id).'" class="btn btn-primary"><i class="fas fa-lg fa-fw m-r-10 fa-eye"></i>View</a>
	// 						</td>
    //                     </tr>';
                           
    //             $i++;   
                
    //         }
               

    //         $data = array(
    //             'status' => 'success',
    //             'msg' => 'success',
    //             'orders' => $itemOrders,
    //             'ordeHtml' => $html,
                
    //         );
    //     }else{
    //         $data = array(
    //             'status' => 'fail',
    //             'msg' => 'Order not found.',
    //             'orders' => $itemOrders,
                
    //         );
    //     }
        
    // return($data);
    
    //$returnView = view('testMyCode')->with('itemOrders', $itemOrders)->render();
   
    
    $returnView = view('testMyCode',compact('itemOrders'))->render();

        return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    
        
    }
    
}
