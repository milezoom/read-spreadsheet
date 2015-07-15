<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends CI_Controller
{
    public function index()
    {
        $this->load->helper('sheet_api');
        $config = createConfig();
        $token_data = unserialize(file_get_contents($config['tokenDataFile']));
        $oAuthInstance = getOAuth2GoogleAPI();
        $oAuthInstance->setTokenData(
            $token_data['accessToken'],
            $token_data['tokenType'],
            $token_data['expiresAt'],
            $token_data['refreshToken']
        );
        $oAuthInstance->setTokenRefreshHandler(function(array $token_data){
            saveToken($token_data);
        });
        $spreadsheetAPI = createSpreadsheetAPI($oAuthInstance);

        $spreadsheetList = $spreadsheetAPI->getSpreadsheetList();

        $data['list'] = $spreadsheetList;

        $this->pageTitle = 'List';
        $this->headerText = 'Spreadsheet List';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('lists', $data);
    }
}
?>
