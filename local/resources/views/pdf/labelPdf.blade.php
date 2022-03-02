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
	font-size: 18px;
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
	$customerdetail = get_customer_and_address_by__user_id(@$itemPackedDetail->customer_id);
	//pr($customerdetail);
	$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

	$country = getCountryByCountryId(@$customerdetail->business_country);
	$state = get_stateNameByStateId(@$customerdetail->business_state);
	$city = get_cityNameByCityId(@$customerdetail->business_city);

?>
</head>

<body style="font-size: 18px; -webkit-print-color-adjust: exact;">
<div class="page-wrap" style="width: 550px; height: 450px; margin: 0 auto;">
<div class="container" style="width: 100%;
    padding-right: 15px;
    padding-left: 15px;
    margin-right: auto;
    margin-left: auto; max-width: 1140px;">
<?php 
for($n=1; $n <= $itemPackedDetail->total+1; $n++){
	?>
<div style="padding: 15px;">

  <div class="card" style="background: #c8c8c8;
    padding: 12px;
    border-radius: 10px;">
        <div class="card-front">
          <div class="card-content">
           
        <!-- <p><strong>Customer Name </strong> {{$customer_name}}</p> -->
        <p><strong>Store Name </strong> {{$customerdetail->store_name}}</p>
         <p><strong>Customer Address </strong> {{$customerdetail->business_street_address}}</p>
             <p><strong>Order No. </strong><span style="font-weight: 600; font-size: 30px">{{@$itemPackedDetail->order_number}}</span></p>
             <p><strong>Order Date </strong>{{date('d/m/Y', strtotime(@$itemPackedDetail->created_at))}}</p>

             <p><strong>Nug </strong><span style="font-weight: 600; font-size: 30px"><?php echo $n.'/'.$itemPackedDetail->total;?></span></p>
          </div>
        
        </div>
    
  </div>
	</div>
  
  <?php }?>
  </div>
</div>
</body>
</html>