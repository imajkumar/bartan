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
    <h1 class="page-header"><b>{{$category->item_name}}</b> Product</h1>
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
               
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
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
                
                                            <div class="item-price">???{{($item->regular_price)? $item->regular_price:0}}</div>
                                            @if($item->item_mrp)
                                            <div class="item-discount-price">???{{($item->item_mrp)? $item->item_mrp:''}}</div>
                                            @endif
                                        <?php }else{ ?>
        
                                            <div class="item-price">???{{$AfterDiscountPrice}}</div>
        
                                            <div class="item-discount-price">???{{($item->regular_price)? $item->regular_price:0}}</div>
                                        <?php }?>
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
                   
                    
                    {{-- <li class="page-item disabled"><a href="javascript:;" class="page-link">Previous</a></li>
                    <li class="page-item active"><a class="page-link" href="javascript:;">1</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">2</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">3</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">4</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">5</a></li>
                    <li class="page-item"><a class="page-link" href="javascript:;">Next</a></li> --}}
                </ul>  
                <!-- END pagination -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar">
                <h4 class="title">Filter By</h4>
            <form action="{{route('filterByAjax')}}" method="POST" id="filterByAjax" name="filterByAjax">
                    @csrf
                    <input type="hidden" name="byType" value="Category" />
                <div class="form-group">
                        <label class="control-label">Keywords</label>
                        <input type="text" class="form-control input-sm" name="keyword" value="" placeholder="Enter Keywords" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Price</label>
                        <div class="row row-space-0">
                            <div class="col-md-5">
                                <input type="number" class="form-control input-sm" name="priceFrom" value="10" placeholder="Price From" />
                            </div>
                            <div class="col-md-2 text-center p-t-5 f-s-12 text-muted">to</div>
                            <div class="col-md-5">
                                <input type="number" class="form-control input-sm" name="priceTo" value="10000" placeholder="Price To" />
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