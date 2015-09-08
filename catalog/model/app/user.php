<?php

Class ModelAppUser extends Model {

	public function addCustomer($data) {
		if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) 
			&& in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $data['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$this->load->model('account/customer_group');
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);
		$sql = 'INSERT INTO ' . DB_PREFIX . 'customer SET firstname = "' . $this->db->escape($data['firstname']) 
			. '", email = "' . $this->db->escape($data['email'])
			. '", salt = "' . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) 
			. '", password = "' . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) 
			. '", newsletter = "' . (isset($data['newsletter']) ? $data['newsletter'] : 0) 
			. '", ip = "' . $this->db->escape($this->request->server['REMOTE_ADDR']) 
			. '", approved = "' . (int)!$customer_group_info['approval'] 
			. '", customer_group_id = "' . (int)$customer_group_id
			. '", status = "1", regtime = "' . time() . '", date_added = NOW()';
		$this->db->query($sql);

		$this->language->load('mail/customer');
		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . '\n\n';

		if ($customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . '\n';
		} else {
			$message .= $this->language->get('text_approval') . '\n';
		}

		$message .= $this->url->link('account/login') . '\n';
		$message .= $this->language->get('text_services') . '\n\n';
		$message .= $this->language->get('text_thanks') . '\n';
		$message .= $this->config->get('config_name');

		/*$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($data['email']);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();*/

		$data = array(
           'sendto' 	=> $data['email'],
           'receiver' 	=> $this->config->get('config_email'),
           'subject' 	=> html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
           'msg' 		=> html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
            );
        $this->load->model('tool/sendmail');
        $this->model_tool_sendmail->send($data);

		// Send to main admin email if new account email is enabled
		if($this->config->get('config_account_mail')) {
			$message  = $this->language->get('text_signup') . "\n\n";
			$message .= $this->language->get('text_website') . ' ' . $this->config->get('config_name') . "\n";
			$message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
			$message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
			$message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
			/*$mail->setTo($this->config->get('config_email'));
			$mail->setSubject(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'));
			$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
			$mail->send();*/

			$data = array(
               'sendto' 	=> $this->config->get('config_email'),
               'receiver' 	=> $this->config->get('config_email'),
               'subject' 	=> html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'),
               'msg' 		=> html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
                );
            $this->model_tool_sendmail->send($data);

			// Send to additional alert emails if new account email is enabled
			$emails = explode(',', $this->config->get('config_alert_emails'));

			foreach ($emails as $email) {
				if (strlen($email) > 0 && preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $email)) {
					/*$mail->setTo($email);
					$mail->send();*/

					$data['sendto'] = $email;
					$this->model_tool_sendmail->send($data);
				}
			}
		}
	}

	public function updateCart ($customerId) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cart = '" . $this->db->escape(isset($this->session->data['cart']) ? serialize($this->session->data['cart']) : '') 
			. "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int) $customerId . "'");
	}
    
    
    //add by kennewei
    public function updatesnatch($data) {
        if($data['quantity'] && !$data['note']) {
            $this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int)$data['quantity'] . "' WHERE cart_id = '" . (int)$data['cart_id'] . "'");   
        }else if(!$data['quantity'] && $data['note']) {
            $this->db->query("UPDATE " . DB_PREFIX . "cart SET note = '" . $this->db->escape($data['note']) . "' WHERE cart_id = '" . (int)$data['cart_id'] . "'");
        }else if($data['quantity'] && $data['note']) {
            $this->db->query("UPDATE " . DB_PREFIX . "cart SET note = '" . $this->db->escape($data['note']) . "', quantity = '" . (int)$data['quantity'] . "' WHERE cart_id = '" . (int)$data['cart_id'] . "'");
        }  
    }
    //end

	public function updateWishlist ($customerId) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET wishlist = '" . $this->db->escape(isset($this->session->data['wishlist']) ? serialize($this->session->data['wishlist']) : '')
		 . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int) $customerId . "'");
	}

	public function login($email, $password, $override = false) {
       
        if ($override) {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer where LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
        } else {
            $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1' OR LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
        }

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

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int) $this->customer_id . "'");

            return true;
        } else {
            return false;
        }
    }

    public function editScores($Newscores, $customerId) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET scores= '" . $this->db->escape(utf8_strtolower($Newscores)) . "' WHERE customer_id = '" . (int)$customerId . "'");
	}

	public function editCustomer($data, $customerId) {
		$sql = "UPDATE " . DB_PREFIX . "customer SET ";
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$sql .= $key . " = '" . $value . "',";
			}
		}
		$sql = substr($sql, 0, strlen($sql) - 1);
		$sql .= " WHERE customer_id = " . (int) $customerId;
		$this->db->query($sql);
	}
	public function getCustomerByOauth($uid, $type) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `from` = '" . $type . "' AND oauthuid = '" . $uid . "'");
		return $query->row;
	}

	public function getAppInfoByCustomer($customerId) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "app_info` WHERE `customer_id` = '" . (int)$customerId . "'");
		return $query->rows;
	}

	public function getOnlineAppByCustomer($customerId) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "app_info` WHERE `customer_id` = '" . (int)$customerId . "' AND `status`=1");
		return $query->rows;
	}

	public function addAppInfo($data) {
		$query = $this->db->query("INSERT INTO `" . DB_PREFIX . "app_info` SET `customer_id` = '" . (int)$data['customer_id'] . "', `user_id` = '" . $this->db->escape($data['user_id']) . "', `channel_id` = '" . $this->db->escape($data['channel_id']) . "', `device_type` = '" . $this->db->escape($data['device_type']) . "', `status` = '" . $this->db->escape($data['status']) . "'");
	}

	public function updateAppInfo($data) {
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "app_info` SET `status` = '" . $this->db->escape($data['status']) . "' WHERE `customer_id` = '" . (int)$data['customer_id'] . "' and `user_id` = '" . $this->db->escape($data['user_id']) . "' and `channel_id` = '" . $this->db->escape($data['channel_id']) . "'");
	}

	public function getVersion($type) {
		$version = 0;
		$query = $this->db->query("SELECT `version` FROM `" . DB_PREFIX . "app_version` WHERE `type` = '" . (int)$type . "'");
		$version = $query->row['version'];
		return $version;
	}
}
?>