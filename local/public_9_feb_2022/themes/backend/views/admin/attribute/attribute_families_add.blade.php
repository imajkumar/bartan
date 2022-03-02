<!-- begin #content -->

<div id="content" class="content">
   

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ATTRIBUTE FAMILY</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('addAttributeFamily')}}" id="addAttributeFamily" name="addAttributeFamily" data-parsley-validate="true">
                
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="code">Code <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="code" name="code" placeholder="Please enter family code" data-parsley-required="true">
                                    </div>
                                </div>
                                
                                
                                
                                
                                
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                                
                                
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="name">Name <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Please enter family name" data-parsley-required="true">
                                    </div>
                                </div>
                                
                               
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                               
                                    
                                
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="status">Status</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" type="text" id="status" name="status">
                                            <option value="1">Active</option>
                                            <option value="0">Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                
                                

                                
                                
                                
                       
                           
                        </div>
                            
                            
                         
                        <div class="form-group row m-b-15">
                            <label class="col-form-label col-md-3">Atrributes</label>
                            <div class="col-md-9">
                                {{-- <select multiple class="form-control mb-3 primaryGroup" name="UnderGroupAttrSelected[]" id="UnderGroupAttrSelected"> --}}
                                @foreach ($attributes as $rowData)
                                
                                <label class="col-form-label" style="margin-top: 11px;
                                margin-left: 122px;">{{$rowData->admin_name_lable}}</label>
                                <input type="checkbox" class="form-check-input" name="attributes[]" value="{{$rowData->id}}" id="attributes" style="margin-top: 11px;
                                margin-left: 122px;"><br>
                                {{-- <option value="{{$rowData->id}}">{{$rowData->attr_name}}</option> --}}
                                @endforeach

                                {{-- </select> --}}
                            </div>
                        </div>
                            
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
