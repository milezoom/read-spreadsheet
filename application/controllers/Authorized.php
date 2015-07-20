<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Authorized extends CI_Controller
{
    public function index()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $access_code = substr($url, -45, 45);

        $this->load->helper('sheet_api');
        $oAuth = getOAuth2GoogleAPI();

        $token_data = $oAuth->getAccessTokenFromAuthCode($access_code);
        saveToken($token_data);

        $data = array();
        $this->load->database();
        $tokens = $this->db->get('token_data')->result_array();
        if(empty($tokens)){
            $data['is_exists'] = true;
        } else {
            $data['is_exists'] = false;
        }

        $this->pageTitle = 'Token';
        $this->headerText = 'Saving Token';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('savingtoken', $data);
    }
}
