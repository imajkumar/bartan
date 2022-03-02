<?php
    $cartCollection = \Cart::getContent();

    $dataCartInArr = $cartCollection->toArray();


    // die;
    ?>

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
                    <a href="javascript:void(0)" onclick="removeItemFromCart({{$rowData['id']}})" data-toggle="tooltip"
                        data-title="">&times;</a>
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