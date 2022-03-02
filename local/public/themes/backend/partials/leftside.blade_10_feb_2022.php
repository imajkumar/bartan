
<?php 

	$route_name='';
	$route_arr = explode(url('/') . "/", url()->current());
	if (array_key_exists(1, $route_arr)) {
		$route_name= $route_arr[1];
	}

	// $customer = session()->get('customer'); 
	
	if(@Auth::user()->user_type == 0){
		@$customerdetail = get_custumer_by_user_id(Auth::user()->id);
		
		if(!empty($customerdetail->profile_pic) )
		{
			
			$profil_pic = asset('/'.ITEM_IMG_PATH.'/'.$customerdetail->profile_pic);
		}else{
			
			$profil_pic = BACKEND.'img/user/user-4.jpg';
		}
?>
<style>
	.sidebar .nav>li.nav-profile .image {
		width: 100px;
		height: auto;
		margin: 20px;
		overflow: hidden;
		position: relative;
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		display: -webkit-box;
		display: -ms-flexbox;
		/* display: flex; */
		-ms-flex-align: center;
		align-items: center;
		-webkit-border-radius: 30px;
		border-radius: 50px;
	}	
	.sidebar .nav>li.nav-profile>a {
		/* margin: -20px; */
		padding-left: 50px;
		display: block;
		color: #fff;
		font-weight: 600;
	}

	
</style>
<!-- begin customer #sidebar -->
<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<a href="javascript:;" data-toggle="nav-profile">
							<div class="cover with-shadow"></div>
							<div class="image" id="pic">
								<img src="{{$profil_pic}}" class="outputPic output" alt="" />
								
								<div class="p-image">
                              <i class="fa fa-camera upload-button"></i>
                              <!-- <input class="file-upload output" type="file" accept="image/*" /> -->
                               </div>
							</div>
							 
						</a>
						<form method="post" id="saveProfilePic" enctype="multipart/form-data">
							@csrf
							<input type="file" name="customer_pic" id="customerPic" accept="image/*" onchange="loadFile(event)" hidden/>
							
						</form>
					</li>

					
					
				</ul>
				<!-- end sidebar user -->
				<!-- begin sidebar nav -->
				<ul class="nav">
					
					
					
					

		{{-- Start code for menu show when pfofile is completed --}}
					<?php 
					
						if(@Auth::user()->profile == 1 && $customerdetail->deleted_at == 1)
						{

					?>
					<li class="{{($route_name == 'customer-profile') ? 'active':'has-sub'}}">
						<a href="{{route('customerProfile')}}">
							
							<i class="icon-user"></i>
							<span>MY PROFILE </span>
						</a>
						
					</li>
					<li class="{{($route_name =='my-order' || $route_name =='my-confirm-order'
						|| $route_name =='my-delivered-order'
						|| $route_name =='my-hold-order'
				) ? 'expand '.$subMenuMyOrder=1:'has-sub '.$subMenuMyOrder=0}}">
				
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="icon-graph"></i>
							<span>MY ORDERS </span>
						</a>
						<ul class="sub-menu" style="display:{{($subMenuMyOrder == 1
				) ? 'block':'none'}}">
							
							<li class="{{($route_name == 'my-order') ? 'active':''}}"><a href="{{route('myOrderList')}}"> My Orders</a></li>
							
							<li class="{{($route_name == 'my-confirm-order') ? 'active':''}}"><a href="{{route('myConfirmOrder')}}">Processed</a></li>
							<!-- <li><a href="{{route('myPacked')}}">Packed</a></li>
							<li><a href="{{route('myShipping')}}">Shipping</a></li> -->
							<li class="{{($route_name == 'my-delivered-order') ? 'active':''}}"><a href="{{route('myDeliveredOrder')}}"> Delivered</a></li>
							<li class="{{($route_name == 'my-cancel-order') ? 'active':''}}"><a href="{{route('myCancelOrder')}}"> Cancelled</a></li>
							<li class="{{($route_name == 'my-hold-order') ? 'active':''}}"><a href="{{route('myHoldOrder')}}"> Hold</a></li>
							
							
						</ul>
					</li>
					<li class="{{($route_name =='my-pending-order' || $route_name =='my-cancel-order'
						|| $route_name =='my-return-order') ? 'expand '.$subMenuMyReturn=1:'has-sub '.$subMenuMyReturn=0}}">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="icon-graph"></i>
							<span>MY RETURN</span>
						</a>
						<ul class="sub-menu" style="display:{{($subMenuMyReturn == 1
				) ? 'block':'none'}}">
							
							<li class="{{($route_name == 'my-pending-order') ? 'active':''}}"><a href="{{route('myPendingOrder')}}"> Pending</a></li>
							<!-- <li class="{{($route_name == 'my-cancel-order') ? 'active':''}}"><a href="{{route('myCancelOrder')}}"> Cancelled</a></li> -->
							<li class="{{($route_name == 'my-return-order') ? 'active':''}}"><a href="{{route('myReturnOrder')}}"> Returned</a></li>
							
							
						</ul>
					</li>

					<li class="{{($route_name == 'terms-of-use') ? 'active':'has-sub'}}">
						<a href="{{route('termsOfUse')}}" target="_blank">
							
							<i class="icon-graph"></i>
							<span>TERMS USE</span>
						</a>
						
					</li>
					<li class="{{($route_name == 'privacy-policy') ? 'active':'has-sub'}}">
						<a href="{{route('privacyPolicy')}}" target="_blank">
							
							<i class="icon-graph"></i>
							<span>POLICIES</span>
						</a>
						
					</li>
					<li class="{{($route_name == 'support') ? 'active':'has-sub'}}">
						<a href="{{route('support')}}" target="_blank">
							
							<i class="icon-graph"></i>
							<span>SUPPORT & HELP</span>
						</a>
						
					</li>
					<li class="{{($route_name == 'customerCartList') ? 'active':'has-sub'}}">
						<a href="{{route('customerCartList')}}" target="_blank">
							
							<i class="icon-graph"></i>
							<span>CUSTOMER CART</span>
						</a>
						
					</li>

					{{-- <li class="has-sub">
						<a href="{{route('addresses')}}">
							
							<i class="fas fa-lg fa-fw m-r-10 fa-address-book"></i>
							<span>ADDRESSES </span>
						</a>
						
					</li> --}}
					

					
					
					
					

					<?php

						}
					?>
		{{-- Start code for menu show when pfofile is completed --}}

					<!-- begin sidebar minify button -->
					<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-back"></i> <span>Collapse</span></a></li>
					<!-- end sidebar minify button -->
				</ul>
				<!-- end sidebar nav -->
			</div>
			<!-- end sidebar scrollbar -->
		</div>
		<div class="sidebar-bg"></div>
		<!-- end customer #sidebar -->


