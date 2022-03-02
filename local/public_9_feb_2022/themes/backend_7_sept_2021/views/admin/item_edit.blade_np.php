<!-- begin #content -->


<style>
    .select2-result-label .wrap:before{
position:absolute;
left:4px;
font-family:fontAwesome;
color:#0000;
content:"\f096";
width:25px;
height:25px;

}
.select2-result-label .wrap.checked:before{
content:"\f14a";
}
.select2-result-label .wrap{
margin-left:15px;
}

    </style>


<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li>
        <li class="breadcrumb-item active">Item Edit</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">ITEM <small>EDIT</small></h1>
    @if(Session::has('message-type'))
    
        <div class="alert alert-{{ Session::get('message-type') }}"> 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        {{ Session::get('message') }}
        </div>
    @endif
    <div id="errorModelMsg" class="alert alert-block" style="display:none"></div>
    <!-- end page-header -->

    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        {{-- <div class="col-xl-4">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">Group Tree</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    
                   
                </div>
            </div>
            <!-- end panel -->
        </div> --}}
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ITEM EDIT</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-xl-12" style="background-color: #e4e7e8;">
                        <!-- begin nav-tabs -->
                        <ul class="nav nav-tabs">
                            {{-- <li class="nav-item">
                                <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                                    <span class="d-sm-none">Tab 1</span>
                                    <span class="d-sm-block d-none">ITEM DETAIL</span>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a href="#addItem" data-toggle="tab" class="nav-link active">
                                    <span class="d-sm-none">Tab 2</span>
                                    <span class="d-sm-block d-none">EDIT ITEM</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#attribute" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 2</span>
                                    <span class="d-sm-block d-none">ATTRIBUTE</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#category" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 2</span>
                                    <span class="d-sm-block d-none">CATEGORY</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#purchasetab" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 3</span>
                                    <span class="d-sm-block d-none">PURCHASE</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#salestab" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 3</span>
                                    <span class="d-sm-block d-none">SALES</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#gallerytab" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 3</span>
                                    <span class="d-sm-block d-none">GALLERY</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#addimages" data-toggle="tab" class="nav-link">
                                    <span class="d-sm-none">Tab 3</span>
                                    <span class="d-sm-block d-none">ADD IMAGES</span>
                                </a>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- end nav-tabs -->
                    <!-- begin tab-content -->
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-12">
                       
                    
                    <!-- begin panel-heading -->
                    {{-- <div class="panel-heading">
                            <h4 class="panel-title">Add item </h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        
                            </div>
                        </div> --}}
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div class="tab-pane fade active show" id="default-tab-1">

                           
                            <table id="data-table-default_no" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>

                                        
                                        <th class="text-nowrap">Item name</th>
                                        <th class="text-nowrap">Group name</th>
                                        <th class="text-nowrap">Brand name</th>
                                        <th class="text-nowrap">Sale price</th>
                                        <th class="text-nowrap">Regular price</th>
                                        <th class="text-nowrap">Open quantity</th>
                                        <th class="text-nowrap">Min quantity</th>


                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="odd gradeX">
                                        <td width="1%" class="f-s-600 text-inverse">1</td>
                                        <td>{{$item->item_name}}</td>
                                        <td>{{$item->g_name}}</td>
                                        <td>{{$item->brandName}}</td>
                                        <td>{{$item->sale_price}}</td>
                                        <td>{{$item->regular_price}}</td>
                                        <td>{{$item->open_qty}}</td>
                                        <td>{{$item->min_qty}}</td>
                                        
                                    </tr> 

                                </tbody>
                            </table>


                        </div> --}}
                        <!-- end tab-pane -->
                        <!-- begin tab-pane -->
                        <div class="tab-pane fade active show" id="addItem">
                            <!-- begin row -->
                            <div class="row">
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel -->


                                    <!-- end panel-heading -->
                                    <!-- begin panel-body -->


                                    <div class="panel-body">
                                        <?php
                                        $dataObjArr = getUnderGroup();

                                        ?>

                                    <form class="form-horizontal" id="editItemMasterForm" action="{{route('updateItem', $item->item_id)}}" name="demo-form" data-parsley-validate="true">
                                            <input type="hidden" name="edit_item_id" id="edit_item_id" value="{{$item->item_id}}"/>
                                        @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-md-4 col-sm-8">

                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="name">Name <span class="required-star">* </span> :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="name" name="item_name" value="{{$item->item_name}}" placeholder="Required" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="salePrice">Sale price :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input type="text" class="form-control" value="{{$item->sale_price}}" id="salePrice" name="sale_price" placeholder="Sale price" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="regularPrice">Reguler price :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input type="text" class="form-control" id="regularPrice" name="regular_price" value="{{$item->regular_price}}" placeholder="Regular price" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="code">Code :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input type="text" class="form-control" value="" id="code" name="code" placeholder="code" />
                                                        </div>
                                                    </div>

                                                    {{-- <h2>Stock Details</h2> --}}
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="minimumqty">Minimum Qty:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="minimumqty" name="min_qty" value="{{$item->min_qty}}" placeholder="Minimum Qty">
        
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                   

                                                </div>
                                                <div class="col-md-4 col-sm-8">
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="item_sku">SKU <span class="required-star">* </span>:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="item_sku" value="{{$item->item_sku}}" name="item_sku" placeholder="SKU" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="description">Description <span class="required-star">* </span> :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="description" value="{{$item->description}}" name="description" placeholder="Description" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="message">HSN :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="hsn" name="hsn" placeholder="HSN">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="stockUnit">Stock Unit:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <select class="form-control" id="stockUnit" name="stock_unit">
                                                                <option value="">select</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    

                                                    

                                                </div>
                                                <div class="col-md-4 col-sm-8">
                                                    
                                                    {{-- <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="group">Group :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <select class="form-control" id="group" name="group_id" value="{{$item->g_name}}" data-parsley-required="true" placeholder="Group">
                                                                @foreach($dataObjArr as $groupData)
                                                                <option value="{{$groupData->g_id}}" {{($groupData->g_id==$item->g_id)? 'selected':''}}>{{$groupData->g_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div> --}}
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="brand">Brand :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <select class="form-control" id="brand" name="brand_id" data-parsley-required="true" placeholder="Brand">
                                                                @foreach($brands as $brand)
                                                                <option value="{{$brand->id}}" {{($brand->id==$item->brand_id)? 'selected':''}}>{{$brand->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="status">Status :</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <select class="form-control" id="status" name="status" placeholder="Status">
                                                                <option value="1" {{($item->status ==1)? 'selected':''}}>Active</option>
                                                                <option value="0" {{($item->status ==0)? 'selected':''}}>Deactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="openingvalue">Openinig value:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="openingvalue" name="openingvalue" placeholder="Opening value">
        
                                                        </div>
                                                    </div>
                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="openingqty">Openinig Qty:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="openingqty" name="open_qty" value="{{$item->open_qty}}" placeholder="Opening qty">
                                                        </div>
                                                    </div>
                                                    


                                                </div>
                                            </div>
                                       </div>
                                    <!-- end panel-body -->


                                    <!-- end panel -->
                                </div>
                                <!-- end col-6 -->
                            </div>
                            <!-- end row -->
                            <fieldset>
                                <button type="submit" id="updateItemBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                                <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                            </fieldset>

                        </div>
                    
                        <div class="tab-pane fade show" id="attribute">
                            {{-- add attrubue new  --}}
                        {{-- <div name="aj[]">
                            
                            <div class="row">
                                <div class="col-4">
                                    <select name="attr_color[]">
                                        <option value="color">Color</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="attrVal_color[]">
                                        <option value="red">Red</option>
                                    </select>
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <select name="attr_color[]">
                                        <option value="color">Color</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="attrVal_color[]">
                                        <option value="green">Green</option>
                                    </select>
                                    
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <select name="attr_size[]">
                                        <option value="L">L</option>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <select name="attrVal_size[]">
                                        <option value="M">M</option>
                                    </select>
                                    
                                </div>
                            </div>
                        </div> --}}


                        <div id="accordion" class="accordion">
                            <!-- begin card -->
                            <?php
                                $i=1;
                                $attributes = get_attributes();
                                foreach($attributes as $attribute){
                            ?>
                            <div class="card bg-dark1 text-white">
                                <div class="card-header bg-dark-darker pointer-cursor d-flex align-items-center collapsed" data-toggle="collapse" data-target="#collapse{{$i}}" aria-expanded="false">
                                    <i class="fa fa-circle fa-fw text-blue mr-2 f-s-8"></i> {{ucfirst($attribute['admin_name_lable'])}}
                                    {{-- <input type="hidden" name="attr_name[]" value="{{$attribute['attribute_code']}}"/> --}}
                                </div>
                                <div id="collapse{{$i}}" class="collapse" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <?php
                                            $options = get_attributes_option_by_attr_id($attribute['id']);
                                            foreach($options as $option){
                                                $checkBox = '';
                                                $itemAttrOption = get_itemAtributeOptions_by_option_id($option['id']);
                                                
                                                if(!empty($itemAttrOption)){
                                                    $checkBox = 'checked';
                                                }
                                        ?>
                                            <label class="" style="color: black;">{{$option['attribute_option_name']}}</label>&nbsp; 
                                            <input type="checkbox" {{$checkBox}} name="option[{{$attribute['attribute_code']}}][]" id="" value="{{$option['id']}}" class="select2-original1" multiple /> 
                                            &nbsp;&nbsp;
                                            <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php $i++;}?>
                           
                            <!-- end card -->
                        </div>
                            {{-- add attrubue new  --}}
                            <div class="row">
                                <div class="col-12">
                                    <div class="panel-body">
                                        {{-- <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label">Attributes :</label>    
                                                    <select class="form-control attributeList" id="attr_1" name="attribute">
                                                        <option value="" selected>Choose attribute</option>
                                                        <?php
                                                        $attributes = get_attributes();
                                                        foreach($attributes as $attribute){
                                                        ?>
                                                        <option value="{{$attribute['id']}}">{{ucfirst($attribute['admin_name_lable'])}}</option>
                                                            
                                                        <?php }?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group" id="aqttrOptions_attr_1oo">
                                           
                                                    <label class="col-form-label">Options :</label> 
                                                    <select name="option[]" id="attrOptions_attr_1" class="select2-original attrOption" multiple> 
                                                        
                                                        
                                                    </select>
                                                    {{-- <label class="">ddff</label>
                                                    <input type="checkbox" name="option[]" id="attrOptions_attr_1" class="select2-original1" multiple /> --}}
                                                {{-- </div>
                                            </div>
                                            
                                        </div> --}}
                                        {{-- <button type="button" id="AddMoreFileBoxAttr" class="btn btn-primary">
                                            Add More
                                        </button> --}}
                                        {{-- <div id="InputsWrapperAttr"> </div> --}} 
                                        
                                            

                                    

{{-- <?php
foreach($attrFamilyGroups as $attrFamilyGroup){
   
    $attributes = get_attribute_by_id($attrFamilyGroup['attribute_id']);
    
    $attrOptions = get_attribute_options_by_attribute_id($attributes['id']);
    

?>
<div class="form-group row m-b-15">
    <label class="col-md-12 col-sm-4 col-form-label">{{$attributes['admin_name_lable']}} :</label>
    <div class="col-md-12 col-sm-8">
        <?php
        if($attributes['type'] == 'select'){
        ?>
        <select class="form-control" name="attributes" data-parsley-required="{{($attributes['is_required'] == 1)? 'true':'false'}}">
            @foreach($attrOptions as $attrOption)
            <option value="{{$attrOption->id}}">{{$attrOption->attribute_option_name}}</option>
            @endforeach
        </select>
        <?php
        }else if($attributes['type'] == 'multiselect'){?>
        <select class="form-control" name="attributes[]" multiselect data-parsley-required="{{($attributes['is_required'] == 1)? 'true':'false'}}">
            @foreach($attrOptions as $attrOption)
            <option value="{{$attrOption->id}}" >{{$attrOption->attribute_option_name}}</option>
            @endforeach
        </select>
        <?php
        }
            else if($attributes['type'] == 'checkbox'){
                
        ?>
        @foreach($attrOptions as $attrOption)
            <label class="col-form-label" style="margin-top: 11px;
            margin-left: 122px;">{{$attrOption->attribute_option_name}}</label>
            <input class="form-control" type="{{$attributes['type']}}" name="attributes[]" value="{{$attrOption->id}}" data-parsley-required="{{($attributes['is_required'] == 1)? 'true':'false'}}">
        @endforeach

        <?php }else{?>
            <input class="form-control" type="{{$attributes['type']}}" name="attributes" data-parsley-required="{{($attributes['is_required'] == 1)? 'true':'false'}}">
        <?php }?>
    </div>
</div>
<?php }?> --}}
                                       
                                    </div>       
                                   
                                
                                </div>
                                <!-- end col-6 -->
                            </div>
                            <!-- end row -->
                            <fieldset>
                                <button type="submit" id="updateItemBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                                <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                            </fieldset>

                        </div>

                        <div class="tab-pane fade show" id="category">
                            <!-- begin row -->
                            <div class="row">
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel -->


                                    <!-- end panel-heading -->
                                    <!-- begin panel-body -->


                                    <div class="panel-body">
                                    

                                        <div id="jstree-checkable-group"></div>
                                    </div>       
                                   
                                
                                </div>
                                <!-- end col-6 -->
                            </div>
                            <!-- end row -->
                            <fieldset>
                                <button type="submit" id="updateItemBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                                <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                            </fieldset>

                        </div>
                        <!-- end tab-pane -->
                        <!-- begin tab-pane -->
                        <div class="tab-pane fade  show" id="purchasetab">
                            {{-- <div class="row"> --}}
                                
                                   
                                {{-- </div> --}}
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel-body -->
                                    <div class="panel-body">
                                        <div class="row">
                                        <div class="col-md-4 col-sm-8">
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="rate">Rate <span class="required-star">* </span> :</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input class="form-control" type="text" id="rate" name="rate" placeholder="Rate" data-parsley-required="true">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="taxregister">Column In Tax Register :</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control" id="taxregister" name="taxregister">
                                                        <option></option>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-4 col-sm-8">
                                            
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="unit">Unit <span class="required-star">* </span> :</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input class="form-control" type="text" id="unit" name="unit" placeholder="Unit" data-parsley-required="true">
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="punit_sunit">Purchase unit - Sale unit :</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input class="form-control" type="text" id="punit_sunit" name="punit_sunit" placeholder="1.00">
                                                </div>
                                            </div>
    
                                        </div>
                                        <div class="col-md-4 col-sm-8">
                                            
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label" for="account">Account :</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input class="form-control" type="text" id="account" name="account" placeholder="Account">
                                                </div>
                                            </div>
                                            
    
    
                                        </div>
                                    </div>


                                </div>
                                    <!-- end panel-body -->
                            </div>
                                <!-- end col-12 -->
                                <fieldset>
                                    <button type="submit" id="updateItemBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                                    <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                                </fieldset>
                        </div>
                        
                        <!-- begin tab-pane -->
                        <div class="tab-pane fade  show" id="salestab">
                            <div class="row">
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel-body -->
                                    <div class="panel-body">

                                        <div class="row">
                                            <div class="col-md-4 col-sm-8">
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-12 col-sm-4 col-form-label" for="rate">Rate <span class="required-star">* </span> :</label>
                                                    <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="rate" name="rate" placeholder="Rate" data-parsley-required="true">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-12 col-sm-4 col-form-label" for="taxregister">Column In Tax Register :</label>
                                                    <div class="col-md-12 col-sm-8">
                                                        <select class="form-control" id="taxregister" name="taxregister">
                                                            <option></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-4 col-sm-8">
                                                
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-12 col-sm-4 col-form-label" for="unit">Unit <span class="required-star">* </span> :</label>
                                                    <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="unit" name="unit" placeholder="Unit" data-parsley-required="true">
                                                    </div>
                                                </div>
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-12 col-sm-4 col-form-label" for="punit_sunit">Purchase unit - Sale unit :</label>
                                                    <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="punit_sunit" name="punit_sunit" placeholder="1.00">
                                                    </div>
                                                </div>
        
                                            </div>
                                            <div class="col-md-4 col-sm-8">
                                                
                                                <div class="form-group row m-b-15">
                                                    <label class="col-md-12 col-sm-4 col-form-label" for="account">Account :</label>
                                                    <div class="col-md-12 col-sm-8">
                                                        <input class="form-control" type="text" id="account" name="account" placeholder="Account">
                                                    </div>
                                                </div>
                                                
        
        
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end panel-body -->
                                </div>
                            </div>
                            
                            <!-- end col-12 -->
                            <fieldset>
                                <button type="submit" id="updateItemBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                                <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                            </fieldset>
                            </form>
                        </div>
                        
                            
                           
                       

                        <!-- end tab-pane -->
                        <!-- begin tab-pane -->
                        <div class="tab-pane fade  show" id="gallerytab">
                            <div class="row">
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel-body -->
                                    <div class="panel-body">

                                        <!-- begin page-header -->
                                        <h1 class="page-header">IMAGES <small></small></h1>

                                        <!-- end page-header -->
                                        <!-- begin #options -->
                                        <div id="options" class="m-b-10">
                                        {{-- <a class="btn btn-primary pull-right" href="{{route('addGalleryImage', $item->item_id)}}">Add image</a></td> --}}

                                            <span class="gallery-option-set" id="filter" data-option-key="filter">
                                                {{-- <a href="#show-all" class="btn btn-default btn-xs active" data-option-value="<span class="required-star">* </span>">Show All</a> --}}
                                                 <a href="#gallery-group-1" class="btn btn-default btn-xs" data-option-value=".gallery-group-1">Show All</a>
                                                {{-- <a href="#gallery-group-2" class="btn btn-default btn-xs" data-option-value=".gallery-group-2">Gallery Group 2</a>
                                                <a href="#gallery-group-3" class="btn btn-default btn-xs" data-option-value=".gallery-group-3">Gallery Group 3</a>
                                                <a href="#gallery-group-4" class="btn btn-default btn-xs" data-option-value=".gallery-group-4">Gallery Group 4</a> --}} 
                                            </span>

                                        </div>
                                        
                                        <!-- end #options -->
                                        <!-- begin #gallery -->
                                        <div id="gallery" class="gallery">
                                            <!-- begin image -->
                                            @foreach($itemImages as $galleryImage)
                                            <div class="image gallery-group-1">
                                                <div class="image-inner">
                                                    <a href="{{BASE_URL.ITEM_IMG_PATH.'/'.$galleryImage->img_name}}" data-lightbox="gallery-group-1">
                                                        <div class="img" style="background-image: url({{BASE_URL.ITEM_IMG_PATH.'/'.$galleryImage->img_name}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #1382 - 3D Arch
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                <h5 class="title">{{$galleryImage->item_name}}</h5>
                                                    {{-- <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Sean Ngu</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div> 
                                                    <div class="desc">
                                                        Nunc velit urna, aliquam at interdum sit amet, lacinia sit amet ligula. Quisque et erat eros. Aenean auctor metus in tortor placerat, non luctus justo blandit.
                                                    </div> --}}
                                                <a class="btn btn-danger deleteItemImgBtn" value="{{$item->item_id.'_'.$galleryImage->id}}" href="javascript:;">Delete</a>
                                                    <div class="pull-right">
                                                    <input type="checkbox" {{($galleryImage->default == 1)? 'checked':''}} class="defaultImg" name="default" value="{{$item->item_id.'_'.$galleryImage->id}}"/>
                                                        <span class="">Primary</span>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                            <!-- end image -->
                                            <!-- begin image -->
                                            {{-- <div class="image gallery-group-1">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-2.jpg')}}" data-lightbox="gallery-group-1">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-2.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #2343 - Madness Arch
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Fusce aliquet ac quam at tincidunt</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Camryn Wong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Fusce eu rutrum nisi, ut pretium mi. Sed mollis nisi sed auctor molestie. Vestibulum dictum pharetra leo sed euismod.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-1">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-3.jpg')}}" data-lightbox="gallery-group-1">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-3.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #3452 - Scottwills Arch
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Etiam lobortis egestas nisl</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Lelouch Wong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Vivamus eget ultricies arcu.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-2">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-4.jpg')}}" data-lightbox="gallery-group-2">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-4.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #4123 - Scottwills Pinecone
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Donec mi quis volutpat ornare</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Richard Leong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut et augue luctus libero dignissim sodales, sapien consequat lacinia fringilla.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-2">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-5.jpg')}}" data-lightbox="gallery-group-2">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-5.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #9200 Kariminal Rider
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Donec pretium volutpat ornare</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Derrick Wong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut et augue luctus libero, feugiat sapien consequat lacinia fringilla.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-3">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-6.jpg')}}" data-lightbox="gallery-group-3">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-6.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #1832 Scottwills Autumn
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Mi quis volutpat ornare sodales</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Apple Tong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Ut et augue luctus libero dignissim sodales. Fusce feugiat sapien consequat lacinia fringilla. Vivamus eget ultricies arcu.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-3">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-7.jpg')}}" data-lightbox="gallery-group-3">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-7.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #0229 Scottwills Autumn 2
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Vestibulum ante ipsum primis</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Thomas Wong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Interdum et malesuada fames ac ante ipsum primis in faucibus. Ut et augue luctus libero dignissim sodales, sapien consequat lacinia fringilla.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-4">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-8.jpg')}}" data-lightbox="gallery-group-4">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-8.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #5721 Scottwills Snow
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Nunc eget hendrerit nisi sodales</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">Andy Wong</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Ut et augue nisi sodales luctus libero dignissim sodales. Fusce feugiat nisi sodales sapien consequat lacinia fringilla.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-4">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-9.jpg')}}" data-lightbox="gallery-group-4">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-9.jpg')}})"></div>
                                                    </a>
                                                    <p class="image-caption">
                                                        #9921 Scottwills Riverbank
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Nunc eget hendrerit nisi dignissim</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">William Tan</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Ut et augue luctus libero dignissim sodales. Fusce feugiat sapien consequat libero dignissim lacinia fringilla.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end image -->
                                            <!-- begin image -->
                                            <div class="image gallery-group-4">
                                                <div class="image-inner">
                                                    <a href="{{asset('assets/img/gallery/gallery-10.jpg')}}" data-lightbox="gallery-group-4">
                                                        <div class="img" style="background-image: url({{asset('assets/img/gallery/gallery-10.jpg')}}" alt="" />
                                                    </a>
                                                    <p class="image-caption">
                                                        #6436 Scottwills Buss
                                                    </p>
                                                </div>
                                                <div class="image-info">
                                                    <h5 class="title">Sed mollis nisi sed auctor</h5>
                                                    <div class="pull-right">
                                                        <small>by</small> <a href="javascript:;">David King</a>
                                                    </div>
                                                    <div class="rating">
                                                        <span class="star active"></span>
                                                        <span class="star active"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                        <span class="star"></span>
                                                    </div>
                                                    <div class="desc">
                                                        Vestibulum dictum pharetra leo sed euismod. Lorem ipsum dolor sit amet, consectetur adipiscing feugiat sapien elit.
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <!-- end image -->
                                        </div>
                                        <!-- end #gallery -->
                                       
                                    </div>
                                    
                                    
                                    <!-- end panel-body -->
                                </div>
                                
                            </div>

                            <!-- end col-12 -->
                            
                        </div>
                        

                        <div class="tab-pane fade  show" id="addimages">
                            <div class="row">
                                <!-- begin col-12 -->
                                <div class="col-12">
                                    <!-- begin panel-body -->
                                    <div class="panel-body">
                                        
                                            
                                            <h1 class="page-header">Gallery <small>images</small></h1>
                                            <!-- end page-header -->
                                            
                                            <!-- begin form-file-upload -->
                                        <form id="fileupload" action="{{route('uploadGalleryImage')}}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" id="item_id" name="item_id" value="{{$item->item_id}}"/>
                                                <!-- begin panel -->
                                                <div class="panel panel-inverse">
                                                    <!-- begin panel-heading -->
                                                    {{-- <div class="panel-heading">
                                                        <h4 class="panel-title">Image Upload</h4>
                                                        <div class="panel-heading-btn">
                                                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                                                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                                                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                                                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                                                        </div>
                                                    </div> --}}
                                                    <!-- end panel-heading -->
                                                    <!-- begin panel-body -->
                                                    <div class="panel-body">			
                                                        {{-- <div class="note note-yellow m-b-15">
                                                            <div class="note-icon f-s-20">
                                                                <i class="fa fa-lightbulb fa-2x"></i>
                                                            </div>
                                                            <div class="note-content">
                                                                <h4 class="m-t-5 m-b-5 p-b-2">Demo Notes</h4>
                                                                <ul class="m-b-5 p-l-25">
                                                                    <li>The maximum file size for uploads in this demo is <strong>5 MB</strong> (default file size is unlimited).</li>
                                                                    <li>Only image files (<strong>JPG, GIF, PNG</strong>) are allowed in this demo (by default there is no file type restriction).</li>
                                                                    <li>Uploaded files will be deleted automatically after <strong>5 minutes</strong> (demo setting).</li>
                                                                </ul>
                                                            </div>
                                                        </div> --}}
                                                        <div class="row fileupload-buttonbar">
                                                            <div class="col-xl-7">
                                                                <span class="btn btn-primary fileinput-button m-r-3">
                                                                    <i class="fa fa-fw fa-plus"></i>
                                                                    <span>Add files...</span>
                                                                    <input type="file" name="files[]" multiple>
                                                                </span>
                                                                <button type="submit" class="btn btn-primary start m-r-3">
                                                                    <i class="fa fa-fw fa-upload"></i>
                                                                    <span>Start upload</span>
                                                                </button>
                                                                <button type="reset" class="btn btn-default cancel m-r-3">
                                                                    <i class="fa fa-fw fa-ban"></i>
                                                                    <span>Cancel upload</span>
                                                                </button>
                                                                <button type="button" class="btn btn-default delete m-r-3">
                                                                    <i class="fa fa-fw fa-trash"></i>
                                                                    <span>Delete</span>
                                                                </button>
                                                                <!-- The global file processing state -->
                                                                <span class="fileupload-process"></span>
                                                            </div>
                                                            <!-- The global progress state -->
                                                            <div class="col-xl-5 fileupload-progress fade d-none d-xl-block">
                                                                <!-- The global progress bar -->
                                                                <div class="progress progress-striped active m-b-0">
                                                                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                                                </div>
                                                                <!-- The extended global progress state -->
                                                                <div class="progress-extended">&nbsp;</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- end panel-body -->
                                                    <!-- begin table -->
                                                    <div class="table-responsive">
                                                        <table class="table table-striped table-condensed text-nowrap mb-0">
                                                            <thead>
                                                                <tr>
                                                                    <th width="10%">PREVIEW</th>
                                                                    <th>FILE INFO</th>
                                                                    <th>UPLOAD PROGRESS</th>
                                                                    <th width="1%"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="files">
                                                                <tr data-id="empty">
                                                                    <td colspan="4" class="text-center text-muted p-t-30 p-b-30">
                                                                        <div class="m-b-10"><i class="fa fa-file fa-3x"></i></div>
                                                                        <div>No file selected</div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table -->
                                                </div>
                                                <!-- end panel -->
                                            </form>
                                            <!-- end form-file-upload -->
                                        </div>
                                        <!-- end #content -->
                                        
                                        
                                        
                                       
                                        
                                            
                                        
                                       
                                            
                                    </div>
                                </div>
                                <!-- end panel-body -->
                                
                            </div>
                        </div>
                        
                    </div>
                    <!-- end tab-pane -->

                    

                </div>
                <!-- end col-8 -->
               
                
            </div>
           
        <a href="{{ URL::previous() }}" class="btn btn-sm btn-primary">BACK</a>
        </div>
        
    </div>

</div>

<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade show">
        <td>
            <span class="preview"></span>
        </td>
        <td>
            <div class="bg-light rounded p-10 mb-2">
                <dl class="m-b-0">
                    <dt class="text-inverse">File Name:</dt>
                    <dd class="name">{%=file.name%}</dd>
                    <dt class="text-inverse m-t-10">File Size:</dt>
                    <dd class="size">Processing...</dd>
                </dl>
            </div>
            <strong class="error text-danger h-auto d-block text-left"></strong>
        </td>
        <td>
            <dl>
                <dt class="text-inverse m-t-3">Progress:</dt>
                <dd class="m-t-5">
                    <div class="progress progress-sm progress-striped active rounded-corner"><div class="progress-bar progress-bar-primary" style="width:0%; min-width: 40px;">0%</div></div>
                </dd>
            </dl>
        </td>
        <td nowrap>
            {% if (!i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start width-100 p-r-20 m-r-3" disabled>
                    <i class="fa fa-upload fa-fw text-inverse"></i>
                    <span>Start</span>
                </button>
            {% } %}
            {% if (!i) { %}
                <button class="btn btn-default cancel width-100 p-r-20">
                    <i class="fa fa-trash fa-fw text-muted"></i>
                    <span>Cancel</span>
                </button>
            {% } %}
        </td>
    </tr>
    {% } %}
</script>

<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
        <tr class="template-download fade show">
            <td width="1%">
                <span class="preview">
                    {% if (file.thumbnailUrl) { %}
                        <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}" class="rounded"></a>
                    {% } else { %}
                        <div class="bg-light text-center f-s-20" style="width: 80px; height: 80px; line-height: 80px; border-radius: 6px;">
                            <i class="fa fa-file-image fa-lg text-muted"></i>
                        </div>
                    {% } %}
                </span>
            </td>
            <td>
                <div class="bg-light p-10 mb-2">
                    <dl class="m-b-0">
                        <dt class="text-inverse">File Name:</dt>
                        <dd class="name">
                            {% if (file.url) { %}
                                <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
                            {% } else { %}
                                <span>{%=file.name%}</span>
                            {% } %}
                        </dd>
                        <dt class="text-inverse m-t-10">File Size:</dt>
                        <dd class="size">{%=o.formatFileSize(file.size)%}</dd>
                    </dl>
                    {% if (file.error) { %}
                        <div><span class="label label-danger">ERROR</span> {%=file.error%}</div>
                    {% } %}
                </div>
            </td>
            <td></td>
            <td>
                {% if (file.deleteUrl) { %}
                    <button class="btn btn-danger delete width-100 m-r-3 p-r-20" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                        <i class="fa fa-trash pull-left fa-fw text-inverse m-t-2"></i>
                        <span>Delete</span>
                    </button>
                    <input type="checkbox" name="delete" value="1" class="toggle">
                {% } else { %}
                    <button class="btn btn-default cancel width-100 m-r-3 p-r-20">
                        <i class="fa fa-trash pull-left fa-fw text-muted m-t-2"></i>
                        <span>Cancel</span>
                    </button>
                {% } %}
            </td>
        </tr>
    {% } %}
</script>
<!-- end row -->
{{-- </div> --}}
<!-- end #content -->