<?php 
function getDateFormat()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getDateFormat(); 
}

function getUnderGroup()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getUnderGroup(); 
}

function getItemCategory()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getItemCategory(); 
}
function getItemCategoryForGroup()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getItemCategoryForGroup(); 
}

function getBarnds()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getBarnds(); 
}

function getBarndsByCustomer($brandId)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getBarndsByCustomer($brandId); 
}

function getCountry()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getCountry(); 
} 

function getCountryByCountryId($country_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getCountryByCountryId($country_id); 
}

function statesByCountry($country_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->statesByCountry($country_id); 
}

function cityesByState($state_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->cityesByState($state_id); 
}

function get_cityNameByCityId($city_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_cityNameByCityId($city_id); 
}


function get_stateNameByStateId($state_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_stateNameByStateId($state_id); 
}



function get_banners()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_banners(); 
}

function get_group_by_g_id($g_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_group_by_g_id($g_id); 
}

function get_gallery_img_by_item_id($item_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_gallery_img_by_item_id($item_id); 
}

function get_item_detail_by_item_id($item_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_item_detail_by_item_id($item_id); 
}

function get_item_by_item_id($item_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_item_by_item_id($item_id); 
}

function get_group_category_cat_id($cat_id)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->get_group_category_cat_id($cat_id); 
}

//taxation dd
function getTaxAppliedByProductID($customerID,$itemID,$itemQTY)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getTaxAppliedByProductID($customerID,$itemID,$itemQTY); 
}

function getRetailPrice($customerID,$itemID,$AfterDiscountPrice,$itemQTY)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getRetailPrice($customerID,$itemID,$AfterDiscountPrice,$itemQTY); 
}
//applied discount  dd
function getDiscountAppliedByProductID($customerID,$itemID,$itemQTY)
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getDiscountAppliedByProductID($customerID,$itemID,$itemQTY); 
}


// function get_items1($flag=null)
// {
//     $obj = app('App\EComGeneralSettings');
//     return $obj->get_items($flag=null); 
// }

function get_items($flag='', $limit=-1, $brandId = array())
    {
        
        switch ($flag) {
           
            case 'Brand':   //By Brands
                $data = DB::table('tbl_items')

                        ->leftJoin('tbl_brands', function ($brand) {
                            $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');

                        })
                        ->select('tbl_items.*')
                        ->orderBy('tbl_items.brand_id', 'asc')
                        ->Where('tbl_items.is_visible', 1)
                         ->limit($limit);
                        if(count($brandId) > 0){
                            $data = $data->whereIn('tbl_items.brand_id', $brandId);
                        }
                        $data = $data->get();
                         //->get();
                         
                break;

            case 'Category':   //By Category
                $data = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                            
                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                    //->orderBy('tbl_items.item_id', 'desc')
                    ->orderByRaw('IF(priority = 1, null, 0)')
                    ->Where('tbl_items.is_visible', 1)
                    ->limit($limit);
                    if(count($brandId) > 0){
                        $data = $data->whereIn('tbl_items.brand_id', $brandId);
                    }
                    $data = $data->get();
                    //$data = $data->paginate(6);
                    // ->paginate(6);
                // ->get();
                break;

            default:
                $data = DB::table('tbl_items')
                 ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_brands', function ($brand) {
                    $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');

                })
                // ->Join('customer_wise_brands', function ($brand) {
                //     $brand->on('customer_wise_brands.brand_id', '=', 'tbl_items.brand_id');
                // })
                ->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })
                ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                    )
                    ->Where('tbl_items.is_visible', 1)
                    //->where('tbl_items.brand_id', [1,6])
                     
                    //->Where('customer_wise_brands.brand_id', 1)
            ->orderBy('tbl_items.item_id', 'desc')
            ->limit($limit);
        

            if(count($brandId) > 0){
                $data = $data->whereIn('tbl_items.brand_id', $brandId);
            }
            $data = $data->get();
        
        
        }
        
        return $data;


    }

function relatedCatItems($itemCatId, $limit=-1, $skipItemId=0)
    {
      
        $data = DB::table('tbl_items')
            ->leftJoin('tbl_item_category', function ($joinItemCat) {
                    $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                    
                })->leftJoin('tbl_group', function ($group) {
                    $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
            
                })
                // ->leftJoin('tbl_item_orders', function ($order) {
                //     $order->on('tbl_item_orders.item_id', '=', 'tbl_items.item_id');
                //     //$order->count('tbl_item_orders.order_id');
                   
            
                // })
                // ->selectRaw('tbl_item_orders.*, count(tbl_item_orders.order_id) as totalItemCount')
                ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                    )
                
            ->orderBy('item_order_count', 'desc')
            ->Where('tbl_items.is_visible', 1)
            
            ->Where('tbl_items.cat_id', $itemCatId)
            ->Where('tbl_items.item_id','!=', $skipItemId)
            //->limit($limit)
            ->get();
               //pr($data);
        return $data;


    }

function frequentlyBoughtitems($itemId)
    {
      
        $data = DB::table('tbl_items')
            ->select('tbl_items.*', 'tbl_items.item_name as product_name')
                
           
            ->Where('tbl_items.is_visible', 1)
            
            //->Where('tbl_items.cat_id', $itemCatId)
            //->Where('tbl_items.item_id','!=', $skipItemId)
            ->Where('tbl_items.item_id', $itemId)
            //->limit($limit)
            ->first();
               //pr($data);
        return $data;


    }

