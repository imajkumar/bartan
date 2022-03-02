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


            // @$brandfilter = Request::get('brandfilter');
            // @$pricefilter = Request::get('pricefilter');
?>




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
                @if(method_exists($items,'links'))
                        
                        {{ $items->links() }}
                   
                @endif
                   
                    
                  
                </ul>
                    </div>