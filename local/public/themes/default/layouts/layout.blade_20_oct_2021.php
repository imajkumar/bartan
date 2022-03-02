<!DOCTYPE html>
<html lang="en">

<head>
<?php
        if (Auth::user()) {

			$login = "true";
			if (Auth::user()->user_type == 0) {

				if (Auth::user()->profile == 1) {

					$kyc = 'true';
				} else {

					$kyc = 'false';
				}
				$isAdmin = "no";
			} else {
				$isAdmin = "yes";
				$kyc = 'true';
			}
		} else {
			$kyc = 'false';
			$login = "false";
		}
    
        


?>
	<meta charset="utf-8" />
	<title>Bartan.com</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" /> -->
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta name="theme-color" content="#e30613">
	<meta name="msapplication-TileColor" content="#e30613">
    <meta name="msapplication-navbutton-color" content="#e30613">
    <meta name="apple-mobile-web-app-status-bar-style" content="#e30613">
	<meta name="BASE_URL" content="{{ url('/') }}" />
	<?php

		if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
	?>
		<meta name="UUID" content="{{ Auth::user()->id }}" />

	<?php }?>
	
	
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<!-- ================== BEGIN BASE CSS STYLE ================== -->
	<link href="{{ FRONT.'css/e-commerce/paginate.css'}}" rel="stylesheet" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
	<link href="{{FRONT.'css/e-commerce/app.min.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'plugins/gritter/css/jquery.gritter.css'}}" rel="stylesheet" />
	<!-- ================== END BASE CSS STYLE ================== -->
	<link rel="shortcut icon" href="{{ asset('/assets/img/icon/fev.png') }}" />
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<link href="{{ FRONT.'css/e-commerce/owl.carousel.min.css'}}" rel="stylesheet" />
	<link href="{{ BACKEND.'css/apple/print.css'}}" rel="stylesheet" media="print" />



	<style type="text/css">

	
		.side-menu-wrapper {
			/* style menu wrapper */
			background: #fff;
			/*padding: 40px 0 0 0px;*/
			position: fixed;
			/* Fixed position */
			top: 0;
			right: 0;
			/* Sidebar initial position. "right" for right positioned menu */
			height: 100%;
			z-index: 2;
			transition: 0.5s;
			/* CSS transition speed */
			width: 250px;
			/*font: 20px "Courier New", Courier, monospace;*/
			box-sizing: border-box;
		}

		.side-menu-wrapper>ul {
			/* css ul list style */
			list-style: none;
			padding: 0;
			margin: 0;
			overflow-y: auto;
			/* enable scroll for menu items */
			height: 95%;
		}

		.side-menu-wrapper>ul>li>a {
			/* links */
			display: block;
			border-bottom: 1px solid #ececec;
			padding: 12px 1px 15px 20px;
			color: #000;
			transition: 0.3s;
			text-decoration: none;
		}

		.side-menu-wrapper>a.menu-close {
			/* close button */
			padding: 0px 0 4px 23px;
			color: #6B6B6B;
			display: block;
			margin: -92px 0 -10px -20px;
			font-size: 35px;
			text-decoration: none;
			float: right;
		}

		.menu-overlay {
			/* overlay */
			height: 100%;
			width: 0;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: rgb(134 135 136 / 44%);
			overflow-y: auto;
			overflow-x: hidden;
			text-align: center;
			opacity: 0;
			transition: opacity 1s;
		}

		.header .user-icon {

			width: 1.3rem;
			height: 1.3rem;
		}

		.menu-open img {
			margin: .69rem .65rem .575rem .725rem;
		}

		.menu-open {

			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			width: 50px;
			height: 50px;
			background-color: #eee;
			border-radius: 50%;
			margin-top: 13px;
			cursor: pointer;

		}

		.profile-highlight {
			display: -webkit-box;
			display: flex;
			border-bottom: 1px solid #E0E0E0;
			padding: 12px 16px;
			margin-bottom: 6px;
			background: #eee;
		}

		.profile-highlight img {
			width: 48px;
			height: 48px;
			border-radius: 25px;
			-o-object-fit: cover;
			object-fit: cover;
		}

		.profile-highlight .details {
			display: -webkit-box;
			display: flex;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			flex-direction: column;
			margin: auto 12px;
		}

		.profile-highlight .details #profile-name {
			font-weight: 600;
			font-size: 16px;
		}

		.profile-highlight .details #profile-footer {
			font-weight: 300;
			font-size: 14px;
			margin-top: 4px;
		}
		.category-sidebar {
			border-right: 1px solid #dedede;
		}
	
		
    </style>
</head>

