<style>
/*.search-content {
    margin-right: -103px;
}

.search-container .search-sidebar {
    margin-left: 103px;
   
    width: 25%;
    padding: .9375rem;
    border: 1px solid #dee2e6;
    background: #fff;
    font-size: .8125rem;
    color: #4d4d4d;
    -webkit-border-radius: 6px;
    border-radius: 6px;
}*/
.cart-top{
    height: 400px;
    padding: 20px 20px;
    overflow: scroll;
}
@media screen and ( max-width: 400px ){

li.page-item {

    display: none;
}

.page-item:first-child,
.page-item:nth-child( 2 ),
.page-item:nth-last-child( 2 ),
.page-item:last-child,
.page-item.active,
.page-item.disabled {

    display: block;
}
}
</style>

<?php
$seller = session()->get('sales');
// pr($seller); 
    @$categoryId = Request::get('catId');
    @$requestBrandId = Request::get('brandId');
    @$keyword = Request::get('keyword');
?>

<!-- BEGIN #page-header -->
<div id="page-header" class="section-container page-header-container bg-black">
    <!-- BEGIN page-header-cover -->
    <div class="page-header-cover">
        <?php
        if(@$brandDetail->brand_img){
            $branImg = BASE_URL.ITEM_IMG_PATH.'/'.@$brandDetail->brand_img;
            
        }else{
            $branImg = FRONT.'img/cover/cover-12.jpg';
        }
        ?>
        <img src="{{$branImg}}" alt="" />
    </div>
    <!-- END page-header-cover -->
    <!-- BEGIN container -->
    <div class="container">
        <?php //pr($brandDetail->brand_img);?>
    
    </div>
    <!-- END container -->
</div>
<!-- BEGIN #page-header -->

