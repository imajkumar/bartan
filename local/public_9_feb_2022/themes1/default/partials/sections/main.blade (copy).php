<!-- BEGIN #slider -->
<div id="slider" class="section-container p-0 bg-black-darker" style="height:400px">
	<!-- BEGIN carousel -->
	<div id="main-carousel" class="carousel slide" data-ride="carousel">
		<!-- BEGIN carousel-inner -->
		<div class="carousel-inner">
			<!-- BEGIN item -->
			
			<?php
				
				$banners = get_banners();
				//pr($banners);
				//$banners = get_bannerLists();
				$n = 1;
				foreach($banners as $banner){
					
					if($banner->banner) {

						
						$bannerImg = BASE_URL.ITEM_IMG_PATH.'/'.$banner->banner;
						//exit($bannerImg);
						
					} else {
						$bannerImg = FRONT.'img/slider/slider-1-cover.jpg';
					}

					// $itemBannerImg = get_item_default_img_item_id($banner->item_id);

					// if($itemBannerImg)
					// {

					// 	$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemBannerImg->img_name;
						
					// } else {

					// 	$itemImg = FRONT.'img/product/product-iphone.png';
					// }

					if($banner->status == 1){
			?>

				<div class="carousel-item {{($n == 1) ? 'active' : ''}}" data-paroller="true" data-paroller-factor="0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{$bannerImg}}') center 0 / cover no-repeat;">
				
				<div class="container">
					{{-- <img src="{{$bannerImg}}" class="product-img right bottom fadeInRight animated" alt="" /> --}}
				</div>
				<div class="carousel-caption carousel-caption-left">
					<div class="container">
					<h3 class="title m-b-5 fadeInLeftBig animated">{{optional($banner)->banner_title}}</h3>
					<p class="m-b-15 fadeInLeftBig animated">{{\Str::limit(strip_tags(optional($banner)->banner_desc),30,'...')}}</p>
						{{-- <div class="price m-b-30 fadeInLeftBig animated"><small>from</small> <span>₹{{($banner->regular_price)? $banner->regular_price:0}}</span></div> --}}
					@if(optional($banner)->btn_name)
						<a href="{{optional($banner)->btn_link}}" class="btn btn-outline btn-lg fadeInLeftBig animated">{{optional($banner)->btn_name}}</a>
					@endif
						{{-- <a href="javascript:void();" onclick="add_to_cart(<?=$banner->item_id?>)" class="btn btn-outline btn-lg fadeInLeftBig animated">Buy Now</a> --}}
					</div>
				</div>
			
				{{-- <div class="container">
					<img src="{{FRONT.'img/slider/slider-1-product.png'}}" class="product-img right bottom fadeInRight animated" alt="" />
				</div>
				<div class="carousel-caption carousel-caption-left">
					<div class="container">
						<h3 class="title m-b-5 fadeInLeftBig animated">iMac</h3>
						<p class="m-b-15 fadeInLeftBig animated">The vision is brighter than ever.</p>
						<div class="price m-b-30 fadeInLeftBig animated"><small>from</small> <span>$2299.00</span></div>
						<a href="product_detail.html" class="btn btn-outline btn-lg fadeInLeftBig animated">Buy Now</a>
					</div>
				</div> --}}
			</div>

		<?php }   $n++;}?>

			<!-- END item -->
			<!-- BEGIN item -->
			{{-- <div class="carousel-item" data-paroller="true" data-paroller-factor="-0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{FRONT.'img/slider/slider-2-cover.jpg'}}') center 0 / cover no-repeat;">
				<div class="container">
					<img src="{{FRONT.'img/slider/slider-2-product.png'}}" class="product-img left bottom fadeInLeft animated" alt="" />
				</div>
				<div class="carousel-caption carousel-caption-right">
					<div class="container">
						<h3 class="title m-b-5 fadeInRightBig animated">iPhone X</h3>
						<p class="m-b-15 fadeInRightBig animated">Say hello to the future.</p>
						<div class="price m-b-30 fadeInRightBig animated"><small>from</small> <span>$1,149.00</span></div>
						<a href="product_detail.html" class="btn btn-outline btn-lg fadeInRightBig animated">Buy Now</a>
					</div>
				</div>
			</div> --}}
			<!-- END item -->
			<!-- BEGIN item -->
			{{-- <div class="carousel-item" data-paroller="true" data-paroller-factor="-0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{FRONT.'img/slider/slider-3-cover.jpg'}}') center 0 / cover no-repeat;">
				<div class="carousel-caption">
					<div class="container">
						<h3 class="title m-b-5 fadeInDownBig animated">Macbook Air</h3>
						<p class="m-b-15 fadeInDownBig animated">Thin.Light.Powerful.<br />And ready for anything</p>
						<div class="price fadeInDownBig animated"><small>from</small> <span>$999.00</span></div>
						<a href="product_detail.html" class="btn btn-outline btn-lg fadeInUpBig animated">Buy Now</a>
					</div>
				</div>
			</div> --}}
			<!-- END item -->
		</div>
		<!-- END carousel-inner -->
		<a class="carousel-control-prev" href="#main-carousel" data-slide="prev"> 
		<i class="fa fa-angle-left"></i> 
		</a>
		<a class="carousel-control-next" href="#main-carousel" data-slide="next"> 
		<i class="fa fa-angle-right"></i> 
		</a>
	</div>
	<!-- END carousel -->
