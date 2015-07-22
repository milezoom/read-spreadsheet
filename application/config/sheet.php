<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|
| Needed config for spreadsheet api
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

$config['scriptWriteURL'] = 'https://script.google.com/a/macros/lazada.co.id/s/AKfycbzm9thAlsh5oSvmH279ZT6h-PGH2vjfCi6p17QgWmBZZZ0FThc/exec?';

$config['scriptAppendURL'] = 'https://script.google.com/a/macros/lazada.co.id/s/AKfycbyNLoRDWxUymyeCxMigxFhz4gFdtGZU0_qr-qclV7mU_C3oI0hA/exec?';

$config['scriptQueryAppendURL'] = 'https://script.google.com/a/macros/lazada.co.id/s/AKfycbz65KuTaCnOLzX-F5rscKRdkh5X87gFLAinqi3Zmt8UwoaFvd0S/exec?';

$config['routeScriptURL'] = 'http://localhost/read-spreadsheet';

$config['maxRow'] = 5;
?>
