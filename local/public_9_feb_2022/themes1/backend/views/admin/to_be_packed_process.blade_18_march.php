<?php 

$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$users = @$customerdetail->business_state;
$city = get_cityNameByCityId(@$customerdetail->business_city);

$scanItemDetail = DB::table('to_be_packed_scan_items')
                                   
                                    ->where('order_number', @$itemOrders[0]->order_id)
                                    ->where('is_packed', 0)
                                   ->get();
?>
<style>
button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
</style>

<!-- end admin #sidebar -->

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
            
            
        {{@$customer_name}}
        </div>
        <!-- end invoice-company -->
        <!-- begin invoice-header -->
        <div class="row">

<div class="col-xl-4 col-md-4">
<div class="widget widget-stats bg-black-transparent-3">

<div class="stats-info">
<strong>Customer name: {{@$customer_name}}</strong><br />
                    Street Address: {{@$customerdetail->business_street_address}}<br />
                    Country: {{@$country->name}}, 
                    State: {{@$state->name}}, 
                    City: {{@$city->name}}<br/> 
                    Zip Code: {{@$customerdetail->business_postal_code}}<br />
                    Phone: {{@Auth::user()->mobile}}<br />
                    Emal id: {{@Auth::user()->email}}<br />
                    GST NO.: {{@$customerdetail->business_gst_number}}<br />

</div>

</div>
</div>


<div class="col-xl-8 col-md-8">


                <table class="table table-invoice">
                    <thead>
                        <tr>
                           
                            
                            <th class="field">No of Item</th>
                            <th class="field">Unpacked</th>
                            <th class="field">Inprocess</th>
                            <th class="field">Packes</th>
                        
                        </tr>
                    </thead>
                    <tbody class="">
                        <tr>
        
                            <td class="value"><a href="#allItemByOrderModel" id="{{$itemOrders[0]->order_id}}"  onclick="getAllItemByOrderOnModel(this.id);" data-toggle="modal">{{count($itemOrders)}}</a></td>
                            
                            <td class="value"><?php echo getUnPackedItemCountByOrderId($itemOrders[0]->order_id);?></td>
                            <td class="value"><?php echo getInprocessItemCountByOrderId($itemOrders[0]->order_id);?></td>
                            <td class="value"><?php echo getPackedItemCountByOrderId($itemOrders[0]->order_id);?></td>
                         	
                         
                        </tr>
                        
                      
                    </tbody>
                </table>
           

</div>





</div>

<div class="row">
	<div class="col-md-4">

<div class="form-group">

    <label class="col-form-label">Order No</label>
<input type="text" class="form-control m-b-5" value="{{$itemOrders[0]->order_id}}" placeholder="Order No" disabled="" readonly>

</div>


</div>
<div class="col-md-4">

<div class="form-group">

    <label class="col-form-label">Order Date</label>
<input type="text" class="form-control m-b-5" value="{{date('d-m-Y',strtotime($itemOrders[0]->created_at))}}" placeholder="12/02/2020" disabled="" readonly>

</div>

</div>
<div class="col-md-4">

<div class="form-group">

    <label class="col-form-label">Packing Date</label>
<input type="text" class="form-control m-b-5" placeholder="Packing date" value="{{date('d-m-Y', strtotime($itemOrders[0]->created_at))}}"  disabled="" readonly>

</div>

</div>


<!-- <div class="col-md-4">

<div class="form-group row m-b-15">
<label class="col-form-label col-md-3">Packing No</label>
<div class="col-md-7">
<input type="text" class="form-control m-b-5" placeholder="Packing No" value="{{$itemOrders[0]->packing_no}}" disabled="" readonly>

</div>
</div>

</div> -->


	</div>

        <!-- end invoice-header -->
        
        <!-- <div class="row row-space-10">
<div class="col-md-4">


<div class="form-group row m-b-15">
<label class="col-form-label col-md-3">Scan</label>
<div class="col-md-7">
<input type="email" class="form-control m-b-5" placeholder="Scan" readonly>

</div>
</div>


</div>

<div class="col-md-3">


<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Item Name</label>
<div class="col-md-7">
<input type="email" class="form-control m-b-5" placeholder="Item Name" readonly>

</div>
</div>


</div>

<div class="col-md-3">


<div class="form-group row m-b-15">
<label class="col-form-label col-md-5">Item Quantity</label>
<div class="col-md-7">
<input type="email" class="form-control m-b-5" placeholder="Item Quantity" readonly>

</div>
</div>


</div>

<div class="col-md-2">