function get_itemsByCatOrBrandIdForTest($flag='', $limit=-1, $catOrBrandId='', $page='', $item_under_group_id='')
{
    $page = (int) $page;
        
        $containsKey = Str::contains($catOrBrandId, '_');
        $id = $catOrBrandId;
        
        if($containsKey){

            $catOrBrand = explode('_', $catOrBrandId);
            $by = $catOrBrand[0];
            $id = $catOrBrand[1];
            $flag = $by;
            //$limit= 6;

        }
    $data = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                    ->orderBy('tbl_items.item_id', 'desc')
                    ->where('tbl_items.cat_id', $id)
                    ->Where('tbl_items.is_visible', 1)
                    //->Where('tbl_group.g_id', 24)
                    //->distinct()
                    ->limit(10);
                    $datas = $data->get();
                        
                    // if(!empty($page)){
                        
                    //     $datas = $data->paginate($page);
                    // }
                    return $datas;
                   //pr($datas);

}





// function get_itemsByCatOrBrandId($flag='', $limit=-1, $catOrBrandId='', $page='', $brandId = array(), $filterByBrandId="", $OrderByPrice="")
function get_itemsByCatOrBrandId($flag='', $limit=-1, $catOrBrandId='', $page='', $brandId = array())
    {
       
        $page = (int) $page;
        
        $containsKey = Str::contains($catOrBrandId, '_');
        $id = $catOrBrandId;
        
        if($containsKey){

            $catOrBrand = explode('_', $catOrBrandId);
            $by = $catOrBrand[0];
            $id = $catOrBrand[1];
            $flag = $by;
            //$limit= 6;

        }
        
        //echo $flag;exit;
        switch ($flag) {
           
            case 'Brand':   //By Brands
                $data = DB::table('tbl_items')

                        ->leftJoin('tbl_brands', function ($brand) {
                            $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                            
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name')
                        ->where('tbl_items.brand_id', $id)
                        ->orderBy('tbl_items.item_id', 'desc')
                        ->Where('tbl_items.is_visible', 1)
                        ->limit($limit);

                        if(count($brandId) > 0){
                            $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                        }
                        //$datas = $data->get();

                    $datas = $data->get();
                        
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                    }

                        
                break;

            case 'Category':   //By Category
                
                $data = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                    
                    ->where('tbl_items.cat_id', $id)
                    ->Where('tbl_items.is_visible', 1)
                    //->Where('tbl_group.g_id', $item_under_group_id)
                    //->distinct('tbl_group.g_name')
                    ->limit($limit);

                    

                    if(count($brandId) > 0){
                        $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                    }
                    

                    
                    @$brandIdForCatFilter = Request::get('brandfilter');
                    
                    if(!empty($brandIdForCatFilter)){

                        $datas = $data->Where('tbl_items.brand_id', $brandIdForCatFilter);
                    }

                    
                    @$orderByPriceForCatFilter = Request::get('pricefilter');
                   
                    if(!empty($orderByPriceForCatFilter)){
                        

                        $datas = $data->orderBy('tbl_items.regular_price', $orderByPriceForCatFilter);
                        
                    }else{
                        $datas = $data->orderBy('tbl_items.item_id', 'desc');
                    }
                   
                  
                 
                    // $datas = $data->get();
                   
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                        if(!empty($brandIdForCatFilter)){
                            $datas->appends(['brandfilter' => $brandIdForCatFilter]);
                        }

                        if(!empty($orderByPriceForCatFilter)){
                            $datas->appends(['pricefilter' => $orderByPriceForCatFilter]);
                        }

                            //$querystringArray = ['brandfilter' => $brandIdForCatFilters, 'pricefilter' => $orderByPriceForCatFilters];
                        //}
                        //$querystringArray = ['brand' => $brandIdForCatFilters, 'price' => $orderByPriceForCatFilters];

                        //$datas->appends($querystringArray);
                    }else{
                        $datas = $data->get();
                    }
                    // echo $limit;
                    // echo $catOrBrandId;
                    //        pr($datas);
                   
                break;

            default:
                
                $data = DB::table('tbl_items')
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

                ->orderBy('tbl_items.item_id', 'desc')
                ->Where('tbl_items.is_visible', 1)
                ->limit($limit);

                if(count($brandId) > 0){
                    $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                }

                    $datas = $data->get();
                        
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                    }

                
        }
        
        return $datas;


    }


    
