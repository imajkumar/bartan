<?php
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

            @$priceFrom = Request::get('priceFrom');
            @$priceTo = Request::get('priceTo');
            @$brandfilter = Request::get('brandfilter');
            @$pricefilter = Request::get('pricefilter');
?>
<!-- BEGIN #page-header -->
<div id="page-header" class="section-container page-header-container bg-black p-b-60 p-t-60">
    <!-- BEGIN page-header-cover -->
    <div class="page-header-cover">
        
        <img src="{{FRONT.'img/cover/cover-12.jpg'}}" alt="" />
    </div>
    <!-- END page-header-cover -->
    <!-- BEGIN container -->
    <div class="container">
        <?php //pr($brandDetail->brand_img);?>
    <h1 class="page-header"><b>{{ucfirst($keyword)}}</b></h1>
    </div>
    <!-- END container -->
</div>
<!-- BEGIN #page-header -->

<!-- BEGIN search-results -->
<div id="search-results" class="section-container">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN search-container -->

       


        <div class="search-container">
       
            <!-- BEGIN search-content -->
            <div class="search-content">
                <!-- BEGIN search-toolbar -->
                <?php if($login=="true" && $kyc == "true" && @$isAdmin != "yes"){ ?>

                <div class="search-toolbar src-filter">
                    <div class="row">
                        <div class="col-md-6 ml-auto">
                            <ul class="sort-list">
                                        <li class="text"><i class="fa fa-filter"></i> Sort by:</li>
                                        <li >
                                             <select class="form-control itemByBrandfillter" id="brand_id" name="itemByBrandfillter">
                                                <option value="">Select Brand</option>
                                                <?php
                                                    // $brandsListArr = DB::table('tbl_brands')->get();
                                                    $brandsListArr = getBarndsByCustomer($brandId);
                                                ?>
                                                @foreach($brandsListArr as $brandsList)
                                                    <option value="{{$brandsList->id}}" {{($brandfilter == $brandsList->id) ? 'selected':''}}>{{ucwords($brandsList->name)}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </li>
                                        <li>
                                             <select class="form-control itemByBrandfillter" id="price_by" name="price_by">
                                                <option value="">Select Price</option>
                                                <option value="asc"  {{($pricefilter == 'asc') ? 'selected':''}}>Low to High</option>
                                               <option value="desc" {{($pricefilter == 'desc') ? 'selected':''}}>High to Low</option>                                
                                            </select>
                                        </li>
                           
                                    </ul>
                           
                        </div>
                       
           
                    </div>
                </div>

                <?php }?>

                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
                <div id="searchFilterDiv">
                <div class="search-item-container" id="itemsByBrand">
                    <!-- BEGIN item-row -->
                    <div class="item-row">
                        
                        <!-- BEGIN item -->
                        <?php
                        if(count($items) > 0){ 
							$i=0;
							foreach($items as $item){
                                if($item->is_visible == 1){

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

                                    if(($i != 1) && ($i != 0) && ($i % 3==0)){
						?>
						
					
							</div>
							<div class="item-row">
						<?php } ?>

						<div class="item item-thumbnail">
							<a href="{{route('productDetail', $item->slug)}}" class="item-image">
								<img src="{{$itemImg}}" alt="" />
                                <?php if($totalOff != 0){?>
                                    <div class="discount">{{$totalOff}}% OFF </div>
                                <?php }?>
							</a>
							<div class="item-info">
								<h4 class="item-title">
								<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
								</h4>
								<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
								<?php 
                                if($login=="true" && $kyc == "true" && @$isAdmin != "yes"){
                                    if($totalOff == 0){
                                        ?>
                                        @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
                                        <div class="item-price itm-pr">
                                            Offer Price: ₹ {{($item->regular_price)?     $item->regular_price:0}}
                                        </div>
                                            @if($item->item_mrp)
                                            <div class="item-price itm-dpr">   MRP: 
                                                <span>
                                                    ₹ {{($item->item_mrp)?   
                                                    $item->item_mrp:''}}
                                                </span>
                                            </div>
                                            @endif
                                            
                                        <?php }else{ ?>
        
                                            @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
                                            <div class="item-price itm-pr">
                                                Offer Price: ₹ {{$AfterDiscountPrice}}
                                            </div>
        
                                            <!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
                                        
                                            @if($item->item_mrp)
                                            <div class="item-price itm-dpr">   MRP: 
                                                <span> 
                                                    ₹ {{($item->item_mrp)? $item->item_mrp:''}}
                                                </span>
                                            </div>
                                            @endif
                                            
                                        <?php }?>

                                        @if($retailPrice)
                                        <div class="itm-rlm">
                                            <span>{{$retailPrice}}%</span> 
                                            Retail Margin 
                                        </div>
                                        @endif

                                    <a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>

                            

                            <?php } ?>
							</div>
						</div>
					
					
						
					
                    <?php  $i++;}}} else {?>

                       <div class="col-md-12 text-center">

                        <div class="srchnofound">

                            <img src="gallery/shopping-cart.png" class="m-b-0">
                            <h4>Sorry, no results found!</h4>
                            <p>Please check the spelling or try searching for something else</p>
                            <a href="{{url('/')}}" class="btn btn-inverse btn-md m-b-30">  <b> <i class="fas fa-rocket"></i> Start Shopping</b></a>
                        </div>

                        </div>


                    <?php } ?>

					
                       
                        
                    </div>
                    <!-- END item-row -->
                    
                </div>
                <!-- END search-item-container -->
                <!-- BEGIN pagination -->
                <ul class="pagination justify-content-center m-t-0">
               @php 
               $keyword = Request::get('keyword')
               @endphp
                    @if (method_exists($items,'links'))
                    
                    {{ $items->appends(['keyword' => $keyword])->links() }}
                            
                       
                    @endif
                   
                    <?php
                        //echo $brands->nextPageUrl()
                        // $paginator->previousPageUrl()
                        //echo  $paginator->url($page);
                        // $paginator->count()
                    ?>
                  
                </ul>
                    </div>
                <!-- END pagination -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar">
                <h4 class="title">Filter By</h4>
                <form action="{{route('filterLeftSideSearchPageAjax')}}" method="POST" id="filterLeftSideSearchPageAjax" name="filterLeftSideSearchPageAjax">
                    @csrf
                    <input type="hidden" name="byType" value="" />
                <div class="form-group">
                        <label class="control-label">Keywords</label>
                <input type="text" class="form-control input-sm" id="keyword" name="keyword" value="{{@$keyword}}" placeholder="Enter Keywords" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Price</label>
                        <div class="row row-space-0">
                            <div class="col-md-5">
                                <input type="number" min="1" onkeyup = "checkPrice()" id="priceFrom" class="form-control input-sm checckPrice" name="priceFrom" value="{{(@$priceFrom) ? @$priceFrom : 1}}" placeholder="Price From" />
                            </div>
                            <div class="col-md-2 text-center p-t-5 f-s-12 text-muted">to</div>
                            <div class="col-md-5">
                                <input type="number" class="form-control input-sm checckPrice" name="priceTo" value="{{@$priceTo}}" placeholder="Price To" />
                            </div>
                        </div>
                    </div>
                    <div class="m-b-30 text-center">
                        <button type="submit" class="btn btn-md btn-inverse"><i class="fa fa-search fa-fw mr-1"></i> FILTER</button>
                    </div>
                </form>
              
                
            </div>
            <!-- END search-sidebar -->
        </div>
        <!-- END search-container -->
    </div>
    <!-- END container -->
</div>
<!-- END search-results -->