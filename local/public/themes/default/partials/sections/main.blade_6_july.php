
	<?php
	
			//pr(Auth::user());
			//$kyc = 'false';

			if (Auth::user()) {

				$login = "true";
				if (Auth::user()->user_type == 0) {

					if (Auth::user()->profile == 1) {

						$kyc = 'true';
					} else {

						$kyc = 'false';
					}
					$isAdmin = "no";
				} else {
					$isAdmin = "yes";
					$kyc = 'true';
				}
			} else {
				$kyc = 'false';
				$login = "false";
			}

			$brandId = array();
			if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
				$customerBrands = DB::table('customer_wise_brands')->where('user_id', Auth::user()->id)->get();
				foreach($customerBrands as $customerBrand){
					$brandId[] = $customerBrand->brand_id;
				}
			}
			// $customer = session()->get('customer');

			//  if($customer){

			// 	if($customer->profile == 1 && user_type){
			// 		$kyc = 'true';

			// 	}else{
			// 		$kyc = 'false';
			// 	}		
			// }else{

			//     $kyc = 'false';
			// }
?>



<!-- <div id="slider" class="section-container p-0 bg-black-darker">
	
	<div id="main-carousel" class="carousel slide" data-ride="carousel">
		
		<div class="carousel-inner">

		<?php
			$banners = get_banners();
			
			$n = 1;
			foreach ($banners as $banner) {

				if ($banner->banner) {


					$bannerImg = BASE_URL . ITEM_IMG_PATH . '/' . $banner->banner;
					//exit($bannerImg);

				} else {
					$bannerImg = FRONT . 'img/slider/slider-1-cover.jpg';
				}

				

				if ($banner->status == 1) {
			?>

		

					<div class="carousel-item {{($n == 1) ? 'active' : ''}}" data-paroller="true" data-paroller-factor="0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{$bannerImg}}') center 0 / cover no-repeat;">

						<div class="container">
							{{-- <img src="{{$bannerImg}}" class="product-img right bottom fadeInRight animated" alt="" /> --}}
						</div>
						<div class="carousel-caption carousel-caption-left">
							<div class="container">
								<h3 class="title m-b-5 fadeInLeftBig animated">{{optional($banner)->banner_title}}</h3>
								<p class="m-b-15 fadeInLeftBig animated">{!! \Str::limit(strip_tags(optional($banner)->banner_desc),30,'...')}}</p>
								{{-- <div class="price m-b-30 fadeInLeftBig animated"><small>from</small> <span>₹{{($banner->regular_price)? $banner->regular_price:0}}</span>
							</div> --}}
							@if(optional($banner)->btn_name)
							<a href="{{optional($banner)->btn_link}}" class="btn btn-outline btn-lg fadeInLeftBig animated">{{optional($banner)->btn_name}}</a>
							@endif
							{{-- <a href="javascript:void();" onclick="add_to_cart(<?= $banner->item_id ?>)" class="btn btn-outline btn-lg fadeInLeftBig animated">Buy Now</a> --}}
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

<?php }
				$n++;
			} ?>


 <div class="carousel-item" data-paroller="true" data-paroller-factor="-0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{FRONT.'img/slider/slider-2-cover.jpg'}}') center 0 / cover no-repeat;">
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
</div>

 <div class="carousel-item" data-paroller="true" data-paroller-factor="-0.3" data-paroller-factor-sm="0.01" data-paroller-factor-xs="0.01" style="background: url('{{FRONT.'img/slider/slider-3-cover.jpg'}}') center 0 / cover no-repeat;">
<div class="carousel-caption">
	<div class="container">
		<h3 class="title m-b-5 fadeInDownBig animated">Macbook Air</h3>
		<p class="m-b-15 fadeInDownBig animated">Thin.Light.Powerful.<br />And ready for anything</p>
		<div class="price fadeInDownBig animated"><small>from</small> <span>$999.00</span></div>
		<a href="product_detail.html" class="btn btn-outline btn-lg fadeInUpBig animated">Buy Now</a>
	</div>
</div>
</div> 

</div>

</div> -->
<!-- END carousel-inner -->