function filter($flag='', $limit='-1', $keyword='', $priceFrom='', $priceTo='', $page='')
{
    $page = (int) $page;
    $searchKey = filter_search($keyword);
    switch ($flag) {
           
        case 'Brand':   //By Brands
            $data = DB::table('tbl_items')

                    ->leftJoin('tbl_brands', function ($brand) {
                        $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                        
                    })
                    ->select('tbl_items.*', 'tbl_items.item_name as product_name')
                    
                    ->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo])
                    ->Where('tbl_items.item_name', 'like', '%' .$keyword . '%')
                    ->orderBy('tbl_items.item_id', 'desc')
                    ->Where('tbl_items.brand_id', '!=', '0')
                    ->Where('tbl_items.is_visible', 1)
                    ->limit($limit);

                $datas = $data->get();
                    
                if(!empty($page)){
                    
                    $datas = $data->paginate($page);
                }

                
            break;

        case 'Category':   //By Category
            
            $data = DB::table('tbl_items')
                ->leftJoin('tbl_item_category', function ($joinItemCat) {
                        $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                    })->leftJoin('tbl_group', function ($group) {
                        $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                
                    })
                    ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                        )

                ->orderBy('tbl_items.item_id', 'desc')
                ->Where('tbl_items.is_visible', 1)
                ->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo])
                ->Where('tbl_items.item_name', 'like', '%' .$keyword . '%')
                ->Where('tbl_items.cat_id', '!=', '0')
                ->limit($limit);
                $datas = $data->get();
                    
                if(!empty($page)){
                    
                    $datas = $data->paginate($page);
                }
                
                
                
               
            break;

        default:
            
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
            ->limit($limit)
            ->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo])

            ->Where(function($query) use ($searchKey){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                   
                }
                
            })
            ->where(function ($query) use ($searchKey) {
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
            })

            ->orWhere(function($query) use ($keyword){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })

            

            
            
            
            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            //->Where('tbl_items.item_name', 'like', '%' .$keyword . '%');
                
                    
                if(!empty($page)){
                    
                    $datas = $data->paginate($page);
                }else{
                    $datas = $data->get();
                }

            
    }

       
    
    return $datas;
}

function searching($limit='-1', $keyword, $page='', $brandId = array())
{
    //DB::enableQueryLog();
    $page = (int) $page;

    @$priceFrom = Request::get('priceFrom');
    @$priceTo = Request::get('priceTo');
    @$brandIdForCatFilter = Request::get('brandfilter');
    @$orderByPriceForCatFilter = Request::get('pricefilter');

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
           
            ->limit($limit)
            

            ->Where(function($query) use ($searchKey, $priceFrom, $priceTo, $brandIdForCatFilter, $orderByPriceForCatFilter){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'RLIKE', '[[:<:]]'.$value.'[[:>:]]');
                    //$query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                   
                }


                if(!empty($priceFrom) && !empty($priceTo)){
                
                    $query->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
                }
    
                if(!empty($brandIdForCatFilter)){
    
                    $query->Where('tbl_items.brand_id', $brandIdForCatFilter);
                }
    
                if(!empty($orderByPriceForCatFilter)){
                
    
                    $query->orderBy('tbl_items.regular_price', $orderByPriceForCatFilter);
                
                }
                
            })
            ->where(function ($query) use ($searchKey) {
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
            })

            ->orWhere(function($query) use ($keyword){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'RLIKE', '[[:<:]]'.$keyword.'[[:>:]]');
                // $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                
                // $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                // $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            })
            

           
            // ->where(function ($query) use ($searchValues) {
            // foreach ($searchValues as $value) {
            //     $query->orWhere('tbl_items.item_name', 'like', "%{$value}% ");
            // }
            // })
            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

            
            
           

            if(!empty($priceFrom) && !empty($priceTo)){
                
                $datas = $data->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo]);
            }

            if(!empty($brandIdForCatFilter)){

                $datas = $data->Where('tbl_items.brand_id', $brandIdForCatFilter);
            }

            if(!empty($orderByPriceForCatFilter)){
            

                $datas = $data->orderBy('tbl_items.regular_price', $orderByPriceForCatFilter);
            
            }
                   
                  
                 
                    // $datas = $data->get();
                   
            if(!empty($page)){
                
                $datas = $data->paginate($page)->onEachSide(0);
                if(!empty($brandIdForCatFilter)){
                    $datas->appends(['brandfilter' => $brandIdForCatFilter]);
                }

                if(!empty($orderByPriceForCatFilter)){
                    $datas->appends(['pricefilter' => $orderByPriceForCatFilter]);
                }

                if(!empty($priceFrom) && !empty($priceTo)){
                    $datas->appends(['priceFrom' => $priceFrom, 'priceTo'=>$priceTo]);
                }


            
            }else{
                $datas = $data->get();
            }
                 
           
            //pr(DB::getQueryLog());
            // pr($datas->toArray());
            //pr($datas);
            return $datas;
    

}




