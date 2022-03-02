<?php 
// $scanItemDetail = DB::table('to_be_packed_scan_items')
                                   
// ->where('order_number', @$itemOrders[0]->order_id)

// ->get();

$itemActualOrdersDetial = DB::table('tbl_item_orders')
        ->where('packing_no', @$itemOrders[0]->packing_no)
        ->first();

$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$users = @$customerdetail->business_state;
$city = get_cityNameByCityId(@$customerdetail->business_city);


?>

<!-- end admin #sidebar -->

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <!-- <ol class="breadcrumb hidden-print float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Order</li>
    </ol> -->
    <!-- end breadcrumb -->
    <!-- begin page-header -->
   <!--  <h1 class="page-header hidden-print">Order detail <small>About order</small></h1> -->
    <!-- end page-header -->
    <!-- begin invoice -->
    <div class="invoice">
        <!-- begin invoice-company -->
        <!-- <div class="invoice-company">


            Neeraj verma
        </div> -->
        <!-- end invoice-company -->


        <div class="invoice-company">


                {{$customer_name}}

             <div class="help-tip">
    <p>
                            <strong>Customer Name:</strong> {{$customer_name}}<br />
                           <strong> Street Address: </strong>{{$customerdetail->business_street_address}}<br />
                         <strong>   Country:</strong> {{$country->name}},<br />
                          <strong>  State:</strong> {{$state->name}},<br />
                           <strong> City:</strong> {{$city->name}}<br />
                          <strong>  Zip Code:</strong> {{$customerdetail->business_postal_code}}<br />
                          <strong>  Phone:</strong> {{Auth::user()->mobile}}<br />
                           <strong> Emal id:</strong> {{Auth::user()->email}}<br />
                           <strong> GST NO.:</strong> {{$customerdetail->business_gst_number}}<br />

                      </p>
 
</div>

            </div>
        <div class="shipped-border">
        <div class="row">

          <!--   <div class="col-xl-4 col-md-12">
                <div class="widget widget-stats bg-black-transparent-3">

                    <div class="stats-info">
                        <strong>Customer Name: </strong>{{$customer_name}}<br />
                       <strong> Street Address:</strong> {{$customerdetail->business_street_address}}<br />
                        <strong>Country: </strong>{{$country->name}},<br>
                        <strong>State:</strong> {{$state->name}},<br>
                        <strong>City:</strong> {{$city->name}}<br />
                       <strong> Zip Code:</strong> {{$customerdetail->business_postal_code}}<br />
                      <strong>  Phone:</strong> {{Auth::user()->mobile}}<br />
                        <strong>Emal id:</strong> {{Auth::user()->email}}<br />
                        <strong>GST NO.:</strong> {{$customerdetail->business_gst_number}}<br />

                    </div>

                </div>
            </div> -->


            <div class="col-xl-4 col-md-6">
                <div class="widget widget-stats bg-black-transparent-3">

                    <div class="stats-info">
                        <strong>
                           Order No:</strong> {{@$itemOrders[0]->order_number}}
                        
                        <!-- <small>Invoice / July period</small> -->

                             <br>
                        <?php echo date('M-d-Y', strtotime(@$itemActualOrdersDetial->created_at));?>
                     <!--    <br>
                     <strong>   Stage: </strong>
                        <span class="badge badge-md badge-danger">Packed</span>




                        <br>

                       <strong> Payment status:</strong>

                        <span class="badge badge-md badge-success">Success</span>

                        <br> -->


                    </div>

                </div>
            </div>


            <div class="col-xl-4 col-md-6">
                <div class="widget widget-stats bg-black-transparent-3">

                    <div class="stats-info">
                       <strong>Packing No :</strong>
                            {{@$itemOrders[0]->packing_no}} <br>
                      <strong>  Packing Date :</strong>
                        {{date('M-d-Y', strtotime(@$itemOrders[0]->created_at))}}


                    </div>

                </div>
            </div>

            <?php

            $checkShipedOrderExists = DB::table('shipped_orders')
                ->where('order_number', @$itemOrders[0]->order_number)
                ->where('customer_id', @$itemOrders[0]->customer_id)
                ->where('packing_no', @$itemOrders[0]->packing_no)
            
                ->first();
        if($checkShipedOrderExists){
            ?>

                <div class="col-xl-4 col-md-6">
            <div class="widget widget-stats bg-black-transparent-3">
           
                
                    <div class="stats-info">
                      <strong>Shipping No:</strong>
                            {{(@$checkShipedOrderExists->shiping_no)? @$checkShipedOrderExists->shiping_no : ''}}<br>
                     <strong> Shipping Date:</strong>
                        {{(@$checkShipedOrderExists->created_at)? date('M-d-Y', strtotime(@$checkShipedOrderExists->created_at)) : ''}}
                    </div>

                </div>
            </div>

        <?php }?>

        </div>

