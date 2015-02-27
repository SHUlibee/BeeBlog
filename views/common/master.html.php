<?php include SERVER_ROOT.'/views/common/header.html.php';?>

<div class="row">
	<div class="col-md-2">
		<?php include SERVER_ROOT.'/views/common/menu.html.php';?>
	</div>
	<div class="col-md-10">
		<?php include(View_Lib::$VIEW_FILE);?>
	</div>
</div>


<?php include SERVER_ROOT.'/views/common/footer.html.php';?>