<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
 
  <div class="carousel-inner">
  <?php
			$banners = get_banners();
			//pr($banners);
			//$banners = get_bannerLists();
			$n = 1;
			foreach ($banners as $banner) {

				if ($banner->banner) {


					$bannerImg = BASE_URL . ITEM_IMG_PATH . '/' . $banner->banner;
					$bannerImgMobile = BASE_URL . ITEM_IMG_PATH . '/' . $banner->mobile_view_banner;
					//exit($bannerImg);

				} else {
					$bannerImg = FRONT . 'img/slider/slider-1-cover.jpg';
					$bannerImgMobile = FRONT . 'img/slider/slider-1-cover.jpg';
				}


				if ($banner->status == 1) {
			?>

    <div class="carousel-item {{($n == 1) ? 'active' : ''}}">
      <!-- <img class="d-block w-100" src="{{$bannerImg}}" alt="First slide"> -->
	  <img class="d-block w-100 banner-d" src="{{ $bannerImg }}" alt="First slide">
       <img class="d-block w-100 banner-m" src="{{ $bannerImgMobile }}" alt="First slide">
       <div class="carousel-caption carousel-caption-right">
							<div class="container">
								<h3 class="title m-b-5 fadeInRightBig animated">{{optional($banner)->banner_title}}</h3>
								<p class="m-b-15 fadeInRightBig animated">{!! \Str::limit(strip_tags(optional($banner)->banner_desc),30,'...') !!}</p>
								@if(optional($banner)->btn_name)
							<a href="{{optional($banner)->btn_link}}" class="btn btn-inverse btn-md fadeInRightBig animated">{{optional($banner)->btn_name}}</a>
							@endif
								<!-- <a href="product_detail.html" class="btn btn-inverse btn-md fadeInRightBig animated">Buy Now</a> -->
							</div>
						</div>
    </div>

	<?php }
				$n++;
			} ?>
    
   
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>




<!-- <a class="carousel-control-prev" href="#main-carousel" data-slide="prev">
	<i class="fa fa-angle-left"></i>
</a>
<a class="carousel-control-next" href="#main-carousel" data-slide="next">
	<i class="fa fa-angle-right"></i>
</a> -->
</div>
<!-- END carousel -->
</div>
<!-- END #slider -->

<!-- BEGIN #promotions -->

<!-- END #promotions -->

<!-- BEGIN #trending-items -->
<section class="section-container client-list">
<div class="container">

		<div class="brand-carousel section-padding owl-carousel">
		<?php
			//$brands = getBarndsByCustomer($brandId);
			 $brands = getBarnds($brandId);
			//pr($brands);
			foreach ($brands as $brand) {
				
				if ($brand->brand_img) {
					$brandImg =  BASE_URL . ITEM_IMG_PATH . '/' . $brand->brand_img;
//echo $brandImg;exit;
			?>
					<!-- <li><a id="{{$brand->id}}" href="{{route('getItemsByBrandId', $brand->id)}}"><img src="{{$brandImg}}" alt="" /></a></li> -->
					
					<div class="single-logo">
						<a href="{{route('getItemsByBrandId', $brand->id)}}" id="{{$brand->id}}">
						<img src="{{$brandImg}}" class="br-image mb-2">
					</a>
					</div>
					

            <?php } } ?>
			
			
		</div>
	</div>
