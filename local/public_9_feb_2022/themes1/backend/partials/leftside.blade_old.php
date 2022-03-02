
<?php 
	// $customer = session()->get('customer'); 
	
	if(Auth::user()->user_type == 0){
		$customerdetail = get_custumer_by_user_id(Auth::user()->id);
		
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
								<img src="{{$profil_pic}}" id="output" class="outputPic" alt="" />
								
								
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
					
						if(Auth::user()->profile == 1 && $customerdetail->deleted_at == 1)
						{

					?>
					<li class="active">
						<a href="{{route('customerProfile')}}">
							
							<i class="icon-user"></i>
							<span>MY PROFILE </span>
						</a>
						
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="icon-graph"></i>
							<span>MY ORDERS </span>
						</a>
						<ul class="sub-menu">
							
							<li><a href="{{route('myOrderList')}}"> My Orders</a></li>
							
							<li><a href="{{route('myConfirmOrder')}}">Processed</a></li>
							<!-- <li><a href="{{route('myPacked')}}">Packed</a></li>
							<li><a href="{{route('myShipping')}}">Shipping</a></li> -->
							<li><a href="{{route('myDeliveredOrder')}}"> Delivered</a></li>
							<li><a href="{{route('myHoldOrder')}}"> Hold</a></li>
							
							
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="icon-graph"></i>
							<span>MY RETURN</span>
						</a>
						<ul class="sub-menu">
							
							<li><a href="{{route('myPendingOrder')}}"> Pending</a></li>
							<li><a href="{{route('myCancelOrder')}}"> Cancelled</a></li>
							<li><a href="{{route('myReturnOrder')}}"> Returned</a></li>
							
							
						</ul>
					</li>

					<li class="has-sub">
						<a href="javascript:;">
							
							<i class="icon-graph"></i>
							<span>TERMS USE</span>
						</a>
						
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							
							<i class="icon-graph"></i>
							<span>POLICIES</span>
						</a>
						
					</li>
					<li class="has-sub">
						<a href="javascript:;">
							
							<i class="icon-graph"></i>
							<span>SUPPORT & HELP</span>
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


<?php } else{?>


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
			<li>
				<ul class="nav nav-profile">
					<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
					
				</ul>
			</li>
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			
			<li class="active">
					<a href="javascript:;">
						{{-- <b class="caret"></b> --}}
						<i class="ion-ios-cog"></i>
						<span>DASHBOARD </span>
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

				
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-graph"></i>
					<span>SALES </span>
				</a>
				<ul class="sub-menu">
					
				<li><a href="{{route('salesPersions')}}"> Sales person</a></li>
				<li><a href="{{route('adminOrderBackend')}}"> Orders tab</a></li>
				<li><a href="{{route('orderAdmin')}}"> Orders</a></li>
				<li><a href="{{route('pendingOrderAdmin')}}"> Pending Order</a></li>
				<li><a href="{{route('approvedOrderAdmin')}}"> Processed Order</a></li>
				<li><a href="{{route('packagingOrderAdmin')}}"> Packed Order</a></li>
				<li><a href="{{route('shippingOrderAdmin')}}"> Shipping Order</a></li>
				<li><a href="{{route('deliveredOrderAdmin')}}"> Delivered Order</a></li>
				<li><a href="{{route('returnOrderAdmin')}}"> Return Order</a></li>
				<li><a href="{{route('cancelOrderAdmin')}}"> Cancelled Order</a></li>
				<li><a href="{{route('holdOrderAdmin')}}"> Hold Order</a></li>
					
					{{-- <li><a href="javascript:;"> Invoices</a></li> --}}
					{{-- <li><a href="javascript:;"> Refunds</a></li> --}}
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li>
					<li><a href="{{route('brandListLayout')}}">Brands</a></li>
					 --}}
				</ul>
			</li>

			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-basket"></i>
					{{-- <span>PRODUCTS <span class="label label-theme">NEW</span></span> --}}
					<span>PRODUCTS</span>
				</a>
				<ul class="sub-menu">

					
					<li><a href="{{route('itemListLayout')}}">Products</a></li>
					<li><a href="{{route('brandListLayout')}}">Brands</a></li>
					<li><a href="{{route('hsnMaster')}}">HSN Master</a></li>


				</ul>
			</li>


			{{-- <li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-basket"></i>
					{{-- <span>PRODUCTS <span class="label label-theme">NEW</span></span> 
					<span>PRODUCTS</span>
				</a>
				<ul class="sub-menu">
					
					<li><a href="{{route('itemCategories')}}">Item Category</a></li>
					<li><a href="{{route('masterSettingsLayout')}}">Master Setup</a></li>
					<li><a href="{{route('itemListLayout')}}">Item Master</a></li>
					
					<li><a href="{{route('brandListLayout')}}">Brands</a></li>
					
				</ul>
			</li> --}}
			{{-- <li class="">
				<a href="{{route('customerListLayout')}}">
					
					<i class="icon-user"></i>
					<span>Customer </span>
				</a>
				
			</li> --}}
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="icon-user"></i>
					<span>CUSTOMERS </span>
				</a>
				<ul class="sub-menu">
					
					<li><a href="{{route('customerListLayout')}}">Customers</a></li>
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li> --}}
					
				</ul>
			</li>
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
					<span>CMS </span>
				</a>
				<ul class="sub-menu">
					
					<li><a href="{{route('bannerListLayout')}}">Banners</a></li>
					{{-- <li><a href="{{route('itemListLayout')}}">Item Master</a></li> --}}
					
				</ul>
			</li>
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
					<span>SETTINGS </span>
				</a>
				<ul class="sub-menu">
					<li><a href="{{route('attributesLayout')}}">Attributes</a></li>
					{{-- <li><a href="{{route('attributeFamiliesLayout')}}">Attribute Families</a></li> --}}
				</ul>
			</li>
			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
					<span>SETUP </span>
				</a>
				<ul class="sub-menu">
				<li><a href="{{route('itemCategories')}}">Item Category</a></li>
					<li><a href="{{route('masterSettingsLayout')}}">Master Setup</a></li>
					
				</ul>
			</li>

			<li class="has-sub">
				<a href="javascript:;">
					<b class="caret"></b>
					<i class="fa fa-cogs"></i>
					<span>DISCOUNT </span>
				</a>
				<ul class="sub-menu">
				<li><a href="{{route('discountLayout')}}">Discounts</a></li>
				<li><a href="{{route('customerClass')}}">Customer class</a></li>
				<li><a href="{{route('customerCategories')}}">Customer categories</a></li>
					
					
				</ul>
			</li>
		
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