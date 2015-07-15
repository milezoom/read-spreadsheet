<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api/parser.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api/parser/simpleentry.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/cellitem.php';
include APPPATH . 'third_party/spreadsheet-api/oauth2/token.php';
include APPPATH . 'third_party/spreadsheet-api/oauth2/googleapi.php';

function createConfig()
{
    $CI =& get_instance();
    $config = array(
        'OAuth2URL' => $CI->config->item('OAuth2URL'),
        'clientID' => $CI->config->item('clientID'),
        'clientSecret' => $CI->config->item('clientSecret'),
        'tokenDataFile' => $CI->config->item('tokenDataFile')
    );
    return $config;
}

function getOAuth2GoogleAPI()
{
    $CI =& get_instance();
    $data = $CI->config->item('OAuth2URL');
    return new OAuth2\GoogleAPI(
        $data['base'].'/'.$data['auth'],
        $data['redirect'],
        $CI->config->item('clientID'),
        $CI->config->item('clientSecret')
    );
}

function saveCredentials(array $data)
{
    $config = createConfig();
    file_put_contents($config['tokenDataFile'], $data);
}

function buildURL()
{
    $scopeList = array(GoogleSpreadsheet\API::API_BASE_URL);
    $CI =& get_instance();
    $OAuth2URL = $CI->config->item('OAuth2URL');
    foreach ($scopeList as &$scopeItem)
    {
        $scopeItem = rtrim($scopeItem,'/') . '/';
    }

    $buildQuerystring = function(array $list) {
		$querystringList = [];
		foreach ($list as $key => $value) {
			$querystringList[] = rawurlencode($key) . '=' . rawurlencode($value);
		}
		return implode('&',$querystringList);
	};

	return sprintf(
		"%s/%s?%s\n\n",
		$OAuth2URL['base'],$OAuth2URL['auth'],
		$buildQuerystring([
			'access_type' => 'offline',
			'approval_prompt' => 'force',
			'client_id' => $CI->config->item('clientID'),
			'redirect_uri' => $OAuth2URL['redirect'],
			'response_type' => 'code',
			'scope' => implode(' ',$scopeList)
		])
	);
}
?>
