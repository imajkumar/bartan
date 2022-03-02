    <!-- BEGIN #checkout-cart -->
<style>
div#checkout-cart {
    margin-left: 220px;
    margin-top: 35px;
    /* color: white; */
}
/*.checkout-header {
    background-color: #222222;
}
.admin-order thead tr th {
	background-color: #e4e7e8;
    color: #222222;
}

.modal-backdrop {
	position: inherit;
	top: 0;
	left: 0;
	z-index: 1040;
	width: 100vw;
	height: 100vh;
	background-color: #000;
}*/
   
</style>
<div class="section-container" id="checkout-cart">
			<!-- BEGIN container -->
			<div class="container">
				<!-- BEGIN checkout -->
				<div class="checkout">
					{{-- <form action="checkout_info.html" method="POST" name="form_checkout"> --}}
                        <!-- BEGIN checkout-header -->
                       
						<div class="checkout-header">
							<!-- BEGIN row -->
							
							<div class="panel panel-inverse panel-with-tabs">
						<!-- begin panel-heading -->
						<div class="panel-heading p-0">
							<!-- begin nav-tabs -->
							<div class="tab-overflow">
								<ul class="nav nav-tabs nav-tabs-inverse">
									<!-- <li class="nav-item prev-button"><a href="javascript:;" data-click="prev-tab" class="nav-link text-primary" ><i class="fa fa-arrow-left"></i></a></li> -->
									<li class="nav-item"><a href="#nav-tab-1" data-toggle="tab" class="nav-link getAdminOrder active" id="10">All</a></li>

									<li class="nav-item"><a href="#nav-tab-2" data-toggle="tab" class="nav-link getAdminOrder" id="0">Pending order</a></li>

									<!-- <li class="nav-item"><a href="#nav-tab-3" data-toggle="tab" class="nav-link getAdminOrder" id="1"> Processed order</a></li> -->
									<li class="nav-item"><a href="#nav-tab-4" data-toggle="tab" class="nav-link getAdminOrder" id="2">Packed order</a></li>
									<li class="nav-item"><a href="#nav-tab-5" data-toggle="tab" class="nav-link getAdminOrder" id="3">Shipping order</a></li>
									<li class="nav-item"><a href="#nav-tab-6" data-toggle="tab" class="nav-link getAdminOrder" id="4">Delivered</a></li>
									<li class="nav-item"><a href="#nav-tab-7" data-toggle="tab" class="nav-link getAdminOrder" id="7">Returned</a></li>
									<li class="nav-item"><a href="#nav-tab-8" data-toggle="tab" class="nav-link getAdminOrder" id="5">Hold</a></li>
									<li class="nav-item"><a href="#nav-tab-9" data-toggle="tab" class="nav-link getAdminOrder" id="6">Cancelled</a></li>
								
								</ul>
							</div>
							<!-- end nav-tabs -->
						<!-- 	<div class="panel-heading-btn mr-2 ml-2 d-flex">
								<a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-secondary" data-click="panel-expand"><i class="fa fa-expand"></i></a>
							</div> -->
						</div>
						<!-- end panel-heading -->
						<!-- begin tab-content -->
						<div class="panel-body tab-content">
							<!-- begin tab-pane -->
							<div class="table-responsive2">
							<!-- <table id="data-table-default" class="table table-striped table-bordered table-td-valign-middle"> -->
									<table class="table table-payment-summary admin-order">
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Order date</th>
                                                <th>Shop name</th>
        										
                                                <th>No.of items</th>
                                                <th>Total Amount</th>
                                                
                                                <th>Stage</th>
                                                <th>Payment status</th>
												<th>Order through</th>
                                       			<th>Salesman Name</th>
                                                <th >Action</th>
                                               
                                                
                                            </tr>
                                        </thead>
										<tbody id="appendOrderItemAdmin">
                                            <?php
                                    //pr($itemOrders);
                                            foreach($itemOrders as $itemOrder){
												$itemOrder = (object) $itemOrder;
                                             //if(count($itemOrders)>0){
												$itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();

												$paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                               
											@$customerdetail = get_customer_and_address_by__user_id(@$itemOrder->customer_id);
                                            ?>
											<tr>
												<td class="value">{{$itemOrder->order_id}}</td>
                                                <td class="value">
												{{date("d-m-Y h:i a", strtoTime(@$paymntStaus->created_at))}}
													<!-- {{date("d-m-Y", strtoTime(@$paymntStaus->created_at))}} -->
												</td>
                                                
												<td>{{@$customerdetail->store_name}}</td>

                                                <td class="value">{{$itemOrdersCount}}</td>
                                                <!-- <td class="value">{{$itemOrder->total_amount}}</td> -->
                                                <td class="value">{{$itemOrder->grand_total}}</td>
                                        
                                       
                                        <td class="value">
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md btn-success">Processed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md btn-danger">Pending</span>

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
                                        
                                        <td class="value">
                                            <?php
                                             
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md btn-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md btn-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
										<td>
                                        <?php 
                                            if(!empty(@$paymntStaus->saler_id)){
                                                echo "By sales person";
                                            }else{
                                                echo "By Customer";
                                            }
                                            
                                        ?>
                                        </td>

                                        <td>
                                        <?php 
                                            if(!empty(@$paymntStaus->saler_id)){
                                                @$customer = DB::table('users')->where('id', @$paymntStaus->saler_id)->first();
                                                echo ucfirst(@$customer->name);
                                            }else{
                                                @$customer = DB::table('users')->where('id', @$itemOrder->customer_id)->first();
                                                echo ucfirst(@$customer->name);
                                            }
                                        ?>
                                        </td>
                                        
										<td>
										<a href="#updateOrderStage" id="{{$itemOrder->order_id.'_'.$itemOrder->stage}}" onclick="updateOrderStage(this.id);" class="updateOrderStage btn btn-default" data-toggle="modal" data-container="body" data-title="Edit"><i class="far fa-lg fa-fw fa-edit"></i></a>
											<a href="{{route('viewOrderAdmin', $itemOrder->order_id)}}" class="btn btn-success" data-toggle="tooltip" data-container="body" data-title="View"><i class="fas fa-lg fa-fw fa-eye"></i></a>
									   </td>
												
											</tr>
											
											
										<?php }?>
											
										</tbody>
									</table>
								</div>



							
							<!-- end tab-pane -->
						</div>
						<!-- end tab-content -->
					</div>
							<!-- END row -->
						</div>
						<!-- END checkout-header -->
						<!-- BEGIN checkout-body -->
					
						<!-- END checkout-body -->
						<!-- BEGIN checkout-footer -->
						<div class="checkout-footer text-center">
							{{-- <button type="submit" class="btn btn-white btn-theme">MANAGE ORDERS</button> --}}
						</div>
						<!-- END checkout-footer -->
					{{-- </form> --}}
				</div>
				<!-- END checkout -->
			</div>
			<!-- END container -->
		</div>
		<!-- END #checkout-cart -->
		
	
		
		
		
	</div>
	<!-- END #page-container -->
	