</section>
<div class="container">
		

		<div class="row row-space-10">
			<div class="col-lg-12">
				@if (auth()->guest() && @$isAdmin !="yes")

				<div id="main">
   

					   	<div class="box">
					  <h2 class="kyc-titles text-center">To see wholesale prices & to buy products</h2>

					  <h1 class="title text-center">Complete Shop's KYC</h1>
					</div>
					     
					<h2 class="kyc-titles text-center">Upload any one of the following documents</h2>

					<h2 class="kyc-red text-center">GST | Cancelled current account cheque</h2>
					<h2 class="kyc-red text-center">Aadhar | Shop & Establishment license</h2>
					<div class="middle">
					  <a class="btn-kyc" href="{{url('/customer/login')}}">
					  
					   <span class="text">Register/ Login</span>
					  </a>
					 </div>
					   


					</div>
			<!-- <a href="{{url('/customer/login')}}"><img src="{{asset('assets/img/cover/kyc_banner.jpg')}}" class="product-img right bottom fadeInRight animated" alt="" /></a> -->

			@else
				@if($kyc == "false")

				<div id="main">
   

					   	<div class="box">
					  <h2 class="kyc-titles text-center">To see wholesale prices & to buy products</h2>

					  <h1 class="title text-center">Complete Shop's KYC</h1>
					</div>
					     
					<h2 class="kyc-titles text-center">Upload any one of the following documents</h2>

					<h2 class="kyc-red text-center">GST | Cancelled current account cheque</h2>
					<h2 class="kyc-red text-center">Aadhar | Shop & Establishment license</h2>
					<div class="middle">
					  <a class="btn-kyc" href="{{route('customerProfileWizard')}}">
					  
					   <span class="text">Register/ Login</span>
					  </a>
					 </div>
					   


					</div>
				<!-- <a href="{{route('customerProfileWizard')}}"><img src="{{asset('assets/img/cover/kyc_banner.jpg')}}" class="product-img right bottom fadeInRight animated" alt="" /></a> -->
				
				@endif
			@endif



	


			</div>
		</div>
	</div>
<div id="trending-items" class="section-container">


		
	<div class="container">
		<!-- BEGIN section-title -->

		<h4 class="section-title clearfix">

			Trending Items
			<small>
				Shop and get your favourite items at amazing prices!

			</small>
		</h4>
		<div class="row row-space-10">
			<div class="MultiCarousel" data-items="1,3,5,6" data-slide="1" id="MultiCarousel" data-interval="1000">
				<div class="MultiCarousel-inner">

					<?php
					$items = get_items($flag = '', $limit = -1, $brandId);

					//pr($items);
					$n = 1;
					foreach ($items as $item) {
						if ($item->is_visible == 1) {

							$itemImages = get_item_default_img_item_id($item->item_id);

							if ($itemImages) {

								$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
							} else {

								$itemImg = FRONT . 'img/product/product-iphone.png';
							}
							@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
							@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
							@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
							
							$totalOff = $custCatDiscount + $custClassDiscount;
							//echo @$custClassDiscount."/".@$custCatDiscount."/".$totalOff."/".@$AfterDiscountPrice;
							$retailPrice ='';
							if($item->item_mrp > $item->regular_price){

								@$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
							}
							
					?>

							<!-- BEGIN item -->
							<div class="item item-thumbnail itemht">
								<div class="item-in">
								<a href="{{route('productDetail', $item->slug)}}" class="item-image">
									<img src="{{$itemImg}}" alt="" />
									<!-- <div class="discount">{{$retailPrice}}% OFF </div> -->
									<?php if($totalOff != 0){?>
									<div class="discount">{{$totalOff}}% OFF </div>
									<?php }?>
							</a>

							<div class="item-info">
								<h4 class="item-title">
									<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
								</h4>
								<p class="item-desc">{!! \Str::limit(strip_tags($item->description),100,'...') !!}</p>


								<?php
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
								?>

									<div class="item-price itm-pr">Offer Price: ₹ {{($item->regular_price)? $item->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr">MRP:
										<span> ₹ {{($item->item_mrp)? $item->item_mrp:''}}</span>
									</div>
									@endif
									<?php }else{ ?>

									<div class="item-price itm-pr" >Offer Price: ₹ {{$AfterDiscountPrice}}</div>

									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr">MRP:<span> ₹ {{($item->item_mrp)? $item->item_mrp:''}}</span></div>
									@endif

									<!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
									
									
									<?php }?>
									
									@if($retailPrice)
									<div class="itm-rlm">
										<span>{{$retailPrice}}%</span> Retail Margin</div>
									@endif

									<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>

									

								<?php } ?>

								

							</div>
							</div>
				</div>
					
				
				<!-- END item -->

		<?php }
					} ?>

			</div>
			<button class="btn btn-primary leftLst">
				<</button> <button class="btn btn-primary rightLst">>
			</button>
		</div>
	</div>

</div>

