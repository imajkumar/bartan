<!-- BEGIN #footer -->
<?php
   
    //pr(Auth::user());
    //$kyc = 'false';

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
<div id="footer" class="footer">
    <!-- BEGIN container -->
    <div class="container">
        <!-- BEGIN row -->
        <div class="row">
            <!-- BEGIN col-3 -->
            <div class="col-lg-3">
                <h4 class="footer-header">ABOUT US</h4>
                <p>
                Subiksh Steel has emerged as a trusted manufacturer and supplier of a varied range of products. 
                The assortment of products that we make available to our clients includes Pressure Cooker,
                </p>
                <p class="mb-lg-4 mb-0">
                 <!-- Nonstick Cookware Set, Lunch Boxes, Plastic Containers, Thermoware Containers, Stainless Steel Flask, Stainless Steel Utensils (Dinner Set, Handi Set, Canister Set, etc), Copper Base Saucepan and Copper Base Handi Set. -->
                  Our clients are happy to be associated with us as we never practice any kind of discrepancy when it comes to product quality that we offer.
                </p>
            </div>
            <!-- END col-3 -->
            <!-- BEGIN col-3 -->
            <div class="col-lg-3">
                <h4 class="footer-header">RELATED LINKS</h4>
                <ul class="fa-ul mb-lg-4 mb-0">
               <!--  <li><i class="fa fa-li fa-angle-right"></i> <a href="#">Shopping Help</a></li> -->
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('termsOfUse')}}">Terms of Use</a></li>
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('contactUs')}}">Contact Us</a></li>

                      <li><i class="fa fa-li fa-angle-right"></i> <a href="https://bartan.com/login" target="_black">Team login</a></li>
                        <li><i class="fa fa-li fa-angle-right"></i> <a href="https://bartan.com/sales-login" target="_black">Sales Team login</a></li>
                    <!-- <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('careers')}}">Careers</a></li> 
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="#">Payment Method</a></li>
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('salesRefund')}}">Sales & Refund</a></li>
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="#">Sitemap</a></li>-->
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('privacyPolicy')}}">Privacy & Policy</a></li>
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('refundPolicy')}}">Refund & Policy</a></li>
                    <li><i class="fa fa-li fa-angle-right"></i> <a href="{{route('faq')}}">FAQ</a></li>
                </ul>
            </div>
            <!-- END col-3 -->
            <!-- BEGIN col-3 -->
            <div class="col-lg-3">
                <h4 class="footer-header">LATEST PRODUCT</h4>
                <ul class="list-unstyled list-product mb-lg-4 mb-0">
                    <?php 
                        $items = get_items($flag='', $limit=4);
                        
                        
                        $n=1;
                        foreach($items as $item)
                        {
        
                            $itemImages = get_item_default_img_item_id($item->item_id);
        
                            if($itemImages)
                            {
        
                                $itemImg = BASE_URL.ITEM_IMG_PATH.'/'.$itemImages->img_name;
                                
                            } else {
        
                                $itemImg = FRONT.'img/product/product-iphone.png';
                            }
    
                    ?>

                        <li>
                            <div class="image">
                            <a href="{{route('productDetail', $item->slug)}}">
                            <img src="{{$itemImg}}" alt="{{$item->product_name}}" />
                            </a>
                            </div>
                            <div class="info">
                            <a href="{{route('productDetail', $item->slug)}}">
                            <h4 class="info-title">{{$item->product_name}}</h4>
                            </a>
                            <?php
								if ($login == "true" && $kyc == "true" && @$isAdmin !="yes") {
								?>
                                <div class="price"><i class="fa fa-inr" aria-hidden="true"></i>₹{{($item->regular_price)? $item->regular_price:0}}</div>
                                <?php }?>
                            </div>
                        </li>

                <?php } ?>

                    
                </ul>
            </div>
            <!-- END col-3 -->
            <!-- BEGIN col-3 -->
            <div class="col-lg-3">
                <h4 class="footer-header">OUR CONTACT</h4>
                <address class="mb-lg-4 mb-0">
                

                <strong>Subhiksh steel impex pvt ltd</strong><br />
                Main Rohtak Road, Nangloi<br />
                Rohtak Road, Delhi - 110041, India<br /><br />
                <abbr title="Phone">Mobile:</abbr> +91-9310219573<br />
                <abbr title="Phone">Phone:</abbr> +91-9311048811<br />
               
                <abbr title="Email">Email:</abbr> <a href="mailto:info@subhiksh.com">info@subhiksh.com</a><br />
                <!-- <abbr title="Skype">Skype:</abbr> <a href="skype:myshop">myshop</a> -->
            </address>
            </div>
            <!-- END col-3 -->
        </div>
        <!-- END row -->
    </div>
    <!-- END container -->
</div>
<!-- END #footer -->