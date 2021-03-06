<?php

// $customer = session()->get('customer');
// if($customer){
//     $login = "true";
// }else{
//     $login = "false";
// }
    if(Auth::user()){

        if(Auth::user()->user_type ==0){

            if(Auth::user()->profile == 1){

                $kyc = 'true';

            }else{

                $kyc = 'false';
            }
            $isAdmin = "no";
        }else{

            $kyc = 'true';
            $isAdmin = "yes";
        }

        $login = "true";
    }else{

        $kyc = 'false';
        $login = "false";
    }
 
    @$users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first(); 

    $itemImages = get_gallery_img_by_item_id($item->item_id);
    $itemIdForRelated = $item->item_id;
        $attrs = DB::table('tbl_items_attributes_data')->where('item_id', $item->item_id)
              ->orderBy('id','desc')
            //->groupBy('item_attr_admin_label')
            ->get();
        
        $nameAttr = '';
        foreach($attrs as $attr){
            
            $nameAttr .= $attr->item_attr_value.',';
        }
        @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
        @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
        @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
        
        $totalOff = $custCatDiscount + $custClassDiscount;
        $retailPrice ='';
        if($item->item_mrp > $item->regular_price){

            @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
        }

        if (@$users->cutomer_state == 10) {
                $cgst = $item->cgst ?? 0;
                $sgst = $item->sgst ?? 0;
           
               $totalGst = $cgst + $sgst; 
            
            } else {
            
                $igst = $item->igst ?? 0;
                $totalGst = $igst;
            
            }

       
        $calculateGst= ($item->regular_price * $totalGst) / 100;

        $forIfoShowPrice = $item->regular_price - $calculateGst;
									
?>
<style>
    .required-star {
        color: red;
    }
</style>


{{-- ---------------------------------------------------------------------------------------- --}}

