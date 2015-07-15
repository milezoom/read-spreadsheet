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
    //TODO: lanjutin 
}
?>
