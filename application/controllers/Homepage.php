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
    public function signup()
    {
        $this->load->helper('sheet_api');
        $this->load->helper('url');
        $url = buildURL();
        redirect($url);
    }
    public function authorize()
    {
        $this->load->database();
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        //check if email exist in database
        $this->db->select();
        $this->db->where('email', $email);
        $this->db->from('users');
        $data = $this->db->get()->row_array();
        if (empty($data)) {
            $message['error_email'] = 'Email not exists, please do Sign Email';

            $this->pageTitle = 'Home';
            $this->headerText = 'List Google Spreadsheet';
            $this->layout = 'Yes';
            $this->layoutName = 'default';
            $this->load->view('homepage', $message);
        }
        if (password_verify($password, $data['password'])) {
            //TODO: implement klo berhasil
        } else {
            $message['error_pass'] = 'Password salah.';

            $this->pageTitle = 'Home';
            $this->headerText = 'List Google Spreadsheet';
            $this->layout = 'Yes';
            $this->layoutName = 'default';
            $this->load->view('homepage', $message);
        }
    }
}
