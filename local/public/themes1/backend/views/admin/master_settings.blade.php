<!-- begin #content -->
<!-- <style>
    .modal-backdrop {
    position: inherit;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
    </style> -->
<div id="content" class="content">
    
    <!-- begin row -->
      <div class="invoice">
    <div class="row">
      
        <!-- begin col-4 -->
        <div class="col-lg-4">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">GROUP TREE</h4>
                    <div class="panel-heading-btn">
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 -->
                    </div>
                </div>
                <div class="panel-body">
                <!-- <input type="text" class="form-control input-sm" placeholder="Type to search..." id="searchText" name="searchText"/> -->
           
                    <div id="jstree-checkable"></div>
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-4 -->
        <!-- begin col-8 -->
        <div class="col-lg-8">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">GROUP MASTER</h4>
                    <div class="panel-heading-btn">
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click=""><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click=""><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body" style="background-color: #e4e7e8;">
                     <!-- begin nav-tabs -->
            <ul class="nav nav-tabs m-b-10">
                <li class="nav-item">
                    <a href="#default-tab-1" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Group List</span>
                        <span class="d-sm-block d-none">Group List</span>
                    </a>
                </li>
                <li class="nav-item m-l-10">
                    <a href="#default-tab-2" data-toggle="tab" class="nav-link ">
                        <span class="d-sm-none">Group</span>
                        <span class="d-sm-block d-none">Group</span>
                    </a>
                </li>
              
            </ul>
            <!-- end nav-tabs -->
            <!-- begin tab-content -->
            <div class="tab-content">
                <!-- begin tab-pane -->
                <div class="tab-pane fade show active" id="default-tab-1">
                    <div class="table-responsive">
                <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Group</th>
                                        <th class="text-nowrap">Alias</th>
                                        <!-- <th class="text-nowrap">Type</th> -->
                                        <!-- <th class="text-nowrap">Required</th>
                                        <th class="text-nowrap">Unique</th> -->
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                
                                $dataObjArr = DB::table('tbl_group')->orderBy('g_id', 'DESC')->get();
                                $i=1;
                                foreach($dataObjArr as $rowData){
                                ?>
                                   <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$rowData->g_name}}</td>
                                        <td>{{$rowData->alias}}</td>
                                        <td> 
                                        <!-- <a href="javascript:void(0);" id="{{$rowData->g_id}}" class="btn btn-primary"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> -->
                                        <a href="javascript:void(0);" id="{{$rowData->g_id}}" onclick=showGroupEdit({{$rowData->g_id}}) class="btn btn-default groupEdit ajEdit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                        @if($rowData->is_used == 0)

                                            <a href="javascript:void();" id="{{$rowData->g_id}}" onclick=groupDelete({{$rowData->g_id}}) class="btn btn-danger groupDelete" data-toggle="tooltip" data-container="body" data-title="Dalete"><i class="fas fa-lg fa-fw fa-trash-alt"></i></a>
                                        
                                        @endif
                                        </td>
                                        
                                   </tr>
                                   
                                <?php }?>

                                </tbody>
                            </table>
                        </div>




                </div>
                <!-- end tab-pane -->
                <!-- begin tab-pane -->
                <div class="tab-pane fade" id="default-tab-2">
                    <!-- begin row -->
                    <div class="row">
                        <!-- begin col-12 -->
                        <div class="col-12">
                            <!-- begin panel -->
                            <div class="panel panel-inverse">
                                <!-- begin panel-heading -->
                                <div class="panel-heading">
                                    <h4 class="panel-title">ADD ITEM GROUP MASTER </h4>
                                   <!--  <div class="panel-heading-btn">
                                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click=""><i class="fa fa-expand"></i></a>

                                    </div> -->
                                </div>
                                <!-- end panel-heading -->
                                <!-- begin panel-body -->
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row m-b-15">
                                                <label class="col-form-label col-md-12 col-sm-4">Group</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input type="text" name="group_name" id="group_name" class="form-control" placeholder="Enter group" />
        
                                                </div>
                                            </div>
                                            <?php
                                            $dataObjArr = getUnderGroup();
                                            ?>
                                            <div class="form-group row m-b-15">
                                                <label class="col-form-label col-md-12 col-sm-4">Under Group</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control" id="UnderGroup" disabled>
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
                                                    <input type="text" name="alias_name" id="alias_name" class="form-control" placeholder="Enter Alias" />
        
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">HSN</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <input type="text" id="hsn" class="form-control m-b-5" placeholder="Enter HSN" />
        
                                                </div>
                                            </div> -->
                                            


                                        </div>

                                        <div class="col-md-4 col-sm-8">

                                            <div class="form-group row">
                                                <label class="col-md-12 col-sm-4 col-form-label">Primay Group (Y/N)</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3 primaryGroup" id="primaryGroup">
                                                        <option selected="selected" value="0">NO</option>
                                                        <option value="1">YES</option>
        
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- <div class="form-group row m-b-15">
                                                <label class="col-md-12 col-sm-4 col-form-label">TAX CATEGORY</label>
                                                <div class="col-md-12 col-sm-8">
                                                    <select class="form-control mb-3" id="taxCategory">
                                                        <option selected="selected" value="">-NA-</option>
                                                        <option value="AF">GST 15%</option>
                                                        <option value="AL">CGST 10%</option>
        
                                                    </select>
                                                </div>
                                            </div> -->
                                            


                                        </div>

                                    </div>

                                    <fieldset>

                                        <button type="button" id="btnGroup" class="btn btn-md btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
                                        <button type="reset" class="btn btn-md btn-default"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
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
                                //$dataItemAttrObjArr = getItemAttributes();
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
               


            </div>
                </div>
            </div>
           
            <!-- end col-8 -->
        </div>
        <!-- end row -->
    </div>
    </div>
    <!-- end #content -->
</div>


<!-- {{-- Start group edit  model --}} -->
    <div class="modal fade" id="groupEditModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Group</h4>
              <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              
            </div>
            <div class="modal-body">
             
                <div class="row" id="groupEditFormAppend">
                    

                </div>
              
            </div>
            <div class="modal-footer">
                <button type="button" id="updateGroup" class="btn btn-success">Update</button>
                <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      {{-- End group edit  model --}}



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
                <button type="button" id="saveAttribute" class="btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Submit</button>
                <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Close</button>
            </div>
          </div>
        </div>
      </div>
      {{-- model --}}
     