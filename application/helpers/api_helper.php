<?php
function get_public_data() {
	$these = &get_instance();
	$dataArray = array();
	$dataArray['base_url'] = base_url();
	$allPageSettingData = $these->Page_Settings_Model->get();

	foreach ($allPageSettingData as $pageSettingData) {
		$dataArray[$pageSettingData->name] = $pageSettingData;
	}

	$settingsNameArray = array('company_details','social_media','weekend_off','home_promo');
	foreach ($settingsNameArray as $settingsName) {
		$companyDetails = $these->Settings_Model->get_by_name($settingsName);
		$companyDetailsValue = json_decode($companyDetails->value);
		$dataArray[$companyDetails->name] = $companyDetailsValue;
	}

	$AllShopTiming = $these->Shop_timing_Model->get();
	$dataArray['opening_and_closing'] = $AllShopTiming;
	return $dataArray;
}

function is_auth_key_valid($authorized_key = '') {
	$these = &get_instance();
	$auth_key = $these->Settings_Model->get_by(array("name" => 'auth_key'), true)->value;
	$encoded_auth_key = base64_encode($auth_key);
	if ($encoded_auth_key == $authorized_key) {
		return true;
	}
	return false;
}