<style>
    input.razorpay-payment-button {
        display: none;
    }

    .container {
        margin-left: 209px;
        margin-top: -60px;
    }


</style>
<?php 

    @$customerForSalesPanel = session()->get('customerForSalesPanel');
    //pr($customerForSalesPanel);
?>
<div class="section-container p-t-60" id="checkout-cart">

    <div class="container">
       
        <div class="checkout">
           

            <div class="checkout-header">

                <div class="row">

                    <div class="col-lg-3">
                        <div class="step active">
                            <a href="#">
                                <!-- <div class="number"></div> -->
                                <div class="info">
                                    <div class="title">Cart Details</div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <!-- <div class="col-lg-3">
                        <div class="step">
                            <a href="javascript:void();">
                                <div class="number">2</div>
                                <div class="info">
                                    <div class="title">Shipping Address</div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->


                    <!-- <div class="col-lg-3">
                        <div class="step">
                            <a href="javascript:void();">
                                <div class="number">3</div>
                                <div class="info">
                                    <div class="title">Payment</div>
                                    <div class="desc"> </div>
                                </div>
                            </a>
                        </div>
                    </div> -->

<!-- 
                    <div class="col-lg-3">
                        <div class="step">
                            <a href="javascript:void();">
                                <div class="number">4</div>
                                <div class="info">
                                    <div class="title">Complete Payment</div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
                    </div> -->

                </div>

            </div>
           
            <form action="{{ route('paymentBySales') }}" id="paymentBySales" method="POST">
                @csrf
                
            <div class="checkout-body">
                <div class="table-responsive">
                    <table class="table table-cart">
                        <thead>
                            <tr>
                                <th>Product Name</th>


                                <th class="text-center">Quantity</th>
                                <th class="text-center">Unit</th>
                                <th class="text-center">Rate</th>
                                <th class="text-center">Discount</th>
                                <th class="text-center">Net Rate</th>
                                <th class="text-center">Amount</th>
                                <?php
                                $users = DB::table('tbl_customers')->where('user_id', @$customerForSalesPanel->user_id)->first();
                                if (@$users->cutomer_state == 10) {
                                ?>
                                    <th class="text-center">CGST</th>
                                    <th class="text-center">SGST</th>
                                <?php
                                } else {
                                ?>
                                    <th class="text-center">IGST</th>
                                <?php
                                }

                                ?>


                                <th class="text-center">Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- layout of cart  -->
                            <?php

                            $cartCollection = \Cart::getContent()->sort();

                            $taxAmtCount = 0;
                            $taxAmtIGST = 0;
                            $taxAmtCGST = 0;
                            $taxAmtSGST = 0;
                            $IGST_H = 0;
                            $CGST_H = 0;
                            $SGST_H = 0;
                            $subTotalAmt = 0;
                            $grandTotal = 0;    
                            //ad
                            @$customerDetail = session()->get('customerForSalesPanel');

                            foreach ($cartCollection->toArray() as $key => $rowData) {

                                $productArr = DB::table('tbl_items')->where('item_id', $rowData['id'])->select('invt_saleunit', 'cat_id','regular_price', 'item_invt_min_order')->first();
                                $DisacoutArrData = getDiscountAppliedByProductID($customerForSalesPanel->user_id, $rowData['id'], $rowData['quantity']);
                                //ajay

                                //neeraj
                                @$custClassDiscount = getCustomerClassDiscount(@$customerDetail->user_id, $productArr->cat_id);
                                @$custCatDiscount = getCustomerCategoryDiscount(@$customerDetail->user_id, $productArr->cat_id);
                                @$AfterDiscountPrice = calculateItemDiscountForCart($productArr->regular_price, $custClassDiscount, $custCatDiscount);
                                
                                //$totalOff = $custCatDiscount + $custClassDiscount;
                               //echo @$AfterDiscountPrice;exit;

                                $disAmt = @$AfterDiscountPrice; 
                                 //neeraj
                                //$disAmt = $DisacoutArrData; //ajay


                                $netAmt = ($rowData['price']) - ($disAmt);
                                $netAmtount = $netAmt * $rowData['quantity'];
                                $subTotalAmt = $subTotalAmt + $netAmtount;
                                $itemQTY = $rowData['quantity'];


                                $taxArrData = getTaxAppliedByProductID($customerForSalesPanel->user_id, $rowData['id'], $rowData['quantity']);




                                if ($taxArrData['igst'] == 0) { //delhi customer 
                                    $IGST_H = 0;
                                    $CGST_H = (($netAmtount * $taxArrData['cgst_p']) / 100);
                                    $SGST_H = (($netAmtount * $taxArrData['sgst_p']) / 100);

                                    $txtAMTVAL = $CGST_H + $SGST_H;
                                } else {
                                    $IGST_H = (($netAmtount * $taxArrData['igst_p']) / 100);
                                    $CGST_H = 0;
                                    $SGST_H = 0;
                                    $txtAMTVAL = $IGST_H;
                                }
                                $totalAmount = $netAmtount + $txtAMTVAL;
                                $grandTotal = $grandTotal + $totalAmount;

                                $taxAmtCount = $taxAmtCount + $taxArrData['taxAmt'];

                                $taxAmtIGST = $taxAmtIGST + $IGST_H;
                                $taxAmtCGST = $taxAmtCGST + $CGST_H;
                                $taxAmtSGST = $taxAmtSGST + $SGST_H;


                                $itemImages = get_item_default_img_item_id($rowData['id']);

                                if ($itemImages) {

                                    $itemImg = BASE_URL . ITEM_IMG_PATH . '/' . $itemImages->img_name;
                                } else {

                                    $itemImg = FRONT . 'img/product/product-iphone.png';
                                }
                            ?>
                            <input type="hidden" name="itemIdForOder[]" value="{{$rowData['id']}}" />
                            <input type="hidden" name="quantityForOder[{{$rowData['id']}}][]" value="{{$rowData['quantity']}}" />
                            <!-- <input type="hidden" name="totalPrice[{{$rowData['id']}}][]" value="{{($rowData['quantity'])*($rowData['price'])}}" /> -->
                            <input type="hidden" name="totalPrice[{{$rowData['id']}}][]" value="{{$netAmtount}}" />
                            <input type="hidden" name="prices[{{$rowData['id']}}][]" value="{{$rowData['price']}}" />
                            <input type="hidden" name="units[{{$rowData['id']}}][]" value="{{$productArr->invt_saleunit}}" />
                            <input type="hidden" name="discounts[{{$rowData['id']}}]" value="{{$disAmt}}" />
                            <input type="hidden" name="netRates[{{$rowData['id']}}][]" value="{{$netAmt}}" />
                            
                            
                            {{-- <input type="hidden" name="totalAmount" value="{{($taxAmtCount)+\Cart::getSubTotal()}}" /> --}}
                            <!-- <input type="hidden" name="totalAmount" value="{{\Cart::getSubTotal()}}" /> -->
                            <input type="hidden" name="totalAmount[{{$rowData['id']}}]" value="{{$totalAmount}}" />
                            <input type="hidden" name="grandTotal" value="{{$grandTotal}}" />
                            <input type="hidden" name="subTotalAmt" value="{{$subTotalAmt}}" />
                                
                            <input type="hidden" name="cgst[{{$rowData['id']}}]" value="{{$CGST_H}}" />
                            <input type="hidden" name="sgst[{{$rowData['id']}}]" value="{{$SGST_H}}" />
                            <input type="hidden" name="igst[{{$rowData['id']}}]" value="{{$IGST_H}}" />
                            <input type="hidden" name="taxAmtIGST" value="{{$taxAmtIGST}}" />
                            <input type="hidden" name="taxAmtCGST" value="{{$taxAmtCGST}}" />
                            <input type="hidden" name="taxAmtSGST" value="{{$taxAmtSGST}}" />

                                <tr>
                                    <!-- <td>  
                                           <a href="#" onclick="removeItemFromCart({{$rowData['id']}})" data-toggle="tooltip" data-title="Remove">&times;</a>
                                        </td> -->
                                    <td class="cart-product">
                                        <div class="product-img">
                                            <img src="{{$itemImg}}" alt="{{$rowData['name']}}">
                                        </div>
                                        <div class="product-info">
                                            <div class="title">{{$rowData['name']}}</div>
                                            <!-- <div class="desc">Delivers Tue 26/04/2016 - Free</div> -->
                                        </div>
                                    </td>



                                    <td class="cart-qty text-center">

                                        <div class="cart-qty-input">
                                            <?php
                                            if ($rowData['quantity'] == 1  || $rowData['quantity'] == $productArr->item_invt_min_order) {
                                            ?>

                                                <a href="#" class="qty-control left disabled" data-click="decrease-qty"><i class="fa fa-minus"></i></a>

                                            <?php } else { ?>

                                                <a href="#" class="qty-control left disabled" onclick="decreaseQTY({{$rowData['id']}})" data-click="decrease-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-minus"></i></a>

                                            <?php } ?>

                                            <input type="text" name="qty" id="qty{{$rowData['id']}}" onfocusout="increseQTYOnKeyPress({{$rowData['id']}})" value="<?php echo $rowData['quantity']; ?>" class="form-control">
                                            <!-- <input type="text" name="qty" id="qty{{$rowData['id']}}"  value="<?php echo $rowData['quantity']; ?>" class="form-control"> -->
                                            <a href="#" class="qty-control right disabled" onclick="increseQTY({{$rowData['id']}})" data-click="increase-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <!-- <div class="qty-desc">11 to max order</div> -->
                                    </td>

                                    <td class="cart-price text-center">{{$productArr->invt_saleunit}}</td>
                                    <td class="cart-price text-center">{{$rowData['price']}}</td>
                                    <td class="cart-price text-center">{{$disAmt}}</td>
                                    <td class="cart-price text-center">{{$netAmt}}</td>

                                    <td class="cart-total text-center">
                                        {{$netAmtount}}
                                    </td>
                                    <?php
                                    if (@$users->cutomer_state == 10) {
                                    ?>
                                        <td class="cart-price text-center">{{round($CGST_H, 2)}}</td>
                                        <td class="cart-price text-center">{{round($SGST_H, 2)}}</td>
                                       
                                    <?php
                                    } else {
                                    ?>
                                        <td class="cart-price text-center">{{round($IGST_H, 2)}}</td>
                                       
                                    <?php
                                    }

                                    ?>


                                    <td class="cart-total text-center">
                                    {{round($totalAmount, 2) }}
                                    </td>





                                </tr>


                            <?php
                            }
                            ?>
                            <!-- layout of cart  -->

                            <tr>
                                <td class="cart-summary" colspan="12">
                                    <div class="summary-container">
                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <div class="value">{{round($subTotalAmt, 2)}}</div>
                                        </div>
                                        <?php
                                        if (@$users->cutomer_state == 10) {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">CGST</div>
                                                <div class="value">{{round($taxAmtCGST, 2)}}</div>
                                            </div>
                                            <div class="summary-row text-primary">
                                                <div class="field">SGST</div>
                                                <div class="value">{{round($taxAmtSGST, 2)}}</div>
                                            </div>

                                        <?php
                                        } else {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">IGST</div>
                                                <div class="value">{{round($taxAmtIGST, 2)}}</div>
                                            </div>
                                        <?php
                                        }
                                        ?>


                                        <div class="summary-row total">
                                            <div class="field">Grand Total</div>
                                            <div class="value">{{round($grandTotal, 2)}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="checkout-footer">
                <!-- <a href="{{url('/')}}" class="btn btn-white btn-lg pull-left btn-theme">CONTINUE SHOPPING</a> -->
               
                   

                    <!-- <button type="submit" class="btn btn-success btn-lg width-200 btn-theme">ORDER NOW</button> -->
                <?php if(count($cartCollection)>0){?>
                    <button type="submit" id="processOrder" class="btn btn-success btn-lg width-200 btn-theme"><span id="loadSpin" style="display:none"><i class="fas fa-spinner fa-pulse"></i></span> ORDER NOW</button>
                
                    <!-- <script src="https://checkout.razorpay.com/v1/checkout.js" 
                        data-key="{{ env('RAZOR_KEY') }}" 
                    
                        data-amount="{{(round($grandTotal, 2))*100}}" 
                        data-currency="INR" 
                        data-buttontext="PAY NOW" 
                        data-name="Bartanwaale.com" 
                        data-description="Rozerpay"
                        data-image="{{asset('assets/img/logo/logo.png')}}"
                        data-prefill.name="Customer name" 
                        data-prefill.email="Customeremail@customer.com" 
                        data-theme.color="#00000">
                    </script> -->
                
                <?php }?>
            </div>
           
                <!-- <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_KEY') }}" data-amount="{{($grandTotal)*100}}" data-currency="INR" data-buttontext="PAY NOW" data-name="Bartanwaale.com" data-description="Rozerpay" data-image="{{asset('assets/img/logo/logo.png')}}" data-prefill.name="Customer name" data-prefill.email="Customeremail@customer.com" data-theme.color="#00000">
                </script>
                 -->

        </form>
    
            </div>
                

    </div>

</div>