<body>
	@partial('header')

	@content()

	@partial('footer')

	<!-- BEGIN #footer-copyright -->
	<div id="footer-copyright" class="footer-copyright">
		<!-- BEGIN container -->
		<div class="container">
		<!-- 	<div class="payment-method">
				<img src="assets/img/payment/payment-method.png" alt="" />
			</div> -->
			<div class="copyright">
				Copyright &copy; {{date('Y')}}. All rights reserved.
			</div>
		</div>
		<!-- END container -->
	</div>
	<!-- END #footer-copyright -->
	</div>
	<!-- END #page-container -->



	<!-- ================== BEGIN BASE JS ================== -->
	<script src="{{FRONT.'js/e-commerce/app.min.js'}}"></script>
	
	<script src="{{ BACKEND.'plugins/gritter/js/jquery.gritter.js'}}"></script>

	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js" integrity="sha512-UdIMMlVx0HEynClOIFSyOrPggomfhBKJE28LKl8yR3ghkgugPnG6iLfRfHwushZl1MOPSY6TsuBDGPK2X4zYKg==" crossorigin="anonymous"></script> -->

	<script src="{{ BACKEND.'js/jquery.validate.js'}}"></script>
	<!-- ================== END BASE JS ================== -->

	<script src="{{ FRONT.'js/ecom-front.js'}}"></script>

	<script src="{{ FRONT.'js/owl.carousel.min.js'}}"></script> 
	<script type="text/javascript">
		$('.brand-carousel').owlCarousel({
	  loop:false,
	  margin:10,
	  autoplay:true,
	  responsive:{
	    0:{
	      items:1
	    },
	    600:{
	      items:3
	    },
	    1000:{
	      items:5
	    }
	  }
	})
	</script>
	<script type="text/javascript">
		var slide_wrp = ".side-menu-wrapper"; //Menu Wrapper
		var open_button = ".menu-open"; //Menu Open Button
		var close_button = ".menu-close"; //Menu Close Button
		var overlay = ".menu-overlay"; //Overlay

		//Initial menu position
		$(slide_wrp).hide().css({
			"left": -$(slide_wrp).outerWidth() + 'px'
		}).delay(50).queue(function() {
			$(slide_wrp).show()
		});

		$(open_button).click(function(e) { //On menu open button click
			e.preventDefault();
			$(slide_wrp).css({
				"left": "0px"
			}); //move menu right position to 0
			setTimeout(function() {
				$(slide_wrp).addClass('active'); //add active class
			}, 50);
			$(overlay).css({
				"opacity": "1",
				"width": "100%"
			});
		});

		$(close_button).click(function(e) { //on menu close button click
			e.preventDefault();
			$(slide_wrp).css({
				"left": -$(slide_wrp).outerWidth() + 'px'
			}); //hide menu by setting right position 
			setTimeout(function() {
				$(slide_wrp).removeClass('active'); // remove active class
			}, 50);
			$(overlay).css({
				"opacity": "0",
				"width": "0"
			});
		});

		$(document).on('click', function(e) { //Hide menu when clicked outside menu area
			if (!e.target.closest(slide_wrp) && $(slide_wrp).hasClass("active")) { // check menu condition
				$(slide_wrp).css({
					"left": -$(slide_wrp).outerWidth() + 'px'
				}).removeClass('active');
				$(overlay).css({
					"opacity": "0",
					"width": "0"
				});
			}
		});
	</script>



	<script>
	$(document).ready(function () {
    var itemsMainDiv = ('.MultiCarousel');
    var itemsDiv = ('.MultiCarousel-inner');
    var itemWidth = "";

    $('.leftLst, .rightLst').click(function () {
        var condition = $(this).hasClass("leftLst");
        if (condition)
            click(0, this);
        else
            click(1, this)
    });

    ResCarouselSize();




    $(window).resize(function () {
        ResCarouselSize();
    });

    //this function define the size of the items
    function ResCarouselSize() {
        var incno = 0;
        var dataItems = ("data-items");
        var itemClass = ('.item');
        var id = 0;
        var btnParentSb = '';
        var itemsSplit = '';
        var sampwidth = $(itemsMainDiv).width();
        var bodyWidth = $('body').width();
        $(itemsDiv).each(function () {
            id = id + 1;
            var itemNumbers = $(this).find(itemClass).length;
            btnParentSb = $(this).parent().attr(dataItems);
            itemsSplit = btnParentSb.split(',');
            $(this).parent().attr("id", "MultiCarousel" + id);


            if (bodyWidth >= 1200) {
                incno = itemsSplit[3];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 992) {
                incno = itemsSplit[2];
                itemWidth = sampwidth / incno;
            }
            else if (bodyWidth >= 768) {
                incno = itemsSplit[1];
                itemWidth = sampwidth / incno;
            }
            else {
                incno = itemsSplit[0];
                itemWidth = sampwidth / incno;
            }
            $(this).css({ 'transform': 'translateX(0px)', 'width': itemWidth * itemNumbers });
            $(this).find(itemClass).each(function () {
                $(this).outerWidth(itemWidth);
            });

            $(".leftLst").addClass("over");
            $(".rightLst").removeClass("over");

        });
    }


    //this function used to move the items
    function ResCarousel(e, el, s) {
        var leftBtn = ('.leftLst');
        var rightBtn = ('.rightLst');
        var translateXval = '';
        var divStyle = $(el + ' ' + itemsDiv).css('transform');
        var values = divStyle.match(/-?[\d\.]+/g);
        var xds = Math.abs(values[4]);
        if (e == 0) {
            translateXval = parseInt(xds) - parseInt(itemWidth * s);
            $(el + ' ' + rightBtn).removeClass("over");

            if (translateXval <= itemWidth / 2) {
                translateXval = 0;
                $(el + ' ' + leftBtn).addClass("over");
            }
        }
        else if (e == 1) {
            var itemsCondition = $(el).find(itemsDiv).width() - $(el).width();
            translateXval = parseInt(xds) + parseInt(itemWidth * s);
            $(el + ' ' + leftBtn).removeClass("over");

            if (translateXval >= itemsCondition - itemWidth / 2) {
                translateXval = itemsCondition;
                $(el + ' ' + rightBtn).addClass("over");
            }
        }
        $(el + ' ' + itemsDiv).css('transform', 'translateX(' + -translateXval + 'px)');
    }

    //It is used to get some elements from btn
    function click(ell, ee) {
        var Parent = "#" + $(ee).parent().attr("id");
        var slide = $(Parent).attr("data-slide");
        ResCarousel(ell, Parent, slide);
    }

});


