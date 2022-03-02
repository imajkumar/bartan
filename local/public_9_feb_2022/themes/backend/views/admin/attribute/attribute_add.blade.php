<!-- begin #content -->

<div id="content" class="content">
    
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ATTRIBUTES</h4>
                    <!-- <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div> -->
                </div>
               <div class="panel-body"> 
                    
                <form class="form-layout" method="post" action="{{route('addAttribute')}}" id="addAttribute" name="addAttribute" data-parsley-validate="true">
                
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="attribute_code">Attribute Code <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="attribute_code" name="attribute_code" placeholder="Please enter attribute code" data-parsley-required="true">
                                    </div>
                                </div>
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_required">Is Required</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_required" name="is_required">
                                            <option value="0">No</option> 
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_comparable">Attribute is comparable</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_comparable" name="is_comparable">
                                            <option value="0">No</option> 
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                                
                                
                                
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="type">Attribute Type <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="type" name="type" placeholder="Please select attribute type" data-parsley-required="true">
                                            <option value="text">Text</option> 
                                            <!-- <option value="textarea">Textarea</option>  -->
                                            {{-- <option value="price">Price</option>  --}}
                                            {{-- <option value="boolean">Boolean</option>  --}}
                                            <option value="select">Select</option> 
                                            <!-- <option value="multiselect">Multiselect</option>  -->
                                            {{-- <option value="datetime">Datetime</option>  --}}
                                            {{-- <option value="date">Date</option>  --}}
                                            {{-- <option value="image">Image</option>  --}}
                                            <!-- <option value="file">File</option> 
                                            <option value="checkbox">Checkbox</option> -->
                                        </select>

                                    </div>
                                </div>
                                
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_unique">Is Unique</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_unique" name="is_unique">
                                            <option value="0">No</option> 
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_visible_on_front">Visible on Product View Page on Front-end</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_visible_on_front" name="is_visible_on_front">
                                            <option value="0">No</option> 
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                               
                                    <div class="form-group row m-b-15" Id="attrOption" style="display:none">
                                        <label class="col-md-12 col-sm-4 col-form-label" for="option">Options <span class="required-star">* </span></label>
                                        <div class="col-md-12 col-sm-8">
                                            <div id="InputsWrapper">
                                                <input type="text" name="options[]"  id="option" class="form-control" placeholder="Please enter option"> 
                                            </div>  
                                            <div id="atributeOptionAppend"></div>
                                            <button type="button" id="AddMoreFileBox" class="btn btn-primary">
                                                Add Option
                                            </button>
                                            
                                        </div>
                                    </div>
                                
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="admin_name_lable">Label/Admin <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="admin_name_lable" name="admin_name_lable" placeholder="Please enter lable" data-parsley-required="true">
                                    </div>
                                </div>
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="input_validation">Input Validation</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="input_validation" name="input_validation">
                                            <option value=""></option> 
                                            <option value="numeric">Number</option> 
                                            <option value="email">Email</option> 
                                            <option value="decimal">Decimal</option> 
                                            <option value="url">URL</option>
                                        </select>
                                    </div>
                                </div> -->

                                
                                
                                
                       
                           
                        </div>
                            
                            
                         

                            
                        </div>
                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-success
                            ">Save </button>
                            <button type="reset" class="btn btn-default">Cancel</button>
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
