<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<style type="text/css">
/*
	 CSS-Tricks Example
	 by Chris Coyier
	 http://css-tricks.com
*/




* {
	margin: 0;
	padding: 0;
}
body {
	font-family: "Open Sans", sans-serif;
	font-size: 14px;
	-webkit-print-color-adjust: exact;
	padding-left: 20px;
	padding-right: 20px;
}
.page-wrap {
	width: 800px;
	margin: 0 auto;
}
textarea {
	border: 0;
	font-family: "Open Sans", sans-serif;
	overflow: hidden;
	resize: none;
}
table {
	border-collapse: collapse;
}
table td, table th {
	border: 1px solid black;
	padding: 5px;
}
.header {
	height: auto;
	width: 100%;
	margin: 20px 0;
	background: #343a40;
	text-align: center;
	color: white;
	font-family: "Open Sans", sans-serif;
	text-decoration: uppercase;
	padding: 8px 0px;
}
.header p {
	font-weight: 14px;
	font-weight: 400;
}
.header h4 {
	font-size: 20px;
	font-weight: bold;
}
#address {
	width: 280px;
	height: auto;
	float: left;
}

.address {
	width: 200px;
	height: auto;
	float: left;
}
/*#customer {
	overflow: hidden;
}*/
#logo {
	text-align: right;
	float: right;
	position: relative;
	margin-top: 25px;
	border: 1px solid #fff;
	max-width: 540px;
	max-height: 100px;
	overflow: hidden;
}
/*#logo:hover, #logo.edit {
	border: 1px solid #000;
	margin-top: 0px;
	max-height: 125px;
}*/
#logoctr {
	display: none;
}
#logohelp {
	text-align: left;
	display: none;
	font-style: italic;
	padding: 10px 5px;
}
#logohelp input {
	margin-bottom: 5px;
}
.edit #logohelp {
	display: block;
}
.edit #save-logo, .edit #cancel-logo {
	display: inline;
}
.edit #image, #save-logo, #cancel-logo, .edit #change-logo, .edit #delete-logo {
	display: none;
}
#customer-title {
	font-size: 20px;
	font-weight: bold;
	float: left;
}
#meta {
	margin-top: 1px;
	width: 180px;
	float: right;
}

