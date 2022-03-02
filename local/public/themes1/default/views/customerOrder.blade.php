    <!-- BEGIN #checkout-cart -->
  
	<div class="section-container" id="checkout-cart">
			<!-- BEGIN container -->
			<div class="container">
				<!-- BEGIN checkout -->
				<div class="checkout">
					{{-- <form action="checkout_info.html" method="POST" name="form_checkout"> --}}
                        <!-- BEGIN checkout-header -->
                       
						<div class="checkout-header">
							<!-- BEGIN row -->
							<div class="row">
								<!-- BEGIN col-3 -->
								<div class="col-lg-2">
									<div class="step active">
										<a href="javascript:void();"  class="getCustomerOrder" id="10">
											
											<div class="info">
												<div class="title">All</div>
												{{-- <div class="desc">Lorem ipsum dolor sit amet.</div> --}}
											</div>
										</a>
									</div>
								</div>
								<!-- END col-3 -->
								<!-- BEGIN col-3 -->
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="0">
											
											<div class="info">
												<div class="title">Pending order</div>
												{{-- <div class="desc">Vivamus eleifend euismod.</div> --}}
											</div>
										</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="1">
											
											<div class="info">
												<div class="title"> Processed order</div>
												{{-- <div class="desc">Vivamus eleifend euismod.</div> --}}
											</div>
										</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="2">
											
											<div class="info">
												<div class="title">Packed order</div>
												{{-- <div class="desc">Vivamus eleifend euismod.</div> --}}
											</div>
										</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="3">
											
											<div class="info">
												<div class="title">Shipping order</div>
												{{-- <div class="desc">Vivamus eleifend euismod.</div> --}}
											</div>
										</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="4">
											
											<div class="info">
												<div class="title">Delivered</div>
												{{-- <div class="desc">Aenean ut pretium ipsum. </div> --}}
											</div>
										</a>
									</div>
								</div>
								<!-- END col-3 -->
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="7">
											
											<div class="info">
												<div class="title">Returned</div>
												{{-- <div class="desc">Aenean ut pretium ipsum. </div> --}}
											</div>
										</a>
									</div>
								</div>
								<!-- BEGIN col-3 -->
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="6">
											
											<div class="info">
												<div class="title">Cancelled</div>
												{{-- <div class="desc">Aenean ut pretium ipsum. </div> --}}
											</div>
										</a>
									</div>
								</div>
								<div class="col-lg-2">
									<div class="step">
										<a href="javascript:void();" class="getCustomerOrder" id="5">
											
											<div class="info">
												<div class="title">Hold</div>
												{{-- <div class="desc">Aenean ut pretium ipsum. </div> --}}
											</div>
										</a>
									</div>
								</div>
								
								
								<!-- END col-3 -->
								<!-- BEGIN col-3 -->
								
								<!-- END col-3 -->
							</div>
							<!-- END row -->
						</div>
						<!-- END checkout-header -->
						<!-- BEGIN checkout-body -->
						<div class="checkout-body">
                            <!-- BEGIN checkout-message -->
                            
							<div class="checkout-message">
								
								<div class="table-responsive2">
									<table class="table table-payment-summary">
                                        <thead>
                                            <tr>
                                                <th >Order Id</th>
                                                <th >Order date</th>
        										
                                                <th >No.of items</th>
                                                <th >Total Amount</th>
                                                
                                                <th >Stage</th>
                                                <th >Payment status</th>
                                                <th >Action</th>
                                               
                                                
                                            </tr>
                                        </thead>
										<tbody id="appendOrderItemCustomer">
                                            <?php
                                    //pr($itemOrders);
                                            foreach($itemOrders as $itemOrder){
												$itemOrder = (object) $itemOrder;
                                             //if(count($itemOrders)>0){
												$itemOrdersCount = DB::table('tbl_item_orders')->where('order_id', $itemOrder->order_id)->count();

												$paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrder->order_id)
                                            ->first();
                                               
                                              
                                            ?>
											<tr>
												<td class="value">{{$itemOrder->order_id}}</td>
                                                <td class="value">
													{{date("d-m-Y", strtoTime(@$paymntStaus->created_at))}}
												</td>
                                                
                                                <td class="value">{{$itemOrdersCount}}</td>
                                                <td class="value">{{$itemOrder->total_amount}}</td>
                                        
                                       
                                        <td class="value">
                                            @if($itemOrder->stage == 1)
                                                <span class="badge badge-md badge-success">Processed</span>

                                            @elseif($itemOrder->stage == 0)
                                                <span class="badge badge-md badge-danger">Pending</span>

                                            @elseif($itemOrder->stage == 2)
                                                <span class="badge badge-md badge-danger">Packaging</span>

                                           
                                            @elseif($itemOrder->stage == 3)
                                                <span class="badge badge-md badge-danger">Shipping</span>

                                            @elseif($itemOrder->stage == 4)
                                                <span class="badge badge-md badge-danger">Delivered</span>
                                                
                                            @elseif($itemOrder->stage == 5)
                                                <span class="badge badge-md badge-danger">Hold</span>
                                                
                                            @elseif($itemOrder->stage == 6)
                                                <span class="badge badge-md badge-danger">Cancel</span>
    
                                            @else
                                                <span class="badge badge-md badge-danger">Return</span>
                                           
                                           
                                          
                                            @endif
                                        </td>
                                        
                                        <td class="value">
                                            <?php
                                             
                                            ?>
 
                                            @if(@$paymntStaus->status == 1)
                                                 <span class="badge badge-md badge-success">Success</span>
 
                                             @elseif(@$paymntStaus->status == 0)
                                                 <span class="badge badge-md badge-danger">Pending</span>
 
                                             
                                             @endif
                                           
                                        </td>
                                        
										<td>
											<a href="{{route('viewOrderCustumerFront', $itemOrder->order_id)}}" class="btn btn-primary"><i class="fas fa-lg fa-fw m-r-10 fa-eye"></i>View</a>
									   </td>
												
											</tr>
											
											
										<?php }?>
											
										</tbody>
									</table>
								</div>
								{{-- <p class="text-silver-darker text-center m-b-0">Should you require any assistance, you can get in touch with Support Team at (123) 456-7890</p> --}}
							</div>
							<!-- END checkout-message -->
						</div>
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
	

