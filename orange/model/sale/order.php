<?php
class ModelSaleOrder extends Model {
	
	public function updatePcReq($order_id,$sign) {
		if ( $sign == 1 ){
			$this->db->query("UPDATE " . DB_PREFIX . "order SET preq=3 WHERE order_id = '" . (int)$order_id . "'");
		}
		if ( $sign == 2 ){
			$this->db->query("UPDATE " . DB_PREFIX . "order SET creq=3 WHERE order_id = '" . (int)$order_id . "'");
		}
	}

	public function getOrders($data) {
		if (isset ( $data ['filter_sn'] ) || isset ( $data ['filter_product_name'] )) {
			$sql = "SELECT o.order_id,o.store_id,o.remarks,o.preq ,o.creq ,o.customer_id,o.firstname,o.difference, o.order_status_buy, o.order_shipping, o.firstname AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "') AS status, o.total, o.store_name, o.store_url, o.currency_code, o.currency_value, o.uptime, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o left join `" . DB_PREFIX . "order_product` op on o.order_id=op.order_id";
			
			if (! empty ( $data ['filter_sn'] )) {
				$sql .= " WHERE op.kuaidi_no= '" . $data ['filter_sn'] . "'";
			}
			
			if (! empty ( $data ['filter_product_name'] )) {
				$sql .= " WHERE op.name LIKE '%" . $data ['filter_product_name'] . "%'";
			}
		} else {
			
			$sql = "SELECT o.order_id,o.store_id,o.remarks,o.preq ,o.creq ,o.customer_id,o.firstname,o.difference, o.order_status_buy, o.order_shipping, o.firstname AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "') AS status, o.total, o.store_name, o.store_url, o.currency_code, o.currency_value, o.uptime, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";
			
			if (isset ( $data ['filter_order_status_id'] ) && ! is_null ( $data ['filter_order_status_id'] )) {
				$sql .= " WHERE o.order_status_id = '" . ( int ) $data ['filter_order_status_id'] . "'";
			} else {
				$sql .= " WHERE o.order_status_id > '0'";
			}
			
			if (! empty ( $data ['filter_order_id'] )) {
				$sql .= " AND o.order_id = '" . ( int ) $data ['filter_order_id'] . "'";
			}
			
			if (! empty ( $data ['filter_customer'] )) {
				// $sql .= " AND o.firstname LIKE '%" . mysql_real_escape_string($data['filter_customer']) . "%'";
				$sql .= " AND o.firstname LIKE '" . mysql_real_escape_string ( $data ['filter_customer'] ) . "'";
			}
			
			if (! empty ( $data ['filter_date_added'] )) {
				$sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape ( $data ['filter_date_added'] ) . "')";
			}
			
			if (! empty ( $data ['filter_date_modified'] )) {
				$sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape ( $data ['filter_date_modified'] ) . "')";
			}
			
			if (! empty ( $data ['filter_total'] )) {
				$sql .= " AND o.total = '" . ( float ) $data ['filter_total'] . "'";
			}
			
			$sort_data = array (
					'o.firstname',
					'o.order_id',
					'customer',
					'status',
					'o.date_added',
					'o.date_modified',
					'o.total' 
			);
			
			if (isset ( $data ['sort'] ) && in_array ( $data ['sort'], $sort_data )) {
				$sql .= " ORDER BY " . $data ['sort'];
			} else {
				$sql .= " ORDER BY o.order_id";
			}
			
			if (isset ( $data ['order'] ) && ($data ['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
			
			if (isset ( $data ['start'] ) || isset ( $data ['limit'] )) {
				if ($data ['start'] < 0) {
					$data ['start'] = 0;
				}
				
				if ($data ['limit'] < 1) {
					$data ['limit'] = 20;
				}
				
				$sql .= " LIMIT " . ( int ) $data ['start'] . "," . ( int ) $data ['limit'];
			}
		}
		// var_dump($query);
		
		$query = $this->db->query ( $sql );
		
		return $query->rows;
	}
	public function getOrderProducts($order_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . ( int ) $order_id . "'" );
		
		return $query->rows;
	}
	public function getOrderOption($order_id, $order_option_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . ( int ) $order_id . "' AND order_option_id = '" . ( int ) $order_option_id . "'" );
		
		return $query->row;
	}
	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query ( "SELECT oo.* FROM " . DB_PREFIX . "order_option AS oo LEFT JOIN " . DB_PREFIX . "product_option po USING(product_option_id) LEFT JOIN `" . DB_PREFIX . "option` o USING(option_id) WHERE order_id = '" . ( int ) $order_id . "' AND order_product_id = '" . ( int ) $order_product_id . "' ORDER BY o.sort_order" );
		
		return $query->rows;
	}
	public function getOrderDownloads($order_id, $order_product_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . ( int ) $order_id . "' AND order_product_id = '" . ( int ) $order_product_id . "'" );
		