<!-- BEGIN container -->
<div class="container" style="display:none">
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


		<?php
		$items = get_items($flag = '', $limit = 6, $brandId);


		$n = 1;
		foreach ($items as $item) {
			if ($item->is_visible == 1) {

				$itemImages = get_item_default_img_item_id($item->item_id);

				if ($itemImages) {

					$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
				} else {

					$itemImg = FRONT . 'img/product/product-iphone.png';
				}

				@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
				@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
				@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
				
				$totalOff = $custCatDiscount + $custClassDiscount;
				$retailPrice ='';
				if($item->item_mrp > $item->regular_price){

					@$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
				}
		?>

				<div class="col-lg-2 col-md-4">
					<!-- BEGIN item -->
					<div class="item item-thumbnail">
						<a href="{{route('productDetail', $item->slug)}}" class="item-image">
							<img src="{{$itemImg}}" alt="" />
							<?php if($totalOff != 0){?>
								<div class="discount">{{$totalOff}}% OFF </div>
							<?php }?>
					</a>
					<div class="item-info">
						<h4 class="item-title">
							<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
						</h4>
						<p class="item-desc">{!! \Str::limit(strip_tags($item->description),100,'...') !!}</p>

						<?php
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
								?>

									<div class="item-price itm-pr">Offer Price: ₹ {{($item->regular_price)? $item->regular_price:0}}</div>
									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr">MRP:
										<span>₹ {{($item->item_mrp)? $item->item_mrp:''}}</span>
									</div>
									@endif
								<?php }else{ ?>

									<div class="item-price itm-pr">Offer Price: ₹{{$AfterDiscountPrice}}</div>

									
									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr">MRP:
										<span>₹ {{($item->item_mrp)? $item->item_mrp:''}}</span>
									</div>
									@endif

									<!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
									
									
									<?php }?>
									
									@if($retailPrice)
									<div class="itm-rlm"><span>{{$retailPrice}}%</span> Retail Margin</div>
									@endif
							
							
							<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>



						<?php } ?>
					</div>
				</div>
				<!-- END item -->
	</div>

<?php }
		} ?>





</div>
<!-- END row -->
</div>
<!-- END container -->
</div>
<!-- END #trending-items -->

