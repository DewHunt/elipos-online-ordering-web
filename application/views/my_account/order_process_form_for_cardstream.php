<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Redirect To Merchant</title>
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap/css/bootstrap.css') ?>" type="text/css" media="screen">
        <style type="text/css">
        	.loader-image {
        		width: 365px;
        		height: 229px;
        		display: block;
        		max-width: 100%;
        		height: auto;
        		margin-left: auto;
        		margin-right: auto;
        	}
        	.green-color { color: green; }
        	.red-color { color: red; }
        </style>
	</head>
	<body>
		<div class="jumbotron text-center" style="margin-bottom:0">
			<h1>Redirecting To Merchant Site</h1>
			<img class="loader-image" src="<?= base_url('assets/images/redirecting-loader.webp'); ?>">
			<h3>Thanks For Your Order</h3>
			<p>Your payment of <b class="red-color"><?= get_price_text($total_amount/100) ?></b> is <b class="green-color">Complete.</b></p>
			<!-- <p>Reference ID : <b class="red-color">EI283S8DSDNS82429</b></p> -->
			<p>Your are going back to <a href="<?= base_url('menu'); ?>"><b><?= get_company_name(); ?></b>...</a></p>
			<p>If you are not redirecting within 10 minutes, <a href="<?= base_url('menu') ?>"><b>CLICK HERE</b></a></p>
			<h5 style="color: red;">(Please do not CLOSE YOUR BROWSER)</h5>
		</div>

        <script type="text/javascript" src="<?= base_url('assets/jquery/jquery-2.2.4.min.js') ?>"></script>
        <script src="<?= base_url('assets/bootstrap/js/bootstrap.js') ?>" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				let url = '<?= base_url('order/order_process') ?>';
			    let form_data = <?= $form_data ?>;
			    form_data = JSON.stringify(form_data);
			    form_data = JSON.parse(form_data);
			    // console.log(form_data);
	            if (form_data) {
					let form = document.createElement("form");
		            form.setAttribute('action', url);
		            form.setAttribute('method', 'post');
					$.each(form_data, function(key, value) {
		    			var input = document.createElement('input');
		    			input.setAttribute('type', 'hidden');
					    input.setAttribute('name', key);
					    input.setAttribute('value', value);
					    form.appendChild(input);
					});
					$('body').append(form);
					form.submit();
	            }
			});
		</script>
	</body>
</html>