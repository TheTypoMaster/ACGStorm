<?php
class ModelAppApp extends Model {
public function forgotten($email){

	$this->load->model('account/customer');
	$this->language->load('app/forgotten');
		$password = substr(sha1(uniqid(mt_rand(), true)), 0, 10);

		$this->model_account_customer->editPassword($email, $password);
	
		$subject ='CNstorm - 会员新密码';

	
		$message  = "我们从 CNstorm 收到您请求新的密码，建议您在使用新密码登入后立即变更此密码，并妥善保存...\n\n";
		$message .= "您的新密码\n\n";
		$message .= $password;	
		$mail = new Mail();
		$mail->protocol = $this->config->get('config_mail_protocol');
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->hostname = $this->config->get('config_smtp_host');
		$mail->username = $this->config->get('config_smtp_username');
		$mail->password = $this->config->get('config_smtp_password');
		$mail->port = $this->config->get('config_smtp_port');
		$mail->timeout = $this->config->get('config_smtp_timeout');
		$mail->setTo($email);
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender($this->config->get('config_name'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
		$mail->send();

}

public function getTotalCustomersByEmail($email) {
	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

	return $query->row['total'];
}

public function  customerId($customerId){

	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$customerId . "' ");
	$sql=$query->rows;
	$wishlist= $sql[0]['wishlist'];
	$wishlist= 	unserialize($wishlist);
	$product=array();
	if($wishlist){
	foreach ($wishlist as $v){

		$this->load->model('tool/image');
		$this->load->model('catalog/product');
		$product_info = $this->model_catalog_product->getProduct($v);
		if ($product_info) {
			if ($product_info['image']) {
				$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
			} else {
				$image = false;
			}

			if ($product_info['quantity'] <= 0) {
				$stock = $product_info['stock_status'];
			} elseif ($this->config->get('config_stock_display')) {
				$stock = $product_info['quantity'];
			} else {
				$stock = $this->language->get('text_instock');
			}

			if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
				$price = $product_info['price'];
			} else {
				$price = false;
			}


			$product[] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'price'      => $price
			);

		}
		 
	}
	return $product;
	}else{
		
		return false;
	}
}

public function addCustomer($data) {
	
	$this->db->query("INSERT INTO " . DB_PREFIX . "customer SET store_id = '" . (int)$this->config->get('config_store_id') . "', firstname = '" . $this->db->escape($data['firstname']) . "',  email = '" . $this->db->escape($data['email']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int)$data['newsletter'] : 0) . "',ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', approved = '1', date_added = NOW()");

	
		$this->language->load('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));

		$message = sprintf($this->language->get('text_welcome'), $this->config->get('config_name')) . "\n\n";


			$message .= $this->language->get('text_login') . "\n";
	

		$message .= $this->url->link('account/login', '', 'SSL') . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= $this->config->get('config_name');
        
        

		$mail = new Mail();
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
		$mail->send();
        

}


public function getCategories($parent_id = 0) {
	$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");

	return $query->rows;
}


public function getProducts($data = array()) {
	if ($this->customer->isLogged()) {
		$customer_group_id = $this->customer->getCustomerGroupId();
	} else {
		$customer_group_id = $this->config->get('config_customer_group_id');
	}

	$sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

	if (!empty($data['filter_category_id'])) {
		if (!empty($data['filter_sub_category'])) {
			$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
		} else {
			$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
		}

		if (!empty($data['filter_filter'])) {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
		} else {
			$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
		}
	} else {
		$sql .= " FROM " . DB_PREFIX . "product p";
	}

	$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

	if (!empty($data['filter_category_id'])) {
		if (!empty($data['filter_sub_category'])) {
			$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
		} else {
			$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
		}

		if (!empty($data['filter_filter'])) {
			$implode = array();

			$filters = explode(',', $data['filter_filter']);

			foreach ($filters as $filter_id) {
				$implode[] = (int)$filter_id;
			}

			$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
		}
	}

	if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
		$sql .= " AND (";

		if (!empty($data['filter_name'])) {
			$implode = array();

			$words = explode(' ', trim(preg_replace('/\s\s+/', ' ', $data['filter_name'])));

			foreach ($words as $word) {
				$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
			}

			if ($implode) {
				$sql .= " " . implode(" AND ", $implode) . "";
			}

			if (!empty($data['filter_description'])) {
				$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
			}
		}

		if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
			$sql .= " OR ";
		}

		if (!empty($data['filter_tag'])) {
			$sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		if (!empty($data['filter_name'])) {
			$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
		}

		$sql .= ")";
	}

	if (!empty($data['filter_manufacturer_id'])) {
		$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
	}

	$sql .= " GROUP BY p.product_id";

	$sort_data = array(
			'pd.name',
			'p.model',
			'p.quantity',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
	);

	if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
		if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
			$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
		} elseif ($data['sort'] == 'p.price') {
			$sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
		} else {
			$sql .= " ORDER BY " . $data['sort'];
		}
	} else {
		$sql .= " ORDER BY p.sort_order";
	}

	if (isset($data['order']) && ($data['order'] == 'DESC')) {
		$sql .= " DESC, LCASE(pd.name) DESC";
	} else {
		$sql .= " ASC, LCASE(pd.name) ASC";
	}

	if (isset($data['start']) || isset($data['limit'])) {
		if ($data['start'] < 0) {
			$data['start'] = 0;
		}

		if ($data['limit'] < 1) {
			$data['limit'] = 20;
		}

		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	}

	$product_data = array();

	$query = $this->db->query($sql);

	foreach ($query->rows as $result) {
		$product_data[] = $this->getProduct($result['product_id']);
	}


	
	
	return $product_data;
}


