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
				$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
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
            @$priceFrom = Request::get('priceFrom');
            @$priceTo = Request::get('priceTo');
            @$keyword = Request::get('keyword');
            // @$pricefilter = Request::get('pricefilter');
            @$brandfilter = Request::get('brandfilter');
            @$pricefilter = Request::get('pricefilter');
?>

<!-- BEGIN #page-header -->
<div id="page-header" class="section-container page-header-container bg-black">
    <!-- BEGIN page-header-cover -->
    <div class="page-header-cover">

        <?php $branImg = FRONT.'img/cover/cover-12.jpg';?>
    <img src="{{$branImg}}" categoryalt="" />
    </div>
    <!-- END page-header-cover -->
    <!-- BEGIN container -->
    <div class="container">
    <h1 class="page-header"><b>{{(@$category->item_name)? @$category->item_name:@$keyword}}</b> Product</h1>
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
                            <input type="hidden" value="{{ Request::segment(2) }}" id="catId" name="catId"/>
                             <select class="form-control itemByCategoryfillter" id="brand_id" name="itemByBrandfillter">
                                <option value="">Select Brand</option>
                                <?php
                                    // $brandsListArr = DB::table('tbl_brands')->get();
                                    $brandsListArr = getBarndsByCustomer($brandId);
                                    
                                    //@$brandfilter = Request::get('brandfilter');
                                ?>
                                @foreach($brandsListArr as $brandsList)
                                    <option value="{{$brandsList->id}}" {{($brandfilter == $brandsList->id) ? 'selected':''}}>{{ucwords($brandsList->name)}}
                                    </option>
                                @endforeach
                            </select>
                        </li>
                        <li>
                             <select class="form-control itemByCategoryfillter" id="price_by" name="price_by">
                                <option value="">Select Price</option>
                                <option value="asc"  {{($pricefilter == 'asc') ? 'selected':''}}>Low to High</option>
                                <option value="desc" {{($pricefilter == 'desc') ? 'selected':''}}>High to Low</option> 
                                <!-- <option value="asc" {{($pricefilter = 'asc') ? 'selected':''}}>Low to High</option>
                               <option value="desc" {{($pricefilter = 'desc') ? 'selected':''}}>High to Low</option>                                 -->
                            </select>
                        </li>
           
                    </ul>
           
        </div>
       

    </div>
</div>

<?php }?>
               
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
                <div id="filterWithPagination">
                <div class="search-item-container" id="itemsByCategory">
                    <!-- BEGIN item-row -->
                    <div class="item-row">
                        
                        <!-- BEGIN item -->
                        <?php 
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
                                <!-- <span class="onsale">Sale</span> -->
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
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
                                    if($totalOff == 0){
                                        ?>
                
                                           <div class="item-price itm-pr">
                                                Offer Price: ₹ {{($item->regular_price)? $item->regular_price:0}}
                                           </div>
                                            @if($item->item_mrp)
                                            <div class="item-discount-price itm-dpr">   MRP: ₹ {{($item->item_mrp)?          
                                               $item->item_mrp:''}}
                                            </div>
                                            @endif
                                        <?php }else{ ?>
        
                                            <div class="item-price itm-pr">
                                                Offer Price: ₹ {{$AfterDiscountPrice}}
                                             </div>
        
                                            <!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
                                            @if($item->item_mrp)
                                            <div class="item-discount-price itm-dpr">   MRP: <span>₹ {{($item->item_mrp)?     
                                                $item->item_mrp:''}}</span>
                                            </div>
                                            @endif
                                        
                                        <?php }?>

                                        @if($retailPrice)
                                        <div class="itm-rlm">
                                            <span>{{$retailPrice}}%</span> Retail Margin
                                        </div>
                                        @endif

                                    <a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>

                            

                            <?php } ?>
							</div>
						</div>
					
					
						
					
					<?php  $i++;} }?>

					
                       
                        
                    </div>
                    <!-- END item-row -->
                    
                </div>
                <!-- END search-item-container -->
                <!-- BEGIN pagination -->
                <ul class="pagination justify-content-center m-t-0">

                

                    @if (method_exists($items,'links'))
                        
                            {{ $items->links() }}
                       
                    @endif
                   
                    
                    
                </ul> 
                </div> 
                <!-- END pagination -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar">
                <h4 class="title">Filter By</h4>
                <form action="{{route('filterLeftSideCategoryPageAjax')}}" method="POST" id="filterLeftSideCategoryPageAjax" name="filterLeftSideCategoryPageAjax">
                    @csrf
            <!-- <form action="{{route('filterByAjax')}}" method="POST" id="filterByAjax" name="filterByAjax">
                    @csrf -->
                    <input type="hidden" name="byType" value="Category" />
                <div class="form-group">
                        <label class="control-label">Keywords</label>
                        <input type="text" class="form-control input-sm" id="keyword" name="keyword" value="{{(@$category->item_name)? @$category->item_name:@$keyword}}" placeholder="Enter Keywords" />
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
                        <button type="submit" class="btn btn-inverse"><i class="fa fa-search fa-fw mr-1"></i> FILTER</button>
                    </div>
                </form>
                <h4 class="title m-b-0">Categories</h4>
                <ul class="search-category-list">
                    <?php 
						$itemCategories = getItemCategory();
						foreach($itemCategories as $itemCategory){

                            $itemsInCategory = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $itemCategory->id);
                            if(count($itemsInCategory) != 0){
                    ?>
                    
                        <li><a id="{{'Category_'.$itemCategory->id}}"  class="getItem" href="javascript:void(0);">{{ucfirst($itemCategory->item_name)}} <span class="pull-right">({{count($itemsInCategory)}})</span></a></li>
                    <?php }}?>

                    {{-- <li><a href="#">iPhone <span class="pull-right">(10)</span></a></li> --}}
                    {{-- <li><a href="#">Mac <span class="pull-right">(15)</span></a></li>
                    <li><a href="#">iPad <span class="pull-right">(32)</span></a></li>
                    <li><a href="#">Watch <span class="pull-right">(4)</span></a></li>
                    <li><a href="#">TV <span class="pull-right">(6)</span></a></li>
                    <li><a href="#">Accessories <span class="pull-right">(38)</span></a></li> --}}
                </ul>
            </div>
            <!-- END search-sidebar -->
        </div>
        <!-- END search-container -->
    </div>
    <!-- END container -->
</div>
<!-- END search-results -->