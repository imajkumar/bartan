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
   
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">HSN</h4>
                    <div class="panel-heading-btn">
                    <!-- <a href="#saveHsnModel" id="" onclick="updateCustomerDiscount(this.id);" class="updateCustomerDiscount btn btn-primary" data-toggle="modal">Add discount</a> -->
                    <a href="#saveHsnModel" class="updateCustomerDiscount btn btn-success" data-toggle="modal"><i class="fas fa-lg fa-fw fa-plus-circle"></i> Add HSN</a>
                     <!--    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Id</th>

                                        <th class="text-nowrap">Name</th>
                                        <th class="text-nowrap">Status</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                   <?php 
                                   foreach($hsnDatas as $hsnData){
                                   ?>
                                    <tr>
                                        <td>{{$hsnData->id}}</td>
                                        <td>{{$hsnData->hsn_name}}</td>
                                        
                                       
                                        <td>
                                            @if($hsnData->status == 1)
                                                <span class="badge badge-md btn-success">Active</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Deactive</span>

                                            @endif
                                        </td>

                                        <td>
                                            <a href="#updateHsnModel" id="{{$hsnData->id.'_'.$hsnData->hsn_name}}"  onclick="updateHsn(this.id);" class="btn btn-default" data-toggle="modal" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <?php
                                                if($hsnData->status==0){
                                            ?>
                                                <a href="javascript:void()" id="{{$hsnData->id}}"  onclick="activeHsn(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i> </a>
                                            
                                                <?php }else{ ?>

                                                <a href="javascript:void()" id="{{$hsnData->id}}"  onclick="deactiveHsn(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i> </a>

                                            <?php }?>
                                         </td>
                                       
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





{{-- start model save HSN Model--}}
<div class="modal fade" id="saveHsnModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('saveHSN')}}" id="saveHSN" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add HSN</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        
                        <input type="text" name="hsn_name" id="hsn_name" class="form-control"/>
                        
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model Save  HSN --}} 

{{-- start model Update HSN Model--}}
<div class="modal fade" id="updateHsnModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateHsn')}}" id="updateHsn" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit HSN</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        
                        <input type="hidden" name="hsnId" id="hsnId"/>
                        <input type="text" name="hsn_name" id="hsnName" class="form-control"/>
                        
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update Hsn  --}} 



