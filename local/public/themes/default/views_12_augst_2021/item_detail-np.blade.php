<?php

    if(Auth::user()){

        if(Auth::user()->user_type ==0){

            if(Auth::user()->profile == 1){

                $kyc = 'true';

            }else{

                $kyc = 'false';
            }
        }else{

            $kyc = 'true';
        }


    }else{

        $kyc = 'false';
    }
 

    $itemImages = get_gallery_img_by_item_id($item->item_id);
    
        $attrs = DB::table('tbl_items_attributes_data')->where('item_id', $item->item_id)
              ->orderBy('id','desc')
            //->groupBy('item_attr_admin_label')
            ->get();
        
        $nameAttr = '';
        foreach($attrs as $attr){
            
            $nameAttr .= $attr->item_attr_value.',';
        }

?>
<style>
    .required-star {
        color: red;
    }
</style>
<!-- BEGIN #product -->
<div id="product" class="section-container p-t-20">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN breadcrumb -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Mobile Phone</a></li>
            <li class="breadcrumb-item"><a href="#">Apple</a></li>
            <li class="breadcrumb-item active">iPhone 6S Plus</li>
        </ul>
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
                            $itemImg = FRONT.'img/product/product-iphone-6s-plus.png';
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
                        <img src="{{($defaultImg) ? $defaultImg:$itemImg}}" alt="img" />
                    </div>
                    <!-- END product-main-image -->
                </div>
                <!-- END product-image -->
                <!-- BEGIN product-info -->
                <div class="product-info">
                    <!-- BEGIN product-info-header -->
                    <div class="product-info-header">
                        <h1 class="product-title">
                           
                            {{-- <span class="badge bg-primary">41% OFF</span>  --}}
                            {{$item->product_name.', '.chop($nameAttr, ',')}} </h1>
                        <ul class="product-category">
                            <li><a href="#"><?php echo get_group_category_cat_id($item->cat_id);?></a></li>
                            {{-- <li>/</li>
                            <li><a href="#">mobile phone</a></li>
                            <li>/</li>
                            <li><a href="#">electronics</a></li>
                            <li>/</li>
                            <li><a href="#">lifestyle</a></li> --}}
                        </ul>
                    </div>
                    <!-- END product-info-header -->
                    <!-- BEGIN product-warranty -->
                    <div class="product-warranty">
                    <div class="pull-right">Availability: {{($item->product_status == 1) ? 'In stock':'Out of stock'}}</div>
                        {{-- <div><b>1 Year</b> Local Manufacturer Warranty</div> --}}
                    <br>
                    </div>
                    <!-- END product-warranty -->
                    <!-- BEGIN product-info-list -->
                    <ul class="product-info-list">
                        {!! $item->description !!}
                        
                    </ul>
                    <form method="post" name="attrSelectionItemDescription" id="attrSelectionItemDescription">
                    <ul class="product-info-list">
                        <?php 
                        
                        $attrDatas = DB::table('tbl_items_attributes_data')
                                ->where('item_id', $item->item_id)
                                ->get();
                        $attributess=array();
                        foreach($attrDatas as $attrData){

                            $att = DB::table('tbl_item_category_child')
                            ->leftjoin('tbl_attributes', 'tbl_attributes.id','=','tbl_item_category_child.item_attr_id')
                            
                            ->where('tbl_item_category_child.item_attr_id', $attrData->item_attr_id)
                            ->where('tbl_item_category_child.item_category_id', $item->cat_id)
                            ->select('tbl_item_category_child.*', 'tbl_attributes.type')
                            ->first();
                            $attributess[] = (array) $att;
                        }

                        $attributess = unique_multidim_array($attributess, 'item_attr_id');
                        $required = '';
                        $num = 1;
                        $requiredValidation = array();
                        foreach($attributess as $attributes)
                        {

                            $attrOptions = DB::table('tbl_items_attributes_data')
                                ->where('item_id', $item->item_id)
                                //->where('item_cat_id', $attributes->item_category_id)
                                ->where('item_attr_id', $attributes['item_attr_id'])
                                ->get();
                           
                                $star = '';
                                
                                if($attributes['is_required'] == 1)
                                {
                                    $star ='<span class="required-star">*</span>';
                                    $required = 'required';
                                    $requiredValidation[] = $num;

                                } 
                                if($attributes['type'] == 'select'){


                    ?>

                                <label class="col-form-label">{{@$attrOptions[0]->item_attr_admin_label}} {!! $star !!}</label>

                                <select class="form-control" name="attributes" id="attrSelect_{{$num}}" {{$required}}>
                                    <option value="" desabled>{{@$attrOptions[0]->item_attr_admin_label}}</option>
                                    @foreach($attrOptions as $attrOption)
                                    <option value="{{$attrOption->id}}">{{$attrOption->item_attr_value}}</option>
                                    @endforeach
                                </select>
                                    <span id="attrSelectError_{{$num}}"></span>

                                    <?php
                                } else if($attributes['type'] == 'multiselect') {

                                    ?>

                                    <select class="form-control" name="attributes[]" multiple {{$required}}>
                                        @foreach($attrOptions as $attrOption)
                                        <option value="{{$attrOption->id}}" >{{$attrOption->item_attr_value}}</option>
                                        @endforeach
                                    </select>

                                    <?php
                                }
                                  else if($attributes['type'] == 'checkbox'){
                                                
                                        ?>

                                        @foreach($attrOptions as $attrOption)
                                            <label class="col-form-label" style="margin-top: 11px;
                                            margin-left: 122px;">{{$attrOption->item_attr_value}}</label>
                                            <input class="form-control" type="{{$attributes['type']}}" name="attributes[]" value="{{$attrOption->id}}" {{$required}}>
                                        @endforeach

                                <?php } else {?>

                                        <input class="form-control" type="{{$attributes['type']}}" name="attributes" {{$required}}>
                                <?php }?>   

                                           
                        
                    <?php $num++;} ?>
                    </ul>
                    <!-- END product-info-list -->
                    <!-- BEGIN product-social -->
                    {{-- <div class="product-social">
                        <ul>
                            <li><a href="javascript:;" class="facebook" data-toggle="tooltip" data-trigger="hover" data-title="Facebook" data-placement="top"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="javascript:;" class="twitter" data-toggle="tooltip" data-trigger="hover" data-title="Twitter" data-placement="top"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="javascript:;" class="google-plus" data-toggle="tooltip" data-trigger="hover" data-title="Google Plus" data-placement="top"><i class="fab fa-google-plus-g"></i></a></li>
                            <li><a href="javascript:;" class="whatsapp" data-toggle="tooltip" data-trigger="hover" data-title="Whatsapp" data-placement="top"><i class="fab fa-whatsapp"></i></a></li>
                            <li><a href="javascript:;" class="tumblr" data-toggle="tooltip" data-trigger="hover" data-title="Tumblr" data-placement="top"><i class="fab fa-tumblr"></i></a></li>
                        </ul>
                    </div> --}}
                    <!-- END product-social -->
                    <!-- BEGIN product-purchase-container -->
                    <div class="product-purchase-container">
                        {{-- <div class="product-discount">
                            <span class="discount">$869.00</span>
                        </div> --}}
                        @if($kyc == "true")

                            <div class="product-price">
                                <div class="price">₹{{($item->regular_price)? $item->regular_price:0}}</div>
                            </div>
                            
                        @endif

                        <?php 
                           //pr($requiredValidation);
                        if($kyc == "true"){

                            if(count($requiredValidation)>0){
                        ?>
                            <a href="javascript:void(0);" onclick="attrValidationAndAddToCart({{count($requiredValidation)}},{{$item->item_id}})" class="btn btn-inverse btn-theme btn-lg width-200">ADD TO CART</a>
                            
                        <?php } else {?>

                            <a href="javascript:void();" onclick="add_to_cart({{$item->item_id}})" class="btn btn-inverse btn-theme btn-lg width-200">ADD TO CART</a>

                        <?php } }else{ ?>
                            <h3>Complete Your KYC then price and add to cart avlable</h3>
                            <?php }?>

                         </div>
                </form>
                    <!-- END product-purchase-container -->
                </div>
                <!-- END product-info -->
            </div>
            <!-- END product-detail -->
            <!-- BEGIN product-tab -->
            {{-- <div class="product-tab">
                <!-- BEGIN #product-tab -->
                <ul id="product-tab" class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#product-desc" data-toggle="tab">Product Description</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product-info" data-toggle="tab">Additional Information</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product_up_sale" data-toggle="tab">Product Up Sale</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product_cross_sale" data-toggle="tab">Product Cross Sale</a></li>
                    <li class="nav-item"><a class="nav-link" href="#product-reviews" data-toggle="tab">Rating & Reviews (5)</a></li>
                </ul>
                <!-- END #product-tab -->
                <!-- BEGIN #product-tab-content -->
                <div id="product-tab-content" class="tab-content">
                    <!-- BEGIN #product-desc -->
                    <div class="tab-pane fade active show" id="product-desc">
                        <!-- BEGIN product-desc -->
                        <div class="product-desc">
                            {!! $item->description !!}
                        </div>
                        <!-- END product-desc -->
                        
                        
                        
                    </div>
                    <!-- END #product-desc -->
                    <!-- BEGIN #product-info -->
                    <div class="tab-pane fade" id="product-info">
                        <!-- BEGIN table-responsive -->
                        
                        <!-- END table-responsive -->
                    </div>
                   
                    <div class="tab-pane fade" id="product_up_sale">
                       
                       
                    </div>
                <div class="tab-pane fade" id="product_cross_sale">
                    <!-- BEGIN table-responsive -->
                   
                    <!-- END table-responsive -->
                </div>

                    <!-- END #product-info -->
                    <!-- BEGIN #product-reviews -->
                    <div class="tab-pane fade" id="product-reviews">
                        <!-- BEGIN row -->
                       
                        <!-- END row -->
                    </div>
                    <!-- END #product-reviews -->
                </div>
                <!-- END #product-tab-content -->
            </div> --}}
            <!-- END product-tab -->

            {{-- Start item information --}}
            <div class="table-responsive">
                <!-- BEGIN table-product -->
                <table class="table table-product table-striped">
                    {{-- <thead>
                        <tr>
                            <th></th>
                            <th>iPhone 6s</th>
                            <th>iPhone 6s Plus</th>
                        </tr>
                    </thead> --}}
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
                            <td class="field">{{ucfirst($keyCode)}}</td>
                            <td>
                            {{ucfirst(chop($attrVals, ', '))}}<br />
                               
                            </td>
                            
                        </tr>

                        <?php }?>

                        {{-- <tr>
                            <td class="field">Weight and Dimensions</td>
                            <td>
                                5.44 inches (138.3 mm) x 2.64 inches (67.1 mm) x 0.28 inch (7.1 mm)<br />
                                Weight: 5.04 ounces (143 grams)
                            </td>
                           
                        </tr> --}}
                        
                        {{-- <tr>
                            <td class="field">Chip</td>
                            <td colspan="2">
                                A9 chip with 64-bit architecture Embedded M9 motion coprocessor
                            </td>
                        </tr> --}}
                      
                        
                    </tbody>
                </table>
                <!-- END table-product -->
            </div>
            {{-- End item information --}}


            {{-- Start up sale product --}}
            <div class="table-responsiv">
                <span>Up sale Item</span>
                <div class="search-item-container">
           

                   <?php
                    //Start for Up sale product code
                        $upsale_sale_item = get_item_by_item_id($item->product_up_sale);
                        if(!empty($upsale_sale_item))
                        {
                            $product_up_sale = get_item_detail_by_item_id($upsale_sale_item->slug); 
                        
                            $product_up_saleImg = get_item_default_img_item_id($product_up_sale->item_id);
                    
                            if($product_up_saleImg)
                            {
                                
                                $productUpSaleImg = BASE_URL.ITEM_IMG_PATH.'/'.$product_up_saleImg->img_name;
                                
                            } else {
                                
                                $productUpSaleImg = FRONT.'img/product/product-iphone.png';
                            }       
                   ?>
                   
                        <div class="item item-thumbnail">
                   

                            <a href="{{route('productDetail', $product_up_sale->slug)}}" class="item-image">
                                <img src="{{$productUpSaleImg}}" alt="{{$product_up_sale->product_name}}" />
                                {{-- <div class="discount">15% OFF</div> --}}
                            </a>
                            <div class="item-info">
                                <h4 class="item-title">
                                <a href="{{route('productDetail', $product_up_sale->slug)}}">{{$product_up_sale->product_name}}</a>
                                </h4>
                                <p class="item-desc">{{\Str::limit(strip_tags($product_up_sale->description),100,'...')}}</p>
                                
                                @if($kyc == "true")

                                    <div class="item-price">₹{{($product_up_sale->regular_price)? $product_up_sale->regular_price:0}} </div>
                                    {{-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
                                    <a href="javascript:void();" onclick="add_to_cart(<?=$product_up_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                                
                                @endif

                            </div>
                        </div>

                    <?php }else{?>
                        <h2>Up sale item not found</h2>
                    <?php }?>
                </div>
                <!-- END table-responsive -->
            </div>
            {{-- End up sale product --}}

            {{-- Start Cross sale product --}}
            <span>Cross sale item</span>
            <div class="search-item-container">
                <!-- BEGIN item-row -->
               <?php //Start for Cross sale product code
                    $cross_sale_item = get_item_by_item_id($item->product_cross_sale);
                   if(!empty($cross_sale_item))
                   {
                        $product_cross_sale = get_item_detail_by_item_id($cross_sale_item->slug); 
                        
                        $product_cross_saleImg = get_item_default_img_item_id($product_cross_sale->item_id);  
                        if($product_cross_saleImg)
                        {
                
                            $productCrossSaleImg = BASE_URL.ITEM_IMG_PATH.'/'.$product_cross_saleImg->img_name;
                            
                        } else {
                
                            $productCrossSaleImg = FRONT.'img/product/product-iphone.png';
                        }  

               ?>
                    <div class="item item-thumbnail">
                        <a href="{{route('productDetail', $product_cross_sale->slug)}}" class="item-image">
                            <img src="{{$productCrossSaleImg}}" alt="{{$product_cross_sale->product_name}}" />
                            {{-- <div class="discount">15% OFF</div> --}}
                        </a>
                        <div class="item-info">
                            <h4 class="item-title">
                            <a href="{{route('productDetail', $product_cross_sale->slug)}}">{{$product_cross_sale->product_name}}</a>
                            </h4>
                            <p class="item-desc">{{\Str::limit(strip_tags($product_cross_sale->description),100,'...')}}</p>
                            
                            @if($kyc == "true")


                                <div class="item-price">₹{{($product_cross_sale->regular_price)? $product_cross_sale->regular_price:0}}</div>
                                {{-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
                                <a href="javascript:void();" onclick="add_to_cart(<?=$product_cross_sale->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
                            @endif
                        </div>
                    </div>

                    <?php }else{?>
                        <h2>UpCross sale item not found</h2>
                    <?php }?>
                
            </div>
            {{-- End Cross sale product --}}
        </div>
 
        <!-- END product -->
        <!-- BEGIN similar-product -->
        {{-- <h4 class="m-b-15 m-t-30">You Might Also Like</h4>
        <div class="row row-space-10">
            
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="../assets/img/product/product-samsung-note5.png" alt="">
                        <div class="discount">32% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Samsung Galaxy Note 5<br>Black</a>
                        </h4>
                        <p class="item-desc">Super. Computer. Now in two sizes.</p>
                        <div class="item-price">$599.00</div>
                        <div class="item-discount-price">$799.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="../assets/img/product/product-iphone-se.png" alt="">
                        <div class="discount">20% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">iPhone SE<br>32/64Gb</a>
                        </h4>
                        <p class="item-desc">A big step for small.</p>
                        <div class="item-price">$499.00</div>
                        <div class="item-discount-price">$599.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="../assets/img/product/product-zenfone2.png" alt="">
                        <div class="discount">15% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product_detail.html">Assus ZenFone 2<br>‏(ZE550ML)</a>
                        </h4>
                        <p class="item-desc">See What Others Can’t See</p>
                        <div class="item-price">$399.00</div>
                        <div class="item-discount-price">$453.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="../assets/img/product/product-xperia-z.png" alt="">
                        <div class="discount">32% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Sony Xperia Z<br>Black Color</a>
                        </h4>
                        <p class="item-desc">For unexpectedly beautiful moments</p>
                        <div class="item-price">$599.00</div>
                        <div class="item-discount-price">$799.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="../assets/img/product/product-lumia-532.png" alt="">
                        <div class="discount">20% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Microsoft Lumia 531<br>Smartphone Orange</a>
                        </h4>
                        <p class="item-desc">1 Year Local Manufacturer Warranty</p>
                        <div class="item-price">$99.00</div>
                        <div class="item-discount-price">$199.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
        </div>  --}}
        <!-- END similar-product -->
    </div>
    <!-- END container -->
</div>
<!-- END #product -->






{{-- ---------------------------------------------------------------------------------------- --}}

<div id="product" class="section-container p-t-20">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN breadcrumb -->
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="#">Mobile Phone</a></li>
            <li class="breadcrumb-item"><a href="#">Apple</a></li>
            <li class="breadcrumb-item active">iPhone 6S Plus</li>
        </ul>
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
                            $itemImg = FRONT.'img/product/product-iphone-6s-plus.png';
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
                        <img src="{{($defaultImg) ? $defaultImg:$itemImg}}" alt="img" />
                    </div>
                    <!-- END product-main-image -->
                </div>
                <!-- END product-image -->
                <!-- BEGIN product-info -->
                <div class="product-info">
                    <!-- BEGIN product-info-header -->
                    <div class="product-info-header">
                        <h1 class="product-title">
                            {{-- <span class="badge bg-primary">41% OFF</span>  --}}
                            {{$item->product_name.', '.chop($nameAttr, ',')}} 
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
                      <li class="nav-item"><a class="nav-link" href="#product-reviews" data-toggle="tab">Additional Information</a></li>
                     </ul>


               <div id="product-tab-content" class="tab-content">
                    <!-- BEGIN #product-desc -->
                    <div class="tab-pane fade active show" id="product-desc">
                         
                         <table class="table table-bordered">

<tbody>
<tr>
<td>In The Box</td>
<td class="clr-t">Handset, Adapter 5V/2A</td>

</tr>
<tr>
<td>Model Number</td>
<td class="clr-t">RMX2030</td>
</tr>
<tr>
<td>Model Name</td>
<td class="clr-t">5i</td>
</tr>
<tr>
<td>Color</td>
<td class="clr-t">Forest Green</td>
</tr>

<tr>
<td>Browse Type</td>
<td class="clr-t">Smartphones</td>
</tr>
<tr>
<td>SIM Type</td>
<td class="clr-t">Dual Sim</td>
</tr>

<tr>
<td>Hybrid Sim Slot</td>
<td class="clr-t">No</td>
</tr>
<tr>
<td>Touchscreen</td>
<td class="clr-t">Yes</td>
</tr>

<tr>
<td>Touchscreen</td>
<td class="clr-t">Yes</td>
</tr>

<tr>
<td>Country of Orgin</td>
<td class="clr-t"><img src="assets/img/icon/india-flag.png" class="user-icon" alt="">  Made in INDIA</td>
</tr>


</tbody>
</table>
                     </div>
                     <div class="tab-pane fade" id="product-info">

                        <div class="desc">
                            {!! $item->description !!}
                            </div>
                    </div>
                    <!-- END #product-info -->
                    <!-- BEGIN #product-reviews -->
                    <div class="tab-pane fade" id="product-reviews">
                    <div class="desc">
                                <h4>iPhone 6s</h4>
                                <p>
                                    The moment you use iPhone 6s, you know you’ve never felt anything like it. With a single press, 3D Touch lets you do more than ever before. Live Photos bring your memories to life in a powerfully vivid way. And that’s just the beginning. Take a deeper look at iPhone 6s, and you’ll find innovation on every level.
                                </p>
                            </div>

                            <div class="desc">
                                <h4>iPhone 6s</h4>
                                <p>
                                    The moment you use iPhone 6s, you know you’ve never felt anything like it. With a single press, 3D Touch lets you do more than ever before. Live Photos bring your memories to life in a powerfully vivid way. And that’s just the beginning. Take a deeper look at iPhone 6s, and you’ll find innovation on every level.
                                </p>
                            </div>
                    </div>

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
        <h4 class="m-b-15 m-t-30">You Might Also Like</h4>
        <div class="row row-space-10">
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-iphone.png" alt="">
                        <div class="discount">15% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product_detail.html">iPhone 6s Plus<br>16GB</a>
                        </h4>
                        <p class="item-desc">3D Touch. 12MP photos. 4K video.</p>
                        <div class="item-price">$649.00</div>
                        <div class="item-discount-price">$739.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-samsung-note5.png" alt="">
                        <div class="discount">32% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Samsung Galaxy Note 5<br>Black</a>
                        </h4>
                        <p class="item-desc">Super. Computer. Now in two sizes.</p>
                        <div class="item-price">$599.00</div>
                        <div class="item-discount-price">$799.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-iphone-se.png" alt="">
                        <div class="discount">20% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">iPhone SE<br>32/64Gb</a>
                        </h4>
                        <p class="item-desc">A big step for small.</p>
                        <div class="item-price">$499.00</div>
                        <div class="item-discount-price">$599.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-zenfone2.png" alt="">
                        <div class="discount">15% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product_detail.html">Assus ZenFone 2<br>‏(ZE550ML)</a>
                        </h4>
                        <p class="item-desc">See What Others Can’t See</p>
                        <div class="item-price">$399.00</div>
                        <div class="item-discount-price">$453.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-xperia-z.png" alt="">
                        <div class="discount">32% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Sony Xperia Z<br>Black Color</a>
                        </h4>
                        <p class="item-desc">For unexpectedly beautiful moments</p>
                        <div class="item-price">$599.00</div>
                        <div class="item-discount-price">$799.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
            <div class="col-lg-2 col-md-4">
                <!-- BEGIN item -->
                <div class="item item-thumbnail">
                    <a href="product_detail.html" class="item-image">
                        <img src="assets/img/product/product-lumia-532.png" alt="">
                        <div class="discount">20% OFF</div>
                    </a>
                    <div class="item-info">
                        <h4 class="item-title">
                            <a href="product.html">Microsoft Lumia 531<br>Smartphone Orange</a>
                        </h4>
                        <p class="item-desc">1 Year Local Manufacturer Warranty</p>
                        <div class="item-price">$99.00</div>
                        <div class="item-discount-price">$199.00</div>
                    </div>
                </div>
                <!-- END item -->
            </div>
        </div>
        <!-- END similar-product -->
    </div>
    <!-- END container -->
</div>