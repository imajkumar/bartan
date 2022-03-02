<?php
//pr(Auth::user());
$customer = session()->get('customer');
// pr($customer);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<title> Dashboard</title>
	<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
<meta name="theme-color" content="#e30613">
	<meta name="msapplication-TileColor" content="#e30613">
    <meta name="msapplication-navbutton-color" content="#e30613">
    <meta name="apple-mobile-web-app-status-bar-style" content="#e30613">
	<meta name="BASE_URL" content="{{ url('/') }}" />

	
	<meta name="UUID" content="{{ @Auth::user()->id }}" />

	<meta name="csrf-token" content="{{ csrf_token() }}">

    
	<link href="../assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
	


	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{ BACKEND.'css/apple/app.min.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/ionicons/css/ionicons.min.css'}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/css/ui.jqgrid.min.css"> -->


	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<!-- <link href="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap.css'}}" rel="stylesheet" /> -->
	<link href="{{ BACKEND.'plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/gritter/css/jquery.gritter.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/jstree/dist/themes/default/style.min.css'}}" rel="stylesheet" />

	<!-- ================== END PAGE LEVEL STYLE ================== -->

	<!-- ================== BEGIN PAGE gallery upload CSS STYLE ================== -->
	<link href="{{asset('assets/plugins/blueimp-gallery/css/blueimp-gallery.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/blueimp-file-upload/css/jquery.fileupload.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/blueimp-file-upload/css/jquery.fileupload-ui.css')}}" rel="stylesheet" />

	<!-- ================== END PAGE gallery upload CSS STYLE ================== -->
	<link href="../assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />

	<link href="{{asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css')}}" rel="stylesheet" />



	<!-- ================== BEGIN PAGE GALLERY ================== -->
	<link href="{{asset('assets/plugins/lightbox2/dist/css/lightbox.css')}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/simple-line-icons/css/simple-line-icons.css'}}" rel="stylesheet" />
	<!-- ================== END PAGE GALLERY ================== -->
	<link href="{{BACKEND.'plugins/smartwizard/dist/css/smart_wizard.css'}}" rel="stylesheet" />
	<link href="{{BACKEND.'plugins/dropzone/dist/min/dropzone.min.css'}}" rel="stylesheet" />
	<link href="{{BACKEND.'plugins/select2/dist/css/select2.css'}}" rel="stylesheet" />

	<link rel="shortcut icon" href="{{ asset('/assets/img/icon/fev.png') }}" />
	
	<!-- <link rel="stylesheet" href="http://cdn.syncfusion.com/13.2.0.29/js/web/flat-azure/ej.web.all.min.css" /> -->
	<style>
		.required-star {
			color: red;
		}

		.form-layout {
			margin-left: 10px;
			margin-right: 10px;
		}
	</style>

	<!-- <style>
		.modal {
			display: none;
			position: fixed;
			z-index: 1000;
			top: 0;
			left: 0;
			height: 100%;
			width: 100%;
			background: rgba(255, 255, 255, .8) url("{{ BACKEND.'img/coming-soon/ajax-loader1.gif'}}") 50% 50% no-repeat;
		}

		body.loading .modal {
			overflow: hidden;
		}

		body.loading .modal {
			display: block;
		}

		.error {
			
			height: 10vh;
			
		}
	</style> -->
		<style>
		.error {
			
			height: 10vh;
			color:red
			
		}
		</style>
</head>

