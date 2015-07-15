<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Authorized extends CI_Controller
{
    public function index()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $access_code = substr($url,-45,45);

        $this->load->helper('sheet_api');
        $oAuth = getOAuth2GoogleAPI();

        $token_data = $oAuth->getAccessTokenFromAuthCode($access_code);
        saveToken($token_data);

        $data = array();
        $config = createConfig();
        if(file_exists($config['tokenDataFile'])){
            $data['is_exists'] = TRUE;
        } else {
            $data['is_exists'] = FALSE;
        }

        $this->pageTitle = 'Token';
        $this->headerText = 'Saving Token';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('frontpage',$data);
        $this->load->view('savingtoken', $data);
    }
}
?>
