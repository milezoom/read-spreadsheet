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
        //$data['sslist'] = $spreadsheetList;
        /*-------------------------------------------------------------------------------------------*/

        /*----------------------- get list worksheet on first spreadsheet ---------------------------*/
        $worksheetList = $spreadsheetAPI->getWorksheetList($spreadsheetIds[0]);
        $worksheetIds = array_keys($worksheetList);
        //$data['wslist'] = $worksheetList;
        /*-------------------------------------------------------------------------------------------*/

        /*---------------------- get raw data feed from selected worksheet --------------------------*/
        $worksheetDataList = $spreadsheetAPI->getWorksheetDataList($spreadsheetIds[0], $worksheetIds[0]);
        //$data['wsdlist'] = $worksheetDataList;
        /*-------------------------------------------------------------------------------------------*/

        /*------------------- get data feed from cell range selected worksheet ----------------------*/
        //$cellRange = ['columnStart' => 1, 'columnEnd' => 3, 'rowStart' => 1, 'rowEnd' => 5]; //optional cell range
        $worksheetCellList = $spreadsheetAPI->getWorksheetCellList($spreadsheetIds[0], $worksheetIds[0]);//, $cellRange);
        //$data['wsclist'] = $worksheetCellList;
        /*-------------------------------------------------------------------------------------------*/

        /*------------------ update value for selected cell (Cell A2 -> 'Kopi') ---------------------*/
        //$worksheetCellList['A2']->setValue('Kopi');
        //$spreadsheetAPI->updateWorksheetCellList($spreadsheetIds[0], $worksheetIds[0], $worksheetCellList);
        /*-------------------------------------------------------------------------------------------*/

        /*--------------------------------- the main code for view ----------------------------------*/
        $sheetList = array();
        $wsList = array();
        foreach($spreadsheetIds as $key){
            $temp_array = array();
            $sheetList[$spreadsheetList[$key]['name']] = $key;
            $worksheets = $spreadsheetAPI->getWorksheetList($key);
            $wsKeys = array_keys($worksheets);
            for($i = 0; $i < count($wsKeys); $i++){
                $name = $worksheets[$wsKeys[$i]]['name'];
                $id_name = $name.'('.$wsKeys[$i].')';
                array_push($temp_array,$id_name);
            }
            $wsList[$spreadsheetList[$key]['name']] = $temp_array;
        }
        $data['sheetList'] = $sheetList;
        $data['wsList'] = $wsList;
        /*-------------------------------------------------------------------------------------------*/

        removeTokenFile();

        $this->pageTitle = 'List';
        $this->headerText = 'Spreadsheet List';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('lists', $data);
    }

    public function update()
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

        $sheetid = $this->input->post('sheetid');
        $worksid = $this->input->post('worksid');
        $cellid = $this->input->post('cellid');
        $upvalue = $this->input->post('upvalue');

        $worksheetCellList = $spreadsheetAPI->getWorksheetCellList($sheetid,$worksid);
        $worksheetCellList[$cellid]->setValue($upvalue);
        $spreadsheetAPI->updateWorksheetCellList($sheetid, $worksid, $worksheetCellList);

        $this->load->helper('url');
        redirect('Testing');
    }

    public function write()
    {
        $this->load->helper('sheet_api');
        $filename = $this->input->post('sheetname');
        $data = $this->input->post('writevalue');
        $url = writeNewSpreadsheetURL($filename, $data);
        $this->load->helper('url');
        redirect($url);
    }

    public function add()
    {
        $this->load->helper('sheet_api');
        $spreadsheetId = $this->input->post('sheetid');
        $worksname = $this->input->post('worksname');
        $data = $this->input->post('writevalue');
        $url = addNewRowURL($spreadsheetId, $worksname, $data);
        $this->load->helper('url');
        redirect($url);
    }

    public function writeFromQuery()
    {
        $filename = $this->input->post('sheetname');
        $this->load->database('transaction');
        $query = $this->input->post('query');
        $result = $this->db->query($query)->result_array();
        $maxRow = $this->config->item('maxRow');
        if(count($result)>$maxRow){
            $this::splitQueryResult($filename, $result);
        } else {
            $this->load->helper('sheet_api');
            $arraydata = array();
            foreach ($result as $value) {
                $data = implode('_!',$value);
                array_push($arraydata, $data);
            }
            $strdata = implode('()',$arraydata);
            $url = writeQuery2SheetURL($filename, $strdata);
            $this->load->helper('url');
            redirect($url);
        }
    }

    private function splitQueryResult($filename, $arraydata)
    {
        $bigrows = array_chunk($arraydata,5);
        $this->load->helper('sheet_api');
        $urls = array();
        $rowcount = array();
        $firstrow = 0;
        $endrow = -1;
        foreach ($bigrows as $rows) {
            $endrow += count($rows);
            $arraydata = array();
            foreach ($rows as $row) {
                $rowstr = implode('_!',$row);
                array_push($arraydata, $rowstr);
            }
            $strdata = implode('()',$arraydata);
            $url = writeQuery2SheetURL($filename, $strdata);
            array_push($urls,$url);
            array_push($rowcount,$firstrow.' - '.$endrow);
            $firstrow += count($rows);
        }

        $data['urls'] = $urls;
        $data['rowcount'] = $rowcount;

        $this->pageTitle = 'Insert List';
        $this->headerText = 'Insert Multiple To Spreadsheet';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('executelist', $data);
    }
}
?>
