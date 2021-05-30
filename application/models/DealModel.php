<?php


class DealModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getDeals()
    {
        $this->db->select('*');
        $this->db->from('DEAL');
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }
}
