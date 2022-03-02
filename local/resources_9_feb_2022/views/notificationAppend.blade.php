<!-- <li class="dropdown"> -->
					<a href="#" data-toggle="dropdown" class="dropdown-toggle icon">
						<i class="ion-ios-notifications"></i>
						<span class="label">{{@$newOrderCount + @$pendingCustomerRegisterCount}}</span>
					</a>
					<div class="dropdown-menu media-list dropdown-menu-right">
						<div class="dropdown-header">New Customer ({{@$pendingCustomerRegisterCount}})</div>

						<ul class="list-unstyled ntdgn ntdgnscrl">
						<?php
                            foreach($getPendingCustomerRegister as $getPendingCustomer)
                            {
                                $customerdetail = get_custumer_by_user_id(@$getPendingCustomer->user_id);
                                //$customerdetail = get_customer_and_address_by__user_id(@$getPendingCustomer->customer_id);
                                $customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);
                                //pr($customerdetail);
                                @$str = $customer_name;
                                @$words = explode(' ', @$str);
                                @$requireStr = @$words[0][0]. @$words[1][0];
                        
                        ?>
							<li>
								<a href="{{url('/edit-customer/'.$getPendingCustomer->id)}}" class="dropdown-item media">
									<div class="media-left">
										{{@$requireStr}}
									</div>
									<div class="media-body">
										<h6 class="media-heading">{{@$customer_name}}	</i></h6>
										<div class="text-muted rd-clr">Pending	</div>
									</div>
								</a>
							</li>
                            <?php }?>

							
						</ul>

						<div class="dropdown-header">New Orders ({{@$newOrderCount}})</div>
						<ul class="list-unstyled ntdgn ntdgnscrl">
                            <?php
                                foreach($getNewOrders as $getNewOrder)
                                {
                                    $customerdetail = get_custumer_by_user_id(@$getPendingCustomer->user_id);
                                    //$customerdetail = get_customer_and_address_by__user_id(@$getNewOrder->customer_id);
                                    $customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);
                            
                                    $itemOrdersCount = DB::table('tbl_item_orders')
                                            ->where('order_id', $getNewOrder->order_id)
                                            ->count();
                            ?>
							<li>
								<a href="{{url('/orders')}}" class="dropdown-item media">
									
									<div class="media-body">
										<h6 class="media-heading">{{@$customer_name}} ({{@$getNewOrder->order_id}})</i></h6>
										<div class="text-muted "> {{@$itemOrdersCount}} Item</div>
									</div>
								</a>
							</li>

							<?php }?>

						</ul>
					</div>
				<!-- </li> -->