<html>
<head>
<title> CCAvenue Payment Gateway Integration kit</title>
</head>
<body>
<center>



<?php
include 'Crypto.php';

	//error_reporting(0);
	
	$merchant_data='';
	 $working_key = env('CCA_WORKING_KEY') ;
	 $access_code = env('CCA_ACCESS_CODE');
	$orderId=$allReq['order_idd'];

	foreach ($allReq as $key => $value){
		$merchant_data.=$key.'='.$value.'&';
	}
	$merchant_data .= "order_id=".$orderId;

	$encrypted_data=encryptA($merchant_data,$working_key); 

?>
<form method="post" name="redirect" action="https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction">
<?php
echo "<input type=hidden name=encRequest value=$encrypted_data>";
echo "<input type=hidden name=access_code value=$access_code>";
echo"<input type= name=csrf_token value={{csrf_token()}}>";
?>
</form>
</center>
<script language='javascript'>document.redirect.submit();</script>
</body>
</html>