<body>
	<div class="modal">
		<!-- Place at bottom of page -->
	</div>
	<!-- begin #page-loader -->
	<div id="page-loader" class="fade show">
		<span class="spinner"></span>
	</div>
	<!-- end #page-loader -->

	@partial('header')

	@partial('leftside')
	@content()

	@partial('footer')




	{{-- start model add item image--}}
	<div class="modal fade" id="addItemImageByModel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Add Image</h4>
					<button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				</div>
				<div class="modal-body">
					<form id="formAttribute" method="post">
						@csrf

					</form>
				</div>
				<div class="modal-footer">
					<button type="button" id="saveAttribute" class="btn btn-primary">Submit</button>
					<button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
	{{-- end model add item image --}}

	<!-- begin scroll to top btn -->
	<a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
	<!-- end scroll to top btn -->
	</div>
	<!-- end page container -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{ BACKEND.'js/app.min.js'}}"></script>

	<script src="{{ BACKEND.'js/theme/apple.min.js'}}"></script>
	<!-- ================== END BASE JS ================== -->



	{{-- gallery --}}
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->


	<script src="{{asset('assets/plugins/blueimp-file-upload/js/vendor/jquery.ui.widget.js')}}"></script>
	<!-- <script src="{{asset('assets/plugins/blueimp-tmpl/js/tmpl.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-load-image/js/load-image.all.min.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-canvas-to-blob/js/canvas-to-blob.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-gallery/js/jquery.blueimp-gallery.min.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.iframe-transport.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-process.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-image.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-audio.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-video.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-validate.js')}}"></script>
	<script src="{{asset('assets/plugins/blueimp-file-upload/js/jquery.fileupload-ui.js')}}"></script> -->
	<!--[if (gte IE 8)&(lt IE 10)]>
		<script src="assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js')}}"></script>
	<![endif]-->
	<!-- <script src="{{asset('assets/js/demo/form-multiple-upload.demo.js')}}"></script> -->
	<!-- ================== END PAGE LEVEL JS ================== -->
	{{-- end gallery --}}


	<script type="text/javascript">
		BASE_URL = $('meta[name="BASE_URL"]').attr('content');
		UID = $('meta[name="UUID"]').attr('content');
		_TOKEN = $('meta[name="csrf-token"]').attr('content');
	</script>

	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ BACKEND.'plugins/gritter/js/jquery.gritter.js'}}"></script>
	<!-- <script src="{{ BACKEND.'plugins/flot/jquery.flot.js'}}"></script>
	<script src="{{ BACKEND.'plugins/flot/jquery.flot.time.js'}}"></script>
	<script src="{{ BACKEND.'plugins/flot/jquery.flot.resize.js'}}"></script>
	<script src="{{ BACKEND.'plugins/flot/jquery.flot.pie.js'}}"></script>
	<script src="{{ BACKEND.'plugins/jquery-sparkline/jquery.sparkline.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap-world-mill.js'}}"></script> -->
	<script src="{{ BACKEND.'plugins/jquery-sparkline/jquery.sparkline.min.js'}}"></script>
	
	<script src="{{ BACKEND.'plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js'}}"></script>

	<script src="{{ BACKEND.'plugins/jstree/dist/jstree.min.js'}}"></script>


	<script src="{{asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

	{{-- <script src="../assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script> --}}
	<script src="{{ BACKEND.'js/demo/table-manage-default.demo.js'}}"></script>




	<!-- ================== BEGIN PAGE GALLERY JS ================== -->
	<script src="{{asset('assets/plugins/isotope-layout/dist/isotope.pkgd.min.js')}}"></script>
	<script src="{{asset('assets/plugins/lightbox2/dist/js/lightbox.min.js')}}"></script>
	<script src="{{asset('assets/js/demo/gallery.demo.js')}}"></script>
	<!-- ================== END PAGE GALLERY JS ================== -->
	<script src="{{ BACKEND.'js/jquery.validate.js'}}"></script>
	<script src="{{BACKEND.'plugins/smartwizard/dist/js/jquery.smartWizard.js'}}"></script>
	<script src="{{BACKEND.'js/demo/form-wizards.demo.js'}}"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/free-jqgrid/4.15.5/jquery.jqgrid.min.js"></script> -->
	



	<script src="{{ BACKEND.'js/appjs/ui-tree.demo.js'}}"></script>

	

	<script src="{{ BACKEND.'js/appjs/dashboard.js'}}"></script>
	<script src="{{ BACKEND.'plugins/ckeditor/ckeditor.js'}}"></script>
	

	<script src="{{ BACKEND.'js/ecom-backend.js'}}"></script>

	
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="{{ BACKEND.'plugins/jquery-migrate/dist/jquery-migrate.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/moment/min/moment.min.js'}}"></script>
	
	<script src="{{ BACKEND.'plugins/ion-rangeslider/js/ion.rangeSlider.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/jquery.maskedinput/src/jquery.maskedinput.js'}}"></script>
	<script src="{{ BACKEND.'plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/pwstrength-bootstrap/dist/pwstrength-bootstrap.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/@danielfarrell/bootstrap-combobox/js/bootstrap-combobox.js'}}"></script>
	<script src="{{ BACKEND.'plugins/bootstrap-select/dist/js/bootstrap-select.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/tag-it/js/tag-it.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/bootstrap-daterangepicker/daterangepicker.js'}}"></script>
	<script src="{{ BACKEND.'plugins/select2/dist/js/select2.min.js'}}"></script>
	
	<script src="{{ BACKEND.'js/demo/form-plugins.demo.js'}}"></script>



	<!-- <script src="{{ BACKEND.'plugins/parsleyjs/dist/parsley.min.js'}}"></script>
	<script src="{{ BACKEND.'plugins/highlight.js/highlight.min.js'}}"></script>
	<script src="{{ BACKEND.'js/demo/render.highlight.js'}}"></script> -->
	<script src="{{ BACKEND.'plugins/dropzone/dist/min/dropzone.min.js'}}"></script>

	

	<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>

	{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.4/select2.min.js"></script>
    <script src="https://rawgit.com/wasikuss/select2-multi-checkboxes/select2-3.5.x/select2.multi-checkboxes.js"></script> --}}
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script> -->

	<!-- <script src="{{ BACKEND.'js/demo/profile.demo.js'}}"></script> -->
	<script src="{{ BACKEND.'js/appjs/ecom.js'}}"></script>
	<!-- <link rel="shortcut icon" href="{{ asset('/assets/img/logo/logo.png') }}" /> -->


	

	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/additional-methods.js"></script>

	{{-- <script type="text/javascript">
	$(document).ready(function() {
		
	$('.select2-original').select2({
	placeholder: "Choose elements",
	width: "100%"
	})
	});
	</script> --}}
	<!-- <script type="text/javascript">
		$(document).ready(function() {
			toastr.options.timeOut = 5000; // 1.5s
			toastr.info('Page Loaded!');

		});
	</script> -->

<script>
	$(document).ready(function(){
		var validation = true;
		$('#cutomer_fname').blur(function () {
			var data = $(this).val();
			$('#cutomer_fname_errorMsg').remove();
			if(data == ""){
				$('#cutomer_fname').after('<div id="cutomer_fname_errorMsg" class="error">Please fill your First Name.</div>');
				$('.sw-btn-next').addClass('disabled');
				$('.sw-btn-next').attr('disabled',true);
				
				validation = false;
				return false;
			}else{
				
				$('.sw-btn-next').attr('disabled',false);
				$('.sw-btn-next').removeClass('disabled');
				$('#cutomer_fname_errorMsg').html(' ');
				return true;
			}
		});
		$('#cutomer_lname').blur(function () {
			var data = $(this).val();
			$('#cutomer_lname_errorMsg').remove();
			if(data == ""){
				$('#cutomer_lname').after('<div id="cutomer_lname_errorMsg" class="error">Please fill your Last Name.</div>');
				$('.sw-btn-next').addClass('disabled');
				$('.sw-btn-next').attr('disabled',true);
				validation = false;
				return false;
			}else{
				$('.sw-btn-next').attr('disabled',false);
				$('.sw-btn-next').removeClass('disabled');
				$('#cutomer_lname_errorMsg').html(' ');
			return true;
			}
		});
		$('#phone').blur(function () {
			var data = $(this).val();
			$('#phone_errorMsg').remove();
			valid_phone = /^[0-9]+$/.test(data);
			if(data == ""){
				$('#phone').after('<div id="phone_errorMsg" class="error">Please fill your Mobile Number.</div>');
				$('.sw-btn-next').addClass('disabled');
				$('.sw-btn-next').attr('disabled',true);
				validation = false;
				return false;
			}else if(!valid_phone)
      		{
				  
				$('#phone').after('<div id="phone_errorMsg" class="error">Please fill your Valid Mobile Number.</div>');
				$('.sw-btn-next').addClass('disabled');
				$('.sw-btn-next').attr('disabled',true);
				validation = false;

			  }else{
				$('.sw-btn-next').attr('disabled',false);
				$('.sw-btn-next').removeClass('disabled');
				$('#phone_errorMsg').html(' ');
				return true;
			}
		});
		// $('#email').blur(function () {
		// 	var data = $(this).val();
		// 	$('#email_errorMsg').remove();
		// 	var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(data);
 
		// 	if(data == "" || !emailReg){
		// 		$('#email').after('<div id="email_errorMsg" class="error">Please fill your Email id.</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#email_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		



		$('.sw-btn-next').hover(function () {
			var fname = $('#cutomer_fname').val();
			var lname = $('#cutomer_lname').val();
			var phone = $('#phone').val();
			//var email = $('#email').val();
			//$('#wizard').data('smartWizard')._showStep(3)
			//alert(fname);

			validCheckphone = /^[0-9]+$/.test(phone);
			//var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/.test(email);
			// if(fname == "" || lname == "" || phone == "" || !validCheckphone || email == "" 
			// || !emailReg){
			 //if(validation == false){
				 var checkValidation = false;
				$('#cutomer_fname_errorMsg').remove();
				$('#cutomer_lname_errorMsg').remove();
				$('#phone_errorMsg').remove();
				$('#email_errorMsg').remove();
				if(fname == ""){

					$('#cutomer_fname').after('<div id="cutomer_fname_errorMsg" class="error">Please fill your First Name.</div>');
					
					$('.sw-btn-next').addClass('disabled');
					$('.sw-btn-next').attr('disabled',true);
					checkValidation = true;
					return false;
				}
				if(lname == ""){
					$('#cutomer_lname').after('<div id="cutomer_lname_errorMsg" class="error">Please fill your Last Name.</div>');
					checkValidation = true;
				}
				if(phone == "" || !validCheckphone){
					$('#phone').after('<div id="phone_errorMsg" class="error">Please fill your Valid Mobile Number.</div>');
					checkValidation = true;
				}
				// if(email == "" || !emailReg){
				// 	$('#email').after('<div id="email_errorMsg" class="error">Please fill your Email id.</div>');
				// 	checkValidation = true;
				// }
			if(checkValidation){
				$('.sw-btn-next').addClass('disabled');
				$('.sw-btn-next').attr('disabled',true);
				return false;
			}else{

				$('#cutomer_fname_errorMsg').html(' ');
				$('#cutomer_lname_errorMsg').html(' ');
				$('#phone_errorMsg').html(' ');
				$('#email_errorMsg').html(' ');

				
				$('.sw-btn-next').removeClass('disabled');
				$('.sw-btn-next').attr('disabled',false);
			
				return true;
			}
		});

		// $('#store_name').blur(function () {
		// 	var data = $(this).val();
		// 	$('#store_name_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#store_name').after('<div id="store_name_errorMsg" class="error">Please fill your Store Name.</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#store_name_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#customer_type').blur(function () {
		// 	var data = $(this).val();
		// 	$('#customer_type_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#customer_type').after('<div id="customer_type_errorMsg" class="error">Please select Customer Type.</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#customer_type_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#business_street_address').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_street_address_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_street_address').after('<div id="customer_type_errorMsg" class="error">Please fill your Address.</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_street_address_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });

		// $('#business_country').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_country_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_country').after('<div id="business_country_errorMsg" class="error">Please select your Country</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_country_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#business_state').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_state_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_state').after('<div id="business_state_errorMsg" class="error">Please select your State</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_state_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#business_city').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_city_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_city').after('<div id="business_city_errorMsg" class="error">Please select your City</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_city_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#business_postal_code').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_postal_code_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_postal_code').after('<div id="business_postal_code_errorMsg" class="error">Please fill your Postal Code</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_postal_code_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		// $('#business_gst_number').blur(function () {
		// 	var data = $(this).val();
		// 	$('#business_gst_number_errorMsg').remove();
			
 
		// 	if(data == ""){
		// 		$('#business_gst_number').after('<div id="business_gst_number_errorMsg" class="error">Please fill GSTIN</div>');
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		validation = false;
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').attr('disabled',false);
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('#business_gst_number_errorMsg').html(' ');
		// 	return true;
		// 	}
		// });
		
		// $('.sw-btn-next').hover(function () {
			
		// 	var store_name = $('#store_name').val();

			
			
		// 	if(store_name == ""){
		// 	 //if(validation == false){
				
		// 		$('.sw-btn-next').addClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',true);
		// 		return false;
		// 	}else{
		// 		$('.sw-btn-next').removeClass('disabled');
		// 		$('.sw-btn-next').attr('disabled',false);
			
		// 		return true;
		// 	}
		// });
	});
</script>


	<!-- ================== END PAGE LEVEL JS ================== -->

	<!-- <script src="{{ BACKEND.'plugins/countdown/jquery.plugin.min.js'}}"></script> -->
	<!-- <script src="{{ BACKEND.'plugins/countdown/jquery.countdown.min.js'}}"></script> -->
	<!-- {{-- <script src="{{ BACKEND.'js/demo/coming-soon.demo.js'}}"></script> --}} -->

	{{-- start model update stage--}}
<div class="modal fade" id="updateOrderStage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateOrderStageAdmin')}}" id="updateOrderStageAdmin" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        <input type="hidden" name="itemOrderId" id="itemOrderId"/>
                        <select name="stage" class="form-control" id="stage">
                            <option value="0">New order</option>
                            <!-- <option value="1">Proccessed</option> -->
                            <option value="1">To be packed</option>
                            <option value="2">Packaging</option>
                            <option value="3">Shipping</option>
                            <option value="4">Delivered</option>
                            <option value="5">Hold</option>
                            <option value="6">Cancel</option>
                            <option value="7">Return</option>
                        </select>
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update stage --}} 