public function getProduct($product_id) {
	if ($this->customer->isLogged()) {
		$customer_group_id = $this->customer->getCustomerGroupId();
	} else {
		$customer_group_id = $this->config->get('config_customer_group_id');
	}

	$query = $this->db->query("SELECT DISTINCT *, pd.name AS name, p.image, m.name AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$customer_group_id . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$customer_group_id . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, (SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND customer_group_id = '" . (int)$customer_group_id . "') AS reward, (SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, (SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, (SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) LEFT JOIN " . DB_PREFIX . "manufacturer m ON (p.manufacturer_id = m.manufacturer_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");

	if ($query->num_rows) {
		return array(
				'product_id'       => $query->row['product_id'],
				'name'             => $query->row['name'],
				'description'      => $query->row['description'],
				'meta_description' => $query->row['meta_description'],
				'meta_keyword'     => $query->row['meta_keyword'],
				'tag'              => $query->row['tag'],
				'model'            => $query->row['model'],
				'sku'              => $query->row['sku'],
				'upc'              => $query->row['upc'],
				'ean'              => $query->row['ean'],
				'jan'              => $query->row['jan'],
				'isbn'             => $query->row['isbn'],
				'mpn'              => $query->row['mpn'],
				'location'         => $query->row['location'],
				'quantity'         => $query->row['quantity'],
				'stock_status'     => $query->row['stock_status'],
				'image'            => $query->row['image'],
				'manufacturer_id'  => $query->row['manufacturer_id'],
				'manufacturer'     => $query->row['manufacturer'],
				'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
				'special'          => $query->row['special'],
				'reward'           => $query->row['reward'],
				'points'           => $query->row['points'],
				'tax_class_id'     => $query->row['tax_class_id'],
				'date_available'   => $query->row['date_available'],
				'weight'           => $query->row['weight'],
				'weight_class_id'  => $query->row['weight_class_id'],
				'length'           => $query->row['length'],
				'width'            => $query->row['width'],
				'height'           => $query->row['height'],
				'length_class_id'  => $query->row['length_class_id'],
				'subtract'         => $query->row['subtract'],
				'rating'           => round($query->row['rating']),
				'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
				'minimum'          => $query->row['minimum'],
				'sort_order'       => $query->row['sort_order'],
				'status'           => $query->row['status'],
				'date_added'       => $query->row['date_added'],
				'date_modified'    => $query->row['date_modified'],
				'viewed'           => $query->row['viewed']
		);
	} else {
		return false;
	}
}

