<?php

defined('BASEPATH') or exit('No direct script access allowed');
class Homepage extends CI_Controller
{
    public function index()
    {
        $this->pageTitle = 'Home';
        $this->headerText = 'List Google Spreadsheet';
        $this->layout = 'Yes';
        $this->layoutName = 'default';
        $this->load->view('homepage');
    }
    public function authorize()
    {
        $this->load->helper('sheet_api');
        $this->load->helper('url');
        $url = buildURL();
        redirect($url);
    }
}
