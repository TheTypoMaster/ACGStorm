<?php

class Cart {

    private $config;
    private $db;
    private $data = array();
    private $data_recurring = array();

    public function __construct($registry) {
        $this->config = $registry->get('config');
        $this->customer = $registry->get('customer');
        $this->session = $registry->get('session');
        $this->db = $registry->get('db');
        $this->tax = $registry->get('tax');
        $this->weight = $registry->get('weight');

        if (!isset($this->session->data['cart']) || !is_array($this->session->data['cart'])) {
            $this->session->data['cart'] = array();
        }
    }

    public function getProductCart($product_id) {
        $cart_info = $this->db->query("SELECT  * FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int) $product_id . "'")->row;
        if ($cart_info) {
            $data['productCart'] = array(
                'cart_id' => $product_id,
                'key' => $product_id,
                'product_id' => $cart_info['num_iid'],
                'name' => $cart_info['product_name'],
                'model' => '淘宝',
                'shipping' => '1',
                'image' => $cart_info['imgurl'],
                'special' => NULL,
                'color' => $cart_info['color'],
                'size' => $cart_info['size'],
                'note' => $cart_info['note'],
                'storename' => $cart_info['store_name'],
                'storeurl' => $cart_info['store_url'],
                'yunfei' => $cart_info['freight'],
                // 'location' => "http://item.taobao.com/item.htm?id=" . $cart_info['num_iid'],
                'location' => $cart_info['product_url'],
                'source' => 0,
                'option' => array(),
                'download' => array(),
                'quantity' => $cart_info['quantity'],
                'minimum' => '1',
                'subtract' => '1',
                'stock' => true,
                'price' => $cart_info['price'],
                'total' => $cart_info['price'] * $cart_info['quantity'],
                'reward' => 0,
                'points' => 0,
                'tax_class_id' => '0',
                'weight' => (float) 0,
                'weight_class_id' => 1,
                'length' => '0',
                'width' => '0',
                'height' => '0',
                'length_class_id' => 1,
                'profile_id' => 0,
                'profile_name' => '0',
                'recurring' => false,
                'recurring_frequency' => 0,
                'recurring_price' => 0,
                'recurring_cycle' => 0,
                'recurring_duration' => 0,
                'recurring_trial' => 0,
                'recurring_trial_frequency' => 0,
                'recurring_trial_price' => 0,
                'recurring_trial_cycle' => 0,
                'recurring_trial_duration' => 0,
            );
        } else {
            $data['productCart'] = array();
        }
        return $data['productCart'];
    }

    //获取购物车产品，cookie不存在时,从数据库oc_customer 表 cart 字段取;存在时，直接读取cookie;
    public function getProducts() {
    	
        if (!$this->data) {
            // if (!isset($_COOKIE['cart_id'])) {
            if (true) {
                krsort($this->session->data['cart']);
     
                foreach ($this->session->data['cart'] as $key => $quantity) {
                    $product = explode(':', $key);
                    $product_id = $product[0];

                    if (!empty($product[3])) {
                        $note = $product[3];
                    } else {
                        $note = '';
                    }
                    if (!empty($product[4])) {
                        $sfreight = $product[4];
                    } else {
                        $sfreight = '';
                    }
                    if (!empty($product[5])) {
                        $sprice = $product[5];
                    } else {
                        $sprice = '';
                    }
          
                    if (strlen($product_id) < 8) {
                        $stock = true;
                        // Options
                        if (!empty($product[1])) {
                            $options = ($product[1]);
                            $search_color = str_replace("_", ":", $options);
                        } else {
                            $options = array();
                            $search_color = '';
                        }

                        // Profile
                        if (!empty($product[2])) {
                            $profile_id = $product[2];
                            $profile_id = ($profile_id);
                            $search_size = str_replace("_", ":", $profile_id);
                        } else {
                            $profile_id = 0;
                            $search_size = '';
                        }

                        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

                        if ($product_query->num_rows) {
                            $option_price = 0;
                            $option_points = 0;
                            $option_weight = 0;

                            $option_data = array();


                            if ($this->customer->isLogged()) {
                                $customer_group_id = $this->customer->getCustomerGroupId();
                            } else {
                                $customer_group_id = $this->config->get('config_customer_group_id');
                            }

                            $price = $product_query->row['price'];

                            // Product Discounts
                            $discount_quantity = 0;

                            foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
                                $product_2 = explode(':', $key_2);

                                if ($product_2[0] == $product_id) {
                                    $discount_quantity += $quantity_2;
                                }
                            }

                            $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND quantity <= '" . (int) $discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

                            if ($product_discount_query->num_rows) {
                                $price = $product_discount_query->row['price'];
                            }

                            // Product Specials
                            $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

                            if ($product_special_query->num_rows) {
                                $price = $product_special_query->row['price'];
                            }

                            // Reward Points
                            $product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "'");

                            if ($product_reward_query->num_rows) {
                                $reward = $product_reward_query->row['points'];
                            } else {
                                $reward = 0;
                            }

                            // Downloads		
                            $download_data = array();

                            $download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int) $product_id . "' AND dd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                            foreach ($download_query->rows as $download) {
                                $download_data[] = array(
                                    'download_id' => $download['download_id'],
                                    'name' => $download['name'],
                                    'filename' => $download['filename'],
                                    'mask' => $download['mask'],
                                    'remaining' => $download['remaining']
                                );
                            }

                            // Stock
                            if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
                                $stock = false;
                            }

                            $recurring = false;
                            $recurring_frequency = 0;
                            $recurring_price = 0;
                            $recurring_cycle = 0;
                            $recurring_duration = 0;
                            $recurring_trial_status = 0;
                            $recurring_trial_price = 0;
                            $recurring_trial_cycle = 0;
                            $recurring_trial_duration = 0;
                            $recurring_trial_frequency = 0;
                            $profile_name = '';

                            if ($profile_id) {
                                $profile_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int) $product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`profile_id` = `p`.`profile_id` AND `pd`.`language_id` = " . (int) $this->config->get('config_language_id') . " WHERE `pp`.`profile_id` = " . (int) $profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int) $customer_group_id)->row;

                                if ($profile_info) {
                                    $profile_name = $profile_info['name'];

                                    $recurring = true;
                                    $recurring_frequency = $profile_info['frequency'];
                                    $recurring_price = $profile_info['price'];
                                    $recurring_cycle = $profile_info['cycle'];
                                    $recurring_duration = $profile_info['duration'];
                                    $recurring_trial_frequency = $profile_info['trial_frequency'];
                                    $recurring_trial_status = $profile_info['trial_status'];
                                    $recurring_trial_price = $profile_info['trial_price'];
                                    $recurring_trial_cycle = $profile_info['trial_cycle'];
                                    $recurring_trial_duration = $profile_info['trial_duration'];
                                }
                            }

                            $this->data[$key] = array(
                                "order_status_buy"=>4,//订单类别1是代购，2是自助购，3是代寄订单，4是商城，5是cosplay商城
                                'cart_session_id' => $product_id,
                                'key' => $key,
                                'product_id' => $product_query->row['product_id'],
                                'name' => $product_query->row['name'],
                                'model' => $product_query->row['model'],
                                "from"=>"mall",//来源商城mall
                                'storename' => $product_query->row['mpn'],
                                //'storename' => "CNstorm商城",//店铺名称和storurl同步 guanzhiqiang 20150626
                                'storeurl' => $product_query->row['mpnurl'],
                                // 'storeurl' =>HTTP_SERVER. "product-mall.html",//店铺地址 同步 guanzhiqiang 20150626
                                'yunfei' => $product_query->row['isbn'],
                                'shipping' => $product_query->row['shipping'],
                                'image' => $product_query->row['image'],
                                'location' => $product_query->row['location'],
                               // 'location' => HTTP_SERVER."$product_id.html",//商品地址 guanzhiqiang 20150626
                                'source' => 1,
                                'color' => $search_color,
                                'size' => $search_size,
                                'note' => $note,
                                'option' => $option_data,
                                'download' => $download_data,
                                'quantity' => $quantity,
                                'minimum' => $product_query->row['minimum'],
                                'subtract' => $product_query->row['subtract'],
                                'stock' => $stock,
                                'price' => ($price + $option_price),
                                'total' => ($price + $option_price) * $quantity,
                                'reward' => $reward * $quantity,
                                'points' => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
                                'tax_class_id' => $product_query->row['tax_class_id'],
                                'weight' => ($product_query->row['weight'] + $option_weight) * $quantity,
                                'weight_class_id' => $product_query->row['weight_class_id'],
                                'length' => $product_query->row['length'],
                                'width' => $product_query->row['width'],
                                'height' => $product_query->row['height'],
                                'length_class_id' => $product_query->row['length_class_id'],
                                'profile_id' => $profile_id,
                                'profile_name' => $profile_name,
                                'recurring' => $recurring,
                                'recurring_frequency' => $recurring_frequency,
                                'recurring_price' => $recurring_price,
                                'recurring_cycle' => $recurring_cycle,
                                'recurring_duration' => $recurring_duration,
                                'recurring_trial' => $recurring_trial_status,
                                'recurring_trial_frequency' => $recurring_trial_frequency,
                                'recurring_trial_price' => $recurring_trial_price,
                                'recurring_trial_cycle' => $recurring_trial_cycle,
                                'recurring_trial_duration' => $recurring_trial_duration,
                            );
                        }
                    } elseif (strstr($product_id, 'cosplay')) {

                        $product_id = explode('_', $product_id);

                        $product_id = $product_id[1];

                        // Options
                        if (!empty($product[1])) {
                            $options = ($product[1]);
                            $search_color = str_replace("_", ":", $options);
                        } else {
                            $options = array();
                            $search_color = '';
                        }

                        // Profile
                        if (!empty($product[2])) {
                            $profile_id = $product[2];
                            $profile_id = ($profile_id);
                            $search_size = str_replace("_", ":", $profile_id);
                        } else {
                            $profile_id = 0;
                            $search_size = '';
                        }

                        $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cosplay_product p LEFT JOIN " . DB_PREFIX . "cosplay_product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

                        if ($product_query->num_rows) {
                            $option_price = 0;
                            $option_points = 0;
                            $option_weight = 0;

                            $option_data = array();


                            if ($this->customer->isLogged()) {
                                $customer_group_id = $this->customer->getCustomerGroupId();
                            } else {
                                $customer_group_id = $this->config->get('config_customer_group_id');
                            }

                      $price_szie= $product_query->row['price_szie'];
						$price='';
					
                         if(isset($price_szie) && !empty($price_szie)){
                            $price_szie=unserialize($product_query->row['price_szie']);
                        
	                        if(is_array($price_szie)){
		                            foreach($price_szie as $k=>$vl){
		                            		if(trim($k) == $search_size){
		                            			foreach( $vl as $j=>$val){
		                           
		                            				if($j == $search_color){
		                            				
		                            					$price = $val['price'];
		                            					break;
		                            				}
		                            			}
		                            		}
		                           	    }
	                                } else{
	                                	$price = $product_query->row['price'];
	                                }
	                            }else{
	                            	$price = $product_query->row['price'];
	                            }
	                   
	                     // $price = $product_query->row['price'];
	                  
                            // Product Discounts
                            $discount_quantity = 0;

                            foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
                                $product_2 = explode(':', $key_2);

                                if ($product_2[0] == $product_id) {
                                    $discount_quantity += $quantity_2;
                                }
                            }

                            $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "cosplay_product_discount WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND quantity <= '" . (int) $discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

                            if ($product_discount_query->num_rows) {
                                $price = $product_discount_query->row['price'];
                            }

                            // Product Specials
                            $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "cosplay_product_special WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

                            if ($product_special_query->num_rows) {
                                $price = $product_special_query->row['price'];
                            }


                            $this->data[$key] = array(
                                "order_status_buy"=>5,//订单类别1是代购，2是自助购，3是代寄订单，4是商城，5是cosplay商城
                                'cart_session_id' => 'cosplay_' . $product_id,
                                'key' => $key,
                                'product_id' => $product_query->row['product_id'],
                                'name' => $product_query->row['name'],
                                'model' => $product_query->row['model'],
                                'storename' => $product_query->row['mpn'],
                                'storeurl' => $product_query->row['mpnurl'],
                                'yunfei' => $product_query->row['isbn'],
                                'shipping' => $product_query->row['shipping'],
                                'image' => $product_query->row['image'],
                                'location' => $product_query->row['location'],
                                'source' => 1,
                                'color' => $search_color,
                                'size' => $search_size,
                                'note' => $note,
                                'option' => $option_data,
                                'download' => array(),
                                'quantity' => $quantity,
                                'minimum' => '1',
                                'subtract' => '1',
                                'stock' => true,
                                'price' => ($price + $option_price),
                                'total' => ($price + $option_price) * $quantity,
                                'reward' => 0,
                                'points' => 0,
                                'tax_class_id' => '0',
                                'weight' => (float) 0.00,
                                'weight_class_id' => 1,
                                'length' => 0,
                                'width' => 0,
                                'height' => 0,
                                'length_class_id' => 1,
                                'profile_id' => 0,
                                'profile_name' => '0',
                                'recurring' => false,
                                'recurring_frequency' => 0,
                                'recurring_price' => 0,
                                'recurring_cycle' => 0,
                                'recurring_duration' => 0,
                                'recurring_trial' => 0,
                                'recurring_trial_frequency' => 0,
                                'recurring_trial_price' => 0,
                                'recurring_trial_cycle' => 0,
                                'recurring_trial_duration' => 0,
                            );
                           
                        }
                         
                    } elseif (strstr($product_id, 'snatch')) {

                        $product_id = explode('_', $product_id);
                        $id = $product_id[1];

                        $cart_info = $this->db->query("SELECT  * FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int) $id . "'")->row;

                        if ($cart_info) {

                            $this->data[$key] = array(
                                "order_status_buy"=>1,//订单类别1是代购，2是自助购，3是代寄订单，4是商城，5是cosplay商城
                                'cart_session_id' => 'snatch_' . $id,
                                'cart_id' => $id,
                                'key' => $key,
                                'product_id' => $cart_info['num_iid'],
                                'name' => $cart_info['product_name'],
                                'model' => '淘宝',
                                'shipping' => '1',
                                'image' => $cart_info['imgurl'],
                                'color' => $cart_info['color'],
                                'size' => $cart_info['size'],
                                'note' => $cart_info['note'],
                                'storename' => $cart_info['store_name'],
                                'storeurl' => $cart_info['store_url'],
                                'yunfei' => $cart_info['freight'],
                                'location' => $cart_info['product_url'],
                                'source' => 0,
                                'option' => array(),
                                'download' => array(),
                                'quantity' => $cart_info['quantity'],
                                'minimum' => '1',
                                'subtract' => '1',
                                'stock' => true,
                                'price' => $cart_info['price'],
                                'total' => $cart_info['price'] * $cart_info['quantity'],
                                'reward' => 0,
                                'points' => 0,
                                'tax_class_id' => '0',
                                'weight' => (float) 0,
                                'weight_class_id' => 1,
                                'length' => '0',
                                'width' => '0',
                                'height' => '0',
                                'length_class_id' => 1,
                                'profile_id' => 0,
                                'profile_name' => '0',
                                'recurring' => false,
                                'recurring_frequency' => 0,
                                'recurring_price' => 0,
                                'recurring_cycle' => 0,
                                'recurring_duration' => 0,
                                'recurring_trial' => 0,
                                'recurring_trial_frequency' => 0,
                                'recurring_trial_price' => 0,
                                'recurring_trial_cycle' => 0,
                                'recurring_trial_duration' => 0,
                            );
                        } else {
                            $this->remove($key);
                        }
                    } else {
                        $this->remove($key);
                    }
                }  //foreach的标签
            } else {
//cookie存在时,读取cookie里
                if (!empty($_COOKIE['cart_id'])) {

                    $cart_id_array = explode(',', $_COOKIE['cart_id']);

                    foreach ($cart_id_array as $cart_id) {

                        $cart_info = $this->db->query("SELECT  * FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int) $cart_id . "'")->row;

                        $key = 'snatch_' . $cart_id;

                        if ($cart_info) {

                            $this->data[$key] = array(
                                'cart_session_id' => 'snatch_' . $cart_id,
                                'cart_id' => $cart_id,
                                'key' => $key,
                                'product_id' => $cart_info['num_iid'],
                                'name' => $cart_info['product_name'],
                                'model' => '淘宝',
                                'shipping' => '1',
                                'image' => $cart_info['imgurl'],
                                'color' => $cart_info['color'],
                                'size' => $cart_info['size'],
                                'note' => $cart_info['note'],
                                'storename' => $cart_info['store_name'],
                                'storeurl' => $cart_info['store_url'],
                                'yunfei' => $cart_info['freight'],
                                'location' => $cart_info['product_url'],
                                'source' => 0,
                                'option' => array(),
                                'download' => array(),
                                'quantity' => $cart_info['quantity'],
                                'minimum' => '1',
                                'subtract' => '1',
                                'stock' => true,
                                'price' => $cart_info['price'],
                                'total' => $cart_info['price'] * $cart_info['quantity'],
                                'reward' => 0,
                                'points' => 0,
                                'tax_class_id' => '0',
                                'weight' => (float) 0,
                                'weight_class_id' => 1,
                                'length' => '0',
                                'width' => '0',
                                'height' => '0',
                                'length_class_id' => 1,
                                'profile_id' => 0,
                                'profile_name' => '0',
                                'recurring' => false,
                                'recurring_frequency' => 0,
                                'recurring_price' => 0,
                                'recurring_cycle' => 0,
                                'recurring_duration' => 0,
                                'recurring_trial' => 0,
                                'recurring_trial_frequency' => 0,
                                'recurring_trial_price' => 0,
                                'recurring_trial_cycle' => 0,
                                'recurring_trial_duration' => 0,
                            );
                        }
                    }
                }
            }
        }
       
        return $this->data;
    }

    public function getProductsMobile() {
        //var_dump($this->session->data['cart']);

        if (!$this->data) {

            foreach ($this->session->data['cart'] as $key => $quantity) {
                file_put_contents("../logs/4.log", var_export($this->session->data['cart'], TRUE) . "\r\n", FILE_APPEND);
                $product = explode(':', $key);

                $product_id = $product[0];

                if (!empty($product[3])) {
                    $note = $product[3];
                } else {
                    $note = '';
                }
                if (!empty($product[4])) {
                    $sfreight = $product[4];
                } else {
                    $sfreight = '';
                }
                if (!empty($product[5])) {
                    $sprice = $product[5];
                } else {
                    $sprice = '';
                }
                if (strlen($product_id) < 8) {
                    $stock = true;

                    //var_dump($product[1]);
                    // Options
                    if (!empty($product[1])) {
                        $options = ($product[1]);
                        $search_color = str_replace("_", ":", $options);
                    } else {
                        $options = array();
                        $search_color = '';
                    }

                    //var_dump($search_color);
                    //var_dump($product[2]);
                    // Profile
                    if (!empty($product[2])) {
                        $profile_id = $product[2];
                        $profile_id = ($profile_id);
                        $search_size = str_replace("_", ":", $profile_id);
                    } else {
                        $profile_id = 0;
                        $search_size = '';
                    }

                    $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int) $product_id . "' AND pd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

                    if ($product_query->num_rows) {
                        $option_price = 0;
                        $option_points = 0;
                        $option_weight = 0;

                        $option_data = array();


                        if ($this->customer->isLogged()) {
                            $customer_group_id = $this->customer->getCustomerGroupId();
                        } else {
                            $customer_group_id = $this->config->get('config_customer_group_id');
                        }

                        $price = $product_query->row['price'];

                        // Product Discounts
                        $discount_quantity = 0;

                        foreach ($this->session->data['cart'] as $key_2 => $quantity_2) {
                            $product_2 = explode(':', $key_2);

                            if ($product_2[0] == $product_id) {
                                $discount_quantity += $quantity_2;
                            }
                        }

                        $product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND quantity <= '" . (int) $discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

                        if ($product_discount_query->num_rows) {
                            $price = $product_discount_query->row['price'];
                        }

                        // Product Specials
                        $product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

                        if ($product_special_query->num_rows) {
                            $price = $product_special_query->row['price'];
                        }

                        // Reward Points
                        $product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int) $product_id . "' AND customer_group_id = '" . (int) $customer_group_id . "'");

                        if ($product_reward_query->num_rows) {
                            $reward = $product_reward_query->row['points'];
                        } else {
                            $reward = 0;
                        }

                        // Downloads		
                        $download_data = array();

                        $download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int) $product_id . "' AND dd.language_id = '" . (int) $this->config->get('config_language_id') . "'");

                        foreach ($download_query->rows as $download) {
                            $download_data[] = array(
                                'download_id' => $download['download_id'],
                                'name' => $download['name'],
                                'filename' => $download['filename'],
                                'mask' => $download['mask'],
                                'remaining' => $download['remaining']
                            );
                        }

                        // Stock
                        if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $quantity)) {
                            $stock = false;
                        }

                        $recurring = false;
                        $recurring_frequency = 0;
                        $recurring_price = 0;
                        $recurring_cycle = 0;
                        $recurring_duration = 0;
                        $recurring_trial_status = 0;
                        $recurring_trial_price = 0;
                        $recurring_trial_cycle = 0;
                        $recurring_trial_duration = 0;
                        $recurring_trial_frequency = 0;
                        $profile_name = '';

                        if ($profile_id) {
                            $profile_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int) $product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`profile_id` = `p`.`profile_id` AND `pd`.`language_id` = " . (int) $this->config->get('config_language_id') . " WHERE `pp`.`profile_id` = " . (int) $profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int) $customer_group_id)->row;

                            if ($profile_info) {
                                $profile_name = $profile_info['name'];

                                $recurring = true;
                                $recurring_frequency = $profile_info['frequency'];
                                $recurring_price = $profile_info['price'];
                                $recurring_cycle = $profile_info['cycle'];
                                $recurring_duration = $profile_info['duration'];
                                $recurring_trial_frequency = $profile_info['trial_frequency'];
                                $recurring_trial_status = $profile_info['trial_status'];
                                $recurring_trial_price = $profile_info['trial_price'];
                                $recurring_trial_cycle = $profile_info['trial_cycle'];
                                $recurring_trial_duration = $profile_info['trial_duration'];
                            }
                        }

                        $this->data[$key] = array(
                            'cart_session_id' => $product_id,
                            'key' => $key,
                            'product_id' => $product_query->row['product_id'],
                            'name' => $product_query->row['name'],
                            'model' => $product_query->row['model'],
                            'storename' => $product_query->row['mpn'],
                            'storeurl' => $product_query->row['mpnurl'],
                            'yunfei' => $product_query->row['isbn'],
                            'shipping' => $product_query->row['shipping'],
                            'image' => $product_query->row['image'],
                            'location' => $product_query->row['location'],
                            'source' => 1,
                            'color' => $search_color,
                            'size' => $search_size,
                            'note' => $note,
                            'option' => $option_data,
                            'download' => $download_data,
                            'quantity' => $quantity,
                            'minimum' => $product_query->row['minimum'],
                            'subtract' => $product_query->row['subtract'],
                            'stock' => $stock,
                            'price' => ($price + $option_price),
                            'total' => ($price + $option_price) * $quantity,
                            'reward' => $reward * $quantity,
                            'points' => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
                            'tax_class_id' => $product_query->row['tax_class_id'],
                            'weight' => ($product_query->row['weight'] + $option_weight) * $quantity,
                            'weight_class_id' => $product_query->row['weight_class_id'],
                            'length' => $product_query->row['length'],
                            'width' => $product_query->row['width'],
                            'height' => $product_query->row['height'],
                            'length_class_id' => $product_query->row['length_class_id'],
                            'profile_id' => $profile_id,
                            'profile_name' => $profile_name,
                            'recurring' => $recurring,
                            'recurring_frequency' => $recurring_frequency,
                            'recurring_price' => $recurring_price,
                            'recurring_cycle' => $recurring_cycle,
                            'recurring_duration' => $recurring_duration,
                            'recurring_trial' => $recurring_trial_status,
                            'recurring_trial_frequency' => $recurring_trial_frequency,
                            'recurring_trial_price' => $recurring_trial_price,
                            'recurring_trial_cycle' => $recurring_trial_cycle,
                            'recurring_trial_duration' => $recurring_trial_duration,
                        );
                    }
                } elseif (strstr($product_id, 'snatch')) {

                    $product_id = explode('_', $product_id);
                    $id = $product_id[1];

                    $cart_info = $this->db->query("SELECT  * FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int) $id . "'")->row;

                    if ($cart_info) {

                        $this->data[$key] = array(
                            'cart_id' => $id,
                            'key' => $key,
                            'product_id' => $cart_info['num_iid'],
                            'name' => $cart_info['product_name'],
                            'model' => '淘宝',
                            'shipping' => '1',
                            'image' => $cart_info['imgurl'],
                            'color' => $cart_info['color'],
                            'size' => $cart_info['size'],
                            'note' => $cart_info['note'],
                            'storename' => $cart_info['store_name'],
                            'storeurl' => $cart_info['store_url'],
                            'yunfei' => $cart_info['freight'],
                            'location' => $cart_info['product_url'],
                            'source' => 0,
                            'option' => array(),
                            'download' => array(),
                            'quantity' => $cart_info['quantity'],
                            'minimum' => '1',
                            'subtract' => '1',
                            'stock' => true,
                            'price' => $cart_info['price'],
                            'total' => $cart_info['price'] * $cart_info['quantity'],
                            'reward' => 0,
                            'points' => 0,
                            'tax_class_id' => '0',
                            'weight' => (float) 0,
                            'weight_class_id' => 1,
                            'length' => '0',
                            'width' => '0',
                            'height' => '0',
                            'length_class_id' => 1,
                            'profile_id' => 0,
                            'profile_name' => '0',
                            'recurring' => false,
                            'recurring_frequency' => 0,
                            'recurring_price' => 0,
                            'recurring_cycle' => 0,
                            'recurring_duration' => 0,
                            'recurring_trial' => 0,
                            'recurring_trial_frequency' => 0,
                            'recurring_trial_price' => 0,
                            'recurring_trial_cycle' => 0,
                            'recurring_trial_duration' => 0,
                        );
                    } else {
                        $this->remove($key);
                    }
                } else {
                    $this->remove($key);
                }
            }  //foreach的标签
        }

        return $this->data;
    }

    public function getRecurringProducts() {
        $recurring_products = array();

        foreach ($this->getProducts() as $key => $value) {
            if ($value['recurring']) {
                $recurring_products[$key] = $value;
            }
        }

        return $recurring_products;
    }
