<?php 
$customerdetail = get_customer_and_address_by__user_id($customerId);
//$customerdetail = DB::table('tbl_customers')->where('user_id', $customerId)->first();
//echo $customerId;
//pr($customerdetail);
$customer_name = ucfirst($customerdetail->cutomer_fname.' '.$customerdetail->cutomer_lname);

$country = getCountryByCountryId(@$customerdetail->business_country);
$state = get_stateNameByStateId(@$customerdetail->business_state);
$city = get_cityNameByCityId(@$customerdetail->business_city);
?>

<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="theme-color" content="#ef8813" />

<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&display=swap" rel="stylesheet">
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
<link rel="icon" href="../images/favicon.png" type="image/png" sizes="50x50">

</head>
<body style="background:#f2f2f2">
<table style="background: #333333; padding: 5px; width: 800px; display: table; margin:60px auto">
<tbody>
<tr>
<td>
<table style="width: 100%; background: #fff; border:1px solid #d8d8d8; padding: 10px 10px 10px 10px">
<tbody>
<!-- <tr>
<td colspan="4" style=" padding:0px 0px 0px 0px">
<img  alt="Logo" height="30" src="images/logo.png" title="" /></td>
</tr>
<tr> -->
<td colspan="4" style="border-top: 1px solid #d8d8d8; font-family: arial">
<div style="margin-top:10px;"><strong style="font-size: 12px">Hello {{$customer_name}},</strong>
<p style="font-size: 16px; margin: 15px 0px 10px 0px;">We thought you’d like to know that Subhiksh dispatched your item(s). Your order is on the way and will be delivered at below address.</p>
<p style="font-size: 16px; margin: 15px 0px 10px 0px;"> <address class="m-t-5 m-b-5">
                    <strong class="text-inverse">Customer name: {{$customer_name}}</strong><br />
                    STREET ADDRESS: {{$customerdetail->business_street_address}}<br />
                    COUNTRY:        {{$country->name}}, 
                    STATE:          {{$state->name}}, 
                    CITY:           {{$city->name}}<br/> 
                    ZIP CODE:       {{$customerdetail->business_postal_code}}<br />
                    PHONE NO.:      {{$customerdetail->phone}}<br />
                    EMAIL ID:       {{$customerdetail->email}}<br />
                    <!-- GST NO.:        {{$customerdetail->business_gst_number}}<br /> -->
                    <!-- {{-- Fax: (123) 456-7890 --}} -->
                </address></p>
<!-- <p style="font-size: 16px; margin: 15px 0px 10px 0px;">Click here for login: <strong><a href="{{url('/customer/login')}}" style="color:#00abed">Link</a></strong></p> -->


</tr>
<tr>
<td colspan="4">
<div style="font-family: arial; font-size: 12px">
<strong style="color:#ccc">We hope to see you again soon!,</strong><br />
<img  alt="Logo" height="30" src="{{asset('/assets/img/logo/logo.png')}}" title="" />


</div>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</body>
</html>
