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
                    <h4 class="panel-title">Order Items Wise Points</h4>

                </div>
                <div class="panel-body">

                    <div class="tab-content">

                        <!-- begin tab-pane -->


                        <div class="row">
                            <!-- <div class="col-sm-2 form-group">
                                <label>From Date</label>
                                <input type="date" name="pincode" id="pincode" value="" class="form-control" placeholder="0" aria-invalid="false">
                            </div>
                            <div class="col-sm-2">
                                <label>To Date</label>
                                <input type="date" name="pincode" id="pincode" value="" class="form-control" placeholder="0" aria-invalid="false">
                            </div> -->

                        </div>


                        <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle">
                            <thead>
                                <tr>

                                    <th class="text-nowrap">Order No.</th>
                                    <th>Order Date</th>
                                    <th>Item Name </th>
                                    <th>QTY</th>
                                    <th>Type</th>
                                    <th>Dispatch Date</th>
                                    <th>Earned Point</th>
                                    <th width="50">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // echo "<pre>";
    
                                foreach ($itemOrders as $rowsData) {


                                    // print_r($rowsData);
                                    
                                    $mstPontArr = DB::table('mst_point_system')->where('item_id',$rowsData->item_id)->first();



                                    

                                ?>
                                    <tr>
                                        <td>{{$rowsData->order_id}}</td>
                                        <td>{{ date('j F Y H:iA',strtotime($rowsData->created_at))}}</td>
                                        <td>{{$mstPontArr->item_name}}</td>
                                        <td>{{$rowsData->quantity}}</td>
                                        <td>Order</td>
                                        <td>NA</td>
                                        
                                        <td>{{$mstPontArr->item_point}}</td>

                                    <td>
                                        


                                        </td>


                                    </tr>

                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- end col-8 -->
                </div>
            </div>
        </div>

    </div>
</div>