.meta {
	margin-top: 1px;
	width: 250px !important;
	float: right;
}
#meta td {
	text-align: right;
}
#meta td.meta-head {
	text-align: left;
	/*background: #eee;*/
	font-weight: 600
}
#meta td textarea {
	width: 100%;
	height: 20px;
	text-align: right;
}
#items {
	clear: both;
	width: 100%;
	margin: 0px 0 0 0;
	border: 1px solid black;
}
#items th {
	background: #eee;
	text-align: left;
}
#items textarea {
	width: 80px;
	height: 50px;
}
#items tr.item-row td {
	border: 0;
	vertical-align: top;
}
#items td.description {
	width: 300px;
}
#items td.item-name {
	width: 175px;
}
#items td.description textarea, #items td.item-name textarea {
	width: 100%;
}
/*#items td.total-line {
	border-right: 0;
	text-align: right;
}*/
#items td.total-value {
	border-left: 0;
	padding: 10px;
}
#items td.total-value textarea {
	height: 20px;
	background: none;
}
#items td.balance {
	background: #eee;
}
#items td.blank {
	border: 0;
}
#terms {
	text-align: center;
	margin: 20px 0 0 0;
}
#terms h5 {
	text-transform: uppercase;
	font-family: "Open Sans", sans-serif;
	letter-spacing: 10px;
	border-bottom: 1px solid black;
	padding: 0 0 8px 0;
	margin: 0 0 8px 0;
}
#terms textarea {
	width: 100%;
	text-align: center;
}
.delete-wpr {
	position: relative;
}
.delete {
	display: block;
	color: #000;
	text-decoration: none;
	position: absolute;
	background: #EEEEEE;
	font-weight: bold;
	padding: 0px 3px;
	border: 1px solid;
	top: -6px;
	left: -22px;
	font-family: "Open Sans", sans-serif;
	font-size: 12px;
}
.thk h2 {
	width: 100%;
	text-align: center;
	font-size: 28px;
	margin-bottom: 50px;
}
.thk {
	text-align: center;
}
.m-t-0{
	margin-top: 0px !important;
}
.row {
	display: flex;
	flex-wrap: wrap;
	margin-right: -15px;
	margin-left: -15px;
}
.row>[class^=col-] {
 padding-left: 10px;
 padding-right: 10px;
}
.col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto, .col-xs, .col-xs-1, .col-xs-10, .col-xs-11, .col-xs-12, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-auto, .col-xxl, .col-xxl-1, .col-xxl-10, .col-xxl-11, .col-xxl-12, .col-xxl-2, .col-xxl-3, .col-xxl-4, .col-xxl-5, .col-xxl-6, .col-xxl-7, .col-xxl-8, .col-xxl-9, .col-xxl-auto, .col-xxxl, .col-xxxl-1, .col-xxxl-10, .col-xxxl-11, .col-xxxl-12, .col-xxxl-2, .col-xxxl-3, .col-xxxl-4, .col-xxxl-5, .col-xxxl-6, .col-xxxl-7, .col-xxxl-8, .col-xxxl-9, .col-xxxl-auto {
	position: relative;
	width: 100%;
	padding-right: 15px;
	padding-left: 15px;
}
.bnk-dtl {
 padding: .75rem;
	border: 1px solid #dee2e6;
}
.afsc-header-welcome {
	font-size: 14px;
	font-weight: 600;
}
.afsc-header p {
	margin-bottom: 0px;
	font-size: 12px!important;
}
.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px;
}
.sgn {
	text-align: right;
}
.m-t-50 {
	margin-top: 50px !important;
}
.text-center {
	text-align: center!important;
}
.m-b-0 {
	margin-bottom: 0!important;
}
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}
.container {
    width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto;
}
::marker {
    unicode-bidi: isolate;
    font-variant-numeric: tabular-nums;
    text-transform: none;
    text-indent: 0px !important;
    text-align: start !important;
    text-align-last: start !important;
}
@media (min-width: 992px) {
.col-lg-12 {
	flex: 0 0 100%;
	max-width: 100%;
}
.col-lg-6 {
	flex: 0 0 50%;
	max-width: 50%;
}
.container, .container-lg, .container-md, .container-sm {
    max-width: 960px;
}
}
@media (min-width: 1200px){
.container, .container-lg, .container-md, .container-sm, .container-xl {
    max-width: 1170px;
}
}
@media (min-width: 768px){
.container, .container-md, .container-sm {
    max-width: 750px;
}
}
</style>
<?php 
        //pr($itemOrders);      
	$customerdetail = get_customer_and_address_by__user_id(@$itemOrders[0]->customer_id);
	//pr($customerdetail);
	$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

	$country = getCountryByCountryId(@$customerdetail->business_country);
	$state = get_stateNameByStateId(@$customerdetail->business_state);
	$city = get_cityNameByCityId(@$customerdetail->business_city);

?>
</head>

<body style="font-size: 14px; -webkit-print-color-adjust: exact;">
<div class="page-wrap" style="width: 700px; margin: 0 auto;">
  <div class="header">
    <h4>Subiksh Steel Impex Pvt Ltd</h4>
    <p>Main Rohtak Road, Nangloi,
      Rohtak Road,
      Delhi, India - 110041</p>
    <p>CIN: DFHDHYTRY64767FGHF</p>
    <P><strong>Tel:</strong>01125943215 <strong> Email: </strong>subiksh2012@gmail.com</P>
  </div>
  <!-- <div class="thk"> <img src="{{asset('gallery/invoicepdfimg.png')}}" style="margin-top: 20px">
    <h2 class="mb-0">Thank you! Your Payment has been successfully
      processed with the following details.</h2>
  </div> -->
  <!-- <div style="clear:both"></div> -->
  
  <div id="address" style="width: 50%">
   
   <p style="margin-bottom: 0px;"><span class="meta-head"> Order No :</span>  {{$itemOrders[0]->order_id}} </p>

   <p style="margin-bottom: 0px;"><span class="meta-head">Date Of Order : </span>  {{date("M d,Y", strtoTime($itemOrders[0]->created_at))}} </p><br>

  </div>


  <div id="meta" style="overflow: hidden;">
  	  <p><span class="meta-head" style="margin-bottom: 0px;">  Transport :</span>  </p>
   <p><span class="meta-head" style="margin-bottom: 0px;">  Vehicle No. :</span>  </p>
    <p><span class="meta-head" style="margin-bottom: 0px;">   Station  :</span>  </p>
     <p><span class="meta-head" style="margin-bottom: 0px;">  E-Way Bill No. :</span>  </p>

  </div>