{{-- start model update stage--}}
<div class="modal fade" id="updateOrderStageFromShiped" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
    <div class="modal-dialog" role="document">
        <form action="{{route('updateOrderStageFromShiped')}}" id="updateOrderStageFromShiped" method="post">
       
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update</h4>
                    <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                
                        @csrf
                        <input type="hidden" name="itemOrderNumber" id="itemOrderNumber"/>
                        <input type="hidden" name="shipingNumber" id="shipingNumber"/>
                        <input type="hidden" name="packingNumber" id="packingNumber"/>
                        <select name="stage" class="form-control" id="stage">
                            <!-- <option value="0">New order</option> -->
                            <!-- <option value="1">Proccessed</option> -->
                            <!-- <option value="1">To be packed</option> -->
                            <!-- <option value="2">Packaging</option> -->
                            <!-- <option value="3">Shipping</option> -->
                            <option value="4">Delivered</option>
                            <option value="5">Hold</option>
                            <option value="6">Cancel</option>
                            <option value="7">Return</option>
                        </select>
                   
                </div>
                <div class="modal-footer">
                    <button type="submit" id="updateOrder" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>
 Submit</button>
                    <button type="button" class="btn btn-default" onclick="javascript:window.location.reload()" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i>
 Close</button>
                </div>
            </div>
         </form>
    </div>
