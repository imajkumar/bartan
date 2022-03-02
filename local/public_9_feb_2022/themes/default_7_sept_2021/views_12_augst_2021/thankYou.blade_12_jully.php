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
.success {
    color: green;
    font-weight: bold;
}
.table td, .table th {
 padding: .75rem;
    vertical-align: top;
    border: 1px solid #dee2e6;
}
.checkout .table.table-payment-summary .product-summary .product-summary-img {
    float: left;
    width: 2.5rem;
    margin-right: 3rem;
}
.tlp {
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
    /*text-align: right;*/
    padding: 20px;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1
}
.summary-container .summary-row.total {
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
.f-w-600 {
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
.tx-in {
    text-align: center;
    line-height: 1.3;
}
.tx-in h3 {
    font-size: 18px;
    font-weight: 600;
}
.tx-in h1 {
    font-size: 24px !important;
    font-weight: 700;
    line-height: .6;
    margin-bottom: 10px !important;
}
.tx-in P {
    margin-bottom: 0px;
}
.tnk h1 {
    font-weight: 600;
}
.afsc-header-welcome{
    font-size: 14px;
    font-weight: 600;
}
.afsc-header p{
    margin-bottom: 0px;
}
.bnk-dtl{
    padding: .75rem;
  
    border: 1px solid #dee2e6;
}
.sgn{
    text-align: right;
}
.m-t-50{
    margin-top: 50px !important;
}
</style>

<div id="product" class="section-container">
<!-- BEGIN container -->

<div class="container">
<div class="col-lg-12">
  <div class="tnk text-center">
    <h1>Thank you!</h1>
    <p>Your order has been successfully processed with the following details.</p>
  </div>
</div>
<div class="checkout" id="checkout-cart">
<script src="https://checkout.razorpay.com/v1/checkout.js"></script> 
{{--
<form action="checkout_info.html" method="POST" name="form_checkout">
--}}
<div class="checkout-header">
  <div class="row">
    <div class="col-lg-3 pull-right"> <a href="javascript:void();" id="downViewCart" onclick="getPDF()" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> <a href="javascript:void();" id="printViewCart" onclick="window.print();" data-toggle="tooltip" data-placement="top" title="Print"><i class="fas fa-print"></i></a> </div>
  </div>
</div>
<div class="checkout-body"> 
  <!-- BEGIN checkout-message -->
  <div class="checkout-message"> 
    <!--    <h1>Thank you! <small>Your order has been successfully processed with the following details.</small></h1>
 --> 
    <!--   <h3>Subhiksh Steal Impex Pvt Ltd. <small>H.No.2, KH No-12/11, Amanpuri Teacher Colony ,Nangaloi, Delhi-110041  </small></h3> -->
    
    <div class="tx-in">
      <h3>Performa Invoice</h3>
      <h1>Subhiksh Steal Impex Pvt Ltd.</h1>
      <p>H.No.2, KH No-12/11, Amanpuri Teacher Colony ,<br>
        Nangaloi, Delhi-110041 </p>
      <p>CIN : U27310DL2012PTC233551</p>
      <p><b>Tel: 01125943215</b>, <b>Email: subhikah2012@gmail.com</b></p>
    </div>
    <div class="invoice">
      <div class="invoice-header">
        <div class="invoice-to">
          <address class="m-t-5 m-b-5">
          Order No: 000087<br>
          Date Of Order : 12/05/2021<br>
          </address>
        </div>
        <div>
          <div class="invoice-date"> 
            
            <!-- <div class="date text-inverse m-t-5">Jul 12,2021</div> -->
            <div class="invoice-detail"> Transport : -- <br>
              Vehicle No. : DL1LM6811<br>
              Station  : -- <br>
              E-Way Bill No. : 731154877876 </div>
          </div>
        </div>
      </div>
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
        <div>
          <div class="invoice-date"> 
            <!-- <small>Invoice / July period</small> -->
            <div class="date text-inverse m-t-5">{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</div>
            <div class="invoice-detail"> Order no: {{$itemOrders[0]->order_id}}<br>
              Transaction Status : <span class="success">Success</span><br>
              <!-- Transaction payment No.: 000009<br> --> 
              
            </div>
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
                <th class="field">HSN/SAC CODE</th>
                <th class="field">Quantity</th>
                <th class="field">Unit</th>
                <th class="field">Item Rate</th>
                <th class="field">Discount</th>
                <th class="field">Net Rate</th>
                <th class="field">Amount</th>
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
                <td class="value">7373</td>
                <td class="value">{{optional($item)->quantity}}</td>
                <td class="value">{{optional($item)->unit}}</td>
                <td class="value">{{optional($item)->item_price}}</td>
                <td class="value">{{optional($item)->discount}}</td>
                <td class="value">{{optional($item)->net_rate}}</td>
                <td class="value">{{optional($item)->total_price}}</td>
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
                <td class="value text-center">{{@$item->total_amount}}</td>
              </tr>
              <?php }?>
              
              <!-- Start delivery and packing charges code -->
              <tr>
                <td class="cart-price"> Packaging Charges </td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargRate}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargDiscount}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargNetRate}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargBasic}}</td>
                <?php
                                    if ($users->cutomer_state == 10) {
                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargCGST}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargSGST}}</td>
                <?php
                                    } else {
                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargIGST}}</td>
                <?php
                                    }

                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargAmount}}</td>
              </tr>
              <tr>
                <td class="cart-price"> Delivery Charge</td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center"></td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargRate}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargDiscount}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargNetRate}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargBasic}}</td>
                <?php
                                    if ($users->cutomer_state == 10) {
                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargCGST}}</td>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargSGST}}</td>
                <?php
                                    } else {
                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargIGST}}</td>
                <?php
                                    }

                                    ?>
                <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargAmount}}</td>
              </tr>
              <!-- End delivery and packing charges code -->
              
              <tr>
                <td class="cart-summary" colspan="12"><div class="summary-container">
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
                  </div></td>
              </tr>
            </tbody>
          </table>
        </div>
        
        <!--  <div class="invoice-price">
                
                <div class="invoice-price-right">
                  
                    <small>TOTAL</small> <span class="f-w-600">₹{{$itemOrders[0]->grand_total}}</span>
                </div>
            </div> --> 
        
      </div>

      <div class="row">
          <div class="col-lg-12">
            <div class="bnk-dtl">
               <div class="afsc-header-welcome">Bank Details</div>
        <div class="afsc-header">
         <p>Kotak Mahindra Bank, 
        Peeragarhi Delhi</p>
         <p>A/C: 8111628861</p>
         <p>IFSC: KKBK0004601</p>
        </div>
    </div>
      </div>
     
          </div>
           <div class="row">
         
       <div class="col-lg-6">
        <div class="bnk-dtl">
               <div class="afsc-header-welcome">Terms & Conditions</div>
        <div id="afsc-header">
          <ol>
            <li>
             Goods once sold will not be taken back
            </li>
            <li>Interest @18%p.a. will be charged if the payment is not made with in the stipulated time</li>
            <li>Subject to 'Delhi' Jurisdiction only</li>
          </ol>
        </div>
    </div>
</div>
    <div class="col-lg-6">
       
               <div class="afsc-header-welcome sgn">For Subhiksh Steal Impex Pvt Ltd.</div>
               <div class="afsc-header-welcome sgn m-t-50">Authorised Signatory</div>
    
    </div>
      </div>
          </div>
     

    </div>



    <p class="text-silver-darker text-center m-b-0">Should you require any assistance, you can get in touch with Support Team at 9810516326, 9318429436</p>
  </div>
  <!-- END checkout-message --> 
  <div class="checkout-footer text-center"> <a href="{{url('/')}}" class="btn btn-success btn-lg btn-theme">CONTINUE SHOPPING</a> </div>
</div>

</div>
</div>
</div>
