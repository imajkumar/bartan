<!-- BEGIN #header -->
<div id="header" class="header" style=" position: fixed;width:100%">

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
            <div class="menu-overlay"> </div>
            <a href="#" class="menu-open">
                <img src="assets/img/icon/menu.svg" class="user-icon" alt="">
            </a>

            <div class="side-menu-wrapper">
                <div class="profile-highlight">
                    <img src="https://images.unsplash.com/photo-1578976563986-fb8769ab695e?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=crop&amp;w=934&amp;q=80" alt="profile-img" width="36" height="36">
                    <div class="details">
                        <div id="profile-name">Kenny Lee</div>
                        <div id="profile-footer">Team Hallaway</div>
                    </div>
                </div>
                <a href="#" class="menu-close">×</a>
                <ul>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/order.svg" class="user-icon" alt=""> Your Order</a></li>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/return.svg" class="user-icon" alt=""> Your Return</a></li>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/rupee.svg" class="user-icon" alt=""> Rate Card</a></li>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/language.svg" class="user-icon" alt=""> Language</a></li>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/logout.svg" class="user-icon" alt=""> Logout</a></li>
                    <li><a href="#" target="_blank" rel="nofollow"><img src="assets/img/icon/token.svg" class="user-icon" alt=""> Sell On Bartanwaala</a></li>

                </ul>
            </div>
            <div class="header-logo">
                <a href="{{url('/')}}">
                   <img src="{{asset('assets/img/logo/logo.png')}}" alt="">
                </a>
            </div>
            <!-- END header-logo -->
            <!-- BEGIN header-nav -->
            <div class="header-nav">
                <div class=" collapse navbar-collapse" id="navbar-collapse">
                    <ul class="nav">

                        <li class="dropdown dropdown-full-width dropdown-hover">
                            <a href="#" data-toggle="dropdown">
                                Our Store
                                <b class="caret"></b>
                                <span class="arrow top"></span>
                            </a>
                            <!-- BEGIN dropdown-menu -->
                            <div class="dropdown-menu p-0">
                                <!-- BEGIN dropdown-menu-container -->
                                <div class="dropdown-menu-container">
                                    <!-- BEGIN dropdown-menu-sidebar -->
                                    <div class="dropdown-menu-sidebar">
                                        <h4 class="title">Shop By Categories</h4>
                                        <ul class="dropdown-menu-list">
                                            <?php
                                            $itemCategories = getItemCategory();
                                            foreach ($itemCategories as $itemCategory) {
                                            ?>
                                                <li><a id="{{ $itemCategory->id}}" class="" href="{{route('getItemsByCatId', $itemCategory->id)}}">{{ucfirst($itemCategory->item_name)}}</a></li>

                                            <?php } ?>


                                        </ul>
                                    </div>
                                    <!-- END dropdown-menu-sidebar -->
                                    <!-- BEGIN dropdown-menu-content -->
                                    <div class="dropdown-menu-content">
                                        <h4 class="title">Shop By Popular Phone</h4>
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <ul class="dropdown-menu-list">
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> iPhone 7</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> iPhone 6s</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> iPhone 6</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> iPhone 5s</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> iPhone 5</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-3">
                                                <ul class="dropdown-menu-list">
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Galaxy S7</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Galaxy A9</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Galaxy J3</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Galaxy Note 5</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Galaxy S7</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-3">
                                                <ul class="dropdown-menu-list">
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Lumia 730</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Lumia 735</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Lumia 830</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Lumia 820</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Lumia Icon</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-3">
                                                <ul class="dropdown-menu-list">
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Xperia X</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Xperia Z5</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Xperia M5</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Xperia C5</a></li>
                                                    <li><a href="product_detail.html"><i class="fa fa-fw fa-angle-right text-muted"></i> Xperia C4</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <h4 class="title">Shop By Brand</h4>
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


                    </ul>
                </div>
                <!-- END dropdown-menu-content -->
            </div>
            <!-- END dropdown-menu-container -->
        </div>
        <!-- END dropdown-menu -->
        </li>

        <li class="" style="width: 500px;">
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
        <li class="dropdown dropdown-hover">
            <a href="#" class="header-cart" data-toggle="dropdown">
                <i class="fa fa-shopping-bag"></i>
                <span class="total" id="total">{{$cartCollection->count()}}</span>
                <span class="arrow top"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-cart p-0">
                <div class="cart-header">
                    <h4 class="cart-title" id="totalWithBag">Shopping Bag ({{$cartCollection->count()}}) </h4>
                </div>
                <div class="cart-body">
                    <ul class="cart-item" id="htmlItemDataAppend">
                        <?php
                        foreach ($dataCartInArr as $key => $rowData) {

                            $itemImages = get_item_default_img_item_id($rowData['id']);

                            if ($itemImages) {

                                $itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
                            } else {

                                $itemImg = FRONT . 'img/product/product-iphone.png';
                            }
                        ?>
                            <li>
                                <div class="cart-item-image"><img src="{{$itemImg}}" alt="" /></div>
                                <div class="cart-item-info">
                                    <h4>{{$rowData['name']}}</h4>
                                    <p class="price">
                                        <i class="fa fa-inr" aria-hidden="true"></i>
                                        {{$rowData['price']}}
                                    </p>
                                </div>
                                <div class="cart-item-close">
                                    <a href="#" onclick="removeItemFromCart({{$rowData['id']}})" data-toggle="tooltip" data-title="Remove">&times;</a>
                                </div>
                            </li>

                        <?php
                        }

                        ?>



                    </ul>
                </div>
                <div class="cart-footer">
                    <div class="row row-space-10">
                        <div class="col-6">
                            <a href="{{route('view_cart')}}" class="btn btn-default btn-theme btn-block">View Cart</a>
                        </div>
                        <div class="col-6">
                            <a href="checkout_cart.html" class="btn btn-inverse btn-theme btn-block">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="divider"></li>
        <li>
            <a href="{{route('login')}}">
                <img src="{{FRONT.'img/user/user-1.jpg'}}" class="user-img" alt="" />
                <span class="d-none d-xl-inline">Login</span>
            </a>
        </li>
        <!-- <li>
                        <a href="{{route('showCustomerLoginForm')}}">
                            
                            <span class="d-none d-xl-inline">Customer login</span>
                        </a>
                    </li> -->
        {{-- <li>
                        <a href="{{route('salesLoginLayout')}}">

        <span class="d-none d-xl-inline">Sales login</span>
        </a>
        </li> --}}
    </ul>
</div>
<!-- END header-nav -->
</div>
<!-- END header-container -->
</div>
<!-- END container -->
</div>
<!-- END #header -->