</div>
{{-- end model update stage --}}



<!-- //for Customer customer approval -->
<?php 
 if(request()->segment(1) === 'edit-customer'){

?>

<script>


$("#wizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {
        
        if (currentStepIndex == 2 && nextStepIndex == 'forward') {


            var gst_certificate_old = $("#gst_certificate_old").val();
           
            var checkValidationCert = false;
            $('#sgst_certificate_errorMsg').remove();
            
            if (checkValidationCert) {


                $('#wizard').data('smartWizard')._showStep(3);
               
                return false;
            } else {



                $('#sgst_certificate_errorMsg').html(' ');

                $('.sw-btn-next').removeClass('disabled');
                $('.sw-btn-next').attr('disabled', false);
                
            }

            $(".sw-btn-next").hide();

        } else {
            $(".sw-btn-next").show();
        }

        

        $("#saveCustomerApproval").validate({
            rules: {
                store_name: "required",
                customer_type: "required",
                business_street_address: "required",
                business_country: "required",
                business_state: "required",
                business_city: "required",
                business_postal_code: {
					required: true,
					maxlength: 6,
					minlength: 6,
					number: true
				},
                payment_option: "required",
				
                

               


            },

            messages: {
                store_name: "Please fill your Store Name.",
                customer_type: "Please select Customer Type.",
                business_street_address: "Please fill your Address.",
                business_country: "Please select your Country",
                business_state: "Please select your State",
                business_city: "Please select your City",
                business_postal_code: "Please fill your Postal Code",
                payment_option: "Please select payment option",
               

            },
        });
        if (currentStepIndex == 1 && nextStepIndex == 'forward') {
            



            var checkValidation = false;


            $('#document_option_errorMsg').remove();
            if ($("#saveCustomerApproval").valid() == false) {
               
                checkValidation = false;
                return false
            } 
			//else if ($("#checkNum").val() >= 2) {
            //     checkValidation = true;
            //     $('#wizard').data('smartWizard')._showStep(1);
            // } else {
            //     $('#document_option').after('<div id="document_option_errorMsg" class="error">Please select any two option.</div>');
            //     return false;
            // }



        }
        
    });
