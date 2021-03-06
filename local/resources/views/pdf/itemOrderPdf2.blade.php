<style>
    input.razorpay-payment-button {
        display: none;
    }
    .checkout .table.table-payment-summary .field {
    font-weight: bold;
     text-align: left !important; 
    width: 30%;
    background: #efefefb5;
}
.success{
    color: green;
    font-weight: bold;

}
.table td, .table th {
    padding: .32rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}
.checkout .table.table-payment-summary .product-summary .product-summary-img {
    float: left;
    width: 2.5rem;
    margin-right: 3rem;
}
.tlp{
    font-size: 18px;
    font-weight: bold;
}
.invoice {
    background: #fff;
    padding: 20px
}
.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}
.invoice .invoice-company {
    font-size: 20px;
    font-weight: 600
}
.invoice .invoice-header {
    margin: 0 -20px;
    background: #f9f9f9;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex
}
@media (max-width:991.98px) {
.invoice .invoice-header {
    display: block
}
.invoice .invoice-header>div+div {
    border-top: 1px solid #ededed
}
}
.invoice .invoice-from {
    padding: 20px;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1
}
.invoice .invoice-from strong {
    font-size: 16px;
    font-weight: 600
}
.invoice .invoice-to {
    padding: 20px;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1
}
.invoice .invoice-to strong {
    font-size: 16px;
    font-weight: 600
}
.invoice .invoice-date {
    text-align: right;
    padding: 20px;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1
}
.summary-container .summary-row.total{
    margin-bottom: 0rem;
}
@media (max-width:991.98px) {
.invoice .invoice-date {
    text-align: left
}
}
.invoice .invoice-date .date {
    font-size: 16px;
    font-weight: 600
}
.invoice .invoice-price {
    background: #f9f9f9;
    width: 100%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex
}
@media (max-width:575.98px) {
.invoice .invoice-price {
    display: block
}
}
.invoice .invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}
.invoice .invoice-price .invoice-price-right {
    margin-left: auto;
   /* padding: 20px;*/
    font-size: 28px;
    font-weight: 300;
    position: relative;
    vertical-align: bottom;
    text-align: right;
    color: #fff;
    background: #222;
    min-width: 25%;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-pack: flex-end;
    -ms-flex-pack: flex-end;
    justify-content: flex-end;
    -ms-flex-align: center;
    align-items: center
}
.invoice .invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 15px;
    left: 20px;
    font-size: 12px
}
.invoice .invoice-price .invoice-price-left {
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    position: relative;
    vertical-align: middle;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1
}
.invoice .invoice-price .invoice-price-left .invoice-price-row {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -ms-flex-align: center;
    align-items: center
}
.table thead th {
    vertical-align: bottom;
    border-bottom: 1px solid #dee2e6;
    background: #222222;
    color: #fff;
}
.f-w-600{
    margin-right: 10px;
}
@media (max-width:575.98px) {
.invoice .invoice-price .invoice-price-left .invoice-price-row {
    display: block;
    text-align: center
}
}
.invoice .invoice-price .invoice-price-left .invoice-price-row .sub-price {
    padding: 0 20px
}
@media (max-width:991.98px) {
.invoice .invoice-price .invoice-price-left .invoice-price-row .sub-price {
    padding: 0
}
.invoice .invoice-price .invoice-price-left .invoice-price-row .sub-price+.sub-price {
    padding-left: 20px
}
}
@media (max-width:575.98px) {
.invoice .invoice-price .invoice-price-left .invoice-price-row .sub-price+.sub-price {
    padding-left: 0
}
}
.invoice .invoice-footer {
    border-top: 1px solid #c8c8c8;
    padding-top: 15px;
    font-size: 11px;
    color: #484848
}
.invoice .invoice-note {
    color: #484848;
    margin-top: 80px;
    font-size: 11px;
    line-height: 1.75
}
.invoice .table-invoice {
    font-size: 13px
}
@media (max-width:991.98px) {
.invoice .table-invoice {
    white-space: nowrap
}
}
</style>

