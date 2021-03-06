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
	width: 250px;
	height: 150px;
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
    <h4>Subhiksh Steel Impex Pvt Ltd</h4>
    <p>Main Rohtak Road, Nangloi,
      Rohtak Road,
      Delhi, India - 110041</p>
    <p>CIN: DFHDHYTRY64767FGHF</p>
    <P><strong>Tel:</strong>011111111 <strong> Email: </strong>info@example.com</P>
  </div>
  <div class="thk"> <img src="{{asset('gallery/invoicepdfimg.png')}}" style="margin-top: 20px">
    <h2 class="mb-0">Thank you! Your Payment has been successfully
      processed with the following details.</h2>
  </div>
  <!-- <div style="clear:both"></div> -->
  
    <div id="address" style="width: 50%">
      <h4>Shipping Details</h4>
      <p>{{@$customer_name}}<br/>
	  {{@$customerdetail->business_street_address}}<br/>
	  {{@$country->name}}<br/>
	  {{@$state->name}}<br/>
	  {{@$city->name}}

	  {{@$customerdetail->business_postal_code}}<br />
	  {{@Auth::user()->mobile}}<br />
	  {{@Auth::user()->email}}<br />
	  <!-- {{@$customerdetail->business_gst_number}}<br /> -->
        
       </p>
    </div>
   
    <table id="meta" style="overflow: hidden;">
      <tr>
        <td class="meta-head">Invoice #</td>
        <td>{{$itemOrders[0]->order_id}}</td>
      </tr>
      <tr>
        <td class="meta-head">Date</td>
        <td>{{date("M d,Y", strtoTime($itemOrders[0]->created_at))}}</td>
      </tr>
      <!-- <tr>
        <td class="meta-head">Amount Due</td>
        <td><div class="due">$875.00</div></td>
      </tr> -->
    </table>
  
  <table id="items">
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
							<td class="cart-price text-center"></td>
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
      <td class="total-value"><div id="total">{{optional($itemOrders[0])->grand_total}}</div></td>
    </tr>
  </table>
  
  <div id="terms">
    <h5></h5>
    <p>Should you require any assistance, you can get in touch with Support Team at (123) 456-7890 </p>
  </div>
</div>
</body>
</html>