<?php } else{ ?>


<!--------------------------- begin Admin #sidebar --------------------------------------->


<div id="sidebar" class="sidebar">
	<!-- begin sidebar scrollbar -->
	<div data-scrollbar="true" data-height="100%">
		<!-- begin sidebar user -->
		<ul class="nav">
			<li class="nav-profile">
				<a href="javascript:;" data-toggle="nav-profile">
					<div class="cover with-shadow"></div>
					<div class="image">
						<img src="" alt="" />
					</div>
					
				</a>
			</li>
			<!-- <li>
				<ul class="nav nav-profile">
					<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
					
				</ul>
			</li> -->
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			<?php
		if(@Auth::user()->user_type == 1){
				?>
			<li class="{{($route_name == 'dashboard') ? 'active':''}}">
					<a href="{{route('dashboard')}}">
						{{-- <b class="caret"></b> --}}
						<i class="fa fa-th-large"></i>
						<span>Dashboard </span>
					</a>
					{{-- <ul class="sub-menu">
						
						<li><a href="javascript:;"> Orders</a></li>
						{{-- <li><a href="javascript:;"> Shipments</a></li>
						<li><a href="javascript:;"> Invoices</a></li>
						<li><a href="javascript:;"> Refunds</a></li> --}}
						{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li>
						<li><a href="{{route('brandListLayout')}}">Brands</a></li>
						 
					</ul> --}}
				</li>

				<?php 
				}
				 if (Auth::user()->hasPermissionTo('groupView')) {
					?>
				<li class="{{($route_name == 'master-settings') ? 'active':'has-sub'}}">
					<a href="{{route('masterSettingsLayout')}}">
						
					<i class="fa fa-users"></i>
						<span>Group </span>
					</a>
				
				
				<!-- <li><a href="{{route('masterSettingsLayout')}}">Group</a></li> -->
				</li>
				<?php
				} 

				?>
				<?php 
				 if (Auth::user()->hasPermissionTo('attributeView')) {
					?>
					<li class="{{($route_name == 'attributesLayout') ? 'active':'has-sub'}}">
					<a href="{{route('attributesLayout')}}">
						
						<i class="fa fa-cogs"></i>
						<span>Attribute </span>
					</a>
				</li>
					<?php
				} 

				?>

				
				<?php 
				 if (Auth::user()->hasPermissionTo('ItemCategoryView')) {
					?>
				<li class="{{($route_name == 'itemCategories') ? 'active':'has-sub'}}">
					<a href="{{route('itemCategories')}}">
						
						<i class="fa fa-bars"></i>
						<span>Item Category </span>
					</a>
				</li>
				<?php
				} 

				?>
				<?php 
				 if (Auth::user()->hasPermissionTo('ViewCustomerCategory')) {
					?>
				<li class="{{($route_name == 'customerClass') ? 'active':'has-sub'}}">
					<a href="{{route('customerClass')}}">
						
						<i class="fa fa-user"></i>
						<span>Customer category </span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewCustomerClass')) {
					?>
				<li class="{{($route_name == 'customerCategories') ? 'active':'has-sub'}}">
					<a href="{{route('customerCategories')}}">
						
						<i class="fa fa-cogs"></i>
						<span>Customer class </span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewDiscounts')) {
					?>
				<li class="{{($route_name == 'discountLayout') ? 'active':'has-sub'}}">
					<a href="{{route('discountLayout')}}">
						
						<i class="fa fa-gift"></i>
						<span>Discounts </span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewHSNSetup')) {
					?>
				<li class="{{($route_name == 'hsnMaster') ? 'active':'has-sub'}}">
					<a href="{{route('hsnMaster')}}">
						
						<i class="fa fa-wrench"></i>
						<span>HSN Setup </span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewBrand')) {
					?>
				<li class="{{($route_name == 'brands') ? 'active':'has-sub'}}">
					<a href="{{route('brandListLayout')}}">
						
						<i class="fa fa-tag"></i>
						<span>Brand </span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewProduct')) {
					?>
				<li class="{{($route_name == 'items') ? 'active':'has-sub'}}">
					<a href="{{route('itemListLayout')}}">
						
					<i class="icon-basket"></i>
						<span>Product </span>
					</a>
				</li>
				<?php
				} 
			if(@Auth::user()->user_type == 1 && Auth::user()->hasPermissionTo('ViewExportImport')){
				//if (Auth::user()->hasPermissionTo('ViewExportImport')) {
				
				?>

				
				<li class="{{($route_name == 'export') ? 'active':'has-sub'}}">
					<a href="{{route('export')}}">
						
					<i class="icon-basket"></i>
						<span>Export/Import </span>
					</a>
				</li>
				<?php }?>
				
			
				
			
			

			


			<?php 
				 if (Auth::user()->hasPermissionTo('ViewCustomers')) {
					?>
			<li class="{{($route_name == 'customers') ? 'expand':'has-sub'}}">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-user"></i>
					<span>Customer </span>
				</a>
				<ul class="sub-menu" style="display:{{($route_name == 'customers') ? 'block':'none'}}">
					
					<li class="{{($route_name == 'customers') ? 'active':''}}"><a href="{{route('customerListLayout')}}">Customers</a></li>
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li> --}}
					
				</ul>
			</li>
			<?php
				} 

				?>

			<?php 
				 if (Auth::user()->hasPermissionTo('ViewSales')) {
					?>
			<li class="{{($route_name =='sales-person' || $route_name =='admin-orders' || 
				$route_name =='orders'
				|| $route_name =='pending-order' ||
				 $route_name =='to-be-packed' ||
				 $route_name =='packed-order' ||
				 $route_name =='shipping-order' ||
				 $route_name =='delivered-order' ||
				 $route_name =='return-order' ||
				 $route_name =='cancelled-order' ||
				 $route_name =='hold-order' 
				) ? 'expand '.$subMenu=1:'has-sub '.$subMenu=0}}">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-graph"></i>
					<span>Sales  </span>
				</a>
				<ul class="sub-menu" style="display:{{($subMenu == 1
				) ? 'block':'none'}}">
					
				<li class="{{($route_name == 'sales-person') ? 'active':''}}"> <a href="{{route('salesPersions')}}"> Sales person</a></li>
				
				<li class="{{($route_name == 'admin-orders') ? 'active':''}}"><a href="{{route('adminOrderBackend')}}"> Order dashboard</a></li>
				<li class="{{($route_name == 'orders') ? 'active':''}}"><a href="{{route('orderAdmin')}}"> Orders</a></li>
				<li class="{{($route_name == 'pending-order') ? 'active':''}}"><a href="{{route('pendingOrderAdmin')}}"> Pending Order</a></li>
				<!-- <li><a href="{{route('approvedOrderAdmin')}}"> Processed Order</a></li> -->
				<li class="{{($route_name == 'to-be-packed') ? 'active':''}}"><a href="{{route('toBePackedAdminOrder')}}"> To be packed</a></li>
				<li class="{{($route_name == 'packed-order') ? 'active':''}}"><a href="{{route('packagingOrderAdmin')}}"> Packed Order</a></li>
				<li class="{{($route_name == 'shipping-order') ? 'active':''}}"><a href="{{route('shippingOrderAdmin')}}"> Shipping Order</a></li>
				<li class="{{($route_name == 'delivered-order') ? 'active':''}}"><a href="{{route('deliveredOrderAdmin')}}"> Delivered Order</a></li>
				<li class="{{($route_name == 'return-order') ? 'active':''}}"><a href="{{route('returnOrderAdmin')}}"> Return Order</a></li>
				<li class="{{($route_name == 'cancelled-order') ? 'active':''}}"><a href="{{route('cancelOrderAdmin')}}"> Cancelled Order</a></li>
				<li class="{{($route_name == 'hold-order') ? 'active':''}}"><a href="{{route('holdOrderAdmin')}}"> Hold Order</a></li>
					
					{{-- <li><a href="javascript:;"> Invoices</a></li> --}}
					{{-- <li><a href="javascript:;"> Refunds</a></li> --}}
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li>
					<li><a href="{{route('brandListLayout')}}">Brands</a></li>
					 --}}
				</ul>
			</li>
			<?php
				} 

				if(@Auth::user()->user_type == 1 && Auth::user()->hasPermissionTo('ViewUserManagement')){
				// if(@Auth::user()->user_type == 1 && Auth::user()->hasPermissionTo('ViewUserManagementUserPremission')){
					?>
				<li class="{{($route_name =='users' || $route_name =='banners'
				) ? 'expand '.$subMenuBanner=1:'has-sub '.$subMenuBanner=0}}">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
				
					<span>User Management </span>
				</a>
				<ul class="sub-menu" style="display:{{($subMenuBanner == 1
				) ? 'block':'none'}}">

					<?php if(Auth::user()->hasPermissionTo('ViewUserManagementUserPremission')){?>

					<li class="{{($route_name == 'users') ? 'active':''}}"><a href="{{route('users.index')}}">Users</a></li>

					<?php } ?>

					<li class="{{($route_name == 'banners') ? 'active':''}}"><a href="{{route('bannerListLayout')}}">Banners</a></li>
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li> --}}
					
				</ul>
			</li>
			<?php }?>

			<!-- <?php 
				 if (Auth::user()->hasPermissionTo('ViewUserManagement')) {
					?>
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
				
					<span>User Management </span>
				</a>
				<ul class="sub-menu">
				<li><a href="{{route('users.index')}}">Users</a></li>

					<li><a href="{{route('bannerListLayout')}}">Banners</a></li>
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li> --}}
					
				</ul>
			</li>
			<?php
				} 

				?> -->

			<?php 
				 if (Auth::user()->hasPermissionTo('ViewContactus')) {
					?>
			<li class="{{($route_name == 'contactus') ? 'active':'has-sub'}}">
					<a href="{{route('getContactList')}}">
						
					<i class="fa fa-phone"></i>
						<span>Contact us </span>
					</a>
				</li>
				<?php
				} 

				?>

			<?php 
				 if (Auth::user()->hasPermissionTo('ViewTransportationMaster')) {
					?>
				<li class="{{($route_name == 'transportMasters') ? 'active':'has-sub'}}">
					<a href="{{route('transportMasters')}}">
						
					<i class="fa fa-truck" aria-hidden="true"></i>
						<span>Transportation Master</span>
					</a>
				</li>
				<?php
				} 

				?>
				<?php 
				 if (Auth::user()->hasPermissionTo('ViewSalesCustomerTag')) {
					?>
				<li class="{{($route_name == 'sales-customer-tag') ? 'active':'has-sub'}}">
					<a href="{{route('salesCustomerTag')}}">
						
					<i class="fa fa-truck" aria-hidden="true"></i>
						<span>Sales Customer Tag</span>
					</a>
				</li>
				<?php
				} 

				?>

				<?php 
				 if (Auth::user()->hasPermissionTo('ViewSalesCustomerTag')) {
					?>
					<li class="{{($route_name == 'Customer-Cart-List') ? 'active':'has-sub'}}">
						<a href="{{route('customerCartListForAdmin')}}">
							
							<i class="icon-graph"></i>
							<span>Customer cart</span>
						</a>
						
					</li>
				<?php
				} 

				

				if(@Auth::user()->user_type == 1 && Auth::user()->hasPermissionTo('ViewCustomerWiseBrand')){
				?>
					<!-- <li class="{{($route_name == 'customer-wise-brand') ? 'active':'has-sub'}}">
						<a href="{{route('customerWiseBrand')}}">
							
							<i class="icon-graph"></i>
							<span>Customer wise brand</span>
						</a>
						
					</li> -->
				<?php }?>
			
			

			
		
			<!-- begin sidebar minify button -->
			<li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i class="ion-ios-arrow-back"></i> <span>Collapse</span></a></li>
			<!-- end sidebar minify button -->
		</ul>
		<!-- end sidebar nav -->
	</div>
	<!-- end sidebar scrollbar -->
</div>
<div class="sidebar-bg"></div>
<!-- end admin #sidebar -->

<?php }?>