// function searching($limit='-1', $keyword, $page='', $brandId = array())
function searching_old_server($limit='-1', $keyword, $page='', $brandId = array())
{
//    pr($brandId);
    $page = (int) $page;
    // //echo $page;exit;
    $searchKey = filter_search($keyword);
    // pr($searchKey);
   
           $data = DB::table('tbl_items')
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

            //->orderBy('tbl_items.item_name')
            // ->orderByRaw('tbl_items.item_name', $keyword)
            
            ->Where('tbl_items.is_visible', 1)
            ->limit($limit)
            
            //->distinct('tbl_item_tags.item_id')
            //->whereBetween('tbl_items.regular_price', [$priceFrom, $priceTo])

            // ->Where(function($query) use ($keyword){
            //     $query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
            //     $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
            //     $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
            //     $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
            //     $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
            //     $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
            // })

            ->Where(function($query) use ($searchKey){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'like', "%{$value}%");
                   
                }
                
            })
           
            ->Where(function($query) use ($searchKey){
                foreach ($searchKey as $value) {
                   
                    $query->Where('tbl_items.item_name', 'like', "%{$value}%");
                    $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
                    $query->orWhere('tbl_items.description', 'like', "%{$value}%");
                    //$query->orWhere('tbl_brands.name', 'like', "%{$value}%");
                    $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', "%{$value}%");
                    $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
                    $query->orWhere('tbl_group.g_name', 'like', "%{$value}%");
                    
                   
                }

                
            })

            ->orWhere(function($query) use ($keyword){
                //$query->Where('tbl_items.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                //$query->orWhere('tbl_brands.name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_item_category.item_name', 'like', '%' . $keyword . '%');
                $query->orWhere('tbl_group.g_name', 'like', '%' . $keyword . '%');
                
            })

            
            
            
            // ->where(function($query) use ($searchKey){
            //     foreach ($searchKey as $value) {
                   
            //         $query->Where('tbl_items.item_name', 'like', "%{$value}%");
            //         $query->orWhere('tbl_item_tags.tag_name', 'like', "%{$value}%");
            //         $query->orWhere('tbl_items.description', 'like', "%{$value}%");
            //         $query->orWhere('tbl_attribute_options.attribute_option_name', 'like', "%{$value}%");
            //         $query->orWhere('tbl_item_category.item_name', 'like', "%{$value}%");
            //         $query->orWhere('tbl_group.g_name', 'like', "%{$value}%");
            //     }
            // })
           
        // $products = Products::where(function ($q) use ($search) {
        //     foreach ($search as $value) {
        //         $q->orWhere('name', 'like', "%{$value}%");
        //         $q->orWhere('description', 'like', "%{$value}%");
        //     }
        // })
            // ->Where('tbl_items.item_name', 'like', '%' . $keyword . '%')
            // ->orWhere('tbl_item_tags.tag_name', 'like', '%' . $keyword . '%')
            // ->orWhere('tbl_items.description', 'like', '%' . $keyword . '%');
                
            ->Where('tbl_items.is_visible', 1)
            ->distinct('tbl_items.item_id');
            if(count($brandId) > 0){
                $datas = $data->whereIn('tbl_items.brand_id', $brandId);
            }

                $datas = $data->get();
                   //pr($datas); 
                if(!empty($page)){
                    
                    $datas = $data->paginate($page);
                }
                // pr($datas->toArray());
                //pr($datas);
            return $datas;
    

}

function getItemAttributes()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getItemAttributes(); 
}

function pr($arr)
{
    echo "<pre>";print_r($arr);exit;
    
}

function get_attribute_by_id($id)
{
    $attribute = DB::table('tbl_attributes')->where('id', $id)->first();
    
    return json_decode(json_encode($attribute), true);
}

function getInprocessItemCountByOrderId($orderNumber)
{
    $InprocessItem = DB::table('tbl_item_orders')->where('order_id', $orderNumber)->where('is_Inprocess', 1)
    ->where('is_packed', 0)
    ->count();
    
    return $InprocessItem;
}

function getPackedItemCountByOrderId($orderNumber)
{
    $PackedItem = DB::table('tbl_item_orders')->where('order_id', $orderNumber)->where('is_packed', 1)->count();
    
    return $PackedItem;
}

function getUnPackedItemCountByOrderId($orderNumber)
{
    $unPackedItem = DB::table('tbl_item_orders')->where('order_id', $orderNumber)->where('is_packed', 0)->count();
    
    return $unPackedItem;
}

function getCustomerCategoryDiscount($customerId, $itemCatId)
{
    $data = 0;
    if(!empty($customerId) && !empty($itemCatId))
    {
        $customer = DB::table('tbl_customers')->where('user_id', $customerId)->first();
        if(!empty($customer->customer_cat_discount))
        {
            $customerCatDiscount = DB::table('tbl_customer_category_discount')
            ->where('cat_class', $customer->customer_cat_discount)
            ->where('item_cat', $itemCatId)
            ->where('applicable_from', '<=', date('d-m-Y'))
            ->where('expired_on', '>=', date('d-m-Y'))
            ->first();
            //echo"neeraj";pr($customerCatDiscount);
            if($customerCatDiscount)
            {
                $data = $customerCatDiscount->discount_percentage;
            }else{
                $data = 0;
            }
            
            
    
        }
    }
    
    return $data;
}

function calculateItemDiscountForCart($itemPrice, $customerClasDiscount=0, $customerCategoryDiscount=0)
{
    //echo $itemPrice."/".$customerClasDiscount."/".$customerCategoryDiscount;exit;
    $afterDiscountPrice = 0;
    if(!empty($itemPrice))
    {
        $totalDiscount = $customerClasDiscount + $customerCategoryDiscount;
        $percentPrice = ($itemPrice * $totalDiscount) / 100;
        $afterDiscountPrice = $itemPrice - $percentPrice;
    }
    
    return $percentPrice;
}

function calculateItemDiscount($itemPrice, $customerClasDiscount=0, $customerCategoryDiscount=0)
{
    //echo $itemPrice."/".$customerClasDiscount."/".$customerCategoryDiscount;exit;
    $afterDiscountPrice = 0;
    if(!empty($itemPrice))
    {
        $totalDiscount = $customerClasDiscount + $customerCategoryDiscount;
        $percentPrice = ($itemPrice * $totalDiscount) / 100;
        $afterDiscountPrice = $itemPrice - $percentPrice;
    }
    //echo $afterDiscountPrice;exit;
    return $afterDiscountPrice;
}