<div class="clearfix"></div>
 
<div style="padding-top: 40px; margin-top: 40px;"></div>

<div id="address" style="width: 80%;">
    <!-- <h4>Shipping Details</h4> -->
    <p>{{@$customerdetail->store_name}}<br/>
      {{@$customerdetail->business_street_address}}<br/>
      
      {{@$state->name}}<br/>
      {{@$city->name}}<br/>
	  {{@$country->name}}
      
      {{@$customerdetail->business_postal_code}}<br />
      {{@$customerdetail->phone}}<br />
          {{@$customerdetail->email}}<br />
      <!-- {{@Auth::user()->mobile}}<br />
      {{@Auth::user()->email}}<br /> -->
      <!-- {{@$customerdetail->business_gst_number}}<br /> --> 
      
    </p>
  </div>

  <div id="meta" style="overflow: hidden;">
  	
 <h4>Delivey at:</h4>
    <p>{{@$customerdetail->store_name}}<br/>
      {{@$customerdetail->business_street_address}}<br/>
      
      {{@$state->name}}<br/>
      {{@$city->name}}<br/>
	  {{@$country->name}}
      
      {{@$customerdetail->business_postal_code}}<br />
      {{@$customerdetail->phone}}<br />
          {{@$customerdetail->email}}<br />
      <!-- {{@Auth::user()->mobile}}<br />
      {{@Auth::user()->email}}<br /> -->
      <!-- {{@$customerdetail->business_gst_number}}<br /> --> 
      
    </p>

  </div>