</div>
        <!-- begin invoice-header -->

        <!-- end invoice-header -->


        <form method="post" action="{{route('saveShippedOrderWithTransport')}}" id="saveShippedOrderWithTransport" enctype="multipart/form-data">
           @csrf
           <input type="hidden" name="packing_no" value="{{@$itemOrders[0]->packing_no}}"/>
            <div class="row">


                <div class="col-xl-12 col-lg-12">


                    <table id="data-table-scroller" class="table table-striped table-bordered  table-td-valign-middle"
                        cellspacing="0" width="100%">
                        <thead>
                            <tr>


                                <th class="text-nowrap">Item</th>
                                <th class="text-nowrap">Item Name</th>
                                <th class="text-nowrap">Quantity</th>
                                <th class="text-nowrap">Unit</th>
                                <!-- <th class="text-nowrap">Action</th> -->
                            </tr>
                        </thead>
                        <tbody>

                            <?php 

foreach($itemOrders as $item){
    $itemDetail = get_item_by_item_id($item->item_id);

                        $itemImages = get_item_default_img_item_id($item->item_id);

							if ($itemImages) {

								$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
							} else {

								$itemImg = FRONT . 'img/product/product-iphone.png';
							}
?>
                            <tr>

                                <td width="1%" class="with-img"><img src="{{$itemImg}}" width="40" /></td>
                                <td>{{@$itemDetail->item_name}}</td>
                                <td>{{@$item->qty}}</td>
                                <td>{{@$item->unit}}</td>
                                <!-- <td>
        <p>

        <a href="javascript:;" class="btn btn-warning btn-icon btn-circle"><i class="fa fa-pencil-square-o"></i></a>
        <a href="javascript:;" class="btn btn-danger btn-icon btn-circle"><i class="fa fa-times"></i></a>


        </p>
        </td> -->

                            </tr>
                            <?php }?>







                        </tbody>


                    </table>
                </div>

                <div class="col-xl-6 ui-sortable ">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">

                        <div class="panel-heading">
                            <h4 class="panel-title">Enter Packing Details</h4>

                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <div class="panel-body">




                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Small Box</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5" name="small_box" id="small_box" placeholder="Small Box"
                                                value="{{@$itemOrders[0]->small_box}}" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">
                                            Medium Box</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5" name="medium_box" id="medium_box" placeholder=" Medium Box"
                                                value="{{@$itemOrders[0]->medium_box}}" readonly />
                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Large Box</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5" name="large_box" id="large_box" placeholder="Large Box"
                                                value="{{@$itemOrders[0]->large_box}}" readonly />

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Bori</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5"
                                                value="{{@$itemOrders[0]->bori}}" name="bori" id="bori" placeholder="Bori" readonly />

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Other</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5"
                                                value="{{@$itemOrders[0]->other}}" name="other" id="other" placeholder="Other" readonly />

                                        </div>
                                    </div>


                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Total</label>

                                        <div class="col-md-8">
                                            <input type="text" class="form-control m-b-5"
                                                value="{{@$itemOrders[0]->total}}"  name="total" id="total" placeholder="Other" readonly />

                                        </div>
                                    </div>



                                </div>

                            </div>






                        </div>
                    </div>


                </div>


                <div class="col-xl-6 ui-sortable ">
                    <div class="panel panel-inverse" data-sortable-id="form-stuff-1">

                        <div class="panel-heading">
                            <h4 class="panel-title">Heading</h4>

                        </div>

                        <div class="row">







                            <div class="col-xl-12">
                                <div class="panel-body">




                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4"> Transporter Name </label>
                                        <div class="col-md-8">
                                            <select name="transporter_id" id="transporter_id" class="form-control">
                                                <option>Select</option>
                                               <?php 
                                                    $transports = DB::table('transport_master')->get();
                                                    foreach($transports as $transport){
                                                ?>
                                                <option  value="{{$transport->id}}">{{$transport->transporter_name}}</option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">
                                            Docket Number</label>
                                        <div class="col-md-8">
                                            <input type="text" name="docket_number" id="docket_number" class="form-control m-b-5"
                                                placeholder="Docket Number" />
                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Docket Name</label>

                                        <div class="col-md-8">
                                            <input type="text" name="docket_name" id="docket_name" class="form-control m-b-5" placeholder="Docket Name" />

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Tentative Delivery Date</label>

                                        <div class="col-md-8">
                                            <div class="input-group" id="default-daterange">
                                                <input type="text" name="tentative_delivery_date" id="tentative_delivery_date" class="form-control"
                                                     placeholder="click to select the date range">
                                                <span class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </span>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Shipping Cost</label>

                                        <div class="col-md-8">
                                            <input type="text" name="shiping_cost" id="shiping_cost" class="form-control m-b-5" placeholder="Shipping Cost" />

                                        </div>
                                    </div>


                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Attachment</label>

                                        <div class="col-md-8">
                                            <input type="file" name="attachment" id="attachment" class="form-control m-b-5" placeholder="Attachment" />

                                        </div>
                                    </div>


                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Payment Mode</label>

                                        <div class="col-md-8">
                                            <input type="text" name="payment_mode" id="payment_mode" class="form-control m-b-5" placeholder="Payment Mode" />

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Amount to be collected</label>

                                        <div class="col-md-8">
                                            <input type="text" name="amount_to_be_collected" id="amount_to_be_collected" class="form-control m-b-5"
                                                placeholder="Amount to be collected" />

                                        </div>
                                    </div>

                                    <div class="form-group row m-b-15">
                                        <label class="col-form-label col-md-4">Picked By</label>

                                        <div class="col-md-8">
                                            <input type="text" name="picked_by" id="picked_by" class="form-control m-b-5" placeholder="Picked By" />

                                        </div>
                                    </div>





                                </div>

                            </div>






                        </div>
                    </div>


                </div>






            </div>
        
        <div class="row justify-content-between">
            <div class="col-4">

            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block m-b-5  mt-5">Shipped</button>
            </div>
        </div>
        </form>

        <!-- begin invoice-content -->

        <!-- end invoice-content -->

    </div>
    <!-- end invoice -->
</div>
<!-- begin #footer -->
<!-- <div id="footer" class="footer">
			&copy; 2020  All Rights Reserved
		</div> -->
<!-- end #footer -->




<div class="modal fade" id="addItemImageByModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Image</h4>
                <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal"
                    aria-label="Close"><span aria-hidden="true">×</span></button>

            </div>
            <div class="modal-body">
                <form id="formAttribute" method="post">
                    <input type="hidden" name="_token" value="fwYYzcJbmfWWjjLZmZHMjJVT0e5fumCgpuq4APm3">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveAttribute" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()"
                    data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- begin scroll to top btn -->
<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade show"
    data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
<!-- end scroll to top btn -->