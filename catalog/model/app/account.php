<?php

class ModelAppAccount extends Model {

	public function getCoupon($data) {
	    $record_query = array();
        
        $sql = "SELECT  * FROM " . DB_PREFIX . "coupon WHERE uid = '" . (int)$data['customerId'] . "'";
        
        if ($data['state']) {
        	if (strpos($data['state'], ',') !== false)
        		$sql .= " and state in (" . $data['state'] . ") and endtime > " . time();
        	elseif ($data['state'] == 4)
        		$sql .= " and (state = " . $data['state'] . " or endtime < " . time() . ")";
        	else
        		$sql .= " and state = " . $data['state'];
        }

        if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] >= 0) {
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	

				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
		}
        
		$record_query = $this->db->query($sql);
		
        return $record_query->rows;
	}

	public function updateCoupon($data) {
		$sql = "UPDATE " . DB_PREFIX . "coupon SET state = " . (int)$data['state'] . " WHERE cid = " . $data['couponId'];
		$this->db->query($sql);
	}

    public function addRechargerecord($data) {
        
        $this->db->query("INSERT INTO " . DB_PREFIX . "rechargerecord SET customer_id = '" . (int)$data['customerId'] .  "', firstname = '" . $this->db->escape($data['firstname']) . "', amount = '" . $this->db->escape($data['amount']) . "', currency = '" . $this->db->escape($data['currency']) .  "', money = '" . $this->db->escape($data['money']) .  "', paytype = '" . $this->db->escape($data['paytype']) . " ', payname = '" . $this->db->escape($data['payname']) . " ', accountmoney = '" . $this->db->escape($data['accountmoney']) . "', addtime = '" . $this->db->escape($data['addtime']) . "', remark = '" . $this->db->escape($data['remark']) . "', state = '" . (int)$data['state'] . "'");
        
        $rid = $this->db->getLastId();
        
        return $rid;
    }

    public function editRechargerecord($data) {
        $this->db->query("UPDATE " . DB_PREFIX . "rechargerecord SET successtime = '" . $this->db->escape($data['successtime']) . "' WHERE rid = '" . (int)$data['rid'] . "'");
    }

	public function getRechargeRecord($data) {
       	$rechargerecord = array();
		
		$sql = "SELECT * FROM " . DB_PREFIX . "rechargerecord WHERE customer_id = '" . (int)$data['customerId'] . "'";
		if ($data['addtime'])
			$sql .= " and addtime > " . (int)$data['addtime'];
        
        if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}
            
            $sql .= " ORDER BY ADDTIME DESC";

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        
		$rechargerecord = $this->db->query($sql);

		return $rechargerecord->rows;
    }

    public function getExpenseRecord($data) {
        $record_query = array();

        $sql = "SELECT  * FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $data['customerId'] . "'";
        if ($data['scope'] == 1) {//代购
            $sql .= " and (remarktype=1 or (type=2 and action <> 3)) ";
        } elseif ($data['scope'] == 2) {//运单
            $sql .= " and (remarktype<>1 and (type=1 or (type=2 and action=3))) ";
        }

        $sql .= " ORDER BY ADDTIME DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $record_query = $this->db->query($sql);

        return $record_query->rows;
    }

    public function getPm($data) {
        if (0 == $data['type'])
            $sql = "SELECT  * FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $data['customerId'] . "'";
        else
            $sql = "SELECT  * FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $data['customerId'] . "' AND type = '" . (int) $data['type'] . "'";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $record_query = $this->db->query($sql);
        return $record_query->rows;
    }

    public function addRecord($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "record SET uid = '" . (int) $data['customerId'] . "', uname = '" . $this->db->escape($data['firstname']) . "', type = '" . (int) ($data['type']) . "', action = '" . (int) ($data['action']) . "', money = '" . (float) ($data['money']) . "', accountmoney = '" . (float) $data['accountmoney'] . "', remark = '" . $this->db->escape($data['remark']) . "', addtime = '" . (int) ($data['addtime']) . "'");

        $rid = $this->db->getLastId();

        return $rid;
    }

    public function getGuestbooks($data) {
        $record_query = array();
       
        $sql = "SELECT  * FROM " . DB_PREFIX . "guestbook WHERE uid = '" . (int)$data['customerId'] . "' ORDER BY `gid` DESC";
            
            
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

    
}