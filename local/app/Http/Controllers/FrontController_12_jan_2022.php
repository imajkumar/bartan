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
use App\CustomerWiseBrand;
use Hash;
use PDF;
// use App\Http\Controllers\Input;




class FrontController extends Controller
{
    public $login;
    public $kyc;
    // public $brandId;
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
        //pr(Auth::user());

        // $brandId = array();
		// 	if ($this->login == "true" && $this->kyc == "true" && @$isAdmin !="yes") {
		// 		$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
		// 		foreach($customerBrands as $customerBrand){
		// 			$brandId[] = $customerBrand->brand_id;
		// 		}
		// 	}

           
      
    }
    
   
    public function itemByBrandfillter(Request $request)
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

        
        $keyword = $request->keyword;
        $brandIdFilter = $request->brandId;
        $searchKey = filter_search($keyword);
        //$searchKey = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        
        $items = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })

                //start attr
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
                    ->distinct('tbl_items.item_id');
                if(!empty($keyword)){
                    $items = $items->Where(function($query) use ($searchKey, $brandIdFilter){
                        foreach ($searchKey as $value) {
                           
                            $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                           
                        }

                        
                       
                        
                        // $query->Where('tbl_brands.id', $brandIdc);
                        // $query->Where('tbl_item_category.id', $categoryId);
                        $query->Where('tbl_brands.id', $brandIdFilter);
                        
                    });
                    $items = $items->where(function ($query) use ($searchKey, $brandIdFilter) {
                        foreach ($searchKey as $value) {
                            $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                           
                            // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                            // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                            
                        }
                        $query->Where('tbl_brands.id', $brandIdFilter);
                    });
        
                    $items = $items->orWhere(function($query) use ($keyword){
                        //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                        // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                        
                        // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                    });
                }

                    // ->where(function($query) use ($keyword){
                    //     $query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                    //     $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                    //     $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                    //     $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                    //     $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                    //     // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                    // })
                    // ->Where('tbl_items.item_name', 'like', '%' .$request->keyword . '%');
                    
                    if(!empty($request->brandId)){

                        $items = $items->Where('tbl_items.brand_id', $request->brandId);
                    }
                  
                    if(!empty($request->price_by)){

                        $items = $items->orderBy('tbl_items.regular_price', $request->price_by);
                    }
            
            
                    $items = $items->paginate(9);
                //->get();
           
                
        
        
               
                $items = $items->withPath(url('/search'));

                
                if(!empty($keyword)){

                   
                    $items = $items->appends(['keyword' => $keyword]);
                }
                if(!empty($request->brandId)){

                   
                    $items = $items->appends(['brandfilter' => $request->brandId]);
                }

                if(!empty($request->price_by)){
                    $items = $items->appends(['pricefilter' => $request->price_by]);
                }
               
       
        //pr($items);
       
        if(count($items)>0){
            $returnView = view('SearchFilterOption', compact('items'))->render();

            return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
        }else{
            //$returnView = view('CategoryFilterOption', compact('items'))->render();
            return response()->json(array('status' =>2, 
            'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
            //'items' => $items,
            ));

        }
           
           
        //     $returnView = view('salesItemAppend', compact('brands'))->render();

        // return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    public function filterLeftSideSearchPageAjax(Request $request)
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
        $brandId = array();
        if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
            if(!empty($brandIdForCatFilter)){
                $brandId[] = $brandIdForCatFilter;
            }
            else if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }else{
                $brandsListArr = DB::table('tbl_brands')->get();
                foreach($brandsListArr as $brandsList){
                    $brandId[] = $brandsList->id;
                }
            }
        }
        
        
        $keyword = $request->keyword;
        $priceFrom = $request->priceFrom;
        $priceTo = $request->priceTo;
        $searchKey = filter_search($keyword);
        //$searchKey = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        
        
        $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

            //end attr

            ->leftJoin('tbl_item_tags', function ($tag) {
                $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                //$tag->orderBy('tbl_item_tags.item_id', 'desc');
                //$tag->distinct('tbl_item_tags.item_id');
            })

                // ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                //     )
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )

                    ->Where('tbl_items.is_visible', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandId){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                }

                if(count($brandId) > 0){
                    $query->whereIn('tbl_items.brand_id', $brandId);
                }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo, $brandId) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }

                if(count($brandId) > 0){
                    $query->whereIn('tbl_items.brand_id', $brandId);
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
               
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');

            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }
            
            //->Where('tbl_items.item_name', 'like', '%' .$keyword . '%');
                    
                //(!empty($page)){
                    $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $datas = $data->paginate(9);
                // }else{
                //     $datas = $data->get();
                // }
                //pr($datas);
                $datas = $datas->withPath(url('/search-filter'));

                
                if(!empty($keyword)){

                   
                    $datas = $datas->appends(['keyword' => $keyword]);
                }
                
                if(!empty($priceFrom) && !empty($priceTo)){

                   
                    $datas = $datas->appends(['priceFrom' => $priceFrom, 'priceTo' => $priceTo]);
                }

                
                // if(!empty($request->brandId)){

                   
                //     $datas = $data->appends(['brandfilter' => $request->brandId]);
                // }

                // if(!empty($request->price_by)){
                //     $datas = $data->appends(['pricefilter' => $request->price_by]);
                // }


            $items = $datas;
            //pr($items);
            if(count($items)>0){
                //pr($items);
                $returnView = view('SearchLeftSideFilter', compact('items', 'keyword'))->render();

                return response()->json(array('status' =>1, 'ordeHtml' =>$returnView, 'keyword'=>ucfirst($keyword)));
            }else{
                //$returnView = view('CategoryFilterOption', compact('items'))->render();
                return response()->json(array('status' =>2, 
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                //'items' => $items,
                ));

            }
           
           
        //     $returnView = view('salesItemAppend', compact('brands'))->render();

        // return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    public function filterLeftSideCategoryPageAjax(Request $request)
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
        
        
        $keyword = $request->keyword;
        $priceFrom = $request->priceFrom;
        $priceTo = $request->priceTo;
        $searchKey = filter_search($keyword);
        //$searchKey = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        
        
        $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

            //end attr

            ->leftJoin('tbl_item_tags', function ($tag) {
                $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                //$tag->orderBy('tbl_item_tags.item_id', 'desc');
                //$tag->distinct('tbl_item_tags.item_id');
            })

                // ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                //     )
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )

                    ->Where('tbl_items.is_visible', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
               
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            //->Where('tbl_items.item_name', 'like', '%' .$keyword . '%');
                    
                //(!empty($page)){
                    $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $datas = $data->paginate(9);
                // }else{
                //     $datas = $data->get();
                // }
                $datas = $datas->withPath(url('/category-filter'));

                
                if(!empty($keyword)){

                   
                    $datas = $datas->appends(['keyword' => $keyword]);
                }
                
                if(!empty($priceFrom) && !empty($priceTo)){

                   
                    $datas = $datas->appends(['priceFrom' => $priceFrom, 'priceTo' => $priceTo]);
                }

                
                // if(!empty($request->brandId)){

                   
                //     $datas = $data->appends(['brandfilter' => $request->brandId]);
                // }

                // if(!empty($request->price_by)){
                //     $datas = $data->appends(['pricefilter' => $request->price_by]);
                // }


            $items = $datas;
            //pr($items);
            if(count($items)>0){
                //pr($items);
                $returnView = view('CategoryLeftSideFilter', compact('items'))->render();

                return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
            }else{
                //$returnView = view('CategoryFilterOption', compact('items'))->render();
                return response()->json(array('status' =>2, 
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                //'items' => $items,
                ));

            }
           
           
        //     $returnView = view('salesItemAppend', compact('brands'))->render();

        // return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }
    
    public function filterLeftSideBrandPageAjax(Request $request)
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
        
        
        $brandId = ($request->get('brandId')) ? $request->get('brandId'):$request->brandId;
        $keyword = $request->keyword;
        $priceFrom = $request->priceFrom;
        $priceTo = $request->priceTo;
        $searchKey = filter_search($keyword);
        //$searchKey = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
        
        
        $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

            //end attr

            ->leftJoin('tbl_item_tags', function ($tag) {
                $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                //$tag->orderBy('tbl_item_tags.item_id', 'desc');
                //$tag->distinct('tbl_item_tags.item_id');
            })

                // ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                //     )
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )

                    ->Where('tbl_items.is_visible', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandId){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $query->where('tbl_items.brand_id', $brandId);
                }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo, $brandId) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $query->where('tbl_items.brand_id', $brandId);
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo, $brandId){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                $query->where('tbl_items.brand_id', $brandId);
               
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            //->Where('tbl_items.item_name', 'like', '%' .$keyword . '%');
                    
                //(!empty($page)){
                    $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $datas = $data->paginate(9);
                // }else{
                //     $datas = $data->get();
                // }
                $datas = $datas->withPath(url('/brand-filter'));

                
                if(!empty($brandId)){

                   
                    $datas = $datas->appends(['brandId' => $brandId]);
                }
                if(!empty($keyword)){

                   
                    $datas = $datas->appends(['keyword' => $keyword]);
                }
                
                if(!empty($priceFrom) && !empty($priceTo)){

                   
                    $datas = $datas->appends(['priceFrom' => $priceFrom, 'priceTo' => $priceTo]);
                }

                
                // if(!empty($request->brandId)){

                   
                //     $datas = $data->appends(['brandfilter' => $request->brandId]);
                // }

                // if(!empty($request->price_by)){
                //     $datas = $data->appends(['pricefilter' => $request->price_by]);
                // }


            $items = $datas;
            //pr($items);
            if(count($items)>0){
                //pr($items);
                $returnView = view('BrandLeftSideFilter', compact('items'))->render();

                return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
            }else{
                //$returnView = view('CategoryFilterOption', compact('items'))->render();
                return response()->json(array('status' =>2, 
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                //'items' => $items,
                ));

            }
           
           
        //     $returnView = view('salesItemAppend', compact('brands'))->render();

        // return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }

    public function itemByBrandfillter_old_26_jully(Request $request)
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

        $keyword = $request->keyword;
        
        $items = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })

                //start attr
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

                    ->where(function($query) use ($keyword){
                        $query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                    })
                    // ->Where('tbl_items.item_name', 'like', '%' .$request->keyword . '%');
                    ->Where('tbl_items.is_visible', 1)
                    ->distinct('tbl_items.item_id');
                    if(!empty($request->brandId)){

                        $items = $items->Where('tbl_items.brand_id', $request->brandId);
                    }
                  
                    if(!empty($request->price_by)){

                        $items = $items->orderBy('tbl_items.regular_price', $request->price_by);
                    }
            
            
                    $items = $items->paginate(9);
                //->get();
           
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
                        $retailPrice ='';
                        if($item->item_mrp > $item->regular_price){
    
                            @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
                        }
    
                        if($totalOff == 0){
                           
                            if($item->regular_price){
    
                                //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                            
                                if($item->item_mrp){
                                   
                                    $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>
                                    <div class="item-discount-price itm-dpr">MRP:
                                             <span>???'.$item->item_mrp.'</span></div>';
                                        
                                        
                                }else{
                                    $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>';
                                }
    
                            
                            }else{
    
                                $Price = '<div class="item-price">???0</div>';
                            }
                        }else{
    
                            $Price ='<div class="item-price itm-pr">Offer Price ???'.$AfterDiscountPrice.'</div>'.
                            '<div class="item-discount-price itm-dpr">MRP ???'.$item->item_mrp.'</div>';
                        }
    
                        if($totalOff != 0){
                            $offPercenteg = '<div class="discount">'.$totalOff.'% OFF </div>';
                                    
                        }else{
                            $offPercenteg = '';
                        }
    
                        
                            if($retailPrice){
                                $retailMarginHtml = '<div class="itm-rlm">
                                <span>'.$retailPrice.'%</span> Retail Margin</div>';
                           }else{
                            $retailMarginHtml='';
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
                                    '.$retailMarginHtml.'
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
                    'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                    'items' => $items,
                    
                );
            }
            
            return($data);
           
           
        //     $returnView = view('salesItemAppend', compact('brands'))->render();

        // return response()->json(array('success' =>true, 'ordeHtml' =>$returnView));
    }


    public function itemByCategoryfillter(Request $request)
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

        
        $priceFrom =$request->priceFromCat;
        $priceTo =$request->priceToCat;
        $keyword =$request->keywordCat;
        $brandId =$request->brandId;
        $price_by =$request->price_by;


        // if(!empty($request->brandId)){

        //     $request->session()->put('brandIdForCatFilter', $request->brandId);
        // }
      
        // if(!empty($request->price_by)){


        //     $request->session()->put('orderByPriceForCatFilter', $request->price_by);
        // }
        
        $brandIdAllow = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
                $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
                
                if(!empty($brandId)){
                    $brandIdAllow[]=$brandId;
                }else if(count($customerBrands)>0){
                    foreach($customerBrands as $customerBrand){
                        $brandIdAllow[] = $customerBrand->brand_id;
                    }
                }else{
                    $brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandIdAllow[] = $brandsList->id;
                        
                    }
                }
			}
            //pr($brandIdAllow);

        //$items = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $catId, $page='9', $brandId);
                   
        $items = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                       
                       
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                    //->orderBy('tbl_items.item_id', 'desc')
                    ->distinct('tbl_items.item_id')
                    ->Where('tbl_items.is_visible', 1);
                   
                        
                  

                 if(!empty($keyword) && !empty($priceFrom) && !empty($priceTo)){ 
                     
                    $items = $items->leftJoin('tbl_item_tags', function ($tag) {
                        $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                        //
                    });

                    $items = $items->leftJoin('tbl_brands', function ($brand) {
                        $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                    });
                    $searchKey = filter_search($keyword);
                      
                    $items = $items->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandIdAllow, $price_by, $brandId){
                        foreach ($searchKey as $value) {
                        
                            $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                            
                            // if($empty($brandId)){

                            //     $query->Where('tbl_items.brand_id', $brandId);
                            // }
                            $query->whereIn('tbl_items.brand_id', $brandIdAllow);
                            $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                            if(!empty($price_by)){

                                $query->orderBy('tbl_items.regular_price', $price_by);
                            }
                        }
                        
                    });
                    $items = $items->where(function ($query) use ($searchKey,$priceFrom, $priceTo, $brandIdAllow, $price_by, $brandId) {
                        foreach ($searchKey as $value) {
                            $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                            

                            // $query->Where('tbl_items.brand_id', $brandId);
                            $query->whereIn('tbl_items.brand_id', $brandIdAllow);
                            $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                            if(!empty($price_by)){

                                $query->orderBy('tbl_items.regular_price', $price_by);
                            }
                            // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                            // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                            // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                            
                        }
                    });

                    $items = $items->orWhere(function($query) use ($keyword, $priceFrom, $priceTo, $brandIdAllow, $price_by, $brandId){
                        //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                        $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                        
                        
                        //$query->Where('tbl_items.brand_id', $brandId);
                        $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                        $query->whereIn('tbl_items.brand_id', $brandIdAllow);
                        if(!empty($price_by)){

                            $query->orderBy('tbl_items.regular_price', $price_by);
                        }
                    
                        // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                        
                        // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                        // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                    });

                    if(!empty($priceFrom) && !empty($priceTo)){

                        
                        $items = $items->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    }
                    if(!empty($price_by)){

                        $items = $items->orderBy('tbl_items.regular_price', $price_by);
                    }

                    $items = $items->paginate(9);
                    $items = $items->withPath(url('/category-filter'));

                    

                    if(!empty($priceFrom) && !empty($priceTo)){

                        
                        $items = $items->appends(['priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                    }
                    if(!empty($brandId)){

                        
                        $items = $items->appends(['brandfilter' => $brandId]);
                    }
                    if(!empty($price_by)){

                        
                        $items = $items->appends(['pricefilter' => $price_by]);
                    }

                    if(!empty($keyword)){

                        
                        $items = $items->appends(['keyword' => $keyword]);
                    }
                }else{
                    

                    
                    $items = $items->where('tbl_items.cat_id', $request->catId);
                    

                    if(!empty($brandId)){

                        $items = $items->Where('tbl_items.brand_id', $brandId);
                    }else{
                        $items = $items->whereIn('tbl_items.brand_id', $brandIdAllow);
                    }
                    
                    
                    
                    
                    if(!empty($request->price_by)){
                        //echo $request->price_by;exit('pp');

                        $items = $items->orderBy('tbl_items.regular_price', $request->price_by);
                        
                        // $items = $items->orderBy('tbl_items.regular_price', $request->price_by);
                    }
            
            
                    $items = $items->paginate(9);
                   
                       
                        $items = $items->withPath(url('/items-by-category/'.$request->catId));
                    
                        

                    if(!empty($request->brandId)){

                       
                        $items = $items->appends(['brandfilter' => $request->brandId]);
                    }

                    if(!empty($request->price_by)){
                        $items = $items->appends(['pricefilter' => $request->price_by]);
                    }
                }
           
            //pr($items);
           
            if(count($items)>0){
                $returnView = view('CategoryFilterOption', compact('items'))->render();

                return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
            }else{
                //$returnView = view('CategoryFilterOption', compact('items'))->render();
                return response()->json(array('status' =>2, 
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                //'items' => $items,
                ));

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

        $brandId = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				// $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
				// foreach($customerBrands as $customerBrand){
				// 	$brandId[] = $customerBrand->brand_id;
				// }
                $customerBrandsTotal = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->count();
				
				if($customerBrandsTotal > 0){
					$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
					foreach($customerBrands as $customerBrand){
						$brandId[] = $customerBrand->brand_id;
					}
				}else{

					$brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandId[] = $brandsList->id;
                    }
				}
			}

        $items = get_itemsByCatOrBrandId($flag='', $limit=-1, $request->catOrBrandId, $page='6', $brandId);
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
                    $retailPrice ='';
                    if($item->item_mrp > $item->regular_price){

                        @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
                    }

                    $Price = '';
                    if($totalOff == 0){
                       
                        if($item->regular_price){

                            //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                            if($item->item_mrp){
                               
                                $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>
                                <div class="item-discount-price itm-dpr">MRP: ???'.$item->item_mrp.'</div>';
									
									
                            }else{
                                $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>';
                            }

                        }else{

                            $Price = '<div class="item-price">???0</div>';
                        }
                    }else{

                        $Price ='<div class="item-price itm-pr">Offer Price: ???'.$AfterDiscountPrice.'</div>';
                        $Price .='<div class="item-discount-price itm-dpr">MRP: ???'.$item->item_mrp.'</div>';

                        //$Price .='<div class="item-discount-price itm-dpr">MRP: ???'.$item->regular_price.'</div>';
                    }

                    if($retailPrice){
                        $retailPriceHtml ='<div class="itm-rlm">
                        <span>'.$retailPrice.'%</span> Retail Margin</div>';
                    }else{
                        $retailPriceHtml='';
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
                               '.$retailPriceHtml.'
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
                //'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
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
        // pr($item);
        return $theme->scope('item_detail', compact('item'))->render();

    }

    public function getItemsByCatId(Request $request, $catId)
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

        $brandId = array();
        
        //@$brandIdForCatFilter = session()->get('brandIdForCatFilter');
        @$brandIdForCatFilter = $request->get('brandfilter');

			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
				if(!empty($brandIdForCatFilter)){
                    $brandId[] = $brandIdForCatFilter;
                }
                else if(count($customerBrands) > 0){
                    foreach($customerBrands as $customerBrand){
                        $brandId[] = $customerBrand->brand_id;
                    }
                }else{
                    $brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandId[] = $brandsList->id;
                    }
                }
			}

            
            
            
        //if(!empty($request->brandId)){

        //}
        

           
        $items = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $catId, $page='9', $brandId);
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
        $theme = Theme::uses('default')->layout('layout');
        $brandDetail = DB::table('tbl_brands')->where('id', $BrandId)->first();
        //pr(auth::user());
        if(Auth::user()){
             @$CustomerWiseBrand = CustomerWiseBrand::where('user_id', Auth::user()->id)->where('brand_id', $BrandId)->first();
            @$CustomerWiseBrandTotal = CustomerWiseBrand::where('user_id', Auth::user()->id)->count();
            //if(!empty($CustomerWiseBrand) && $CustomerWiseBrand != NULL){
            if($CustomerWiseBrandTotal == 0){

                $brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='9');
            }else if(!empty($CustomerWiseBrand) && $CustomerWiseBrand != NULL){

                $brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='9');
                
                //$brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='');
                
            }else{
                $brands = array();
            }
        }else{
            $brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='9');
        }
        
        //  var_dump($CustomerWiseBrand);exit;
        // if(!empty($CustomerWiseBrand) && $CustomerWiseBrand != NULL){

        //     $brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='');
        // }else{
        //     $brands = array();
            
            
        // }
        //$brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='');
        //pr($brands);
        //$brands = get_itemsByCatOrBrandId($flag='Brand', $limit=-1, $BrandId, $page='');
       // pr($brands);
        
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
       
       
        if(count($items)>0){
            $returnView = view('CategoryLeftSideFilter', compact('items'))->render();

            return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
        }else{
            //$returnView = view('CategoryFilterOption', compact('items'))->render();
            return response()->json(array('status' =>2, 
            'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
            //'items' => $items,
            ));

        }
       
        //pr($items);
        // if(count($items)>0){
        //     $html = '<div class="item-row">';
            
        //         $i=0;
        //         foreach($items as $item){
        //             if($item->is_visible == 1)
        //             {

        //             $itemImages = get_item_default_img_item_id($item->item_id);

		// 			if($itemImages)
		// 			{

		// 				$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
						
		// 			} else {

		// 				$itemImg = FRONT.'img/product/product-iphone.png';
        //             }
        //             @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
        //             @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
        //             @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
                    
        //             $totalOff = $custCatDiscount + $custClassDiscount;
        //             $retailPrice ='';
        //             if($item->item_mrp > $item->regular_price){

        //                 @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
        //             }

        //             if($totalOff == 0){
                       
        //                 if($item->regular_price){

        //                     //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                        
        //                     if($item->item_mrp){
                               
        //                         $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>
        //                         <div class="item-discount-price itm-dpr">MRP:
        //                                  <span>???'.$item->item_mrp.'</span></div>';
									
									
        //                     }else{
        //                         $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>';
        //                     }

                        
        //                 }else{

        //                     $Price = '<div class="item-price">???0</div>';
        //                 }
        //             }else{

        //                 $Price ='<div class="item-price itm-pr">Offer Price ???'.$AfterDiscountPrice.'</div>'.
        //                 '<div class="item-discount-price itm-dpr">MRP ???'.$item->item_mrp.'</div>';
        //             }

		// 			if($totalOff != 0){
        //                 $offPercenteg = '<div class="discount">'.$totalOff.'% OFF </div>';
                    			
        //             }else{
        //                 $offPercenteg = '';
        //             }

                    
        //                 if($retailPrice){
        //                     $retailMarginHtml = '<div class="itm-rlm">
        //                     <span>'.$retailPrice.'%</span> Retail Margin</div>';
        //                }else{
        //                 $retailMarginHtml='';
        //                }
                    
        //             if(($i != 1) && ($i != 0)&& ($i % 3==0)){

        //                 $html .='</div><div class="item-row">';
        //             }

        //             if(($kyc == "true") && ($login=="true") && $isAdmin != "yes")
        //             {
                        
                        

        //                 $html .='<div class="item item-thumbnail">
        //                     <a href="'.route("productDetail", $item->slug).'" class="item-image">
        //                         <img src="'.$itemImg.'" alt="" />
        //                         '.$offPercenteg.'
        //                     </a>
        //                     <div class="item-info">
        //                         <h4 class="item-title">
        //                         <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
        //                         </h4>
        //                         <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
        //                         '.$Price.'
        //                         '.$retailMarginHtml.'
        //                         <a href="javascript:void();" onclick="add_to_cart('.$item->item_id.')" class="btn btn-inverse">ADD TO CART</a>
        //                     </div>
        //                 </div>';
        //             }else{
                        
                       
        //                 $html .='<div class="item item-thumbnail">
        //                     <a href="'.route("productDetail", $item->slug).'" class="item-image">
        //                         <img src="'.$itemImg.'" alt="" />
        //                         '.$offPercenteg.'
        //                     </a>
        //                     <div class="item-info">
        //                         <h4 class="item-title">
        //                         <a href="'.route("productDetail", $item->slug).'">'.$item->product_name.'</a>
        //                         </h4>
        //                         <p class="item-desc">'.\Str::limit(strip_tags($item->description),100,'...').'</p>
                                
        //                     </div>
        //                 </div>';

        //             }
        //          $i++;   
        //         }
        //     }
        //         $html .='</div>';

        //     $data = array(
        //         'status' => 'success',
        //         'msg' => 'success',
        //         'items' => $items,
        //         'itemHtml' => $html,
                
        //     );
        // }else{
        //     $data = array(
        //         'status' => 'fail',
        //         //'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
        //         'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
        //         'items' => $items,
                
        //     );
        // }
        
        // return($data);


    }

    public function filterByAjaxBrand(Request $request)
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
       
       
        // if(count($items)>0){
        //     $returnView = view('CategoryLeftSideFilter', compact('items'))->render();

        //     return response()->json(array('status' =>1, 'ordeHtml' =>$returnView));
        // }else{
        //     //$returnView = view('CategoryFilterOption', compact('items'))->render();
        //     return response()->json(array('status' =>2, 
        //     'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
        //     //'items' => $items,
        //     ));

        // }
       
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
                    $retailPrice ='';
                    if($item->item_mrp > $item->regular_price){

                        @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
                    }

                    if($totalOff == 0){
                       
                        if($item->regular_price){

                            //$Price = '<div class="item-price">???'.$item->regular_price.'</div>';
                        
                            if($item->item_mrp){
                               
                                $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>
                                <div class="item-discount-price itm-dpr">MRP:
                                         <span>???'.$item->item_mrp.'</span></div>';
									
									
                            }else{
                                $Price = '<div class="item-price itm-pr">Offer Price: ???'.$item->regular_price.'</div>';
                            }

                        
                        }else{

                            $Price = '<div class="item-price">???0</div>';
                        }
                    }else{

                        $Price ='<div class="item-price itm-pr">Offer Price ???'.$AfterDiscountPrice.'</div>'.
                        '<div class="item-discount-price itm-dpr">MRP ???'.$item->item_mrp.'</div>';
                    }

					if($totalOff != 0){
                        $offPercenteg = '<div class="discount">'.$totalOff.'% OFF </div>';
                    			
                    }else{
                        $offPercenteg = '';
                    }

                    
                        if($retailPrice){
                            $retailMarginHtml = '<div class="itm-rlm">
                            <span>'.$retailPrice.'%</span> Retail Margin</div>';
                       }else{
                        $retailMarginHtml='';
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
                                '.$retailMarginHtml.'
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
                //'msg' => '<div class="item-row"><div class="item item-thumbnail">Item not found</div></div>',
                'msg' => '<div class="item-nofound item-row"><h4><i class="fas fa-shopping-basket"></i>Item not found</h4></div>',
                'items' => $items,
                
            );
        }
        
        return($data);


    }

    public function searchKeyword(Request $request)
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

        $brandId = array();
        @$brandIdForCatFilter = $request->get('brandfilter');
        if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
            if(!empty($brandIdForCatFilter)){
                $brandId[] = $brandIdForCatFilter;
            }
            else if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }else{
                $brandsListArr = DB::table('tbl_brands')->get();
                foreach($brandsListArr as $brandsList){
                    $brandId[] = $brandsList->id;
                }
            }
        }

			// if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
			// 	// $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
			// 	// foreach($customerBrands as $customerBrand){
			// 	// 	$brandId[] = $customerBrand->brand_id;
			// 	// }
            //     $customerBrandsTotal = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->count();
				
			// 	if($customerBrandsTotal > 0){
			// 		$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
			// 		foreach($customerBrands as $customerBrand){
			// 			$brandId[] = $customerBrand->brand_id;
			// 		}
			// 	}else{

			// 		$brandsListArr = DB::table('tbl_brands')->get();
            //         foreach($brandsListArr as $brandsList){
            //             $brandId[] = $brandsList->id;
            //         }
			// 	}
			// }

        $keyword = $request->query('keyword');
        if( $request->has('keyword') && !empty($keyword) ) 
        {
            
            // $items = searching($limit='-1', $keyword=$keyword, $page='9');
            $items = searching($limit='-1', $keyword=$keyword, $page='9', $brandId);
            // $items = searching($limit='-1', $keyword=$keyword, $page='');

            
        }else{

            $items =array();
           
        }
        //pr($items);
        $theme = Theme::uses('default')->layout('layout');
            
        return $theme->scope('search', compact('items','keyword'))->render();
    }

    public function searchKeywordFilter(Request $request)
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

        $brandId = array();
        @$brandIdForCatFilter = $request->get('brandfilter');
        if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
            if(!empty($brandIdForCatFilter)){
                $brandId[] = $brandIdForCatFilter;
            }
            else if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }else{
                $brandsListArr = DB::table('tbl_brands')->get();
                foreach($brandsListArr as $brandsList){
                    $brandId[] = $brandsList->id;
                }
            }
        }

			

        $keyword = $request->query('keyword');
        @$priceFrom =  $request->query('priceFrom');
            @$priceTo =  $request->query('priceTo');
         
        if( $request->has('keyword') && !empty($keyword) ) 
        {
           
            // $items = searching($limit='-1', $keyword=$keyword, $page='9');
            //$items = searching($limit='-1', $keyword=$keyword, $page='9', $brandId);
            // $items = searching($limit='-1', $keyword=$keyword, $page='');

            
    $searchKey = filter_search($keyword);
    //$searchValues = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
    //$columns = ['title', 'subtitle', 'description'];
     //pr($searchValues);
   
           $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

                //end attr
                ->leftJoin('tbl_item_tags', function ($tag) {
                    $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                    
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )
                

           ->Where('tbl_items.is_visible', 1)
           
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
               
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

            // $request->query('priceFrom');
            
            
            //if(!empty($priceFrom) && !empty($priceTo)){
                
                $datas = $data->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
                // $datas = $data->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
            //}

            // @$brandIdForCatFilter =  $request->query('brandfilter');
                    
            //         if(!empty($brandIdForCatFilter)){

            //             $datas = $data->Where('tbl_items.brand_id', $brandIdForCatFilter);
            //         }

                    
                    // @$orderByPriceForCatFilter =  $request->query('pricefilter');
                   
                    // if(!empty($orderByPriceForCatFilter)){
                        

                    //     $datas = $data->orderBy('tbl_items.regular_price', $orderByPriceForCatFilter);
                        
                    // }
                   
                  
                 
                    // $datas = $data->get();
                   
            
                
                $datas = $data->paginate(9);
                // if(!empty($brandIdForCatFilter)){
                //     $datas->appends(['brandfilter' => $brandIdForCatFilter]);
                // }

                // if(!empty($orderByPriceForCatFilter)){
                //     $datas->appends(['pricefilter' => $orderByPriceForCatFilter]);
                // }

                if(!empty($priceFrom) && !empty($priceTo)){
                    $datas->appends(['priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                }


            
            
                 
    
            
        }else{

            $items =array();
           
        }
        $items = $datas;
        //pr($items);
        $theme = Theme::uses('default')->layout('layout');
            
        return $theme->scope('search', compact('items','keyword'))->render();
    }
    
    public function searchKeywordCategoryFilter(Request $request)
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

        $brandId = array();
        @$pricefilterCat = $request->get('pricefilter');
        @$brandIdForCatFilter = $request->get('brandfilter');
        if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
            if(!empty($brandIdForCatFilter)){
                $brandId[] = $brandIdForCatFilter;
            }
            else if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }else{
                $brandsListArr = DB::table('tbl_brands')->get();
                foreach($brandsListArr as $brandsList){
                    $brandId[] = $brandsList->id;
                }
            }
        }

		

        @$keyword = $request->query('keyword');
        @$priceFrom =  $request->query('priceFrom');
        @$priceTo =  $request->query('priceTo');
         
        if( $request->has('keyword') && !empty($keyword) ) 
        {
           
            // $items = searching($limit='-1', $keyword=$keyword, $page='9');
            //$items = searching($limit='-1', $keyword=$keyword, $page='9', $brandId);
            // $items = searching($limit='-1', $keyword=$keyword, $page='');

            
    $searchKey = filter_search($keyword);
    //$searchValues = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
    //$columns = ['title', 'subtitle', 'description'];
     //pr($searchValues);
   
           $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

                //end attr
                ->leftJoin('tbl_item_tags', function ($tag) {
                    $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                    
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )
                

           ->Where('tbl_items.is_visible', 1)
           
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandId){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                }
                if(count($brandId) > 0){
                    $query->whereIn('tbl_items.brand_id', $brandId);
                    }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo, $brandId) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    

                    if(count($brandId) > 0){
                        $query->whereIn('tbl_items.brand_id', $brandId);
                    }
                    
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo, $brandId){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);

                if(count($brandId) > 0){
                $query->whereIn('tbl_items.brand_id', $brandId);
                }
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

            // $request->query('priceFrom');
            
            
            //if(!empty($priceFrom) && !empty($priceTo)){
                
                $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                
               
                
                // $datas = $data->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
            //}

            // @$brandIdForCatFilter =  $request->query('brandfilter');
                    
            //         if(!empty($brandIdForCatFilter)){

            //             $datas = $data->Where('tbl_items.brand_id', $brandIdForCatFilter);
            //         }

                    
                    // @$orderByPriceForCatFilter =  $request->query('pricefilter');
                   
                    if(!empty($pricefilterCat)){
                        

                        $datas = $data->orderBy('tbl_items.regular_price', $pricefilterCat);
                        
                    }
                   
                  
                 
                    // $datas = $data->get();
                   
            
                
                $datas = $data->paginate(9);
                
                if(!empty($brandIdForCatFilter)){
                    $datas->appends(['brandfilter' => $brandIdForCatFilter]);
                }

                if(!empty($pricefilterCat)){
                    $datas->appends(['pricefilter' => $pricefilterCat]);
                }

                if(!empty($priceFrom) && !empty($priceTo)){
                    
                    $datas->appends(['keyword'=>$keyword, 'priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                }


            
            
                 
    
            
        }else{

            $items =array();
           
        }
        $items = $datas;
        //pr($items);
        $theme = Theme::uses('default')->layout('layout');
            
        return $theme->scope('productsByCategory', compact('items','keyword'))->render();
    }

    public function searchKeywordBrandFilter(Request $request)
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

        $brandId = array();
        @$brandIdForBrandFilter = $request->get('brandId');
        if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
            if(!empty($brandIdForBrandFilter)){
                $brandId[] = $brandIdForBrandFilter;
            }
            else if(count($customerBrands) > 0){
                foreach($customerBrands as $customerBrand){
                    $brandId[] = $customerBrand->brand_id;
                }
            }else{
                $brandsListArr = DB::table('tbl_brands')->get();
                foreach($brandsListArr as $brandsList){
                    $brandId[] = $brandsList->id;
                }
            }
        }

			

        @$keyword = $request->query('keyword');
        @$priceFrom =  $request->query('priceFrom');
            @$priceTo =  $request->query('priceTo');
         
        if( $request->has('keyword') && !empty($keyword) ) 
        {
           
            // $items = searching($limit='-1', $keyword=$keyword, $page='9');
            //$items = searching($limit='-1', $keyword=$keyword, $page='9', $brandId);
            // $items = searching($limit='-1', $keyword=$keyword, $page='');

            
    $searchKey = filter_search($keyword);
    //$searchValues = preg_split('/\s+/', $keyword, -1, PREG_SPLIT_NO_EMPTY);
    //$columns = ['title', 'subtitle', 'description'];
     //pr($searchValues);
   
           $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

                //end attr
                ->leftJoin('tbl_item_tags', function ($tag) {
                    $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                    
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )
                

           ->Where('tbl_items.is_visible', 1)
           
            //->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandIdForBrandFilter){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $query->where('tbl_items.brand_id', $brandIdForBrandFilter);
                }
                
            })
            ->where(function ($query) use ($searchKey,$priceFrom, $priceTo, $brandIdForBrandFilter) {
                foreach ($searchKey as $value) {
                    $query->orWhere('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_items.description', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_brands.name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    $query->orWhere('tbl_item_category.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    
                    $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                    $query->where('tbl_items.brand_id', $brandIdForBrandFilter);
                    // $query->orWhere('tbl_items.item_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    // $query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    // $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    
                }
            })

            ->orWhere(function($query) use ($keyword, $priceFrom, $priceTo, $brandIdForBrandFilter){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                
                $query->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                $query->where('tbl_items.brand_id', $brandIdForBrandFilter);
               
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

            // $request->query('priceFrom');
            
            
            //if(!empty($priceFrom) && !empty($priceTo)){
                
                $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                
                
                // $datas = $data->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
            //}

            // @$brandIdForCatFilter =  $request->query('brandfilter');
                    
            //         if(!empty($brandIdForCatFilter)){

            //             $datas = $data->Where('tbl_items.brand_id', $brandIdForCatFilter);
            //         }

                    
                    // @$orderByPriceForCatFilter =  $request->query('pricefilter');
                   
                    // if(!empty($orderByPriceForCatFilter)){
                        

                    //     $datas = $data->orderBy('tbl_items.regular_price', $orderByPriceForCatFilter);
                        
                    // }
                   
                  
                 
                    // $datas = $data->get();
                   
            
                
                $datas = $data->paginate(9);
                // if(!empty($brandIdForCatFilter)){
                //     $datas->appends(['brandfilter' => $brandIdForCatFilter]);
                // }

                // if(!empty($orderByPriceForCatFilter)){
                //     $datas->appends(['pricefilter' => $orderByPriceForCatFilter]);
                // }

                if(!empty($priceFrom) && !empty($priceTo)){
                    $datas->appends(['brandId'=> $brandIdForBrandFilter, 'keyword'=>$keyword, 'priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                }


            
            
                 
    
            
        }else{

            $items =array();
            

            $items =array();
            $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                })
               

                //end attr
                ->leftJoin('tbl_item_tags', function ($tag) {
                    $tag->on('tbl_item_tags.item_id', '=', 'tbl_items.item_id');
                    
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name' 
                    )
                

           
           
            //->limit($limit)
            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

            
                
                $datas = $data->whereBetween('tbl_items.item_mrp', [$priceFrom, $priceTo]);
                
                $datas = $data->paginate(9);
               

                if(!empty($priceFrom) && !empty($priceTo)){
                    $datas->appends(['brandId'=> $brandIdForBrandFilter, 'keyword'=>$keyword, 'priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                }

            //$datas =array();
           
        
           
        }
        $brands = $datas;
        $brandDetail = DB::table('tbl_brands')->where('id', $brandIdForBrandFilter)->first();
        //pr($items);
        $theme = Theme::uses('default')->layout('layout');
            
        return $theme->scope('productsByBrand', compact('brands','keyword','brandDetail'))->render();
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

    public function getItemsByCatOrBrandIdByAjaxForPaginationOnClickCat(Request $request)
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

        $brandId = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				// $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
				// foreach($customerBrands as $customerBrand){
				// 	$brandId[] = $customerBrand->brand_id;
				// }
                $customerBrandsTotal = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->count();
				
				if($customerBrandsTotal > 0){
					$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
					foreach($customerBrands as $customerBrand){
						$brandId[] = $customerBrand->brand_id;
					}
				}else{

					$brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandId[] = $brandsList->id;
                    }
				}
			}
            
            
            if(!empty($request->pageNo)){
                $pageNum = $request->pageNo;
            }else{
                $pageNum = 1;
            }

            if(!empty($request->catId)){
               $categoryOrBrand= $request->catId;
            }else{
                $categoryOrBrand= '';
            }


        $items = get_itemsByCatOrBrandIdForPagination($flag=$request->flag, $catOrBrandId=$categoryOrBrand, $pageNo=$pageNum, $perPageLimit=$request->perPageLimit, $brandId);
        // $items = get_itemsByCatOrBrandId($flag='', $limit=-1, $request->catOrBrandId, $page='6', $brandId);
        //pr($items);
       
       
       
				$itemsAll = get_itemsByCatOrBrandIdPaginateAllItem($flag=$request->flag, $limit=-1, $catOrBrandId=$categoryOrBrand, $page='', $brandId);
				
                $per_page_limit = 6;
				$totalPage = ceil(count($itemsAll) /$per_page_limit);

                $pageNoPriv = $pageNum;
                $pageNoPriv = $pageNoPriv-1;
                if($pageNoPriv >= 1 && $pageNoPriv < $pageNum){

                    $paramForPriv = "flag='$request->flag', catId='$categoryOrBrand', pageNo=$pageNoPriv, perPageLimit=$per_page_limit";
                   
                    $paginateHtml = '<li class="page-item" onclick="paginationCategoyOnClick('.$paramForPriv.')"><a href="javascript:;" class="page-link"><</a></li>';
                }else{
                    $paginateHtml = '<li class="page-item"><a href="javascript:;" class="page-link"><</a></li>';

                }

				
               
					for($p=1; $p<=$totalPage; $p++){
                        if($pageNum == $p){
                            $active ='active';
                        }else{
                            $active ='';
                        }
                        $param = "flag='$request->flag', catId='$categoryOrBrand', pageNo=$p, perPageLimit=$per_page_limit";
                        // $paginateHtml .= '<a class="cdp_i" href="#!'.$p.'" onclick="paginationCategoy('.$param.')">'. $p .'</a>';
					    // $paginateHtml .= '<li class="page-item '.$active.'" onclick="paginationCategoy('.$param.')"><a class="page-link" href="javascript:;">'. $p .'</a></li>';
					
					     $paginateHtml .= '<li class="page-item '.$active.'" onclick="paginationCategoyOnClick('.$param.')"><a class="page-link" href="javascript:;">'. $p .'</a></li>';
					}
                    $pageNoNext = $pageNum;
                    $pageNoNext = $pageNoNext+1;
                    if($pageNoNext <= $totalPage){

                        $paramForNext = "flag='$request->flag', catId='$categoryOrBrand', pageNo=$pageNoNext, perPageLimit=$per_page_limit";
                        $paginateHtml .= '<li class="page-item" onclick="paginationCategoyOnClick('.$paramForNext.')"><a class="page-link" href="javascript:;">></a></li>';
                    }else{
                        $paginateHtml .= '<li class="page-item"><a class="page-link" href="javascript:;">></a></li>';

                    }
        $returnViewPaginateFile = view('test_pagination', compact('items'))->render();

        return response()->json(array('success' => true, 'ordeHtml' => $returnViewPaginateFile, 'paginateHtml' => $paginateHtml));
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

        $brandId = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				// $customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
				// foreach($customerBrands as $customerBrand){
				// 	$brandId[] = $customerBrand->brand_id;
				// }
                $customerBrandsTotal = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->count();
				
				if($customerBrandsTotal > 0){
					$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
					foreach($customerBrands as $customerBrand){
						$brandId[] = $customerBrand->brand_id;
					}
				}else{

					$brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandId[] = $brandsList->id;
                    }
				}
			}
            
            
            if(!empty($request->pageNo)){
                $pageNum = $request->pageNo;
            }else{
                $pageNum = 1;
            }

            if(!empty($request->catId)){
               $categoryOrBrand= $request->catId;
            }else{
                $categoryOrBrand= '';
            }


        $items = get_itemsByCatOrBrandIdForPagination($flag=$request->flag, $catOrBrandId=$categoryOrBrand, $pageNo=$pageNum, $perPageLimit=$request->perPageLimit, $brandId);
        // $items = get_itemsByCatOrBrandId($flag='', $limit=-1, $request->catOrBrandId, $page='6', $brandId);
        //pr($items);
        $paginateHtml = '';
        // $paginateHtml = '<a href="#!-1" class="cdp_i">prev</a>';
        //echo $categoryOrBrand;exit;
				$itemsAll = get_itemsByCatOrBrandIdPaginateAllItem($flag=$request->flag, $limit=-1, $catOrBrandId=$categoryOrBrand, $page='', $brandId);
				// $itemsAll = get_items($flag = 'Category', $limit = -1, $brandId);
					//pr($itemsAll);	
				$per_page_limit = 6;
				$totalPage = ceil(count($itemsAll) /$per_page_limit);
               
					for($p=1; $p<=$totalPage; $p++){
                        if($pageNum == $p){
                            $active ='active';
                        }else{
                            $active ='';
                        }
                        $param = "flag='$request->flag', catId='$categoryOrBrand', pageNo=$p, perPageLimit=$per_page_limit";
                        // $paginateHtml .= '<a class="cdp_i" href="#!'.$p.'" onclick="paginationCategoy('.$param.')">'. $p .'</a>';
					    $paginateHtml .= '<li class="page-item '.$active.'" onclick="paginationCategoy('.$param.')"><a class="page-link" href="javascript:;">'. $p .'</a></li>';
					
					    // $paginateHtml .= '<li class="page-item '.$active.'" onclick="paginationCategoy('.$param.')"><a class="page-link" href="javascript:;">'. $p .'</a></li>';
					}
                    // $paginateHtml .= '<a href="#!+1" class="cdp_i">next</a>';
        $returnViewPaginateFile = view('test_pagination', compact('items'))->render();

        return response()->json(array('success' => true, 'ordeHtml' => $returnViewPaginateFile, 'paginateHtml' => $paginateHtml));
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


    public function getItemOnClickCarausel(Request $request)
    {
        //pr($request->all());
        
        
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

        $brandId = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				
                $customerBrandsTotal = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->count();
				
				if($customerBrandsTotal > 0){
					$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
					foreach($customerBrands as $customerBrand){
						$brandId[] = $customerBrand->brand_id;
					}
				}else{

					$brandsListArr = DB::table('tbl_brands')->get();
                    foreach($brandsListArr as $brandsList){
                        $brandId[] = $brandsList->id;
                    }
				}
			}
            
            
            if(!empty($request->pageNo)){
                $pageNum = $request->pageNo;
            }else{
                $pageNum = 1;
            }

            

            //$items = get_items($flag = '', $limit = 6, $brandId);
            
        $items = getItemOnClickCarausel($pageNo=$pageNum, $perPageLimit=$request->perPageLimit, $brandId);
        
        $returnViewPaginateFile = view('appendItemClickOnCarausel', compact('items','pageNum'))->render();

        return response()->json(array('success' => true, 'ordeHtml' => $returnViewPaginateFile));

            
    }
}
