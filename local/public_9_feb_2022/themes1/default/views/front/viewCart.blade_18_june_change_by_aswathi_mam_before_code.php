<style>
    input.razorpay-payment-button {
        display: none;
    }
</style>
<?php
 $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first(); 
?>
<div class="section-container p-t-40" id="checkout-cart">

    <div class="container">
       
        <div class="checkout">
           

            <div class="checkout-header">

                <div class="row">

                    <div class="col-lg-3">
                        <div class="step active">
                            <a href="#">
                                <div class="number">1</div>
                                <div class="info">
                                    <div class="title">Details</div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="step">
                            <a href="javascript:void();">
                                <div class="number">2</div>
                                <div class="info">
                                    <div class="title">Shipping Address</div>
                                    <div class="desc"></div>
                                </div>
                            </a>
                        </div>
                    </div>


                    <div class="col-lg-3">
                        <div class="step">
                            <a href="javascript:void();">
                                <div class="number">3</div>
                                <div class="info">
                                    <div class="title">Payment</div>
                                    <div class="desc"> </div>
                                </div>
                            </a>
                        </div>
                    </div>


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
                    </div>

                </div>

            </div>
           
            <?php
                if(trim($users->payment_option) === "Online payment"){
                ?>
                <form action="{{ route('payment') }}" method="POST">
               <?php }else{?>
               
                <form action="{{ route('codOrCreditOrderByCustomer') }}" method="POST">
               <?php }?>
            <!-- <form action="{{ route('payment') }}" method="POST"> -->
                @csrf
                
                
            <div class="">
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
                                
                                <!-- <th class="text-center">Basic Rate</th> -->
                                <th class="text-center">Basic</th>
                                <?php
                                // $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first();
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
                            if(@$customerCartLists){
                                //pr(@$customerCartLists);
                                foreach($customerCartLists as $customerCartList){
                                    \Cart::remove($customerCartList->item_id); 
                                    $itemDataArr = DB::table('tbl_items')->where('item_id', $customerCartList->item_id)->first();
                                
                                    \Cart::add(array(
                                        'id' => $itemDataArr->item_id, // inique row ID
                                        'name' => $itemDataArr->item_name,
                                        'price' =>($itemDataArr->regular_price)? $itemDataArr->regular_price:0,
                                        'quantity' => ($customerCartList->qty)? $customerCartList->qty:$itemDataArr->item_invt_min_order,
                                        'attributes' => array()
                                    ));
                                }
                            }
                            $cartCollection = \Cart::getContent()->sort();
                           //pr($cartCollection );

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

                            foreach ($cartCollection->toArray() as $key => $rowData) {

                                $productArr = DB::table('tbl_items')->where('item_id', $rowData['id'])->select('invt_saleunit','is_tax_included', 'cat_id','regular_price', 'item_invt_min_order','item_cart_remarks')->first();
                                $DisacoutArrData = getDiscountAppliedByProductID(Auth::user()->id, $rowData['id'], $rowData['quantity']);
                                //ajay
                                
                                //neeraj
                                @$custClassDiscount = getCustomerClassDiscount(Auth::user()->id, $productArr->cat_id);
                                @$custCatDiscount = getCustomerCategoryDiscount(Auth::user()->id, $productArr->cat_id);
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


                                $taxArrData = getTaxAppliedByProductID(Auth::user()->id, $rowData['id'], $rowData['quantity']);

                               // pr($taxArrData);
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
                                            <p>{!! @$productArr->item_cart_remarks !!}</p>
                                            <!-- <div class="desc">Delivers Tue 26/04/2016 - Free</div> -->
                                        </div>
                                    </td>



                                    <td class="cart-qty text-center">

                                        <div class="cart-qty-input">
                                            <?php
                                            if ($rowData['quantity'] == 1 || $rowData['quantity'] == $productArr->item_invt_min_order) {
                                            ?>

                                                <a href="#" class="qty-control left disabled" data-click="decrease-qty"><i class="fa fa-minus"></i></a>

                                            <?php } else { ?>

                                                <a href="#" class="qty-control left disabled" onclick="decreaseQTY({{$rowData['id']}})" data-click="decrease-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-minus"></i></a>

                                            <?php } ?>

                                            <input type="text" name="qty" id="qty{{$rowData['id']}}" onfocusout="increseQTYOnKeyPress({{$rowData['id']}})" value="<?php echo $rowData['quantity']; ?>" class="form-control">
                                            <!-- <input type="text" name="qty" id="qty{{$rowData['id']}}" value="<?php echo $rowData['quantity']; ?>" class="form-control"> -->
                                            <a href="#" class="qty-control right disabled" onclick="increseQTY({{$rowData['id']}})" data-click="increase-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-plus"></i></a>
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

                                    <?php
                                    if ($users->cutomer_state == 10) {
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
                                            <div class="field p-r-10">Dealer target</div>
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
                <a href="{{url('/')}}" class="btn btn-inverse btn-md pull-left">Continue Buying</a>
               
                   
                <?php
                if($subTotalAmt < trim(@$users->minimum_order))
                {
                    echo "Your minimum order must be ".trim(@$users->minimum_order).' Without GST rate.';
                }else{

                if(trim($users->payment_option) === "Online payment"){
                ?>

                
                <button type="submit" class="btn btn-inverse btn-md width-200">Pay Now</button>
               
                
               
                
               <?php }else{?>
               
                <button type="submit" class="btn btn-inverse btn-md width-200">Submit Order</button>
               <?php }?>
                </div>
               
                <?php
                if(trim($users->payment_option) === "Online payment"){
                ?>
                <script src="https://checkout.razorpay.com/v1/checkout.js" 
                    data-key="{{ env('RAZOR_KEY') }}" 
                
                    data-amount="{{(round($grandTotal, 2))*100}}" 
                    data-currency="INR" 
                    data-buttontext="PAY NOW" 
                    data-name="Bartan.com" 
                    data-description="Rozerpay" 
                    data-image="{{asset('assets/img/logo/logo.png')}}"
                    data-prefill.name="{{@$users->cutomer_fname.' '.@$users->cutomer_lname}}" 
                    data-prefill.email="{{@$users->email}}" 
                    data-theme.color="#00000">
                </script>
                <?php }}?>
               

                      <!-- data-amount="{{(($taxAmtCount)+\Cart::getTotal())*100}}"  -->
              
                
 <!-- data-image="{{asset('assets/img/logo/logo.png')}}"  -->
        </form>
    
            </div>
                

    </div>

</div>