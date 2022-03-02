<!-- begin #content -->
<div id="content" class="content">
  
    <!-- begin row -->
    <div class="row">
        <!-- begin col-4 -->
        <div class="col-xl-4">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">GROUP TREE</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    <div id="jstree-checkable"></div>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-xl-8">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">GROUP MASTER</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body" style="background-color: #e4e7e8;">
                     <!-- begin nav-tabs -->
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Tab 1</span>
                        <span class="d-sm-block d-none">ITEM LIST</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Tab 2</span>
                        <span class="d-sm-block d-none">GROUP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#default-tab-3" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Tab 3</span>
                        <span class="d-sm-block d-none">ITEM GROUP</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#measurement" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Tab 3</span>
                        <span class="d-sm-block d-none">MEASUREMENT</span>
                    </a>
                </li>
            </ul>
            <!-- end nav-tabs -->
            <!-- begin tab-content -->
            <div class="tab-content">
                <!-- begin tab-pane -->
                <div class="tab-pane fade active show" id="default-tab-1">
                    {{-- <table id="grid1"></table> --}}


                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade  show" id="default-tab-2">
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-12 -->
                        <div class="col-12">
                            <!-- begin panel -->
                            <div class="panel panel-inverse" data-sortable-id="form-stuff-12">
                                <!-- begin panel-heading -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">ADD ITEM GROUP MASTER </h4>
                                    <div class="panel-heading-btn">
                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>

                                    </div>
                                </div>
                                <!-- end panel-heading -->
                                <!-- begin panel-body -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row m-b-15">
                                                <label class="col-form-label col-md-12 col-sm-4">Group</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input type="text" name="group_name" id="group_name" class="form-control m-b-5" placeholder="Enter group" />
        
                                                </div>
                                            </div>
                                            <?php
                                            $dataObjArr = getUnderGroup();
                                            ?>
                                            <div class="form-group row m-b-15">
                                                <label class="col-form-label col-md-12 col-sm-4">Under Group</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3" id="UnderGroup" disabled>
                                                        @foreach ($dataObjArr as $rowData)
                                                        <option value="{{$rowData->g_id}}">{{$rowData->g_name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            

                                            
                                        </div>

                                        <div class="col-md-4 col-sm-8">
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">Alias</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input type="text" name="alias_name" id="alias_name" class="form-control m-b-5" placeholder="Enter Alias" />
        
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">HSN</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input type="text" id="hsn" class="form-control m-b-5" placeholder="Enter HSN" />
        
                                                </div>
                                            </div>
                                            


                                        </div>

                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">Primay Group (Y/N)</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3 primaryGroup" id="primaryGroup">
                                                        <option selected="selected" value="0">NO</option>
                                                        <option value="1">YES</option>
        
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">TAX CATEGORY</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3" id="taxCategory">
                                                        <option selected="selected" value="">-NA-</option>
                                                        <option value="AF">GST 15%</option>
                                                        <option value="AL">CGST 10%</option>
        
                                                    </select>
                                                </div>
                                            </div>
                                            


                                        </div>

                                    </div>

                                    <fieldset>

                                        <button type="button" id="btnGroup" class="btn btn-sm btn-primary m-r-5 ">SAVE</button>
                                        <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                                    </fieldset>

                                </div>
                                <!-- end panel-body -->

                            </div>
                            <!-- end panel -->
                        </div>
                        <!-- end col-6 -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade  show" id="default-tab-3">
                    <div class="row">
                        <!-- begin col-12 -->
                        <div class="col-12">
                            <!-- begin panel-body -->
                            <div class="panel-body">


                            <form method="post" id="frmSaveGroupAttr" action="{{route('saveGroupAttribute')}}">
                                @csrf
                                <?php
                                $dataObjArr = getUnderGroup();
                                $dataItemAttrObjArr = getItemAttributes();
                                ?>
                                <div class="form-group row m-b-15">
                                    <label class="col-form-label col-md-3">Under Group</label>
                                    <div class="col-md-9">
                                        <select class="form-control mb-3" name="UnderGroupAttr" id="UnderGroupAttr" >
                                            @foreach ($dataObjArr as $rowData)
                                            <option value="{{$rowData->g_id}}">{{$rowData->g_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-3">Atrribute</label>
                                        <div class="col-md-9">
                                            {{-- <select multiple class="form-control mb-3 primaryGroup" name="UnderGroupAttrSelected[]" id="UnderGroupAttrSelected"> --}}
                                            @foreach ($dataItemAttrObjArr as $rowData)
                                            
                                            <label class="col-form-label">{{$rowData->attr_name}}</label>
                                            <input type="checkbox" class="form-check-input" name="UnderGroupAttrSelected[]" value="{{$rowData->id}}" id="UnderGroupAttrSelected" style="margin-top: 11px;
                                            margin-left: 122px;"><br>
                                            {{-- <option value="{{$rowData->id}}">{{$rowData->attr_name}}</option> --}}
                                            @endforeach

                                            {{-- </select> --}}
                                        </div>
                                    </div>

                              
                               
                                <fieldset>

                                    <button type="submit" id="btnGroupAttr" class="btn btn-sm btn-primary m-r-5 ">SAVE </button>
                                    <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                                </fieldset>
                            </form>
                        </div>
                    <!-- end panel-body -->
                    </div>
                        <!-- end col-12 -->
                </div>
            </div>
                <!-- begin tab-pane -->
                <div class="tab-pane fade  show" id="measurement">
                    <div class="row">
                        <!-- begin col-12 -->
                        <div class="col-12">
                            <!-- begin panel-body -->
                            <div class="panel-body">


                            <form method="post" id="frmSaveAttributeValue" action="{{route('saveAttributeValue')}}">
                                @csrf
                                <?php
                                $dataObjArr = getUnderGroup();
                                $dataItemAttrObjArr = getItemAttributes();
                                ?>
                                
                                <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-3">Atrribute</label>
                                        <div class="col-md-3">
                                            <select  class="form-control mb-3" name="attribute_id" id="attributeId">
                                            @foreach ($dataItemAttrObjArr as $rowData)
                                            <option value="{{$rowData->id}}">{{$rowData->attr_name}}</option>
                                            @endforeach

                                            </select>
                                        </div>
                                        {{-- <label class="col-form-label col-md-3">Value</label> --}}
                                        <div class="col-md-3">
                                            <input type="text" name="attr_name" class="form-control" id="attrName" placeholder="Color name"/>
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" id="btnGroupAttr" class="btn btn-sm btn-primary m-r-5 ">SAVE </button>
                                            <button type="button" class="btn btn-sm btn-primary m-r-5" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add new</button>
                                            
                                        </div>
                                    </div>
                                     
                               
                                {{-- <fieldset>

                                    <button type="submit" id="btnGroupAttr" class="btn btn-sm btn-primary m-r-5 ">SAVE </button>
                                    <button type="reset" class="btn btn-sm btn-default">Cancel</button>
                                </fieldset> --}}
                            </form>






                            </div>
                            <!-- end panel-body -->
                        </div>
                        <!-- end col-12 -->
                    </div>
                </div>
                <!-- end tab-pane -->


            </div>
                </div>
            </div>
           
            <!-- end col-8 -->
        </div>
        <!-- end row -->
    </div>
    <!-- end #content -->
</div>


    {{-- model --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add New Attribute</h4>
              <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              
            </div>
            <div class="modal-body">
              <form id="formAttribute" method="post">
                  @csrf
                  <div id="errorModelMsg" class="alert alert-block" style="display:none"></div>
                <div class="form-group">
                  <label for="attrName" class="control-label">Attribute name:</label>
                  <input type="text" class="form-control" name="attr_name" id="attrName">
                </div>
                {{-- <div class="form-group">
                  <label for="message-text" class="control-label">Message:</label>
                  <textarea class="form-control" id="message-text"></textarea>
                </div> --}}
              </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveAttribute" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      {{-- model --}}
     