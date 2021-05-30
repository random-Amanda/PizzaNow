<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{
    public function viewReceipt()
    {
        $orderId = $this->uri->segment(3);
        $this->load->model('OrderModel');
        $invoice = $this->OrderModel->getInvoice($orderId);
        $this->load->view('header');
        $this->load->view('orderpage',$invoice);
    }
}
