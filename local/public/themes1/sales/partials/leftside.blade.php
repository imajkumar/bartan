<!--------------------------- begin Sales #sidebar --------------------------------------->

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
			{{-- <li>
				<ul class="nav nav-profile">
					<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
					
				</ul>
			</li> --}}
		</ul>
		<!-- end sidebar user -->
		<!-- begin sidebar nav -->
		<ul class="nav">
			
			<li class="active">
					<a href="javascript:;">
						{{-- <b class="caret"></b> --}}
						<i class="ion-ios-cog"></i>
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
				<li class="has-sub">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="icon-graph"></i>
							<span>Items</span>
						</a>
						<ul class="sub-menu">
							
							
							<li><a href="{{route('salesPersonItems')}}">Items</a></li>
							<!-- <li><a href="{{route('itemListLayoutSales')}}">Add Item</a></li> -->
							
							
							
						</ul>
					</li>
					<li class="has-sub">
						<a href="{{route('myOrderListBySales')}}">
							<!-- <b class="caret"></b> -->
							<i class="icon-graph"></i>
							<span>My Order</span>
						</a>
						
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