<div id="content" class="content">


    <div class="row">

        <div class="col-xl-12">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Product Details</span>
                        <span class="d-sm-block d-none">Product Details</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Attribute</span>
                        <span class="d-sm-block d-none">Attribute</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-3" id="galleryTab" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Gallery</span>
                        <span class="d-sm-block d-none">Gallery</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Product Relation</span>
                        <span class="d-sm-block d-none">Product Relation</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-5" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Taxation</span>
                        <span class="d-sm-block d-none">Taxation</span>
                    </a>
                </li>


            </ul>
            <div class="tab-content">

                <div class="tab-pane fade active show" id="default-tab-1">

                    <form action="{{route('saveChangesProductDetails')}}" method="post" id="ajaxProductAttrSaveEditNeeraj">
                        <input type="hidden" name="txtItemID" value="{{$item->item_id}}">
                        @csrf

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label >Product Name</label>
                                    <input type="text" class="form-control" name="item_name" value="{{optional($item)->itemName}}">
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Barcode</label>
                                    <input type="text" class="form-control itemBarcode" name="barcode" id="{{$item->item_id}}" maxlength="13" value="{{optional($item)->barcode}}">
                                    

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >SKU</label>
                                    <input type="text" class="form-control" name="item_sku" value="{{optional($item)->item_sku}}"  placeholder="SKU">
                                    <!-- <input type="text" class="form-control" name="item_sku" value="{{$sku}}"  placeholder="SKU"> -->
                                </div>

                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Brand</label>
                                    <select class="form-control" id="brand" name="brand_id" data-parsley-required="true" placeholder="Brand">
                                        @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" {{($brand->id==$item->brand_id)? 'selected':''}}>{{ucwords($brand->name)}}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                             
                        </div>


                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label >Product Discription Hide <input type="checkbox" name="is_description_hide" {{(@$item->is_description_hide == 1)? "checked":"" }} value="1" id="is_description_hide"/></label>
                                    <textarea class="ckeditor" id="editor1" name="product_discription" rows="20">
                                    {{ optional($item)->description }}

                                    </textarea>

                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Search Term</label>

                                    <ul id="jquery-tagIt-default">
                                        <?php
                                        $tags = DB::table('tbl_item_tags')->where('item_id', $item->item_id)->get();
                                        foreach($tags as $tag){
                                        ?>
                                            <li>{{$tag->tag_name}}</li>

                                        <?php }?>

                                        </ul>

                                  <!--   <select name="productTag[]" class="multiple-select2 select2 form-control" id="jquery-tagIt-default" multiple="multiple">
                                        <optgroup label="Tags">
                                            <option value="AK">Alaska</option>
                                            <option value="HI">Hawaii</option>
                                        </optgroup>

                                    </select>
 -->
                                </div>
                               

                            </div>
                        </div>

                        
                        <hr>
                        <!-- Stock and Selling -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Inventry UNIT</label>
                                    <input type="text" value="{{optional($item)->invt_unit}}" class="form-control" name="invt_unit">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >QTY</label>
                                    <input type="text" value="{{optional($item)->invt_qty}}" class="form-control"  placeholder="QTY" name="invt_qty">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Sales UNIT</label>
                                    <select class="form-control" id="invt_saleunit" name="invt_saleunit" data-parsley-required="true" placeholder="Brand">
                                        <option value="Per Box" {{(optional($item)->invt_saleunit == 'Per Box')? 'selected' : ''}}>Per Box</option>
                                        <option value=">Per Pcs" {{(optional($item)->invt_saleunit == 'Per Pcs')? 'selected' : ''}}>Per Pcs</option>
                                        <option value="Per Dozen" {{(optional($item)->invt_saleunit == 'Per Dozen')? 'selected' : ''}}>Per Dozen</option>
                                        <option value="Per Tag" {{(optional($item)->invt_saleunit == 'Per Tag')? 'selected' : ''}}>Per Tag</option>
                                        <option value="Per Set" {{(optional($item)->invt_saleunit == 'Per Set')? 'selected' : ''}}>Per Set</option>
                                        <option value="Per Kg" {{(optional($item)->invt_saleunit == 'Per Kg')? 'selected' : ''}}>Per Kg</option>

                                    </select>

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Regular Price</label>

                                    <input type="text" value="{{optional($item)->regular_price}}" name="regular_price" id="regular_price" class="form-control"  placeholder="">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >MRP</label>

                                    <input type="text" value="{{optional($item)->item_mrp}}" name="item_mrp" class="form-control"  placeholder="Enter item MRP">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Country of Origin</label>
                                    <select class="form-control" id="ori_country" name="ori_country" data-parsley-required="true" placeholder="Brand">
                                        @foreach(getCountry() as $brand)

                                            @if($brand->id == '101' || $brand->id == '44')
                                            <option value="{{$brand->id}}" {{($brand->id==$item->ori_country || $brand->id == '101')? 'selected':''}}>{{ucwords($brand->name)}}</option>
                                            @endif
                                            
                                        @endforeach
                                    </select>

                                </div>

                            </div>
                        </div>
                        <!-- Stock and Selling -->
                        <!-- volume settings  -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Length (in cm)</label>
                                    <input type="text" value="{{optional($item)->item_invt_lengh}}" class="form-control volumeCount" name="item_invt_lengh" id="item_invt_lengh">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Width (in cm)</label>
                                    <input type="text" class="form-control volumeCount" value="{{optional($item)->item_invt_width}}" name="item_invt_width" id="item_invt_width">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Height (in cm)</label>

                                    <input type="text" class="form-control volumeCount" value="{{optional($item)->item_invt_height}}" name="item_invt_height" id="item_invt_height">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Volumetric weight (in kg)</label>

                                    <input type="text" class="form-control"  value="{{optional($item)->item_invt_volume}}" placeholder="In kg" name="item_invt_volume" id="item_invt_height_volume">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Weight (in kg)</label>

                                    <input type="text" onkeyup="countPricePerPscAndRegularPrice()" name="item_invt_weight" id="item_invt_weight" value="{{optional($item)->item_invt_weight}}" class="form-control"  placeholder="">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Min Order QTY</label>

                                    <input type="text" name="item_invt_min_order" value="{{optional($item)->item_invt_min_order}}" class="form-control"  placeholder="">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Price per kg</label>

                                    <input type="text" onkeyup="countPricePerPscAndRegularPrice()" name="price_per_kg" id="price_per_kg" value="{{optional($item)->price_per_kg}}" class="form-control"  placeholder="price per kg">

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Item cart remarks</label>

                                    <textarea name="item_cart_remarks" class="form-control"  placeholder="Item cart remarks">{{optional($item)->item_cart_remarks}}</textarea>

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label > Is Tax Included</label>

                                    <input type="checkbox" value="1" {{(optional($item)->is_tax_included == 1) ? 'checked':''}} class="form-control" name="is_tax_included">
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Trending Item Sequence No.</label>

                                    <input type="number" min="1" name="trending_item" value="{{optional($item)->trending_item}}" class="form-control"  placeholder="Trending item">

                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >Set of</label>

                                    <input type="text" onkeyup="countPricePerPscAndRegularPrice()" name="set_of" id="set_of" value="{{optional($item)->set_of}}" class="form-control"  placeholder="Set of">

                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Price per Pcs</label>

                                    <input type="text" onkeyup="countPricePerPscAndRegularPrice()" name="price_per_pcs" id="price_per_pcs" value="{{optional($item)->price_per_pcs}}" class="form-control"  placeholder="Price per pcs">

                                </div>

                            </div>
                        </div>
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="SAVE CHANGES" id="SAVE_CHANGES" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        <!-- volume settings  -->
                    </form>

                </div>

                <?php
                //$dataObjArr = getItemCategoryes();
                 $dataObjArr = getItemCategory();
                ?>
                <div class="tab-pane fade" id="default-tab-2" style="padding:10px;background-color: #b6c2c9;">
                    <!-- Attribute  -->
                    <!-- tab new  -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a href="#default-tab-1A" data-toggle="tab" class="nav-link active">
                                <span class="d-sm-none">Item Attributes</span>
                                <span class="d-sm-block d-none">Item Attributes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#default-tab-2A" data-toggle="tab" class="nav-link">
                                <span class="d-sm-none">Attribute Settings</span>
                                <span class="d-sm-block d-none">Attribute Settings</span>
                            </a>
                        </li>

                    </ul>


                    <div class="tab-content">

                        <div class="tab-pane fade active show" id="default-tab-1A">
                            <!-- pruduct save attribure  -->
                            <div class="row">
                                <?php
                                $dataAttr = DB::table('tbl_items_attributes_data')->where('item_id', $item->item_id)->get();
                                foreach ($dataAttr as $key => $rowData) {
                                ?>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">{{$rowData->item_attr_admin_label}}</label>

                                            <input class="form-control" type="text" id="item_category_desc" value="{{$rowData->item_attr_value}}" name="" placeholder="">

                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <button type="button" style="margin-top: 27px;" id="{{$rowData->id}}" onclick="deleteItemAttrOption(this.id)" class="btn btn-sm btn-danger m-r-5 remove_field_Attr"> DELETE</button>
                                        </div>
                                    </div>
                                <?php
                                }

                                ?>
                            </div>
                            <!-- pruduct save attribure  -->
                        </div>


                        <div class="tab-pane fade" id="default-tab-2A">
                            <!-- attr setting  -->
                            <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('saveChangesProductAttribue')}}" id="saveItemCategoryeditProduct" name="saveItemCategoryeditProduct">

                                <input type="hidden" name="txtItemID" value="{{$item->item_id}}">
                                @csrf

                                <!-- formData -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Category</label>
                                            <select class="form-control selectProductAttribute" id="selectProduct" name="selectProductCatID" placeholder="">
                                                <option value="">-SELECT-</option>
                                                <?php
                                                foreach ($dataObjArr as $key => $rowData) {

                                                ?>
                                                    <option value="{{$rowData->id}}" {{($item->cat_id == $rowData->id)? 'selected':''}}>{{$rowData->item_name}}</option>

                                                <?php
                                                }

                                                ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Attribute</label>
                                            <select class="form-control productAttribute" id="productAttribute" name="productAttributeID" placeholder="Please select attribute">
                                                <option value="">-SELECT-</option>
                                                <?php
                                                $catAttrChildArr = DB::table('tbl_attributes')->get();
                                                
                                                    foreach ($catAttrChildArr as $key => $rowData) {
                                                        
                                                        
                                                    ?>
                                                     <option value="{{@$rowData->id}}">{{@$rowData->admin_name_lable}}</option>
                                               
                                                <?php }?>
                                            </select>

                                        </div>
                                    </div>

                                </div>
                                <div class="appendDataHtml">

                                </div>

                                <!-- formData -->

                                <fieldset style="margin-top:35px;">
                                    <input type="submit" value="SAVE CHANGES" class="btn btn-sm btn-primary m-r-5 " />

                                </fieldset>
                            </form>

                            <!-- attr setting  -->
                        </div>

                    </div>

                    <!-- tab new  -->



                    <!-- Attribute  -->
                </div>


                <div class="tab-pane fade show" id="default-tab-3">
                    <!-- gallary  -->



                    {{-- gallary --}}

                    <div id="dropzone">
                        <form action="{{route('addGalleryImageA', $item->item_id)}}" class="dropzone needsclick" id="imajkumar">
                            @csrf
                            <div class="dz-message needsclick">
                                Drop files <b>here</b> or <b>click</b> to upload.<br />
                                <span class="dz-note needsclick">
                                    (This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)
                                </span>
                            </div>
                        </form>
                    </div>
                    &nbsp;
                    &nbsp;

                    <div id="options" class="m-b-10">
                                       
                        <span class="gallery-option-set" id="filter" data-option-key="filter">
                            
                                <a href="#gallery-group-1" class="btn btn-default btn-xs" data-option-value=".gallery-group-1">Show All</a>
                        </span>

                    </div>

                    <div id="gallery" class="gallery">
                        <!-- begin image -->

                        <?php
                        foreach($itemImages as $galleryImage){
                         //if(!empty($galleryImage->img_name) && file_exists(BASE_URL.ITEM_IMG_PATH.'/'.$galleryImage->img_name)){ 
                         if(!empty($galleryImage->img_name)){ 
                            
                            ?>
                        <div class="image gallery-group-1">
                            <div class="image-inner">
                                <a href="{{BASE_URL.ITEM_IMG_PATH.'/'.$galleryImage->img_name}}" data-lightbox="gallery-group-1">
                                    <div class="img" style="background-image: url({{BASE_URL.ITEM_IMG_PATH.'/'.$galleryImage->img_name}})"></div>
                                </a>
                                <p class="image-caption">
                                    {{$galleryImage->item_name}}
                                </p>
                            </div>
                            <div class="image-info">
                                <h5 class="title">{{$galleryImage->item_name}}</h5>

                                <a class="btn btn-danger deleteItemImgBtn" value="{{$item->item_id.'_'.$galleryImage->id}}" href="javascript:;">Delete</a>
                                <div class="pull-right">
                                    <input type="checkbox" {{($galleryImage->default == 1)? 'checked':''}} class="defaultImg" name="default" value="{{$item->item_id.'_'.$galleryImage->id}}" />
                                    <span class="">Primary</span>
                                </div>
                            </div>
                        </div>
                                                   <?php }
                                                }?>
                        <!-- end image -->

                        <!-- end image -->
                    </div>
                    <!-- end #gallery -->


                    {{-- gallary --}}

                    <!-- begin #gallery -->











                    <!-- gallary  -->
                </div>
                <div class="tab-pane fade" id="default-tab-4">


                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('saveChangesProductRelation')}}" id="saveChangesProductRelation" name="saveItemCategoryeditProduct">


                        <input type="hidden" name="txtItemID" value="{{$item->item_id}}">
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label >Product Upsells</label>
                                    {{-- <input type="text" class="form-control" name="product_up_sale" value="{{optional($item)->product_up_sale}}"> --}}
                                    <select class="form-control" name="product_up_sale">
                                        <option value="">Select Item For Upsells</option>
                                        <?php
                                        $itemLists = get_items();
                                        ?>
                                        @foreach($itemLists as $itemList)

                                        <option value="{{$itemList->item_id}}" {{($item->product_up_sale == $itemList->item_id)? 'selected':''}}>{{$itemList->product_name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label >Product Cross sells</label>
                                    {{-- <input type="text" class="form-control" name="product_cross_sale" value="{{optional($item)->product_cross_sale}}"> --}}
                                    <select class="form-control" name="product_cross_sale">
                                        <option value="">Select Item For Cross Sells</option>
                                        <?php
                                        $itemLists = get_items();
                                        ?>
                                        @foreach($itemLists as $itemList)

                                        <option value="{{$itemList->item_id}}" {{($item->product_cross_sale == $itemList->item_id)? 'selected':''}}>{{$itemList->product_name}}</option>
                                        @endforeach

                                    </select>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label > Points Earned Per Unit sales </label>

                                    <input type="text" class="form-control" name="product_unit_sale" value="{{optional($item)->product_unit_sale}}">
                                </div>

                            </div>

                        </div>

                        <!-- produt relation  -->

                        <!-- produt relation  -->
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label >Product Stock status</label>
                                    <!-- <input type="text" class="form-control" name="product_status" value="{{optional($item)->product_status}}"> -->
                                    <select class="form-control" name="product_status">
                                        <option value="1" {{(optional($item)->product_status == 1) ? 'selected':''}}>In Stock</option>
                                        <option value="0" {{(optional($item)->product_status == 0) ? 'selected':''}}>Out of Stock</option>
                                        <option value="2" {{(optional($item)->product_status == 2) ? 'selected':''}}>As per Actual</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label >Allow for Backorder</label>
                                    <select class="form-control" id="is_allow_backover" name="is_allow_backover" data-parsley-required="true" placeholder="Brand">

                                        <option value="1">YES</option>
                                        <option value="2">NO</option>

                                    </select>

                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label > Product is visible</label>

                                    <select class="form-control" id="is_visible" name="is_visible" data-parsley-required="true" placeholder="Brand">

                                        <option value="1" {{(optional($item)->is_visible == 1) ? 'selected':''}}>YES</option>
                                        <option value="2" {{(optional($item)->is_visible == 2) ? 'selected':''}}>NO</option>

                                    </select>

                                </div>

                            </div>

                        </div>

                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="SAVE CHANGES" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>
                    </form>

                    </form>

                    <!-- produt relation  -->

                </div>
                <div class="tab-pane fade" id="default-tab-5">


                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('saveChangesProductTaxation')}}" id="saveChangesProductTaxation" name="saveChangesProductTaxation">


                        <input type="hidden" name="txtItemID" value="{{$item->item_id}}">
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >HSN</label>                                   
                                    <select class="form-control" name="hsn_code">
                                        <option value="">Select HSN</option>
                                        <?php 
                                            $hsnDatas = DB::table('tbl_hsn')->where('status', 1)->get();
                                            foreach($hsnDatas as  $hsnData){
                                        ?>
                                            <option value="{{$hsnData->id}}" {{($item->hsn_code == $hsnData->id) ? 'selected':''}}>{{$hsnData->hsn_name}}</option>                                      
                                        <?php }?>
                                    </select>
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label >IGST %</label>
                                    <input type="text" class="form-control" value="{{optional($item)->igst}}" name="igst" >
                                   
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label > CGST % </label>

                                    <input type="text" value="{{optional($item)->cgst}}"  class="form-control" name="cgst" >
                                </div>

                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label > SGST %</label>

                                    <input type="text" value="{{optional($item)->sgst}}" class="form-control" name="sgst">
                                </div>

                            </div>
                            

                        </div>

                        <!-- produt relation  -->

                        <!-- produt relation  -->
                      

                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="SAVE CHANGES" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>
                    </form>

                    </form>

                    <!-- produt relation  -->

                </div>





            </div>










        </div>




    </div>

</div>