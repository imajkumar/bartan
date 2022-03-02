
    <div id="content" class="content">
    

    <!-- begin row -->
    
    <div class="row">
        
        <div class="col-xl-12">
            
            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading">
                    <h4 class="panel-title">ORDERS</h4>
                    <div class="panel-heading-btn">
                    
                        <a class="btn btn-primary pull-right" href="javascript:void(0);" onclick="getPaymentStatusPayByLink();" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Get payment status</a>

                        <!-- <a class="btn btn-primary pull-right" href="{{route('addNewCustomerLayout')}}" style="background-color:#0f0f0f;border: none;"><i class="fas fa-lg fa-fw m-r-10 fa-plus-circle"></i>Add</a> -->
                       <!--  <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
 -->
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
                                    
                                     foreach($itemOrders as $itemOrder){
                                     
                                        $itemOrder = (object) $itemOrder;
                                        if(@$itemOrder->packing_stage){

                                            $itemOrdersCount = DB::table('item_order_packing_details')
                                            ->where('order_number', $itemOrder->order_id)
                                            ->where('packing_no', $itemOrder->packing_no)
                                            ->count();
                                        }else{

                                            $itemOrdersCount = DB::table('tbl_item_orders')
                                            ->where('order_id', $itemOrder->order_id)
                                            ->count();
                                        }
                                        
                                        
                                        //$item = get_item_detail($itemOrder->item_id);
                                        //pr($itemOrder);
                                            
                                        //if(count($itemOrders)>0){
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
                                        <td>{{$itemOrder->grand_total}}</td>
                                   
                                       <?php if(@$itemOrder->packing_stage){?>
                                        <td>
                                        <span class="badge badge-md btn-danger">Packed</span>
                                        </td>
                                       <?php }else{ ?>
                                        <td>
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md btn-success">Proccessed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md btn-danger">New order</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md btn-danger">Packed</span>

                                           
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
                                            //pr($paymntStaus);
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md btn btn-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md btn btn-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        

                                        <td>
                                           
                                           <a href="{{route('viewOrderSales', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>
                                            
                                           
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

