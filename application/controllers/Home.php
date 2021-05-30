<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
        public function index()
        {
                $this->load->view('header');
                $this->load->view('homepage');
        }
        public function signUp()
        {
                $this->load->view('header');
                $this->load->view('signuppage');
        }
        public function login()
        {
                $this->load->view('header');
                $this->load->view('loginpage');
        }
        public function logout()
        {
                $this->session->set_userdata('custId', null);
                $this->session->set_userdata('name', null);
                $this->load->view('header');
                $this->load->view('homepage');
        }
}
