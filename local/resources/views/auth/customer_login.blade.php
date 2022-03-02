
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ WEB_TITLE}} | Login</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('/assets/img/icon/fev.png') }}" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{BACKEND.'css/apple/app.min.css'}}" rel="stylesheet" />
	<link href="{{BACKEND.'plugins/ionicons/css/ionicons.min.css'}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	<style>
        .modal {
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: rgba( 255, 255, 255, .8 ) 
                        url("{{ BACKEND.'img/coming-soon/ajax-loader1.gif'}}") 
                        50% 50% 
                        no-repeat;
        }

        body.loading .modal {
            overflow: hidden;   
        }

        body.loading .modal {
            display: block;
        }
    </style>
</head>
<body class="pace-top">
	<div class="modal"><!-- Place at bottom of page --></div>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->
	
	<!-- begin #page-container -->
	<div id="page-container" class="fade">
		<!-- begin login -->
		<div class="login login-with-news-feed">
			<!-- begin news-feed -->
			<div class="news-feed">
				<div class="news-image" style="background-image: url({{BACKEND.'img/login-bg/login-bg-11.jpg'}})"></div>
				<div class="news-caption">
					<h4 class="caption-title"><b>{{WEB_TITLE}}</b> </h4>
					<!-- <p>
						Download the Color Admin app for iPhone®, iPad®, and Android™. Lorem ipsum dolor sit amet, consectetur adipiscing elit.
					</p> -->
				</div>
			</div>
			<!-- end news-feed -->
			<!-- begin right-content -->
			<div class="right-content">
				<!-- begin login-header -->
				<div class="login-header text-center">

					<img src="{{asset('assets/img/logo/logo.png')}}">
					
				
				</div>
				<!-- end login-header -->
				<!-- begin login-content -->
				<div class="login-content">
					
                    <form method="post" class="margin-bottom-0" action="{{ route('sendOtp') }}" id="sendOtpForCustomer" >
					@csrf

					<div class="Sign text-center">
					
					<h3>Sign in into your account</h3>
					</div>
					<div dir="auto" class="styled-Function styled-Function css-76zvg2 pb-3" style="color: rgb(99, 115, 129); font-family: Roboto; font-size: 14px; font-weight: normal; text-align: center;">Enter your 10-digit mobile number or Email id to receive the verification code.</div>
					
						<div class="form-group m-b-15">
							<input type="text" name="mobile" class="form-control form-control-lg control-rd" placeholder="Mobile Number or Email id" required />
						</div>
						
						{{-- <div class="checkbox checkbox-css m-b-30">
							<input type="checkbox" id="remember_me_checkbox" value=""  />
							<label for="remember_me_checkbox">
							Remember Me
							</label>
						</div> --}}
						<div class="login-buttons">
							<button type="submit" id="senOtpBtn" class="btn btn-dark btn-block btn-lg btn-rd"><i class="ion-ios-paper-plane"></i> Send OTP</button>
						</div>
						
						<hr />
						<p class="text-center text-grey-darker mb-0">
							&copy;  All Right Reserved {{date("Y")}}
						</p>
                    </form>
                    <form class="margin-bottom-0" action="{{ route('verifyOtp') }}" id="verifyOtp" method="post" style="display:none">
					   
						<input type="hidden" name="mobile" id="mobileForVerify"/>
						@csrf
						<div dir="auto" id="verifyOtpMsg" class="styled-Function styled-Function css-76zvg2 text-center m-b-20"></div>
						<!-- <a href="javascript:void();" id="changeNumber" class="pull-right">Change</a> -->
                            <div class="form-group m-b-15">
                                <input type="text" name="otp" class="form-control form-control-lg control-rd" placeholder="Please enter OTP" required />
                            </div>
                            
						
                           
                            <div class="login-buttons">
                                <button type="submit" class="btn btn-dark btn-block btn-lg btn-rd"><i class="fa fa-check-circle"></i> Verify OTP</button>
                                <a href="javascript:void();" onclick="resendOtp()" class="btn btn-block btn-lg btn-rd">Resend OTP</a>
                            </div>
                            
                            <hr />
                            <p class="text-center text-grey-darker mb-0">
                                &copy;  All Right Reserved 2020
                            </p>
                        </form>
				</div>
				<!-- end login-content -->
			</div>
			<!-- end right-container -->
		</div>
		<!-- end login -->
		
		
		
		<!-- begin scroll to top btn -->
		<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
		<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{BACKEND.'js/app.min.js'}}"></script>
	<script src="{{BACKEND.'js/theme/apple.min.js'}}"></script>

	<!-- ================== END BASE JS ================== -->
