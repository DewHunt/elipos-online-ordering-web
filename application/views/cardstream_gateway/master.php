<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Cardstream Payment Page</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" type="text/css" media="screen">
		<link rel="stylesheet" type="text/css" href="<?= base_url('assets/admin/sweetalert2/css/sweetalert2.min.css') ?>" />
        <style type="text/css">
			.container-block { margin: 20px 10px 10px 10px; }
			.logo-block { margin-bottom: 20px; padding: 10px; border: 1px solid red; text-align: center; }
			.app-logo { width: 85%; }
			.footer-block { margin-top: 20px; margin-bottom: 20px; padding: 10px; text-align: center; }
			hr { border: 1px solid red; }
		</style>
		<?= isset($this->css_content) ? $this->css_content : '' ?>
	</head>
	<body>
		<div class="container-block">
			<div class="logo-block">
				<img class="app-logo" src="<?= base_url('assets/images/mobile_apps/logo.png'); ?>">
			</div>

			<?= $this->page_content; ?>

			<div class="footer-block">
				<h3><?= get_company_name(); ?></h3>
				<hr>
				<h5><?= get_company_address(); ?></h5>
			</div>
		</div>
		<script type="text/javascript" src="<?= base_url('assets/jquery/jquery-1.9.1.min.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/jquery/jquery-ui.1.10.4.js') ?>"></script>
		<script type="text/javascript" src="<?= base_url('assets/admin/sweetalert2/js/sweetalert2.min.js') ?>"></script>
		<?= isset($this->script_content) ? $this->script_content : '' ?>
	</body>
</html>
