<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Homepage extends CI_Controller
{
    public function index()
    {
        $this->load->database();
        $tokens = $this->db->get('token_data')->result_array();
        if(empty($tokens)){
            $data['is_token_exists'] = FALSE;
        } else {
            $data['is_token_exists'] = TRUE;
        }
        $this->pageTitle = 'Home';
        $this->headerText = 'List Google Spreadsheet';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('homepage', $data);
    }
    public function authorize()
    {
        $this->load->helper('sheet_api');
        $this->load->helper('url');
        $url = buildURL();
        redirect($url);
    }
    public function lists()
    {
        $this->load->helper('sheet_api');
        $this->load->helper('url');
        loadTokenFromDB();
        redirect('Spreadsheet');
    }
}
