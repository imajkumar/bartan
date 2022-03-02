<!-- begin #content -->

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Dashboar</a></li>
        {{-- <li class="breadcrumb-item"><a href="javascript:;">Settings</a></li> --}}
        <li class="breadcrumb-item active">Add category</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    
    <h1 class="page-header">CATEGORY <small>new</small></h1>

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">CATEGORY</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('addCategory')}}" id="addCategory" name="addCategory" class="form-layout" data-parsley-validate="true">
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="item_category_name">Item Category <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="item_category_name" name="item_category_name" placeholder="Please enter category name" data-parsley-required="true">
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="item_category_desc">Description </label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="textarea" id="item_category_desc" name="item_category_desc" placeholder="Please enter category description">
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="group">Group</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="group" name="group" placeholder="Please select group">
                                            <option value="">Please select group</option>
                                            {{-- <option value="1">General</option>
                                            <option value="2">Wholesale</option> --}}
                                        </select>
                                    </div>
                                </div>
                                
                                
                               
                            </div>
                            
                        </div>

                        <div id="categoryAttrWrapper">
                            <div class="row form-layout">
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="attribute">Attribute</label>
                                        <div class="">
                                            <select class="form-control" id="attribute" name="attribute[]" placeholder="Please select attribute">
                                                <option value="">Please select Attribute</option>
                                                <?php 
                                                    $attributes = get_attributes();
                                                    foreach($attributes as $attribute){
                                                ?>
                                                
                                                    <option value="{{$attribute['id']}}">{{$attribute['admin_name_lable']}}</option> 

                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="is_required">Is required</label>
                                        <div class="">
                                            <select class="form-control" id="is_required" name="is_required[]">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="is_unique">Is unique</label>
                                        <div class="">
                                            <select class="form-control" id="is_unique" name="is_unique[]">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="is_comparable">Attribute to comparable</label>
                                        <div class="">
                                            <select class="form-control" id="is_comparable" name="is_comparable[]">
                                                <option value="1">Yes</option>
                                                <option value="2">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="sku_count">SKU Count</label>
                                        <div class="">
                                            <input class="form-control" type="text" id="sku_count" name="sku_count[]" placeholder="Please enter sku count">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="m-b-3">
                                        <label class="" for="priority">Priority</label>
                                        <div class="">
                                            <input class="form-control" type="text" id="priority" name="priority[]" placeholder="Please enter priority">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" id="AddMoreAttrInCategory" class="btn btn-primary pull-right">
                                            Add More
                                        </button>
                        </div>

                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
                            <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                        </fieldset>
                    </form> 

                    
                    <!-- end #content -->
                {{-- </div> --}}
            {{-- </div> --}}
        </div>

    </div>

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
