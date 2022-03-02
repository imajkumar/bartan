<style>
    input.razorpay-payment-button {
        display: none;
    }
</style>
<div id="product" class="section-container p-t-20">
    <!-- BEGIN container -->
    <div class="container">
        <div class="checkout">
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            {{-- <form action="checkout_info.html" method="POST" name="form_checkout"> --}}
             
                <div class="checkout-header">

                    <div class="row">

                        <div class="col-lg-3">
                            {{-- <div class="step active">
                                <a href="#">
                                    <div class="number">1</div>
                                    <div class="info">
                                        <div class="title">Delivery Options</div>
                                        <div class="desc">Lorem ipsum dolor sit amet.</div>
                                    </div>
                                </a>
                            </div> --}}
                        </div>


                        {{-- <div class="col-lg-3">
                            <div class="step">
                                <a href="checkout_info.html">
                                    <div class="number">2</div>
                                    <div class="info">
                                        <div class="title">Shipping Address</div>
                                        <div class="desc">Vivamus eleifend euismod.</div>
                                    </div>
                                </a>
                            </div>
                        </div> --}}


                        {{-- <div class="col-lg-3">
                            <div class="step">
                                <a href="checkout_payment.html">
                                    <div class="number">3</div>
                                    <div class="info">
                                        <div class="title">Payment</div>
                                        <div class="desc">Aenean ut pretium ipsum. </div>
                                    </div>
                                </a>
                            </div>
                        </div> --}}


                        {{-- <div class="col-lg-3">
                            <div class="step">
                                <a href="checkout_complete.html">
                                    <div class="number">4</div>
                                    <div class="info">
                                        <div class="title">Complete Payment</div>
                                        <div class="desc">Curabitur interdum libero.</div>
                                    </div>
                                </a>
                            </div>
                        </div> --}}

                    </div>

                </div>

                    <?php 
                       //\Cart::remove(5);
                       //$itemId = 456;

                    //\Cart::get($itemId)->getSubTotal;

                    $cartCollection = \Cart::getContent()->sort();

                    ?>
                <div class="checkout-body">
                    <div class="table-responsive">
                        @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-dismissible fade in" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Error!</strong> {{ $message }}
                            </div>
                        @endif
                        @if($message = Session::get('success'))
                       
                            <div class="alert alert-success alert-dismissible fade {{ Session::has('success') ? 'show' : 'in' }}" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                <strong>Success!</strong> {{ $message }}
                            </div>
                        @endif
                        <table class="table table-cart">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Product Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                
                                foreach ($cartCollection->toArray() as $key => $rowData) {

                                    
                                    


                                    $itemImages = get_item_default_img_item_id($rowData['id']);

                                        if($itemImages)
                                        {

                                            $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                            
                                        } else {

                                            $itemImg = FRONT.'img/product/product-iphone.png';
                                        }
                                  ?>
                                     
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
                                            <div class="desc">Delivers Tue 26/04/2016 - Free</div>
                                        </div>
                                    </td>
                                    <td class="cart-price text-center">{{$rowData['price']}}</td>
                                    <td class="cart-qty text-center">
                                        {{-- <div class="cart-qty-input">
                                            <a href="#" class="qty-control left disabled" onclick="decreaseQTY({{$rowData['id']}})"  data-click="decrease-qty" data-target="#qty_{{$rowData['id']}}"><i class="fa fa-minus"></i></a>
                                            <input type="text" name="qty_{{$rowData['id']}}"  id="qty_{{$rowData['id']}}" value="{{$rowData['quantity']}}" class="form-control">
                                            <a href="#" class="qty-control right disabled" onclick="increseQTY({{$rowData['id']}})"  data-click="increase-qty" data-target="#qty_{{$rowData['id']}}"><i class="fa fa-plus"></i></a>
                                        </div> --}}
                                        <div class="cart-qty-input">
                                            <?php
                                            if($rowData['quantity']==1){
                                            ?>

                                            <a href="#" class="qty-control left disabled"   data-click="decrease-qty" ><i class="fa fa-minus"></i></a>
                                            
                                            <?php }else{?>

                                                <a href="#" class="qty-control left disabled"  onclick="decreaseQTY({{$rowData['id']}})" data-click="decrease-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-minus"></i></a>
                                            
                                                <?php }?>
                                            
                                            <input type="text" name="qty" id="qty{{$rowData['id']}}" value="<?php echo $rowData['quantity'];?>"  class="form-control">
                                            <a href="#" class="qty-control right disabled" onclick="increseQTY({{$rowData['id']}})"    data-click="increase-qty" data-target="#qty{{$rowData['id']}}"><i class="fa fa-plus"></i></a>
                                        </div>
                                        
                                        <div class="qty-desc">11 to max order</div>
                                    </td>
                                    <td class="cart-total text-center">
                                    {{($rowData['quantity'])*($rowData['price'])}}
                                    </td>
                                </tr>


                                  <?php
                                }
                                ?>
                               
                                <tr>
                                    <td class="cart-summary" colspan="4">
                                        <div class="summary-container">
                                            <div class="summary-row">
                                                <div class="field">Cart Subtotal</div>
                                                <div class="value">{{\Cart::getSubTotal()}}</div>
                                            </div>
                                            <div class="summary-row text-danger">
                                                <div class="field">Free Shipping</div>
                                                <div class="value">0.00</div>
                                            </div>
                                            <div class="summary-row total">
                                                <div class="field">Total</div>
                                                <div class="value">{{\Cart::getTotal()}}</div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="checkout-footer">
                <a href="{{url('/')}}" class="btn btn-white btn-lg pull-left btn-theme">CONTINUE SHOPPING</a>
                <form action="{{ route('payment') }}" method="POST" >
                    @csrf
                   <input type="hidden" name="team" value="errrrrr"/>
                   <?php
                   foreach ($cartCollection->toArray() as $key => $rowData) {?>

                         <input type="hidden" name="itemIdForOder[]" value="{{$rowData['id']}}"/>
                         <input type="hidden"  name="quantityForOder[{{$rowData['id']}}][]" value="{{$rowData['quantity']}}"/>
                         <input type="hidden"  name="totalPrice[{{$rowData['id']}}][]" value="{{($rowData['quantity'])*($rowData['price'])}}"/>
                         <input type="hidden"  name="prices[{{$rowData['id']}}][]" value="{{$rowData['price']}}"/>
                         <input type="hidden"  name="totalAmount" value="{{\Cart::getSubTotal()}}"/>
                   
                 <?php }?>
                   
                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ env('RAZOR_KEY') }}"
                          
                            data-amount="{{(\Cart::getTotal())*100}}"
                            data-currency="INR"
                            data-buttontext="PAY NOW"
                            data-name="Bartanwaale.com"
                            data-description="Rozerpay"
                            data-image="{{asset('assets/img/logo/logo.png')}}"
                            data-prefill.name="Customer name"
                            data-prefill.email="Customeremail@customer.com"
                            data-theme.color="#00000">
                    </script>
                    <button type="submit" class="btn btn-inverse btn-lg btn-theme width-200">PAY NOW</button>
               
                </form> 
                </div>
            
           
        </div>
    </div>
</div>