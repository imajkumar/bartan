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
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">CUSTOMER CLASS</h4>
                    <div class="panel-heading-btn">
                    <!-- <a href="#saveHsnModel" id="" onclick="updateCustomerDiscount(this.id);" class="updateCustomerDiscount btn btn-primary" data-toggle="modal">Add discount</a> -->
                    <!-- <a href="#saveCustomerCategoryModel" class="btn btn-primary" data-toggle="modal">Add</a> -->
                      <!--   <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
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

                                        <th class="text-nowrap">Customer category</th>
                                        <th class="text-nowrap">Created date</th>
                                        <th class="text-nowrap">Status</th>
                                        
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                   <?php 

                                   foreach($customerCategories as $customerCategoryList){
                                   ?>
                                    <tr>
                                        <td>{{$customerCategoryList->id}}</td>
                                        <td>{{$customerCategoryList->cust_category_name}}</td>
                                        <td>{{date("d-m-Y", strtotime($customerCategoryList->created_at))}}</td>
                                        
                                       
                                        <td>
                                            @if($customerCategoryList->status == 1)
                                                <span class="badge badge-md btn-success">Active</span>

                                            @else
                                                <span class="badge badge-md btn-danger">Deactive</span>

                                            @endif
                                        </td>
                                        

                                        <td>
                                            <a href="#updateCustomerClassModel" id="{{$customerCategoryList->id.'_'.$customerCategoryList->cust_category_name}}"  onclick="updateCustomerCategory(this.id);" class="btn btn-default" data-toggle="modal" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <?php
                                                if($customerCategoryList->status==0){
                                            ?>
                                                <a href="javascript:void()" id="{{$customerCategoryList->id}}"  onclick="activeCustomerCategory(this.id);" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="Active"><i class="far fa-lg fa-fw icon-user-following"></i> </a>
                                            
                                                <?php }else{ ?>

                                                <a href="javascript:void()" id="{{$customerCategoryList->id}}"  onclick="deactiveCustomerCategory(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Deactive"><i class="far fa-lg fa-fw icon-user-unfollow"></i> </a>

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





{{-- start model save saveCustomerCategoryModel Model--}}
<div class="modal fade" id="saveCustomerCategoryModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('saveCustomerCategory')}}" id="saveCustomerCategory" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Customer Category</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        
                        <input type="text" name="cust_category_name" id="cust_category_name" class="form-control"/>
                        
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-success"><i class="fa fa-paper-plane"></i> Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model Save  saveCustomerCategoryModel --}} 

{{-- start model Update updateCustomerCategoryModel Model--}}
<div class="modal fade" id="updateCustomerClassModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateCustomerCategory')}}" id="updateCustomerCategory" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit HSN</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        
                        <input type="hidden" name="customerCategoryId" id="customerCategoryId"/>
                        <input type="text" name="cust_category_name" id="custCategoryName" class="form-control"/>
                        
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update Hsn  --}} 