<div id="product" class="section-container p-t-150">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN breadcrumb -->
        <!-- <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Mobile Phone</a></li>
            <li class="breadcrumb-item"><a href="#">Apple</a></li>
            <li class="breadcrumb-item active">iPhone 6S Plus</li>
        </ul> -->
        <!-- END breadcrumb -->
        <!-- BEGIN product -->
        <div class="product">
            <!-- BEGIN product-detail -->
            <div class="product-detail">
                <!-- BEGIN product-image -->
                <div class="product-image">
                    <!-- BEGIN product-thumbnail -->
                    <div class="product-thumbnail">
                        <ul class="product-thumbnail-list">
                            <?php 
                            $n=1;
                            $defaultImg ='';
                            $itemImg = FRONT.'img/product/product-iphone.png';
                            foreach($itemImages as $itemImage)
                                {
                                    if($itemImage->default == 1){
                                        $defaultImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImage->img_name;
                                        
                                    }

                                    if($itemImage->img_name)
                                    {
                                        $active = $itemImage->default;
                                        $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImage->img_name;
                                    }
                                    
                            ?>

                                <li class="{{($itemImage->default == 1) ? 'active':''}}"><a href="#" data-click="show-main-image" data-url="{{$itemImg}}"><img src="{{$itemImg}}" alt="{{$itemImage->img_name}}" /></a></li>
                           
                            
                            <?php $n++;}?>

                        </ul>
                    </div>
                    <!-- END product-thumbnail -->
                    <!-- BEGIN product-main-image -->
                    <div class="product-main-image" data-id="main-image">
                        <img id="zoom_mw" src="{{($defaultImg) ? $defaultImg:$itemImg}}" data-zoom-image="{{($defaultImg) ? $defaultImg:$itemImg}}" alt="img" />
                    </div>
                    <!-- END product-main-image -->
                </div>
                <!-- END product-image -->
                <!-- BEGIN product-info -->
                <div class="product-info">
                    <!-- BEGIN product-info-header -->
                    <div class="product-info-header">
                        <h1 class="product-title">
                        <?php if($totalOff != 0){?>

                            <span class="badge bg-primary">{{$totalOff}}% OFF</span>
								
						<?php }?> 
                         
                            {{$item->product_name}} 
                            <!-- {{$item->product_name.' '.chop($nameAttr, ',')}}  -->
                        </h1>
                        <ul class="product-category">
                            <li><a href="#"><?php echo get_group_category_cat_id($item->cat_id);?></a></li>
                            
                        </ul>
                    </div>
                    <!-- END product-info-header -->
                    <div class="product-tab">
                     <ul id="product-tab" class="nav nav-tabs">
                      <li class="nav-item"><a class="nav-link active" href="#product-desc" data-toggle="tab">Specification</a></li>
                      <li class="nav-item"><a class="nav-link" href="#product-info" data-toggle="tab">Product Description</a></li>
                      {{-- <li class="nav-item"><a class="nav-link" href="#product-reviews" data-toggle="tab">Additional Information</a></li> --}}
                     </ul>


               <div id="product-tab-content" class="tab-content">
                    <!-- BEGIN #product-desc -->
                    <div class="tab-pane fade active show" id="product-desc">
                         
                         <table class="table table-bordered">

                            <tbody>
                                <?php
                                $attrds = DB::table('tbl_items_attributes_data')
                                        
                                ->where('item_id', $item->item_id)
                                                //->where('item_cat_id', $item->cat_id)
                                                ->get();
                                //pr($attrds);
                                    $atr = array();
                                    foreach($attrds as $attrd){

                                        $atr[$attrd->item_attr_code][] = $attrd->item_attr_value;
                                    }
                                    
                                    
                                    foreach($atr as $keyCode => $attr){

                                        $attrVals ='';
                                        foreach($attr as $attrVal){
                                            
                                            $attrVals .= $attrVal.', ';
                                        }
                                ?>
                            

                                <tr>
                                    <td>
                                        {{ucfirst($keyCode)}}
                                    </td>
                                    <td class="clr-t">
                                        {{ucfirst(chop($attrVals, ', '))}}<br />
                                    
                                    </td>
                                    
                                </tr>
    
                            <?php }?>


                            {{-- @if($item->invt_saleunit)
                                <tr>
                                    <td>Sales Unit</td>
                                    <td class="clr-t">{{$item->invt_saleunit}}</td>
                                </tr>
                            @endif --}}

                            {{-- @if($item->item_invt_lengh)
                                <tr>
                                    <td>Length</td>
                                    <td class="clr-t">{{$item->item_invt_lengh}}</td>
                                </tr>
                            @endif
                            @if($item->item_invt_width)
                                <tr>
                                    <td>Width</td>
                                    <td class="clr-t">{{$item->item_invt_width}}</td>
                                </tr>
                            @endif
                            @if($item->item_invt_height)
                                <tr>
                                    <td>Height</td>
                                    <td class="clr-t">{{$item->item_invt_height}}</td>
                                </tr>
                            @endif
                            @if($item->item_invt_weight)
                                <tr>
                                    <td>Weight</td>
                                    <td class="clr-t">{{$item->item_invt_weight}}</td>
                                </tr>
                            @endif --}}
                           

                            <tr>
                                <td>Availability</td>
                                <?php if($item->product_status == 1) {?>

                                    <td class="clr-t">In stock</td>

                                <?php }else if($item->product_status == 0){?>

                                    <td class="clr-t">Out of stock</td>

                                <?php }else{?>

                                    <td class="clr-t">As per Actual</td>

                                <?php } ?>
                            </tr>
                            <tr>
                                <td>Brand</td>
                                <td class="clr-t">
                                    <?php 
                                        $brand = DB::table('tbl_brands')->where('id', $item->brand_id)->first();
                                    ?>
                                    {{@$brand->name}}
                                </td>
                            </tr>
                            <?php /*
                                $itemTags = '';
                                    $tags = DB::table('tbl_item_tags')->where('item_id', $item->item_id)->get();
                                    if(count($tags)>0){
                            ?>
                            <tr>
                                <td>Tags</td>
                                <td class="clr-t">
                                    <?php
                                   
                                        foreach($tags as $tag){
                                            $itemTags .= $tag->tag_name.',';
                                        }

                                        echo chop($itemTags, ',');
                                    ?>
                                </td>
                            </tr>
                            <?php } */?>
                            <tr>
                                <td>HSN code</td>
                                <td class="clr-t">
                                <?php
                                @$hsnDetail = DB::table('tbl_hsn')->where('id', @$item->hsn_code)->first(); 
                                ?>
                                    {{@$hsnDetail->hsn_name}}
                                </td>
                            </tr>

                       

                            <tr>
                                <td>Country of Orgin</td>
                                <td class="clr-t"> 
                                    <?php 
                                    $itemCountry = getCountryByCountryId($item->ori_country);
                                    ?> 
                                    Made in {{ strtoupper(@$itemCountry->name) }}
                                </td>
                            </tr>


                            </tbody>
                        </table>


                        <div>
                       
                            
                            <?php 
                                if($login=="true"){
                                    if($kyc == "true" ){
                                    if(@$isAdmin !="yes"){
                                       
                                           

                            ?>
                                 <div class="product-price">
                                        @if($item->price_per_pcs)
                                            <div class="item-price itm-pr itprce">Price Per Piece: ??? {{$item->price_per_pcs}}</div>
                                        @endif

                                        @if($item->set_of)
                                            <div class="item-price itm-pr itprce">1 set:  ({{$item->set_of}} Pcs)</div>
                                        @endif
                                        <?php 
                                         if($totalOff == 0){
                                        ?>
                                        
                                        	@if($item->price_per_kg)
												<div class="item-price itm-pr itprce">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}}/Kg</div>
											@endif
                                            <div class="item-price itm-pr itprce">
                                                Offer Price: ??? {{($item->regular_price)? $item->regular_price:0}}
                                                
                                                <span>({{$forIfoShowPrice}} + 
                                                {{$totalGst}} %GST)</span>
                                            </div>
                                            
                                            
                                            @if($item->item_mrp)
                                            <!-- <div class="item-discount-price itm-dpr"> -->
                                            <div class="item-price itm-dpr">MRP:
                                                <span> ???{{($item->item_mrp)? $item->item_mrp:''}}</span>
                                            </div>
                                            
                                            @endif
                                        <?php }else{ ?>

                                            @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
                                           <div class="item-price itm-pr itprce">
                                                Offer Price: ??? {{$AfterDiscountPrice}}
                                            </div>

                                            <!-- <div class="product-discount">
                                                <span class="discount">???{{($item->regular_price)? $item->regular_price:0}}</span>
                                            </div>  -->
                                            @if($item->item_mrp)
                                            <div class="item-price itm-dpr">MRP:
                                                <span>
                                                    ??? {{($item->item_mrp)? $item->item_mrp:''}}
                                                </span>
                                            </div>
                                            
                                            @endif

                                        <?php }?>
                                        @if($retailPrice)
									       <div class="itm-rlm">
                                                <span>{{$retailPrice}}%</span>
                                                Retail margin
                                           </div>
									@endif
                                           
                                        </div>
                                        <div class="product-purchase-container text-center" >
                                        <a href="javascript:void();" onclick="add_to_cart({{$item->item_id}})" class="btn btn-inverse btn-md width-200" style="float:none;">ADD TO CART</a></div>

                            <?php } else{?>
                                <h3 class="btn btn-img mt-2">Your are admin</h3>
                                <?php } }else{?>

                                    <h3 class="kyc-cm">Complete shop KYC to view price</h3>

                            <?php }}else{ ?>

                                <h3 class="btn btn-img mt-2">Login to see prices and buy</h3>

                            <?php } ?>
                        </div>








                     </div>
                     <div class="tab-pane fade" id="product-info">

                        <div class="desc">
                            {!! $item->description !!}
                            </div>
                        <div class="desc">
                            {!! $item->item_cart_remarks !!}
                            </div>
                    </div>
                    <!-- END #product-info -->
                    <!-- BEGIN #product-reviews -->
                    {{-- <div class="tab-pane fade" id="product-reviews">
                    <div class="desc">
                                <h4>iPhone 6s</h4>
                                <p>
                                    The moment you use iPhone 6s, you know you???ve never felt anything like it. With a single press, 3D Touch lets you do more than ever before. Live Photos bring your memories to life in a powerfully vivid way. And that???s just the beginning. Take a deeper look at iPhone 6s, and you???ll find innovation on every level.
                                </p>
                            </div>

                            <div class="desc">
                                <h4>iPhone 6s</h4>
                                <p>
                                    The moment you use iPhone 6s, you know you???ve never felt anything like it. With a single press, 3D Touch lets you do more than ever before. Live Photos bring your memories to life in a powerfully vivid way. And that???s just the beginning. Take a deeper look at iPhone 6s, and you???ll find innovation on every level.
                                </p>
                            </div>
                    </div> --}}

                   </div>


                    </div>



                </div>
                <!-- END product-info -->
            </div>
            <!-- END product-detail -->
            <!-- BEGIN product-tab -->
        
            <!-- END product-tab -->
        </div>
        <!-- END product -->
        <!-- BEGIN similar-product -->
        {{-- <h4 class="m-b-15 m-t-30">You Might Also Like Up sale product and cross sale</h4> --}}
        &nbsp;
        &nbsp;
        &nbsp;
        <div class="row">
            
            
        <?php
            $upsale_sale_item = get_item_by_item_id($item->product_up_sale);
                    if(!empty($upsale_sale_item))
                    {
        ?>
       
        
            <div class="col-md-6">
                <!-- BEGIN item -->
                <?php
                //Start for Up sale product code
                    
                        $product_up_sale = get_item_detail_by_item_id($upsale_sale_item->slug); 
                    
                        $product_up_saleImg = get_item_default_img_item_id($product_up_sale->item_id);
                
                        if($product_up_saleImg)
                        {
                            
                            $productUpSaleImg = BASE_URL.ITEM_IMG_PATH.'/'.$product_up_saleImg->img_name;
                            
                        } else {
                            
                            $productUpSaleImg = FRONT.'img/product/product-iphone.png';
                        }       

                    $itemForSales = DB::table('tbl_items')->where('slug', $upsale_sale_item->slug)->first();
                    @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $itemForSales->cat_id);
                    @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $itemForSales->cat_id);
                    @$AfterDiscountPrice = calculateItemDiscount($itemForSales->regular_price, $custClassDiscount, $custCatDiscount);
                   
                    $totalOff = $custCatDiscount + $custClassDiscount;
                    $retailPrice ='';
                    if($itemForSales->item_mrp > $itemForSales->regular_price){
    
                        @$retailPrice = getRetailPrice(Auth::user()->id,$itemForSales->item_id,$AfterDiscountPrice,$itemQTY=1);
                    }
               ?>
               
                    <div class="item item-thumbnail">
               

                        <a href="{{route('productDetail', $product_up_sale->slug)}}" class="item-image">
                            <img src="{{$productUpSaleImg}}" alt="{{$product_up_sale->product_name}}" />
                            <?php if($totalOff != 0){?>

                                <div class="discount">{{$totalOff}}% OFF</div>

                            <?php }?>
                        </a>
                        <div class="item-info">
                            <h4 class="item-title">
                            <a href="{{route('productDetail', $product_up_sale->slug)}}">{{$product_up_sale->product_name}}</a>
                            </h4>
                            <p class="item-desc">{!! \Str::limit(strip_tags($product_up_sale->description),100,'...') !!}</p>
                            
                            
                            @if($kyc == "true" && @$isAdmin != "yes")
                            <?php 
                                if($totalOff == 0){
                                    ?>

                                    

                                    @if($item->price_per_kg)
                                        <div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
                                    @endif
									<div class="item-price itm-pr">Offer Price:
                                        ???{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}}
                                    </div>
									
                                    @if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>??? {{($item->item_mrp)? $item->item_mrp:''}}</span>
                                    </div>
									@endif
                                <?php }else{ ?>

                                    @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
                                   <div class="item-price itm-pr">Offer Price: ??? {{$AfterDiscountPrice}}</div>
                                    <!-- <div class="item-discount-price">???{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}}</div> -->
                                    @if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>
                                            ??? {{($item->item_mrp)? $item->item_mrp:''}}
                                        </span>
                                    </div>
									@endif
                                <?php }?>

                                <!-- <div class="item-price">???{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}} </div> -->
                                 <!-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div>  -->

                                 @if($retailPrice)
									<div class="itm-rlm">
                                        <span>{{$retailPrice}}%</span>Retail margin</div>
									@endif
                                
                                
                                <a href="javascript:void();" onclick="add_to_cart(<?=$product_up_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                            
                            @endif

                        </div>
                  

               
                
                <!-- END item -->
            </div>
            
            
          
           
            
        </div>
        <?php }
        
        $cross_sale_item = get_item_by_item_id($item->product_cross_sale);
               if(!empty($cross_sale_item))
               {
        
        ?>

        {{-- <h4 class="m-b-15 m-t-30">You Might Also Like Cross sale product</h4> --}}
       
            <div class="col-md-6">
                <!-- BEGIN item -->
                <?php //Start for Cross sale product code
                
                    $product_cross_sale = get_item_detail_by_item_id($cross_sale_item->slug); 
                    
                    $product_cross_saleImg = get_item_default_img_item_id($product_cross_sale->item_id);  
                    if($product_cross_saleImg)
                    {
            
                        $productCrossSaleImg = BASE_URL.ITEM_IMG_PATH.'/'.$product_cross_saleImg->img_name;
                        
                    } else {
            
                        $productCrossSaleImg = FRONT.'img/product/product-iphone.png';
                    }  

                    $itemForSales = DB::table('tbl_items')->where('slug', $cross_sale_item->slug)->first();
                    @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $itemForSales->cat_id);
                    @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $itemForSales->cat_id);
                    @$AfterDiscountPrice = calculateItemDiscount($itemForSales->regular_price, $custClassDiscount, $custCatDiscount);
                   
                    $totalOff = $custCatDiscount + $custClassDiscount;

                    $retailPrice ='';
                    if($itemForSales->item_mrp > $itemForSales->regular_price){
    
                        @$retailPrice = getRetailPrice(Auth::user()->id,$itemForSales->item_id,$AfterDiscountPrice,$itemQTY=1);
                    }

           ?>
                <div class="item item-thumbnail">
                    <a href="{{route('productDetail', $product_cross_sale->slug)}}" class="item-image">
                        <img src="{{$productCrossSaleImg}}" alt="{{$product_cross_sale->product_name}}" />
                        <?php if($totalOff != 0){?>

                            <div class="discount">{{$totalOff}}% OFF</div>

                        <?php }?>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                        <a href="{{route('productDetail', $product_cross_sale->slug)}}">{{$product_cross_sale->product_name}}</a>
                        </h4>
                        <p class="item-desc">{!! \Str::limit(strip_tags($product_cross_sale->description),100,'...') !!}</p>
                        
                        @if($kyc == "true" && @$isAdmin != "yes")
                        <?php 
                                if($totalOff == 0){
                                    ?>

                                            @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
                                    <div class="item-price itm-pr">Offer Price: ??? {{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>??? {{($item->item_mrp)? $item->item_mrp:''}}</span></div>
									@endif
                                
                                <?php }else{ ?>
                                    @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif

                                    <div class="item-price itm-pr">Offer Price: ??? {{$AfterDiscountPrice}}</div>
                                    <!-- <div class="item-discount-price">???{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div> -->
                                    @if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>??? {{($item->item_mrp)? $item->item_mrp:''}} </span></div>
									@endif
                                
                                <?php }?>

                                @if($retailPrice)
									<div class="itm-rlm">
                                        <span>{{$retailPrice}}%</span>Retail margin</div>
									@endif

                            <!-- <div class="item-price">???{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div> -->
                            <!-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div>  -->
                            <a href="javascript:void();" onclick="add_to_cart(<?=$product_cross_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                        @endif
                    </div>
                </div>

                
               
                <!-- END item -->
           
            
          
        </div>

        <?php }?>


    </div>
   
    <div id="trending-items" class="section-container">
        <div class="container">
		<!-- BEGIN section-title -->
        <?php
        $items = relatedCatItems($itemCatId = $item->cat_id, $limit = 24, $skipItemId = $itemIdForRelated);
        if(count($items)>0){
        ?>
        <h4 class="section-title clearfix">

			Related Items
			
		</h4>
        
         <!-- start crousel -->
        <div class="row row-space-10">
			<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
				<div class="MultiCarousel-inner">

					<?php
                   
					//$items = relatedCatItems($itemCatId = $item->cat_id, $limit = 24, $skipItemId = $itemIdForRelated);


					$n = 1;
                    $max_val = 0;
					foreach ($items as $item) {
                        $itemCountInOrder = DB::table('tbl_item_orders')->where('item_id', $item->item_id)->count();
                        // if ($max_val < $itemCountInOrder){
                        //     $max_val = $itemCountInOrder;
                       
                        
                        if ($item->is_visible == 1) {

							$itemImages = get_item_default_img_item_id($item->item_id);

							if ($itemImages) {

								$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
							} else {

								$itemImg = FRONT . 'img/product/product-iphone.png';
							}
							@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
							@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
							@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
							
							$totalOff = $custCatDiscount + $custClassDiscount;
							//echo @$custClassDiscount."/".@$custCatDiscount."/".$totalOff."/".@$AfterDiscountPrice;

                            $totalOff = $custCatDiscount + $custClassDiscount;

                            $retailPrice ='';
                            if($item->item_mrp > $item->regular_price){
            
                                @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
                            }
					?>

							<!-- BEGIN item -->
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
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
								?>

                                    @if($item->price_per_kg)
                                        <div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
                                    @endif
									<div class="item-price itm-pr">Offer Price: ??? {{($item->regular_price)? $item->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>??? {{($item->item_mrp)? $item->item_mrp:''}}</span>
                                    </div>
									@endif
                                    <?php }else{ ?>

                                        @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
									<div class="item-price itm-pr">Offer Price: ??? {{$AfterDiscountPrice}}</div>

									<!-- <div class="item-discount-price">???{{($item->regular_price)? $item->regular_price:0}}</div> -->
									@if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>??? {{($item->item_mrp)? $item->item_mrp:''}}
                                        </span>
                                    </div>
									@endif
                                    
                                    <?php }?>
									
                                    @if($retailPrice)
									<div class="itm-rlm">
                                        <span>{{$retailPrice}}%</span>Retail margin</div>
									@endif

									<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>



								<?php } ?>

								

							</div>
				</div>
					
				
				<!-- END item -->

		<?php }
					} ?>

			</div>
			<button class="btn btn-primary leftLst">
				<</button> <button class="btn btn-primary rightLst">>
			</button>
		</div>
	</div>
    <?php }
    
    $itemOrders = DB::table('tbl_item_orders')->where('item_id', $itemIdForRelated)->get();
        $orderId=array();
        foreach ($itemOrders as $itemOrder) {
            $orderId[]= $itemOrder->order_id;
        }
        $itemOrderCounts = DB::table('tbl_item_orders')->whereIn('order_id', $orderId)
        ->where('item_id', '!=', $itemIdForRelated)
        ->select('tbl_item_orders.*', DB::raw('count(tbl_item_orders.item_id) as totalItemCount'))
        ->groupBy('tbl_item_orders.item_id')
        ->orderBY('totalItemCount', 'DESC')
        ->get();

        if(count($itemOrderCounts)>0){
    ?>
<!-- stend  related items crousel -->
<h4 class="section-title clearfix">
Frequently bought items
</h4>
    <!-- start bought items crousel -->
    <div class="row row-space-10">
			<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
				<div class="MultiCarousel-inner">

                <?php
					//$items = relatedCatItems($itemCatId = $item->cat_id, $limit = 24, $skipItemId = $item->item_id);
					
                    //pr( $itemOrderCounts);
                    
					$n = 1;
					foreach ($itemOrderCounts as $itemOrderCount) {
                        $item = frequentlyBoughtitems($itemOrderCount->item_id);
                        //pr($items);
                        
                         //foreach ($items as $item) {
                        //     $item = json_decode(json_encode($item), true);
						if (@$item->is_visible == 1) {

							$itemImages = get_item_default_img_item_id($item->item_id);

							if ($itemImages) {

								$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
							} else {

								$itemImg = FRONT . 'img/product/product-iphone.png';
							}
							@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
							@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
							@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
							
							$totalOff = $custCatDiscount + $custClassDiscount;
							//echo @$custClassDiscount."/".@$custCatDiscount."/".$totalOff."/".@$AfterDiscountPrice;
                            
                            $retailPrice ='';
                            if($item->item_mrp > $item->regular_price){
            
                                @$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
                            }
					?>

							<!-- BEGIN item -->
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
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
								?>

                                            @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
									<div class="item-price itm-pr">Offer Price: 
                                        ??? {{($item->regular_price)? $item->regular_price:0}}
                                    </div>
									@if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>
                                         ??? {{($item->item_mrp)? $item->item_mrp:''}}
                                        </span>
                                    </div>
									@endif
                                    <?php }else{ ?>

                                        @if($item->price_per_kg)
												<div class="item-price itm-pr">Price Per Kg: ??? {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
											@endif
									<div class="item-price itm-pr">Offer Price: 
                                     ??? {{$AfterDiscountPrice}}
                                    </div>

									<!-- <div class="item-discount-price">???{{($item->regular_price)? $item->regular_price:0}}</div> -->
									@if($item->item_mrp)
									<div class="item-price itm-dpr">MRP:
                                        <span>
                                            ??? {{($item->item_mrp)? $item->item_mrp:''}}
                                        </span>
                                    </div>
									@endif
                                    
                                    <?php }?>
									

                                    @if($retailPrice)
									<div class="itm-rlm">
                                        <span>{{$retailPrice}}%</span>Retail margin</div>
									@endif

									<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>



								<?php } ?>

								

							</div>
				</div>
					
				
				<!-- END item -->

		<?php }
					}   ?>

			</div>
			<button class="btn btn-primary leftLst"><
				</button> <button class="btn btn-primary rightLst">>
			</button>
		</div>
	</div>
    <?php }?>
<!-- end bought items crousel -->
</div>



        <!-- END similar-product -->
    </div>
    <!-- END container -->
</div>