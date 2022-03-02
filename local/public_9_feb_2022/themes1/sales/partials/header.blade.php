<?php
//pr(Auth::user());
@$customerDetail = session()->get('customerForSalesPanel');
//pr($customerDetail);
$seller = session()->get('sales');

$profil_pic = BACKEND.'img/user/user-4.jpg';
//pr($seller);
?>
<!-- begin custumer #page-container -->
<div id="page-container" class="fade page-sidebar-fixed page-header-fixed">

		<!-- begin #header -->
		<div id="header" class="header navbar-default">
			<!-- begin navbar-header -->
			<div class="navbar-header">
				
			<a href="{{url('/')}}" class="navbar-brand"><span class="navbar-logo">
				<img src="{{asset('assets/img/logo/logo.png')}}" alt=""></span> <b class="mr-1"></b> </a>
				
				<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			</div>
		
			<!-- end navbar-header --><!-- begin header-nav -->
			<ul class="navbar-nav navbar-right">
				<!-- <li class="navbar-form">
					<form action="" method="POST" name="search_form">
						<div class="form-group">
							<input type="text" class="form-control" placeholder="Enter keyword" />
							<button type="submit" class="btn btn-search"><i class="ion-ios-search"></i></button>
						</div>
					</form>
				</li> -->

				<?php
					$cartCollection = \Cart::getContent();

					$dataCartInArr = $cartCollection->toArray();
				?>
				<li class="dropdown">
					<a href="{{@$profile_pic}}" data-toggle="dropdown" class="dropdown-toggle icon">
					<i class="fa fa-shopping-bag"></i>
						<span class="label" id="total">{{$cartCollection->count()}}</span>
					</a>

					
					<div class="dropdown-menu media-list dropdown-menu-right cart-top">
					<!-- 	<div class="dropdown-header" id="totalWithBag" >Shopping Bag ({{$cartCollection->count()}})</div> -->
						<div id="htmlItemDataAppend">
						<?php
							
						
                            foreach ($dataCartInArr as $key => $rowData) {

                                $itemImages = get_item_default_img_item_id($rowData['id']);

                                if ($itemImages) {

                                    $itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
                                } else {

                                    $itemImg = FRONT . 'img/product/product-iphone.png';
                                }
                        ?>
						
						<a href="javascript:;" class="dropdown-item media" >
							<div class="media-left">
								<img src="{{$itemImg}}" class="media-object" alt="" />
								
							</div>
							<div class="media-body">
							
								<h6 class="media-heading">{{\Str::limit(strip_tags($rowData['name']),30,'...')}}</h6>
								<!-- <p>{{\Str::limit(strip_tags($rowData['name']),100,'...')}}</p> -->
								<div class="text-muted">

									<i class="fa fa-inr" aria-hidden="true"></i>
                                            {{$rowData['price']}}
											
								</div>
							
                      
							</div>
							<span class="remove" onclick="removeItemFromCartSales({{$rowData['id']}})" >&times;</span>
						</a>
						
							<?php }?>
                            </div>
						<div class="dropdown-footer text-center">
							<a href="{{route('salse_view_cart')}}" class="btn btn-inverse width-200">View more</a>
						</div>
					</div>
				</li>
				<!-- <li class="dropdown">
					<a href="{{@$profile_pic}}" data-toggle="dropdown" class="dropdown-toggle icon">
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
				</li> -->
				<li class="dropdown navbar-user">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<img src="{{$profil_pic ?? ''}}" class="outputPic" alt="" /> 
						<span class="d-none d-md-inline">
								
							{{ ucfirst(@$seller->seller_name)}}
						</span> <b class="caret"></b>
					</a>
					<div class="dropdown-menu dropdown-menu-right">
						<!-- <a href="javascript:;" class="dropdown-item">Edit Profile</a> -->
						{{-- <a href="javascript:;" class="dropdown-item"><span class="badge badge-danger pull-right">2</span> Inbox</a>						                         --}}
                        
                        <div class="dropdown-divider"></div>
                        
                                        

                        <a  href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" class="dropdown-item">Log Out</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                        <!-- <a  href="{{ route('salesLogout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" class="dropdown-item">Log Out</a>
                        <form id="logout-form" action="{{ route('salesLogout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form> -->
					</div>
				</li>
			</ul>
			<!-- end header navigation right -->
		</div>
		<!-- end #header -->
		