//下单不了 guanzhiqiang 20150626
    public function add($product_id, $qty = 1, $option, $profile_id = '', $note = '') {
        //$key = (int) $product_id . ':';
        $key = $product_id . ':';

        if ($option) {
            $key .= (trim($option)) . ':';
        } else {
            $key .= ':';
        }

        if ($profile_id) {
            $key .= trim($profile_id) . ':';
        } else {
            $key .= ':';
        }

        if ($note) {
            $key .= trim($note);
        }

        if ((int) $qty && ((int) $qty > 0)) {
            if (!isset($this->session->data['cart'][$key])) {
                $this->session->data['cart'][$key] = (int) $qty;
            } else {
                $this->session->data['cart'][$key] += (int) $qty;
            }
        }


        $this->data = array();
    }

    /**     * ****************************************************************************************************
     * @funtion：定义函数addsearch()用于将在搜索框中输入天猫或者淘宝的商品Url地址来查看商品详情，添加进购物车

     * @param：   string $product_id  参数为该单件商品的数字id

     * @param:    string $quantity 参数为将该单价商品放入购物车的数量

     * @param:    string $option 参数为将该单价商品选择的颜色

     * @param:    string $profile_id 参数为将该单价商品选择的尺寸

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.22
     * ********************************************************************************************************* */
    public function addsearch($product_id, $qty = 1, $option, $profile_id = '', $note = '', $sfreight, $sprice) {

        $key = $product_id . ':';

        if ((int) $qty && ((int) $qty > 0)) {
            if (!isset($this->session->data['cart'][$key])) {
                $this->session->data['cart'][$key] = (int) $qty;
            } else {
                $this->session->data['cart'][$key] += (int) $qty;
            }
        }


        $this->data = array();
    }

