<!-- begin #content -->

<div id="content" class="content">
  

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ATTRIBUTE FAMILY EDIT</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                {{-- <div class="panel-body"> --}}
                    
                <form method="post" action="{{route('updateAttributeFamily')}}" id="updateAttributeFamily" name="updateAttributeFamily" data-parsley-validate="true">
                <input type="hidden" name="attribute_families_id" value="{{$attrFamily->id}}"/>
                    @csrf   
                    <div class="row">
                           
                            <div class="col-md-4 col-sm-8">
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="code">Code <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                    <input class="form-control" type="text" id="code" name="code" value="{{$attrFamily->code}}" placeholder="Please enter family code" data-parsley-required="true">
                                    </div>
                                </div>
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-form-label col-md-3">Atrributes</label>
                                    <div class="col-md-9">
                                        {{-- <select multiple class="form-control mb-3 primaryGroup" name="UnderGroupAttrSelected[]" id="UnderGroupAttrSelected"> --}}
                                    
                                        <?php 
                                        $i=0;
                                        
                                        foreach ($attributes as $rowData){
                                             $attrId[] = $rowData->id;
                                        }
                                        foreach ($attributes as $rowData){
                                             //pr($attrId);
                                           if(count($attrFamilyGroups)>0 && in_array(@$attrFamilyGroups[$i]['attribute_id'], $attrId)) {
                                            $checked = 'checked';
                                           }else{
                                            $checked ='';
                                           }
                                            
                                        ?>
                                        
                                        <label class="col-form-label" style="margin-top: 11px;
                                        margin-left: 122px;">{{$rowData->admin_name_lable}}</label>
                                        <input type="checkbox" class="form-check-input" name="attributes[]" value="{{$rowData->id}}"  {{$checked}} ><br>
                                        {{-- <option value="{{$rowData->id}}">{{$rowData->attr_name}}</option> --}}
                                        
                                        <?php 
                                        $i++;
                                        }
                                        ?>
        
                                        {{-- </select> --}}
                                    </div>
                                </div>
                                
                                
                                
                                
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                                
                                
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="name">Name <span class="required-star">*</span></label>
                                    <div class="col-md-12 col-sm-8">
                                        <input class="form-control" type="text" id="name" name="name" value="{{$attrFamily->name}}" placeholder="Please enter family name" data-parsley-required="true">
                                    </div>
                                </div>
                                
                               
                       

                            </div>
                            <div class="col-md-4 col-sm-8">
                               
                                    
                                
                                
                                <div class="form-group row m-b-15">
                                    <label class="col-md-12 col-sm-4 col-form-label" for="status">Status</label>
                                    <div class="col-md-12 col-sm-8">
                                        <select class="form-control" type="text" id="status" name="status">
                                            <option value="1" {{($attrFamily->status==1)?'selected':''}}>Active</option>
                                            <option value="0" {{($attrFamily->status==0)?'selected':''}}>Deactive</option>
                                        </select>
                                    </div>
                                </div>
                                
                                

                                
                                
                                
                       
                           
                        </div>
                            
                            
                       </div>
                        <fieldset>
                            <button type="submit" id="updateFamilyBtn" class="btn btn-sm btn-primary m-r-5">SAVE </button>
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
