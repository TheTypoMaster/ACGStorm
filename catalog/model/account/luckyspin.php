<?php
class ModelAccountLuckyspin extends Model {
    
    public function addspinrecord($data) {
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "luckyspin SET  uid = '" . (int)$data['uid'] . "' ,uname = '" . $this->db->escape($data['uname']) .  "', remark = '" . $this->db->escape($data['remark']) .  "', addtime = '" . (int)($data['addtime']) . "'");
        
		$id = $this->db->getLastId();
		
		return $id;
    }
    
    public function addCoupon($data) {
        
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET uname = '" . $this->db->escape($data['uname']) . "', uid= '" . $this->db->escape($data['uid']) . "', money= '" . (float)$data['money'] .  "', addtime = '" . $this->db->escape(strtotime($data['date_start'])) . "', endtime = '" . $this->db->escape(strtotime($data['date_end'])) . "', state= '" . (int)$data['status'] . "', sn = unix_timestamp(NOW())");

		$coupon_id = $this->db->getLastId();
	
	}
    
    public function updateluckyspin() {
        
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET luckyspin = unix_timestamp(NOW()) WHERE customer_id = '" . (int)$this->customer->getId() . "'");
    }
    
    public function getluckyspin($uid) {
        
        $query = $this->db->query("SELECT  luckyspin as luckyspin FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$uid . "'");

		return $query->row['luckyspin'];
        
    }
    
    public function getluckyspininfo() {
        
        $query = $this->db->query("SELECT  *  FROM " . DB_PREFIX . "luckyspin ORDER BY uid desc LIMIT 10");

		return $query->rows;
        
    }
    
    
}