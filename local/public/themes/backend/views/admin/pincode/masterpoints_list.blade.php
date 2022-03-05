<!-- begin #content -->

<div id="content" class="content">
   
    

    @if(Session::has('message-type'))
    
    <div class="alert alert-{{ Session::get('message-type') }}"> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    {{ Session::get('message') }}
    </div>
@endif

    <!-- end page-header -->

    <!-- begin row -->
    
    <div class="row">
        <div class="col-xl-12">
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">POINTS</h4>
                    <div class="panel-heading-btn">
                        <!-- <a class="btn btn-success pull-right" href="{{route('addPincode')}}" style="border: none;"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Add New</a> -->
                        
                        
                        <a class="btn btn-success pull-right" href="{{route('exportPointMaster')}}"><i class="fas fa-lg fa-fw fa-download"></i> Export Points Master</a>
                        
                       
                        <form class="impbtn form-horizontal" method="post" action="{{route('pointMasterImport')}}" id="pincodeImport" name="pincodeImport" enctype="multipart/form-data">
                            @csrf
                            <input type="file"  name="mp_csvfile" class="inpsize" id="m_csvfile" accept=".csv" required/>
                            <input type="submit" value="Import" id="pincodeImportUpdateBtn" class="btn btn-success pull-right" />
                        </form>
                       
                        <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
              
               
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%"></th>
                                        
                                        <th class="text-nowrap">Item ID</th>
                                       
                                        <th class="text-nowrap">Item Name</th>
                                        <th class="text-nowrap">Item SKU</th>
                                        <th class="text-nowrap">Points</th>
                                        <th class="text-nowrap">Created on</th>
                                       
                                        <th class="text-nowrap" width="20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=0;
                                        
                                    foreach($pointsLists as $rows)
                                    {
                                        
                                    ?>
                                    <tr>
                                        <td>{{$i++}}</td>
                                        
                                       
                                        <td>{{@$rows->item_id}}</td>
                                        <td>{{@$rows->item_name}}</td>
                                        <td>{{@$rows->item_sku}}</td>
                                        <td>{{@$rows->item_point}}</td>
                                       
                                        <td>{{date('d-m-Y', strtotime($rows->created_at))}}</td>
                                        
                                        <!-- <td>
                                            
                                            <a href="{{route('editPincode', $rows->item_id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw  fa-edit"></i></a>
                                            
                                            <a href="{{route('deletePincode', $rows->item_id)}}" onclick="return confirm('Are you sure you want to remove this?');" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Delete"><i class="fa fa-trash" aria-hidden="true"></i> </a>
                                        </td> -->
                                    </tr>
                                <?php }?>

                                </tbody>
                            </table>

                        </div>
                <!-- end col-8 -->

                
            </div>


        </div>
    </div>

</div>

<!-- end row -->
{{-- </div> --}}
<!-- end #content -->
