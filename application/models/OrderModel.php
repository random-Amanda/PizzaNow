<?php

class OrderModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }



    public function getInvoice($orderId)
    {
        $data = array();
        $total = 0.00;
        $order = $this->getOrder($orderId);
        if (!is_null($order)) {
            foreach ($order as $row) {
                $data['order'] = array(
                    'OrderId' => $orderId,
                    'Customer ' => $row->NAME,
                    'Delivery Address ' => $row->ADDRESS,
                    'Timestamp ' => $row->TIME
                );
            }
        }
        $orderItems = $this->getOrderItems($orderId);
        if (!is_null($orderItems)) {
            $data['orderItems'] = array();
            foreach ($orderItems as $item) {
                if (!isset($item->size)) {
                    $item->size = '';
                }
                $showItem = array(
                    'NAME' => $item->name,
                    'SIZE' => $item->size,
                    'QTY' => $item->qty,
                    'UNIT_PRICE' => $item->price
                );
                if (isset($item->topping)) {
                    $showItem['topping'] = array(
                        'NAME' => $item->topping[0]->name,
                        'PRICE' => $item->topping[0]->price,
                    );
                    $showItem['TOTAL'] = ($item->topping[0]->price + $item->price) * $item->qty;
                } else {
                    $showItem['TOTAL'] = $item->price * $item->qty;
                }
                $data['orderItems'][] = $showItem;
                $total += $showItem['TOTAL'];
            }
            $data['order']['Total Bill Value   Rs.'] = $total;
            return $data;
        } else {
            return null;
        }
    }

    private function getOrder($orderId)
    {
        $this->db->select('CUST_ORDER.TIME,
        CUSTOMER.NAME,
        CUSTOMER.ADDRESS');
        $this->db->from('CUST_ORDER');
        $this->db->join('CUSTOMER', 'CUST_ORDER.CUST_ID=CUSTOMER.CUST_ID');
        $this->db->where('CUST_ORDER.ORDER_ID', $orderId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    private function getToppings($orderItemId)
    {
        $this->db->select('
        PRODUCT.PROD_NAME as name,
        PRODUCT_DETAIL.UNIT_PRICE as price');
        $this->db->from('PRODUCT');
        $this->db->join('PRODUCT_DETAIL', 'PRODUCT_DETAIL.PROD_ID=PRODUCT.PROD_ID');
        $this->db->join('PIZZA_TOPPING_MAPPING', 'PIZZA_TOPPING_MAPPING.TOPPING_ID=PRODUCT.PROD_ID');
        $this->db->join('ORDER_ITEM', 'ORDER_ITEM.ID=PIZZA_TOPPING_MAPPING.ORDER_ITEM_ID');
        $this->db->where('ORDER_ITEM.ID', $orderItemId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    private function getOrderItems($orderId)
    {
        $items = array();
        $this->db->select(
            'PRODUCT.PROD_NAME as name,
            PRODUCT.PROD_TYPE as type,
            PRODUCT.PROD_ID,
            PRODUCT_DETAIL.SIZE as size,
            PRODUCT_DETAIL.UNIT_PRICE as price,
            ORDER_ITEM.ID as item_id,
            ORDER_ITEM.QTY as qty'
        );
        $this->db->from('PRODUCT');
        $this->db->join('PRODUCT_DETAIL', 'PRODUCT.PROD_ID=PRODUCT_DETAIL.PROD_ID');
        $this->db->join('ORDER_ITEM', 'ORDER_ITEM.PROD_DETAIL_ID=PRODUCT_DETAIL.ID');
        $this->db->where('ORDER_ID', $orderId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                if (isset($row->type)) {
                    if ($row->type == 'PIZZA') {
                        if (!is_null($this->getToppings($row->item_id))) {
                            $row->topping = $this->getToppings($row->item_id);
                        }
                    }
                }
                $items[] = $row;
            }
        }

        $this->db->select(
            'DEAL.NAME as name,
            DEAL.DEAL_ID,
            DEAL.UNIT_PRICE as price,
            ORDER_ITEM.QTY as qty'
        );
        $this->db->from('DEAL');
        $this->db->join('ORDER_ITEM', 'ORDER_ITEM.DEAL_ID=DEAL.DEAL_ID');
        $this->db->where('ORDER_ID', $orderId);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            foreach ($query->result() as $row) {
                $items[] = $row;
            }
        }
        return $items;
    }
}
