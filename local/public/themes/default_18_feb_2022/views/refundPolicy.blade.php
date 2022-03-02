
<div id="page-header" class="section-container page-header-container bg-black">
    <!-- BEGIN page-header-cover -->
    <div class="page-header-cover">
        
        <img src="{{FRONT.'img/cover/cover-15.jpg'}}" alt="" />
    </div>
    <!-- END page-header-cover -->
    <!-- BEGIN container -->
    <div class="container">
        <?php //pr($brandDetail->brand_img);?>
    <h1 class="page-header"><b>Refund Policy</b></h1>
    </div>
    <!-- END container -->
</div>
<!-- BEGIN #page-header -->
<?php 
$page=DB::table('tbl_pages')->where('page_title', 'return_policy')->first();
echo html_entity_decode($page->page_desc);
?>