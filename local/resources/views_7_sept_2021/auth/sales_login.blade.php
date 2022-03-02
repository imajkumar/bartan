
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ WEB_TITLE}} | login</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('/assets/img/icon/fev.png') }}" />
	
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{BACKEND.'css/apple/app.min.css'}}" rel="stylesheet" />
	<link href="{{BACKEND.'plugins/ionicons/css/ionicons.min.css'}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
</head>
<body class="pace-top">
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
				<div class="login-header">
					<div class="brand">
						<span class="logo"><i class="ion-ios-cloud"></i></span> <b></b> Sales Login
						<small></small>
						
					</div>
					<div class="icon">
						<i class="fa fa-sign-in-alt"></i>
					</div>
				</div>
				<!-- end login-header -->
				<!-- begin login-content -->
				<div class="login-content">
				@if (session('msg'))
					<div class="alert alert-success" role="alert">
					{{ session('msg') }}
					</div>
				@endif
				<ul>
					@foreach($errors->all() as $error)
						<li>{{ $error }}</li>
						@endforeach
				</ul>
                <form method="post" class="margin-bottom-0" action="{{ route('sendOtpForSales') }}" id="sendOtpForCustomer" >
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
							&copy;  All Right Reserved 2020
						</p>
                    </form>
                    <form class="margin-bottom-0" action="{{ route('verifyOtpForSales') }}" id="verifyOtp" method="post" style="display:none">
					   
						<input type="hidden" name="mobile" id="mobileForVerify"/>
						@csrf
						<div dir="auto" id="verifyOtpMsg" class="styled-Function styled-Function css-76zvg2 text-center m-b-20"></div>
						<!-- <a href="javascript:void();" id="changeNumber" class="pull-right">Change</a> -->
                            
                            <div class="form-group m-b-15">
                                <input type="text" name="mobile" id="verifiedMobileOrEmail" class="form-control form-control-lg control-rd" placeholder="Mobile Number or Email id" required />
                            </div>

                            <!-- <div class="form-group m-b-15">
                                <input type="password" name="password" id="password" class="form-control form-control-lg control-rd" placeholder="Password" required />
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                
                            </div> -->
                            
                            <div class="form-group m-b-15">
                                <input type="text" name="otp" class="form-control form-control-lg control-rd" placeholder="Please enter OTP" required />
                            </div>
                            
						
                           
                            <div class="login-buttons">
                                <button type="submit" class="btn btn-dark btn-block btn-lg btn-rd"><i class="fa fa-check-circle"></i> Verify OTP</button>
                                <a href="javascript:void();" onclick="resendOtpForSales()" class="btn btn-block btn-lg btn-rd">Resend OTP</a>
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
		
		<!-- begin theme-panel -->
		<!-- <div class="theme-panel theme-panel-lg">
			<a href="javascript:;" data-click="theme-panel-expand" class="theme-collapse-btn"><i class="fa fa-cog"></i></a>
			<div class="theme-panel-content">
				<h5>App Settings</h5><ul class="theme-list clearfix">
					<li><a href="javascript:;" class="bg-red" data-theme="red" data-theme-file="../assets/css/apple/theme/red.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Red">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-pink" data-theme="pink" data-theme-file="../assets/css/apple/theme/pink.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Pink">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-orange" data-theme="orange" data-theme-file="../assets/css/apple/theme/orange.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Orange">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-yellow" data-theme="yellow" data-theme-file="../assets/css/apple/theme/yellow.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Yellow">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-lime" data-theme="lime" data-theme-file="../assets/css/apple/theme/lime.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Lime">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-green" data-theme="green" data-theme-file="../assets/css/apple/theme/green.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Green">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-teal" data-theme="teal" data-theme-file="../assets/css/apple/theme/teal.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Teal">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-aqua" data-theme="aqua" data-theme-file="../assets/css/apple/theme/aqua.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Aqua">&nbsp;</a></li>
					<li class="active"><a href="javascript:;" class="bg-blue" data-theme="default" data-theme-file="" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Default">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-purple" data-theme="purple" data-theme-file="../assets/css/apple/theme/purple.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Purple">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-indigo" data-theme="indigo" data-theme-file="../assets/css/apple/theme/indigo.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Indigo">&nbsp;</a></li>
					<li><a href="javascript:;" class="bg-black" data-theme="black" data-theme-file="../assets/css/apple/theme/black.min.css" data-click="theme-selector" data-toggle="tooltip" data-trigger="hover" data-container="body" data-title="Black">&nbsp;</a></li>
				</ul>
				<div class="divider"></div>
				<div class="row m-t-10">
					<div class="col-6 control-label text-inverse f-w-600">Header Fixed</div>
					<div class="col-6 d-flex">
						<div class="custom-control custom-switch ml-auto">
							<input type="checkbox" class="custom-control-input" name="header-fixed" id="headerFixed" value="1" checked />
							<label class="custom-control-label" for="headerFixed">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-6 control-label text-inverse f-w-600">Header Inverse</div>
					<div class="col-6 d-flex">
						<div class="custom-control custom-switch ml-auto">
							<input type="checkbox" class="custom-control-input" name="header-inverse" id="headerInverse" value="1" />
							<label class="custom-control-label" for="headerInverse">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-6 control-label text-inverse f-w-600">Sidebar Fixed</div>
					<div class="col-6 d-flex">
						<div class="custom-control custom-switch ml-auto">
							<input type="checkbox" class="custom-control-input" name="sidebar-fixed" id="sidebarFixed" value="1" checked />
							<label class="custom-control-label" for="sidebarFixed">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-6 control-label text-inverse f-w-600">Sidebar Grid</div>
					<div class="col-6 d-flex">
						<div class="custom-control custom-switch ml-auto">
							<input type="checkbox" class="custom-control-input" name="sidebar-grid" id="sidebarGrid" value="1" />
							<label class="custom-control-label" for="sidebarGrid">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="row m-t-10">
					<div class="col-md-6 control-label text-inverse f-w-600">Sidebar Gradient</div>
					<div class="col-md-6 d-flex">
						<div class="custom-control custom-switch ml-auto">
							<input type="checkbox" class="custom-control-input" name="sidebar-gradient" id="sidebarGradient" value="1" />
							<label class="custom-control-label" for="sidebarGradient">&nbsp;</label>
						</div>
					</div>
				</div>
				<div class="divider"></div>
				<h5>Admin Design (5)</h5>
				<div class="theme-version">
					<a href="../template_html/index_v2.html">
						<span style="background-image: url(../assets/img/theme/default.jpg);"></span>
					</a>
					<a href="../template_transparent/index_v2.html">
						<span style="background-image: url(../assets/img/theme/transparent.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../template_apple/index_v2.html" class="active">
						<span style="background-image: url(../assets/img/theme/apple.jpg);"></span>
					</a>
					<a href="../template_material/index_v2.html">
						<span style="background-image: url(../assets/img/theme/material.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../template_facebook/index_v2.html">
						<span style="background-image: url(../assets/img/theme/facebook.jpg);"></span>
					</a>
					<a href="../template_google/index_v2.html">
						<span style="background-image: url(../assets/img/theme/google.jpg);"></span>
					</a>
				</div>
				<div class="divider"></div>
				<h5>Language Version (7)</h5>
				<div class="theme-version">
					<a href="../template_html/index_v2.html" class="active">
						<span style="background-image: url(../assets/img/version/html.jpg);"></span>
					</a>
					<a href="../template_ajax/index_v2.html">
						<span style="background-image: url(../assets/img/version/ajax.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../template_angularjs/index_v2.html">
						<span style="background-image: url(../assets/img/version/angular1x.jpg);"></span>
					</a>
					<a href="../template_angularjs8/index_v2.html">
						<span style="background-image: url(../assets/img/version/angular8x.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../template_laravel/index_v2.html">
						<span style="background-image: url(../assets/img/version/laravel.jpg);"></span>
					</a>
					<a href="../template_vuejs/index_v2.html">
						<span style="background-image: url(../assets/img/version/vuejs.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../template_reactjs/index_v2.html">
						<span style="background-image: url(../assets/img/version/reactjs.jpg);"></span>
					</a>
				</div>
				<div class="divider"></div>
				<h5>Frontend Design (4)</h5>
				<div class="theme-version">
					<a href="../../../frontend/template/template_one_page_parallax/index.html">
						<span style="background-image: url(../assets/img/theme/one-page-parallax.jpg);"></span>
					</a>
					<a href="../../../frontend/template/template_e_commerce/index.html">
						<span style="background-image: url(../assets/img/theme/e-commerce.jpg);"></span>
					</a>
				</div>
				<div class="theme-version">
					<a href="../../../frontend/template/template_blog/index.html">
						<span style="background-image: url(../assets/img/theme/blog.jpg);"></span>
					</a>
					<a href="../../../frontend/template/template_forum/index.html">
						<span style="background-image: url(../assets/img/theme/forum.jpg);"></span>
					</a>
				</div>
				<div class="divider"></div>
				<div class="row m-t-10">
					<div class="col-md-12">
						<a href="https://seantheme.com/color-admin/documentation/" class="btn btn-inverse btn-block btn-rounded" target="_blank"><b>Documentation</b></a>
						<a href="javascript:;" class="btn btn-default btn-block btn-rounded" data-click="reset-local-storage"><b>Reset Local Storage</b></a>
					</div>
				</div>
			</div>
		</div> -->
		<!-- end theme-panel -->
		
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

	function resendOtpForSales(){
		
		$.ajax({
                type: 'POST',
                url: BASE_URL + '/customer/resendOtpForSales',
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
                        $('#verifiedMobileOrEmail').val(responce['mobile']);
                        

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
                url: BASE_URL + '/customer/sendOtpForSales',
				data: $(this).serialize(),
				beforeSend: function() { body.addClass("loading"); },
            	complete: function() { body.removeClass("loading"); },

                success: function(responce) {

                    if (responce['status'] == 'success') {
						$('#sendOtpForCustomer').hide();
                        toastr.success(responce['msg']);
                        $('#verifyOtpMsg').html('Enter 6 digit verification code sent to '+responce['mobile']);
                        $('#mobileForVerify').val(responce['mobile']);
                        $('#verifiedMobileOrEmail').val(responce['mobile']);
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
                url: BASE_URL + '/customer/verifyOtpForSales',
				data: $(this).serialize(),
				beforeSend: function() { body.addClass("loading"); },
            	complete: function() { body.removeClass("loading"); },
				

                success: function(responce) {

                    if (responce['status'] == 'success') {

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
	$(document).bind("contextmenu",function(e) {
 e.preventDefault();
});

$(document).keydown(function(e){
    if(e.which === 123){
       return false;
    }
});

document.onkeydown = function(e) {
	
	if (e.ctrlKey && (e.keyCode === 85 ) || e.keyCode === 73) {
		return false;
	}
};
</script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

</body>
</html>