function getCustomerClassDiscount($customerId, $itemCatId)
{
     
    $data = 0;
    if(!empty($customerId) && !empty($itemCatId))
    {
        $customer = DB::table('tbl_customers')->where('user_id', $customerId)->first();
        
        if(!empty($customer->customer_class_discount))
        {
            //echo "ttttt";
            $customerClassDiscount = DB::table('tbl_customer_class_discount')
            ->where('customer_class', $customer->customer_class_discount)
            ->where('customer_type', $customer->customer_type)
            ->where('applicable_from', '<=', date('d-m-Y'))
            ->where('expired_on', '>=', date('d-m-Y'))
            ->where('item_cat', $itemCatId)
            ->first();
          //pr($customerClassDiscount);
            if($customerClassDiscount)
            {
                $data = $customerClassDiscount->discount_percentage;
            }else{
                $data = 0;
            }
            
           
    
        }
    }
    
    return $data;
}

function get_attributes()
{
    $attribute = DB::table('tbl_attributes')->get();
    
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_attributes_option_by_attr_id($attr_id)
{
    $attribute = DB::table('tbl_attribute_options')->where('attribute_id', $attr_id)->get();
    
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_item_default_img_item_id($item_id)
{
    $data = DB::table('tbl_item_gallery')->where('item_id', $item_id)
            ->where('default', 1)->first();
    
    return $data;
}

function get_itemAtributeOptions_by_option_id($option_id)
{
    
   $attribute = DB::table('tbl_item_attributes')->where('attr_option', $option_id)->first();
   //pr(json_decode(json_encode($attribute), true));
    return json_decode(json_encode($attribute), true);
    //return $attribute;
}

function get_attribute_options_by_attribute_id($id)
{
    $attributeOptions = DB::table('tbl_attribute_options')->where('attribute_id', $id)->get();
    
    return $attributeOptions;
}

function get_categorys_by_item_id($item_id)
{
    $categories = DB::table('tbl_item_groups')->where('item_id', $item_id)->get();
    
    return $categories;
}

function getItemCategoryes()
{
    $data = DB::table('tbl_item_category')
    ->join('tbl_item_category_child','tbl_item_category_child.item_category_id','=','tbl_item_category.id')
    ->select('tbl_item_category.*')
    ->distinct('tbl_item_category.item_name')
    //->where('tbl_items.is_visible', 1)
    ->get();
    return $data;
}

function get_categorys_by_g_id($g_id)
{
    $groups = DB::table('tbl_group')->where('g_id', $g_id)->first();
    return $groups;
}

function get_customer_class_by_id($c_id)
{
    $class = DB::table('tbl_customer_classes')->where('id', $c_id)->first();
    return $class;
}

function get_customer_classes()
{
    $class = DB::table('tbl_customer_classes')->where('status', 1)->get();
    return $class;
}

function getCustomerCategoryList()
{
    $data = DB::table('tbl_customer_categories')->where('status', 1)->get();
    return $data;
}

function getCustomerCategoryById($id)
{
    $data = DB::table('tbl_customer_categories')->where('id', $id)->first();
    return $data;
}



function get_customer_and_address_by__user_id($user_id)
{
    
    $customerProfile = DB::table('tbl_customers')->where('user_id', $user_id)
    ->leftjoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')

    ->leftjoin('tbl_addresses','tbl_addresses.customer_id','=','tbl_customers.id')
    ->leftjoin('tbl_customer_documents','tbl_customer_documents.customer_id','=','tbl_customers.id')
    ->select('tbl_customers.id as cust_id','tbl_customers.*', 
    'tbl_addresses.id as address_id', 'tbl_businesses.*', 'tbl_customer_documents.id as docs_id', 'tbl_customer_documents.*')
    ->first();
    
    return $customerProfile;
}

 function get_item_detail($item_id)
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
            ->where('tbl_items.item_id', $item_id)
            ->first();
        return $data;

        
    }

function get_bannerLists()
{
    
    $bannerLists = DB::table('tbl_banners')->leftjoin('tbl_banner_size', function ($join) {
        $join->on('tbl_banners.size', '=', 'tbl_banner_size.id');

    })->leftjoin('tbl_items', function ($join) {

        $join->on('tbl_items.item_id', '=', 'tbl_banners.item_id');
    })
        ->select('tbl_items.*','tbl_banner_size.id as banner_size_id', 'tbl_banner_size.banner_size', 'tbl_banners.*')
        ->get();
    
    return $bannerLists;
}

function get_addresses_by_user_id($user_id)
{
    $customerAddresses = DB::table('tbl_addresses')->where('address_user_id', $user_id)->get();
    
    return $customerAddresses;
}

function get_businesses_by_user_id($user_id, $customer_id)
{
    $customerAddresses = DB::table('tbl_businesses')->where('address_user_id', $user_id)->get();
    
    return $customerAddresses;
}

function get_teams_by_customer_id($customer_id)
{
    $customerTeams = DB::table('tbl_teams')->where('customer_id', $customer_id)->get();
    
    return $customerTeams;
}

function get_custumer_by_user_id($user_id)
{
    $customerAddresses = DB::table('tbl_customers')->where('user_id', $user_id)->first();
    
    return $customerAddresses;
}

function get_user_by_user_id($user_id)
{
    $user = DB::table('users')->where('id', $user_id)->first();
    //pr(json_decode(json_encode($user), true));
    return json_decode(json_encode($user), true);
}

function get_sku_by_item_id($item_id)
{
    $item = DB::table('tbl_items')->leftjoin('tbl_items_attributes_data', 'tbl_items.item_id', '=', 'tbl_items_attributes_data.item_id')

           

        ->where('tbl_items.item_id', '=', $item_id)

        ->first();
    
        $group = DB::table('tbl_item_category')
                    ->leftjoin('tbl_group', function($group){
                        $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    })
                ->select('tbl_group.g_name', 'tbl_item_category.item_name as cat_name')
                ->where('tbl_item_category.id', $item->cat_id)
             ->first();
                  
          
        $itemSku = '';

        // $itemSku .= substr($group->g_name, 0, 3).'-'.substr($group->cat_name, 0, 3).'-'.substr($item->item_name, 0, 3).'-'.substr($item->item_attr_value, 0, 3);
        @$itemSku .= substr(@$group->g_name, 0, 4).'-'.substr(@$group->cat_name, 0, 4).'-'.substr($item->item_name, 0, 4);
        
     return strtoupper($itemSku);
}

function get_unique_code()
{
    $today = date("Ymd");
    $rand = strtoupper(substr(uniqid(sha1(time())),0,4));
     $unique = $today . $rand;
     return $unique;
}

function unique_multidim_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();
   
    foreach($array as $val) {
        if (!in_array($val[$key], $key_array)) {
            $key_array[$i] = $val[$key];
            $temp_array[$i] = $val;
        }
        $i++;
    }
    return $temp_array;
}

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); 
    $alphaLength = strlen($alphabet) - 1; 
    
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    
    return implode($pass); 
}

