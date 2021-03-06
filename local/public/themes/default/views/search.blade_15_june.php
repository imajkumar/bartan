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
               
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
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
					
					
						
					
                    <?php  $i++;}}} else {?>

                       <div class="col-md-12 text-center">

                        <img src="gallery/shopping-cart.png" class="m-b-0">

                 
                        <h4>Sorry, no results found!</h4>
                        <p>Please check the spelling or try searching for something else</p>
                        <a href="{{url('/')}}" class="btn btn-inverse btn-md m-b-30">  <b>Start Shopping</b></a>

                        </div>


                    <?php } ?>

					
                       
                        
                    </div>
                    <!-- END item-row -->
                    
                </div>
                <!-- END search-item-container -->
                <!-- BEGIN pagination -->
                <ul class="pagination justify-content-center m-t-0">
                    @if (method_exists($items,'links'))
                        
                            {{ $brands->links() }}
                       
                    @endif
                   
                    <?php
                        //echo $brands->nextPageUrl()
                        // $paginator->previousPageUrl()
                        // $paginator->url($page)
                        // $paginator->count()
                    ?>
                  
                </ul>
                <!-- END pagination -->
            </div>
            <!-- END search-content -->
            <!-- BEGIN search-sidebar -->
            <div class="search-sidebar">
                <h4 class="title">Filter By</h4>
                <form action="{{route('filterByAjax')}}" method="POST" id="filterByBrandAjax" name="filterByBrandAjax">
                    @csrf
                    <input type="hidden" name="byType" value="" />
                <div class="form-group">
                        <label class="control-label">Keywords</label>
                <input type="text" class="form-control input-sm" name="keyword" value="{{@$keyword}}" placeholder="Enter Keywords" />
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