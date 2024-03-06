<!DOCTYPE html>
<html>
	<head>
	    <title>Customer Registration</title>
	</head>

	<body>
		<div class="row">
			<div class="col-lg-8">
				<p>Dear Customer,</p>
				<p>Congratulations! Your registration confirmation of <?= $companyName ?> is successfully completed with below information.</p>
				<p>We recommend you to save below information for your future reference.</p>
			</div>
		</div>
	    <table class="table table-bordered table-striped">
	    	<tbody>
	    		<tr>
	    			<td>First Name : </td>
	    			<td><?= $customerInfo->first_name ?></td>
	    		</tr>

	    		<tr>
	    			<td>Last Name : </td>
	    			<td><?= $customerInfo->last_name ?></td>
	    		</tr>
	    		
	    		<tr>
	    			<td>Email : </td>
	    			<td><?= $customerInfo->email ?></td>
	    		</tr>
	    		
	    		<tr>
	    			<td>Mobile : </td>
	    			<td><?= $customerInfo->mobile ?></td>
	    		</tr>
	    		
	    		<tr>
	    			<td>Billing Post Code : </td>
	    			<td><?= $customerInfo->billing_postcode ?></td>
	    		</tr>
	    		
	    		<tr>
	    			<td>Delivery Post Code : </td>
	    			<td><?= $customerInfo->delivery_postcode ?></td>
	    		</tr>
	    	</tbody>
	    </table>
		<div class="row">
			<div class="col-lg-8">
				Please See Our <a href="<?= base_url('terms_and_conditions') ?>">Terms And Conditions</a>.
			</div>
		</div>
	</body>
</html>