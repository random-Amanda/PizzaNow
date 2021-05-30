<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Product extends CI_Controller
{    

    public function loadProducts()
    {
        $type = $this->uri->segment(3);
        $this->load->model('ProductModel');
        $products = $this->ProductModel->getProducts($type);
        if (is_null($products)) {
            $this->load->view('errorpage');
        } else {
            $data = array('products' => $products);
            $this->load->view('header');
            $this->load->view('productpage', $data);
        }
    }
}
