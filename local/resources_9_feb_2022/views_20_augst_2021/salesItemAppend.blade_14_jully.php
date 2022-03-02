
<!-- BEGIN search-container -->
<div class="search-container hello">
            <!-- BEGIN search-content -->
            <div class="search-content">
                <!-- BEGIN search-toolbar -->
               
                <!-- END search-toolbar -->
                <!-- BEGIN search-item-container -->
                <div class="search-item-container">
                    <!-- BEGIN item-row -->
                    <div class="item-row">
                        
                        <!-- BEGIN item -->
                        <?php 
                            $i=0;
                            $customer = session()->get('customerForSalesPanel');
							foreach($brands as $item){
                                if($item->is_visible == 1){

                                    $itemImages = get_item_default_img_item_id($item->item_id);

                                    if($itemImages)
                                    {

                                        $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                        
                                    } else {

                                        $itemImg = FRONT.'img/product/product-iphone.png';
                                    }
                                    
                                    @$custClassDiscount = getCustomerClassDiscount($customer->user_id, $item->cat_id);
                                    @$custCatDiscount = getCustomerCategoryDiscount($customer->user_id, $item->cat_id);
                                    @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
                                    
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
								<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
								</h4>
								<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
                                
                                <?php 
                                if($totalOff == 0){
                                    ?>

									<div class="item-price itm-pr"> Offer Price:₹{{($item->regular_price)? $item->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr"> MRP: <span>₹{{($item->item_mrp)? $item->item_mrp:''}}</span></div>
									@endif
                                
                                <?php }else{ ?>

                                    <div class="item-price itm-pr"> Offer Price:₹{{$AfterDiscountPrice}}</div>
                                    <div class="item-discount-price itm-dpr"> MRP: <span>₹{{($item->regular_price)? $item->regular_price:0}}</span></div>
                                
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
            <div class="search-sidebar">
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














