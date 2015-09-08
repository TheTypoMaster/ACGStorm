<?php
class ModelAccountRechargerecord extends Model {
	public function addRechargerecord($data) {
		
		$this->db->query("INSERT INTO " . DB_PREFIX . "rechargerecord SET customer_id = '" . (int)$this->customer->getId() .  "', firstname = '" . $this->db->escape($data['firstname']) . "', amount = '" . $this->db->escape($data['amount']) . "', currency = '" . $this->db->escape($data['currency']) .  "', money = '" . $this->db->escape($data['money']) .  "', paytype = '" . $this->db->escape($data['paytype']) . " ', payname = '" . $this->db->escape($data['payname']) . " ', accountmoney = '" . $this->db->escape($data['accountmoney']) . "', addtime = '" . $this->db->escape($data['addtime']) . "',source=1, state = '" . (int)$data['state'] . "'");
        
		$rid = $this->db->getLastId();
		
		return $rid;
	}
    
    public function getRechargerecord($data) {
        
       	$rechargerecord = array();
		
		$sql = "SELECT * FROM " . DB_PREFIX . "rechargerecord WHERE customer_id = '" . (int)$this->customer->getId() . "'";
        
        if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
            
            $sql .= "ORDER BY ADDTIME DESC";				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        
        
		$rechargerecord = $this->db->query($sql);

		return $rechargerecord->rows;
        
	
    }
    
    public function getTopUpMoneybyId($topup_id) {
        return (float) $this->db->query("SELECT money FROM oc_rechargerecord WHERE rid = " . (int) $topup_id)->row['money'];
    }
    
    public function getInfo($topup_id) {
        return $this->db->query("SELECT money,state FROM oc_rechargerecord WHERE rid = " . (int) $topup_id)->row;
    }
 
    public function getMoneybyid($rid) {

		$query = $this->db->query("SELECT accountmoney FROM " . DB_PREFIX . "rechargerecord WHERE rid = '" . $rid . "'");

		return $query->row['accountmoney'];

	}
    
    
   	public function getTotalRechargerecord() {
   	    
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "rechargerecord WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	
		return $query->row['total'];
	}
    
    public function  updateRechargerecord($data) {
        
       return  $this->db->query("UPDATE " . DB_PREFIX . "rechargerecord SET state = '" . (int)$data['state'] . "', successtime =  '" . $this->db->escape($data['successtime'])  . "', remark =  '" . $this->db->escape($data['remark']) . "' WHERE rid = '" . (int)$data['rid'] . "'");
    }
    
    public function getRemarkbyrid($rid) {
        
        $query = $this->db->query("SELECT remark AS remark FROM " . DB_PREFIX . "rechargerecord WHERE rid = '" . (int)$rid . "'");
	
		return $query->row['remark'];
    }
    

}
?>