</div>
<div class="clearfix"></div>


  <table id="items" style="width: 700px; margin: 20px auto;">
    <tr>
      <th>Item Name</th>
      <th>Quantity</th>
      <th>Unit</th>
      <th>Rate</th>
      <th>Discount</th>
      <th>Net Rate</th>
      <th>Amount</th>
      <!-- <th>CGST</th> -->
      <th>CGST</th>
      <th>SGST</th>
      <th>IGST</th>
      
      <!-- <?php
			$users = DB::table('tbl_customers')->where('user_id', @$itemOrders[0]->customer_id)->first();
			//pr($users);
			if (@$users->cutomer_state == 10) {
			?>
				<th>CGST</th>
				<th>SGST</th>
			<?php
			} else {
			?>
				<th>IGST</th>
			<?php
			}

		?> -->
      <th>Total Amount</th>
    </tr>
    <?php
    $sumQty=0;
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
      $sumQty += optional($item)->quantity;
	?>
    <tr id="hiderow">
      <td><span class="price">{{ucfirst($item->item_name)}}</span></td>
      <td><span class="price">{{optional($item)->quantity}}</span></td>
      <td><span class="price">{{optional($item)->unit}}</span></td>
      <td><span class="price">{{optional($item)->item_price}}</span></td>
      <td><span class="price">{{optional($item)->discount}}</span></td>
      <td><span class="price">{{optional($item)->net_rate}}</span></td>
      <td><span class="price">{{optional($item)->total_price}}</span></td>
      <!-- <td><span class="price">{{optional($item)->sgst}}</span></td> -->
      
      <?php
			$users = DB::table('tbl_customers')->where('user_id', @$itemOrders[0]->customer_id)->first();
			if ($users->cutomer_state == 10) {
			?>
      <td><span class="price">{{optional($item)->cgst}}</span></td>
      <td><span class="price">{{optional($item)->sgst}}</span></td>
      <td><span class="price">0</span></td>
      <?php
			} else {
			?>
      <td><span class="price">0</span></td>
      <td><span class="price">0</span></td>
      <td><span class="price">{{optional($item)->igst}}</span></td>
      <?php
			}

		?>
      <td><span class="price">{{@$item->total_amount}}</span></td>
    </tr>
    <?php }?>
    
    <!-- Start delivery and packing charges code -->
    <tr>
      <td class="cart-price"> Packaging Charges </td>
      <td class="cart-price text-center"></td>
      <td class="cart-price text-center">  </td>
      <!-- <td class="cart-price text-center">Total Qty</td>
      <td class="cart-price text-center"> {{@$sumQty}} </td> -->
      <!-- <td class="cart-price text-center"></td> -->
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargRate}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargDiscount}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargNetRate}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargBasic}}</td>
      <?php
							if ($users->cutomer_state == 10) {
							?>
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargCGST}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->packingChargSGST}}</td>
      <td><span class="cart-price text-center">0</span></td>
      <?php
							} else {
							?>
      <td><span class="cart-price text-center">0</span></td>
      <td><span class="cart-price text-center">0</span></td>
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
      <!-- <td class="cart-price text-center"></td> -->
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargRate}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargDiscount}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargNetRate}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargBasic}}</td>
      <?php
                                    if ($users->cutomer_state == 10) {
                                    ?>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargCGST}}</td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargSGST}}</td>
      <td><span class="cart-price text-center">0</span></td>
      <?php
                                    } else {
                                    ?>
      <td><span class="cart-price text-center">0</span></td>
      <td><span class="cart-price text-center">0</span></td>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargIGST}}</td>
      <?php
                                    }

                                    ?>
      <td class="cart-price text-center">{{optional($itemOrders[0])->deliveryChargAmount}}</td>
    </tr>
    <!-- End delivery and packing charges code -->
    
    <tr>
      <td colspan="8" class="blank" style="border: 0;"></td>
      <td colspan="2" class="total-line">Total</td>
      <td class="total-value"><div id="subtotal">{{optional($itemOrders[0])->subTotalAmt}}</div></td>
    </tr>
    <?php
		if ($users->cutomer_state == 10) {
		?>
    <tr>
      <td colspan="8" class="blank" style="border: 0;"></td>
      <td colspan="2" class="total-line">CGST</td>
      <td class="total-value"><div id="total">{{optional($itemOrders[0])->taxAmtCGST}}</div></td>
    </tr>
    <tr>
      <td colspan="8" class="blank" style="border: 0;"></td>
      <td colspan="2" class="total-line">SGST</td>
      <td class="total-value"><div id="total">{{optional($itemOrders[0])->taxAmtSGST}}</div></td>
    </tr>
    <?php
		} else {
		?>
    <tr>
      <td colspan="8" class="blank" style="border: 0;"></td>
      <td colspan="2" class="total-line">IGST</td>
      <td class="total-value"><div id="total">{{optional($itemOrders[0])->taxAmtIGST}}</div></td>
    </tr>
    <?php
		}
		?>
    <tr>
      <td colspan="8" class="blank" style="border: 0;"></td>
      <td colspan="2" class="total-line">Grand Total</td>
      <?php 
                      @$grandTotalPoint = number_format((float)round(@$itemOrders[0]->grand_total), 2, '.', '');
                      ?>
                      <td class="total-value"><div class="value">{{@$grandTotalPoint}}</div></td>
      <!-- <td class="total-value"><div id="total">{{optional($itemOrders[0])->grand_total}}</div></td> -->
    </tr>
  </table>
 
  
</div>
<div class="container" style="width: 700px; margin: 20px auto;">
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
    </div>
 <div class="container" style="width: 700px; margin: 20px auto;">

  <div id="address" class="address" style="width: 50%">
    <div class="bnk-dtl">
          <div class="afsc-header-welcome">Terms & Conditions</div>
          <div class="afsc-header">
            
              <p>1. Goods once sold will not be taken back </p>
              <p>2. Interest @18%p.a. will be charged if the <br/> payment is not made with in the stipulated time</p>
              <p>3. Subject to 'Delhi' Jurisdiction only</p>
          
          </div>
        </div>
  </div>
  <div id="meta" class="meta" style="overflow: hidden;">
     <div class="afsc-header-welcome sgn">For Subiksh Steal Impex Pvt Ltd.</div>
        <div class="afsc-header-welcome sgn m-t-50">Authorised Signatory</div>
  </div>
</div>
  <!-- <div id="terms">
    <h5></h5>
    <p>Should you require any assistance, you can get in touch with Support Team at (123) 456-7890 </p>
  </div> -->
</body>
</html>