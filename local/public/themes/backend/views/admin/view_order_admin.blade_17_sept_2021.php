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
    /*padding: 20px*/
    padding: 1.25rem 2.5rem;
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
    text-align: initial;
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
.tx-in h1{
    line-height: initial !important;
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
    font-size: .85rem;
}.afsc-header ol,li{
     font-size: .85rem;
}
address{
    font-size: .85rem;
}
.invoice-detail{
     font-size: .85rem;
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
.m-r-166{
    margin-right: 166px !important;
}
.w-30{
    width: 30%;
}
.summary-container {
    float: right;
    width: 11rem !important;
    text-align: right;
}
</style>

<?php 

//pr($itemOrders);
$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
//pr($customerdetail);
$customer_name = ucfirst(@$customerdetail->cutomer_fname.' '.@$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$users = @$customerdetail->business_state;
$city = get_cityNameByCityId(@$customerdetail->business_city);

?>

<div id="content" class="content">
    <!-- begin breadcrumb -->
    <ol class="breadcrumb hidden-print float-xl-right">
        <li class="breadcrumb-item"><a href="javascript:;">Home</a></li>
        <li class="breadcrumb-item active">Order</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header hidden-print">Order detail <small>About order</small></h1>
    <div class="invoice-company">
        <div class="row">
        <div class="col-lg-12 pull-right">
                        <!-- <a href="javascript:void();" id="downViewCart" onclick="getPDF()" data-toggle="tooltip" data-placement="top" title="Download"><i class="fas fa-download"></i></a> -->
                            <!-- <a href="javascript:void();" id="printViewCart" onclick="window.print();" data-toggle="tooltip" data-placement="top" title="Print"><i class="fas fa-print"></i></a> -->
                       
             <span class="pull-right hidden-print">
                <a href="javascript:;" id="downViewCart" onclick="getPDF()" class="btn btn-sm btn-white m-b-10"><i class="fa fa-file-pdf t-plus-1 text-danger fa-fw fa-lg"></i> Export as PDF</a>
                  <a href="" onclick="window.print();"  class="btn btn-sm btn-white m-b-10"><i class="fas fa-print"></i> Print</a>
                <!-- <a href="javascript:;" onclick="window.print()" class="btn btn-sm btn-white m-b-10"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> Print</a>  -->
            </span>
            <!-- {{$customer_name}} -->
        </div>
         </div>
       
    <!-- end page-header -->
    <!-- begin invoice -->
  
    <div class="invoice" id="checkout-cart">
    <div class="tx-in">
      <h3>Performa Invoice</h3>
      <h1>Subiksh Steel Impex Pvt Ltd.</h1>
      <p>H.No.2, KH No-12/11, Amanpuri Teacher Colony ,<br>
        Nangloi, Delhi-110041 </p>
      <p>CIN : U27310DL2012PTC233551</p>
      <p><b>Tel: 01125943215</b>, <b>Email: subiksh2012@gmail.com</b></p>
    </div>
    <div class="invoice-header">
        <div class="invoice-to">
          <address class="m-t-5 m-b-5">
          Order No: {{$itemOrders[0]->order_id}}<br>
          Date Of Order : {{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}<br>
          </address>
        </div>
        <div class="w-30">
          <div class="invoice-date"> 
            
            <!-- <div class="date text-inverse m-t-5">Jul 12,2021</div> -->
            <div class="invoice-detail"> Transport :  <br>
              Vehicle No. : <br>
              Station  :  <br>
              E-Way Bill No. :  </div>
          </div>
        </div>
      </div>
        <!-- begin invoice-company -->
        
        <!-- end invoice-company -->
        <!-- begin invoice-header -->
        <div class="invoice-header">
            
            <div class="invoice-to">
            <strong class="text-inverse">Billed to:</strong>
                <address class="m-t-5 m-b-5">
             <div class="break">   <strong class="text-inverse">{{$customerdetail->store_name}}</strong></div>
               
                    <!-- <strong class="text-inverse">Customer name: {{@$customer_name}}</strong><br /> -->
                    Street Address: {{@$customerdetail->business_street_address}}<br />
                    Country: {{@$country->name}}, 
                    State: {{@$state->name}}, 
                    City: {{@$city->name}}<br/> 
                    Zip Code: {{@$customerdetail->business_postal_code}}<br />
                    Phone: {{@$customerdetail->phone}}<br />
                    Email id: {{@$customerdetail->email}}<br />
                    <!-- Phone: {{@Auth::user()->mobile}}<br />
                    Email id: {{@Auth::user()->email}}<br /> -->
                    GST NO.: {{@$customerdetail->business_gst_number}}<br />
                    {{-- Fax: (123) 456-7890 --}}
                </address>
            </div>
            <div class="w-30">
            <div class="invoice-to">
                <!-- <small>Invoice / July period</small> -->
                <strong class="text-inverse">Delivery at:</strong>
            <address class="m-t-5 m-b-5">
            <div class="break"><strong class="text-inverse">{{$customerdetail->store_name}}</strong></div>
          Street Address: {{$customerdetail->business_street_address}}<br />
          Country:        {{$country->name}}, 
          State:          {{$state->name}}, 
          City:           {{$city->name}}<br/>
          Zip Code:       {{$customerdetail->business_postal_code}}<br />
          Phone: {{@$customerdetail->phone}}<br />
          Email id: {{@$customerdetail->email}}<br />
          <!-- Phone:      {{Auth::user()->mobile}}<br />
          Email id:       {{Auth::user()->email}}<br /> -->
          GST NO.:        {{$customerdetail->business_gst_number}}<br />
          {{-- Fax: (123) 456-7890 --}}
          </address>
                <!-- <div class="date text-inverse m-t-5">{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</div> -->
                <div class="invoice-detail">
                <!-- Order no: {{$itemOrders[0]->order_id}}<br /> -->
                Stage: @if($itemOrders[0]->stage == 1)
                                    <span class="badge badge-md badge-success">Proccessed</span>

                                @elseif($itemOrders[0]->stage == 0)
                                    <span class="badge badge-md badge-danger">New order</span>

                                @elseif($itemOrders[0]->stage == 2)
                                    <span class="badge badge-md badge-danger">Packaging</span>

                               
                                @elseif($itemOrders[0]->stage == 3)
                                    <span class="badge badge-md badge-danger">Shipping</span>

                               
                              
                                   
                                @elseif($itemOrders[0]->stage == 4)
                                <span class="badge badge-md badge-danger">Delivered</span>
                                
                                @elseif($itemOrders[0]->stage == 5)
                                <span class="badge badge-md badge-danger">Hold</span>
                                
                                @elseif($itemOrders[0]->stage == 6)
                                <span class="badge badge-md badge-danger">Cancel</span>

                                @else
                                <span class="badge badge-md badge-danger">Return</span>
                                @endif
                                <br />

                Payment status: 
                <?php
                         $paymntStaus =  DB::table('tbl_payment_status')->where('item_order_id',  $itemOrders[0]->order_id)
                        ->first();
                        ?>

                        @if(@$paymntStaus->status == 1)
                             <span class="badge badge-md badge-success">Success</span>

                         @elseif(@$paymntStaus->status == 0)
                             <span class="badge badge-md badge-danger">Pending</span>

                         
                         @endif<br />
                    
                </div>
            </div>
           </div> 
        </div>
        <!-- end invoice-header -->
        <!-- begin invoice-content -->
        <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive table-print">
                <table class="table table-invoice">
                    <thead>
                        <tr>
                           
                            
                            <th class="field">Item</th>
                            <th class="field">Item Name</th>
                            <th class="field">HSN/SAC Code</th>
                            <th class="field">Quantity</th>
                            <th class="field">Unit</th>
                            
                            <th class="field">Item Rate</th>
                            <th class="field">Discount</th>
                            <th class="field">Net Rate</th>
                            <th class="field">Amount</th>
                            <?php
                           
                                if ($users == 10) {
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
                            
                            <th class="field">Total Amount</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sr=1;
                        $sumQty=0;
                                    //pr($itemOrders);
                                    foreach($itemOrders as $itemOrder){
                                             
                                        $item = get_item_detail($itemOrder->item_id);
                                        $itemImages = get_item_default_img_item_id($itemOrder->item_id);
                                        
                                        if($itemImages)
                                        {
                                            
                                            $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                            
                                        } else {
                                            
                                            $itemImg = FRONT.'img/product/product-iphone.png';
                                        }
                                        @$productArrForHsn = DB::table('tbl_items')->where('item_id', $itemOrder->item_id)->select('hsn_code')->first();
                       
                            @$productHSN = DB::table('tbl_hsn')->where('id', $productArrForHsn->hsn_code)->first();        
                                        
                            $sumQty += optional($itemOrder)->quantity;
                                        
                                        ?>
                        <tr>
                           
                            <td class="value">
                                {{$sr++}}
                                <!-- <img src="{{$itemImg}}" width="50px" height="50px"/> -->
                            </td>
                            
                            <td class="value">{{optional($item)->product_name }}</td>
                            <td class="value">{{@$productHSN->hsn_name}}</td>
                            <td class="value">{{optional($itemOrder)->quantity}}

                            <br/><br/>{{(optional($itemOrder)->set_of > 0)? '('.optional($itemOrder)->set_of.' Pcs)':''}}
                            </td>
                            <td class="value">{{optional($itemOrder)->unit}}</td>
                            <td class="value">{{optional($itemOrder)->item_price}}</td>
                            <td class="value">{{optional($itemOrder)->discount}}</td>
                            <td class="value">{{optional($itemOrder)->net_rate}}</td>
                            <td class="value">{{optional($itemOrder)->total_price}}</td>
                            <?php
                               
                                if ($users == 10) {
                                ?>

                                <td class="value">{{optional($itemOrder)->cgst}}</td>
                                <td class="value">{{optional($itemOrder)->sgst}}</td>
                                
                                   
                                <?php
                                } else {
                                ?>
                                    <td class="value">{{optional($itemOrder)->igst}}</td>
                                <?php
                                }

                                ?>
                            <!-- <td class="value">{{$itemOrder->total_price}}</td> -->
                             <td class="value text-center">{{$itemOrder->total_amount}} </td>
                    
                             
                            
                    
                            
                        </tr>
                        
                        
                    <?php }?>

                    <!-- Start delivery and packing charges code -->
                    <tr>
                             


                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center">Total Qty</td>
                                    <td class="cart-price text-center"> {{@$sumQty}} </td>
                                     <td class="cart-price"> Packaging Charges </td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargDiscount}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargNetRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargBasic}}</td>

                                    <?php
                                    if ($users == 10) {
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
                            

                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                    <td class="cart-price text-center"></td>
                                      <td class="cart-price"> Delivery Charge</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargDiscount}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargNetRate}}</td>
                                    <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargBasic}}</td>

                                    <?php
                                    if ($users == 10) {
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

                        <td class="cart-summary" colspan="10">
                                    <div class="summary-row">
                                    <h5>Amount in Words: </h5>

                                    <p style="font-size: 1.1rem;"><strong> <?php @$InWord = numberTowords(round(@$itemOrders[0]->grand_total));?>{{@$InWord}} only</strong></p>
                                         
                                    </div>
                                </td>
                                <td class="cart-summary" colspan="2">

                                    <div class="summary-container">

                                        <div class="summary-row">
                                            <div class="field">Cart Subtotal</div>
                                            <div class="value">{{optional($itemOrders[0])->subTotalAmt}}</div>
                                        </div>
                                        <?php
                                        if ($users == 10) {
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
                                            <?php 
                                            @$grandTotalPoint = number_format((float)round(@$itemOrders[0]->grand_total), 2, '.', '');
                                            ?>
                                            <div class="value">{{@$grandTotalPoint}}</div>
                                            <!-- <div class="value">{{round(@$itemOrders[0]->grand_total)}}</div> -->
                                        </div>
                                    </div>
                                </td>
                            </tr> 
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
           <!--  <div class="invoice-price">
               
                <div class="invoice-price-right">
                    <small>TOTAL</small> <span class="f-w-600">???{{@$itemOrders[0]->grand_total}}</span>
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
       
               <div class="afsc-header-welcome sgn">For Subiksh Steal Impex Pvt Ltd.</div>
               <div class="afsc-header-welcome sgn m-t-50">Authorised Signatory</div>
    
    </div>
      </div>
      <p class="text-silver-darker text-center m-b-0">Should you require any assistance, you can get in touch with Support Team at 9810516326</p>
          </div>
     
          
    </div>



   
  
