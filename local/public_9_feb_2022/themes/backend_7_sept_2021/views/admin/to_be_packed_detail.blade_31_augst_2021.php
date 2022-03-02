<?php 

$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$users = @$customerdetail->business_state;
$city = get_cityNameByCityId(@$customerdetail->business_city);

?>

<!-- <div id="page-container" class="fade page-sidebar-fixed page-header-fixed show has-scroll"> -->
<div>
    <div id="content" class="content">
        <!-- begin breadcrumb -->
       <!--  <ol class="breadcrumb hidden-print float-xl-right">
            <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
            <li class="breadcrumb-item active">Order</li>
        </ol> -->
        <!-- end breadcrumb -->
        <!-- begin page-header -->
        <!-- <h1 class="page-header hidden-print">Order detail <small>About order</small></h1> -->
        <!-- end page-header -->
        <!-- begin invoice -->
        <div class="invoice">
            <!-- begin invoice-company -->
            <div class="invoice-company">


                {{$customer_name}}

             <div class="help-tip">
    <p>
                            <strong>Customer Name:</strong> {{@$customer_name}}<br />
                           <strong> Street Address: </strong>{{@$customerdetail->business_street_address}}<br />
                         <strong>   Country:</strong> {{@$country->name}},<br />
                          <strong>  State:</strong> {{@$state->name}},<br />
                           <strong> City:</strong> {{@$city->name}}<br />
                          <strong>  Zip Code:</strong> {{@$customerdetail->business_postal_code}}<br />
                          <strong>  Phone:</strong> {{@Auth::user()->mobile}}<br />
                           <strong> Emal id:</strong> {{@Auth::user()->email}}<br />
                           <strong> GST NO.:</strong> {{@$customerdetail->business_gst_number}}<br />

                      </p>
 