<!-- BEGIN #mobile-list -->
<div id="mobile-list" class="section-container p-t-0">
	<!-- BEGIN container -->
	<div class="container">
		<div class="category-container">
			<!-- BEGIN category-sidebar -->
			<div class="category-sidebar">
				<ul class="category-list category-list border-all height-fix">
					<li class="list-header">Top Categories</li>

					<?php
					$itemCategories = getItemCategoryForGroup();
					// $itemCategories = array_multisort( array_column($itemCategories->toArray(), "priority"), SORT_ASC, $itemCategories->toArray());
					// $itemCategories = getItemCategory();
					//pr($itemCategories);
					foreach ($itemCategories as $itemCategory) {
						
						// $itemsInCategory = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $itemCategory->id);
                        $itemsInCategory = get_itemsByCatOrBrandIdForTest($flag='Category', $limit=-1, $itemCategory->id, $itemCategory->item_under_group_id);
						//echo $itemCategory->item_under_group_id;pr($itemsInCategory);
						if(count($itemsInCategory) != 0){

							$group = DB::table('tbl_group')->where('g_id', $itemCategory->item_under_group_id)->first();
					if($group){
					?>
						<li><a id="{{'Category_'.$itemCategory->id}}" class="getItem getItemTest1" href="javascript:void(0);">{{ucfirst(@$group->g_name)}}</a></li>
						<!-- <li><a id="{{'Category_'.$itemCategory->id}}" class="getItem" href="javascript:void(0);">{{ucfirst($itemCategory->item_name)}}</a></li> -->

					<?php }}} ?>

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
						$items = get_items($flag = 'Category', $limit = 6, $brandId);

						// pr($items);
						$i = 0;
						foreach ($items as $item) {
							if ($item->is_visible == 1) {

								$itemImages = get_item_default_img_item_id($item->item_id);

								if ($itemImages) {

									$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
								} else {

									$itemImg = FRONT . 'img/product/product-iphone.png';
								}
								@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
									@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
									@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
									
									$totalOff = $custCatDiscount + $custClassDiscount;
									
									$retailPrice ='';
									if($item->item_mrp > $item->regular_price){
					
										@$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
									}

								if (($i != 1) && ($i != 0) && ($i % 3 == 0)) {
									
									
						?>


					</div>
					<div class="item-row">
					<?php } ?>

					<div class="item item-thumbnail">
						<a href="{{route('productDetail', $item->slug)}}" class="item-image">
							<img src="{{$itemImg}}" alt="" />
							<?php if($totalOff != 0){?>
								<div class="discount">{{$totalOff}}% OFF </div>
							<?php }?>
						</a>
						<div class="item-info">
							<h4 class="item-title">
								<a href="{{route('productDetail', $item->slug)}}">{{$item->product_name}}</a>
							</h4>
							<p class="item-desc">{!! \Str::limit(strip_tags($item->description),100,'...') !!}</p>

							<?php
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
										?>
		
											<div class="item-price itm-pr">Offer Price: ₹ {{($item->regular_price)? $item->regular_price:0}}</div>
											@if($item->item_mrp)
											<div class="item-discount-price itm-dpr">MRP: <span>₹ {{($item->item_mrp)? $item->item_mrp:''}}</span></div>
											@endif
										<?php }else{ ?>
		
											<div class="item-price itm-pr">Offer Price: ₹ {{$AfterDiscountPrice}}</div>
		
											

										@if($item->item_mrp)
										<div class="item-discount-price itm-dpr">MRP: <span>₹ {{($item->item_mrp)? $item->item_mrp:''}}</span></div>
										@endif

									<!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
									
									
									<?php }?>
									
									@if($retailPrice)
									<div class="itm-rlm">
										<span>{{$retailPrice}}%</span> Retail Margin</div>
									@endif

								<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>



							<?php } ?>
						</div>
					</div>




			<?php $i++;
							}
						} ?>

					</div>
					

					<!-- END item-row -->

				</div>
				<!-- END category-item -->
			</div>
			<!-- END category-detail -->
		</div>
		<!-- <ul class="pagination justify-content-center m-t-0">
              
			  @if (method_exists($items,'links'))
			  
			  {{ $items->links() }}
					  
				 
			  @endif
			 
			 
			
		  </ul> -->
	</div>
</div>

