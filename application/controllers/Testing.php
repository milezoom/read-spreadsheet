<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Testing extends CI_Controller
{
    public function index()
    {
        $this->load->helper('sheet_api');
        $config = createConfig();
        loadTokenFromDB();
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

        /*-------------------------- get list spreadsheet on your drive -----------------------------*/
        $spreadsheetList = $spreadsheetAPI->getSpreadsheetList();
        $spreadsheetIds = array_keys($spreadsheetList);
        $data['sslist'] = $spreadsheetList;
        /*-------------------------------------------------------------------------------------------*/

        /*----------------------- get list worksheet on first spreadsheet ---------------------------*/
        $worksheetList = $spreadsheetAPI->getWorksheetList($spreadsheetIds[0]);
        $worksheetIds = array_keys($worksheetList);
        $data['wslist'] = $worksheetList;
        /*-------------------------------------------------------------------------------------------*/

        /*---------------------- get raw data feed from selected worksheet --------------------------*/
        $worksheetDataList = $spreadsheetAPI->getWorksheetDataList($spreadsheetIds[0], $worksheetIds[0]);
        $data['wsdlist'] = $worksheetDataList;
        /*-------------------------------------------------------------------------------------------*/

        /*------------------- get data feed from cell range selected worksheet ----------------------*/
        $cellRange = ['columnStart' => 1, 'columnEnd' => 1, 'rowStart' => 1, 'rowEnd' => 4]; //optional cell range
        $worksheetCellList = $spreadsheetAPI->getWorksheetCellList($spreadsheetIds[0], $worksheetIds[0], $cellRange);
        $data['wsclist'] = $worksheetCellList;
        /*-------------------------------------------------------------------------------------------*/

        /*------------------ update value for selected cell (Cell A2 -> 'Kopi') ---------------------*/
        $worksheetCellList['A2']->setValue('Kopi');
        $spreadsheetAPI->updateWorksheetCellList($spreadsheetIds[0], $worksheetIds[0], $worksheetCellList);
        /*-------------------------------------------------------------------------------------------*/

        removeTokenFile();

        $this->pageTitle = 'List';
        $this->headerText = 'Spreadsheet List';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('lists', $data);
    }
}
?>
