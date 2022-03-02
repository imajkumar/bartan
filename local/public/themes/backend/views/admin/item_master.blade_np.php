<!-- begin #content -->

<div id="content" class="content">
  
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
                    <h4 class="panel-title">ITEM SETTING</h4>
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
                            
                            <li class="nav-item">
                                <a href="#addItem" data-toggle="tab" class="nav-link active">
                                    <span class="d-sm-none">Tab 2</span>
                                    <span class="d-sm-block d-none">ADD ITEM</span>
                                </a>
                            </li>
                            
                            
                        </ul>
                    </div>
                    <!-- end nav-tabs -->
                    <!-- begin tab-content -->
                    {{-- <div class="panel panel-inverse" data-sortable-id="form-stuff-12"> --}}
                    <div id="errorMsg" class="alert alert-block" style="display:none"></div>
                    <!-- begin panel-heading -->
                    {{-- <div class="panel-heading">
                            <h4 class="panel-title">Add item </h4>
                            <div class="panel-heading-btn">
                                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
        
                            </div>
                        </div> --}}
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        
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

                                    <form method="post" action="{{route('saveItem')}}" class="form-horizontal" id="saveItemMaster" data-parsley-validate="true" name="saveItemMaster">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-4 col-sm-8">

                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="name">Name <span class="required-star">* </span>:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="name" name="item_name" placeholder="Please enter item name" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                   
                                                   
                                                    
                                           

                                                </div>
                                                <div class="col-md-4 col-sm-8">

                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="name">SKU <span class="required-star">* </span>:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <input class="form-control" type="text" id="item_sku" name="item_sku" placeholder="Please enter item sku" data-parsley-required="true">
                                                        </div>
                                                    </div>
                                                   
                                                    
                                           

                                                </div>
                                                <div class="col-md-4 col-sm-8">

                                                    <div class="form-group row m-b-15">
                                                        <label class="col-md-12 col-sm-4 col-form-label" for="attribute_family_id">Attribute family <span class="required-star">* </span>:</label>
                                                        <div class="col-md-12 col-sm-8">
                                                            <select class="form-control" type="text" id="attribute_family_id" name="attribute_family_id" data-parsley-required="true">
                                                            <option value="">Select Attribute Family</option>
                                                            @foreach($attrFamilys as $attrFamily)
                                                            <option value="{{$attrFamily->id}}">{{$attrFamily->name}}</option>
                                                            @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                    
                                           

                                                </div>
                                                
                                                
                                                

                                                
                                            </div>
                                       
                            <!-- end row -->

                        </div>
                        <fieldset>
                            <input type="submit" id="submitItemBtn" value="SAVE" class="btn btn-sm btn-primary m-r-5 "/>
                            <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                        </fieldset>
                    </div>
                    <!-- end tab-pane -->

                    

                </div>
                <!-- end col-8 -->

                
            </div>
           
            </form>

        </div>
    </div>

</div>

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->