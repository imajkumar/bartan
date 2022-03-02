<?php

	//$customer = session()->get('customer'); 
	//pr(Auth::user());
	
	if(@Auth::user()->user_type == 0)
		{
			// if(Auth::user()->profile == 0){
			// 	\App\Http\Controllers\HomeController::dashboard();
			// 	//return redirect()->route('dashboard');
			// }
			$userType = 'Customer';

			@$customerdetail = get_custumer_by_user_id(Auth::user()->id);
			if(!empty($customerdetail->profile_pic) )
			{
			
			$profil_pic = asset('/'.ITEM_IMG_PATH.'/'.$customerdetail->profile_pic);
			}else{
				
				$profil_pic = BACKEND.'img/user/user-4.jpg';
			}


		}else{

			$userType = 'Admin';
			//$profile_pic = ' ';
			$profil_pic = BACKEND.'img/user/user-4.jpg';
		}
		
		
	
		
?>

<!-- begin custumer #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed m-t-0">

		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				
			<a href="{{url('/')}}" class="navbar-brand"><span class="navbar-logo">
				<img src="{{asset('assets/img/logo/logo.png')}}" alt=""></span> <b class="mr-1"></b> </a><br>
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
			
			
			<!-- end navbar-header --><!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				{{-- <li class="navbar-form">
					<form action="" method="POST" name="search_form">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter keyword" />
							<button type="submit" class="btn btn-search"><i class="ion-ios-search"></i></button>
						</div>
					</form>
				</li> --}}
				{{-- <li class="dropdown">
					<a href="#" data-toggle="dropdown" class="dropdown-toggle icon">
						<i class="ion-ios-notifications"></i>
						<span class="label">5</span>
					</a>
					<div class="dropdown-menu media-list dropdown-menu-right">
						<div class="dropdown-header">NOTIFICATIONS (5)</div>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-bug media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
								<div class="text-muted">3 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="../assets/img/user/user-1.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">John Smith</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted">25 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<img src="../assets/img/user/user-2.jpg" class="media-object" alt="" />
								<i class="fab fa-facebook-messenger text-blue media-object-icon"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading">Olivia</h6>
								<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
								<div class="text-muted">35 minutes ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-plus media-object bg-silver-darker"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New User Registered</h6>
								<div class="text-muted">1 hour ago</div>
							</div>
						</a>
						<a href="javascript:;" class="dropdown-item media">
							<div class="media-left">
								<i class="fa fa-envelope media-object bg-silver-darker"></i>
								<i class="fab fa-google text-warning media-object-icon f-s-14"></i>
							</div>
							<div class="media-body">
								<h6 class="media-heading"> New Email From John</h6>
								<div class="text-muted">2 hour ago</div>
							</div>
						</a>
						<div class="dropdown-footer text-center">
							<a href="javascript:;">View more</a>
						</div>
					</div>
				</li> --}}


				
				<?php 
						// $newOrderCount = DB::table('tbl_item_orders')->where('stage', 0)->count();
						// $getNewOrders = DB::table('tbl_item_orders')->where('stage', 0)
						// ->orderBy('id', 'DESC')
						// ->take(5)
						// ->get();

						@$itemOrdersForCount = DB::table('tbl_payment_status')
						->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
						->orderBy('tbl_payment_status.id', 'desc')
						->where('tbl_item_orders.stage', 0)
						->get();
						@$itemOrdersForCount = unique_multidim_array(json_decode(json_encode($itemOrdersForCount), true), 'item_order_id');
						@$newOrderCount = count($itemOrdersForCount);

						@$itemOrders = DB::table('tbl_payment_status')
						->rightjoin('tbl_item_orders', function ($itemJoin) {
                            $itemJoin->on('tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id');
                            // $itemJoin->limit(5);
                        })
						// ->rightjoin('tbl_item_orders', 'tbl_item_orders.order_id', '=', 'tbl_payment_status.item_order_id')
						->orderBy('tbl_payment_status.id', 'desc')
						//->limit(5)
						->where('tbl_item_orders.stage', 0)
						->get();
						//@$itemOrders = @$itemOrders->limit(5);
        				@$itemOrders = unique_multidim_array(json_decode(json_encode($itemOrders), true), 'item_order_id');
				
						//pr(@$itemOrders);


						$pendingCustomerRegisterCount = DB::table('tbl_customers')
						->where('status', 0)
						->where('deleted_at', 1)
						->count();
						$getPendingCustomerRegister = DB::table('tbl_customers')
						->where('status', 0)
						->where('deleted_at', 1)
						->orderBy('id', 'DESC')
						->take(5)
						->get();
					?>
					
				<li class="dropdown" id="notification" style="display:{{(@Auth::user()->user_type == 1)? 'block':'none' }}">
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
                                // $customerdetail = get_customer_and_address_by__user_id(@$getPendingCustomer->customer_id);
                                $customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);
                                //pr($customerdetail);
                                @$str = $customer_name;
                                @$words = explode(' ', @$str);
                                @$requireStr = @$words[0][0]. @$words[1][0];
                        
                        ?>
							<li>
								<a href="{{route('editCustomerLayout', $getPendingCustomer->id)}}" class="dropdown-item media">
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
							//$itemOrders = unique_multidim_array(json_decode(json_encode($getNewOrders), true), 'order_id');
                                $n=1;
							foreach($itemOrders as $getNewOrder)
                                { 
									if($n<=5){

									$getNewOrder= (object) $getNewOrder;
                                    // $customerdetail = get_custumer_by_user_id(@$getPendingCustomer->user_id);
                                    $customerdetail = get_customer_and_address_by__user_id(@$getNewOrder->customer_id);
                                    $customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);
                            
                                    $itemOrdersCount = DB::table('tbl_item_orders')
                                            ->where('order_id', $getNewOrder->order_id)
                                            ->count();
                            ?>
							<li>
								<a href="{{route('orderAdmin')}}" class="dropdown-item media">
									
									<div class="media-body">
										<h6 class="media-heading">{{@$customer_name}} ({{@$getNewOrder->order_id}})</i></h6>
										<div class="text-muted "> {{@$itemOrdersCount}} Item</div>
									</div>
								</a>
							</li>

							<?php } 
							$n++;}?>

						</ul>
					</div>
				</li>

				
				<li class="dropdown navbar-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="{{$profil_pic ?? ''}}" class="outputPic" alt="" /> 
						<span class="d-none d-md-inline">
							{{ ucfirst(@Auth::user()->name)}}
						</span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						{{-- <a href="javascript:;" class="dropdown-item">Edit Profile</a> --}}
						{{-- <a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>						                         --}}
                        
                        <div class="dropdown-divider"></div>
                        
						<a  href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" class="dropdown-item">Log Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>        
					
							<!-- <a  href="{{ route('customerLogout') }}" onclick="event.preventDefault();  document.getElementById('logout-form-customer').submit();" class="dropdown-item">Log Out</a>
                        <form id="logout-form-customer" action="{{ route('customerLogout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form> -->

						
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->