<script>
	//start send otp for customer
	BASE_URL = "{{URL::to('/')}}"; 
	body = $("body");
	
	//alert(BASE_URL);
    
	$('#changeNumber').click(function(){
		$('#sendOtpForCustomer').show();
		$('#verifyOtp').css('display', 'none');
	});

	function resendOtp(){
		
		$.ajax({
                type: 'POST',
                url: BASE_URL + '/customer/resendOtp',
                data: {
					'_token': $('meta[name="csrf-token"]').attr('content'),
					'mobile': $('#mobileForVerify').val()
				},
				beforeSend: function() { body.addClass("loading"); },
            	complete: function() { body.removeClass("loading"); },

                success: function(responce) {

                    if (responce['status'] == 'success') {
						toastr.success(responce['msg']);
                        
                        $('#mobileForVerify').val(responce['mobile']);
                        

                    } else {
						toastr.warning(responce['msg']);
                        

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${item}</strong></br>`;
                    });
					toastr.error(errorHtml);
					//$('#sendOtpForCustomer').show();

                }

            
		});
	}

    //function sendOtpForCustomer() {
        $('#sendOtpForCustomer').on('submit', function(e) {
            
			e.preventDefault();
			$('#verifyOtp').css('display', 'none');
            $('#verifyOtp').css('display', 'none');
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/customer/sendOtp',
				data: $(this).serialize(),
				beforeSend: function() { body.addClass("loading"); },
            	complete: function() { body.removeClass("loading"); },

                success: function(responce) {

                    if (responce['status'] == 'success') {
						$('#sendOtpForCustomer').hide();
                        toastr.success(responce['msg']);
                        $('#verifyOtpMsg').html('Enter 6 digit verification code sent to '+responce['mobile']);
                        $('#mobileForVerify').val(responce['mobile']);
                        $('#verifyOtp').css('display', 'block');

                        //window.location.replace(responce['url']);

                    } else {
						$('#sendOtpForCustomer').show();
                        toastr.warning(responce['msg']);
                        $('#verifyOtp').css('display', 'none');

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${item}</strong></br>`;
                    });
					toastr.error(errorHtml);
					$('#sendOtpForCustomer').show();

                }

            })

        });
    //}


    

    //function verifyOtp() {
        $('#verifyOtp').on('submit', function(e) {

            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: BASE_URL + '/customer/verifyOtp',
				data: $(this).serialize(),
				beforeSend: function() { body.addClass("loading"); },
            	complete: function() { body.removeClass("loading"); },
				

                success: function(responce) {

                    if (responce['status'] == 'success') {

						localStorage.clear();
                        toastr.success(responce['msg']);

                        
						window.location.replace(responce['url']);
						$('#verifyOtp').css('display', 'none');

                    } else {

                        toastr.warning(responce['msg']);
                        $('#mobileForVerify').val(responce['mobile']);
                        $('#verifyOtp').css('display', 'block');

                    }
                },
                error: function(xhr, status, error) {

                    let errorHtml = '';
                    $.each(xhr.responseJSON.errors, function(key, item) {
                        errorHtml += `<strong>${item}</strong></br>`;
                    });
                    toastr.error(errorHtml);

                }

            })

        });
    //}


</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
</body>
</html>