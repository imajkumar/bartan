
<?php
        if(Auth::user()){

            $login = "true";
            if(Auth::user()->user_type ==0){

                if(Auth::user()->profile == 1){

                    $kyc = 'true';

                }else{

                    $kyc = 'false';
                }

                $customerdetail = get_custumer_by_user_id(Auth::user()->id);

                if(!empty($customerdetail->profile_pic) )
                {
                    
                    $profil_pic = asset('/'.ITEM_IMG_PATH.'/'.$customerdetail->profile_pic);
                }else{
                    
                    $profil_pic = BACKEND.'img/user/user-4.jpg';
                }
            }else{

                $kyc = 'true';
                $profil_pic = BACKEND.'img/user/user-4.jpg';
            }


        }else{

            $kyc = 'false';
            $profil_pic = BACKEND.'img/user/user-4.jpg';
            $login = "false";
        }
    
        


?>

<!-- <div id="page-container" class="fade">

<div id="top-nav" class="top-nav">


</div> -->
<div id="page-container" class="fade show">


    <div id="header" class="header" data-fixed-top="true">
        <!-- BEGIN container -->
        <div class="container">
            <!-- BEGIN header-container -->
            <div class="header-container">
                <!-- BEGIN navbar-toggle -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- END navbar-toggle -->
                <!-- BEGIN header-logo -->

                <!-- <label for="menu" class="menu menu-overlay">
              <span></span>
               <span></span>
               <span></span>
              </label>