function generateOtp($n) 
{
    $generator = "1357902468"; 
    $result = ""; 
    
    for ($i = 1; $i <= $n; $i++) { 
        $result .= substr($generator, (rand()%(strlen($generator))), 1); 
    } 

    return $result; 

}

function getAllItemCategory()
{
    $obj = app('App\EComGeneralSettings');
    return $obj->getAllItemCategory(); 
}

function getNextOrderNumber()
{
    $lastOrder = DB::table('tbl_item_orders')->orderBy('created_at', 'desc')->first();

    if ( ! $lastOrder )
       $number = 0;
    else 
        $number = substr($lastOrder->order_id, 3);
    return sprintf('%06d', intval($number) + 1);
}

function sendSms($mobile, $message) 
{
    //$accusage = env('ACCUSAGE');
    // echo $senderId = env('SENDERID')."<br>";
    // echo $user = env('USER')."<br>";
    // echo $key = env('KEY')."<br>";
    // echo $mobile = $mobile."<br>";
    // echo $message = $message."<br>";
    
    //$url="http://sms.sahajapps.com/submitsms.jsp?user=Bartan&key=610d4ead4aXX&mobile=+918218526749&message=test neeraj sms&senderid=Bartan&accusage=1";
    // if(!empty($mobile) && is_numeric($mobile) && !empty($user) && !empty($senderId) && !empty($message) && !empty($key))
    // {
         $authKey = env('KEY');
         $userid = env('USERO');
         $senderId = env('SENDERID');
        $entityid =  env('ENTITYID');
        $tempid =  env('TEMPID');

        // $authKey = "610d4ead4aXX";
        // $userid = "Bartan";
        // $senderId = "Bartan";
        // $entityid = "1201162038478525646";
        // $tempid = "1207162425723012516";

        $mobileNumber = $mobile;
        $message = rawurlencode($message);
        $url='http://sms.sahajapps.com/submitsms.jsp?user='.$userid.'&key='.$authKey.'&mobile='.$mobileNumber.'&message='.$message.'&senderid='.$senderId.'&accusage=1&entityid='.$entityid.'&tempid='.$tempid;
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $url,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;

    // }else{
    //     echo "Ivalid mobile number or message";
    // }
}

function genratePdfItemOrderByOrderId($orderId){
   
    $itemOrders = DB::table('tbl_payment_status')
        ->leftjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->leftjoin('tbl_items','tbl_items.item_id','=','tbl_item_orders.item_id')
        ->where('tbl_payment_status.item_order_id', $orderId)

        ->select('tbl_items.item_id', 'tbl_items.item_name', 'tbl_item_orders.*', 'tbl_payment_status.*')
        ->get();
        
        //pr($itemOrders);
        //$theme = Theme::uses('default')->layout('layout');
        //return $theme->scope('pdf.itemOrderPdf', compact('itemOrders'))->render();
      
       $pdf = \PDF::loadView('pdf.itemOrderPdf', compact('itemOrders'));
       
       return $pdf;
}

function genratePdfItemOrderByOrderIdForCustomerSales($orderId){
   
    $itemOrders = DB::table('tbl_payment_status')
        ->leftjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
        ->leftjoin('tbl_items','tbl_items.item_id','=','tbl_item_orders.item_id')
        ->where('tbl_payment_status.item_order_id', $orderId)

        ->select('tbl_items.item_id', 'tbl_items.item_name', 'tbl_item_orders.*', 'tbl_payment_status.*')
        ->get();
        
        //pr($itemOrders);
        //$theme = Theme::uses('default')->layout('layout');
        //return $theme->scope('pdf.itemOrderPdf', compact('itemOrders'))->render();
      
       $pdf = \PDF::loadView('pdf.itemOrderPdfCustomerSales', compact('itemOrders'));
       
       return $pdf;
}