</script>
<!-- //Start for Customer customer approval -->
<?php }?>

<?php if( request()->segment(1) ==='dashboard'){?>
<script>

	 $("#wizard").on("leaveStep", function(e, anchorObject, currentStepIndex, nextStepIndex, stepDirection) {

        


		$.validator.addMethod('filesize', function (value, element, param) {
			// alert(param);
			 console.log(element.files[0].size);
			return this.optional(element) || (element.files[0].size <= param)
		}, 'File size must be less than 5 MB');
		// }, 'File size must be less than {0}');

		// $.validator.addMethod("testValPan", function(value, element) {
		// 	var pan = $("#pan_number").val();
		// 	alert($("#pan_number").val());
		// return this.optional(element) || (pan !="");
		// }, "Number is not accepted.");


        $("#saveCustomerProfileDetails").validate({
            rules: {
                store_name: "required",
                customer_type: "required",
                business_street_address: "required",
                business_country: "required",
                business_state: "required",
                business_city: "required",
                business_postal_code: {
					required: true,
					maxlength: 6,
					minlength: 6,
					number: true
				},

                document_option: {
                    required: true,



                },
                business_gst_number: { required: true, minlength: 15 },
                pan_number: "required",
                // pan_number:{
				// 	testValPan: true
				// },
                
                dl_number: "required",
                cancel_check: "required",
				gst_certificate: {
					//extension: "png",
					//accept: "image/*,application/msword,.pdf",
					// accept: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"
					//extension: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf",
					//extension: "pdf|docx|doc|jpg|jpeg|png|jdeh",
					//filesize: 9000,
					// filesize: 8445,
					//filesize: 5000000,
					
					required: function(element){
						if($("#gst_certificate_old").val()==""){
							return $("#business_gst_number").val()!="";
						}
						
					}
				},
				FSSAI_certificate: {
					//extension: "png",
					//accept: "image/*,application/msword,.pdf",
					// accept: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"
					//extension: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf",
					//extension: "pdf|docx|doc|jpg|jpeg|png|jdeh",
					//filesize: 9000,
					// filesize: 8445,
					//filesize: 5000000,
					
					required: function(element){
						if($("#gst_certificate_old").val()==""){
							return $("#pan_number").val()!="";
						}
						
					}
				},
				driving_license: {
					//extension: "png",
					//accept: "image/*,application/msword,.pdf",
					// accept: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"
					//extension: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf",
					//extension: "pdf|docx|doc|jpg|jpeg|png|jdeh",
					//filesize: 9000,
					// filesize: 8445,
					//filesize: 5000000,
					
					required: function(element){
						if($("#driving_license_old").val()==""){
							return $("#dl_number").val()!="";
						}
						
					}
				},
				cancel_bank_cheque: {
					//extension: "png",
					//accept: "image/*,application/msword,.pdf",
					// accept: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf"
					//extension: ".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf",
					//extension: "pdf|docx|doc|jpg|jpeg|png|jdeh",
					//filesize: 9000,
					// filesize: 8445,
					//filesize: 5000000,
					
					required: function(element){
						if($("#cancel_bank_cheque_old").val()==""){
							
							return $("#cancel_check").val()!="";
						}
						
					}
				},
				// gst_certificate: {
				// 	extension: "pdf|docx|doc|jpg|jpeg|png|jdeh",
				// 	filesize: 5000000,
				// }
                


            },

            messages: {
                store_name: "Please fill your Store Name.",
                customer_type: "Please select Customer Type.",
                business_street_address: "Please fill your Address.",
                business_country: "Please select your Country",
                business_state: "Please select your State",
                business_city: "Please select your City",
                business_postal_code: "Please fill your Postal Code",
                document_option: {
                    required: "Please select any two option",
                },

                business_gst_number: {
                    required: "Please fill GSTIN",
                    minlength: 'Please fill GSTIN Valid GSTNO.'
                },
                pan_number: "Please fill your PAN Number",
                dl_number: "Please fill your Driving License",
                cancel_check: "Please fill your Cancel Check Number",
                //payment_option: "Please select payment option",
                // gst_certificate: {
                //     extension: "Please upload image,doc,docx,docx,pdf file.",
                //     filesize: 'Please filesize.'
                // },

            },
        });
		
        if (currentStepIndex == 1 && nextStepIndex == 'forward') {




            var checkValidation = false;


            $('#document_option_errorMsg').remove();
            if ($("#saveCustomerProfileDetails").valid() == false) {
				
                checkValidation = false;
                return false
            } else if ($("#checkNum").val() >= 2) {

                checkValidation = true;
				

                $('#wizard').data('smartWizard')._showStep(1);
            } else {

                $('#document_option').after('<div id="document_option_errorMsg" class="error">Please select any two option.</div>');
                return false;
            }



        }

		if (currentStepIndex == 2 && nextStepIndex == 'forward') {

			
			var gst_certificate_old = $("#gst_certificate_old").val();

			var checkValidationCert = false;
			$('#sgst_certificate_errorMsg').remove();

			if ($("#saveCustomerProfileDetails").valid() == false) {
				
				
				//alert($("#pan_number").val());
				$('#wizard').data('smartWizard')._showStep(3);

				return false;
			} else {

				// var panCardNum = $("#pan_number").val();
				
			
				// if(panCardNum !=""){

				// }

				$('#sgst_certificate_errorMsg').html(' ');

				$('.sw-btn-next').removeClass('disabled');
				$('.sw-btn-next').attr('disabled', false);

			}

			$(".sw-btn-next").hide();

		} else {

				$(".sw-btn-next").show();
			}
		

        // if (currentStepIndex == 2 && nextStepIndex == 'forward') {




        //     var checkValidation = false;


            
        //     if ($("#saveCustomerProfileDetails").valid() == false) {

        //         checkValidation = false;
        //         return false
        //     }  else {
        //         checkValidation = true;
        //         $('#wizard').data('smartWizard')._showStep(2);
        //     }



        // }

    });
	</script>
	<?php }?>


	<!-- <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script> -->
    <!-- <script type='text/javascript' src='https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyBV69yb6tupSoDzZwVb16m2X0GTC4wHec0&latlng="latitude","longitude"&sensor=true' id='google-maps-js'></script> -->
    <!-- http://www.google.com/maps/place/49.46800006494457,17.11514008755796 -->
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyCbXaOwGHCK73I0P4gXRzttJ_Wtf37zdG4"></script>
	<script>
         //getLocation();

        function getLocation() {
			
            if (navigator.geolocation) {
				
                navigator.geolocation.getCurrentPosition(showPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showPosition(position) {
            var latt = position.coords.latitude;
            var longg = position.coords.longitude;

            GetAddress(latt, longg);
        }

        function GetAddress(lats, long) {
            var lat = lats;
            var lng = long;

            var latlng = new google.maps.LatLng(lat, lng);
      
            var geocoder = geocoder = new google.maps.Geocoder();
            geocoder.geocode({ 'latLng': latlng }, function(results, status) {
                //console.log(results);
				latitude = results[0].geometry.location.lat();
                longitude = results[0].geometry.location.lng();
				//alert('lat-'+latitude+'long-'+longitude);
                if (status == google.maps.GeocoderStatus.OK) {
                    if (results[1]) {
						$("#latitude").val(latitude);
						$("#longitude").val(longitude);
						$("#geo_location").val(results[1].formatted_address);
                        //alert("Location: " + results[1].formatted_address);
                    }
                }
            });
        }

   </script>
    <!-- <script src="{{ asset('local/corex/assets/js/getTaskByEmployID.js') }}" type="text/javascript"></script> -->
    

  
  <!-- <script>
getLocation();
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    alert(position.coords.latitude);
//   x.innerHTML = "Latitude: " + position.coords.latitude +
//   "<br>Longitude: " + position.coords.longitude;
}
</script> -->

</body>

</html>