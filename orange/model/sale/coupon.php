<?php
class ModelSaleCoupon extends Model {
	public function addCoupon($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET uname = '" . $this->db->escape($data['uname']) . "', uid= '" . $this->db->escape($data['uid']) . "', money= '" . (float)$data['money'] .  "', addtime = '" . $this->db->escape(strtotime($data['date_start'])) . "', endtime = '" . $this->db->escape(strtotime($data['date_end'])) . "', state= '" . (int)$data['status'] . "', sn = unix_timestamp(NOW())");

		$coupon_id = $this->db->getLastId();
	
	}

	public function editCoupon($cid, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "coupon SET uname = '" . $this->db->escape($data['uname']) . "', uid= '" . $this->db->escape($data['uid']) . "', money= '" . (float)$data['money'] .  "', addtime = '" . $this->db->escape(strtotime($data['date_start'])) . "', endtime = '" . $this->db->escape(strtotime($data['date_end'])) . "', state= '" . (int)$data['status'] . "' WHERE cid = '" . (int)$cid . "'");
		//var_dump("UPDATE " . DB_PREFIX . "coupon SET uname = '" . $this->db->escape($data['uname']) . "', uid= '" . $this->db->escape($data['uid']) . "', money= '" . (float)$data['money'] .  "', addtime = '" . $this->db->escape(strtotime($data['date_start'])) . "', endtime = '" . $this->db->escape(strtotime($data['date_end'])) . "', state= '" . (int)$data['status'] . "' WHERE cid = '" . (int)$cid . "'");
		
	}

	public function deleteCoupon($coupon_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon WHERE cid = '" . (int)$coupon_id . "'");
		
	}

	public function getCoupon($coupon_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "coupon WHERE cid = '" . (int)$coupon_id . "'");

		return $query->row;
	}


	public function getCoupons($data = array()) {
		$sql = "SELECT cid, uid, uname, money, addtime, endtime, state FROM " . DB_PREFIX . "coupon";
    //    $sql = "SELECT * FROM " . DB_PREFIX . "coupon";
        if (isset($data['uname']) && $data['uname']) {
            
            $sql .=" WHERE uname='" . addslashes(html_entity_decode($data['uname'])) . "'";
            
        }


		$sort_data = array(
		        'cid',
		        'uid',
			'uname',
			'money',
			'addtime',
			'endtime',
			'state'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY cid";	
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
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
        
        //var_dump($sql);		

		$query = $this->db->query($sql);

		return $query->rows;
	}

	
	public function getUid($uname) {
		$query = $this->db->query("SELECT customer_id AS uid FROM " . DB_PREFIX . "customer WHERE firstname= '" . $uname . "'");
                if($query->row){
		      return $query->row['uid'];
		} else {
		      return 0;
		}
	}
	
	public function getTotalCoupons() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "coupon");

		return $query->row['total'];
	}	

	public function getCouponHistories($coupon_id, $start = 0, $limit = 10) {
		if ($start < 0) {
			$start = 0;
		}

		if ($limit < 1) {
			$limit = 10;
		}	

		$query = $this->db->query("SELECT ch.order_id, CONCAT(c.firstname, ' ', c.lastname) AS customer, ch.amount, ch.date_added FROM " . DB_PREFIX . "coupon_history ch LEFT JOIN " . DB_PREFIX . "customer c ON (ch.customer_id = c.customer_id) WHERE ch.coupon_id = '" . (int)$coupon_id . "' ORDER BY ch.date_added ASC LIMIT " . (int)$start . "," . (int)$limit);

		return $query->rows;
	}

	public function getTotalCouponHistories($coupon_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "coupon_history WHERE coupon_id = '" . (int)$coupon_id . "'");

		return $query->row['total'];
	}			
}
?>