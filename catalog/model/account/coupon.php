<?php
class ModelAccountCoupon extends Model {
    
    public function getCouponbycid($cid) {
        
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "coupon`  WHERE  cid = '" . (int)$cid . "'");
        
        return $query->row;
    }
    
    
	public function addCoupon($data) {
	   
		$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET  sn = '" . $this->db->escape($data['sn']) . "' ,uid = '" . (int)$this->customer->getId() .  "', uname = '" . $this->db->escape($data['firstname']) . "', getway = '" . (int)($data['getway']) . "', endtime = '" . (int)($data['endtime']) . "', addtime = '" . (int)($data['addtime']) . "', money = '" . (int)$data['money'] . "', sellmoney = '" . (int)$data['sellmoney'] . "', state = '" . (int)($data['state']) . "'");
        
		$cid = $this->db->getLastId();
		
		return $cid;
	}
	
	public function updateCoupon($cid , $state) {
	   
	    $this->db->query("UPDATE  " . DB_PREFIX . "coupon  SET state = " . $state  . "  WHERE cid = '" . (int)$cid . "'");
	}

	public function deleteCoupon($cid) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "coupon WHERE cid = '" . (int)$cid . "'");
	}	
    
	
	public function getCoupon($data) {
	    $record_query = array();
        
      
 
			 if(6 == $data['type'])
              $sql = "SELECT  * FROM " . DB_PREFIX . "coupon WHERE uid = '" . (int)$this->customer->getId() . "' ";
       else
            $sql = "SELECT  * FROM " . DB_PREFIX . "coupon WHERE uid = '" . (int)$this->customer->getId() . "' AND state = '" . (int)$data['type'] . "'";
			
		
		$sql .=" order by cid ".$data['order'];
        if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        
        
		$record_query = $this->db->query($sql);
		
        return $record_query->rows;
	}
	
	
	public function getCouponsByid() {
		
		$record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon WHERE uid= '" . (int)$this->customer->getId() . "'" );
	
                return $record_query->rows; 
	
	}
	
	public function getCouponsByState() {
		
		$record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon WHERE state = 1 and uid= '" . (int)$this->customer->getId() . "' OR  state = 2 and uid= '" .  (int)$this->customer->getId() . "'");
	
                return $record_query->rows; 
	
	}
	
	public function getCoupons() {
		
		$record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon");
	
        return $record_query->rows; 
		
	}	
	
	public function getTotalCoupon($type='') {
		if($type)
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "coupon WHERE uid = '" . (int)$this->customer->getId() . "' and state=".$type);
		else
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "coupon WHERE uid = '" . (int)$this->customer->getId() . "'");
	
		return $query->row['total'];
	}
	
	public function getFavourables() {
		$sql = "SELECT * FROM " . DB_PREFIX . "favourable";	
		$sql .= " ORDER BY add_time";	
		$sql .= " ASC";			
		$query = $this->db->query($sql);
		return $query->rows;
	}
}
?>