function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
	
	</script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script> -->
<script src="{{ FRONT.'js/jspdf.min.js'}}"></script>
<script src="{{ FRONT.'js/html2canvas.js'}}"></script>
<?php 
$route_name='';
	$route_arr = explode(url('/') . "/", url()->current());
	if (array_key_exists(1, $route_arr)) {
		$route_name= $route_arr[1];
	}
	if($route_name == ""){
	?>
<script type="text/javascript" src="{{ FRONT.'js/paginate.js'}}"></script>
<?php }?>
<!-- <script type="text/javascript" src="https://code.jquery.com/jquery-2.2.4.min.js"></script> -->

<!-- <script type="text/javascript" src="libs/png_support/zlib.js"></script>
<script type="text/javascript" src="libs/png_support/png.js"></script>
<script type="text/javascript" src="jspdf.plugin.addimage.js"></script>
<script type="text/javascript" src="jspdf.plugin.png_support.js"></script> -->

<script>
//np
function getPDF(){

		var HTML_Width = $("#checkout-cart").width();
		var HTML_Height = $("#checkout-cart").height();
		var top_left_margin = 15;
		var PDF_Width = HTML_Width+(top_left_margin*2);
		var PDF_Height = (PDF_Width*1.5)+(top_left_margin*2);
		var canvas_image_width = HTML_Width;
		var canvas_image_height = HTML_Height;
		
		var totalPDFPages = Math.ceil(HTML_Height/PDF_Height)-1;
		

		html2canvas($("#checkout-cart")[0],{allowTaint: true,
                useCORS: true}).then(function(canvas) {
			canvas.getContext('2d');
			
			console.log(canvas.height+"  "+canvas.width);
			
			
			var imgData = canvas.toDataURL("image/jpeg", 1.0);
			var pdf = new jsPDF('p', 'pt',  [PDF_Width, PDF_Height]);
		    pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin,canvas_image_width,canvas_image_height);
			
			
			for (var i = 1; i <= totalPDFPages; i++) { 
				pdf.addPage(PDF_Width, PDF_Height);
				pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height*i)+(top_left_margin*4),canvas_image_width,canvas_image_height);
			}
			
		    pdf.save("viewCart.pdf");
        });
	};

	////Pagination start 
window.onload = function () {
  var paginationPage = parseInt($(".cdp").attr("actpage"), 10);
  $(".cdp_i").on("click", function () {
    var go = $(this).attr("href").replace("#!", "");
    if (go === "+1") {
      paginationPage++;
    } else if (go === "-1") {
      paginationPage--;
    } else {
      paginationPage = parseInt(go, 10);
    }
    $(".cdp").attr("actpage", paginationPage);

	paginationCategoy(flag='Category', catId = '', pageNo=paginationPage, perPageLimit=6);
  });
};

////Pagination end
</script>
<script type="text/javascript" src="{{ FRONT.'js/jquery.ez-plus-zoom.js'}}"></script>
<!-- <script type="text/javascript" src="https://cdn.rawgit.com/igorlino/elevatezoom-plus/1.1.17/src/jquery.ez-plus.js"></script> -->
<script>
	$('.zoom_mw').ezPlus({
    scrollZoom: true
});


</script>

</body>

</html>