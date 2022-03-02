<div id="page-header" class="section-container page-header-container bg-black">
			<!-- BEGIN page-header-cover -->
			<div class="page-header-cover">
				<img src="{{FRONT.'img/cover/cover-13.jpg'}}" alt="">
			</div>
			<!-- END page-header-cover -->
			<!-- BEGIN container -->
			<div class="container">
				<h1 class="page-header">Frequently Asked <b>Questions</b></h1>
			</div>
			<!-- END container -->
		</div>
		<div id="faq" class="section-container">
			<!-- BEGIN container -->
			<div class="container">
			<div class="accordion faq" id="faq-list">
<?php 
$page=DB::table('tbl_pages')->where('page_title', 'faq')->first();
echo html_entity_decode(htmlspecialchars($page->page_desc));
// echo html_entity_decode($page->page_desc);
?>
		<!-- {!! @$page->page_desc !!} -->

</div>
</div>
</div>