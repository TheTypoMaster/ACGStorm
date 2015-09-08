<?php

Class ModelAppOrder extends Model {

    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT os.name FROM `" . DB_PREFIX . "order_status` os WHERE os.order_status_id = o.order_status_id AND os.language_id = o.language_id) AS order_status FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {

            return array(
                'order_id' => $order_query->row['order_id'],
                'invoice_no' => $order_query->row['invoice_no'],
                'invoice_prefix' => $order_query->row['invoice_prefix'],
                'store_id' => $order_query->row['store_id'],
                'store_name' => $order_query->row['store_name'],
                'store_url' => $order_query->row['store_url'],
                'customer_id' => $order_query->row['customer_id'],
                'firstname' => $order_query->row['firstname'],
                'lastname' => $order_query->row['lastname'],
                'telephone' => $order_query->row['telephone'],
                'fax' => $order_query->row['fax'],
                'email' => $order_query->row['email'],
                
                'total' => $order_query->row['total'],
                'order_status_id' => $order_query->row['order_status_id'],
                'order_status' => $order_query->row['order_status'],
                'order_status_buy' => $order_query->row['order_status_buy'],
                'language_id' => $order_query->row['language_id'],
                
                'currency_id' => $order_query->row['currency_id'],
                'currency_code' => $order_query->row['currency_code'],
                'currency_value' => $order_query->row['currency_value'],
                'ip' => $order_query->row['ip'],
                'forwarded_ip' => $order_query->row['forwarded_ip'],
                'user_agent' => $order_query->row['user_agent'],
                'accept_language' => $order_query->row['accept_language'],
                'date_modified' => $order_query->row['date_modified'],
                'date_added' => $order_query->row['date_added']
            );
        } else {
            return false;
        }
    }
    
	/**
	 * 更改订单状态
	 * @param  [type]  $order_id        [description]
	 * @param  [type]  $order_status_id [description]
	 * @param  [type]  $store_id        从手机支付的会把此值改为1
	 * @param  string  $comment         [description]
	 * @param  boolean $notify          [description]
	 * @return [type]                   [description]
	 */
	public function update($order_id, $order_status_id, $store_id, $comment = '', $notify = false) {

		// $this->load->model('checkout/order')
        $order_info = $this->getOrder($order_id);

        if ($order_info && $order_info['order_status_id']) {

            // Fraud Detection
            if ($this->config->get('config_fraud_detection')) {
                $this->load->model('checkout/fraud');

                $risk_score = $this->model_checkout_fraud->getFraudScore($order_info);

                if ($risk_score > $this->config->get('config_fraud_score')) {
                    $order_status_id = $this->config->get('config_fraud_status_id');
                }
            }

            // Ban IP
            $status = false;

            $this->load->model('account/customer');

            if ($order_info['customer_id']) {

                $results = $this->model_account_customer->getIps($order_info['customer_id']);

                foreach ($results as $result) {
                    if ($this->model_account_customer->isBanIp($result['ip'])) {
                        $status = true;

                        break;
                    }
                }
            } else {
                $status = $this->model_account_customer->isBanIp($order_info['ip']);
            }

            if ($status) {
                $order_status_id = $this->config->get('config_order_status_id');
            }


            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $order_status_id . "', store_id = '" . (int) $store_id . "',date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");


            $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int) $order_id . "', order_status_id = '" . (int) $order_status_id . "', notify = '" . (int) $notify . "', comment = '" . $this->db->escape($comment) . "', date_added = NOW()");

            // Send out any gift voucher mails
            if ($this->config->get('config_complete_status_id') == $order_status_id) {
                $this->load->model('checkout/voucher');

                $this->model_checkout_voucher->confirm($order_id);
            }

            if ($notify) {
                $language = new Language($order_info['language_directory']);
                $language->load($order_info['language_filename']);
                $language->load('mail/order');

                $subject = sprintf($language->get('text_update_subject'), html_entity_decode($order_info['store_name'], ENT_QUOTES, 'UTF-8'), $order_id);

                $message = $language->get('text_update_order') . ' ' . $order_id . "\n";
                $message .= $language->get('text_update_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

                $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int) $order_status_id . "' AND language_id = '" . (int) $order_info['language_id'] . "'");

                if ($order_status_query->num_rows) {
                    $message .= $language->get('text_update_order_status') . "\n\n";
                    $message .= $order_status_query->row['name'] . "\n\n";
                }


                if ($order_info['customer_id']) {
                    $message .= $language->get('text_update_link') . "\n";
                    $message .= $order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id . "\n\n";
                }

                if ($comment) {
                    $message .= $language->get('text_update_comment') . "\n\n";
                    $message .= $comment . "\n\n";
                }


                $message .= "order is payed";

                $message .= $language->get('text_update_footer');

                /*$mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo($order_info['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($order_info['store_name']);
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
                $mail->send();*/

                $data = array(
                   'sendto'     => $order_info['email'],
                   'receiver'   => $this->config->get('config_email'),
                   'subject'    => html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
                   'msg'        => html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
                    );
                $this->load->model('tool/sendmail');
                $this->model_tool_sendmail->send($data);
            }
        }
    }

    public function order_updat($order_id, $order_status_id, $store_id) {
        if(is_array($order_id))
        {
            foreach($order_id as $id)
            {
                $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = $order_status_id, store_id = $store_id WHERE order_id = '" . (int) $id . "'");
            }
        }
        else
        {
            $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = $order_status_id  WHERE order_id = '" . (int) $order_id . "'");
        }
        
        return $query;
    }

    public function getOrders($data = array()) {
        $sql = "SELECT o.order_id, o.order_shipping, o.language_id,o.store_url,o.store_name, o.order_weight,o.order_kaudi,o.order_kuaidi_no,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS status, o.order_status_buy, o.order_status_id, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

        if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
          if (!strpos($data['order_status_id'], ',')) {
            $sql .= " WHERE o.order_status_id = '" . (int) $data['order_status_id'] . "'";
          } else {
            $sql .= " WHERE o.order_status_id in (" . $data['order_status_id'] . ")";
          }
        } else {
            $sql .= " WHERE o.order_status_id > '0'";
        }

    if (!empty($data['username_id'])) {
      $sql .= " AND o.customer_id = '" . (int)$data['username_id'] . "'";
    }
    
    if (!empty($data['order_status_buy'])) {
      $sql .= " AND o.order_status_buy = '" . (int)$data['order_status_buy'] . "'";
    }
    
    
    if (!empty($data['yundan_or'])) {
           
      $sql .= " AND o.yundan_or = '" . (int)$data['yundan_or'] . "'";
    }
    
    
    

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float) $data['filter_total'] . "'";
        }

        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.order_kaudi',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }



        
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function get_selfproduct($customer_id) {
        
        $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int)$customer_id . "'");
        
        return $query->rows;
    }

    public function del_selfproduct($customer_id) {
        
        $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int)$customer_id . "'");
    }

    public function select_send_porduct($data) {

        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data['username_id']) && !is_null($data['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data['username_id'] . "'";
        }

        if ($data['order_status_id']) {
            if ($data['order_status_id'] == 1)//待付款
                $sql .= " AND o.state = 0 ";
            elseif ($data['order_status_id'] == 2)//待发货
                $sql .= " AND o.state in (1,5) ";
            elseif ($data['order_status_id'] == 3)//待收货
                $sql .= " AND o.state = 2 ";
        }


            if (!empty($data['consignee'])) {
                $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data['consignee']) . "%'";
            }
            
        $sql .= " ORDER BY sid DESC";

        if (!empty($data['limit']))
            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];

            $query = $this->db->query($sql);
            return $query->rows;
    }

    public function addOrder($data) {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int) $data['store_id'] . "', store_name = '" . $this->db->escape($data['storename']) . "', store_url = '" . $this->db->escape($data['storeurl']) . "', customer_id = '" . (int) $data['customer_id'] .  "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', order_status_buy = '" . (int) $data['order_status_buy'] . "', order_status_id = '" . (int) $data['order_status_id'] . "', total = '" . (float) $data['total'] . "', order_shipping = '" . $this->db->escape($data['order_shipping']) . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" . $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");
        $order_id = $this->db->getLastId();

        foreach ($data['products'] as $product) {
            //$this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int)$order_id . "', product_id = '" . (int)$product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int)$product['quantity'] . "', price = '" . (float)$product['price'] . "', total = '" . (float)$product['total']  . "', reward = '" . (int)$product['reward'] . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', product_id = '" . (int) $product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int) $product['quantity'] . "', price = '" . (float) $product['price'] . "', total = '" . (float) $product['total'] . "', option_color = '" . $this->db->escape($product['color']) . "', option_size = '" . $this->db->escape($product['size']) . "', img = '" . $this->db->escape($product['img']) . "', producturl = '" . $this->db->escape($product['producturl']) . "', source = '" . $this->db->escape($product['source']) . "', num_iid = '" . $this->db->escape($product['num_iid']) . "'");
           
        }
        
        return $order_id;
    }

    public function insert_zizhu($data_product) {
        
         $query = $this->db->query("INSERT INTO " . DB_PREFIX . "taobao_order SET  Shop = '" . $this->db->escape($data_product['seller']) . "', custom_id = '" . (int) $data_product['custom_id'] .  "'");
    
         $taobao_id = $this->db->getLastId();
         
         $query2 = $this->db->query("INSERT INTO " . DB_PREFIX . "taobao_product SET  img = '" . $this->db->escape($data_product['img']) . "' ,remark = '" . $this->db->escape($data_product['remark']) . "' ,qty = '" . (int) $data_product['qty'] . "',taobao_order_id = " . (int) $taobao_id . ",custom_id = '" . (int) $data_product['custom_id'] . "',date_add = '" . (int) $data_product['time'] . "',product_name = '" . $this->db->escape($data_product['heading_title']) . "',price = '" . $this->db->escape($data_product['price']) . "',size = '" . $this->db->escape($data_product['size']) .  "',color = '" . $this->db->escape($data_product['color'])  . "',store_name = '" . $this->db->escape($data_product['storename'])  . "',store_url = '" . $this->db->escape($data_product['storeurl'])  . "',  yunfei = '" . $this->db->escape($data_product['searchfreight']) . "', producturl= '".$this->db->escape($data_product['producturl'])."', product_id = '" . $this->db->escape($data_product['num_iid']) . "'");
            
         return 1;
    }
}
?>