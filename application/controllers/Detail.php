<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Detail extends CI_Controller
{

    public function loadProductDetails()
    {
        $prodId = $this->uri->segment(3);
        $this->load->model('ProductModel');
        $prodwithdetails = $this->ProductModel->getProductWithDetails($prodId);
        if (is_null($prodwithdetails)) {
            $this->load->view('header');
            $this->load->view('errorpage');
        } else {
            $data = array('details' => $prodwithdetails['details'], 'product' => $prodwithdetails['product']);
            if ($prodwithdetails['product']->TYPE == "PIZZA") {
                $toppings = $this->ProductModel->getToppings();
                $data['toppings'] = $toppings;
            } else {

                $data['toppings'] = null;
            }
            $this->load->view('header');
            $this->load->view('detailpage', $data);
        }
    }
}
