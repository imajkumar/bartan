<!-- BEGIN #page-header -->
<div id="page-header" class="section-container page-header-container bg-black">
	<!-- BEGIN page-header-cover -->
	<div class="page-header-cover">

		<img src="{{FRONT.'img/cover/cover-15.jpg'}}" alt="" />
	</div>
	<!-- END page-header-cover -->
	<!-- BEGIN container -->
	<div class="container">
		<?php //pr($brandDetail->brand_img);
		?>

	</div>
	<!-- END container -->
</div>
<!-- BEGIN #page-header -->
<div id="product" class="section-container p-t-20">
	<!-- BEGIN container -->
	<div class="container">
		<!-- BEGIN breadcrumb -->
		<!-- <ul class="breadcrumb m-b-10 f-s-12">
					<li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
				
					<li class="breadcrumb-item active">Contact Us</li>
				</ul> -->
		<!-- END breadcrumb -->
		<!-- BEGIN row -->
		<div class="row row-space-30">
			<!-- BEGIN col-8 -->
			<div class="col-md-8">
				<h4 class="m-t-0 text-center"><b>CONTACT US</b></h4>
				<h2 class="m-t-0 text-center" id="contactMsg"> </h2>

				<form class="form-horizontal" name="contact_us_form" action="{{route('saveContactUs')}}" id="saveContactUs" method="POST">
					@csrf
					<div class="form-group row">
						<label class="col-form-label col-md-3 text-lg-right">Name <span class="text-danger">*</span></label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="name" id="name">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-3 text-lg-right">Email <span class="text-danger">*</span></label>
						<div class="col-md-7">
							<input type="email" class="form-control" name="email" value="{{@Auth::user()->email}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-3 text-lg-right">Mobile number <span class="text-danger">*</span></label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="mobile_no" value="{{@Auth::user()->mobile}}">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-3 text-lg-right">Subject <span class="text-danger">*</span></label>
						<div class="col-md-7">
							<input type="text" class="form-control" name="subject">
						</div>
					</div>
					<div class="form-group row">
						<label class="col-form-label col-md-3 text-lg-right">Message <span class="text-danger">*</span></label>
						<div class="col-md-7">
							<textarea class="form-control" rows="8" name="message"></textarea>
						</div>
					</div>
					<div class="form-group row">

						<div class="col-md-7">
							@if(config('services.recaptcha.key'))
							<div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}" >
							</div>
							<input type="hidden" class="hiddenRecaptcha required" name="hiddenRecaptcha" id="hiddenRecaptcha">
							@endif
						</div>
					</div>

					
 
@if ($errors->has('g-recaptcha-response'))
    <span class="help-block">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
    </span>
@endif


					<div class="form-group row">
						<label class="col-form-label col-md-3"></label>
						<div class="col-md-7">
							<button type="submit" class="btn btn-inverse btn-theme">SEND MESSAGE</button>
						</div>
					</div>
				</form>
			</div>
			<!-- END col-8 -->
			<!-- BEGIN col-4 -->
			<div class="col-md-6">
				<h4 class="m-b-20">Our Contacts</h4>
				<!-- 	<div class="embed-responsive embed-responsive-16by9 m-b-15">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3500.2188577110346!2d77.01947971440855!3d28.683099088542736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d03ae00439a1b%3A0x6316c5621986fe3e!2sRohtak%20Rd!5e0!3m2!1sen!2sin!4v1608705035546!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
						</div> -->
				<div><b>Subhiksh Steel Impex Pvt. Ltd. </b></div>
				<p class="m-b-15">
					<i class="fa fa-map-marker xlarge"></i>H.No.-2, KH NO.-12/11, <br>AMANPURI TEACHER COLONY, NANGLOI, DELHI-110041.
				</p>
				<div><b>Email</b></div>
				<p class="m-b-15">
					<i class="fa fa-envelope"></i> <a href="mailto:info@subhiksh.com" class="text-inverse">info@subhiksh.com</a><br>

				</p>
				<div><b>Mobile</b></div>
				<p class="m-b-15">
					<i class="fa fa-mobile xxxlarge"></i> <a href="tel:+91-9910247800" class="text-inverse">+91-9910247800</a><br>
					<!-- 	<i class="fa fa-mobile xxxlarge"></i> <a href="tel:+91-9311048811" class="text-inverse">+91-9311048811</a><br>
							<br> -->
				</p>
				<!-- <div><b>Web</b></div>
						<p class="m-b-15">
							<i class="fa fa-globe"></i><a href="www.subhikshsteel.com" class="text-inverse">www.subhikshsteel.com</a><br>
							<i class="fa fa-globe"></i> <a href="https://www.exportersindia.com/luxmi-bartan-bhandar/" class="text-inverse">www.exportersindia.com/luxmi-bartan-bhandar/</a><br>
							<br>
						</p> -->
				<!-- <div class="m-b-5"><b>Social Network</b></div>
						<p class="m-b-15">
							<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-facebook"></i></a>
							<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-twitter"></i></a>
							<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-google-plus"></i></a>
							<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-instagram"></i></a>
							<a href="#" class="btn btn-icon btn-white btn-circle"><i class="fab fa-dribbble"></i></a>
						</p> -->
			</div>
			<div class="col-md-6">

				<div class="embed-responsive embed-responsive-16by9 m-b-15">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3500.2188577110346!2d77.01947971440855!3d28.683099088542736!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390d03ae00439a1b%3A0x6316c5621986fe3e!2sRohtak%20Rd!5e0!3m2!1sen!2sin!4v1608705035546!5m2!1sen!2sin" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
				</div>

			</div>
			<!-- END col-4 -->
		</div>
		<!-- END row -->
	</div>
	<!-- END row -->
</div>