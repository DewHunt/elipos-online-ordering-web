<?php
	$continent_name = $location ? $location->continent_name : '';
	$city = $location ? $location->city : '';
	$country_name = $location ? $location->country_name : '';
	$zipcode = $location ? $location->zipcode : '';
?>

<div style="font-family: 'Google Sans',Roboto,RobotoDraft,Helvetica,Arial,sans-serif; border-style: solid; border-width: thin; border-color: #dadce0; border-radius: 8px; width: 70%;">
	<div style="text-align: center;">
		<img src="<?= get_company_logo_url() ?>" style="width: 250px; padding: 10px;">
		<div style="font-size: 24px; font-weight: bold; color: red; margin-top: -25px;">Your password was changed</div>
		<div style="font-size: 18px; margin-top: -25px; color: green; margin-bottom: -60px;"><?= $customer_info->email ?></div>
	</div>
	<hr>
	<div>
		<p style="text-align: center; margin-top: -15px; margin-bottom: -10px;">This password for your <?= get_company_name() ?> account <b><?= $customer_info->email ?></b> was changed.</p>
		<p style="text-align: center; margin-top: -15px; margin-bottom: -10px;">On <b><?= date("l jS \of F Y h:i:s A") ?></b>, Near <b><?= $continent_name ?>, <?= $city ?>, <?= $country_name ?>-<?= $zipcode ?></b>
		</p>
	</div>
</div>