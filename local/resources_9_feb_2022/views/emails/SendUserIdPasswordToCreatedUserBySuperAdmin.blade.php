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
<tr>
<td colspan="4" style=" padding:0px 0px 0px 0px">
<img  alt="Logo" height="30" src="/{{asset('/assets/img/logo/logo.png')}}" title="" /></td>
</tr>
<tr>
<td colspan="4" style="border-top: 1px solid #d8d8d8; font-family: arial">
<div style="margin-top:10px;"<strong style="font-size: 12px">Dear {{ucfirst($name)}},</strong>
<p style="font-size: 16px; margin: 15px 0px 10px 0px;"><strong>Please find below details for login; 
</strong></br>User Id = {{$email}} and password = {{$password}}</p>
<p style="font-size: 16px; margin: 15px 0px 10px 0px;"><strong><a href="{{route('login')}}" style="color:#00abed">Login here</a></strong></p>


</tr>
<tr>
<td colspan="4">
<div style="font-family: arial; font-size: 12px">
<strong style="color:#ccc">Best regards,</strong><br />
System Administrator.


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
