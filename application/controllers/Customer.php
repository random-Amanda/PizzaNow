<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function index()
    {
        $this->load->view('header');
        $this->load->view('homepage');
    }

    public function add()
    {
        $data           = array();
        $this->load->model('CustomerModel');
        $credentials = $this->CustomerModel->addUser($this->input->post());
        if (is_null($credentials)) {
            $data['userExists'] = false;
        } else {
            if ($credentials == true) {
                $data['creds'] = $credentials;
                $this->session->custId = $credentials->CUST_ID;
                $this->session->name = $credentials->NAME;
            }
            $data['userExists'] = true;
        }
        echo json_encode($data);
    }

    public function login()
    {
        $data           = array();
        $this->load->model('CustomerModel');
        $credentials = $this->CustomerModel->authenticate($this->input->post());
        if (is_null($credentials)) {
            $data['userExists'] = false;
        } else {
            $data['userExists'] = true;
            if ($credentials == false) {
                $data['loggedin'] = false;
            } else {
                $data['loggedin'] = true;
            }
        }

        echo json_encode($data);
    }
}
