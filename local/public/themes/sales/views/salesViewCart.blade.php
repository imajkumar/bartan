<!-- <style>
    input.razorpay-payment-button {
        display: none;
    }

    .container {
        margin-left: 209px;
        margin-top: -60px;
    }


</style> -->
<?php 

    @$customerForSalesPanel = session()->get('customerForSalesPanel');
    $users = DB::table('tbl_customers')->where('user_id', @$customerForSalesPanel->user_id)->first();
    //pr($customerForSalesPanel);
?>
<div class="content" id="checkout-cart">

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
           
            <?php
                // if(trim(@$users->payment_option) === "Online payment"){
                ?>
                <form action="{{ route('codOrCreditOrderBySales') }}" id="paymentBySales" method="POST">
                <!-- <form action="{{ route('paymentBySales') }}" id="paymentBySales" method="POST"> -->
               <?php //}else{?>
                <!-- <form action="{{ route('codOrCreditOrderBySales') }}" id="paymentBySales" method="POST"> -->
               
               <?php // }?>
            <!-- <form action="{{ route('paymentBySales') }}" id="paymentBySales" method="POST"> -->
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
                                <th class="text-center">Basic</th>
                                <!-- <th class="text-center">Amount</th> -->
                                <?php
                                // $users = DB::table('tbl_customers')->where('user_id', @$customerForSalesPanel->user_id)->first();
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


                            $deliveryCharg = 0; 
                            $deliveryChargRate = 0;
                            $deliveryChargDiscount = 0;
                            $deliveryChargNetRate = 0;
                            $deliveryChargBasic = 0;
                            $deliveryChargCGST = 0;
                            $deliveryChargSGST = 0;
                            $deliveryChargIGST = 0;
                            $deliveryChargAmount = 0;

                            $packingCharg = 0;
                            $packingChargRate = 0;
                            $packingChargDiscount = 0;
                            $packingChargNetRate = 0;
                            $packingChargBasic = 0;
                            $packingChargCGST = 0;
                            $packingChargSGST = 0;
                            $packingChargIGST = 0;
                            $packingChargAmount = 0;

                            @$customerDetail = session()->get('customerForSalesPanel');

                            foreach ($cartCollection->toArray() as $key => $rowData) {
                                

                                $productArr = DB::table('tbl_items')->where('item_id', $rowData['id'])->select('invt_saleunit','is_tax_included', 'cat_id','regular_price', 'item_invt_min_order','item_cart_remarks')->first();
                                //echo $rowData['id'];pr($productArr);
                                $DisacoutArrData = getDiscountAppliedByProductID(@$customerForSalesPanel->user_id, $rowData['id'], $rowData['quantity']);
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
                                //$subTotalAmt = $subTotalAmt + $netAmtount;
                                $itemQTY = $rowData['quantity'];


                                $taxArrData = getTaxAppliedByProductID(@$customerForSalesPanel->user_id, $rowData['id'], $rowData['quantity']);


                                if($productArr->is_tax_included == 1){
                                    if (@$users->cutomer_state == 10) {
                                     $totTaxSum= $taxArrData['cgst_p']+ $taxArrData['sgst_p'];
 
                                     // $netAmtount=$netAmtount/112*100;
                                     $netAmtount=$netAmtount/($totTaxSum+100)*100;
 
                                    }else{
                                  $totTaxSum= $taxArrData['igst_p'];
 
                                 // $netAmtount=$netAmtount/112*100;
                                 $netAmtount=$netAmtount/($totTaxSum+100)*100;
                                    }
                                 
                                 
                                
                             
                             }


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
                                //$grandTotal = $grandTotal + $totalAmount;

                                //Start Charges ----
                                

                                @$deliveryChargRate =   @$deliveryChargRate + ($netAmtount * @$users->delivery_charge)/100;
                                      
                                       
                                @$packingChargRate = $packingChargRate + ($netAmtount * $users->packing_charge)/100;

                                @$deliveryChargDiscount = ($deliveryChargRate * $users->delivery_discount)/100;
                                @$packingChargDiscount = ($packingChargRate * $users->packing_discount)/100;
                                
                                @$deliveryChargNetRate = ($deliveryChargRate - $deliveryChargDiscount);
                                @$packingChargNetRate = ($packingChargRate - $packingChargDiscount);
                                
                                @$deliveryChargBasic = $deliveryChargNetRate;
                                @$packingChargBasic = $packingChargNetRate;

                                $maxCgst = 0;
                                if($taxArrData['cgst_p'] >= $maxCgst){
                                    $maxCgst = $taxArrData['cgst_p'];
                                }
                                //echo $maxCgst;
                                $maxSgst = 0;
                                if($taxArrData['sgst_p'] >= $maxSgst){
                                    $maxSgst = $taxArrData['sgst_p'];
                                }

                                $maxIgst = 0;
                                if($taxArrData['igst_p'] >= $maxIgst){
                                    $maxIgst = $taxArrData['igst_p'];
                                }

                                // if($productArr->is_tax_included == 1){
                                    if (@$users->cutomer_state == 10) {
                                     
                                       
                                        $deliveryChargCGST= ($deliveryChargNetRate * $maxCgst)/100;
                                        $packingChargCGST= ($packingChargNetRate * $maxCgst)/100;

                                        $deliveryChargSGST= ($deliveryChargNetRate * $maxSgst)/100;
                                        $packingChargSGST= ($packingChargNetRate * $maxSgst)/100;

                                        $deliveryChargAmount = $deliveryChargNetRate + ($deliveryChargSGST + $deliveryChargCGST);
                                        $packingChargAmount = $packingChargNetRate + ($packingChargSGST + $packingChargCGST);
 
                                    }else{
                                        $deliveryChargIGST= ($deliveryChargNetRate * $maxIgst)/100;
                                        $packingChargIGST= ($packingChargNetRate * $maxIgst)/100;

                                        $deliveryChargAmount = $deliveryChargNetRate + $deliveryChargIGST;
                                        $packingChargAmount = $packingChargNetRate + $packingChargIGST;
                                    }
                                 
                                // }
                            
                               
                                $subTotalAmt = $subTotalAmt + $netAmtount;

                                //End charges


                               
                               
                                

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
                            <input type="hidden" name="setOfForOrder[{{$rowData['id']}}]" value="{{@$rowData['attributes']['set_of']}}" />
                            
                            <!-- <input type="hidden" name="totalPrice[{{$rowData['id']}}][]" value="{{($rowData['quantity'])*($rowData['price'])}}" /> -->
                            <input type="hidden" name="totalPrice[{{$rowData['id']}}][]" value="{{round($netAmtount, 2)}}" />
                            <input type="hidden" name="prices[{{$rowData['id']}}][]" value="{{round($rowData['price'], 2)}}" />
                            <input type="hidden" name="units[{{$rowData['id']}}][]" value="{{$productArr->invt_saleunit}}" />
                            <input type="hidden" name="discounts[{{$rowData['id']}}]" value="{{round($disAmt, 2)}}" />
                            <input type="hidden" name="netRates[{{$rowData['id']}}][]" value="{{round($netAmt,2)}}" />
                            
                            
                            {{-- <input type="hidden" name="totalAmount" value="{{($taxAmtCount)+\Cart::getSubTotal()}}" /> --}}
                            <!-- <input type="hidden" name="totalAmount" value="{{\Cart::getSubTotal()}}" /> -->
                            <input type="hidden" name="totalAmount[{{$rowData['id']}}]" value="{{round($totalAmount, 2)}}" />
                            
                           
                            
                            <!-- <input type="hidden" name="grandTotal" value="{{$grandTotal}}" />
                            <input type="hidden" name="subTotalAmt" value="{{$subTotalAmt}}" /> -->
                                
                            <input type="hidden" name="cgst[{{$rowData['id']}}]" value="{{round($CGST_H, 2)}}" />
                            <input type="hidden" name="sgst[{{$rowData['id']}}]" value="{{round($SGST_H, 2)}}" />
                            <input type="hidden" name="igst[{{$rowData['id']}}]" value="{{round($IGST_H, 2)}}" />
                            <!-- <input type="hidden" name="taxAmtIGST" value="{{$taxAmtIGST}}" />
                            <input type="hidden" name="taxAmtCGST" value="{{$taxAmtCGST}}" />
                            <input type="hidden" name="taxAmtSGST" value="{{$taxAmtSGST}}" /> -->

                                <tr>
                                    <td>  
                                           <a href="#" onclick="removeItemFromCart({{$rowData['id']}})" data-toggle="tooltip" data-title="Remove">&times;</a>
                                        </td>
                                    <td class="cart-product">
                                        <div class="product-img">
                                            <img src="{{$itemImg}}" alt="{{$rowData['name']}}">
                                        </div>
                                        <div class="product-info">
                                            <div class="title">{{$rowData['name']}}</div>
                                            <p>{!! @$productArr->item_cart_remarks !!}</p>
                                        </div>
                                    </td>



                                    <td class="cart-qty text-center">

                                        <div class="cart-qty-input">
                                            <?php
                                            if ($rowData['quantity'] == 1) {
                                            // if ($rowData['quantity'] == 1  || $rowData['quantity'] == $productArr->item_invt_min_order) {
                                            ?>

                                                <a href="#" class="qty-control left disabled" data-click="decrease-qty"><i class="fa fa-minus"></i></a>

                                            <?php } else { ?>

                                                <a href="#" class="qty-control left disabled" onclick="decreaseQTY({{$rowData['id']}})" data-click="decrease-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-minus"></i></a>

                                            <?php } ?>

                                            <input type="text" name="qty" id="qty{{$rowData['id']}}" onfocusout="increseQTYOnKeyPress({{$rowData['id']}})" value="<?php echo $rowData['quantity']; ?>" class="form-control">
                                            
                                            <?php if(@$rowData['attributes']['set_of'] != 0){?>
                                                <br><input type="text" name="set_of" id="set_of" value="<?php echo @$rowData['attributes']['set_of']; ?>" class="form-control" readonly>
                                                Pcs
                                            <?php }?>
                                            
                                            <!-- <input type="text" name="qty" id="qty{{$rowData['id']}}"  value="<?php echo $rowData['quantity']; ?>" class="form-control"> -->
                                            <a href="javascript:void()" class="qty-control right disabled" onclick="increseQTY({{$rowData['id']}})" data-click="increase-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-plus"></i></a>
                                        </div>

                                        <!-- <div class="qty-desc">11 to max order</div> -->
                                    </td>

                                    <td class="cart-price text-center">{{$productArr->invt_saleunit}}</td>
                                    <td class="cart-price text-center">{{$rowData['price']}}</td>
                                    <td class="cart-price text-center">{{$disAmt}}</td>
                                    <td class="cart-price text-center">{{$netAmt}}</td>

                                    <td class="cart-total text-center">
                                        {{round($netAmtount, 2)}}
                                    </td>

                                    <!-- <td class="cart-total text-center">
                                        {{$netAmtount}}
                                    </td> -->
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
                              <td class="cart-price"> Packaging Charges </td>


                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                   
                                    <td class="cart-price text-center">{{round($packingChargRate, 2)}}</td>
                                    <td class="cart-price text-center">{{round($packingChargDiscount, 2)}}</td>
                                    <td class="cart-price text-center">{{round($packingChargNetRate, 2)}}</td>
                                    <td class="cart-price text-center">{{round($packingChargBasic, 2)}}</td>
                                    <?php
                                    if (@$users->cutomer_state == 10) {
                                    ?>
                                        <td class="cart-price text-center">{{round($packingChargCGST, 2)}}</td>
                                    <td class="cart-price text-center">{{round($packingChargSGST, 2)}}</td>
                                       
                                    <?php
                                    } else {
                                    ?>
                                       <td class="cart-price text-center">{{round($packingChargIGST, 2)}}</td>
                                       
                                    <?php
                                    }

                                    ?>
                                    
                                    <td class="cart-price text-center">{{round($packingChargAmount, 2)}}</td>
                             </tr>
                             <tr>
                              <td class="cart-price"> Delivery Charge</td>


                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    
                                    <td class="cart-price text-center">{{round($deliveryChargRate, 2)}}</td>
                                    <td class="cart-price text-center">{{round($deliveryChargDiscount, 2)}}</td>
                                    <td class="cart-price text-center">{{round($deliveryChargNetRate, 2)}}</td>
                                    <td class="cart-price text-center">{{round($deliveryChargBasic, 2)}}</td>
                                    <?php
                                    if (@$users->cutomer_state == 10) {
                                    ?>
                                       <td class="cart-price text-center">{{round($deliveryChargCGST, 2)}}</td>
                                    <td class="cart-price text-center">{{round($deliveryChargSGST, 2)}}</td>
                                       
                                    <?php
                                    } else {
                                    ?>
                                       <td class="cart-price text-center">{{round($deliveryChargIGST, 2)}}</td>
                                       
                                    <?php
                                    }

                                    ?>
                                    <td class="cart-price text-center">{{round($deliveryChargAmount, 2)}}</td>
                             </tr>

                            <tr>
                                <td class="cart-summary" colspan="12">
                                    <div class="summary-container">
                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <?php 
                                            $subTotalAmt = $subTotalAmt + $deliveryChargBasic + $packingChargBasic;
                                            $taxAmtIGST = $taxAmtIGST + ($deliveryChargIGST + $packingChargIGST);
                                            $taxAmtCGST = $taxAmtCGST + ($deliveryChargCGST + $packingChargCGST);
                                            $taxAmtSGST = $taxAmtSGST + ($deliveryChargSGST + $packingChargSGST);
                                            $grandTotal = $grandTotal + $subTotalAmt + $taxAmtIGST + $taxAmtCGST + $taxAmtSGST;
                                            ?>

                            <input type="hidden" name="deliveryChargRate" value="{{round($deliveryChargRate, 2)}}" />
                            <input type="hidden" name="deliveryChargDiscount" value="{{round($deliveryChargDiscount, 2)}}" />
                            <input type="hidden" name="deliveryChargNetRate" value="{{round($deliveryChargNetRate, 2)}}" />
                            <input type="hidden" name="deliveryChargBasic" value="{{round($deliveryChargBasic, 2)}}" />
                            <input type="hidden" name="deliveryChargCGST" value="{{round($deliveryChargCGST,2)}}" />
                            <input type="hidden" name="deliveryChargSGST" value="{{round($deliveryChargSGST, 2)}}" />
                            <input type="hidden" name="deliveryChargIGST" value="{{round($deliveryChargIGST, 2)}}" />
                            <input type="hidden" name="deliveryChargAmount" value="{{round($deliveryChargAmount, 2)}}" />
                            
                            <input type="hidden" name="packingChargRate" value="{{round($packingChargRate, 2)}}" />
                            <input type="hidden" name="packingChargDiscount" value="{{round($packingChargDiscount, 2)}}" />
                            <input type="hidden" name="packingChargNetRate" value="{{round($packingChargNetRate, 2)}}" />
                            <input type="hidden" name="packingChargBasic" value="{{round($packingChargBasic, 2)}}" />
                            <input type="hidden" name="packingChargCGST" value="{{round($packingChargCGST, 2)}}" />
                            <input type="hidden" name="packingChargSGST" value="{{round($packingChargSGST, 2)}}" />
                            <input type="hidden" name="packingChargIGST" value="{{round($packingChargIGST, 2)}}" />
                            <input type="hidden" name="packingChargAmount" value="{{round($packingChargAmount, 2)}}" />
                            
                            
                                            
                                            <input type="hidden" name="grandTotal" value="{{round($grandTotal, 2)}}" />
                                            <input type="hidden" name="subTotalAmt" value="{{round($subTotalAmt, 2)}}" />
                                            <input type="hidden" name="taxAmtIGST" value="{{round($taxAmtIGST, 2)}}" />
                                            <input type="hidden" name="taxAmtCGST" value="{{round($taxAmtCGST, 2)}}" />
                                            <input type="hidden" name="taxAmtSGST" value="{{round($taxAmtSGST, 2)}}" />

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

                                        <!-- <div class="summary-row total">
                                            <div class="field">Grand Total</div>
                                            <div class="value">{{round($grandTotal, 2)}}</div>
                                        </div> -->

                                        <!-- <div class="summary-row m-t-40">
                                            <div class="field p-r-10">Payment option</div>
                                            <div class="value">
                                                <select class="form-control" name="payment_option">
                                                    <option value="">Select Payment Option</option>
                                                    <option value="100% ADVANCE">100% ADVANCE</option>
                                                    <option value="COD">COD</option>
                                                    <option value="Card Payment">Card Payment</option>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="summary-row m-t-40">
                                            <div class="field p-r-10">Dealer target </div>
                                            <div class="value">
                                                {{@$users->dealer_target}}
                                            </div>
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
                <?php 
                if($subTotalAmt < trim(@$users->minimum_order))
                {
                    echo "Your minimum order must be ".trim(@$users->minimum_order).' Without GST rate.';
                
                /*
                else{
                if(count($cartCollection)>0){

                    
                    if(trim(@$users->payment_option) === "Online payment"){
                        */
                ?>

                
                
                    <!-- <button type="submit" id="processOrder" class="btn btn-inverse width-200 "><span id="loadSpin" style="display:none"><i class="fas fa-spinner fa-pulse"></i></span> ORDER NOW</button> -->
               
                
               
                
               <?php }else{
                   ?>
               
                <button type="submit" id="processOrder" class="btn btn-inverse btn-md width-200"><span id="loadSpin" style="display:none"><i class="fas fa-spinner fa-pulse"></i></span>Add To Customer Cart</button>
               <?php }
               ?>
                
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
                
                <?php //}}?>
            </div>
           
                <!-- <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('RAZOR_KEY') }}" data-amount="{{($grandTotal)*100}}" data-currency="INR" data-buttontext="PAY NOW" data-name="Bartanwaale.com" data-description="Rozerpay" data-image="{{asset('assets/img/logo/logo.png')}}" data-prefill.name="Customer name" data-prefill.email="Customeremail@customer.com" data-theme.color="#00000">
                </script>
                 -->

        </form>
    
            </div>
                

    </div>

</div>