<!-- BEGIN #mobile-list -->
<div id="mobile-list" class="section-container p-t-0">
	<!-- BEGIN container -->
	<div class="container">

		<!-- BEGIN category-container -->
		<div class="category-container">
			<!-- BEGIN category-sidebar -->
			<div class="category-sidebar">
				<ul class="category-list category-list border-all">
					<li class="list-header">Top Brands</li>
					<?php
					//pr($brandId);
					$brands = getBarndsByCustomer($brandId);
					//$brands = getBarnds();
					//pr($brands);
					foreach ($brands as $brand) {
					?>
						<li><a id="{{'Brand_'.$brand->id}}" class="getItemByBrand" href="javascript:void(0);">{{ucfirst($brand->name)}}</a></li>
					<?php } ?>

				</ul>
			</div>
			<!-- END category-sidebar -->
			<!-- BEGIN category-detail -->
			<div class="category-detail">

				<!-- BEGIN category-item -->
				<div class="category-item list" id="itemsByBrand">

					<!-- BEGIN item-row -->
					<div class="item-row">
						<?php
						$items = get_items($flag = 'Brand', $limit = 6, $brandId);


						$i = 0;
						foreach ($items as $item) {
							if ($item->is_visible == 1) {

								$itemImages = get_item_default_img_item_id($item->item_id);

								if ($itemImages) {

									$itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
								} else {

									$itemImg = FRONT . 'img/product/product-iphone.png';
								}

								@$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $item->cat_id);
									@$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $item->cat_id);
									@$AfterDiscountPrice = calculateItemDiscount($item->regular_price, $custClassDiscount, $custCatDiscount);
									
									$totalOff = $custCatDiscount + $custClassDiscount;
									
									$retailPrice ='';
									if($item->item_mrp > $item->regular_price){
					
										@$retailPrice = getRetailPrice(Auth::user()->id,$item->item_id,$AfterDiscountPrice,$itemQTY=1);
									}
									
								if (($i != 1) && ($i != 0) && ($i % 3 == 0)) {
						?>


					</div>
					<div class="item-row">
					<?php } ?>

					<div class="item item-thumbnail">
						<a href="{{route('productDetail', $item->slug)}}" class="item-image">
							<img src="{{$itemImg}}" alt="" />
							<?php if($totalOff != 0){?>
								<div class="discount">{{$totalOff}}% OFF </div>
							<?php }?>
						</a>
						<div class="item-info">
							<h4 class="item-title">
								<a href="{{route('productDetail', $item->slug)}}">{{$item->item_name}}</a>
							</h4>
							<p class="item-desc">{!! \Str::limit(strip_tags($item->description),100,'...') !!}</p>
							<?php
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
									if($totalOff == 0){
								?>
		
									<div class="item-price itm-pr">
										Offer Price: ₹ {{($item->regular_price)? $item->regular_price:0}}
									</div>
									@if($item->item_mrp)
									<div class="item-discount-price itm-dpr">MRP: 
										<span>₹ {{($item->item_mrp)? $item->item_mrp:''}}<span>
									</div>
									@endif
								
								<?php }else{ ?>

									<div class="item-price itm-pr">
										Offer Price: ₹ {{$AfterDiscountPrice}}
									</div>

									@if($item->item_mrp)
										<div class="item-discount-price itm-dpr">	 
											MRP: 
											<span> ₹ {{($item->item_mrp)? $item->item_mrp:''}}</span>
										</div>
										@endif

									<!-- <div class="item-discount-price">₹{{($item->regular_price)? $item->regular_price:0}}</div> -->
									
									
									<?php }?>
									
									@if($retailPrice)
									<div class="itm-rlm">
										<span>{{$retailPrice}}%</span> Retail margin</div>
									@endif

								<a href="javascript:void(0)" onclick="add_to_cart(<?= $item->item_id ?>)" class="btn btn-inverse">ADD TO CART</a>



							<?php } ?>
						</div>
					</div>




			<?php $i++;
							}
						} ?>
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

<!-- BEGIN #tablet-list -->

<!-- END #tablet-list -->

<!-- BEGIN #policy -->
<div id="policy" class="section-container bg-white ftr-box">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN row -->
		<div class="row">
			<!-- BEGIN col-4 -->
			<div class="col-lg-3 col-md-3 mb-3 mb-md-0">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-certificate" aria-hidden="true"></i></div>
					<div class="policy-info">
						<h4>No compromise on quality</h4>
						<p>Best quality Food Graded Stainless Steel Easy To Maintain Top quality Polish & Finish Zero Defect product. </p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<!-- END col-4 -->
			<!-- BEGIN col-4 -->
			<div class="col-lg-3 col-md-3 mb-3 mb-md-0">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-handshake"></i></div>
					<div class="policy-info">
						<h4>Great customisation opportunity</h4>
						<p>Wide range for all classes Great product for Corporate gifting as per their need Customize your product as per your price and need.</p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<!-- END col-4 -->
			<!-- BEGIN col-4 -->
			<div class="col-lg-3 col-md-3">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fas fa-rupee-sign"></i></div>
					<div class="policy-info">
						<h4>Competitive pricing</h4>
						<p>Availble in all price and range in the market Competitive Price with better quality Having Pan India Presence with more than 5000 dealer distributor network.</p>
					</div>
				</div>
				<!-- END policy -->
			</div>
			<div class="col-lg-3 col-md-3">
				<!-- BEGIN policy -->
				<div class="policy">
					<div class="policy-icon"><i class="fa fa-truck"></i></div>
					<div class="policy-info">
						<h4>Committed to make timely delivery of products</h4>
						<p>Best Logistic Support Honour Commitment and customer service. </p>
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
<!-- <div id="subscribe" class="section-container">
	
	<div class="container">
		
		<div class="row">
			
			<div class="col-md-6 mb-4 mb-md-0">
				
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
				
			</div>
			
			<div class="col-md-6">
				
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
				
			</div>
			
		</div>
		
	</div>

</div> -->
<!-- END #subscribe