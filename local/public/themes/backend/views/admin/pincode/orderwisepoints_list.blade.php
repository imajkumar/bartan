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
<!-- begin #content -->

<div id="content" class="content">

    <!-- begin row -->

    <div class="row">

        <div class="col-xl-12">

            <div class="panel panel-inverse" data-sortable-id="tree-view-1">
                <div class="panel-heading ui-sortable-handle">
                    <h4 class="panel-title">Order Wise Points</h4>

                </div>
                <div class="panel-body">

                    <div class="tab-content">

                        <!-- begin tab-pane -->


                        <div class="row">
                            <div class="col-sm-2 form-group">
                                <label>From Date</label>
                                <input type="date" name="pincode" id="pincode" value="" class="form-control" placeholder="0" aria-invalid="false">
                            </div>
                            <div class="col-sm-2">
                                <label>To Date</label>
                                <input type="date" name="pincode" id="pincode" value="" class="form-control" placeholder="0" aria-invalid="false">
                            </div>
                            <div class="col-sm-2">
                                <label>Customer</label>
                                <select class="form-control">
                                    <option>Select</option>
                                    <?php

                                    // $custmerArr=DB::table('shipped_orders')->distinct()->where('order_stage', 4)->get('customer_id');
                                    $custmerArr = DB::table('shipped_orders')->distinct()->get('customer_id');

                                    foreach ($custmerArr as $key => $rowData) {

                                        
                                        @$customerdetail = get_customer_and_address_by__user_id(@$rowData->customer_id);

                                    ?>
                                        <option value="{{$rowData->customer_id}}">{{@$customerdetail->store_name}}</option>
                                    <?php


                                    }
                                    ?>
                                </select>
                            </div>
                        </div>


                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>

                                    <th class="text-nowrap">Order No.</th>
                                    <th>Order Date</th>
                                    <th>Tpye </th>
                                    <th>Customer Name</th>
                                    <th>Dispatch Date</th>
                                    <th>Earned Point</th>
                                    <th width="50">Action</th>
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
                                        
                                        
                                       
                                            
                                        //if(count($itemOrders)>0){
                                            @$customerdetail = get_customer_and_address_by__user_id(@$itemOrder->customer_id);

                                            $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_number)
                                            ->first();
                                            $custmerArr = DB::table('tbl_customers')->where('user_id', $rowData->customer_id)->first()->cutomer_fname;

                                            //get order number wise points
                                            // $itemOrder->order_number
                                            $custmerOrderArr = DB::table('shipped_orders')->where('order_number',$itemOrder->order_number)->get();
                                            $Xpoint=0;
                                            foreach ($custmerOrderArr as $key => $row) {
                                                # code...
                                                $item_id=$row->item_id;

                                                $mstPontArr = DB::table('mst_point_system')->where('item_id',$item_id)->first();
                                                $Xpoint=$Xpoint+$mstPontArr->item_point;





                                                

                                            }


                                            //get order number wise points
                                            



                                            
                                    ?>
                                    <tr>
                                        <td>{{$itemOrder->order_number}}</td>
                                        <td>
                                        {{date("j F Y h:i a", strtoTime(@$paymntStaus->created_at))}}
                                      
                                        </td>

                                        <td>Order</td>
                                        <td>{{@$customerdetail->store_name}}</td>

                                        <td>NA</td>
                                      
                                        <td>{{$Xpoint}}</td>
                                       
                                        
                                        <td>
                                            
                                          
                                            <a href="{{route('viewDeliveredOrderAdminPoint', $itemOrder->shiping_no)}}" class="btn btn-success"><i class="fas fa-lg fa-fw fa-eye"></i>View</a>
                                            
                                            
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
</div>