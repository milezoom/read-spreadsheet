<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/spreadsheet-api/googlespreadsheet/api.php';
include APPPATH.'third_party/spreadsheet-api/googlespreadsheet/api/parser.php';
include APPPATH.'third_party/spreadsheet-api/googlespreadsheet/api/parser/simpleentry.php';
include APPPATH.'third_party/spreadsheet-api/googlespreadsheet/cellitem.php';
include APPPATH.'third_party/spreadsheet-api/oauth2/token.php';
include APPPATH.'third_party/spreadsheet-api/oauth2/googleapi.php';

function createConfig()
{
    $CI = &get_instance();
    $config = array(
        'OAuth2URL' => $CI->config->item('OAuth2URL'),
        'clientID' => $CI->config->item('clientID'),
        'clientSecret' => $CI->config->item('clientSecret'),
        'tokenDataFile' => $CI->config->item('tokenDataFile'),
    );

    return $config;
}

function getOAuth2GoogleAPI()
{
    $CI = &get_instance();
    $data = $CI->config->item('OAuth2URL');

    return new OAuth2\GoogleAPI(
        $data['base'].'/'.$data['token'],
        $data['redirect'],
        $CI->config->item('clientID'),
        $CI->config->item('clientSecret')
    );
}

function saveToken(array $data)
{
    $CI = &get_instance();

    $CI->load->database();
    $token_data = array(
        'id' => 1,
        'access_token' => $data['accessToken'],
        'expires_at' => $data['expiresAt'],
        'token_type' => $data['tokenType'],
        'refresh_token' => $data['refreshToken']
    );
    $tokens = $CI->db->get('token_data')->result_array();
    if(empty($tokens)){
        $CI->db->insert('token_data', $token_data);
    } else {
        $CI->db->update('token_data', $token_data);
    }
}

function loadTokenFromDB()
{
    $CI = &get_instance();
    $config = createConfig();
    $CI->load->database();
    $tokens = $CI->db->get('token_data')->result_array();
    $token_data = array(
        'accessToken' => $tokens[0]['access_token'],
        'expiresAt' => $tokens[0]['expires_at'],
        'tokenType' => $tokens[0]['token_type'],
        'refreshToken' => $tokens[0]['refresh_token']
    );
    file_put_contents($config['tokenDataFile'], serialize($token_data));
}

function removeTokenFile()
{
    $CI = &get_instance();
    $config = createConfig();
    unlink($config['tokenDataFile']);
}

function buildURL()
{
    $scopeList = array(GoogleSpreadsheet\API::API_BASE_URL);
    $CI = &get_instance();
    $OAuth2URL = $CI->config->item('OAuth2URL');
    foreach ($scopeList as &$scopeItem) {
        $scopeItem = rtrim($scopeItem, '/').'/';
    }

    $buildQuerystring = function (array $list) {
        $querystringList = [];
        foreach ($list as $key => $value) {
            $querystringList[] = rawurlencode($key).'='.rawurlencode($value);
        }

        return implode('&', $querystringList);
    };

    return sprintf(
        "%s/%s?%s\n\n",
        $OAuth2URL['base'], $OAuth2URL['auth'],
        $buildQuerystring([
            'access_type' => 'offline',
            'approval_prompt' => 'force',
            'client_id' => $CI->config->item('clientID'),
            'redirect_uri' => $OAuth2URL['redirect'],
            'response_type' => 'code',
            'scope' => implode(' ', $scopeList),
        ])
    );
}

function createSpreadsheetAPI($oAuth)
{
    $api = new GoogleSpreadsheet\API($oAuth);

    return $api;
}

function writeNewSpreadsheetURL($filename,$strdata)
{
    $CI = &get_instance();
    $sheetURL = $CI->config->item('scriptWriteURL');
    $routeURL = $CI->config->item('routeScriptURL');
    $data = array(
        'filename' => $filename,
        'data' => $strdata,
        'homepage' => $routeURL
    );
    $parameter = http_build_query($data);
    $sheetURL .= $parameter;
    return $sheetURL;
}

function addNewRowURL($spreadsheetId,$sheetName,$strdata)
{
    $CI = &get_instance();
    $sheetURL = $CI->config->item('scriptAppendURL');
    $routeURL = $CI->config->item('routeScriptURL');
    $data = array(
        'ssid' => $spreadsheetId,
        'sheetname' => $sheetName,
        'data' => $strdata,
        'homepage' => $routeURL
    );
    $parameter = http_build_query($data);
    $sheetURL .= $parameter;
    return $sheetURL;
}

function writeQuery2SheetURL($filename,$strdata)
{
    $CI = &get_instance();
    $sheetURL = $CI->config->item('scriptQueryAppendURL');
    $routeURL = $CI->config->item('routeScriptURL');
    $data = array(
        'filename' => $filename,
        'data' => $strdata,
        'homepage' => $routeURL
    );
    $parameter = http_build_query($data);
    $sheetURL .= $parameter;
    return $sheetURL;
}
