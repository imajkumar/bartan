<!-- begin #content -->
<style>
    .modal-backdrop {
    position: inherit;
    top: 0;
    left: 0;
    z-index: 1040;
    width: 100vw;
    height: 100vh;
    background-color: #000;
}
    </style>
<div id="content" class="content">
    

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">DELIVERED ORDERS</h4>
                    <div class="panel-heading-btn">
                        {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}}
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>

                    </div>
                </div>
                <div class="panel-body">
                    
                    <div class="tab-content">

                        <!-- begin tab-pane -->
                        {{-- <div id="Grid"></div> --}}
                        
                        
                        
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Order No.</th>
                                        <th class="text-nowrap">Shipping No.</th>
                                        <th class="text-nowrap">Shop name</th>

                                        <th class="text-nowrap">No.of items</th>
                                       
                                        <th class="text-nowrap">Stage</th>
                                        <th class="text-nowrap">Date</th>
                                      
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                     foreach($itemOrders as $itemOrder){
                                     
                                        $itemOrder = (object) $itemOrder;
                                      

                                            $itemOrdersCount = DB::table('shipped_orders')
                                            ->where('shiping_no', $itemOrder->shiping_no)
                                            ->where('packing_no', $itemOrder->packing_no)
                                            ->count();
                                       
                                        
                                        
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrder);
                                            
                                        //if(count($itemOrders)>0){
                                            @$customerdetail = get_customer_and_address_by__user_id(@$itemOrder->customer_id);
                                            
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_number}}</td>
                                        <td>{{$itemOrder->shiping_no}}</td>

                                        <td>{{@$customerdetail->store_name}}</td>

                                        <td>{{$itemOrdersCount}}</td>
                                       
                                   
                                      
                                        <td>
                                        <span class="badge badge-md btn-danger">Delivered</span>
                                        </td>
                                       
                                        <td>
                                            {{date("d-m-Y", strtoTime($itemOrder->created_at))}}
                                        </td>
                                        
                                       
                                        
                                        <td>
                                            
                                            <!-- <a href="#updateOrderStageFromShiped" id="{{$itemOrder->order_number.'_'.$itemOrder->order_stage.'_'.$itemOrder->shiping_no.'_'.$itemOrder->packing_no}}" onclick="updateOrderStageFromShippedOrder(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> -->
                                            <a href="{{route('viewOrderAdmin', $itemOrder->order_number)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a>
                                            
                                        </td>
                                        <!-- <td>
                                            
                                            <a href="#updateOrderStageFromShiped" id="{{$itemOrder->order_number.'_'.$itemOrder->order_stage.'_'.$itemOrder->shiping_no.'_'.$itemOrder->packing_no}}" onclick="updateOrderStageFromShippedOrder(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                                            
                                            <a href="{{route('viewOrderAdmin', $itemOrder->order_number)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a>
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