public function get_cart_prodcuts($customerId){

	$data=array();
	$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = " . (int)$customerId . " AND status = '1'");

	$dd=$customer_query->row;
	$cart=$dd['cart'];

	foreach (unserialize($cart) as $key => $quantity) {
		$product = explode(':', $key);
			
		$product_id = $product[0];

		if (!empty($product[3])) {
			$note = $product[3];
		}else{
			$note = '';
		}


		if(strlen($product_id)<8)
		{
			$stock = true;

			if (!empty($product[1])) {
				$options = ($product[1]);
				$search_color = str_replace("_",":",$options);
					
			} else {
				$options = array();
				$search_color = '';
			}


			if (!empty($product[2])) {
				$profile_id = $product[2];
				$profile_id = ($profile_id);
				$search_size = str_replace("_",":",$profile_id);

			} else {
				$profile_id = 0;
				$search_size = '';
			}

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

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

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

				if ($product_discount_query->num_rows) {
					$price = $product_discount_query->row['price'];
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

				if ($product_special_query->num_rows) {
					$price = $product_special_query->row['price'];
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Downloads
				$download_data = array();

				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

				foreach ($download_query->rows as $download) {
					$download_data[] = array(
							'download_id' => $download['download_id'],
							'name'        => $download['name'],
							'filename'    => $download['filename'],
							'mask'        => $download['mask'],
							'remaining'   => $download['remaining']
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
					$profile_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int)$product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`profile_id` = `p`.`profile_id` AND `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " WHERE `pp`.`profile_id` = " . (int)$profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$customer_group_id)->row;

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

				$data[]= array(
						'key'                       => $key,
						'product_id'                => $product_query->row['product_id'],
						'name'                      => $product_query->row['name'],
						'model'                     => $product_query->row['model'],
						'storename'                 => $product_query->row['mpn'],
						'storeurl'                  => $product_query->row['mpnurl'],
						'yunfei'                    => $product_query->row['isbn'],
						'shipping'                  => $product_query->row['shipping'],
						'image'                     => $product_query->row['image'],
						'location'                  => $product_query->row['location'],
						'source'                    => 1,
						'color'                     => $search_color,
						'size'                      => $search_size,
						'note'						=> $note,
						'option'                    => $option_data,
						'download'                  => $download_data,
						'quantity'                  => $quantity,
						'minimum'                   => $product_query->row['minimum'],
						'subtract'                  => $product_query->row['subtract'],
						'stock'                     => $stock,
						'price'                     => ($price + $option_price),
						'total'                     => ($price + $option_price) * $quantity,
						'reward'                    => $reward * $quantity,
						'points'                    => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
						'tax_class_id'              => $product_query->row['tax_class_id'],
						'weight'                    => ($product_query->row['weight'] + $option_weight) * $quantity,
						'weight_class_id'           => $product_query->row['weight_class_id'],
						'length'                    => $product_query->row['length'],
						'width'                     => $product_query->row['width'],
						'height'                    => $product_query->row['height'],
						'length_class_id'           => $product_query->row['length_class_id'],
						'profile_id'                => $profile_id,
						'profile_name'              => $profile_name,
						'recurring'                 => $recurring,
						'recurring_frequency'       => $recurring_frequency,
						'recurring_price'           => $recurring_price,
						'recurring_cycle'           => $recurring_cycle,
						'recurring_duration'        => $recurring_duration,
						'recurring_trial'           => $recurring_trial_status,
						'recurring_trial_frequency' => $recurring_trial_frequency,
						'recurring_trial_price'     => $recurring_trial_price,
						'recurring_trial_cycle'     => $recurring_trial_cycle,
						'recurring_trial_duration'  => $recurring_trial_duration,
				);
			}
		}
		elseif(strlen($product_id)>8 && strlen($product_id) <15)
		{
			//使用key值通过淘宝API接口获取商品详情信息

			$param['id'] = $product_id;



			//颜色
			if (!empty($product[1]))
			{
				$search_color = $product[1];
				$search_color = ($search_color);
				$search_color = str_replace("_",":",$search_color);
			}
			else
			{
				$search_color = '';
			}

			//var_dump($search_color);

			//尺寸
			if (!empty($product[2]))
			{
				$search_size = $product[2];
				$search_size = ($search_size);
				$search_size = str_replace("_",":",$search_size);
			}
			else
			{
				$search_size = '';
			}

			//var_dump($search_size);

			include_once(DIR_SYSTEM.'taobao.class.php');
			$searchresult = TAOBAO::getItemInfo($param);

			//var_dump($searchresult);

			$searchresult = array_map('strip_tags',$searchresult);
			$searchresult = array_map('trim',$searchresult);

			$searchresult['size_number']  = json_decode($searchresult['size_number'],true);

			$searchresult['color_number'] = json_decode($searchresult['color_number'],true);

			$image = $searchresult['goodsimg'];

			$size  = '';
			if(array_key_exists($search_size,$searchresult['size_number']) && $searchresult['size_number'][$search_size])
			{
				$size  = $searchresult['size_number'][$search_size];
				//var_dump($size);
			}

			$color = '';
			if(array_key_exists($search_color,$searchresult['color_number']) && $searchresult['color_number'][$search_color])
			{
				$color = $searchresult['color_number'][$search_color];

			}

			$price = '';
			if($size && $color)
			{
				$price = json_decode($searchresult['price'],true);
				$pkey = $size.'_'.$color;
				$searchresult['goodsprice'] = $price[$pkey];
			}


			if($searchresult['goodsname'])
			{
				$data[]= array(
						'key'                       => $key,
						'product_id'                => $searchresult['num_iid'],
						'name'                      => $searchresult['goodsname'],
						'model'                     => urldecode($searchresult['model']),
						'shipping'                  => '1',
						'image'                     => $image,
						'color'                     => $color,
						'size'                      => $size,
						'note'						=> $note,
						'storename'                 => $searchresult['storename'],
						'storeurl'                  => $searchresult['storeurl'],
						'yunfei'                    => $searchresult['yunfei'],
						'location'                  => "http://item.taobao.com/item.htm?id=".$product_id,
						'source'                    => 0,
						'option'                    => array(),
						'download'                  => array(),
						'quantity'                  => $quantity,
						'minimum'                   => '1',
						'subtract'                  => '1',
						'stock'                     => true,
						'price'                     => $searchresult['goodsprice'],
						'total'                     => $searchresult['goodsprice'] * $quantity,
						'reward'                    => 0,
						'points'                    => 0,
						'tax_class_id'              => '0',
						'weight'                    => (float)0,
						'weight_class_id'           => 1,
						'length'                    => '0',
						'width'                     => '0',
						'height'                    => '0',
						'length_class_id'           => 1,
						'profile_id'                => 0,
						'profile_name'              => '0',
						'recurring'                 => false,
						'recurring_frequency'       => 0,
						'recurring_price'           => 0,
						'recurring_cycle'           => 0,
						'recurring_duration'        => 0,
						'recurring_trial'           => 0,
						'recurring_trial_frequency' => 0,
						'recurring_trial_price'     => 0,
						'recurring_trial_cycle'     => 0,
						'recurring_trial_duration'  => 0,
				);
			}
			else {
				$this->remove($key);
			}
		}
		else {
			$this->remove($key);
		}
	}


	return $data;
}



public function cart_updata($productId,$remark,$quantity,$customerId){

	$productId2=$productId.$remark;
	$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = " . (int)$customerId . " AND status = '1'");
	$dd=$customer_query->row;
	$cart=$dd['cart'];
	$array_cart=unserialize($cart);

	$ff=array($productId2=>$quantity);
	foreach ($array_cart as $key => $k) {
		if($key==$productId){
		unset($array_cart[$productId]);
	}
}
  $newarray=    array_merge($array_cart,$ff);

$query= $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET cart = '" . serialize($newarray)  . "' WHERE customer_id = '" . (int)$customerId . "'and status=1");
	return $query;
	
}


public function cart_dele($productId,$customerId){
	


	$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = " . (int)$customerId . " AND status = '1'");
	$dd=$customer_query->row;
	$cart=$dd['cart'];
	$array_cart=unserialize($cart);
	

	foreach ($array_cart as $key => $k) {

		if($key==$productId){
			unset($array_cart[$productId]);
		}
	}

	$query= $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET cart = '" . serialize($array_cart)  . "' WHERE customer_id = '" . (int)$customerId . "'and status=1");
	return $query;
	
}

public function addsearch($product_id, $qty = 1, $option, $profile_id = '', $note = '',$customerId) {

	$ccc=array();
	$key = $product_id . ':';

	if ($option) {
		$key .= ($option) . ':';
	}  else {
		$key .= ':';
	}

	if ($profile_id) {
		$key .= $profile_id . ':';
	}else {
		$key .= ':';
	}

	if ($note) {
		$key .= $note;
	}

	if ((int)$qty && ((int)$qty > 0)) {
		$ccc[$key] = (int)$qty;
		$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = " . (int)$customerId . " AND status = '1'");
		$dd=$customer_query->row;
		$cart=$dd['cart'];
		if(unserialize($cart)){
			foreach (unserialize($cart) as $k=>$v){
				foreach ($ccc as $kk=>$vv){

					if($k==$kk){
						$vvv=$v+$vv;
						$d=array($kk=>$vvv);
						$rt=	array_merge (unserialize($cart),$d);

					}else {

						$rt=	array_merge (unserialize($cart),$ccc);

					}
				}
			}

			$query= $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET cart = '" . serialize($rt)  . "' WHERE customer_id = '" . (int)$customerId . "' and status=1");
			if($query){

				return 1;
			}else {
				return 0;
			}
		}else {
			$query= $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET cart = '" . serialize($ccc)  . "' WHERE customer_id = '" . (int)$customerId . "'and status=1");
			if($query){

				return 1;
			}else {
				return 0;
			}

		}

	}

}

public function Submit_cart($productId,$customerId){
	


		$data=array();
		foreach ($productId as $key => $quantity) {
			$product = explode(':', $key);
				
			$product_id = $product[0];

		
			
			if (!empty($product[3])) {
				$note = $product[3];
			}else{
				$note = '';
			}
	
	
			if(strlen($product_id)<8)
			{
				$stock = true;
	
				if (!empty($product[1])) {
					$options = ($product[1]);
					$search_color = str_replace("_",":",$options);
						
				} else {
					$options = array();
					$search_color = '';
				}
	
	
				if (!empty($product[2])) {
					$profile_id = $product[2];
					$profile_id = ($profile_id);
					$search_size = str_replace("_",":",$profile_id);
	
				} else {
					$profile_id = 0;
					$search_size = '';
				}
	
				$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");
	
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
	
					$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");
	
					if ($product_discount_query->num_rows) {
						$price = $product_discount_query->row['price'];
					}
	
					// Product Specials
					$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");
	
					if ($product_special_query->num_rows) {
						$price = $product_special_query->row['price'];
					}
	
					// Reward Points
					$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$customer_group_id . "'");
	
					if ($product_reward_query->num_rows) {
						$reward = $product_reward_query->row['points'];
					} else {
						$reward = 0;
					}
	
					// Downloads
					$download_data = array();
	
					$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$product_id . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
	
					foreach ($download_query->rows as $download) {
						$download_data[] = array(
								'download_id' => $download['download_id'],
								'name'        => $download['name'],
								'filename'    => $download['filename'],
								'mask'        => $download['mask'],
								'remaining'   => $download['remaining']
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
						$profile_info = $this->db->query("SELECT * FROM `" . DB_PREFIX . "profile` `p` JOIN `" . DB_PREFIX . "product_profile` `pp` ON `pp`.`profile_id` = `p`.`profile_id` AND `pp`.`product_id` = " . (int)$product_query->row['product_id'] . " JOIN `" . DB_PREFIX . "profile_description` `pd` ON `pd`.`profile_id` = `p`.`profile_id` AND `pd`.`language_id` = " . (int)$this->config->get('config_language_id') . " WHERE `pp`.`profile_id` = " . (int)$profile_id . " AND `status` = 1 AND `pp`.`customer_group_id` = " . (int)$customer_group_id)->row;
	
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
	
					$data[]= array(
							'key'                       => $key,
							'product_id'                => $product_query->row['product_id'],
							'name'                      => $product_query->row['name'],
							'model'                     => $product_query->row['model'],
							'storename'                 => $product_query->row['mpn'],
							'storeurl'                  => $product_query->row['mpnurl'],
							'yunfei'                    => $product_query->row['isbn'],
							'shipping'                  => $product_query->row['shipping'],
							'image'                     => $product_query->row['image'],
							'location'                  => $product_query->row['location'],
							'source'                    => 1,
							'color'                     => $search_color,
							'size'                      => $search_size,
							'note'						=> $note,
							'option'                    => $option_data,
							'download'                  => $download_data,
							'quantity'                  => $quantity,
							'minimum'                   => $product_query->row['minimum'],
							'subtract'                  => $product_query->row['subtract'],
							'stock'                     => $stock,
							'price'                     => ($price + $option_price),
							'total'                     => ($price + $option_price) * $quantity,
							'reward'                    => $reward * $quantity,
							'points'                    => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $quantity : 0),
							'tax_class_id'              => $product_query->row['tax_class_id'],
							'weight'                    => ($product_query->row['weight'] + $option_weight) * $quantity,
							'weight_class_id'           => $product_query->row['weight_class_id'],
							'length'                    => $product_query->row['length'],
							'width'                     => $product_query->row['width'],
							'height'                    => $product_query->row['height'],
							'length_class_id'           => $product_query->row['length_class_id'],
							'profile_id'                => $profile_id,
							'profile_name'              => $profile_name,
							'recurring'                 => $recurring,
							'recurring_frequency'       => $recurring_frequency,
							'recurring_price'           => $recurring_price,
							'recurring_cycle'           => $recurring_cycle,
							'recurring_duration'        => $recurring_duration,
							'recurring_trial'           => $recurring_trial_status,
							'recurring_trial_frequency' => $recurring_trial_frequency,
							'recurring_trial_price'     => $recurring_trial_price,
							'recurring_trial_cycle'     => $recurring_trial_cycle,
							'recurring_trial_duration'  => $recurring_trial_duration,
					);
				}
			}
			elseif(strlen($product_id)>8 && strlen($product_id) <15)
			{
				//使用key值通过淘宝API接口获取商品详情信息
	
				$param['id'] = $product_id;
	
	
	
				//颜色
				if (!empty($product[1]))
				{
					$search_color = $product[1];
					$search_color = ($search_color);
					$search_color = str_replace("_",":",$search_color);
				}
				else
				{
					$search_color = '';
				}
	
				//var_dump($search_color);
	
				//尺寸
				if (!empty($product[2]))
				{
					$search_size = $product[2];
					$search_size = ($search_size);
					$search_size = str_replace("_",":",$search_size);
				}
				else
				{
					$search_size = '';
				}
	
				//var_dump($search_size);
	
				include_once(DIR_SYSTEM.'taobao.class.php');
				$searchresult = TAOBAO::getItemInfo($param);
	
				//var_dump($searchresult);
	
				$searchresult = array_map('strip_tags',$searchresult);
				$searchresult = array_map('trim',$searchresult);
	
				$searchresult['size_number']  = json_decode($searchresult['size_number'],true);
	
				$searchresult['color_number'] = json_decode($searchresult['color_number'],true);
	
				$image = $searchresult['goodsimg'];
	
				$size  = '';
				if(array_key_exists($search_size,$searchresult['size_number']) && $searchresult['size_number'][$search_size])
				{
					$size  = $searchresult['size_number'][$search_size];
					//var_dump($size);
				}
	
				$color = '';
				if(array_key_exists($search_color,$searchresult['color_number']) && $searchresult['color_number'][$search_color])
				{
					$color = $searchresult['color_number'][$search_color];
					//var_dump($color);
				}
	
				$price = '';
				if($size && $color)
				{
					$price = json_decode($searchresult['price'],true);
					$pkey = $size.'_'.$color;
					$searchresult['goodsprice'] = $price[$pkey];
				}
	
	
				if($searchresult['goodsname'])
				{
					$data[]= array(
							'key'                       => $key,
							'product_id'                => $searchresult['num_iid'],
							'name'                      => $searchresult['goodsname'],
							'model'                     => urldecode($searchresult['model']),
							'shipping'                  => '1',
							'image'                     => $image,
							'color'                     => $color,
							'size'                      => $size,
							'note'						=> $note,
							'storename'                 => $searchresult['storename'],
							'storeurl'                  => $searchresult['storeurl'],
							'yunfei'                    => $searchresult['yunfei'],
							'location'                  => "http://item.taobao.com/item.htm?id=".$product_id,
							'source'                    => 0,
							'option'                    => array(),
							'download'                  => array(),
							'quantity'                  => $quantity,
							'minimum'                   => '1',
							'subtract'                  => '1',
							'stock'                     => true,
							'price'                     => $searchresult['goodsprice'],
							'total'                     => $searchresult['goodsprice'] * $quantity,
							'reward'                    => 0,
							'points'                    => 0,
							'tax_class_id'              => '0',
							'weight'                    => (float)0,
							'weight_class_id'           => 1,
							'length'                    => '0',
							'width'                     => '0',
							'height'                    => '0',
							'length_class_id'           => 1,
							'profile_id'                => 0,
							'profile_name'              => '0',
							'recurring'                 => false,
							'recurring_frequency'       => 0,
							'recurring_price'           => 0,
							'recurring_cycle'           => 0,
							'recurring_duration'        => 0,
							'recurring_trial'           => 0,
							'recurring_trial_frequency' => 0,
							'recurring_trial_price'     => 0,
							'recurring_trial_cycle'     => 0,
							'recurring_trial_duration'  => 0,
					);
				}
				else {
					$this->remove($key);
				}
			}
			else {
				$this->remove($key);
			}

	
	
	
	}
	

	
	return $data;
	

}




}
	
?>