<div id="product" class="section-container p-t-60">
    <!-- BEGIN container -->
    <div class="container">
        <div class="checkout">
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            {{-- <form action="checkout_info.html" method="POST" name="form_checkout"> --}}
             
                <div class="checkout-header">

                    <div class="row">

                        <div class="col-lg-3">
                            
                        </div>



                    </div>

                </div>

                <div class="checkout-body">
                    <!-- BEGIN checkout-message -->
                    <div class="checkout-message">
                        <h1>Thank you! <small>Your Payment has been successfully processed with the following details.</small></h1>




                        <div class="invoice">
       
        <div class="invoice-header">
            
            <div class="invoice-to">
                <?php 
                
                    $customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
                    //pr($customerdetail);
                    $customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

                    $country = getCountryByCountryId(@$customerdetail->business_country);
                    $state = get_stateNameByStateId(@$customerdetail->business_state);
                    $city = get_cityNameByCityId(@$customerdetail->business_city);
                
                ?>
                <!-- <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Customer name: {{$customer_name}}</strong><br>
                    STREET ADDRESS: bghfh<br>
                    COUNTRY:        India, 
                    STATE:          Himachal Pradesh, 
                    CITY:           Gagret<br> 
                    ZIP CODE:       56567<br>
                    PHONE NO.:      9899450999<br>
                    EMAIL ID:       tyht@fghfh.gffg<br>
                    GST NO.:        jgujtu67u6<br>
                    
                </address> -->
                <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Customer name: {{$customer_name}}</strong><br />
                    STREET ADDRESS: {{$customerdetail->business_street_address}}<br />
                    COUNTRY:        {{$country->name}}, 
                    STATE:          {{$state->name}}, 
                    CITY:           {{$city->name}}<br/> 
                    ZIP CODE:       {{$customerdetail->business_postal_code}}<br />
                    PHONE NO.:      {{Auth::user()->mobile}}<br />
                    EMAIL ID:       {{Auth::user()->email}}<br />
                    GST NO.:        {{$customerdetail->business_gst_number}}<br />
                    {{-- Fax: (123) 456-7890 --}}
                </address>
            </div>
           <div class="invoice-date">
                <!-- <small>Invoice / July period</small> -->
                <div class="date text-inverse m-t-5">{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</div>
                <div class="invoice-detail">
                Order no: {{$itemOrders[0]->order_id}}<br>
                Transaction Status : <span class="success">Success</span><br>
                <!-- Transaction payment No.: 000009<br> -->
             
                    
                </div>
            </div>
        </div>
        <!-- end invoice-header -->
        <!-- begin invoice-content -->
        <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
                <table class="table table-invoice">
                    <thead>
                        <tr>
                            <!-- <th class="field">Order no</th>
                            <th class="field">Order date</th> -->
                            
                            <th class="field">Item</th>
                            <th class="field">Item Name</th>
                            <th class="field">Quantity</th>
                            <th class="field">Unit</th>
                            
                            <th class="field">Item Rate</th>
                            <th class="field">Discount</th>
                            <th class="field">Net Rate</th>
                            <th class="field">Amount</th>
                            <th class="field">CGST</th>
                                  
                            <?php
                                $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first();
                                if ($users->cutomer_state == 10) {
                                ?>
                                    <th class="field">CGST</th>
                                    <th class="field">SGST</th>
                                <?php
                                } else {
                                ?>
                                    <th class="field">IGST</th>
                                <?php
                                }

                                ?>
                            
                        <!-- <th class="field">Total Item Price</th> -->
                            <th class="field">Total Amount</th>
                            
                         
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($itemOrders as $item)
                        {
                            //pr($item);
                            $itemImages = get_item_default_img_item_id($item->item_id);

                            if($itemImages)
                            {

                                $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                
                            } else {

                                $itemImg = FRONT.'img/product/product-iphone.png';
                            }
                    ?>
                        <tr>
                          
                            <td class="value"><img src="{{$itemImg}}" width="50px" height="50px"></td>
                            
                            <td class="value">{{ucfirst($item->item_name)}}</td>
                            <td class="value">{{optional($item)->quantity}}</td>
                            <td class="value">{{optional($item)->unit}}</td>
                            <td class="value">{{optional($item)->item_price}}</td>
                            <td class="value">{{optional($item)->discount}}</td>
                            <td class="value">{{optional($item)->net_rate}}</td>
                            <td class="value">{{optional($item)->total_price}}</td>
                          
                                <td class="value">{{optional($item)->sgst}}</td> 
                            <?php
                                $users = DB::table('tbl_customers')->where('user_id', Auth::user()->id)->first();
                                if ($users->cutomer_state == 10) {
                                ?>

                                <td class="value">{{optional($item)->cgst}}</td>
                                <td class="value">{{optional($item)->sgst}}</td>
                                
                                   
                                <?php
                                } else {
                                ?>
                                    <td class="value">{{optional($item)->igst}}</td>
                                <?php
                                }

                                ?>
                             <td class="value">{{@$item->total_amount}}</td>
                    
                
                
                            
                        </tr>
                            <?php }?>
                        
                            <tr>
                                <td class="cart-summary" colspan="12">
                                    <div class="summary-container">
                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <div class="value">{{optional($itemOrders[0])->subTotalAmt}}</div>
                                        </div>
                                        <?php
                                        if ($users->cutomer_state == 10) {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">CGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtCGST}}</div>
                                            </div>
                                            <div class="summary-row text-primary">
                                                <div class="field">SGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtSGST}}</div>
                                            </div>

                                        <?php
                                        } else {
                                        ?>
                                            <div class="summary-row text-primary">
                                                <div class="field">IGST</div>
                                                <div class="value">{{optional($itemOrders[0])->taxAmtIGST}}</div>
                                            </div>
                                        <?php
                                        }
                                        ?>


                                        <div class="summary-row total">
                                            <div class="field">Grand Total</div>
                                            <div class="value">{{optional($itemOrders[0])->grand_total}}</div>
                                        </div>
                                    </div>
                                </td>
                            </tr>             
                        
                        
                                            
                        
                    </tbody>
                </table>
            </div>
         
           <!--  <div class="invoice-price">
                
                <div class="invoice-price-right">
                  
                    <small>TOTAL</small> <span class="f-w-600">???{{$itemOrders[0]->grand_total}}</span>
                </div>
            </div> -->
            
        </div>
       
    </div>
                      
                        <p class="text-silver-darker text-center m-b-0">Should you require any assistance, you can get in touch with Support Team at (123) 456-7890</p>
                    </div>
                    <!-- END checkout-message -->
                </div>  
                <div class="checkout-footer text-center">
                    <a href="{{url('/')}}" class="btn btn-success btn-lg btn-theme">CONTINUE SHOPPING</a>
                </div>


                
            
           
        </div>
    </div>
</div>