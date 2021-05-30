<?php


class ProductModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getToppings()
    {
        $this->db->select('PRODUCT.PROD_ID AS ID,
        PRODUCT.PROD_NAME AS NAME,
        PRODUCT.PROD_TYPE AS TYPE,
        PRODUCT.IMG AS IMG,
        PRODUCT_DETAIL.ID AS DETAIL_ID,
        PRODUCT_DETAIL.UNIT_PRICE AS UNIT_PRICE');
        $this->db->from('PRODUCT');
        $this->db->join('PRODUCT_DETAIL', 'PRODUCT.PROD_ID = PRODUCT_DETAIL.PROD_ID');
        $this->db->where('PRODUCT.PROD_TYPE', "TOPPING");
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function getProductWithDetails($prodId)
    {
        $this->db->select('PRODUCT.PROD_ID AS ID,
        PRODUCT.PROD_NAME AS NAME,
        PRODUCT.PROD_TYPE AS TYPE,
        PRODUCT.PROD_DESC AS DESCRIPTION,
        PRODUCT.IMG AS IMG,
        PRODUCT_DETAIL.ID AS DETAIL_ID,
        PRODUCT_DETAIL.UNIT_PRICE AS UNIT_PRICE,
        PRODUCT_DETAIL.SIZE AS SIZE');
        $this->db->from('PRODUCT');
        $this->db->join('PRODUCT_DETAIL', 'PRODUCT.PROD_ID = PRODUCT_DETAIL.PROD_ID');
        $this->db->where('PRODUCT.PROD_ID', $prodId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return array('product' => $query->row(), 'details' => $query->result());
        } else {
            return null;
        }
    }
    public function getProducts($type)
    {
        $this->db->select('*');
        $this->db->from('PRODUCT');
        $this->db->where('PRODUCT.PROD_TYPE', $type);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }
    public function getProductDetails($prodId)
    {
        $this->db->select('*');
        $this->db->from('PRODUCT_DETAILS');
        $this->db->where('PROD_ID', $prodId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }
}