<!-- BEGIN search-results -->
<div id="search-results" class="content">
    <!-- BEGIN container -->
   <div class="container">
    <div class="row">
                              
                                <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 pull-right">
                                      <label for="">Customer</label>
                                    <select class="form-control" id="selesCustomer" name="selesCustomer" placeholder="Please select customer">
                                        <option value="">Please select customer</option>
                                        <?php
                                            $selesCustomers = DB::table('tbl_customers')
                                            ->join('customer_sales','customer_sales.customer_id','=','tbl_customers.id')
                                            ->leftJoin('tbl_businesses','tbl_businesses.customer_id','=','tbl_customers.id')
                                            ->where('tbl_customers.status', 1)
                                            ->where('tbl_customers.deleted_at', 1)
                                            // ->where('customer_sales.sales_user_id', $seller->user_id)
                                            ->where('customer_sales.se_id', $seller->user_id)
                                            ->orWhere('customer_sales.asm_id', $seller->user_id)
                                            ->orWhere('customer_sales.rsm_id', $seller->user_id)
                                            ->orWhere('customer_sales.nsm_id', $seller->user_id)
                                            ->select('tbl_customers.*','tbl_businesses.store_name')
                                            ->get();
                                            //pr($selesCustomers);
                                            $customer = session()->get('customerForSalesPanel');
                                            //pr($customer);
                                            foreach($selesCustomers as $selesCustome){
                                                
                                            //pr($selesCustome);
                                        ?>
                                            <option value="{{$selesCustome->id}}" {{(@$customer->id == $selesCustome->id)? 'selected':''}}>{{ucfirst($selesCustome->cutomer_fname.' '.$selesCustome->cutomer_lname.' '.$selesCustome->phone.' '.$selesCustome->store_name )}}</option>
                                        
                                        <?php }?>
                                    </select>
                                </div>
                            </div>


        <div class="row" id="filtterItem" style="display:{{($customer)? '':'none'}}">
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <label class="col-md-12 col-sm-6 col-form-label" for="">By Brand</label>
                <div class="input-group">
                   
                    <select class="form-control" id="salesItemByBrand" name="salesItemByBrand" onchange="searchItemBySales()">
                        <option value="">Select brand</option>
                        <?php
                         $customer = session()->get('customerForSalesPanel');
                         $brandId = array();
                         if(!empty($customer)){
                             $customerBrands = DB::table('customer_wise_brands')->where('user_id', $customer->user_id)->get();
                                if(count($customerBrands) > 0){
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
                         
                             
                             $brandsListArr = DB::table('tbl_brands')->whereIn('tbl_brands.id', $brandId)->get();
                            //$brandsListArr = DB::table('tbl_brands')->get();
                        ?>
                        
                        @foreach($brandsListArr as $brandsList)
                            <option value="{{$brandsList->id}}" {{($requestBrandId == $brandsList->id)? "selected":""}}>{{ucwords($brandsList->name)}}</option>
                        @endforeach
                    </select>
                    
                </div>
                   
            </div>
         
            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
            <label class="col-md-12 col-sm-6 col-form-label" for="">By Category</label>
                <div class="input-group">
                    <select class="form-control" id="salesItemByCategory" name="salesItemByCategory" onchange="searchItemBySales()">
                        <option value="">Select Category</option>
                        <?php
                            //$dataObjArr = getItemCategory();
                            //$dataObjArr = getItemCategoryes();
                            $dataObjArr = getAllItemCategory();
                        ?>
                        
                         @foreach ($dataObjArr as $rowData)
                            <option value="{{$rowData->id}}" {{($categoryId == $rowData->id)? "selected":""}}>{{$rowData->item_name}}</option>
                        @endforeach

                    </select>
                   
                </div>
            </div>
            </br>

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <label class="col-md-12 col-sm-4 col-form-label" for="">Search</label>
                <div class="input-group">
               
                    <input type="text" id="salesItemSeach" name="salesItemSeach" value="{{($keyword)? $keyword:''}}" placeholder="Search" class="form-control bg-silver-lighter">
                    <!-- <input type="text" id="salesItemSeach" name="salesItemSeach" onkeyup="searchItemBySales()" value="{{($keyword)? $keyword:''}}" placeholder="Search" class="form-control bg-silver-lighter"> -->
                    <div class="input-group-append">
                        <button class="btn btn-inverse" onclick="searchItemBySales()" type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
       </div> 

    <div class="container" id="salesItemAppend">

        <!-- BEGIN search-container -->
        <?php 
         //echo "test";exit;
            //pr($customer);
            if(session()->has('customerForSalesPanel')){
                $customer = session()->get('customerForSalesPanel');
                //pr($customer);
        ?>

        
        
        <div class="search-container" >
       
       					
										
            <!-- BEGIN search-content -->
            <div class="search-content">
            
                <!-- BEGIN search-toolbar -->
               
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
                <div class="search-item-container m-t-20">
               
                    <!-- BEGIN item-row -->
                    <div class="item-row">
                    

                        <!-- BEGIN item -->
                        <?php 
							$i=0;
							foreach($brands as $item){
                                if($item->is_visible == 1){

                                    $itemImages = get_item_default_img_item_id($item->item_id);

                                    if($itemImages)
                                    {

                                        $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                        
                                    } else {

                                        $itemImg = FRONT.'img/product/product-iphone.png';
                                    }
                                    $totalOff=0;
                                    @$custClassDiscount = getCustomerClassDiscount($customer->user_id, $item->cat_id);
                                    @$custCatDiscount = getCustomerCategoryDiscount($customer->user_id, $item->cat_id);
                                    @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
                                    //echo $customerDetail->user_id;exit;
                                    $totalOff = $custCatDiscount + $custClassDiscount;

                                    $retailPrice ='';
									if($item->item_mrp > $item->regular_price){
					
										@$retailPrice = getRetailPrice($customer->user_id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
									}
                                    
                                    if(($i != 1) && ($i != 0) && ($i % 3==0)){
						?>
						
					
							</div>
							<div class="item-row">
						<?php } ?>

						<div class="item item-thumbnail">
							<a href="{{route('salesProductDetail', $item->slug)}}" class="item-image">
								<img src="{{$itemImg}}" alt="" />
                                <?php if($totalOff != 0){?>

                                    <div class="discount">{{$totalOff}}% OFF</div>

                                <?php }?>
							
							</a>
							<div class="item-info">
								<h4 class="item-title">
								<a href="{{route('salesProductDetail', $item->slug)}}">{{$item->product_name}}</a>
								</h4>
								<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
                                
                                
                                <?php 
                                if($totalOff == 0){
                                    ?>

									<div class="item-price itm-pr"> Offer Price:₹{{($item->regular_price)? $item->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-discount-price">₹{{($item->item_mrp)? $item->item_mrp:''}}</div>
									@endif
                                
                                <?php }else{ ?>

                                    <div class="item-price itm-pr"> Offer Price:₹{{$AfterDiscountPrice}}</div>
                                    <div class="item-discount-price itm-dpr"> MRP: <span>₹{{($item->item_mrp)? $item->item_mrp:0}}</span></div>
                                    <!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
                                
                                <?php }?>

                                @if($retailPrice)
                                    <div class="itm-rlm">
                                    <span>{{$retailPrice}}%</span> Retail margin</div>
                                @endif
                                    <a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>

                            

                           
							</div>
						</div>
					
					
						
					
					<?php  $i++;}}?>

					
                       
                        
                    </div>
                    <!-- END item-row -->
                    
                </div>
                <!-- END search-item-container -->
                <!-- BEGIN pagination -->
                <ul class="pagination justify-content-center m-t-0">
                    @if (method_exists($brands,'links'))
                        
                            {{ $brands->links() }}
                       
                    @endif
                   
                   
                    
                </ul>
                <!-- END pagination -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar m-t-20">
                <!-- <h4 class="title">Filter By</h4> -->
                <h4 class="title m-b-0">Customer</h4>
                <ul class="search-category-list">
                <address class="m-t-5 m-b-5">
                    <?php 
                    $customer_name = ucfirst($customer->cutomer_fname.' '.$customer->cutomer_lname);

                    $country = getCountryByCountryId(@$customer->business_country);
                    $state = get_stateNameByStateId(@$customer->business_state);
                    $city = get_cityNameByCityId(@$customer->business_city);
                    ?>
                            <strong class="text-inverse">Customer name: {{@$customer_name}}</strong><br />
                            STREET ADDRESS: {{@$customer->business_street_address}}<br />
                            COUNTRY:        {{@$country->name}}<br/>  
                            STATE:          {{@$state->name}}<br/> 
                            CITY:           {{@$city->name}}<br/> 
                            ZIP CODE:       {{@$customer->business_postal_code}}<br />
                            PHONE NO.:     {{@$customer->phone}}<br />
                            EMAIL ID:       {{@$customer->email}}<br />
                            GST NO.:        {{@$customer->business_gst_number}}<br />
                            
                </address>
                    
                </ul>
                
                
            </div>
            <!-- END search-sidebar -->
        </div>

       <?php }?>
        <!-- END search-container -->
    </div>
    <!-- END container -->
</div>
<!-- END search-results -->