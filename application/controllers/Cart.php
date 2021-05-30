<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends CI_Controller
{
    function  __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function index()
    {
        $this->load->view('header');
        $this->load->view('cartpage');
    }

    public function loadCart()
    {
        $this->load->model('CartModel');
        $tempItem = $this->input->post();
        $tempItem['itemPrice'] = $this->CartModel->calculateItemPrice($this->input->post());
        $this->session->set_userdata('tempItem', $tempItem);
        $this->session->set_userdata('referrer_url', $this->agent->referrer());
        $this->load->view('header');
        $this->load->view('cartpage');
    }

    public function checkout()
    {
        $this->load->model('CartModel');
        $return = $this->CartModel->completeOrder();
        echo json_encode($return);
    }

    public function add()
    {
        $this->load->model('CartModel');
        $return = $this->CartModel->addToCart($this->input->post());
        echo json_encode($return);
    }

    public function remove()
    {
        $this->load->model('CartModel');
        $return = $this->CartModel->removeFromCart($this->input->post());
        redirect(site_url('Cart'));
    }
}
