<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Food Portal | <?= $title ?></title>

		<?php include APPPATH.'views/admin/include/header.php'; ?>
	</head>

	<body class="nav-md footer_fixed" style="font-family: 'Lato';">
		<div class="container body">
		    <div class="main_container">
		    	<?php include APPPATH.'views/admin/include/navigation.php'; ?>

		        <!-- page content -->
		        <div class="right_col" role="main">
            		<div class="clearfix"></div>
		            <?php if (!empty($this->session->flashdata('save_message'))): ?>                
		                <div class="alert alert-success alert-dismissible fade in">
		                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                    <strong>Success!</strong> <?= $this->session->flashdata('save_message'); ?>
		                </div>
		            <?php endif ?>

		            <?php if (!empty($this->session->flashdata('error_message'))): ?>                
		                <div class="alert alert-danger alert-dismissible fade in">
		                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                    <strong>Error!</strong> <?= $this->session->flashdata('error_message'); ?>
		                </div>
		            <?php endif ?>

		            <?= empty($this->page_content) ? 'Body Content Here' : $this->page_content; ?>
		        </div>
		        <!-- /page content -->
		    </div>
		</div>
		<br>
		<?php include APPPATH.'views/admin/include/footer.php'; ?>

		<?php include APPPATH.'views/admin/include/script_page.php'; ?>
		<?= empty($this->custom_js) ? '' : $this->custom_js; ?>
	</body>
</html>