<a href="javascript:;" class="btn btn-primary btn-block m-b-5">ADD</a>



</div>

</div> -->
        
        <div class="row">
       
       
<div class="col-xl-8 col-lg-6">
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
                    <tbody class="" >
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
                            <td class="value"><a href="javascript::void(0);" id="{{@$itemOrders[0]->order_id.'_'.$item->item_id.'_'.$item->customer_id.'_'.$item->id}}" onclick="deleteScandItem(this.id);" class="btn btn-danger" data-toggle="tooltip" data-container="body" data-title="Dalete"><i class="fa fa-trash" aria-hidden="true"></i> </a></td>
                        
                       </tr>
                    <?php } }?>

                                 
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
</div>     
     
     <div class="col-lg-4 ">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">

<div class="panel-heading">
<h4 class="panel-title">Enter Packing Details</h4>

</div>

<div  class="row">
		<div class="col-xl-12">
<div class="panel-body">

<form id="countTotalPackingDetailBoxForm" method="post">
<?php 
    $itemOrderPackingDetail = DB::table('item_order_packing_details')
    ->where('order_number', @$itemOrders[0]->order_id)
    ->where('customer_id', @$itemOrders[0]->customer_id)
    // ->where('packing_no', @$itemOrders[0]->packing_no)
    // ->where('item_id', @$itemOrders[0]->item_id)
    ->first(); 
?>
@csrf
<input type="hidden" class="form-control m-b-5"  name="order_number" value="{{@$itemOrders[0]->order_id}}"/>
<!-- <input type="hidden" class="form-control m-b-5"  name="order_item_id" value="2"/>
<input type="hidden" class="form-control m-b-5"  name="item_id" value="3"/> -->
<input type="hidden" class="form-control m-b-5"  name="customer_id" value="{{@$itemOrders[0]->customer_id}}"/>
<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Small Box</label>
<div class="col-md-8">
<input type="text" class="form-control m-b-5 countTotalPackingDetailBox"  name="small_box" id="small_box" value="{{@$itemOrderPackingDetail->small_box}}" placeholder="Small Box"/>
</div>
</div>
<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">
Medium Box</label>
<div class="col-md-8">
<input type="text" class="form-control m-b-5 countTotalPackingDetailBox" name="medium_box" id="medium_box" value="{{@$itemOrderPackingDetail->medium_box}}" placeholder="Medium Box" />
</div>
</div>

<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Large Box</label>

<div class="col-md-8">
<input type="text" class="form-control m-b-5 countTotalPackingDetailBox"  name="large_box" id="large_box" value="{{@$itemOrderPackingDetail->large_box}}" placeholder="Large Box" />

</div>
</div>

<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Bori</label>

<div class="col-md-8">
<input type="text" class="form-control m-b-5 countTotalPackingDetailBox" name="bori" id="bori" value="{{@$itemOrderPackingDetail->bori}}" placeholder="Bori" />

</div>
</div>

<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Other</label>

<div class="col-md-8">
<input type="text" class="form-control m-b-5 countTotalPackingDetailBox" name="other" id="other" value="{{@$itemOrderPackingDetail->other}}" placeholder="Other" />

</div>
</div>


<div class="form-group row m-b-15">
<label class="col-form-label col-md-4">Total</label>

<div class="col-md-8">
<input type="text" class="form-control m-b-5 total" name="total" id="total" value="{{@$itemOrderPackingDetail->total}}" placeholder="Total" disabled="" />
<input type="text" class="form-control m-b-5 total" name="total"  value="{{@$itemOrderPackingDetail->total}}" placeholder="Total" style="display:none"/>

</div>
</div>  


</form>
</div>

</div>






</div>
</div>

            
            </div>
            
            <div class="col-lg-2">
            <div class="panel panel-inverse" data-sortable-id="form-stuff-1">




</div>

            
            </div>
            
            
            
     
        </div>    
            
        <div class="row">
    <div class="col-6">
     <button type="button" onclick="printLableAndSaveBox();" class="btn btn-success btn-block m-b-5  mt-5">Print Lable </button>
    </div>

    <div class="col-6">
      <button class="btn btn-success btn-block m-b-5  mt-5" id="packedBtnProcess" onclick="moveToshipingBtn();" >Packed</button>
      <!-- <button class="btn btn-primary btn-block m-b-5  mt-5" id="packedBtnProcess" onclick="moveToshipingBtn();" {{(!empty($itemOrderPackingDetail->id)) ? '':'disabled'}} >Packed</button> -->
    </div>
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
	<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade show" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<!-- end scroll to top btn -->
	</div>