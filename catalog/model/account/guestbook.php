<?php
class ModelAccountGuestbook extends Model {
	public function addGuestbook($data) {
	   
		$this->db->query("INSERT INTO " . DB_PREFIX . "guestbook SET uid = '" . (int)$data['uid'] .  "', uname = '" . $this->db->escape($data['uname']) . "', type = '" . $this->db->escape($data['type']) .  "', addtime = '" . (int)($data['addtime']) . "', state = '" . (int)($data['state']) . "', msg = '" . $this->db->escape($data['msg']) . "', reply = '" . $this->db->escape($data['reply']) . "'");
        
		$gid = $this->db->getLastId();
		
		return $gid;
	}
	

	public function deleteGuestbook($gid) {
	   
		$this->db->query("DELETE FROM " . DB_PREFIX . "guestbook WHERE gid = '" . (int)$gid . "'");
	}	
    
	
	public function getGuestbook($data) {
	   
       $record_query = array();
	   
	   if(6 == $data['type'])
            $sql = "SELECT  * FROM " . DB_PREFIX . "guestbook WHERE uid = '" . (int)$this->customer->getId() . "'";
       else
            $sql = "SELECT  * FROM " . DB_PREFIX . "guestbook WHERE uid = '" . (int)$this->customer->getId() . "' AND type = '" . (int)$data['type'] . "'";
            
         if(isset($data['order'])){
			$sql .= " order by gid ".$data['order'];
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
        

        $record_query = $this->db->query($sql);
      
        return $record_query->rows;
	}
	
	public function getGuestbooks() {
		
		$record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "guestbook");
	
        return $record_query->rows; 
		
	}	
	
	public function getTotalGuestbook($type) {
	   
       if(6 == $type)
		    $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "guestbook WHERE uid = '" . (int)$this->customer->getId() . "'");
       else
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "guestbook WHERE uid = '" . (int)$this->customer->getId() . "' AND type = '" . (int)$type . "'");
      
		return $query->row['total'];
	}
    
   
}
?>