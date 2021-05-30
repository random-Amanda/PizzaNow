<?php


class CustomerModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function getCustomerCredentials($username)
    {
        $this->db->select('CUST_ID,PASSWORD,NAME');
        $this->db->from('CUSTOMER');
        $this->db->where('USERNAME', $username);
        $query = $this->db->get();
        if ($query->num_rows() != 0) {
            return $query->row();
        } else {
            return null;
        }
    }

    public function insertUser($userObject)
    {
        $userObject['PASSWORD'] = password_hash($userObject['PASSWORD'], PASSWORD_DEFAULT);
        $this->db->insert('CUSTOMER', $userObject);
        $cust_id = $this->db->insert_id();
        if (!is_null($cust_id)) {
            return $this->getCustomerCredentials($userObject['USERNAME']);
        } else {
            return null;
        }
    }

    public function addUser($user)
    {
        $credentials = $this->getCustomerCredentials($user['USERNAME']);
        // check if user already exists.
        if (is_null($credentials)) {
            //insert user into database.
            $credentials = $this->insertUser($user);
            if (!is_null($credentials)) {
                return $credentials;
            } else {
                // return null if user creation was unsuccessful.
                return null;
            }
        } else {
            //return false if the user already exists.
            return false;
        }
    }

    public function authenticate($user)
    {
        $credentials = $this->CustomerModel->getCustomerCredentials($user['USERNAME']);
        if (is_null($credentials)) {
            return null;
        } else {
            if (!password_verify($user['PASSWORD'], $credentials->PASSWORD)) {
                return false;
            } else {
                $this->session->custId = $credentials->CUST_ID;
                $this->session->name = $credentials->NAME;
                return true;
            }
        }
    }
}