</div>

            </div>
            <!-- end invoice-company -->
            <!-- begin invoice-header -->
            <div class="row m-b-0">

               <!--  <div class="col-xl-4 col-md-4">
                    <div class="widget widget-stats bg-black-transparent-3">

                        <div class="stats-info">
                            <strong>Customer Name:</strong> {{@$customer_name}}<br />
                           <strong> Street Address: </strong>{{@$customerdetail->business_street_address}}<br />
                         <strong>   Country:</strong> {{@$country->name}},<br />
                          <strong>  State:</strong> {{@$state->name}},<br />
                           <strong> City:</strong> {{@$city->name}}<br />
                          <strong>  Zip Code:</strong> {{@$customerdetail->business_postal_code}}<br />
                          <strong>  Phone:</strong> {{@Auth::user()->mobile}}<br />
                           <strong> Emal id:</strong> {{@Auth::user()->email}}<br />
                           <strong> GST NO.:</strong> {{@$customerdetail->business_gst_number}}<br />

                        </div>

                    </div>
                </div> -->


                <div class="col-xl-12 col-md-8">


                    <table class="table table-invoice">
                        <thead>
                            <tr>


                                <th class="field">No of Item</th>
                                <th class="field">Unpacked</th>
                                <th class="field">Inprocess</th>
                                <th class="field">Packed</th>

                            </tr>
                        </thead>
                        <tbody class="">
                            <tr>

                                <td class="value"><a href="#allItemByOrderModel" id="{{$itemOrders[0]->order_id}}"
                                        onclick="getAllItemByOrderOnModel(this.id);"
                                        data-toggle="modal">{{count($itemOrders)}}</a></td>

                                <td class="value"><?php echo getUnPackedItemCountByOrderId($itemOrders[0]->order_id);?>
                                </td>
                                <td class="value"><?php echo getInprocessItemCountByOrderId($itemOrders[0]->order_id);?>
                                </td>
                                <td class="value"><?php echo getPackedItemCountByOrderId($itemOrders[0]->order_id);?>
                                </td>


                            </tr>


                        </tbody>
                    </table>


                     <form id="barcodeScanForm" method="post" action="{{route('barcodeScanItemSave')}}">
                @csrf
                <input type="hidden" name="customer_id" id="customer_id" value="{{@$itemOrders[0]->customer_id}}" />
                <input type="hidden" name="order_number" id="order_number" value="{{$itemOrders[0]->order_id}}" />
                <input type="hidden" name="itemOrderId" id="itemOrderId" />
                <input type="hidden" name="unit" id="itemUnit" />
                <input type="hidden" name="itemId" id="itemId" />
                <div class="row">

                    <div class="col-md-3">


                        <div class="form-group">
                            
                          
                                <label class="col-form-label">Barcode</label>
                                <input type="text" class="form-control m-b-5" name="barcode" id="barcode"
                                    placeholder="Barcode">

                            </div>
                    
                    </div>

                    <div class="col-md-3">


                        <div class="form-group">
                         
                                <label class="col-form-label">Item Name</label>
                                <input type="text" class="form-control m-b-5" name="item_name" id="item_name"
                                    placeholder="Item Name" readonly>

                            </div>
                     
                    </div>

                    <div class="col-md-3">


                        <div class="form-group">
                        
                                 <label class="col-form-label">Item Quantity</label>
                                <input type="text" class="form-control m-b-5" name="qty" id="qty"
                                    placeholder="Item Quantity">

                            </div>
                      
                    </div>

                    <div class="col-md-3">
 <div class="form-group m-t-30">
    
                        <button type="submit" class="btn btn-success add-btn">ADD</button>
                        </div>



                    </div>

                </div>
            </form>

             <div class="invoice-content">
                        <!-- begin table-responsive -->
                        <div class="">
                            <table class="table table-invoice my-custom-scrollbar table-wrapper-scroll-y">
                                <thead>
                                    <tr>


                                        <th class="field">Item</th>
                                        <th class="field">Item Name</th>
                                        <th class="field">Quantity</th>
                                        <th class="field">Unit</th>
                                        <th class="field" width="100px;">Action </th>



                                    </tr>
                                </thead>
                                <tbody class="">
                                    <?php 
                    $toBePackedScanItems = DB::table('to_be_packed_scan_items')->where('order_number', @$itemOrders[0]->order_id)
                    ->where('customer_id', @$itemOrders[0]->customer_id)->get();
                    foreach($toBePackedScanItems as $item){
                        if($item->is_packed !=1){
                        $itemDetail = get_item_by_item_id($item->item_id);

                        $itemImages = get_item_default_img_item_id($item->item_id);

                            if ($itemImages) {

                                $itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
                            } else {

                                $itemImg = FRONT . 'img/product/product-iphone.png';
                            }
                    ?>
                                    <tr>

                                        <td class="value"><img src="{{$itemImg}}" width="50px" height="50px"></td>

                                        <td class="value">{{@$itemDetail->item_name}}</td>
                                        <td class="value">{{@$item->quantity}}</td>
                                        <td class="value">{{@$item->unit}}</td>
                                        <td class="value"><a href="javascript::void(0);"
                                                id="{{@$itemOrders[0]->order_id.'_'.$item->item_id.'_'.$item->customer_id.'_'.$item->id}}"
                                                onclick="deleteScandItem(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Dalete"> <i class="fa fa-trash" aria-hidden="true"></i>
</a>
                                        </td>

                                    </tr>
                                    <?php }}?>





                                    <tr>
                                        <td class="cart-summary" colspan="12">

                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>



                        <!-- end table-responsive -->
                        <!-- begin invoice-price -->
                        <!--  <div class="invoice-price">
               
                <div class="invoice-price-right">
                    <small>TOTAL</small> <span class="f-w-600">₹</span>
                </div>
            </div> -->

                    </div>

                      <div class="text-center">
                        <a href="#" class="btn btn-success add-btn"
                            id="{{@$itemOrders[0]->order_id.'_'.@$itemOrders[0]->customer_id}}"
                            onclick="toBePackedClickBtnProcess(this.id);">Process</a>
                    </div>


                </div>





            </div>
            <!-- end invoice-header -->
            <!-- <div class="row row-space-10">
	<div class="col-md-4">

<div class="form-group row m-b-15">
<label class="col-form-label col-md-3">Order No</label>
<div class="col-md-7">
<input type="text" class="form-control m-b-5" placeholder="21" disabled="" readonly>

</div>
</div>

</div>
<div class="col-md-4">

<div class="form-group row m-b-15">
<label class="col-form-label col-md-3">Order Date</label>
<div class="col-md-7">
<input type="text" class="form-control m-b-5" placeholder="12/02/2020" disabled="" readonly>

</div>
</div>

</div>




	</div> -->
           
            <div class="row">


                <div class="col-xl-12 col-lg-12">
                   
                </div>





            </div>

            <div class="row">
                <div class="col-4">
                  

                </div>
                <!--  <div class="col-4">
      <a href="javascript:;" class="btn btn-primary btn-block m-b-5  mt-5">Move to Shipping</a>
    </div> -->
            </div>

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
    <div class="modal  popdgn" id="allItemByOrderModel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Order Details</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table table-invoice">
                                    <thead>
                                        <tr>


                                            <th class="field">Item</th>
                                            <th class="field">Item Name</th>
                                            <th class="field">Quantity</th>
                                            <th class="field">Unit</th>



                                            <th class="field">Status</th>

                                        </tr>
                                    </thead>
                                    <tbody id="allItemByOrderOnModelAppend"></tbody>
                                </table>
                            </div>
                        </div>
                        <!---->

                    </div>




                </div>
            </div>
        </div>
    </div>




    <!-- begin scroll to top btn -->
    <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade show"
        data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
    <!-- end scroll to top btn -->
</div>