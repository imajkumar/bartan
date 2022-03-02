
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>{{ WEB_TITLE}} | Login</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
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
					<div class="login-header text-center">

					<img src="{{asset('assets/img/logo/logo.png')}}">
					
				
				</div>

					
				</div>
				<!-- end login-header -->
				<!-- begin login-content -->
				<div class="login-content">
					
				<div class="Sign text-center mb-4">
					
					<h3>Admin Login</h3>
					@foreach($errors->all() as $error)
						<span>{{ $error }}</span>
						@endforeach
					</div>
					@if (session('msg'))
					<div class="alert alert-success" role="alert">
					{{ session('msg') }}
					</div>
				@endif
				
					
				
                    <form class="margin-bottom-0" action="{{ route('login') }}" method="post">
                    @csrf
						<div class="form-group m-b-15">
							<input type="text" name="email" class="form-control form-control-lg control-rd" placeholder="Email Address" required />
						</div>
						<div class="form-group m-b-15">
							<input type="password" name="password" class="form-control form-control-lg control-rd" placeholder="Password" required />
						</div>
						<div class="checkbox checkbox-css m-b-30">
							<input type="checkbox" id="remember_me_checkbox" value=""  />
							<label for="remember_me_checkbox">
							Remember Me
							</label>
						</div>
						<div class="login-buttons">
							<button type="submit" class="btn btn-dark btn-block btn-lg btn-rd">Sign</button>
						</div>
						
						<hr />
						<p class="text-center text-grey-darker mb-0">
							&copy;  All Right Reserved {{date("Y")}}
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

	
</body>
</html>