</div>
<!-- END #slider -->


<div class="container">


<!-- BEGIN #mobile-list -->
<div id="mobile-list" class="section-container p-t-25">
	<!-- BEGIN container -->
	<div class="container">
		
		<!-- END section-title -->
		<!-- BEGIN category-container -->
		<div class="category-container">
			<!-- BEGIN category-sidebar -->
			<div class="category-sidebar">
				<ul class="category-list">
					<li class="list-header">Top Categories</li>

					<?php 
						$itemCategories = getItemCategory();
						foreach($itemCategories as $itemCategory){
					?>
						<li><a id="{{'Category_'.$itemCategory->id}}" class="getItem" href="javascript:void(0);">{{ucfirst($itemCategory->item_name)}}</a></li>
					
						<?php }?>

				</ul>
			</div>
			<!-- END category-sidebar -->
		
			<!-- BEGIN category-detail -->
			<div class="category-detail">
				<!-- BEGIN category-item -->
				
				<!-- END category-item -->
				<!-- BEGIN category-item -->
				<div class="category-item list" id="itemsByCategory">
					<!-- BEGIN item-row -->
					<div class="item-row">
						<!-- BEGIN item -->
					
						<?php 
							$items = get_items($flag='Category', $limit=6);

							
							$i=0;
							foreach($items as $item){
								if($item->is_visible == 1){

									$itemImages = get_item_default_img_item_id($item->item_id);

									if($itemImages)
									{

										$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
										
									} else {

										$itemImg = FRONT.'img/product/product-iphone.png';
									}

									
									if(($i != 1) && ($i != 0)&& ($i % 3==0)){
						?>
						
					
							</div>
							<div class="item-row">
						<?php } ?>

						<div class="item item-thumbnail">
							<a href="{{route('productDetail', $item->slug)}}" class="item-image">
								<img src="{{$itemImg}}" alt="" />
								{{-- <div class="discount">15% OFF</div> --}}
							</a>
							<div class="item-info">
								<h4 class="item-title">
								<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
								</h4>
								<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
								<div class="item-price">₹{{($item->regular_price)? $item->regular_price:0}}</div>
								{{-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
								<a href="javascript:void();" onclick="add_to_cart(<?=$item->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
							</div>
						</div>
					
					
						
					
					<?php  $i++;}}?>

					</div>	
					
					<!-- END item-row -->
					
				</div>
				<!-- END category-item -->
			</div>
			<!-- END category-detail -->
		</div>
		<!-- END category-container -->
	</div>
	<!-- END container -->
</div>
<!-- END #mobile-list -->
<div class="container">
<!-- BEGIN #trending-items -->
<div id="trending-items" class="section-container">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN section-title -->
		<h4 class="section-title clearfix">
			<a href="#" class="pull-right m-l-5"><i class="fa fa-angle-right f-s-18"></i></a>
			<a href="#" class="pull-right"><i class="fa fa-angle-left f-s-18"></i></a>
			Trending Items
			<small>Shop and get your favourite items at amazing prices!</small>
		</h4>
		<!-- END section-title -->
		<!-- BEGIN row -->
		<div class="row row-space-10">
			<!-- BEGIN col-2 -->

			<?php 
				$items = get_items($flag='', $limit=6);
				
				
				$n=1;
				foreach($items as $item)
				{
					if($item->is_visible == 1){

						$itemImages = get_item_default_img_item_id($item->item_id);

						if($itemImages)
						{

							$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
							
						} else {

							$itemImg = FRONT.'img/product/product-iphone.png';
						}

					
					
			?>

			<div class="col-lg-2 col-md-4">
				<!-- BEGIN item -->
				<div class="item item-thumbnail">
					<a href="{{route('productDetail', $item->slug)}}" class="item-image">
						<img src="{{$itemImg}}" alt="" />
					{{-- <div class="discount">15% OFF{{$item->item_id}}</div> --}}
					</a>
					<div class="item-info">
						<h4 class="item-title">
						<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
						</h4>
						<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
						<div class="item-price">₹{{($item->regular_price)? $item->regular_price:0}}</div>
						{{-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
						<a href="javascript:void(0)" onclick="add_to_cart(<?=$item->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
					</div>
				</div>
				<!-- END item -->
			</div>

		<?php }}?>
			
			
		</div>
		<!-- END row -->
	</div>
	<!-- END container -->
</div>
<!-- END #trending-items -->

<!-- BEGIN #tablet-list -->
<div id="tablet-list" class="section-container p-t-0">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN section-title -->
		<h4 class="section-title clearfix">
			<a href="#" class="pull-right">SHOW ALL</a>
			Tablet
			<small>Shop and get your favourite tablet at amazing prices!</small>
		</h4>
		<!-- END section-title -->
		<!-- BEGIN category-container -->
		<div class="category-container">
			<!-- BEGIN category-sidebar -->
			<div class="category-sidebar">
				<ul class="category-list">
					<li class="list-header">Top Brands</li>
					<?php 
						$brands = getBarnds();
						foreach($brands as $brand){
					?>
						<li><a id="{{'Brand_'.$brand->id}}" class="getItemByBrand" href="javascript:void(0);">{{ucfirst($brand->name)}}</a></li>
					<?php }?>
					
					
				</ul>
			</div>
			<!-- END category-sidebar -->
			<!-- BEGIN category-detail -->
			<div class="category-detail">
				<!-- BEGIN category-item -->
				<a href="#" class="category-item full">
					<div class="item">
						<div class="item-cover">
							<img src="{{FRONT.'img/product/product-huawei-mediapad.jpg'}}" alt="" />
						</div>
						<div class="item-info bottom">
							<h4 class="item-title">Huawei MediaPad T1 7.0</h4>
							<p class="item-desc">Vibrant colors. Beautifully displayed</p>
							<div class="item-price"><i class="fa fa-inr" aria-hidden="true"></i>299.00</div>
						</div>
					</div>
				</a>
				<!-- END category-item -->
				<!-- BEGIN category-item -->
				

				<div class="category-item list" id="itemsByBrand">
					<!-- BEGIN item-row -->
					<div class="item-row">
						<?php 
							$items = get_items($flag='Brand', $limit=6);

							
							$i=0;
							foreach($items as $item){
								if($item->is_visible == 1){

									$itemImages = get_item_default_img_item_id($item->item_id);

									if($itemImages)
									{

										$itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
										
									} else {

										$itemImg = FRONT.'img/product/product-iphone.png';
									}

									
									if(($i != 1) && ($i != 0)&& ($i % 3==0)){
						?>
						
					
							</div>
							<div class="item-row">
						<?php } ?>

						<div class="item item-thumbnail">
							<a href="{{route('productDetail', $item->slug)}}" class="item-image">
								<img src="{{$itemImg}}" alt="" />
								{{-- <div class="discount">15% OFF</div> --}}
							</a>
							<div class="item-info">
								<h4 class="item-title">
								<a href="{{route('productDetail', $item->slug)}}">{{$item->item_name}}</a>
								</h4>
								<p class="item-desc">{{\Str::limit(strip_tags($item->description),100,'...')}}</p>
								<div class="item-price">₹{{($item->regular_price)? $item->regular_price:0}}</div>
								{{-- <div class="item-discount-price"><i class="fa fa-inr" aria-hidden="true"></i>{{$item->regular_price}}</div> --}}
								<a href="javascript:void();" onclick="add_to_cart(<?=$item->item_id?>)" class="btn btn-inverse">ADD TO CART</a>
							</div>
						</div>
					
					
						
					
					<?php  $i++;}}?>
					</div>
					
					<!-- END item-row -->
					
				</div>
				<!-- END category-item -->
			</div>
			<!-- END category-detail -->
		</div>
		<!-- END category-container -->
	</div>
	<!-- END container -->
</div>
<!-- END #tablet-list -->

<!-- BEGIN #policy -->
<div id="policy" class="section-container bg-white">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN row -->
		<div class="row">
			<!-- BEGIN col-4 -->
			<div class="col-lg-4 col-md-4 mb-4 mb-md-0">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-truck"></i></div>
					<div class="policy-info">
						<h4>Free Delivery Over $100</h4>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<!-- END col-4 -->
			<!-- BEGIN col-4 -->
			<div class="col-lg-4 col-md-4 mb-4 mb-md-0">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-umbrella"></i></div>
					<div class="policy-info">
						<h4>1 Year Warranty For Phones</h4>
						<p>Cras laoreet urna id dui malesuada gravida. <br />Duis a lobortis dui.</p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<!-- END col-4 -->
			<!-- BEGIN col-4 -->
			<div class="col-lg-4 col-md-4">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-user-md"></i></div>
					<div class="policy-info">
						<h4>6 Month Warranty For Accessories</h4>
						<p>Fusce ut euismod orci. Morbi auctor, sapien non eleifend iaculis.</p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<!-- END col-4 -->
		</div>
		<!-- END row -->
	</div>
	<!-- END container -->
</div>
<!-- END #policy -->

<!-- BEGIN #subscribe -->
<div id="subscribe" class="section-container">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN row -->
		<div class="row">
			<!-- BEGIN col-6 -->
			<div class="col-md-6 mb-4 mb-md-0">
				<!-- BEGIN subscription -->
				<div class="subscription">
					<div class="subscription-intro">
						<h4> LET'S STAY IN TOUCH</h4>
						<p>Get updates on sales specials and more</p>
					</div>
					<div class="subscription-form">
						<form name="subscription_form" action="index.html" method="POST">
							<div class="input-group">
								<input type="text" class="form-control" name="email" placeholder="Enter Email Address" />
								<div class="input-group-append">
									<button type="submit" class="btn btn-inverse"><i class="fa fa-angle-right"></i></button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<!-- END subscription -->
			</div>
			<!-- END col-6 -->
			<!-- BEGIN col-6 -->
			<div class="col-md-6">
				<!-- BEGIN social -->
				<div class="social">
					<div class="social-intro">
						<h4>FOLLOW US</h4>
						<p>We want to hear from you!</p>
					</div>
					<div class="social-list">
						<a href="#"><i class="fab fa-facebook"></i></a>
						<a href="#"><i class="fab fa-twitter"></i></a>
						<a href="#"><i class="fab fa-instagram"></i></a>
						<a href="#"><i class="fab fa-dribbble"></i></a>
						<a href="#"><i class="fab fa-google-plus"></i></a>
					</div>
				</div>
				<!-- END social -->
			</div>
			<!-- END col-6 -->
		</div>
		<!-- END row -->
	</div>
	<!-- END container -->
</div>
<!-- END #subscribe -->