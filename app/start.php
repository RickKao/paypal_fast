<?php

require 'vendor/autoload.php';

define('SITE_URL', 'http://localhost/paypal_fast');

$paypal = new \PayPal\Rest\ApiContext(
	new \PayPal\Auth\OAuthTokenCredential(
		'AfGYnSxFm9GJ2Hq9LZtICtFBxEMF-ABmcyg9vYAdaFA3am01ciBtEZID_yhAVrKLpMg8hAJkC1xm0xe3',
		'EPV_zf8g77wury-wBOlR5RP5vpR05FNb644uFKRY_Df3nJUcJqCwRRpWg9Zmfl4DPCgmd5VMeSNmdr10'
	)
	);