function get_itemsByCatOrBrandIdForPagination($flag='', $catOrBrandId='', $pageNo='1', $perPageLimit='6', $brandId = array())
    {
        //echo $pageNo;
       //echo $perPageLimit;
       $offset = ($pageNo - 1) * $perPageLimit;
        
        //echo $offset;
        switch ($flag) {
           
            case 'Brand':   //By Brands
                $data = DB::table('tbl_items')

                        ->leftJoin('tbl_brands', function ($brand) {
                            $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                            
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name')
                        
                        
                        ->orderBy('tbl_items.item_id', 'desc')
                        ->Where('tbl_items.is_visible', 1)
                        ->limit($offset, $perPageLimit);

                        if(!empty($catOrBrandId)){
                            $data = $data->where('tbl_items.brand_id', $catOrBrandId);
                        }

                        if(count($brandId) > 0){
                            $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                        }
                        //$datas = $data->get();

                    $datas = $data->get();
                        
                    

                        
                break;

            case 'Category':   //By Category
                
                $data = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                    ->orderByRaw('IF(priority = 1, null, 0)')
                    //->orderBy('tbl_items.item_id', 'desc')
                    //->where('tbl_items.cat_id', $id)
                    ->Where('tbl_items.is_visible', 1)
                    //->Where('tbl_group.g_id', $item_under_group_id)
                    //->distinct('tbl_group.g_name')
                    ->skip($offset)
                    ->take($perPageLimit);

                    //->limit($offset, $perPageLimit);

                        if(!empty($catOrBrandId)){
                            $data = $data->where('tbl_items.cat_id', $catOrBrandId);
                        }
                    if(count($brandId) > 0){
                        $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                    }

                    $datas = $data->get();
                   
                    
                    // echo $limit;
                        //pr($datas);
                   
                break;

            default:
                
                $data = DB::table('tbl_items')
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

                ->orderBy('tbl_items.item_id', 'desc')
                ->Where('tbl_items.is_visible', 1)
                ->limit($offset, $perPageLimit);

                // if(!empty($catOrBrandId)){
                //     $data = $data->where('tbl_items.cat_id', $catOrBrandId);
                // }

                if(count($brandId) > 0){
                    $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                }

                    $datas = $data->get();
                   

                
        }
        
        return $datas;


    }



    function get_itemsByCatOrBrandIdPaginateAllItem($flag='', $limit=-1, $catOrBrandId='', $page='', $brandId = array())
    {
       
        $page = (int) $page;
        
        $containsKey = Str::contains($catOrBrandId, '_');
        $id = $catOrBrandId;
        
        if($containsKey){

            $catOrBrand = explode('_', $catOrBrandId);
            $by = $catOrBrand[0];
            $id = $catOrBrand[1];
            $flag = $by;
            //$limit= 6;

        }
        
        //echo  $id;exit;
        switch ($flag) {
           
            case 'Brand':   //By Brands
                $data = DB::table('tbl_items')

                        ->leftJoin('tbl_brands', function ($brand) {
                            $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');
                            
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name')
                        //->where('tbl_items.brand_id', $id)
                        ->orderBy('tbl_items.item_id', 'desc')
                        ->Where('tbl_items.is_visible', 1)
                        ->limit($limit);
                        if(!empty($id)){
                            $datas = $data->whereIn('tbl_items.brand_id', $id);
                        }
                        if(count($brandId) > 0){
                            $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                        }
                        //$datas = $data->get();

                    $datas = $data->get();
                        
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                    }

                        
                break;

            case 'Category':   //By Category
                
                $data = DB::table('tbl_items')
                    ->leftJoin('tbl_item_category', function ($joinItemCat) {
                            $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');

                        })->leftJoin('tbl_group', function ($group) {
                            $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
                    
                        })
                        ->select('tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                            )

                            ->orderByRaw('IF(priority = 1, null, 0)')
                    //->orderBy('tbl_items.item_id', 'desc')
                    //  ->where('tbl_items.cat_id', $id)
                    ->Where('tbl_items.is_visible', 1)
                    //->Where('tbl_group.g_id', $item_under_group_id)
                    //->distinct('tbl_group.g_name')
                    ->limit($limit);

                    if(!empty($id)){
                        $datas = $data->where('tbl_items.cat_id', $id);
                    }

                    

                    if(count($brandId) > 0){
                        $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                    }

                    $datas = $data->get();
                   
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                    }
                    // echo $limit;
                    // echo $catOrBrandId;
                    //        pr($datas);
                   
                break;

            default:
                
                $data = DB::table('tbl_items')
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

                ->orderBy('tbl_items.item_id', 'desc')
                ->Where('tbl_items.is_visible', 1)
                ->limit($limit);

                if(count($brandId) > 0){
                    $datas = $data->whereIn('tbl_items.brand_id', $brandId);
                }

                    $datas = $data->get();
                        
                    if(!empty($page)){
                        
                        $datas = $data->paginate($page);
                    }

                
        }
        
        return $datas;


    }


function filter_search($query)
{
    $q = preg_split('/[;,+ ]+/', $query, -1, PREG_SPLIT_NO_EMPTY);
    //$q = preg_replace("/[^ \w-]/", "", $q);
    return $q;
}

function numberTowords1($num)
{ 
            $ones = array( 
                1 => "one", 
                2 => "two", 
                3 => "three", 
                4 => "four", 
                5 => "five", 
                6 => "six", 
                7 => "seven", 
                8 => "eight", 
                9 => "nine", 
                10 => "ten", 
                11 => "eleven", 
                12 => "twelve", 
                13 => "thirteen", 
                14 => "fourteen", 
                15 => "fifteen", 
                16 => "sixteen", 
                17 => "seventeen", 
                18 => "eighteen", 
                19 => "nineteen" 
                ); 
                $tens = array( 
                1 => "ten",
                2 => "twenty", 
                3 => "thirty", 
                4 => "forty", 
                5 => "fifty", 
                6 => "sixty", 
                7 => "seventy", 
                8 => "eighty", 
                9 => "ninety" 
            ); 
            $hundreds = array( 
                "hundred", 
                "thousand", 
                "million", 
                "billion", 
                "trillion", 
                "quadrillion" 
            ); //limit t quadrillion 
            $num = number_format($num,2,".",","); 
            $num_arr = explode(".",$num); 
            $wholenum = $num_arr[0]; 
            $decnum = $num_arr[1]; 
            $whole_arr = array_reverse(explode(",",$wholenum)); 
            krsort($whole_arr); 
            $rettxt = ""; 
            foreach($whole_arr as $key => $i){ 
            if($i < 20){ 
            $rettxt .= $ones[$i]; 
            }elseif($i < 100){ 
            $rettxt .= $tens[substr($i,0,1)]; 
            $rettxt .= " ".$ones[substr($i,1,1)]; 
            }else{ 
            $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            $rettxt .= " ".$tens[substr($i,1,1)]; 
            $rettxt .= " ".$ones[substr($i,2,1)]; 
            } 
            if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
            } 
            } 
            if($decnum > 0){ 
            $rettxt .= " and "; 
            if($decnum < 20){ 
            $rettxt .= $ones[$decnum]; 
            }elseif($decnum < 100){ 
            $rettxt .= $tens[substr($decnum,0,1)]; 
            $rettxt .= " ".$ones[substr($decnum,1,1)]; 
            } 
            } 
            return $rettxt; 
} 

function numberTowords($num)
{

$ones = array(
0 =>"ZERO",
1 => "ONE",
2 => "TWO",
3 => "THREE",
4 => "FOUR",
5 => "FIVE",
6 => "SIX",
7 => "SEVEN",
8 => "EIGHT",
9 => "NINE",
10 => "TEN",
11 => "ELEVEN",
12 => "TWELVE",
13 => "THIRTEEN",
14 => "FOURTEEN",
15 => "FIFTEEN",
16 => "SIXTEEN",
17 => "SEVENTEEN",
18 => "EIGHTEEN",
19 => "NINETEEN",
"014" => "FOURTEEN"
);
$tens = array( 
0 => "ZERO",
1 => "TEN",
2 => "TWENTY",
3 => "THIRTY", 
4 => "FORTY", 
5 => "FIFTY", 
6 => "SIXTY", 
7 => "SEVENTY", 
8 => "EIGHTY", 
9 => "NINETY" 
); 
$hundreds = array( 
"HUNDRED", 
"THOUSAND", 
"MILLION", 
"BILLION", 
"TRILLION", 
"QUARDRILLION" 
); /*limit t quadrillion */
$num = number_format($num,2,".",","); 
$num_arr = explode(".",$num); 
$wholenum = $num_arr[0]; 
$decnum = $num_arr[1]; 
$whole_arr = array_reverse(explode(",",$wholenum)); 
krsort($whole_arr,1); 
$rettxt = ""; 
foreach($whole_arr as $key => $i){
	
while(substr($i,0,1)=="0")
		$i=substr($i,1,5);
if($i < 20){ 
/* echo "getting:".$i; */
$rettxt .= $ones[$i]; 
}elseif($i < 100){ 
if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
}else{ 
if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
} 
if($key > 0){ 
$rettxt .= " ".$hundreds[$key]." "; 
}
} 
if($decnum > 0){
$rettxt .= " and ";
if($decnum < 20){
$rettxt .= $ones[$decnum];
}elseif($decnum < 100){
$rettxt .= $tens[substr($decnum,0,1)];
$rettxt .= " ".$ones[substr($decnum,1,1)];
}
}
return ucwords(strtolower($rettxt));
}

function getItemOnClickCarausel($pageNo='1', $perPageLimit='6',$brandId = array())
{
    $offset = ($pageNo - 1) * $perPageLimit;
    $data = DB::table('tbl_items')
                ->leftJoin('tbl_item_category', function ($joinItemCat) {
                $joinItemCat->on('tbl_item_category.id', '=', 'tbl_items.cat_id');
                
            })->leftJoin('tbl_brands', function ($brand) {
                $brand->on('tbl_brands.id', '=', 'tbl_items.brand_id');

            })
            // ->Join('customer_wise_brands', function ($brand) {
            //     $brand->on('customer_wise_brands.brand_id', '=', 'tbl_items.brand_id');
            // })
            ->leftJoin('tbl_group', function ($group) {
                $group->on('tbl_group.g_id', '=', 'tbl_item_category.item_under_group_id');
        
            })
            ->select('tbl_brands.*','tbl_items.*', 'tbl_items.item_name as product_name', 'tbl_item_category.*', 'tbl_item_category.item_name as item_cat_name', 'tbl_group.*' 
                )
                ->Where('tbl_items.is_visible', 1)
                ->Where('tbl_items.trending_item', '!=', null)
                //->where('tbl_items.brand_id', [1,6])
                    
                //->Where('customer_wise_brands.brand_id', 1)
        ->orderBy('tbl_items.trending_item', 'asc')
        ->skip($offset)
        ->take($perPageLimit);

    

        if(count($brandId) > 0){
            $data = $data->whereIn('tbl_items.brand_id', $brandId);
        }
        $data = $data->get();
    
    
    
    
    return $data;
}
