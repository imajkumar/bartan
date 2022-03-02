

<div id="content" class="content">

@if(Session::has('message-type'))
    
    <div class="alert alert-{{ Session::get('message-type') }}"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    {{ Session::get('message') }}
    </div>
@endif
    <div class="row">

        <div class="col-xl-12">

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Export</span>
                        <span class="d-sm-block d-none">Export</span>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Import</span>
                        <span class="d-sm-block d-none">Import</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#default-tab-4" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Import</span>
                        <span class="d-sm-block d-none">Import New Item</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-attr" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Attribute</span>
                        <span class="d-sm-block d-none">Import Attribute</span>
                    </a>
                </li>
                


            </ul>
            <div class="tab-content">

                <div class="tab-pane fade active show" id="default-tab-1">
                <a class="btn btn-success pull-right" href="{{route('exportItem')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export All</a>
                    <form action="{{route('exportItemBycolumn')}}" method="post" id="exportItemBycolumn">
                        
                        @csrf

                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Export Item fields for update</label>
                                    <select class="form-control select2" id="itemcolum" name="itemcolum[]" multiple required>
                                       <?php 
                                       $columns = array(
                                           //'item_id'=>'Id',
                                            'brand_id'=>"Brand",

                                            'cat_id'=>"Category",

                                            'item_name'=>"Item name",
                                            'item_sku'=>"Item sku",
                                            'description'=>"Description",
                                            // 'tag'=>"Product Tags",
                                            'regular_price'=>"Regular price",
                                            'invt_qty'=>"Quantity",
                                            'invt_saleunit'=>"Sale unit",
                                            'item_invt_min_order'=>"Item min order qty",
                                            'barcode'=>"Barcode",
                                            'product_up_sale'=>"product_up_sale",
                                            'product_cross_sale'=>"product_cross_sale",
                                            'product_status'=>"product_status",
                                            'is_visible'=>"is_visible",
                                            'hsn_code'=>"hsn_code",
                                            'igst'=>"igst",
                                            'cgst'=>"cgst",
                                            'sgst'=>"sgst",
                                            'item_mrp'=>"MRP",
                                            'invt_unit'=>"Inventry UNIT",
                                            'ori_country'=>"Country of origin",
                                            'item_invt_lengh'=>"Lengh",
                                            'item_invt_width'=>"Width",
                                            'item_invt_height'=>"Height",
                                            'item_invt_volume'=>"Volumetric",
                                            'item_invt_weight'=>"Weight",
                                            'item_cart_remarks'=>"Item cart remark",
                                            'is_tax_included'=>"Is tax Included",

                                            'item_tags'=>"Item tags",
                                            'price_per_kg'=>"Price per kg",
                                            'trending_item'=>"Trending Item Sequence No",
                                            'set_of'=>"Set of",
                                            'price_per_pcs'=>"Price per pcs",

                                            
                                            
                                           
                                        
                                        );
                                        foreach($columns as $columnKey => $columnVal){
                                       ?>
                                       <option value="{{$columnKey}}">{{$columnVal}}</option>
                                       <?php }?>
                                    </select>

                                </div>

                            </div>
                             
                        </div>


                        
                        
                        
                          
                        
                        <!-- Stock and Selling -->
                        <!-- volume settings  -->
                       
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Export" id="Export" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        <!-- volume settings  -->
                    </form>

                </div>
                

                

                <div class="tab-pane fade" id="default-tab-3">
               

                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('itemImportForUpdate')}}" id="itemImport" name="itemImport" enctype="multipart/form-data">


                       
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item Import For Update</label>
                                   
                                    <input type="file" class="form-control" name="m_csvfile"/>
                                   
                                </div>

                            </div>

                        </div>

                        <!-- produt relation  -->

                        
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Import" id="itemImportUpdateBtn" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        
                                            
                        
                    </form>

                   

                    <!-- produt relation  -->

                </div>
              
                <div class="tab-pane fade" id="default-tab-4">
                <a class="btn btn-success pull-right" href="{{asset('/gallery/ItemImportTemplate.csv')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export Sample For Import New Item</a>

                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('newItemImport')}}" id="newItemImport" name="newItemImport" enctype="multipart/form-data">


                       
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item Import</label>
                                   
                                    <input type="file" class="form-control" name="m_csvfile" id="m_csvfile"/>
                                    <!-- <input type="checkbox" class="form-control" name="importUpdate" id="importUpdate"/> -->
                                </div>

                            </div>

                            <!-- <div class="col-md-3">
                                <div class="form-group">
                                    <label >Update existing item</label>
                                   
                                   
                                    <input type="checkbox" class="form-control" name="importUpdate" value="1" id="importUpdate"/>
                                </div>

                            </div> -->

                            

                            
                             
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Category</label>
                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                       <?php 
                                       $dataObjArr = getAllItemCategory();
                                        ?>
                                       @foreach ($dataObjArr as $rowData)
                                       <option value="{{$rowData->id}}">{{$rowData->item_name}}</option>
                                       @endforeach
                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Brand</label>
                                    <select class="form-control" id="brand_id" name="brand_id" required>
                                       <?php 
                                       $brands = DB::table('tbl_brands')->get();
                                        
                                       ?>
                                       @foreach($brands as $brand)
                                        <option value="{{$brand->id}}" >{{ucwords($brand->name)}}</option>
                                        @endforeach
                                      
                                    </select>

                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Product is visible</label>
                                    <select class="form-control" id="is_visible" name="is_visible" data-parsley-required="true">

                                        <option value="1">YES</option>
                                        <option value="2">NO</option>

                                    </select>

                                </div>

                            </div>

                        </div> -->
                        <!-- produt relation  -->

                        
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Import" id="itemImportBtn" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        

                        
                    </form>

                   

                    <!-- produt relation  -->

                </div>



                <div class="tab-pane fade" id="default-tab-attr">
               
                <a class="btn btn-success pull-right" href="{{route('exportAttrForColumn')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export Attribute For update</a>

                    <form class="form-horizontal" data-parsley-validate="true" method="post" action="{{route('itemImportForUpdateAttr')}}" id="itemImport" name="itemImport" enctype="multipart/form-data">


                       
                        @csrf
                        <!-- produt relation  -->
                        <div class="row">
                            
                           
                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label >Item Attribute update by sku</label>
                                   
                                    <input type="file" class="form-control" name="m_csvfile" accept=".csv" require/>
                                   
                                </div>

                            </div>

                        </div>

                        <!-- produt relation  -->

                        
                        <fieldset style="margin-top:35px;">
                            <input type="submit" value="Import" id="itemImportUpdateBtn" class="btn btn-sm btn-primary m-r-5 " />

                        </fieldset>

                        

                        
                    </form>

                   

                    <!-- produt relation  -->

                </div>
                
               





            </div>










        </div>




    </div>

</div>