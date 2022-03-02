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
                    <h4 class="panel-title">TO BE PACKED</h4>
                    <div class="panel-heading-btn">
                        {{-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> --}}
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a> -->

                    </div>
                </div>
                <ul class="nav nav-tabs m-l-10 m-t-10">
                <li class="nav-item m-r-10">
                    <a href="#tab-pending" data-toggle="tab" class="nav-link active">
                        <span class="d-sm-none">Pending</span>
                        <span class="d-sm-block d-none">Pending</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#tab-inprocess" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Inprocess</span>
                        <span class="d-sm-block d-none">Inprocess</span>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#tab-rejected" id="rejectedTab" data-toggle="tab" class="nav-link">
                        <span class="d-sm-none">Rejected</span>
                        <span class="d-sm-block d-none">Rejected</span>
                    </a>
                </li> -->
                


            </ul>
                <!-- <div class="panel-body"> -->
                    
                    <div class="tab-content">


                        <div class="tab-pane fade active show" id="tab-pending">
                            
                            
                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Order No.</th>
                                        <th class="text-nowrap">Order date</th>
                                        <th class="text-nowrap">Shop name</th>

                                        <th class="text-nowrap">No.of items</th>
                                        <th class="text-nowrap">Total Amount</th>
                                        <th class="text-nowrap">Stage</th>
                                        <th class="text-nowrap">Payment status</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    //pr($itemOrders);
                                    foreach($itemOrders as $itemOrder){
                                     
                                        $itemOrder = (object) $itemOrder;
                                        if($itemOrder->stage != 6){
                                        $ItemOrderId = $itemOrder->order_id;
                                        // $itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)
                                        // ->where('is_Inprocess', 0)->orWhere('is_Inprocess', 2)->count();
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrders);

                                        $itemOrdersCount = DB::table('tbl_item_orders')
                                        ->where('order_id', $itemOrder->order_id)
                                        ->where('is_Inprocess', 0)
                                        //->orWhere('is_Inprocess', 2)
                                        ->orWhere(function($query) use ($ItemOrderId){
                                            $query->orWhere('is_Inprocess', 2)
                                            ->where('order_id', $ItemOrderId);
                                        })
                                        ->count();
                                            
                                        //if($itemOrder->is_Inprocess == 0){
                                            @$customerdetail = get_customer_and_address_by__user_id(@$itemOrder->customer_id);
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_id}} </td>
                                        <td>
                                            {{date("d-m-Y", strtoTime($itemOrder->created_at))}}
                                        </td>
                                        <td>{{@$customerdetail->store_name}}</td>
                                        <td>{{$itemOrdersCount}}</td>
                                        <td>{{$itemOrder->grand_total}}</td>
                                        <!-- <td>{{$itemOrder->total_amount}}</td> -->
                                   
                                        <?php if($itemOrder->pending_qty > 0){?>
                                        <td>
                                        <span class="badge badge-md btn-success">Partial</span>
                                        </td>
                                        <?php } else{?>
                                        <td>
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md btn-success">To be packed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md btn-danger">New order</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md btn-danger">Packaging</span>

                                           
                                            @elseif($itemOrder->stage == 3)
                                                <span class="badge badge-md btn-danger">Shipping</span>

                                           
                                          
                                               
                                            @elseif($itemOrder->stage == 4)
                                            <span class="badge badge-md btn-danger">Delivered</span>
                                            
                                            @elseif($itemOrder->stage == 5)
                                            <span class="badge badge-md btn-danger">Hold</span>
                                            
                                            @elseif($itemOrder->stage == 6)
                                            <span class="badge badge-md btn-danger">Cancel</span>

                                            @else
                                            <span class="badge badge-md btn-danger">Return</span>
                                            @endif
                                        </td>
                                        <?php }?>
                                        
                                        <td>
                                            <?php
                                             $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                            //$paymntStaus =  DB::table('tbl_payment_status')->get();
                                            //pr($paymntStaus);payment_option
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md btn btn-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md btn btn-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        

                                        <td>
                                            {{-- <a href="{{route('editOrderStageAdmin', $itemOrder->order_id)}}" class="btn btn-info"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> --}}
                                            <!-- <a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> -->
                                            @if(@$paymntStaus->status == 1)
                                            <a href="{{route('toBePackedDetail', $itemOrder->order_id)}}" id="{{$itemOrder->order_id}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            @else
                                            <a href="{{route('toBePackedDetail', $itemOrder->order_id)}}" id="{{$itemOrder->order_id}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <!-- <a href="javascript:void(0);" id="{{$itemOrder->order_id}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a> -->

                                            @endif
                                            <a href="{{route('viewOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>
                                            <a href="{{url('order-cancel-by-admin/'. $itemOrder->order_id.'/'. Auth::user()->id)}}" onclick="return confirm('Do you really want to Cancel this order?');" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Cancel">Cancel</a>
                                        </td>
                                       
                                    </tr>
                                         
                                <?php }} ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="tab-inprocess">
                            
                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Order No.</th>
                                        <th class="text-nowrap">Order date</th>
                                        <th class="text-nowrap">Shop name</th>

                                        <th class="text-nowrap">No.of items</th>
                                        <!-- <th class="text-nowrap">Total Amount</th> -->
                                        <th class="text-nowrap">Stage</th>
                                        <th class="text-nowrap">Payment status</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // $itemOrders = DB::table('tbl_payment_status')
                                    // ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
                                    // ->join('item_order_packing_details','item_order_packing_details.packing_no','=','tbl_item_orders.packing_no')
                                    // ->orderBy('item_order_packing_details.id', 'desc')
                                    //  ->where('tbl_item_orders.is_packed', 1)
                                    // ->get();

                                    $itemOrders = DB::table('tbl_payment_status')
                                    ->rightjoin('tbl_item_orders','tbl_item_orders.order_id','=','tbl_payment_status.item_order_id')
                                    //->leftjoin('item_order_packing_details','tbl_item_orders.order_id','=','item_order_packing_details.order_number')
                                   
                                    ->orderBy('tbl_payment_status.id', 'desc')
                                    ->where('tbl_item_orders.stage', 1)
                                    ->where('tbl_item_orders.is_Inprocess', 1)
                                    
                                    ->orWhere('tbl_item_orders.is_Inprocess', 2)
                                    ->where('tbl_item_orders.is_packed', 0)
                                    // ->Where(function($query){
                                    //     $query ->where('item_order_packing_details.is_packed', 0)
                                    //     ->where('item_order_packing_details.order_number', '=', 'tbl_item_orders.order_id');
                                        
                                    // })
                                    
                                    ->get();
                                     //pr($itemOrders);
                                    $itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
                                    //pr($itemOrders);
                                     foreach($itemOrders as $itemOrder){
                                     
                                        $itemOrder = (object) $itemOrder;
                                        if($itemOrder->stage != 6){
                                        $ItemOrderId = $itemOrder->order_id;
                                        // $itemOrdersCount = DB::table('tbl_item_orders')
                                        // ->where('order_id', $itemOrder->order_id)
                                        
                                        // ->where('is_packed', 0)
                                        // ->where('is_Inprocess', 1)
                                        // ->orWhere('is_Inprocess', 2)
                                        // ->count();
                                        $itemOrdersCount = DB::table('tbl_item_orders')
                                        ->where('order_id', $itemOrder->order_id)
                                        ->where('is_packed', 0)
                                        ->where('is_Inprocess', 1)
                                        ->orWhere(function($query) use ($ItemOrderId){
                                            $query ->orWhere('is_Inprocess', 2)
                                            ->where('order_id', $ItemOrderId);
                                        })
                                        ->count();

                                        if($itemOrdersCount > 0){
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrders);
                                            
                                        //if(count($itemOrders)>0){
                                            //if($itemOrder->is_packed ==1){
                                                @$customerdetail = get_customer_and_address_by__user_id(@$itemOrder->customer_id);
                                                
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_id}}</td>
                                        <td>
                                            {{date("d-m-Y", strtoTime($itemOrder->created_at))}}
                                        </td>
                                        
                                        <td>{{@$customerdetail->store_name}}</td>

                                        <td>{{$itemOrdersCount}}</td>
                                        <!-- <td>{{$itemOrder->total_amount}}</td> -->
                                   
                                       
                                        <td>
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md btn-success">To be packed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md btn-danger">New order</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md btn-danger">Packaging</span>

                                           
                                            @elseif($itemOrder->stage == 3)
                                                <span class="badge badge-md btn-danger">Shipping</span>

                                           
                                          
                                               
                                            @elseif($itemOrder->stage == 4)
                                            <span class="badge badge-md btn-danger">Delivered</span>
                                            
                                            @elseif($itemOrder->stage == 5)
                                            <span class="badge badge-md btn-danger">Hold</span>
                                            
                                            @elseif($itemOrder->stage == 6)
                                            <span class="badge badge-md btn-danger">Cancel</span>

                                            @else
                                            <span class="badge badge-md btn-danger">Return</span>
                                            @endif
                                        </td>
                                        
                                        
                                        <td>
                                            <?php
                                             $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                            //pr($paymntStaus);
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md btn btn-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md btn btn-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        

                                        <td>
                                            {{-- <a href="{{route('editOrderStageAdmin', $itemOrder->order_id)}}" class="btn btn-info"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> --}}
                                            <!-- <a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> -->
                                            <a href="{{route('toBePackedProcess', $itemOrder->order_id)}}" class="btn btn-default" data-toggle="tooltip" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
                                            <!--<a href="{{route('viewOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>-->
                                            <a href="{{route('viewToBeProccessTabOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>
                                            <a href="{{url('order-cancel-by-admin/'. $itemOrder->order_id.'/'. Auth::user()->id)}}" onclick="return confirm('Do you really want to Cancel this order?');" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Cancel">Cancel</a>
                                        </td>
                                       
                                    </tr>
                                         
                                <?php }}}?>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="tab-pane fade" id="tab-rejected">
                            
                            
                            <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                                <thead>
                                    <tr>
                                        <th width="1%">Order No.</th>
                                        <th class="text-nowrap">Order date</th>

                                        <th class="text-nowrap">No.of items</th>
                                        <th class="text-nowrap">Total Amount</th>
                                        <th class="text-nowrap">Stage</th>
                                        <th class="text-nowrap">Payment status</th>
                                        <th class="text-nowrap">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    
                                     foreach($itemOrders as $itemOrder){
                                     
                                        $itemOrder = (object) $itemOrder;
                                        $itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrders);
                                            
                                        //if(count($itemOrders)>0){
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_id}}</td>
                                        <td>
                                            {{date("d-m-Y", strtoTime($itemOrder->created_at))}}
                                        </td>
                                        
                                        <td>{{$itemOrdersCount}}</td>
                                        <td>{{$itemOrder->total_amount}}</td>
                                   
                                       
                                        <td>
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md btn-success">Proccessed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md btn-danger">New order</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md btn-danger">Packaging</span>

                                           
                                            @elseif($itemOrder->stage == 3)
                                                <span class="badge badge-md btn-danger">Shipping</span>

                                           
                                          
                                               
                                            @elseif($itemOrder->stage == 4)
                                            <span class="badge badge-md btn-danger">Delivered</span>
                                            
                                            @elseif($itemOrder->stage == 5)
                                            <span class="badge badge-md btn-danger">Hold</span>
                                            
                                            @elseif($itemOrder->stage == 6)
                                            <span class="badge badge-md btn-danger">Cancel</span>

                                            @else
                                            <span class="badge badge-md btn-danger">Return</span>
                                            @endif
                                        </td>
                                        
                                        
                                        <td>
                                            <?php
                                             $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                            //pr($paymntStaus);
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md btn btn-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md btn btn-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        

                                        <td>
                                            {{-- <a href="{{route('editOrderStageAdmin', $itemOrder->order_id)}}" class="btn btn-info"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a> --}}
                                            <a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal"><i class="far fa-lg fa-fw m-r-10 fa-edit"></i>Edit</a>
                                            <a href="{{route('viewOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a>
                                        </td>
                                       
                                    </tr>
                                         
                                <?php }?>
                                </tbody>
                            </table>
                        </div> -->
                    </div>
                <!-- end col-8 -->

                
            <!-- </div> -->


        </div>
    </div>

</div>




