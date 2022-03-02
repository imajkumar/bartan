<?php

$customerDetail = session()->get('customerForSalesPanel');

    $itemImages = get_gallery_img_by_item_id($item->item_id);
    
        $attrs = DB::table('tbl_items_attributes_data')->where('item_id', $item->item_id)
              ->orderBy('id','desc')
            //->groupBy('item_attr_admin_label')
            ->get();
        
        $nameAttr = '';
        foreach($attrs as $attr){
            
            $nameAttr .= $attr->item_attr_value.',';
        }

        @$custClassDiscount = getCustomerClassDiscount(@$customerDetail->user_id, $item->cat_id);
        @$custCatDiscount = getCustomerCategoryDiscount(@$customerDetail->user_id, $item->cat_id);
        @$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
        //echo $customerDetail->user_id;exit;
        $totalOff = $custCatDiscount + $custClassDiscount;

        $retailPrice ='';
        if($item->item_mrp > $item->regular_price){

            @$retailPrice = getRetailPrice($customer->user_id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
        }

        @$users = DB::table('tbl_customers')->where('user_id', $customerDetail->user_id)->first(); 

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
<div class="content">
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
                        <img src="{{($defaultImg) ? $defaultImg:$itemImg}}" id="zoom_mw" alt="img" />
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

                            <!-- {{$item->product_name.', '.chop($nameAttr, ',')}}  -->
                            {{$item->product_name}} 
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
                                                ->where('item_cat_id', $item->cat_id)
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
                                    {{$brand->name}}
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

                            @if($item->item_invt_min_order)
                                <tr>
                                    <td>Minimum Order quantity</td>
                                    <td class="clr-t">{{$item->item_invt_min_order}}</td>
                                </tr>
                            @endif

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
                       
                            <div class="product-price">
                                @if($item->price_per_pcs)
                                    <div class="item-price itm-pr itprce">Price Per Piece: ₹ {{$item->price_per_pcs}}</div>
                                @endif
                                @if($item->set_of)
                                    <div class="price itm-pr">1 set:  ({{$item->set_of}} Pcs)</div>
                                @endif
                                <?php 
                                if($totalOff == 0){
                                ?>
                                @if($item->price_per_kg)
										<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
									@endif
                                    <div class="price itm-pr"> Offer Price:₹{{($item->regular_price)? $item->regular_price:0}}
                                    
                                    <span>({{$forIfoShowPrice}} + 
                                                {{$totalGst}} %GST)</span>
                                    </div>
                                    @if($item->item_mrp)
                                    <div class="product-discount">
                                        <span class="itm-dpr"> MRP: <span>₹{{($item->item_mrp)? $item->item_mrp:''}}</span>
                                    </div> 
									
									@endif
                                <?php }else{ ?>

                                    @if($item->price_per_kg)
										<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
									@endif
                                    <div class="price itm-pr"> Offer Price:₹{{$AfterDiscountPrice}}</div>

                                    <div class="product-discount">
                                        <span class="itm-dpr"> MRP: <span>₹{{($item->item_mrp)? $item->item_mrp:0}}</span>
                                    </div> 

                                <?php }?>

                                @if($retailPrice)
                                    <div class="itm-rlm">
                                    <span>{{$retailPrice}}%</span> Retail margin</div>
                                @endif

                            </div>
                             <div class="product-purchase-container text-center" >
                            <a href="javascript:void();" onclick="add_to_cart({{$item->item_id}})" class="btn btn-inverse btn-theme btn-lg width-200" style="float:none;">ADD TO CART</a></div>

                            
                        </div>








                     </div>
                     <div class="tab-pane fade" id="product-info">

                        <div class="desc">
                            {!! $item->description !!}
                            </div>
                    </div>
                    <!-- END #product-info -->
                    <!-- BEGIN #product-reviews -->
                   

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
                        @$custClassDiscount = getCustomerClassDiscount(@$customerDetail->user_id, $itemForSales->cat_id);
                        @$custCatDiscount = getCustomerCategoryDiscount(@$customerDetail->user_id, $itemForSales->cat_id);
                        @$AfterDiscountPrice = calculateItemDiscount($itemForSales->regular_price, $custClassDiscount, $custCatDiscount);
                        //echo $customerDetail->user_id;exit;
                        $totalOff = $custCatDiscount + $custClassDiscount;
               ?>
               
                    <div class="item item-thumbnail">
               

                        <a href="{{route('salesProductDetail', $product_up_sale->slug)}}" class="item-image">
                            <img src="{{$productUpSaleImg}}" alt="{{$product_up_sale->product_name}}" />
                           
                            <?php if($totalOff != 0){?>

                                <div class="discount">{{$totalOff}}% OFF</div>

                            <?php }?>

                        </a>
                        <div class="item-info">
                            <h4 class="item-title">
                            <a href="{{route('salesProductDetail', $product_up_sale->slug)}}">{{$product_up_sale->product_name}}</a>
                            </h4>
                            <p class="item-desc">{{\Str::limit(strip_tags($product_up_sale->description),100,'...')}}</p>
                            
                            <?php 
                                if($totalOff == 0){
                                    ?>

									<div class="item-price">₹{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}}</div>
									
                                    @if($product_up_sale->item_mrp)
									<div class="item-price">₹{{($product_up_sale->item_mrp)? $product_up_sale->item_mrp:''}}</div>
									@endif

                                <?php }else{ ?>

                                    <div class="item-price">₹{{$AfterDiscountPrice}}</div>
                                    <div class="item-price">₹{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}}</div>
                                
                                <?php }?>

                                <!-- <div class="item-price">₹{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}} </div> -->
                                {{-- <div class="item-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
                                <a href="javascript:void();" onclick="add_to_cart(<?=$product_up_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                            
                            

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
                    @$custClassDiscount = getCustomerClassDiscount(@$customerDetail->user_id, $itemForSales->cat_id);
                    @$custCatDiscount = getCustomerCategoryDiscount(@$customerDetail->user_id, $itemForSales->cat_id);
                    @$AfterDiscountPrice = calculateItemDiscount($itemForSales->regular_price, $custClassDiscount, $custCatDiscount);
                    //echo $customerDetail->user_id;exit;
                    $totalOff = $custCatDiscount + $custClassDiscount;

           ?>
                <div class="item item-thumbnail">
                    <a href="{{route('salesProductDetail', $product_cross_sale->slug)}}" class="item-image">
                        <img src="{{$productCrossSaleImg}}" alt="{{$product_cross_sale->product_name}}" />
                        <?php if($totalOff != 0){?>

                            <div class="discount">{{$totalOff}}% OFF</div>

                        <?php }?>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                        <a href="{{route('salesProductDetail', $product_cross_sale->slug)}}">{{$product_cross_sale->product_name}}</a>
                        </h4>
                        <p class="item-desc">{{\Str::limit(strip_tags($product_cross_sale->description),100,'...')}}</p>
                        
                        
                        <?php 
                                if($totalOff == 0){
                                    ?>

                                    @if($item->price_per_kg)
										<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
									@endif
                                    <div class="item-price">₹{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div>
									@if($product_cross_sale->item_mrp)
									<div class="item-price">₹{{($product_cross_sale->item_mrp)? $product_cross_sale->item_mrp:''}}</div>
									@endif
                                
                                <?php }else{ ?>

                                    @if($item->price_per_kg)
										<div class="item-price itm-pr">Price Per Kg: ₹ {{($item->price_per_kg)? $item->price_per_kg:0}} /Kg</div>
									@endif
                                    <div class="item-price">₹{{$AfterDiscountPrice}}</div>
                                    <div class="item-price">₹{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div>
                                  
                                
                                <?php }?>

                            <!-- <div class="item-price">₹{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div> -->
                            {{-- <div class="item-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
                            <a href="javascript:void();" onclick="add_to_cart(<?=$product_cross_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                       
                    </div>
                </div>

                
               
                <!-- END item -->
           
            
          
        </div>

        <?php }?>
    </div>
        <!-- END similar-product -->
    </div>
    <!-- END container -->
</div>
</div>
