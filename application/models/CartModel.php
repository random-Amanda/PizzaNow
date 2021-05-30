<?php

class CartModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
    }

    public function completeOrder()
    {

        $return           = array();
        if ($this->session->custId) {
            if (!empty($this->session->order)) {
                $order = $this->session->order;
                if (!$this->session->orderId) {
                    $oderId = $this->createOrder($this->session->custId);
                    if (is_null($oderId)) {
                        $message = "Could not create new Order";
                        $return['error'] = $message;
                        return $return;
                    } else {
                        $this->session->orderId = $oderId;
                    }
                }
                foreach ($order as $item) {
                    $orderItemId = $this->addOrderItem($item);
                    if (is_null($orderItemId)) {
                        $message = "Could not create new Order Item.";
                        $return['error'] = $message;
                        log_message('error',  $message . $this->session->orderId);
                        return $return;
                    } else {
                        if (isset($item['TOPPING_ID'])) {
                            if (is_null($this->createPizzaToppingMapping($orderItemId, $item))) {
                                $message = "Could not create PIZZA TOPPING mapping.";
                                log_message('error', $message);
                                $return['error'] = $message;
                                return $return;
                            }
                        }
                    }
                }
                $this->updateTimeandTotal($this->session->orderId);
                $return['orderId'] = $this->session->orderId;
                $this->session->set_userdata('orderId', null);
                $this->session->set_userdata('order', null);
            } else {
                $return['error'] = "No items in cart";
            }
        } else {
            $return['error'] = "User not Logged in";
        }
        return $return;
    }

    private function createOrder()
    {
        $order           = array(
            'CUST_ID' => $this->session->custId
        );
        $this->db->trans_begin();
        $this->db->insert('CUST_ORDER', $order);
        $orderId = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            log_message('error', "DB ERROR: " . print_r($this->db->error(), TRUE));
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            log_message('debug', "Created new Order with ORDER_ID: " . $orderId);
        }
        return $orderId;
    }

    private function addOrderItem($data)
    {
        if (isset($data['PROD_DETAIL_ID'])) {
            $orderItem           = array(
                'ORDER_ID' => $this->session->orderId,
                'QTY' => $data['QTY'],
                'PROD_DETAIL_ID' => $data['PROD_DETAIL_ID']
            );
            $this->db->trans_begin();
            $this->db->insert('ORDER_ITEM', $orderItem);;
            $itemId = $this->db->insert_id();
            if ($this->db->trans_status() === FALSE) {
                log_message('error', "DB ERROR: " . print_r($this->db->error(), TRUE));
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                log_message('debug', "Created new Order Item with ORDER_ITEM_ID: " . $itemId);
            }
            return $itemId;
        } elseif (isset($data['DEAL_ID'])) {
            $orderItem           = array(
                'ORDER_ID' => $this->session->orderId,
                'QTY' => $data['QTY'],
                'DEAL_ID' => $data['DEAL_ID']
            );
            $this->db->trans_begin();
            $this->db->insert('ORDER_ITEM', $orderItem);
            $itemId = $this->db->insert_id();
            if ($this->db->trans_status() === FALSE) {
                log_message('error', "DB ERROR: " . print_r($this->db->error(), TRUE));
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                log_message('debug', "Created new Order Item with ORDER_ITEM_ID: " . $itemId);
            }
            return $itemId;
        } else {
            return null;
            log_message('error', "Could not create new Order Item for ORDER_ID " . $this->session->orderId .
                " : Either PROD_DETAIL_ID or DEAL_DETAIL_ID must be given.");
        }
    }

    private function updateTimeandTotal($orderId)
    {
        $this->db->trans_begin();
        $this->db->set('TIME', date("Y/m/d H:i:s", strtotime("now")));
        $this->db->where('ORDER_ID', $orderId);
        $this->db->update('CUST_ORDER');
        if ($this->db->trans_status() === FALSE) {
            log_message('error', "DB ERROR: " . print_r($this->db->error(), TRUE));
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    private function createPizzaToppingMapping($orderItemId, $data)
    {
        $mapping = array(
            'TOPPING_ID' => $data['TOPPING_ID'],
            'ORDER_ITEM_ID' => $orderItemId
        );
        $this->db->trans_begin();
        $this->db->insert('PIZZA_TOPPING_MAPPING', $mapping);
        $mappingId = $this->db->insert_id();
        if ($this->db->trans_status() === FALSE) {
            log_message('error', "DB ERROR: " . print_r($this->db->error(), TRUE));
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
        return $mappingId;
    }

    public function calculateItemPrice($data)
    {
        if (isset($data['TOPPING_PRICE'])) {
            return ($data['PRICE'] + $data['TOPPING_PRICE']) * $data['QTY'];
        } else {
            return ($data['PRICE'] * $data['QTY']);
        }
    }

    public function addToCart($data)
    {
        $order = $this->session->userdata('order');
        if (is_null($order)) {
            $this->session->set_userdata('order', array($data));
        } else {
            $order[] = $data;
            $this->session->set_userdata('order', $order);
        }

        $this->session->set_userdata('tempItem', null);
        log_message('debug', "Added 'tempItem' to session -> " . print_r($this->session->userdata(), TRUE));
        return array('success' => "Successfully added item to cart.");
    }

    public function removeFromCart($data)
    {
        $order = $this->session->userdata('order');
        unset($order[$data['index']]);
        $this->session->set_userdata('order', $order);
        log_message('debug', "Removed 'item' with index " . $data['index'] . " from session -> ");
    }
}
