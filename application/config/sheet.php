<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|
| Config file for authorization app access to google spreadsheet
|
*/

$config['OAuth2URL'] = array(
    'base' => 'https://accounts.google.com/o/oauth2',
	'auth' => 'auth', // for Google authorization
	'token' => 'token', // for OAuth2 token actions
	'redirect' => 'http://localhost/read-spreadsheet/index.php/authorized'
);

$config['clientID'] = '759581556765-51khqof20uk98f7r5cig2vje4bnjgob8.apps.googleusercontent.com';

$config['clientSecret'] = 'qrlfT5KkPM4CZgFYB-RETh4l';

$config['tokenDataFile'] = FCPATH.'assets/credentials/token_data';
?>
