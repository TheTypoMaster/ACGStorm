<?php

class Modelinternationalfreight extends Model {

     public function getdelivery($realvalue) {
        
        $query = $this->db->query("SELECT *  FROM  `" . DB_PREFIX . "dg_delivery` WHERE areaid = '" . (int)$realvalue . "'");
       
        return $query->rows;
     }
     
     public function getcomment($data) {
        
        $query = $this->db->query("SELECT uid,uname,country,did,comment,commenttime FROM  `" . DB_PREFIX . "sendorder` s LEFT JOIN `" . DB_PREFIX . "dg_area` a ON  (a.name_en = s.country)  WHERE a.aid = '" . (int)$data['realvalue'] . "' AND  commenttime>0 AND showcomment=1 AND deliveryname = '" .$this->db->escape($data['deliveryname']) ."' ORDER BY commenttime DESC LIMIT " . $data['limit']);
                 
        return $query->rows;
     }
     
     public function getface($uid) {
        
        $query = $this->db->query("SELECT face as face  FROM  `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)$uid . "'");
       
        return $query->row['face'];
        
     }
}

?>
