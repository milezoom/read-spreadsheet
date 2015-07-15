<?php
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api/parser.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/api/parser/simpleentry.php';
include APPPATH . 'third_party/spreadsheet-api/googlespreadsheet/cellitem.php';
include APPPATH . 'third_party/spreadsheet-api/oauth2/token.php';
include APPPATH . 'third_party/spreadsheet-api/oauth2/googleapi.php';

class Sheetfunction
{
    private $tokenData;
    private $oAuth2GoogleAPI;

    public function __construct()
    {
        $this->load->helper('sheet_api');
        $config = $createConfig();
        $token_data = file_get_contents($config['tokenDataFile']);
        $this->$tokenData = $token_data;

        $oAuth = $getOAuth2GoogleAPI();
        $oAuth->setTokenData(
            $token_data['accessToken'],
            $token_data['tokenType'],
            $token_data['expiresAt'],
            $token_data['refreshToken']
        );
        $oAuth->setTokenRefreshHandler(function(array $token_data){
            $this->saveOAuth2TokenData($token_data, $config['tokenDataFile']);
        });
    }

    public function createSpreadsheetAPI()
    {
        return new GoogleSpreadsheet\API($this->oAuth2GoogleAPI);
    }

    private function saveOAuth2TokenData(array $data, $path)
    {
        file_put_contents($path,$data);
    }
}
?>
