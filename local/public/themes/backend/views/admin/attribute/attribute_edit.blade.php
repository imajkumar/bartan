<!-- begin #content -->

<div id="content" class="content">
   
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">EDIT ATTRIBUTES</h4>
                    <div class="panel-heading-btn">
                       

                    </div>
                </div>
               <div class="panel-body">
                    
                <form class="form-layout" method="post" action="{{route('updateAttribute')}}" id="updateAttribute" name="updateAttribute" data-parsley-validate="true">
                <input type="hidden" name="attribute_id" value="{{$attribute->id}}"/>
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="attribute_code">Attribute Code <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                    <input class="form-control" type="text" id="attribute_code" name="attribute_code" value="{{$attribute->attribute_code}}" placeholder="Please enter attribute code" data-parsley-required="true">
                                    </div>
                                </div>
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_required">Is Required</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_required" name="is_required">
                                            <option value="0" {{($attribute->is_required==0)? 'selected':''}}>No</option> 
                                            <option value="1" {{($attribute->is_required==1)? 'selected':''}}>Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_comparable">Attribute is comparable</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_comparable" name="is_comparable">
                                            <option value="0" {{($attribute->is_comparable==0)? 'selected':''}}>No</option> 
                                            <option value="1" {{($attribute->is_comparable==0)? 'selected':''}}>Yes</option>
                                        </select>
                                    </div>
                                </div>
                                 -->
                                
                                
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="type">Attribute Type{{$attribute->type}} <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="type" name="type" placeholder="Please select attribute type" data-parsley-required="true">
                                            <option value="text" {{($attribute->type=='text')? 'selected':''}}>Text</option> 
                                            <!-- <option value="textarea" {{($attribute->type=='textarea')? 'selected':''}}>Textarea</option>  -->
                                            {{-- <option value="price" {{($attribute->type=='price')? 'selected':''}}>Price</option>  --}}
                                            {{-- <option value="boolean" {{($attribute->type=='boolean')? 'selected':''}}>Boolean</option>  --}}
                                            <option value="select" {{(strtolower($attribute->type)=='select')? 'selected':''}}>Select</option> 
                                            <!-- <option value="multiselect" {{($attribute->type=='multiselect')? 'selected':''}}>Multiselect</option>  -->
                                            {{-- <option value="datetime" {{($attribute->type=='datetime')? 'selected':''}}>Datetime</option>  --}}
                                            {{-- <option value="date" {{($attribute->type=='date')? 'selected':''}}>Date</option>  --}}
                                            {{-- <option value="image" {{($attribute->type=='image')? 'selected':''}}>Image</option>  --}}
                                            <!-- <option value="file" {{($attribute->type=='file')? 'selected':''}}>File</option>  -->
                                            <!-- <option value="checkbox" {{($attribute->type=='checkbox')? 'selected':''}}>Checkbox</option> -->
                                        </select>

                                    </div>
                                </div>
                                
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_unique">Is Unique</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_unique" name="is_unique">
                                            <option value="0" {{($attribute->is_unique=='0')? 'selected':''}}>No</option> 
                                            <option value="1" {{($attribute->is_unique=='1')? 'selected':''}}>Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="is_visible_on_front">Visible on Product View Page on Front-end</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="is_visible_on_front" name="is_visible_on_front">
                                            <option value="0" {{($attribute->is_visible_on_front=='0')? 'selected':''}}>No</option> 
                                            <option value="1" {{($attribute->is_visible_on_front=='1')? 'selected':''}}>Yes</option>
                                        </select>
                                    </div>
                                </div> -->
                       

                            </div>
                            <div class="col-md-4 col-sm-8">

                                <div class="form-group row m-b-15" Id="attrOption" style="display:{{(count($attributeOptions)>0 && ((strtolower($attribute->type)=='select') || ($attribute->type=='multiselect') || ($attribute->type=='checkbox')))? 'block':'none'}}">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="option">Options <span class="required-star">* </span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <div id="InputsWrapper">
                                            @foreach($attributeOptions as $attributeOption)
                                        <input type="text" name="options[]"  id="option" value="{{$attributeOption->attribute_option_name}}" class="form-control" placeholder="Please enter option" data-parsley-required="true"> 
                                            @endforeach
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
                                    <input class="form-control" type="text" id="admin_name_lable" name="admin_name_lable" value="{{$attribute->admin_name_lable}}" placeholder="Please enter lable" data-parsley-required="true">
                                    </div>
                                </div>
                                
                                <!-- <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="input_validation">Input Validation</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" id="input_validation" name="input_validation">
                                            <option value=""></option> 
                                            <option value="numeric" {{($attribute->input_validation=='numeric')? 'selected':''}}>Number</option> 
                                            <option value="email" {{($attribute->input_validation=='email')? 'selected':''}}>Email</option> 
                                            <option value="decimal" {{($attribute->input_validation=='decimal')? 'selected':''}}>Decimal</option> 
                                            <option value="url" {{($attribute->input_validation=='url')? 'selected':''}}>URL</option>
                                        </select>
                                    </div>
                                </div> -->

                                
                               
                                
                       

                            </div>
                            
                            
                         

                            
                        </div>
                        <fieldset>
                            <button type="submit" id="addCustomerBtn" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save </button>
                            <button type="reset" class="btn btn-secondary"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
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
