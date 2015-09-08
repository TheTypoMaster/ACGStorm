<?php

class Customer {

    private $customer_id;
    private $firstname;
    private $lastname;
    private $email;
    private $telephone;
    private $money;
    private $score;
    private $newsletter;
    private $customer_group_id;
    private $address_id;
    private $utype;
    private $growth;
    private $face;
    private $verification;
    private $isbusiness;

    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->db = $registry->get('db');
        $this->request = $registry->get('request');
        $this->session = $registry->get('session');

        if (isset($this->session->data['customer_id'])) {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $this->session->data['customer_id'] . "' AND status = '1'");

            if ($customer_query->num_rows) {
                $this->customer_id = $customer_query->row['customer_id'];
                $this->firstname = $customer_query->row['firstname'];
                $this->lastname = $customer_query->row['lastname'];
                $this->email = $customer_query->row['email'];
                $this->telephone = $customer_query->row['telephone'];
                $this->money = $customer_query->row['money'];
                $this->score = $customer_query->row['scores'];
                $this->newsletter = $customer_query->row['newsletter'];
                $this->customer_group_id = $customer_query->row['customer_group_id'];
                $this->address_id = $customer_query->row['address_id'];
                $this->verification = $customer_query->row['verification'];
                $this->utype = $customer_query->row['utype'];
                $this->growth = $customer_query->row['growth'];
                $this->face = $customer_query->row['face'];
                $this->isbusiness = $customer_query->row['business'];
			
                $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int) $this->customer_id . "'");
			
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int) $this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

                if (!$query->num_rows) {
                    $this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int) $this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
                }
            } else {
                $this->logout();
            }
        }
    }

    public function login($email, $password, $override = false) {
       
        if ($override) {
           
            //$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer where LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer where LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
        } else {
       	    
            //$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1' OR LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
        }

        //var_dump("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
        //var_dump($customer_query);


        if ($customer_query->num_rows) {
            
            $this->session->data['customer_id'] = $customer_query->row['customer_id'];

            if ($customer_query->row['cart'] && is_string($customer_query->row['cart'])) {
                $cart = unserialize($customer_query->row['cart']);

                foreach ($cart as $key => $value) {
                    if (!array_key_exists($key, $this->session->data['cart'])) {
                        $this->session->data['cart'][$key] = $value;
                    } else {
                        $this->session->data['cart'][$key] += $value;
                    }
                }
            }

            if ($customer_query->row['wishlist'] && is_string($customer_query->row['wishlist'])) {
                if (!isset($this->session->data['wishlist'])) {
                    $this->session->data['wishlist'] = array();
                }

                $wishlist = unserialize($customer_query->row['wishlist']);

                foreach ($wishlist as $product_id) {
                    if (!in_array($product_id, $this->session->data['wishlist'])) {
                        $this->session->data['wishlist'][] = $product_id;
                    }
                }
            }
            
            if(isset($_COOKIE['cart_id'])) {
                
                if(!empty($_COOKIE['cart_id'])){
                    
                    $cart_id_str = $_COOKIE['cart_id'];
                    
                    $cart_id_array = explode(',',$cart_id_str);
                   
						foreach($cart_id_array as $cart_id) {
							
							$this->db->query("UPDATE " . DB_PREFIX . "cart SET customer_id = " . $customer_query->row['customer_id'] . ", firstname = '" . $customer_query->row['firstname'] . "' WHERE cart_id = " . $cart_id);
						}
                   
                   setcookie('cart_id',''); 
                }
                
                setcookie('cart_id',''); 
            }

            $this->customer_id = $customer_query->row['customer_id'];
            $this->firstname = $customer_query->row['firstname'];
            $this->lastname = $customer_query->row['lastname'];
            $this->email = $customer_query->row['email'];
            $this->telephone = $customer_query->row['telephone'];
            $this->money = $customer_query->row['money'];
            $this->score = $customer_query->row['scores'];
            $this->newsletter = $customer_query->row['newsletter'];
            $this->customer_group_id = $customer_query->row['customer_group_id'];
            $this->address_id = $customer_query->row['address_id'];
            $this->utype = $customer_query->row['utype'];
            $this->growth = $customer_query->row['growth'];
            $this->face = $customer_query->row['face'];
            $this->verification = $customer_query->row['verification'];
            $this->isbusiness = $customer_query->row['business'];

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int) $this->customer_id . "'");

            return true;
        } else {
            return false;
        }
    }

    public function logout() {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') . "', wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '') . "' WHERE customer_id = '" . (int) $this->customer_id . "'");

        unset($this->session->data['customer_id']);

        $this->customer_id = '';
        $this->firstname = '';
        $this->lastname = '';
        $this->email = '';
        $this->telephone = '';
        $this->money = '';
        $this->score = '';
        $this->newsletter = '';
        $this->customer_group_id = '';
        $this->address_id = '';
        $this->utype = '';
        $this->growth = '';
        $this->face = '';
        $this->verification = '';
        $this->isbusiness = '';
    }

    public function isLogged() {
        return $this->customer_id;
    }

    public function getId() {
        return $this->customer_id;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function getMoney() {
        return $this->money;
    }
    
    public function getScore() {
        return $this->score;
    }

    public function getNewsletter() {
        return $this->newsletter;
    }
    
     //获取会员等级
    public function getUtype() {
    	return $this->utype;
    }
    //获取会员成长值
    public function getGrowth() {
    	return $this->growth;
    }
    
    public function getFace() {
    	return $this->face;
    }
    
 
    public function getVerify() {
        return $this->verification;
    }

    public function getBusinessVerify() {
        
            return $this->isbusiness;
        
    }

    public function getCustomerGroupId() {
        return $this->customer_group_id;
    }

    public function getAddressId() {
        return $this->address_id;
    }

    public function getBalance() {
        $query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int) $this->customer_id . "'");

        return $query->row['total'];
    }

    public function getRewardPoints() {
        $query = $this->db->query("SELECT SUM(score) AS total FROM " . DB_PREFIX . "scorerecord WHERE uid = '" . (int) $this->customer_id . "'");

        return $query->row['total'];
    }

}

?>