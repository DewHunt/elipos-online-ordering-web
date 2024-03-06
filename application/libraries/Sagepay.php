<?php

class Sagepay {
	
	public function __construct() {
	}

	public function sagepay_transaction($card_data,$total_amount = 0,$notification_url,$ip_address = "192.168.0.161") {
		$result = "";
		$is_valid = true;
		$msg = "";
		if ($notification_url) {
			$basic_authorization_code = get_sagepay_base64_encoded_integration_key_and_password();
			if ($basic_authorization_code) {
				$merchant_session_key = $this->get_sagepay_merchant_session_key($basic_authorization_code);
				if (isset($merchant_session_key['merchantSessionKey']) && $merchant_session_key['merchantSessionKey']) {
					$merchant_session_key = $merchant_session_key['merchantSessionKey'];
					$card_identifier = $this->get_sagepay_card_identifier($merchant_session_key, $card_data);
					if (isset($card_identifier['cardIdentifier']) && $card_identifier['cardIdentifier']) {
						$decoded_card_data = json_decode($card_data);
						$cardholderName = $decoded_card_data->cardDetails->cardholderName;
						$card_identifier = $card_identifier['cardIdentifier'];
						$total_amount = (int)round(($total_amount * 100), 0);

	                    $request_data = '
	                        {
	                            "transactionType": "Payment",
	                            "paymentMethod": {
	                                "card": {
	                                    "merchantSessionKey": "' . $merchant_session_key . '",
	                                    "cardIdentifier": "' . $card_identifier . '",
	                                    "reusable": false,
	                                    "save": false
	                                }
	                            },
	                            "vendorTxCode": "elipos-' . time() . '",
	                            "amount": ' . $total_amount . ',
	                            "currency": "GBP",
	                            "description": "Payment",
	                            "settlementReferenceText": "' . time() . '",
	                            "customerFirstName": "' . $cardholderName . '",
	                            "customerLastName": "N/A",
	                            "billingAddress": {
	                                "address1": "88",
	                                "address2": "",
	                                "address3": "",
	                                "city": "London",
	                                "postalCode": "412",
	                                "country": "GB",
	                                "state": "st"
	                            },
	                            "entryMethod": "Ecommerce",
	                            "apply3DSecure": "UseMSPSetting",
	                            "applyAvsCvcCheck": "UseMSPSetting",
	                            "strongCustomerAuthentication": {
	                                "notificationURL": "'.$notification_url.'",
	                                "browserIP": "'.$ip_address.'",
	                                "browserAcceptHeader": "\\\*/\\\*",
	                                "browserJavascriptEnabled": false,
	                                "browserJavaEnabled": false,
	                                "browserLanguage": "'.substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2).'",
	                                "browserColorDepth": 1,
	                                "browserScreenHeight": "500",
	                                "browserScreenWidth": "500",
	                                "browserTZ": "150",
	                                "browserUserAgent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:67.0) Gecko/20100101 Firefox/67.0",
	                                "challengeWindowSize": "Small",
	                                "acctID": "1245678",
	                                "transType": "GoodsAndServicePurchase",
	                                "threeDSRequestorAuthenticationInfo": {
	                                    "threeDSReqAuthData": "",
	                                    "threeDSReqAuthMethod": "LoginWithThreeDSRequestorCredentials",
	                                    "threeDSReqAuthTimestamp": "'.date('Ymdhi').'"
	                                },
	                                "threeDSRequestorPriorAuthenticationInfo": {
	                                    "threeDSReqPriorAuthData": "data",
	                                    "threeDSReqPriorAuthMethod": "FrictionlessAuthentication",
	                                    "threeDSReqPriorAuthTimestamp": "'.date('Ymdhi').'",
	                                    "threeDSReqPriorRef": "2cd842f5-da5d-40b7-8ae6-6ce61cc7b580"
	                                },
	                                "acctInfo": {
	                                    "chAccAgeInd": "MoreThanSixtyDays",
	                                    "chAccChange": "'.date('Ymd').'",
	                                    "chAccChangeInd": "MoreThanSixtyDays",
	                                    "chAccDate": "'.date('Ymd').'",
	                                    "chAccPwChange": "'.date('Ymd').'",
	                                    "chAccPwChangeInd": "MoreThanSixtyDays",
	                                    "nbPurchaseAccount": "5",
	                                    "provisionAttemptsDay": "0",
	                                    "txnActivityDay": "1",
	                                    "txnActivityYear": "24",
	                                    "paymentAccAge": "'.date('Ymd').'",
	                                    "paymentAccInd": "MoreThanSixtyDays",
	                                    "shipAddressUsage": "'.date('Ymd').'",
	                                    "shipAddressUsageInd": "MoreThanSixtyDays",
	                                    "shipNameIndicator": "FullMatch",
	                                    "suspiciousAccActivity": "NotSuspicious"
	                                },
	                                "merchantRiskIndicator": {
	                                    "deliveryEmailAddress": "demo@elipos.co.uk",
	                                    "deliveryTimeframe": "OvernightShipping",
	                                    "preOrderDate": "'.date('Ymd').'",
	                                    "preOrderPurchaseInd": "MerchandiseAvailable",
	                                    "reorderItemsInd": "Reordered",
	                                    "shipIndicator": "CardholderBillingAddress"
	                                },
	                                "threeDSExemptionIndicator": "TransactionRiskAnalysis",
	                                "website": "'.base_url().'"
	                            },
	                            "credentialType": {
	                                "cofUsage": "First",
	                                "initiatedType": "CIT"
	                            },
	                            "fiRecipient": {
	                                "accountNumber": "1234567890",
	                                "surname": "Surname",
	                                "postcode": "EC1V 8AB",
	                                "dateOfBirth": "19900212"
	                            }
	                        }
	                    ';

                        /* API URL */
                        $url = get_sagepay_active_server()."transactions";

                        /* Init cURL resource */
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                            CURLOPT_URL => $url,
                            CURLOPT_RETURNTRANSFER => true,
                            CURLOPT_SSL_VERIFYPEER => false,
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_CUSTOMREQUEST => "POST",
                            CURLOPT_POSTFIELDS => $request_data,
                            CURLOPT_HTTPHEADER => array(
                                // "Accept: application/json",
                                "Authorization: Basic " . $basic_authorization_code,
                                "Cache-Control: no-cache",
                                "Content-Type:application/json",
                            ),
                        ));
                        /* execute request */
                        $response = curl_exec($curl);
                        $result = json_decode($response, true);                            
                        $err = curl_error($curl);
                        curl_close($curl);
                        
                        if ($result && isset($result['status']) && $result['status'] == 'Invalid') {
                            $is_valid = false;
                            $msg = $result['statusDetail'];
                        }
                        
                        if ($result && isset($result['errors']) && count($result['errors'] > 0)) {
                            $is_valid = false;
                            $msg = "Payment incomplete, please try again.";
                        }
					} else {
	                    $is_valid = false;
	                    $msg = "Card details are invalid.";
	                    if (isset($card_identifier['errors'])) {
	                        $card_identifier_errors = $card_identifier['errors'][0];
	                        if (isset($card_identifier_errors['clientMessage'])) {
	                            $msg = $card_identifier_errors['clientMessage'];
	                        } else if (isset($card_identifier_errors['description'])) {
	                            $msg = $card_identifier_errors['description'];
	                        }
	                    }
					}				
				} else {
	                $is_valid = false;
	                $msg = "Card payments are incomplete, please try again.";
	                if (isset($merchant_session_key['description'])) {
	                    $msg = $merchant_session_key['description'];
	                }
				}
			} else {
	            $is_valid = false;
	            $msg = "Authentication failed, please try again.";
			}
		} else {
            $is_valid = false;
            $msg = "Notification URL not found, please contact to authority.";
		}

		return [$result,$is_valid,$msg];
	}

    public function get_sagepay_merchant_session_key($basic_authorization_code = "") {
        $result = '';
        if ($basic_authorization_code) {
            $vendor_name = get_sagepay_vendor_name();
            $request_data = '{
                "vendorName": "'.$vendor_name.'"
            }';

            $url = get_sagepay_active_server()."merchant-session-keys";

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $request_data,
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Basic " . $basic_authorization_code,
                    "Cache-Control: no-cache",
                    "Content-Type: application/json"
                )
            ));

            $response = curl_exec($curl);
            $result = json_decode($response, true);
            $err = curl_error($curl);
            curl_close($curl);
        }

        return $result;
    }

    public function get_sagepay_card_identifier($merchant_session_key, $card_data) {
        $card_identifier = "";

        $url = get_sagepay_active_server()."card-identifiers";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $card_data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $merchant_session_key,
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);
        $result = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);

        return $result;
    }

    public function retrieve_sagepay_transaction($transaction_id = '') {
        $basic_authorization_code = get_sagepay_base64_encoded_integration_key_and_password();

        $environment = get_sagepay_environment();
        // $transaction_id = 'F8868CAE-BB6D-EF34-CD8E-1A9C6138DE8C';

        $url = get_sagepay_active_server()."transactions/".$transaction_id;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $basic_authorization_code,
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);
        $results = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);
        return $results;
    }

    public function complete_3d_secure_sagepay_transaction($data) {
        $basic_authorization_code = get_sagepay_base64_encoded_integration_key_and_password();

        $environment = get_sagepay_environment();
        $transaction_id = $data['MD'];
        $PaRes = $data['PaRes'];
        $request_data = array('paRes' => $PaRes);

        $url = get_sagepay_active_server()."transactions/".$transaction_id."/3d-secure";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($request_data),
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic " . $basic_authorization_code,
                "Cache-Control: no-cache",
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);
        $results = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);
        return $results;
    }

    public function sagepay_3d_secure_challenge_response($cres = '',$transaction_id = '') {
        $basic_authorization_code = get_sagepay_base64_encoded_integration_key_and_password();

        $request_data = '{"cRes": "'.$cres.'"}';
        $environment = get_sagepay_environment();
        $url = get_sagepay_active_server()."transactions/".$transaction_id."/3d-secure-challenge";

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $request_data,
            CURLOPT_HTTPHEADER => array(
                // "Accept: application/json",
                "Authorization: Basic " . $basic_authorization_code,
                "Cache-Control: no-cache",
                "Content-Type:application/json",
            ),
        ));

        $response = curl_exec($curl);
        $results = json_decode($response, true);
        $err = curl_error($curl);
        curl_close($curl);
        // dd($results);
        return $results;
    }

    public function sagepay_refund_transaction($transaction_id,$order_information_id,$total_amount) {
        if (empty($transaction_id) || empty($order_information_id)) {
            $status = false;
        } else {
            $basic_authorization_code = get_sagepay_base64_encoded_integration_key_and_password();

            if ($basic_authorization_code) {
            	$total_amount = (int)round(($total_amount * 100), 0);
                $request_data = '
                    {
                        "transactionType": "Refund",
                        "referenceTransactionId": "' . $transaction_id . '",
                        "vendorTxCode": "elipos-00' . $order_information_id . '",
                        "amount": ' . $total_amount . ',
                        "description": "Refund From Elipos"
                    }
                ';

                /* API URL */
                $url = get_sagepay_active_server()."transactions";

                /* Init cURL resource */
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => $request_data,
                    CURLOPT_HTTPHEADER => array(
                        // "Accept: application/json",
                        "Authorization: Basic " . $basic_authorization_code,
                        "Cache-Control: no-cache",
                        "Content-Type:application/json",
                    ),
                ));

                /* execute request */
                $response = curl_exec($curl);
                $results = json_decode($response, true);
                $err = curl_error($curl);
                curl_close($curl);

                $status = true;
                if ($err || isset($results['errors'])) {
                    $status = false;
                }
            } else {
                $status = false;
            }

        }
        return $status;
    }
}