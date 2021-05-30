<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Deal extends CI_Controller
{
    
    public function loadDeals()
    {
        $this->load->model('DealModel');
        $deals = $this->DealModel->getDeals();
        if (is_null($deals)) {
            $this->load->view('header');
            $this->load->view('errorpage');
        } else {
            $data = array('deals' => $deals);
            $this->load->view('header');
            $this->load->view('dealspage', $data);
        }
    }
}
