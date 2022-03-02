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
use App\itemOrderProcess;
use Illuminate\Support\Str;
use App\ItemCategory;
use App\toBePackedScanItem;
use App\Mail\CustomerApproveMail;
use App\Mail\CustomerRejectedMail;
use App\Mail\SalesPersonSendPassword;
use App\CustomerCart;
use PDF;
use Illuminate\Validation\Rule;

use App\Mail\AfterOrderDispatchMailToCustomer;


use Illuminate\Support\Facades\Mail;
use Hash;
use Redirect;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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

    public function customerCartList(){

        $customerCartLists = CustomerCart::where('customer_id', Auth::user()->id)
        ->groupBy('customer_id')
        ->get();
        //$customerCartLists = unique_multidim_array(json_decode(json_encode($customerCartLists), true), 'customer_id');
        //pr($customerCartLists);
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.customerCartList', compact('customerCartLists'))->render();
        
    }

    public function customerCartListForAdmin(){

        $customerCartLists = CustomerCart::groupBy('customer_id')
        ->get();
        //$customerCartLists = unique_multidim_array(json_decode(json_encode($customerCartLists), true), 'customer_id');
        //pr($customerCartLists);
        $theme = Theme::uses('backend')->layout('layout');
       return $theme->scope('admin.customerCartListForAdmin', compact('customerCartLists'))->render();
        
    }
    //saveUserPermissioon
    public function saveUserPermission(Request $request)
    {
       
        $userID=$request->userID;

        DB::table('model_has_permissions')->where('model_id', '=', $userID)->delete();

        $userPermisson=$request->userPermisson;
        foreach ($userPermisson as $key => $row) {
           
                DB::table('model_has_permissions')
                ->updateOrInsert(
                    [
                        'permission_id' => $row,
                         'model_type' => 'App\User',
                         'model_id' => $userID
                    ],
                    [
                        'permission_id' => $row,
                        'model_type' => 'App\User',
                        'model_id' => $userID

                    ]
                );

        }
        return redirect()->back()->with('success', 'Permision Updated Update Successfully');   

    }
    //saveUserPermissioon

    public function index(Request $request)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $userArr = DB::table('users')
            ->get();
        $data['users'] = $userArr;

        return $theme->scope('users.index', $data)->render();
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
            
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $theme = Theme::uses('backend')->layout('layout');
        $userArr = DB::table('users')
            ->where('id',$id)
            ->first();
        $data['users'] = $userArr;

        return $theme->scope('users.edit', $data)->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }


    public function viewOrderAdmin($orderId)
    {


        $itemOrders = DB::table('tbl_item_orders')
            ->where('order_id', $orderId)
            ->get();

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.view_order_admin', compact('itemOrders'))->render();
    }

    public function getContactList()
    {
        $contacts = DB::table('contact_us')->get();
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.contact_us_list', compact('contacts'))->render();
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
    public function getAjaxSelectedAttributeValue_Old(Request $request)
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



    public function getAjaxSelectedAttributeValue(Request $request)
    {

        $selectAttrID = $request->selectAttrID;
        $catAttrChildArr = DB::table('tbl_attributes')->where('id', $selectAttrID)->first();

        switch ($catAttrChildArr->type) {
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
            'status' => ($request->status) ? $request->status : 0,
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
    //saveChangesProductDetails

    public function checkUniBarcode(Request $request)
    {
        $check = DB::table('tbl_items')->where('barcode', $request->barcode)->count();
        if ($check > 0) {
            return Response::json(array(
                'status' => 1,
                'msg' => 'Barcode already exist.'

            ));
        } else {
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

        $pendingCustomersData = DB::table('tbl_customers')->where('status', 0)->orderBy('created_at', 'DESC')->get();
        $approveCustomersData = DB::table('tbl_customers')->where('status', 1)->orderBy('created_at', 'DESC')->get();
        $rejectedCustomersData = DB::table('tbl_customers')->where('status', 2)->orderBy('created_at', 'DESC')->get();

        return $theme->scope('admin.customer_list', compact('dataObjArr', 'pendingCustomersData', 'approveCustomersData', 'rejectedCustomersData'))->render();
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
        echo "ccc";
        pr($request->all());
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


        return $theme->scope('admin.item_edit', compact('sku', 'attributeAndOptions', 'brands', 'item', 'itemImages', 'attrArr'))->render();
    }
    //saveChangesProductAttribue
    public function saveChangesProductAttribue_old(Request $request)
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

                    if ($data_arrData->type != 'select') {

                        DB::table('tbl_items_attributes_data')->updateOrInsert(
                            ['item_id' => $txtItemID, 'item_attr_code' => $attr_codeName],
                            [
                                'item_cat_id' => $selectProductCatID,
                                'item_attr_id' => $data_arrData->id,
                                //'item_attr_code' => $attr_codeName,
                                'item_attr_value' => $attr_code,
                                'item_attr_admin_label' => $data_arrData->admin_name_lable,
                                'created_by' => Auth::user()->id,
                                'created_on' => date('Y-m-d H:i:s'),

                            ]
                        );
                    } else {

                        $data_arr = DB::table('tbl_attribute_options')->where('id', $attr_code)->first();

                        //$data_arrData = DB::table('tbl_attributes')->where('attribute_code', $attr_codeName)->first();

                        DB::table('tbl_items_attributes_data')->updateOrInsert(
                            ['item_id' => $txtItemID, 'item_attr_value' => $data_arr->attribute_option_name],
                            [
                                'item_cat_id' => $selectProductCatID,
                                'item_attr_id' => $data_arr->attribute_id,
                                'item_attr_code' => $attr_codeName,
                                'item_attr_admin_label' => $data_arrData->admin_name_lable,
                                'created_by' => Auth::user()->id,
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

    public function saveChangesProductAttribue(Request $request)
    {
        //dd($request->all());

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

            if ($data_arrDataForText->type != 'select') {

                DB::table('tbl_items_attributes_data')->updateOrInsert(
                    ['item_id' => $txtItemID, 'item_attr_code' => $data_arrDataForText->attribute_code],
                    [
                        'item_cat_id' => $selectProductCatID,
                        'item_attr_id' => $request->productAttributeForText,

                        'item_attr_value' => $request->productAttribute_text,
                        'item_attr_admin_label' => $data_arrDataForText->admin_name_lable,
                        'created_by' => Auth::user()->id,
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
                    'created_by' => Auth::user()->id,
                    'created_on' => date('Y-m-d H:i:s'),

                ]
            );
        }

        //}

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
        @$customer = DB::table('tbl_customers')->where('user_id', $request->customer_id)->first();
        $this->validate($request, [
            'cutomer_fname' => 'required|string|max:120',
            'cutomer_lname' => 'required|string|max:120',
            // 'f_name' => 'required|string|max:120',
            // 'l_name' => 'required|string|max:120',
              'email' => 'required|string|max:50',
            // 'email' => 'required|string|max:50|unique:users,email,'.@$customer->user_id,
            // 'email' => 'required|string|max:50|unique:tbl_customers,email,'.@$customer->id,
            
            // 'email' => ['required', 'string', 'email', 'max:50',
            //                 Rule::unique('users')->ignore($customer->user_id),
            //             ],
            // 'email' => ['required', 'string', 'email', 'max:50',
            //                 Rule::unique('tbl_customers')->ignore($customer->id),
            //             ],
            //'gender' => 'required',
            //'dob' => 'max:15',
            'mobile' => 'required|integer|digits:10',
            //  'mobile' => 'required|digits:10|unique:users,mobile,'.@$customer->user_id,
            //  'mobile' => 'required|digits:10|unique:tbl_customers,phone,'.@$customer->id,
            // 'mobile' => ['required', 'digits:10', 'mobile',
            //                 Rule::unique('users')->ignore($customer->user_id),
            //             ],
            // 'mobile' => ['required', 'digits:10', 'phone',
            //                 Rule::unique('tbl_customers')->ignore($customer->id),
            //             ],

            // 'mobile' => 'required|digits:10',
            // 'street_address' => 'required|string',
            'business_street_address' => 'required',
            'business_country' => 'required',
            'store_name' => 'required',
            'customer_type' => 'required',
            'business_state' => 'required',
            'business_city' => 'required',

            'business_postal_code' => 'required|integer',
            'business_gst_number' => 'required',
            // 'gst_certificate' => 'required',
            // 'shop_establishment_license' => 'required',
            // 'msme_udyog_adhar' => 'required',
            // 'FSSAI_certificate' => 'required',
            // 'Trade_certificate' => 'required',

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
            //    'business_gst_number.regex' => 'GST number format is not valid.',
            //    'gst_certificate.required' => 'GST Certificate is required.',
            //    'shop_establishment_license.required' => 'Shop establishment license is required.',
            //    'msme_udyog_adhar.required' => 'MSME udyog adhar is required.',
            //    'FSSAI_certificate.required' => 'FSSAI certificate is required.',
            //    'Trade_certificate.required' => 'Trade certificate is required.',

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

                $msgSMS = 'Congratulations!
                Your Subhiksh id has been approved successfully.
                Click here for login:' . url('/customer/login') . '" 
                ';
                $sms = sendSms($request->mobile, html_entity_decode($msgSMS));
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

        $optionData = '';
        foreach ($dataObjArr as $rowData) {
            if ($rowData->g_id != $request->group_id) {
                $optionData .= '<option value="' . $rowData->g_id . '">' . $rowData->g_name . '</option>';
            }
        }

        $groupEditHtml = '
                    <div class="col-md-4 col-sm-8">

                        <div class="form-group row m-b-15">
                            <label class="col-form-label col-md-12 col-sm-4">Group</label>
                            <div class="col-md-12 col-sm-8">
                                <input type="text" name="group_name" id="edit_group_name" value="' . $gorupForEdit->g_name . '" class="form-control m-b-5" placeholder="Enter group" />
                                <input type="hidden" name="group_id" id="group_id" value="' . $request->group_id . '" class="form-control m-b-5" placeholder="Enter group" />

                            </div>
                        </div>
                        
                        <div class="form-group row m-b-15">
                            <label class="col-form-label col-md-12 col-sm-4">Under Group</label>
                            <div class="col-md-12 col-sm-8">
                                <select class="form-control mb-3" id="Edit_UnderGroup" disabled>
                                   ' . $optionData . '
                                </select>
                            </div>
                        </div>
                        

                        
                    </div>

                    <div class="col-md-4 col-sm-8">
                        <div class="form-group row m-b-15">
                            <label class="col-md-12 col-sm-4 col-form-label">Alias</label>
                            <div class="col-md-12 col-sm-8">
                                <input type="text" name="alias_name" id="edit_alias_name" value="' . $gorupForEdit->alias . '" class="form-control m-b-5" placeholder="Enter Alias" />

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
        return $theme->scope('admin.sales.sales_edit', compact('seller', 'sellerTpes'))->render();
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
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
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
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
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
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', 1)
            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.order_admin', compact('itemOrders'))->render();
    }

    public function toBePackedAdminOrder()
    {
        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('tbl_item_orders.stage', 1)
            ->where('tbl_item_orders.is_Inprocess', 0)
            ->orWhere('tbl_item_orders.is_Inprocess', 2)
            //->where('tbl_item_orders.is_packed', 0)
            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.to_be_packed_admin_order', compact('itemOrders'))->render();
    
    
    }

    public function getAllItemByOrderOnModel(Request $request)
    {
        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('tbl_item_orders.order_id', $request->itemOrderId)
            ->get();
        //$itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $returnView = view('getAllItemByOrderOnModel', compact('itemOrders'))->render();
        return response()->json(array('success' => true, 'ordeHtml' => $returnView));
    
    
    }

    public function getAllItemByCustomerCart(Request $request)
    {
        $customerCarts = DB::table('customer_carts')
            ->where('customer_id', $request->customerId)
            ->get();
            
        $returnView = view('getAllItemByCustomerCartForModel', compact('customerCarts'))->render();
        return response()->json(array('success' => true, 'ordeHtml' => $returnView));
    
    
    }

    // public function printLableAndSaveBox(Request $request)
    // {

    //     $itemPackedDetail = itemOrderProcess::where('order_number', $request->order_number)
    //                 ->where('customer_id', $request->customer_id)->first();


    //     $pdf = PDF::loadView('pdf.labelPdf', compact('itemPackedDetail'));
    //     $fileName =  'Lable.'. 'pdf' ;
    //     $pdf->save('gallery' . '/' . $fileName);
    //     $pdfFile = 'gallery/'.$fileName;
    //     return response()->download($pdfFile);

    // }

    public function printLableAndSaveBox(Request $request)
    {
        //echo get_unique_code();exit;
        //pr($request->all());

        if (empty($request->total)) {
            return Response::json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.'

            ));
        }

        $toBePackedScanItems = DB::table('to_be_packed_scan_items')
            ->where('order_number', $request->order_number)
            ->where('customer_id', $request->customer_id)
            ->where('is_packed', 0)
            ->get();
        $packing_no = get_unique_code();


        if (count($toBePackedScanItems) > 0) {
            foreach ($toBePackedScanItems as $toBePackedScanItem) {
                $itemOrderProcess = itemOrderProcess::Create([

                    'order_number'   => $request->order_number,
                    'order_item_id'   => $toBePackedScanItem->order_item_id,
                    'customer_id'   => $request->customer_id,
                    'item_id'   => $toBePackedScanItem->item_id,
                    'packing_no'   => $packing_no,

                    'small_box'   => $request->small_box,
                    'medium_box'   => $request->medium_box,
                    'large_box'   => $request->large_box,
                    'bori'   => $request->bori,

                    'other'   => $request->other,
                    'total'   => $request->total,
                    'qty'   => $toBePackedScanItem->quantity,
                    'exact_qty'   => $toBePackedScanItem->exact_qty,
                    'unit'   => $toBePackedScanItem->unit,
                    'pending_qty'   => $toBePackedScanItem->pending_qty,
                    'increase_qty'   => $toBePackedScanItem->increase_qty,
                ]);

                // $itemOrderProcess = itemOrderProcess::updateOrCreate([

                //     'order_number'   => $request->order_number,
                //     'order_item_id'   => $toBePackedScanItem->order_item_id,
                //     'customer_id'   => $request->customer_id,
                //     'item_id'   => $toBePackedScanItem->item_id,

                //     ],[

                //         'order_number'   => $request->order_number,
                //         'order_item_id'   => $toBePackedScanItem->order_item_id,
                //         'customer_id'   => $request->customer_id,
                //         'item_id'   => $toBePackedScanItem->item_id,
                //         'packing_no'   => $packing_no,

                //         'small_box'   => $request->small_box,
                //         'medium_box'   => $request->medium_box,
                //         'large_box'   => $request->large_box,
                //         'bori'   => $request->bori,

                //         'other'   => $request->other,
                //         'total'   => $request->total,
                //         'qty'   => $toBePackedScanItem->quantity,
                //         'exact_qty'   => $toBePackedScanItem->exact_qty,
                //         'unit'   => $toBePackedScanItem->unit,
                //         'pending_qty'   => $toBePackedScanItem->pending_qty,
                //         'increase_qty'   => $toBePackedScanItem->increase_qty,
                //     ]);



                if ($itemOrderProcess->save()) {

                    @$checkPackedOrder = DB::table('item_order_packing_details')->where('order_number', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        // ->select('item_order_packing_details.*', DB::raw('sum(item_order_packing_details.qty) as totalPackedQty'))
                        ->sum('item_order_packing_details.qty');
                    //echo "<pre>";print_r($checkPackedOrder);
                    //pr($checkPackedOrder);
                    if (@$checkPackedOrder == $toBePackedScanItem->exact_qty) {

                        DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                            ->where('customer_id', $request->customer_id)
                            ->where('item_id', $toBePackedScanItem->item_id)
                            ->update(['is_packed' => 1, 'stage' => 2, 'pending_qty' => 0, 'is_Inprocess' => 1, 'packing_no' => $packing_no]);
                    } else if (@$checkPackedOrder < $toBePackedScanItem->exact_qty) {
                        DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                            ->where('customer_id', $request->customer_id)
                            ->where('item_id', $toBePackedScanItem->item_id)
                            ->update(['is_packed' => 0, 'stage' => 2, 'is_Inprocess' => 2, 'packing_no' => $packing_no]);
                    } else {
                        DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                            ->where('customer_id', $request->customer_id)
                            ->where('item_id', $toBePackedScanItem->item_id)
                            ->update(['is_packed' => 0, 'stage' => ($toBePackedScanItem->pending_qty == 0) ? 2 : 1, 'packing_no' => '']);
                    }

                    // $checkActualOrder = DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                    // ->where('customer_id', $request->customer_id)
                    // ->where('item_id', $toBePackedScanItem->item_id)
                    // ->first();

                    // if($checkActualOrder->is_Inprocess == 2){

                    //     DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                    //     ->where('customer_id', $request->customer_id)
                    //     ->where('item_id', $toBePackedScanItem->item_id)
                    //     ->update(['is_packed'=> 0, 'packing_no'=> ""]);

                    // }else{
                    //     DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                    //     ->where('customer_id', $request->customer_id)
                    //     ->where('item_id', $toBePackedScanItem->item_id)
                    //     ->update(['is_packed'=> 1, 'packing_no'=> $packing_no ]);
                    // }

                    DB::table('to_be_packed_scan_items')->where('order_number', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        ->update(['is_packed' => 1, 'packing_no' => $packing_no]);
                } else {
                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        ->update(['is_packed' => 0]);

                    DB::table('to_be_packed_scan_items')->where('order_number', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        ->update(['is_packed' => 0]);
                }
            }

            $itemPackedDetail = itemOrderProcess::where('order_number', $request->order_number)
                ->where('customer_id', $request->customer_id)->first();


            $pdf = PDF::loadView('pdf.labelPdf', compact('itemPackedDetail'));
            $fileName =  time() . '.' . 'pdf';
            $pdf->save('gallery' . '/' . $fileName);
            $pdfFile = 'gallery/' . $fileName;
            // return response()->download($pdfFile);

            return Response::json(array(
                'status' => 1,
                'msg' => 'Item packed successfully.',
                'pdfFile' => $pdfFile,
                'dPdf' => $fileName

            ));
        } else {
            return Response::json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.'

            ));
        }
    }

    public function moveToshipingBtn(Request $request)
    {

        //pr($request->all());

        if (empty($request->total)) {
            return Response::json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.'

            ));
        }

        $toBePackedScanItems = DB::table('to_be_packed_scan_items')->where('order_number', $request->order_number)
            ->where('customer_id', $request->customer_id)->get();
        if (count($toBePackedScanItems) > 0) {
            foreach ($toBePackedScanItems as $toBePackedScanItem) {
                // $checkActualOrder = DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //     ->where('customer_id', $request->customer_id)
                //     ->where('item_id', $toBePackedScanItem->item_id)
                //     ->first();



                @$checkPackedOrder = DB::table('item_order_packing_details')->where('order_number', $request->order_number)
                    ->where('customer_id', $request->customer_id)
                    ->where('item_id', $toBePackedScanItem->item_id)
                    // ->select('item_order_packing_details.*', DB::raw('sum(item_order_packing_details.qty) as totalPackedQty'))
                    ->sum('item_order_packing_details.qty');


                // if(@$checkPackedOrder == $toBePackedScanItem->exact_qty){

                //     DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //     ->where('customer_id', $request->customer_id)
                //     ->where('item_id', $toBePackedScanItem->item_id)
                //     ->update(['is_packed'=> 1, 'stage'=> 2, 'pending_qty' => 0, 'is_Inprocess'=>1, 'packing_no'=> $packing_no]);

                // }else if(@$checkPackedOrder < $toBePackedScanItem->exact_qty){
                //     DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //     ->where('customer_id', $request->customer_id)
                //     ->where('item_id', $toBePackedScanItem->item_id)
                //     ->update(['is_packed'=> 0, 'stage'=> ($toBePackedScanItem->pending_qty == 0) ? 2:1, 'pending_qty' => 0, 'is_Inprocess'=>2, 'packing_no'=> $packing_no]);
                // }else{
                //     DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //     ->where('customer_id', $request->customer_id)
                //     ->where('item_id', $toBePackedScanItem->item_id)
                //     ->update(['is_packed'=> 0, 'stage'=> ($toBePackedScanItem->pending_qty == 0) ? 2:1, 'packing_no'=>'']);
                // }

                if (@$checkPackedOrder == $toBePackedScanItem->exact_qty) {

                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        ->update(['is_packed' => 1, 'stage' => 2, 'pending_qty' => 0, 'is_Inprocess' => 1]);
                } else if (@$checkPackedOrder < $toBePackedScanItem->exact_qty) {

                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        //->update(['is_packed'=> 0, 'stage'=> 2, 'is_Inprocess'=>2]);
                        ->update(['is_packed' => 0, 'stage' => ($toBePackedScanItem->pending_qty == 0) ? 2 : 1, 'is_Inprocess' => 2]);
                } else {
                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $toBePackedScanItem->item_id)
                        ->update(['is_packed' => 0, 'stage' => ($toBePackedScanItem->pending_qty == 0) ? 2 : 1]);
                }





                DB::table('item_order_packing_details')->where('order_number', $request->order_number)
                    ->where('customer_id', $request->customer_id)
                    ->where('item_id', $toBePackedScanItem->item_id)
                    ->where('packing_no', $toBePackedScanItem->packing_no)
                    ->update(['is_packed' => 1, 'packing_stage' => 2]);

                DB::table('to_be_packed_scan_items')->where('order_number', $request->order_number)
                    ->where('customer_id', $request->customer_id)
                    ->where('item_id', $toBePackedScanItem->item_id)
                    ->update(['is_packed' => 1]);
            }

            // $itemPackedDetail = itemOrderProcess::where('order_number', $request->order_number)
            // ->where('customer_id', $request->customer_id)->first();




            return Response::json(array(
                'status' => 1,
                'msg' => 'Item order move to shiping successfully.',
                'url' => route('packagingOrderAdmin')


            ));
        } else {
            return Response::json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.'

            ));
        }
    }

    public function toBePackedDetail($orderId)
    {
        $itemOrders = DB::table('tbl_item_orders')
            ->where('order_id', $orderId)
            ->get();
        //$itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.to_be_packed_detail', compact('itemOrders'))->render();
    }

    public function toBePackedProcess($orderId)
    {
        $itemOrders = DB::table('tbl_item_orders')
            ->where('order_id', $orderId)
            ->get();
        //$itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.to_be_packed_process', compact('itemOrders'))->render();
    }

    public function tobeShipedOrder($packingNo)
    {
        //echo $packingNo;exit;
        $itemOrders = DB::table('item_order_packing_details')
            ->where('packing_no', $packingNo)
            ->get();
        //$itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.to_be_shiped', compact('itemOrders'))->render();
    }

    public function transportMasters()
    {
        $transportMasters = DB::table('transport_master')->orderBy('id', 'desc')->get();
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.transportMastersList', compact('transportMasters'))->render();
    }

    public function transportSaveForm(Request $request)
    {
        $itemData = DB::table('transport_master')->insert([
            'transporter_name' => $request->transporter_name,
            'transporter_address' => $request->transporter_address,
            'contact_person_name' => $request->contact_person_name,
            'phone_no' => $request->phone_no,

        ]);

        return Response::json(array(
            'status' => 1,
            'msg' => 'Transport detail save successfully.'

        ));
    }

    public function transportUpdateForm(Request $request)
    {
        //pr($request->all());
        $itemData = DB::table('transport_master')->where('id', $request->transport_id)->update([
            'transporter_name' => $request->transporter_name,
            'transporter_address' => $request->transporter_address,
            'contact_person_name' => $request->contact_person_name,
            'phone_no' => $request->phone_no,

        ]);

        return Response::json(array(
            'status' => 1,
            'msg' => 'Transport detail updated successfully.'

        ));
    }

    public function packagingOrderAdmin()
    {
        // $itemOrders = DB::table('tbl_payment_status')
        // ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        // ->orderBy('tbl_payment_status.id', 'desc')
        // ->where('stage', 2)
        // ->get();

        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->join('item_order_packing_details', 'item_order_packing_details.order_number', '=', 'tbl_item_orders.order_id')
            ->orderBy('item_order_packing_details.id', 'desc')
            ->where('item_order_packing_details.is_packed', 1)
            //  ->where('item_order_packing_details.packing_stage', 2)
            ->select('item_order_packing_details.*', 'tbl_item_orders.order_id', 'tbl_item_orders.stage')
            ->get();
        //pr($itemOrders);
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.packed_order_admin', compact('itemOrders'))->render();
        //return $theme->scope('admin.order_admin', compact('itemOrders'))->render();

    }

    public function shippingOrderAdmin()
    {
        // $itemOrders = DB::table('tbl_payment_status')
        // ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        // ->orderBy('tbl_payment_status.id', 'desc')
        // ->where('stage', 3)
        // ->get();

        $itemOrders = DB::table('shipped_orders')->orderBy('id', 'desc')->get();

        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'shiping_no');
        //$itemOrders = json_decode(json_encode($itemOrders), true), 'item_order_id');
        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.shipped_order_admin', compact('itemOrders'))->render();
    }

    public function returnOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', 7)
            ->orWhere('shipped_orders.order_stage', 7)
            ->get();


        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.order_admin', compact('itemOrders'))->render();
    }

    public function cancelOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', 6)
            ->orWhere('shipped_orders.order_stage', 6)
            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.order_admin', compact('itemOrders'))->render();
    }

    public function holdOrderAdmin()
    {
        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->leftjoin('shipped_orders', 'shipped_orders.packing_no', '=', 'tbl_item_orders.packing_no')
            ->orderBy('tbl_payment_status.id', 'desc')
            ->where('stage', 5)
            ->orWhere('shipped_orders.order_stage', 5)
            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        //pr($itemOrders);

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.order_admin', compact('itemOrders'))->render();
    }

    public function deliveredOrderAdmin()
    {
        // $itemOrders = DB::table('tbl_payment_status')
        // ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        // ->orderBy('tbl_payment_status.id', 'desc')
        // ->where('stage', 4)
        // ->get();
        $itemOrders = DB::table('shipped_orders')
            //->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
            ->orderBy('shipped_orders.id', 'desc')
            ->where('order_stage', 4)
            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'shiping_no');

        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.delivered_order_admin', compact('itemOrders'))->render();
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

        if ($request->stage == 4) {
            $orderDetail = DB::table('tbl_item_orders')->where('order_id',  $request->itemOrderId)->first();
            $users = DB::table('tbl_customers')->where('user_id', $orderDetail->customer_id)->first();
            if ($users->phone) {
                $sms = sendSms(@$users->phone, "We thought you'd like to know that Subhiksh dispatched your item(s). Your order is on the way.");
            }
            if ($users->email) {
                Mail::to(@$users->email)->send(new AfterOrderDispatchMailToCustomer($orderDetail->order_id));
            }
        }
        $itemOrders = DB::table('tbl_item_orders')->get();

        $theme = Theme::uses('backend')->layout('layout');
        return Redirect::back();
    }

    public function updateOrderStageFromShiped(Request $request)
    {
        //pr($request->all());
        $updateOrder = DB::table('shipped_orders')
            ->where('order_number',  $request->itemOrderNumber)
            ->where('shiping_no',  $request->shipingNumber)
            ->where('packing_no',  $request->packingNumber)
            ->update([
                'order_stage' => $request->stage
            ]);

        $updateOrder = DB::table('tbl_item_orders')
            ->where('order_id',  $request->itemOrderNumber)
            //->where('shiping_no',  $request->shipingNumber)
            ->where('packing_no',  $request->packingNumber)
            ->where('is_packed',  1)
            ->update([
                'stage' => $request->stage
            ]);

        if ($request->stage == 4) {
            $orderDetail = DB::table('shipped_orders')
                ->where('order_number',  $request->itemOrderNumber)
                ->where('shiping_no',  $request->shipingNumber)
                ->where('packing_no',  $request->packingNumber)
                ->first();
            //pr($orderDetail);
            $users = DB::table('tbl_customers')->where('user_id', $orderDetail->customer_id)->first();
            if ($users->phone) {
                $sms = sendSms(@$users->phone, "We thought you'd like to know that Subhiksh dispatched your item(s). Your order is on the way.");
            }
            if ($users->email) {
                Mail::to(@$users->email)->send(new AfterOrderDispatchMailToCustomer($orderDetail->order_number));
            }
        }
        //$itemOrders = DB::table('tbl_item_orders')->get();

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

        echo "ttttttt";
        exit;
    }
    public function editClassDiscount(Request $request)
    {


        $discountData = DB::table('tbl_customer_class_discount')->where('id', $request->classDiscountId)->first();
        $disountClassHtmlEdit = '';



        $itemCategories = DB::table('tbl_item_category')->get();
        $itemCat = '';
        $catSelected = '';
        foreach ($itemCategories as $itemCategorie) {
            if ($itemCategorie->id == $discountData->item_cat) {
                $catSelected = 'selected';
            } else {
                $catSelected = '';
            }

            $itemCat .= '<option value="' . $itemCategorie->id . '" ' . $catSelected . '>' . $itemCategorie->item_name . '</option>';
        }

        $customerTypes = [1 => 'Dealer', 2 => 'Wholesaller', 3 => 'Distibuter'];
        $customerTypesOption = '';
        $customerTypeSelected = '';
        foreach ($customerTypes as $customerTypeKey => $customerType) {
            if ($customerTypeKey == $discountData->customer_type) {
                $customerTypeSelected = 'selected';
            } else {
                $customerTypeSelected = '';
            }

            $customerTypesOption .= '<option value="' . $customerTypeKey . '" ' . $customerTypeSelected . '>' . $customerType . '</option>';
        }

        //$customerClasses = ['DL' => 'DL', 'UP' => 'UP'];
        $customerClasses = get_customer_classes();
        $customerClassesOption = '';
        $customerClassesSelected = '';

        foreach ($customerClasses as $customerClasseKey => $customerClasse) {

            if ($customerClasse->id == $discountData->customer_class) {
                $customerClassesSelected = 'selected';
            } else {
                $customerClassesSelected = '';
            }

            $customerClassesOption .= '<option value="' . $customerClasse->id . '" ' . $customerClassesSelected . '>' . $customerClasse->cust_class_name . '</option>';
        }


        $category = get_group_category_cat_id($discountData->item_cat);

        $disountClassHtmlEdit .= '<form action="' . route('updateClassDiscount') . '" method="post" class="" id="updateClassDiscount">
                       <input type="hidden" name="classDiscountId" value="' . $request->classDiscountId . '">
                  
                       <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Customer type</label>
                           <select  name="customer_type" id="customer_type" class="form-control">
                           <option value="">Select customer type</option>
                           ' . $customerTypesOption . '
                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Customer class</label>
                            <select  name="customer_class" id="customer_class" class="form-control">
                            <option value="">Select Customer class</option>
                                ' . $customerClassesOption . '
                            
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Item category</label>
                           <select  name="item_cat" id="item_cat" class="form-control">
                                <option value="">Select item category</option>
                                ' . $itemCat . '

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Discount(%)</label>
                            <input type="text" class="form-control" name="discount_percentage" value="' . $discountData->discount_percentage . '">
                        
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Applicable from</label>
                            <input type="text" class="form-control date" name="applicable_from" value="' . date("d-m-Y", strtotime($discountData->applicable_from)) . '" id="applicable_from">
                        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Expired on</label>
                            <input type="text"  class="form-control date" name="expired_on" value="' . date("d-m-Y", strtotime($discountData->expired_on)) . '" id="expired_on">
                        
                        </div>
                    </div>
                    
                    
                </div>


                <fieldset>
                    <input type="button" onclick="updateClassDiscountBtn()" value="Update" class="btn btn-success m-b-10" />

                </fieldset>
                
                 
                
            </form>';

        //pr($disountClassHtmlEdit);
        return Response::json(array(
            'status' => 1,
            'disountClassHtmlEdit' => html_entity_decode($disountClassHtmlEdit)

        ));
    }

    public function editCustomerSalesTaging(Request $request)
    {


        $customerSales = DB::table('customer_sales')->where('id', $request->customerSalesId)->first();
        $editCustomerSalesTagingForm = '';
        $customers = DB::table('tbl_customers')
            ->where('status', 1)
            ->where('deleted_at', 1)
            ->get();
        $customerOption = '';
        $customerSelected = '';
        foreach ($customers as $customer) {
            if ($customer->id == $customerSales->customer_id) {
                $customerSelected = 'selected';
            } else {
                $customerSelected = '';
            }
            $customerType = (@$customer->customer_type == 1) ? 'Dealer' : ((@$customer->customer_type == 2) ? 'Wholesaler' : ((@$customer->customer_type == 3) ? 'Distibuter' : ''));
            $customerName = ucfirst(@$customer->cutomer_fname . ' ' . @$customer->cutomer_lname) . '-' . @$customerType . '-' . @$customer->phone . '-' . @$customer->email;

            $customerOption .= '<option value="' . $customer->user_id . '" ' . $customerSelected . '>' . $customerName . '</option>';
        }

        $SE_salers = DB::table('tbl_sellers')
            ->where('status', 1)
            ->where('seller_type_id', 4)
            ->get();

        $SE_salers_option = '';
        $SE_salers_selected = '';

        foreach ($SE_salers as $SE_sales) {
            if ($SE_sales->id == $customerSales->sales_id) {
                $SE_salers_selected = 'selected';
            } else {
                $SE_salers_selected = '';
            }

            $SE_salers_option .= '<option value="' . $SE_sales->user_id . '" ' . $SE_salers_selected . '>' . ucfirst($SE_sales->seller_name) . '</option>';
        }

        $ASM_salers = DB::table('tbl_sellers')
            ->where('status', 1)
            ->where('seller_type_id', 3)
            ->get();
        $ASM_salers_option = '';
        $ASM_salers_selected = '';

        foreach ($ASM_salers as $ASM_sales) {
            if ($ASM_sales->id == $customerSales->sales_id) {
                $ASM_salers_selected = 'selected';
            } else {
                $ASM_salers_selected = '';
            }

            $ASM_salers_option .= '<option value="' . $ASM_sales->user_id . '" ' . $ASM_salers_selected . '>' . ucfirst($ASM_sales->seller_name) . '</option>';
        }

        $RSM_salers = DB::table('tbl_sellers')
            ->where('status', 1)
            ->where('seller_type_id', 2)
            ->get();
        $RSM_salers_option = '';
        $RSM_salers_selected = '';

        foreach ($RSM_salers as $RSM_sales) {
            if ($RSM_sales->id == $customerSales->sales_id) {
                $RSM_salers_selected = 'selected';
            } else {
                $RSM_salers_selected = '';
            }

            $RSM_salers_option .= '<option value="' . $RSM_sales->user_id . '" ' . $RSM_salers_selected . '>' . ucfirst($RSM_sales->seller_name) . '</option>';
        }

        $NSM_salers = DB::table('tbl_sellers')
            ->where('status', 1)
            ->where('seller_type_id', 1)
            ->get();
        $NSM_salers_option = '';
        $NSM_salers_selected = '';

        foreach ($NSM_salers as $NSM_sales) {
            if ($NSM_sales->id == $customerSales->sales_id) {
                $NSM_salers_selected = 'selected';
            } else {
                $NSM_salers_selected = '';
            }

            $NSM_salers_option .= '<option value="' . $NSM_sales->user_id . '" ' . $NSM_salers_selected . '>' . ucfirst($NSM_sales->seller_name) . '</option>';
        }

        $editCustomerSalesTagingForm .= '<form action="' . route('updateCustomerSalesTaging') . '" method="post" class="" id="updateCustomerSalesTaging">
                       <input type="hidden" name="customerSalesId" value="' . $request->customerSalesId . '">
                  
                       <div class="row">
                   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Customer</label>
                            <select  name="customer_id" id="customer_id" class="form-control">
                            <option value="">Select Customer</option>
                                ' . $customerOption . '
                            
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >SE</label>
                           <select  name="sales_id[]" id="se_sales_id" class="form-control">
                                <option value="">Select Sales SE</option>
                                ' . $SE_salers_option . '

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >ASM</label>
                           <select  name="sales_id[]" id="asm_sales_id" class="form-control">
                                <option value="">Select Sales ASM</option>
                                ' . $ASM_salers_option . '

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >RSM</label>
                           <select  name="sales_id[]" id="rsm_sales_id" class="form-control">
                                <option value="">Select Sales RSM</option>
                                ' . $RSM_salers_option . '

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >NSM</label>
                           <select  name="sales_id[]" id="nsm_sales_id" class="form-control">
                                <option value="">Select Sales NSM</option>
                                ' . $NSM_salers_option . '

                           </select>
                        </div>

                    </div>
                   
                    
                    
                </div>


                <fieldset>
                    <input type="button" onclick="updateCustomerSalesTaging()" value="Update" class="btn btn-success m-b-10" />

                </fieldset>
                

                
            </form>';

        //pr($disountClassHtmlEdit);
        return Response::json(array(
            'status' => 1,
            'editCustomerSalesTagingForm' => html_entity_decode($editCustomerSalesTagingForm)

        ));
    }

    public function editCategoryDiscount(Request $request)
    {


        $discountData = DB::table('tbl_customer_category_discount')->where('id', $request->categoryDiscountId)->first();
        $disountClassHtmlEdit = '';



        $itemCategories = DB::table('tbl_item_category')->get();
        $itemCat = '';
        $catSelected = '';
        foreach ($itemCategories as $itemCategorie) {
            if ($itemCategorie->id == $discountData->item_cat) {
                $catSelected = 'selected';
            } else {
                $catSelected = '';
            }

            $itemCat .= '<option value="' . $itemCategorie->id . '" ' . $catSelected . '>' . $itemCategorie->item_name . '</option>';
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

        foreach ($customerClasses as $customerClasse) {
            if ($customerClasse->id == $discountData->cat_class) {
                $customerClassesSelected = 'selected';
            } else {
                $customerClassesSelected = '';
            }

            $customerClassesOption .= '<option value="' . $customerClasse->id . '" ' . $customerClassesSelected . '>' . $customerClasse->cust_category_name . '</option>';
        }


        $category = get_group_category_cat_id($discountData->item_cat);

        $disountClassHtmlEdit .= '<form action="' . route('updateCategoryDiscount') . '" method="post" class="" id="updateCategoryDiscount">
                       <input type="hidden" name="categoryDiscountId" value="' . $request->categoryDiscountId . '">
                  
                       <div class="row">
                   
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Customer class</label>
                            <select  name="cat_class" id="cat_class" class="form-control">
                            <option value="">Select Customer class</option>
                                ' . $customerClassesOption . '
                            
                           
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label >Item category</label>
                           <select  name="item_cat" id="item_cat" class="form-control">
                                <option value="">Select item category</option>
                                ' . $itemCat . '

                           </select>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Discount(%)</label>
                            <input type="text" class="form-control" name="discount_percentage" value="' . $discountData->discount_percentage . '">
                        
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Applicable from</label>
                            <input type="text" class="form-control date" name="applicable_from" value="' . date("d-m-Y", strtotime($discountData->applicable_from)) . '" id="applicable_from">
                        
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                    
                            <label >Expired on</label>
                            <input type="text"  class="form-control date" name="expired_on" value="' . date("d-m-Y", strtotime($discountData->expired_on)) . '" id="expired_on">
                        
                        </div>
                    </div>
                    
                    
                </div>


                <fieldset>
                    <input type="button" onclick="updateCategoryDiscountBtn()" value="Update" class="btn btn-success m-b-10" />

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

    public function salesCustomerTag()
    {
        $theme = Theme::uses('backend')->layout('layout');
        $customerSaleses = DB::table('customer_sales')->get();


        return $theme->scope('admin.customer_seler_tag', compact('customerSaleses'))->render();
    }

    public function updateCategoryDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_category_discount')
            ->where('cat_class', $request->cat_class)
            ->where('item_cat', $request->item_cat)
            ->where('id', '!=', $request->categoryDiscountId)
            ->first();

        if ($check) {
            //pr($check);
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
        foreach ($discountDatas as $discountData) {



            $category = get_group_category_cat_id($discountData->item_cat);
            @$customerCategory = getCustomerCategoryById(@$discountData->cat_class);
            $disountHtml .= '<tr>

                    <td>' . $discountData->id . '</td>
                    <td>' . @$customerCategory->cust_category_name . '</td>
                    
                    <td>' . $category . '</td>
                    <td>' . $discountData->discount_percentage . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->applicable_from)) . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->expired_on)) . '</td>
                   
                    <td>
                        <a class="btn btn-primary" id="' . $discountData->id . '" onclick="editCategoryDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                        
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

        if ($check) {
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
        foreach ($discountDatas as $discountData) {

            if ($discountData->customer_type == 1) {
                $customerType = 'Dealer';
            } else if ($discountData->customer_type == 2) {
                $customerType = 'Wholesaller';
            } else {
                $customerType = 'Distibuter';
            }

            $category = get_group_category_cat_id($discountData->item_cat);
            $customer_class = get_customer_class_by_id($discountData->customer_class);

            $disountHtml .= '<tr>

                    <td>' . $discountData->id . '</td>
                    <td>' . $customerType . '</td>
                    <td>' . $customer_class->cust_class_name . '</td>
                    <td>' . $category . '</td>
                    <td>' . $discountData->discount_percentage . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->applicable_from)) . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->expired_on)) . '</td>
                   
                    <td>
                        <a class="btn btn-primary" id="' . $discountData->id . '" onclick="editClassDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                        
                    </td>
                
                </tr>';
        }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Update class discount successfuly',
            'appendDiscount' => $disountHtml

        ));
    }

    public function saveCustomerSales(Request $request)
    {

        if (count($request->sales_id) > 0) {
            foreach ($request->sales_id as $sales_id) {

                if (!empty(@$sales_id) && !empty($request->customer_id)) {
                    $customer = DB::table('tbl_customers')->where('user_id', $request->customer_id)->first();
                    $salesDetail = DB::table('tbl_sellers')->where('user_id', $sales_id)->first();

                    $saveCustomerSales = DB::table('customer_sales')->updateOrInsert([

                        'customer_user_id' => @$request->customer_id,
                        'customer_id' => @$customer->id,
                        'sales_id' => @$salesDetail->id,
                        'sales_user_id' =>  @$sales_id,
                    ], [
                        'customer_id' => @$customer->id,
                        'customer_user_id' => @$request->customer_id,
                        'sales_id' => @$salesDetail->id,
                        'sales_user_id' =>  @$sales_id,

                    ]);
                    // $saveCustomerSales = DB::table('customer_sales')->insert([
                    //     'customer_id' => @$customer->id,
                    //     'customer_user_id' => @$request->customer_id,
                    //     'sales_id' => @$salesDetail->id,
                    //     'sales_user_id' =>  @$sales_id,

                    // ]);
                }
            }
        }



        $customerSales = DB::table('customer_sales')->get();
        $customerSalesHtml = '';
        foreach ($customerSales as $customerSale) {
            $customerDetail = DB::table('tbl_customers')->where('id', $customerSale->customer_id)->first();
            $salesDetail = DB::table('tbl_sellers')->where('id', $customerSale->sales_id)->first();

            if (@$customerDetail->customer_type == 1) {
                @$customerType = 'Dealer';
            } else if (@$customerDetail->customer_type == 2) {
                @$customerType = 'Wholesaller';
            } else {
                @$customerDetail = 'Distibuter';
            }

            if (@$salesDetail->seller_type_id == 1) {
                $NSM_sales_name = @$salesDetail->seller_name;
            } else {
                $NSM_sales_name = '';
            }

            if (@$salesDetail->seller_type_id == 2) {
                $RSM_sales_name = @$salesDetail->seller_name;
            } else {
                $RSM_sales_name = '';
            }
            if (@$salesDetail->seller_type_id == 3) {
                $ASM_sales_name = @$salesDetail->seller_name;
            } else {
                $ASM_sales_name = '';
            }
            if (@$salesDetail->seller_type_id == 4) {
                $SE_sales_name = @$salesDetail->seller_name;
            } else {
                $SE_sales_name = '';
            }


            $customerName = ucfirst(@$customerDetail->cutomer_fname . ' ' . @$customerDetail->cutomer_lname) . '-' . @$customerType . '-' . @$customerDetail->phone . '-' . @$customerDetail->email;

            $customerSalesHtml .= '<tr>

                    <td>' . @$customerSale->id . '</td>
                    <td>' . @$customerName . '</td>
                    <td>' . ucfirst(@$SE_sales_name) . '</td>
                    <td>' . ucfirst(@$ASM_sales_name) . '</td>
                    <td>' . ucfirst(@$RSM_sales_name) . '</td>
                    <td>' . ucfirst(@$NSM_sales_name) . '</td>
                    <td>' . date("d-m-Y", strtotime(@$customerSale->created_at)) . '</td>
                   
                   
                    <td>
                        <a class="btn btn-default" id="' . $customerSale->id . '" onclick="editCustomerSalesTaging(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                       
                        
                    </td>
                
                </tr>';
        }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Customer taged successfuly',
            'customerSalesHtml' => $customerSalesHtml

        ));
    }

    public function updateCustomerSalesTaging(Request $request)
    {

        if (count($request->sales_id) > 0) {
            foreach ($request->sales_id as $sales_id) {

                if (!empty(@$sales_id) && !empty($request->customer_id)) {
                    $customer = DB::table('tbl_customers')->where('user_id', $request->customer_id)->first();
                    $salesDetail = DB::table('tbl_sellers')->where('user_id', $sales_id)->first();

                    $checkCustomerSales = DB::table('customer_sales')
                        ->where('customer_id', @$customer->id)
                        ->where('customer_user_id', @$request->customer_id)
                        ->where('sales_id', @$salesDetail->id)
                        ->where('sales_user_id', @$sales_id)
                        ->first();

                    if ($checkCustomerSales) {

                        $saveCustomerSales = DB::table('customer_sales')->updateOrInsert([

                            'customer_user_id' => @$request->customer_id,
                            'customer_id' => @$customer->id,
                            'sales_id' => @$salesDetail->id,
                            'sales_user_id' =>  @$sales_id,
                        ], [
                            'customer_id' => @$customer->id,
                            'customer_user_id' => @$request->customer_id,
                            'sales_id' => @$salesDetail->id,
                            'sales_user_id' =>  @$sales_id,

                        ]);
                    } else {

                        $saveCustomerSales = DB::table('customer_sales')->where('id', $request->customerSalesId)->update([
                            'customer_id' => @$customer->id,
                            'customer_user_id' => @$request->customer_id,
                            'sales_id' => @$salesDetail->id,
                            'sales_user_id' =>  @$sales_id,

                        ]);
                    }
                }
            }
        }



        $customerSales = DB::table('customer_sales')->get();
        $customerSalesHtml = '';
        foreach ($customerSales as $customerSale) {
            $customerDetail = DB::table('tbl_customers')->where('id', $customerSale->customer_id)->first();
            $salesDetail = DB::table('tbl_sellers')->where('id', $customerSale->sales_id)->first();

            if (@$customerDetail->customer_type == 1) {
                @$customerType = 'Dealer';
            } else if (@$customerDetail->customer_type == 2) {
                @$customerType = 'Wholesaller';
            } else {
                @$customerDetail = 'Distibuter';
            }

            if (@$salesDetail->seller_type_id == 1) {
                $NSM_sales_name = @$salesDetail->seller_name;
            } else {
                $NSM_sales_name = '';
            }

            if (@$salesDetail->seller_type_id == 2) {
                $RSM_sales_name = @$salesDetail->seller_name;
            } else {
                $RSM_sales_name = '';
            }
            if (@$salesDetail->seller_type_id == 3) {
                $ASM_sales_name = @$salesDetail->seller_name;
            } else {
                $ASM_sales_name = '';
            }
            if (@$salesDetail->seller_type_id == 4) {
                $SE_sales_name = @$salesDetail->seller_name;
            } else {
                $SE_sales_name = '';
            }


            $customerName = ucfirst(@$customerDetail->cutomer_fname . ' ' . @$customerDetail->cutomer_lname) . '-' . @$customerType . '-' . @$customerDetail->phone . '-' . @$customerDetail->email;

            $customerSalesHtml .= '<tr>

                    <td>' . @$customerSale->id . '</td>
                    <td>' . @$customerName . '</td>
                    <td>' . ucfirst(@$SE_sales_name) . '</td>
                    <td>' . ucfirst(@$ASM_sales_name) . '</td>
                    <td>' . ucfirst(@$RSM_sales_name) . '</td>
                    <td>' . ucfirst(@$NSM_sales_name) . '</td>
                    <td>' . date("d-m-Y", strtotime(@$customerSale->created_at)) . '</td>
                   
                   
                    <td>
                        <a class="btn btn-default" id="' . $customerSale->id . '" onclick="editCustomerSalesTaging(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                       
                        
                    </td>
                
                </tr>';
        }

        return Response::json(array(
            'status' => 1,
            'msg' => 'Customer taging updated successfuly',
            'customerSalesHtml' => $customerSalesHtml

        ));
    }

    public function saveClassDiscount(Request $request)
    {
        $check = DB::table('tbl_customer_class_discount')
            ->where('customer_type', $request->customer_type)
            ->where('customer_class', $request->customer_class)
            ->where('item_cat', $request->item_cat)
            ->first();

        if ($check) {
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
        foreach ($discountDatas as $discountData) {

            if ($discountData->customer_type == 1) {
                $customerType = 'Dealer';
            } else if ($discountData->customer_type == 2) {
                $customerType = 'Wholesaller';
            } else {
                $customerType = 'Distibuter';
            }

            $category = get_group_category_cat_id($discountData->item_cat);
            $customer_class = get_customer_class_by_id($discountData->customer_class);

            $disountHtml .= '<tr>

                    <td>' . $discountData->id . '</td>
                    <td>' . $customerType . '</td>
                    <td>' . $customer_class->cust_class_name . '</td>
                    <td>' . $category . '</td>
                    <td>' . $discountData->discount_percentage . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->applicable_from)) . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->expired_on)) . '</td>
                   
                    <td>
                        
                        <a class="btn btn-default" id="' . $discountData->id . '" onclick="editClassDiscount(this.id)" href="javascript:void();" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
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

        if ($check) {
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
        foreach ($discountDatas as $discountData) {



            $category = get_group_category_cat_id($discountData->item_cat);
            @$customerCategory = getCustomerCategoryById(@$discountData->cat_class);
            $disountHtml .= '<tr>

                    <td>' . $discountData->id . '</td>
                    <td>' . @$customerCategory->cust_category_name . '</td>
                    <td>' . $category . '</td>
                    <td>' . $discountData->discount_percentage . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->applicable_from)) . '</td>
                    <td>' . date("d-m-Y", strtotime($discountData->expired_on)) . '</td>
                   
                   <td>
                    <a class="btn btn-primary"  id="' . $discountData->id . '" onclick="editCategoryDiscount(this.id)" href="javascript:void();"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                    
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

    public function adminOrderBackend()
    {

        $itemOrders = DB::table('tbl_payment_status')
            ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
            ->orderBy('tbl_payment_status.id', 'desc')

            ->get();
        $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');


        //pr($itemOrders);
        $theme = Theme::uses('backend')->layout('layout');
        return $theme->scope('admin.adminOrderTabPage', compact('itemOrders'))->render();
    }

    public function saveShippedOrderWithTransport(Request $request)
    {

        //pr($request->all());
        // $this->validate($request, [

        //     'transporter_id' => 'required|max:120',
        //     'attachment' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
        // ]);

        if ($request->hasFile('attachment')) {
            $banner = $request->file('attachment');
            $name = preg_replace('/[^a-zA-Z0-9_.]/', '_', $banner->getClientOriginalName());
            $destinationPath = ITEM_IMG_PATH;
            $image_name = 'attachment_' . date('mdis') . $name;
            $banner->move($destinationPath, $image_name);
            // if (File::exists($destinationPath . '/' . $request->input('old_attachment'))) {
            //     File::delete($destinationPath . '/' . $request->input('old_attachment'));
            // }
        } else {
            $image_name = $request->input('old_attachment');
        }
        $packedOrders = DB::table('item_order_packing_details')->where('packing_no', $request->packing_no)->get();
        $shiping_no = date('ymdis') . rand(000, 999);
        foreach ($packedOrders as $packedOrder) {

            $checkShipedOrderExists = DB::table('shipped_orders')
                ->where('order_number', $packedOrder->order_number)
                ->where('customer_id', $packedOrder->customer_id)
                ->where('packing_no', $packedOrder->packing_no)
                ->where('item_id', $packedOrder->item_id)
                ->first();
            //pr($checkShipedOrderExists);
            if ($checkShipedOrderExists) {


                $shippedOrder = DB::table('shipped_orders')->updateOrInsert(
                    [

                        'order_number' => $packedOrder->order_number,
                        'customer_id' => $packedOrder->customer_id,
                        'packing_no' => $packedOrder->packing_no,
                        'item_id' => $packedOrder->item_id,
                        'shiping_no' => $checkShipedOrderExists->shiping_no,
                    ],
                    [

                        'order_number' => $packedOrder->order_number,
                        'customer_id' => $packedOrder->customer_id,
                        'shiping_no' => $checkShipedOrderExists->shiping_no,
                        'packing_no' => $packedOrder->packing_no,
                        'item_id' => $packedOrder->item_id,
                        'quantity' => $packedOrder->qty,
                        'unit' => $packedOrder->unit,
                        'small_box' => $packedOrder->small_box,
                        'medium_box' => $packedOrder->medium_box,
                        'large_box' => $packedOrder->large_box,
                        'bori' => $packedOrder->bori,
                        'other' => $packedOrder->other,
                        'total' => $packedOrder->total,
                        'transporter_id' => $request->transporter_id,
                        'docket_number' => $request->docket_number,
                        'docket_name' => $request->docket_name,
                        'tentative_delivery_date' => $request->tentative_delivery_date,
                        'shiping_cost' => $request->shiping_cost,
                        'attachment' => $image_name,
                        'payment_mode' => $request->payment_mode,
                        'amount_to_be_collected' => $request->amount_to_be_collected,
                        'picked_by' => $request->picked_by,

                    ]
                );
            } else {


                $shippedOrder = DB::table('shipped_orders')->insert([
                    'customer_id' => $packedOrder->customer_id,
                    'order_number' => $packedOrder->order_number,
                    'shiping_no' => $shiping_no,
                    'packing_no' => $packedOrder->packing_no,
                    'item_id' => $packedOrder->item_id,
                    'quantity' => $packedOrder->qty,
                    'unit' => $packedOrder->unit,
                    'small_box' => $packedOrder->small_box,
                    'medium_box' => $packedOrder->medium_box,
                    'large_box' => $packedOrder->large_box,
                    'bori' => $packedOrder->bori,
                    'other' => $packedOrder->other,
                    'total' => $packedOrder->total,
                    'transporter_id' => $request->transporter_id,
                    'docket_number' => $request->docket_number,
                    'docket_name' => $request->docket_name,
                    'tentative_delivery_date' => $request->tentative_delivery_date,
                    'shiping_cost' => $request->shiping_cost,
                    'attachment' => $image_name,
                    'payment_mode' => $request->payment_mode,
                    'amount_to_be_collected' => $request->amount_to_be_collected,
                    'picked_by' => $request->picked_by,

                ]);
            }
        }

        return response()->json(array(
            'status' => 1,
            'msg' => 'Order shipped successfully.',
            'url' => route('shippingOrderAdmin')
        ));
    }

    public function getItemByBarcode(Request $request)
    {
        //pr($request->all());
        //echo $request->barcode;
        $item = DB::table('tbl_items')->where('barcode', $request->barcode)->first();
        //pr($item);
        $itemDetail = DB::table('tbl_item_orders')->where('customer_id', $request->customer_id)
            ->where('order_id', $request->order_number)
            ->where('item_id', $item->item_id)
            ->where('stage', 1)
            ->first();

        @$scandItem = DB::table('to_be_packed_scan_items')->where('customer_id', $request->customer_id)
            ->where('order_number', $request->order_number)
            ->where('item_id', $item->item_id)
            ->first();

        if (@$scandItem->quantity == $itemDetail->quantity) {
            DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                ->where('item_id', $item->item_id)
                ->update(['pending_qty' => 0]);

            DB::table('to_be_packed_scan_items')->where('order_number', $request->order_number)
                ->where('item_id', $item->item_id)
                ->update(['pending_qty' => 0]);
        }
        //pr($itemDetail);

        //    $html = '';
        //    $html = '<input type="hidden" name=""';
        return response()->json(array(
            'status' => 1,
            'itemId' => $item->item_id,
            'itemName' => (@$itemDetail->id) ? $item->item_name : '',
            'itemOrderQuantity' => (@$itemDetail->pending_qty != 0) ? @$itemDetail->pending_qty : @$itemDetail->quantity,
            'itemOrderId' => @$itemDetail->id,
            'itemUnit' => @$itemDetail->unit
        ));
    }

    public function deleteScandItem(Request $request)
    {
        $deleteToBePackedScanItem = toBePackedScanItem::where('id', $request->scanItemId)->delete();

        @$itemOrderProcess = itemOrderProcess::where('order_number', $request->order_number)
            ->where('customer_id', $request->customer_id)
            ->where('item_id', $request->item_id)
            ->where('is_packed', 0)
            ->count();

        if (@$itemOrderProcess > 0) {
            @$itemOrderProcess = itemOrderProcess::where('order_number', $request->order_number)
                ->where('customer_id', $request->customer_id)
                ->where('item_id', $request->item_id)
                ->where('is_packed', 0)
                ->delete();

            DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                ->where('customer_id', $request->customer_id)
                ->where('item_id', $request->item_id)
                ->update(['is_packed' => 0, 'increase_qty' => 0, 'pending_qty' => 0, 'packing_no' => '']);
        }

        if ($deleteToBePackedScanItem) {
            $checkActualOrder = DB::table('tbl_item_orders')
                ->where('order_id', $request->order_number)
                ->where('customer_id', $request->customer_id)
                ->where('item_id', $request->item_id)
                ->first();
            @$checkPackedOrder = DB::table('item_order_packing_details')
                ->where('order_number', $request->order_number)
                ->where('customer_id', $request->customer_id)
                ->where('item_id', $request->item_id)
                // ->select('item_order_packing_details.*', DB::raw('sum(item_order_packing_details.qty) as totalPackedQty'))
                ->sum('item_order_packing_details.qty');
            // echo @$checkPackedOrder;exit('ttest');
            if (@$checkPackedOrder > 0) {

                if (@$checkPackedOrder == $checkActualOrder->quantity) {
                    // $pendingQty = @$checkPackedOrder - $checkActualOrder->quantity;
                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $request->item_id)
                        ->update(['is_packed' => 1, 'increase_qty' => 0, 'pending_qty' => 0]);
                }
                if (@$checkPackedOrder < $checkActualOrder->quantity) {
                    $pendingQty = $checkActualOrder->quantity - @$checkPackedOrder;
                    DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                        ->where('customer_id', $request->customer_id)
                        ->where('item_id', $request->item_id)
                        ->update(['is_packed' => 0, 'is_Inprocess' => 2, 'increase_qty' => 0, 'pending_qty' => $pendingQty]);
                }
            } else {
                //exit('eee');
                DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                    ->where('customer_id', $request->customer_id)
                    ->where('item_id', $request->item_id)
                    ->update(['is_Inprocess' => 0, 'pending_qty' => 0, 'stage' => 1]);
            }




            return response()->json(array(
                'status' => 1,
                'msg' => 'Item added successfully.',


            ));
        } else {
            return response()->json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.',


            ));
        }
    }

    public function toBePackedClickBtnProcess(Request $request)
    {

        //pr($request->all());
        @$deleteToBePackedScanItems = toBePackedScanItem::where('order_number', $request->order_number)
            ->where('customer_id', $request->customer_id)

            ->get();

        if (count(@$deleteToBePackedScanItems) > 0) {
            foreach (@$deleteToBePackedScanItems as $deleteToBePackedScanItem) {

                $orderActual = DB::table('tbl_item_orders')->where('order_id', $deleteToBePackedScanItem->order_number)->where('id', $deleteToBePackedScanItem->order_item_id)->first();

                // @$checkScanedOrderQty = DB::table('to_be_packed_scan_items')
                //     ->where('order_number', $deleteToBePackedScanItem->order_number)
                //     ->where('customer_id', $deleteToBePackedScanItem->customer_id)
                //     ->where('item_id', $deleteToBePackedScanItem->item_id)

                //     ->sum('to_be_packed_scan_items.quantity');



                //     if(@$checkPackedOrder == $toBePackedScanItem->exact_qty){

                //         DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //         ->where('customer_id', $request->customer_id)
                //         ->where('item_id', $toBePackedScanItem->item_id)
                //         ->update(['is_packed'=> 1, 'stage'=> 2, 'pending_qty' => 0, 'is_Inprocess'=>1, 'packing_no'=> $packing_no]);

                //     }else{
                //         DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                //         ->where('customer_id', $request->customer_id)
                //         ->where('item_id', $toBePackedScanItem->item_id)
                //         ->update(['is_packed'=> 0, 'stage'=> ($toBePackedScanItem->pending_qty == 0) ? 2:1, 'packing_no'=>'']);
                //     }

                // if($orderActual->quantity >= $checkScanedOrderQty+$deleteToBePackedScanItem->quantity){

                // }else{

                // }
                //echo @$checkScanedOrderQty+$deleteToBePackedScanItem->quantity;exit;
                $pending_qty = 0;

                // if($orderActual->quantity >= (@$checkScanedOrderQty+$deleteToBePackedScanItem->quantity)){

                //     $pending_qty = $orderActual->quantity - (@$checkScanedOrderQty+$deleteToBePackedScanItem->quantity);

                if ($orderActual->quantity >= $deleteToBePackedScanItem->quantity) {

                    $pending_qty = $orderActual->quantity - (@$checkScanedOrderQty + $deleteToBePackedScanItem->quantity);
                    //echo $pending_qty;exit('ddg');
                    DB::table('tbl_item_orders')->where('order_id', $deleteToBePackedScanItem->order_number)
                        ->where('customer_id', $deleteToBePackedScanItem->customer_id)
                        ->where('item_id', $deleteToBePackedScanItem->item_id)
                        ->where('id', $deleteToBePackedScanItem->order_item_id)
                        ->update(['pending_qty' => $pending_qty, 'increase_qty' => 0]);
                }

                // if($orderActual->quantity < (@$checkScanedOrderQty+$deleteToBePackedScanItem->quantity)){

                //     $increase_qty = (@$checkScanedOrderQty+$deleteToBePackedScanItem->quantity) - $orderActual->quantity;
                if ($orderActual->quantity < $deleteToBePackedScanItem->quantity) {

                    $increase_qty = $deleteToBePackedScanItem->quantity - $orderActual->quantity;
                    DB::table('tbl_item_orders')->where('order_id', $deleteToBePackedScanItem->order_number)
                        ->where('customer_id', $deleteToBePackedScanItem->customer_id)
                        ->where('item_id', $deleteToBePackedScanItem->item_id)
                        ->where('id', $deleteToBePackedScanItem->order_item_id)
                        ->update(['increase_qty' => $increase_qty, 'pending_qty' => 0]);
                }

                //echo $pending_qty;exit('dd');
                DB::table('tbl_item_orders')->where('order_id', $deleteToBePackedScanItem->order_number)
                    ->where('customer_id', $deleteToBePackedScanItem->customer_id)
                    ->where('item_id', $deleteToBePackedScanItem->item_id)
                    ->where('id', $deleteToBePackedScanItem->order_item_id)
                    ->update(['is_Inprocess' => ($pending_qty > 0) ? 2 : 1]);
                // ->update(['is_Inprocess'=> ($pending_qty == 0) ? 0 : (($pending_qty > 0)? 2:1)]);

                DB::table('to_be_packed_scan_items')->where('order_number', $deleteToBePackedScanItem->order_number)
                    ->where('customer_id', $deleteToBePackedScanItem->customer_id)
                    ->where('item_id', $deleteToBePackedScanItem->item_id)
                    ->where('order_item_id', $deleteToBePackedScanItem->order_item_id)
                    ->update([
                        'pending_qty' => ($deleteToBePackedScanItem->exact_qty >= $deleteToBePackedScanItem->quantity) ? $deleteToBePackedScanItem->exact_qty - $deleteToBePackedScanItem->quantity : 0,
                        'increase_qty' => ($deleteToBePackedScanItem->exact_qty <= $deleteToBePackedScanItem->quantity) ? $deleteToBePackedScanItem->quantity - $deleteToBePackedScanItem->exact_qty : 0,
                    ]);
            }

            return response()->json(array(
                'status' => 1,
                'msg' => 'Item processed successfully.',
                'url' => route('toBePackedAdminOrder'),



            ));
        } else {
            return response()->json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.',
                'url' => route('toBePackedDetail', $request->order_number),


            ));
        }
    }

    public function barcodeScanItemSave(Request $request)
    {

        $orderActual = DB::table('tbl_item_orders')->where('order_id', $request->order_number)->where('id', $request->itemOrderId)->first();
        //    $toBePackedScanItem = toBePackedScanItem::updateOrCreate([

        //     'order_number'   => $request->order_number,
        //     'order_item_id'   => $request->itemOrderId,
        //     'customer_id'   => $request->customer_id,
        //     'item_id'   => $request->itemId,
        //     'item_barcode'   => $request->barcode,
        //     ],[
        //         'order_number'   => $request->order_number,
        //         'order_item_id'   => $request->itemOrderId,
        //         'customer_id'   => $request->customer_id,
        //         'item_id'   => $request->itemId,
        //         'item_barcode'   => $request->barcode,
        //         'item_name'   => $request->item_name,
        //         'quantity'   => $request->qty,
        //         'exact_qty'   =>  $orderActual->quantity,
        //         'unit'   => $request->unit,
        //     ]);
        $pending_qty = 0;
        $increase_qty = 0;
        if ($orderActual->quantity >= $request->qty) {

            $pending_qty = $orderActual->quantity - $request->qty;


            DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                ->where('id', $request->itemOrderId)
                ->update(['pending_qty' => $pending_qty]);

            // DB::table('to_be_packed_scan_items')->where('order_number', $deleteToBePackedScanItem->order_number)
            // ->where('customer_id', $deleteToBePackedScanItem->customer_id)
            // ->where('item_id', $deleteToBePackedScanItem->item_id)
            // ->where('order_item_id', $deleteToBePackedScanItem->order_item_id)
            // ->update(['pending_qty'=> $pending_qty]);
        }

        if ($orderActual->quantity < $request->qty) {

            $increase_qty = $request->qty - $orderActual->quantity;

            DB::table('tbl_item_orders')->where('order_id', $request->order_number)
                ->where('id', $request->itemOrderId)
                ->update(['increase_qty' => $increase_qty]);

            // DB::table('tbl_item_orders')->where('order_id', $deleteToBePackedScanItem->order_number)
            // ->where('customer_id', $deleteToBePackedScanItem->customer_id)
            // ->where('item_id', $deleteToBePackedScanItem->item_id)
            // ->where('id', $deleteToBePackedScanItem->order_item_id)
            // ->update(['increase_qty'=> $increase_qty]);


        }

        $checkScanItem = toBePackedScanItem::where('order_number', $request->order_number)
            ->where('order_item_id', $request->itemOrderId)
            ->where('item_id', $request->itemId)
            ->where('customer_id', $request->customer_id)
            ->first();
        $scanQty = 0;
        if ($request->qty < $orderActual->quantity && (@$checkScanItem->quantity + $request->qty <= $orderActual->quantity)) {
            //if(@$checkScanItem->quantity + $request->qty){
            $scanQty = @$checkScanItem->quantity + $request->qty;
        } else {
            $scanQty = $orderActual->quantity;
        }

        if (@$checkScanItem->is_packed == 0) {

            $toBePackedScanItem = toBePackedScanItem::updateOrCreate([

                'order_number'   => $request->order_number,
                'order_item_id'   => $request->itemOrderId,
                'customer_id'   => $request->customer_id,
                'item_id'   => $request->itemId,
                'item_barcode'   => $request->barcode,
            ], [
                'order_number'   => $request->order_number,
                'order_item_id'   => $request->itemOrderId,
                'customer_id'   => $request->customer_id,
                'item_id'   => $request->itemId,
                'item_barcode'   => $request->barcode,
                'item_name'   => $request->item_name,
                //'quantity'   => ($request->qty == @$checkScanItem->quantity || $request->qty == $orderActual->quantity) ? $request->qty:@$checkScanItem->quantity + $request->qty,
                'quantity'   => $scanQty,
                'exact_qty'   =>  $orderActual->quantity,
                'unit'   => $request->unit,
                'pending_qty'   => $pending_qty,
                'increase_qty'   => $increase_qty,
            ]);
        } else {


            $toBePackedScanItem = toBePackedScanItem::Create([
                'order_number'   => $request->order_number,
                'order_item_id'   => $request->itemOrderId,
                'customer_id'   => $request->customer_id,
                'item_id'   => $request->itemId,
                'item_barcode'   => $request->barcode,
                'item_name'   => $request->item_name,
                'quantity'   => $request->qty,
                'exact_qty'   =>  $orderActual->quantity,
                'unit'   => $request->unit,
                'pending_qty'   => $pending_qty,
                'increase_qty'   => $increase_qty,
            ]);
        }
        if ($toBePackedScanItem->save()) {
            //DB::table('tbl_item_orders')->where('id', $request->itemOrderId)->update(['is_Inprocess'=> 1]);

            return response()->json(array(
                'status' => 1,
                'msg' => 'Item added successfully.',
                'url' => route('toBePackedDetail', $request->order_number),

            ));
        } else {
            return response()->json(array(
                'status' => 0,
                'msg' => 'Something is wrong try again.',
                'url' => route('toBePackedDetail', $request->order_number),

            ));
        }
    }

    public function editTransport(Request $request)
    {

        $transport = DB::table('transport_master')
            ->where('id', $request->transportId)
            ->first();

        return response()->json(array(
            'status' => 1,
            'id' => $transport->id,
            'transporter_name' => $transport->transporter_name,
            'transporter_address' => $transport->transporter_address,
            'contact_person_name' => $transport->contact_person_name,
            'phone_no' => $transport->phone_no,
        ));
    }


    public function getAdminOrder(Request $request)
    {

        if ($request->stage == '2') {
            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('item_order_packing_details', 'item_order_packing_details.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('item_order_packing_details.packing_stage', $request->stage)
                ->where('item_order_packing_details.is_packed', 1)
                ->get();

            // $itemOrders = DB::table('item_order_packing_details')
            // ->orderBy('id', 'desc')
            // ->where('is_packed', 1)
            // ->where('packing_stage', 2)
            // ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        } else if ($request->stage == '3') {

            // $itemOrders = DB::table('shipped_orders')
            // ->orderBy('id', 'desc')
            // ->where('order_stage', $request->stage)
            // ->get();
            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('shipped_orders.order_stage', $request->stage)
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        } else if ($request->stage == '4') {
            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('shipped_orders.order_stage', $request->stage)
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        } else if ($request->stage > '4' && $request->stage < '10') {

            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('shipped_orders.order_stage', $request->stage)
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'packing_no');
        } else if ($request->stage == '0') {

            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('shipped_orders.order_stage', $request->stage)
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        } else if ($request->stage == '1') {

            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->leftjoin('shipped_orders', 'shipped_orders.order_number', '=', 'tbl_item_orders.order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->where('stage', $request->stage)
                ->orWhere('shipped_orders.order_stage', $request->stage)
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        } else {
            $itemOrders = DB::table('tbl_payment_status')
                ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
                ->orderBy('tbl_payment_status.id', 'desc')
                ->get();
            $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
        }

        // if($request->stage != '10'){

        //     $itemOrders = DB::table('tbl_payment_status')
        //     ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        //     ->leftjoin('shipped_orders','shipped_orders.order_number','=','tbl_item_orders.order_id')
        //     ->orderBy('tbl_payment_status.id', 'desc')
        //     ->where('stage', $request->stage)
        //     ->orWhere('shipped_orders.order_stage', $request->stage)
        //     ->get();


        // }else{

        //     $itemOrders = DB::table('tbl_payment_status')
        //     ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        //     ->orderBy('tbl_payment_status.id', 'desc')
        //     ->get();

        // }



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


        $returnView = view('testMyCode', compact('itemOrders'))->render();

        return response()->json(array('success' => true, 'ordeHtml' => $returnView));
    }
}