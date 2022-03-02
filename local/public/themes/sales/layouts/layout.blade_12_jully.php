<!DOCTYPE html>
<html lang="en">

    <head>
    <style>
		.required-star {
			color: red;
		}

		.form-layout {
			margin-left: 10px;
			margin-right: 10px;
		}
	</style>

	<style>
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
	</style>
        {!! meta_init() !!}
        <meta name="keywords" content="@get('keywords')">
        <meta name="description" content="@get('description')">
        <meta name="author" content="@get('author')">
    
        <title>Sales</title>
        <!-- <title>@get('title')</title> -->

        <meta name="BASE_URL" content="{{ url('/') }}" />
	
	{{-- <meta name="UUID" content="{{ ($customer)? $customer->id:Auth::user()->id}}" /> --}}
	{{-- <meta name="UUID" content="{{ Auth::user()->id }}" /> --}}
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
   
    <link rel="shortcut icon" href="{{ asset('/assets/img/icon/fev.png') }}" />
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{ BACKEND.'css/apple/app.min.css'}}" rel="stylesheet" />

	<link href="{{ BACKEND.'css/apple/sales_app.min.css'}}" rel="stylesheet" />

	<link href="{{ BACKEND.'plugins/ionicons/css/ionicons.min.css'}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
   
    
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/themes/redmond/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
	

	<!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
	<link href="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/gritter/css/jquery.gritter.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/jstree/dist/themes/default/style.min.css'}}" rel="stylesheet" />

	<!-- ================== END PAGE LEVEL STYLE ================== -->

	<!-- ================== BEGIN PAGE gallery upload CSS STYLE ================== -->
	<link href="{{asset('assets/plugins/blueimp-gallery/css/blueimp-gallery.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/blueimp-file-upload/css/jquery.fileupload.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/blueimp-file-upload/css/jquery.fileupload-ui.css')}}" rel="stylesheet" />

	<!-- ================== END PAGE gallery upload CSS STYLE ================== -->

	<link href="{{asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
	<link href="{{asset('assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css')}}" rel="stylesheet" />

	
	
    <!-- ================== BEGIN PAGE GALLERY ================== -->
	<link href="{{asset('assets/plugins/lightbox2/dist/css/lightbox.css')}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/simple-line-icons/css/simple-line-icons.css'}}" rel="stylesheet" />
	<!-- ================== END PAGE GALLERY ================== -->
	<link href="{{BACKEND.'plugins/smartwizard/dist/css/smart_wizard.css'}}" rel="stylesheet" />
	<link href="{{BACKEND.'plugins/dropzone/dist/min/dropzone.min.css'}}" rel="stylesheet" />
	<link href="../assets/plugins/tag-it/css/jquery.tagit.css" rel="stylesheet" />
	
   

</head>

        @styles()
        
    </head>

    <body>
        @partial('header')
        @partial('leftside')

        @content()

        @partial('footer')

        @scripts()
        <a href="javascript:;" class="btn btn-icon btn-circle btn-primary btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
        </div>
        <!-- end page container -->
        <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
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
      <!--[if (gte IE 8)&(lt IE 10)]> -->
            <script src="assets/plugins/jquery-file-upload/js/cors/jquery.xdr-transport.js')}}"></script>
      
        <script src="{{asset('assets/js/demo/form-multiple-upload.demo.js')}}"></script>
         <!-- ================== END PAGE LEVEL JS ================== --> 
        <!-- end gallery  -->
    
    
        <script type="text/javascript">
            BASE_URL = $('meta[name="BASE_URL"]').attr('content');
            UID = $('meta[name="UUID"]').attr('content');
            _TOKEN = $('meta[name="csrf-token"]').attr('content');
        </script>
        <script src="{{ BACKEND.'js/jquery.validate.js'}}"></script>
    
    
        <!-- ================== BEGIN PAGE LEVEL JS ================== -->
        <script src="{{ BACKEND.'plugins/gritter/js/jquery.gritter.js'}}"></script>
        <!-- <script src="{{ BACKEND.'plugins/flot/jquery.flot.js'}}"></script>
        <script src="{{ BACKEND.'plugins/flot/jquery.flot.time.js'}}"></script>
        <script src="{{ BACKEND.'plugins/flot/jquery.flot.resize.js'}}"></script>
        <script src="{{ BACKEND.'plugins/flot/jquery.flot.pie.js'}}"></script>
        <script src="{{ BACKEND.'plugins/jquery-sparkline/jquery.sparkline.min.js'}}"></script>
        <script src="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap.min.js'}}"></script>
        <script src="{{ BACKEND.'plugins/jvectormap-next/jquery-jvectormap-world-mill.js'}}"></script>
        <script src="{{ BACKEND.'plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js'}}"></script>
        <script src="{{ BACKEND.'plugins/jstree/dist/jstree.min.js'}}"></script> -->
        
    
        <script src="{{asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        
       <script src="{{ BACKEND.'js/demo/table-manage-default.demo.js'}}"></script>
        
    
        
    
        <!-- ================== BEGIN PAGE GALLERY JS ================== -->
        <script src="{{asset('assets/plugins/isotope-layout/dist/isotope.pkgd.min.js')}}"></script>
        <script src="{{asset('assets/plugins/lightbox2/dist/js/lightbox.min.js')}}"></script>
        <script src="{{asset('assets/js/demo/gallery.demo.js')}}"></script>
        <!-- ================== END PAGE GALLERY JS ================== -->
        <!-- <script src="{{BACKEND.'plugins/smartwizard/dist/js/jquery.smartWizard.js'}}"></script> -->
        <!-- <script src="{{BACKEND.'js/demo/form-wizards.demo.js'}}"></script> -->
    
        <!-- <script src="{{ BACKEND.'js/appjs/ui-tree.demo.js'}}"></script> -->
    
    
        <script src="{{ BACKEND.'js/appjs/dashboard.js'}}"></script>
        <script src="{{ BACKEND.'js/ecom-backend.js'}}"></script>
        <script src="{{ BACKEND.'plugins/parsleyjs/dist/parsley.min.js'}}"></script>
        <script src="{{ BACKEND.'plugins/highlight.js/highlight.min.js'}}"></script>
        <script src="{{ BACKEND.'js/demo/render.highlight.js'}}"></script>
        <script src="{{ BACKEND.'plugins/dropzone/dist/min/dropzone.min.js'}}"></script>
        
        <script src="{{ BACKEND.'plugins/ckeditor/ckeditor.js'}}"></script>
    
        <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script>
    
    <!-- <script src="{{ BACKEND.'js/demo/profile.demo.js'}}"></script> -->
    <!-- <script src="{{ BACKEND.'js/appjs/ecom.js'}}"></script> -->
    <script src="{{ BACKEND.'js/appjs/salespersion.js'}}"></script>
    
    
   
    
        <!-- ================== END PAGE LEVEL JS ================== -->
        
        <!-- <script src="{{ BACKEND.'plugins/countdown/jquery.plugin.min.js'}}"></script>
        <script src="{{ BACKEND.'plugins/countdown/jquery.countdown.min.js'}}"></script>
        <script src="{{ BACKEND.'js/demo/coming-soon.demo.js'}}"></script> -->

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
    </body>
    
    </html>