		return $query->rows;
	}
	public function getOrderVouchers($order_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . ( int ) $order_id . "'" );
		
		return $query->rows;
	}
	public function getOrderVoucherByVoucherId($voucher_id) {
		$query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . ( int ) $voucher_id . "'" );
		
		return $query->row;
	}
	public function getOrderTotals($order_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . ( int ) $order_id . "' ORDER BY sort_order" );
		
		return $query->rows;
	}
	public function getTotalOrders($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";
		
		if (isset ( $data ['filter_order_status_id'] ) && ! is_null ( $data ['filter_order_status_id'] )) {
			$sql .= " WHERE order_status_id = '" . ( int ) $data ['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}
		
		if (! empty ( $data ['filter_order_id'] )) {
			$sql .= " AND order_id = '" . ( int ) $data ['filter_order_id'] . "'";
		}
		
		if (! empty ( $data ['filter_customer'] )) {
			$sql .= " AND CONCAT(firstname, ' ', lastname) LIKE '%" . $this->db->escape ( $data ['filter_customer'] ) . "%'";
		}
		
		if (! empty ( $data ['filter_date_added'] )) {
			$sql .= " AND DATE(date_added) = DATE('" . $this->db->escape ( $data ['filter_date_added'] ) . "')";
		}
		
		if (! empty ( $data ['filter_date_modified'] )) {
			$sql .= " AND DATE(date_modified) = DATE('" . $this->db->escape ( $data ['filter_date_modified'] ) . "')";
		}
		
		if (! empty ( $data ['filter_total'] )) {
			$sql .= " AND total = '" . ( float ) $data ['filter_total'] . "'";
		}
		
		$query = $this->db->query ( $sql );
		
		return $query->row ['total'];
	}
	public function getTotalOrdersByStoreId($store_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . ( int ) $store_id . "'" );
		
		return $query->row ['total'];
	}
	public function getTotalOrdersByOrderStatusId($order_status_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . ( int ) $order_status_id . "' AND order_status_id > '0'" );
		
		return $query->row ['total'];
	}
	public function getTotalOrdersByLanguageId($language_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . ( int ) $language_id . "' AND order_status_id > '0'" );
		
		return $query->row ['total'];
	}
	public function getTotalOrdersByCurrencyId($currency_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . ( int ) $currency_id . "' AND order_status_id > '0'" );
		
		return $query->row ['total'];
	}
	public function getTotalSales() {
		$query = $this->db->query ( "SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'" );
		
		return $query->row ['total'];
	}
	public function getTotalSalesByYear($year) {
		$query = $this->db->query ( "SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . ( int ) $year . "'" );
		
		return $query->row ['total'];
	}

	public function addOrderHistory($order_id, $data) {
		$this->db->query ( "UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . ( int ) $data ['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . ( int ) $order_id . "'" );
		
		$this->db->query ( "INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . ( int ) $order_id . "', order_status_id = '" . ( int ) $data ['order_status_id'] . "', notify = '" . (isset ( $data ['notify'] ) ? ( int ) $data ['notify'] : 0) . "', comment = '" . $this->db->escape ( strip_tags ( $data ['comment'] ) ) . "', date_added = NOW()" );
		
		$order_info = $this->getOrder ( $order_id );
		
		// Send out any gift voucher mails
		if ($this->config->get ( 'config_complete_status_id' ) == $data ['order_status_id']) {
			$this->load->model ( 'sale/voucher' );
			
			$results = $this->getOrderVouchers ( $order_id );
			
			foreach ( $results as $result ) {
				$this->model_sale_voucher->sendVoucher ( $result ['voucher_id'] );
			}
		}
		
		if ($data ['notify']) {
			$language = new Language ( $order_info ['language_directory'] );
			$language->load ( $order_info ['language_filename'] );
			$language->load ( 'mail/order' );
			
			$subject = sprintf ( $language->get ( 'text_subject' ), $order_info ['store_name'], $order_id );
			
			$message = $language->get ( 'text_order' ) . ' ' . $order_id . "\n";
			$message .= $language->get ( 'text_date_added' ) . ' ' . date ( $language->get ( 'date_format_short' ), strtotime ( $order_info ['date_added'] ) ) . "\n\n";
			
			$order_status_query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . ( int ) $data ['order_status_id'] . "' AND language_id = '" . ( int ) $order_info ['language_id'] . "'" );
			
			if ($order_status_query->num_rows) {
				$message .= $language->get ( 'text_order_status' ) . "\n";
				$message .= $order_status_query->row ['name'] . "\n\n";
			}
			
			if ($order_info ['customer_id']) {
				$message .= $language->get ( 'text_link' ) . "\n";
				$message .= html_entity_decode ( $order_info ['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8' ) . "\n\n";
			}
			
			if ($data ['comment']) {
				$message .= $language->get ( 'text_comment' ) . "\n\n";
				$message .= strip_tags ( html_entity_decode ( $data ['comment'], ENT_QUOTES, 'UTF-8' ) ) . "\n\n";
			}
			
			$message .= $language->get ( 'text_footer' );
			
			$mail = new Mail ();
			$mail->protocol = $this->config->get ( 'config_mail_protocol' );
			$mail->parameter = $this->config->get ( 'config_mail_parameter' );
			$mail->hostname = $this->config->get ( 'config_smtp_host' );
			$mail->username = $this->config->get ( 'config_smtp_username' );
			$mail->password = $this->config->get ( 'config_smtp_password' );
			$mail->port = $this->config->get ( 'config_smtp_port' );
			$mail->timeout = $this->config->get ( 'config_smtp_timeout' );
			$mail->setTo ( $order_info ['email'] );
			$mail->setFrom ( $this->config->get ( 'config_email' ) );
			$mail->setSender ( $order_info ['store_name'] );
			$mail->setSubject ( html_entity_decode ( $subject, ENT_QUOTES, 'UTF-8' ) );
			$mail->setText ( html_entity_decode ( $message, ENT_QUOTES, 'UTF-8' ) );
			$mail->send ();
		}
		
		$this->load->model ( 'payment/amazon_checkout' );
		$this->model_payment_amazon_checkout->orderStatusChange ( $order_id, $data );
	}
	public function getOrderHistories($order_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}
		
		if ($limit < 1) {
			$limit = 10;
		}
		
		$query = $this->db->query ( "SELECT oh.date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . ( int ) $order_id . "' AND os.language_id = '" . ( int ) $this->config->get ( 'config_language_id' ) . "' ORDER BY oh.date_added ASC LIMIT " . ( int ) $start . "," . ( int ) $limit );
		
		return $query->rows;
	}
	public function getTotalOrderHistories($order_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . ( int ) $order_id . "'" );
		
		return $query->row ['total'];
	}
	public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
		$query = $this->db->query ( "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . ( int ) $order_status_id . "'" );
		
		return $query->row ['total'];
	}
	public function getEmailsByProductsOrdered($products, $start, $end) {
		$implode = array ();
		
		foreach ( $products as $product_id ) {
			$implode [] = "op.product_id = '" . ( int ) $product_id . "'";
		}
		
		$query = $this->db->query ( "SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode ( " OR ", $implode ) . ") AND o.order_status_id <> '0' LIMIT " . ( int ) $start . "," . ( int ) $end );
		
		return $query->rows;
	}
	public function getTotalEmailsByProductsOrdered($products) {
		$implode = array ();
		
		foreach ( $products as $product_id ) {
			$implode [] = "op.product_id = '" . ( int ) $product_id . "'";
		}
		
		$query = $this->db->query ( "SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode ( " OR ", $implode ) . ") AND o.order_status_id <> '0'" );
		
		return $query->row ['total'];
	}
	public function ajax_getorder_stues($order_product_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		return $query->rows;
	}
	public function getorder_special($order_product_id) {
		$query = $this->db->query ( "SELECT order_product_id,order_id,addtime,name,option_size,option_color,price,quantity,total FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		return $query->rows;
	}
	public function ajax_update_orderstues($order_product_id, $colorid, $state) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product` SET $state =  $colorid   WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		//return $query->rows;
		return $query;
	}
	public function deleteOrder($data) {
		$query = $this->db->query ( "DELETE FROM `" . DB_PREFIX . "order_product` WHERE order_product_id = '" . ( int ) $data['productId'] . "'" );
		if ($data['totalProduct'] == 1){
			$query = $this->db->query ( "DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . ( int ) $data['orderId'] . "'" );
		}
		$query = $this->db->query("INSERT INTO " . DB_PREFIX . "record SET uid = '" . $this->db->escape($data['customerId']) . "', uname = '" . $data['uname']. "', type = 2 , money = '" . $this->db->escape($data['money']) . "', accountmoney = '" . $this->db->escape($data['accountmoney']) . "', remark= '" . $data['remark'] . "',source=1, addtime = '" . time() . "',payname='". $data['payname'] ."',record='" . $data['record'] . "'");
		return $query;
	}
	public function order_updat($order_id, $order_status_id) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . $order_status_id . "'  WHERE order_id = '" . ( int ) $order_id . "'" );
		return $query;
	}
	public function order_updat2($order_id, $pay_id) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product` SET pay_id = '" . $pay_id . "'  WHERE order_id = '" . ( int ) $order_id . "'" );
		return $query;
	}
	public function ajax_update_tracking($order_product_id, $tracking) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product` SET kuaidi_no = '" . $tracking . "' WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		return $query;
	}
	public function express() {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "express " );
		return $query->rows;
	}
	public function express_chage($order_product_id, $Adult_Value) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product` SET express = '" . $Adult_Value . "'   WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		return $query;
	}
	public function weight_chage($order_product_id, $Adult_Value) {
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product` SET weight = $Adult_Value   WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		return $query;
	}
	public function get_Order_Products($order_product_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . ( int ) $order_product_id . "'" );
		
		return $query->row;
	}
	public function editOrder2($order_product_id, $data) {
		$total = $data ['order_commodity_price'] * $data ['order_update_qty'];
		$tracking = $data ['tracking_remark'];
		$express_change = $data ['express_change'];
		$name = $data ['order_commodity_name'];
		$weight = $data ['weight'];
		$cul = $data ['order_commodity_address'];
		$order_id = $data ['order_id'];
		$seller = $data ['order_update_seller'];
		$kuaidi_no = $data ['kuaidi_no'];
		$order_express_price = $data ['order_express_price'];
		$order_change = $data ['order_change'];
		$order_update_color = $data ['order_update_color'];
		$order_update_size = $data ['order_update_size'];
		$order_remark = $data ['order_remark'];
		
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product`  SET  quantity = " . ( int ) $data ['order_update_qty'] . ",price = " . $data ['order_commodity_price'] . "  ,name = '" . $name . "'  ,total = " . ( int ) $total . ",express = '" . $express_change . "'   ,tracking_number = '" . $tracking . "' ,weight = '" . $weight . "'      ,kuaidi_no = '" . $kuaidi_no . "'   ,option_size = '" . $order_update_size . "'   ,option_color = '" . $order_update_color . "'     ,note= '" . $order_remark . "'                 WHERE  order_product_id = " . ( int ) $order_product_id );
		
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order`   SET  store_url = '" . $cul . "' , store_name = '" . $seller . "'  , order_shipping = '" . $order_express_price . "'   , order_status_id = '" . $order_change . "'                     WHERE  order_id = " . ( int ) $order_id );
	}
    
    public function getstatusbyoid($order_id) {
        
        $query = $this->db->query("SELECT order_status_id AS order_status_id FROM `" .  DB_PREFIX . "order` where order_id = '" .(int)$order_id . "'");
        
        return $query->row['order_status_id'];
    }
    
    public function getshippingbyoid($order_id) {
        
        $query = $this->db->query("SELECT order_shipping AS order_shipping FROM `" .  DB_PREFIX . "order` where order_id = '" .(int)$order_id . "'");
        
        return $query->row['order_shipping'];
        
    }
    
    public function getdifferencetotal($order_id) {
        
        $query = $this->db->query("SELECT total,difference FROM `" . DB_PREFIX . "order_product` WHERE order_id = '". (int)$order_id . "'");
        
        return $query->rows;
    }
    
    public function sum_product_total($order_id) {
        
        $query = $this->db->query("SELECT SUM(total) AS ordertotal FROM  " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");
        
        return $query->row['ordertotal'];
    }
 
    public function updatefreight($data) {
        $query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order`   SET  difference = '" . $data ['order_shipping'] . "', 	date_modified=NOW()   WHERE  order_id = " . ( int ) $data ['order_id'] );
        
        return $query;
    }

    public function updateweight($data) {
    	if ($data['variable']=='weight'){
    		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order`   SET  order_weight = '" . $data ['totalProductWeight'] . "', 	date_modified=NOW()   WHERE  order_id = " . ( int ) $data ['order_id'] );
        }
	$query1 = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product`   SET " . $data['variable'] . " = '" . $data ['pweight'] . "', 	uptime=NOW()   WHERE  order_id = " . ( int ) $data ['order_id'] );
	if (isset($query)){
		if ($query && $query1) return 1;
		else return 0;
	}else if ($query1){
		return 1;
	}else{
		return 0;
	}
    }

	public function order_product_modify($data) {
        
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET date_modified=NOW() where order_id = '" . $data['order_id'] . "'");	   
       
		$query = $this->db->query ( "UPDATE `" . DB_PREFIX . "order_product`  SET  name = '" . $this->db->escape($data ['name'])  .  "'  ,difference = '" . $data ['difference'] . "' ,option_size = '" . $this->db->escape($data ['option_size']) . "'   ,option_color = '" . $this->db->escape($data ['option_color']) . "'     ,note= '" . $this->db->escape($data ['note']) . "', uptime= '" . time () . "' WHERE  order_product_id = " . ( int ) $data['order_product_id'] );
		
        return $query;
	}
	public function get_order_list($order_product_id) {
		$query = $query = $this->db->query ( "SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE   op.order_product_id = $order_product_id" );
		return $query;
	}
	public function sun_product_total($order_id) {
		$query = $this->db->query ( "SELECT SUM(total) AS ordertotal FROM  " . DB_PREFIX . "order_product WHERE order_id = '" . ( int ) $order_id . "'" );
		return $query->rows;
	}
	public function cul_home_Products($order_product_id) {
		$query = $this->db->query ( "SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . ( int ) $order_product_id . "'" );
		return $query->rows;
	}

	public function getOnlineAppByCustomer($customerId) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "app_info` WHERE `customer_id` = '" . (int)$customerId . "' AND `status`=1");
		return $query->rows;
	}
    
    public function addOrder($data) {
       
        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int) $data['store_id'] . "', store_name = '" . $this->db->escape($data['storename']) . "', store_url = '" . $this->db->escape($data['storeurl']) . "', customer_id = '" . (int) $data['customer_id'] . "', customer_group_id = '" . (int) $data['customer_group_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', order_status_buy = '" . (int) $data['order_status_buy'] . "', order_status_id = '" . (int) $data['order_status_id'] . "', total = '" . (float) $data['total'] . "', order_shipping = '" . $this->db->escape($data['order_shipping']) . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" . $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");
        
        $order_id = $this->db->getLastId();

        foreach ($data['products'] as $product) {
            
            $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', product_id = '" . $this->db->escape($product['product_id']) . "', note = '" . $this->db->escape($product['note']) . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int) $product['quantity'] . "', price = '" . (float) $product['price'] . "', total = '" . (float) $product['total'] . "', option_color = '" . $this->db->escape($product['color']) . "', option_size = '" . $this->db->escape($product['size']) . "', img = '" . $this->db->escape($product['img']) . "', producturl = '" . $this->db->escape($product['producturl']) . "', source = '" . $this->db->escape($product['source']) . "'");
            
        }
       
        return $order_id;
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->row;
    }

    public function insert_daiji_order($insert_data) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $insert_data['username_id'] . "'");

        $user = $query->row;

        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET order_status_buy = '" . $insert_data['order_status_buy'] . "', customer_id = '" . (int) $insert_data['username_id'] . "', firstname = '" . $this->db->escape($user['firstname']) . "', lastname = '" . $this->db->escape($user['lastname']) . "', email = '" . $this->db->escape($user['email']) . "',   order_status_id = '" . $insert_data['order_status_id'] . "', language_id = '" . (int) $this->config->get('config_language_id') . "', date_added = NOW(), date_modified = '0',addtime='" . time()."'");

        $order_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', name = '" . $this->db->escape($insert_data['order_daiji_name']) . "', kuaidi_no = '" . $this->db->escape($insert_data['express_number']) . "',express = '" . $this->db->escape($insert_data['expresses']) . "', note = '" . $insert_data['order_Parcel'] . "' ,addtime='" . time()."'");
    }
  
  public function updatabz($oid,$content){
	 $sql="UPDATE " . DB_PREFIX . "order set  remarks= '".$content."' WHERE order_id = " . (int) $oid ;
	 $query = $this->db->query($sql);
	 return  $query;
  }  
}

?>