-->

                <div class="menu-overlay"> </div>
                <div class="header-logo">
                    <a href="{{asset('/')}}">
                        <img src="{{asset('assets/img/logo/logo.png')}}" alt="">

                    </a>
                </div>
              <!--   <a href="#" class="menu-open"><img src="{{asset('assets/img/icon/menu.svg')}}" class="user-icon" alt=""></a> -->
               
              

              
                <!-- END header-logo -->
                <!-- BEGIN header-nav -->
                <div class="header-nav">
                    <div class=" collapse navbar-collapse" id="navbar-collapse">
                        <ul class="nav">

                            <li class="dropdown  dropdown-full-width dropdown-hover">
                                <a href="#" data-toggle="dropdown">
                                    <i class="fas fa-store"></i> <strong>Our Store</strong>
                                    <b class="caret"></b>
                                    <span class="arrow top"></span>
                                </a>
                                <!-- BEGIN dropdown-menu -->
                                <div class="dropdown-menu dropdown-scroll p-0">
                                    <!-- BEGIN dropdown-menu-container -->
                                    <div class="dropdown-menu-container">

                                        <!-- BEGIN dropdown-menu-content -->
                                        <div class="dropdown-menu-content">
                                        
                                            <div class="row">
                                              <!--   <div class="col-lg-12">
                                                    <ul class="dropdown-menu-list">
                                                        <?php
                                                        $itemCategories = getItemCategory();
                                                        foreach ($itemCategories as $itemCategory) {

                                                            $itemsInCategory = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $itemCategory->id);
                                                                if(count($itemsInCategory) != 0){
                                                        ?>
                                                            <li><a id="{{ $itemCategory->id}}" class="" href="{{route('getItemsByCatId', $itemCategory->id)}}">{{ucfirst($itemCategory->item_name)}}</a></li>

                                                        <?php }} ?>


                                                    </ul>
                                                </div> -->



                                                    <!-- <div class="col-lg-3"> -->
                                                        
                                                    <?php
                                                   
                                                   $dataGroups = DB::table('tbl_group')->orderBy('g_id', 'DESC')->get();
                                                   $i=1;
                                                   //pr($dataGroups);
                                                   foreach($dataGroups as $dataGroup){
                                                       $dataItemCats = DB::table('tbl_item_category')->where('item_under_group_id', $dataGroup->g_id)->orderBy('id', 'DESC')->get();
                                                       
                                                       //$dataItemCatCheck = DB::table('tbl_item_category')->where('item_under_group_id', $dataGroup->g_id)->orderBy('id', 'DESC')->get();
                                                       
                                                       if(count(@$dataItemCats)>0){
                                                           $itemExistInGroupCat = array();
                                                        foreach($dataItemCats as $itemCategory){ 
                                                            $itemsInCategoryCheck = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $itemCategory->id);
                                                            if(count($itemsInCategoryCheck) != 0){
                                                                $itemExistInGroupCat[] = $itemCategory->id;
                                                            }
                                                        }
                                                        if(count($itemExistInGroupCat)>0){
                                                           //if(($i != 1) && ($i != 0) && ($i % 4==0)){
                                                   ?>
                                                   <!-- </div> -->
                                                   <!-- </div> -->
                                                   <!-- <div class="row"> -->
                                                       <!-- <div class="col-lg-3"> -->
                                                  
                                                   <div class="col-lg-3">
                                                   
                                                       <!-- <h4 class="title-heading">{{$dataGroup->g_name}}</h4> -->
                                                       
                                                       <ul class="dropdown-menu-list">
                                                       <?php
                                                           foreach($dataItemCats as $itemCategory){ 
                                                            $itemsInCategoryCheck = get_itemsByCatOrBrandId($flag='Category', $limit=-1, $itemCategory->id);
                                                            if(count($itemsInCategoryCheck) != 0){
                                                       ?>
                                                           <li><a  id="{{ $itemCategory->id}}" href="{{route('getItemsByCatId', $itemCategory->id)}}"><i class="fa fa-fw fa-angle-right text-muted"></i>{{ucfirst($itemCategory->item_name)}}</a></li>
                                                           
                                                           
                                                       <?php } }?>
                                                       </ul>
                                                       </div>
                                               <?php  $i++;}}} ?>
                                               
                                               <?php //} ?>

                                                    </div>
                                                   
                                                  
                                                    
                                               



                                            
                                            <!-- <h4 class="title">Shop By Brand</h4>
                                            <ul class="dropdown-brand-list m-b-0">
                                                <?php
                                                $brands = getBarnds();
                                                foreach ($brands as $brand) {
                                                    if ($brand->brand_img) {
                                                        $brandImg =  BASE_URL . ITEM_IMG_PATH . '/' . $brand->brand_img;

                                                ?>
                                                        <li><a id="{{$brand->id}}" href="{{route('getItemsByBrandId', $brand->id)}}"><img src="{{$brandImg}}" alt="" /></a></li>
                                                        {{-- <li><a id="{{$brand->id}}" href="javascript:void();"><img src="{{$brandImg}}" alt="" /></a>
                            </li> --}}
                    <?php }
                                                } ?>

                        </ul> -->
                    </div>
                    <!-- END dropdown-menu-content -->
                </div>
                <!-- END dropdown-menu-container -->
            </div>
            <!-- END dropdown-menu -->
            </li>


            <li class="" style="width: 480px;">
                <form style="margin-top:20px" action="{{route('searchKeyword')}}" method="get" id="searchForm" name="searchForm">

                    <div class="input-group">
                        <input type="text" name="keyword" placeholder="Search" class="form-control bg-silver-lighter" />
                        <div class="input-group-append">
                            <button class="btn btn-inverse" type="submit"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
            </ul>
        </div>
    </div>
    <!-- END header-nav -->
    <?php
    $cartCollection = \Cart::getContent();

    $dataCartInArr = $cartCollection->toArray();


    // die;
    ?>
    <!-- BEGIN header-nav -->
    <div class="header-nav">
        <ul class="nav pull-right">
            <?php
                if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
            ?>
            <li class="dropdown dropdown-hover">
                <a href="#" class="header-cart" data-toggle="dropdown">
                
                    <i class="fa fa-shopping-bag"></i>
                    <span class="total" id="total">{{$cartCollection->count()}}</span>
                    <span class="arrow top"></span>
                </a>

               <div class="vwcrtdgn dropdown-menu dropdown-menu-cart p-0">
                    <div class="cart-header">
                        <h4 class="cart-title" id="totalWithBag">Shopping Bag ({{$cartCollection->count()}}) </h4>
                       
                    </div>
                    <div class="cart-body ">
                        <ul class="dropdown-scroll cart-item" id="htmlItemDataAppend">
                            <?php
                            foreach ($dataCartInArr as $key => $rowData) {

                                $itemImages = get_item_default_img_item_id($rowData['id']);

                                if ($itemImages) {

                                    $itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
                                } else {

                                    $itemImg = FRONT . 'img/product/product-iphone.png';
                                }
                                $itemDetail = DB::table('tbl_items')->where('item_id', $rowData['id'])->select('cat_id')->first();
                                //pr($itemDetail);
                                @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $itemDetail->cat_id);
                                @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $itemDetail->cat_id);
                                @$AfterDiscountPrice = calculateItemDiscount($rowData['price'], $custClassDiscount, $custCatDiscount);
                               
                                $totalOff = $custCatDiscount + $custClassDiscount;
                            ?>
                                <li>
                                    <div class="cart-item-image"><img src="{{$itemImg}}" alt="" /></div>
                                    <div class="cart-item-info">
                                        <h4>{{$rowData['name']}}</h4>
                                        <p class="price">
                                            <i class="fa fa-inr" aria-hidden="true"></i>
                                            <!-- {{$rowData['price']}} -->
                                          {{@$AfterDiscountPrice}}
                                        </p>
                                    </div>
                                    <div class="cart-item-close">
                                        <a href="javascript:void(0)" onclick="removeItemFromCart({{$rowData['id']}})" data-toggle="tooltip" data-title="Remove">&times;</a>
                                    </div>
                                </li>

                            <?php
                            }

                            ?>



                        </ul>
                    </div>
                    <div class="cart-footer">
                        <div class="row row-space-10">
                            <div class="col-12">
                                <a href="{{route('view_cart')}}" class="btn btn-inverse  btn-block">View Cart</a>

                            </div>
                           <!--  <div class="col-6">
                                <a href="javascript:void();" class="btn btn-inverse btn-theme btn-block">Checkout</a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </li>
            <li class="divider"></li>
            <?php  } ?>

           
            <li class="dropdown dropdown-hover">
                <?php
                if (Auth::guest()) {
                ?>
                    <a href="javascript:void(0);" data-toggle="dropdown">
                        <img src="{{$profil_pic ?? ''}}" class="user-img" alt="" />
                        <span class="d-none d-xl-inline" >Sign In</span>
                          <b class="caret"></b>
                                        <span class="arrow top"></span>
                    </a>

                    <div class="dropdown-menu">
                                     

                        <ul class="dropdown-item-menu">
                       
                            <li><a href="{{route('aboutUs')}}" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/order.svg')}}" class="user-icon" alt=""> About Us</a></li>
                            <li><a href="{{route('refundPolicy')}}" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/order.svg')}}" class="user-icon" alt=""> Refund & Policy</a></li>
                      
                           
                            <li>

                                <a href="{{route('showCustomerLoginForm')}}" class="logout-clr btn btn-inverse"><img src="{{asset('assets/img/icon/logout.svg')}}" class="user-icon" alt=""> Login</a>
                                

                            </li>
                            <!-- <li><a href="#" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/token.svg')}}" class="user-icon" alt=""> Sell On Bartanwaala</a></li> -->

                        </ul>
                                      
                                    </div>

                 
                <?php
                } else {
                ?>





                    <a href="{{(@Auth::user()->user_type == 1 || @Auth::user()->user_type == 0)? route('dashboard') : route('SalesDashboard')}}">
                        <img src="{{$profil_pic ?? ''}}" class="user-img" alt="" />
                       
                        
                        <span class="d-none d-xl-inline">My Account </span>

                    </a>
                    
                    <div class="dropdown-menu">
                                     

                        <ul class="dropdown-item-menu">
                           <li class="flow-name"><a href=""><span class="font-weith">{{ucfirst(Auth::user()->name)}} </span> 
                                                   <span class="m-t-0">{{(@$customerdetail->customer_type == 1)? 'Dealer':((@$customerdetail->customer_type == 2)? 'Wholesaler':((@$customerdetail->customer_type == 3)? 'Distibuter':''))}} </span></a></li>

                        <li><a href="{{route('myOrderList')}}" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/order.svg')}}" class="user-icon" alt=""> Your Order</a></li>
                            <li><a href="{{route('myReturnOrder')}}" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/return.svg')}}" class="user-icon" alt=""> Your Return</a></li>
                            <li><a href="{{route('aboutUs')}}" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/order.svg')}}" class="user-icon" alt=""> About Us</a></li>
                      
                           
                            <li>

                                <a href="{{ route('logout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" class="logout-clr btn btn-inverse"><img src="{{asset('assets/img/icon/logout.svg')}}" class="user-icon" alt=""> Log Out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <!-- <a href="{{ route('customerLogout') }}" onclick="event.preventDefault();  document.getElementById('logout-form').submit();" class="logout-clr btn btn-inverse"><img src="{{asset('assets/img/icon/logout.svg')}}" class="user-icon" alt=""> Log Out</a>
                                <form id="logout-form" action="{{ route('customerLogout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form> -->

                            </li>
                            <!-- <li><a href="#" target="_blank" rel="nofollow"><img src="{{asset('assets/img/icon/token.svg')}}" class="user-icon" alt=""> Sell On Bartanwaala</a></li> -->

                        </ul>
                                      
                                    </div>
                <?php
                }
                ?>

            </li> 
        
        </ul>
    </div>
    <!-- END header-nav -->
</div>
<!-- END header-container -->
</div>
<!-- END container -->
</div>
