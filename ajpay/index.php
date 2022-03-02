<?php 
require_once "config.php";
?>
<style>
body {
    max-width: 620px;
    margin: 20px auto;
    font-size: 0.95em;
    font-family: Arial;
}
.form-field {
    padding: 10px;
    width: 250px;
    border: #c1c0c0 1px solid;
    border-radius: 3px;
    margin: 0px 20px 20px 0px;
    background-color: white;
}
#ccav-payment-form {
    border: #c1c0c0 1px solid;
    padding: 30px;
}
.btn-payment {
    background: #009614;
    border: #038214 1px solid;
    padding: 8px 30px;
    border-radius: 3px;
    color: #FFF;
    cursor: pointer;
}
</style>
<h1>CCAvenue Payment Gateway Intgration</h1>
<div id="ccav-payment-form">
<form name="frmPayment" action="ccavRequestHandler.php" method="POST">
    <input type="hidden" name="merchant_id" value="<?php echo CCA_MERCHANT_ID; ?>"> 
    <input type="hidden" name="language" value="EN"> 
    <input type="hidden" name="amount" value="10">
    <input type="hidden" name="currency" value="INR"> 
    <!-- <input type="hidden" name="redirect_url" value="https://bartan.com/ajpay/payment-response.php">  -->
    <input type="hidden" name="redirect_url" value="https://bartan.com/ajpay/ccavResponseHandler.php"> 

    <input type="hidden" name="cancel_url" value="https://bartan.com/ajpay/payment-cancel.php"> 
    
    <div>
    <input type="text" name="billing_name" value="Ajay Kumar" class="form-field" Placeholder="Billing Name"> 
    <input type="text" name="billing_address" value="Delhi-96" class="form-field" Placeholder="Billing Address">
    </div>
    <div>
    <input type="text" name="billing_state" value="Delhi" class="form-field" Placeholder="State"> 
    <input type="text" name="billing_zip" value="110096" class="form-field" Placeholder="Zipcode">
    </div>
    <div>
    <input type="text" name="billing_country" value="India" class="form-field" Placeholder="Country">
    <input type="text" name="billing_tel" value="7703886088" class="form-field" Placeholder="Phone">
    </div> 
    <div>
    <input type="text" name="billing_email" value="ajayit2020@gmail.com" class="form-field" Placeholder="Email">
    </div>
    <div>
    <button class="btn-payment" type="submit">Pay Now</button>
    </div>
</form>
</div>