//修改购物车购买商品数量
    public function update($key, $qty) {
        if ((int) $qty && ((int) $qty > 0)) {
            $this->session->data['cart'][$key] = (int) $qty;
        } else {
            $this->remove($key);
        }

        $this->data = array();
    }

//修改购物车商品备注信息
    public function updateRemark($key, $remark) {
        if (isset($remark)) {
            $value = $this->session->data['cart'][$key];
            $this->remove($key);
            $count = substr_count($key, ':');
            if ($count == 0)
                $remark = $key . ':::' . $remark;
            elseif ($count == 1)
                $remark = utf8_substr($key, 0, utf8_strrpos($key, ':') + 1) . '::' . $remark;
            elseif ($count == 2)
                $remark = utf8_substr($key, 0, utf8_strrpos($key, ':') + 1) . ':' . $remark;
            else
                $remark = utf8_substr($key, 0, utf8_strrpos($key, ':') + 1) . $remark;
            $this->session->data['cart'][$remark] = (int) $value;
        }

        $this->data = array();
    }

    /** key的值传值有时缺少冒号:guanzhiqiang 20150525 */
    public function remove($key) {
        if (strpos($key, ":") === false) {
            $key.=":";
        }
        if (isset($this->session->data['cart'][$key])) {
            unset($this->session->data['cart'][$key]);
        }

        $this->data = array();
    }

    //退出时，清空cart,导致退出登录时购物车里的东西不见啦 guanzhiqiang 20150525   就是要不见 guanzhiqiang 20150727 
    public function clear() {
        $this->session->data['cart'] = array();
        $this->data = array();
    }

    public function getWeight() {
        $weight = 0;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
            }
        }

        return $weight;
    }

    public function getSubTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $product['total'];
        }

        return $total;
    }

    public function getTaxes() {
        $tax_data = array();

        foreach ($this->getProducts() as $product) {
            if ($product['tax_class_id']) {
                $tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

                foreach ($tax_rates as $tax_rate) {
                    if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
                        $tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
                    } else {
                        $tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
                    }
                }
            }
        }

        return $tax_data;
    }

    public function getTotal() {
        $total = 0;

        foreach ($this->getProducts() as $product) {
            $total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
        }

        return $total;
    }

    public function countProducts() {
        $product_total = 0;

        $products = $this->getProducts();

        foreach ($products as $product) {
            $product_total = count($products);
        }

        return $product_total;
    }

    public function hasProducts() {
        return count($this->session->data['cart']);
    }

    public function hasRecurringProducts() {
        return count($this->getRecurringProducts());
    }

    public function hasStock() {
        $stock = true;

        foreach ($this->getProducts() as $product) {
            if (!$product['stock']) {
                $stock = false;
            }
        }

        return $stock;
    }

    public function hasShipping() {
        $shipping = false;

        foreach ($this->getProducts() as $product) {
            if ($product['shipping']) {
                $shipping = true;

                break;
            }
        }

        return $shipping;
    }

    public function hasDownload() {
        $download = false;

        foreach ($this->getProducts() as $product) {
            if ($product['download']) {
                $download = true;

                break;
            }
        }

        return $download;
    }

}

?>