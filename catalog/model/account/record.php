<?php

class ModelAccountRecord extends Model {

    public function addRecord($data) {

        if ($this->customer->getId()) {
            $this->db->query("INSERT INTO " . DB_PREFIX . "record SET uid = '" . (int) ($this->customer->getId()) . "', uname = '" . $this->db->escape($data['firstname']) .  "', payname = '" . $this->db->escape($data['payname']) . "', money = '" . (float) ($data['money']) . "', accountmoney = '" . (float) $data['accountmoney'] . "', remark = '" . $this->db->escape($data['remark']) . "', remarktype = '" . (int)$data['remarktype'] . "', remarkdetails = '" . $this->db->escape($data['remarkdetails']) . "',source=1, addtime = '" . (int) ($data['addtime']) . "'");
        } else {
	    if(!isset($data['uid']))$data['uid']='0';
            $this->db->query("INSERT INTO " . DB_PREFIX . "record SET uid = '" . (int) ($data['uid']) . "', uname = '" . $this->db->escape($data['firstname']) .  "', payname = '" . $this->db->escape($data['payname']) . "', money = '" . (float) ($data['money']) . "', accountmoney = '" . (float) $data['accountmoney'] . "', remark = '" . $this->db->escape($data['remark']) . "', remarktype = '" . (int)$data['remarktype'] . "', remarkdetails = '" . $this->db->escape($data['remarkdetails']) . "',source=1, addtime = '" . (int) ($data['addtime']) . "'");
        }

        $rid = $this->db->getLastId();

        return $rid;
    }

    public function addScoreRecord($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET score = '" . $data['score'] . "',uid = '" . (int) ($data['uid']) . "',uname ='" . $this->db->escape($data['firstname']) . "',remark = '" . $this->db->escape($data['remark']) . " ' ,addtime='" . time() . "',totalscore='" . $data['totalscore'] . "',type=" . (int) $data['type']);
    }

    public function deleteRecord($rid) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "record WHERE rid = '" . (int) $rid . "'");
    }

    public function getRecord($data) {

        $record_query = array();
		if(isset($data['type'])){
			if($data['type']==1){
				$sql = "SELECT  * FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $this->customer->getId() . "' and action in(1,2) ORDER BY rid DESC ";
			}else{
				$sql = "SELECT  * FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $this->customer->getId() . "' and action=".$data['type']." ORDER BY rid DESC ";
			}
		}
		else
        $sql = "SELECT  * FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $this->customer->getId() . "' ORDER BY rid DESC ";


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

    public function getRecords() {

        $record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "record");

        return $record_query->rows;
    }

    public function getTotalRecord($type='') {
	if($type)
		 $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $this->customer->getId() . "' and type=".$type);
	else
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "record WHERE uid = '" . (int) $this->customer->getId() . "'");

        return $query->row['total'];
    }
    
    public function getinfobyrid($rid) {
        
        $query = $this->db->query("SELECT remarktype,remarkdetails FROM `" . DB_PREFIX . "record` WHERE rid = '" . (int)$rid . "'" );

        return $query->row;
        
    }
    
    
    public function getinfobyoid($order_id_str) {
        
        $order_id_str = rtrim($order_id_str,',');
        
        $order_query = $this->db->query("SELECT order_id,store_name,store_url,order_shipping,total,date_added FROM " . DB_PREFIX . "order WHERE order_id IN (" . $order_id_str . ")");
        
        if ($order_query->num_rows) {
            
            foreach($order_query->rows as &$row) {

            $order_product_query = $this->db->query("SELECT producturl,name,price,quantity,img,option_size,option_color FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$row['order_id'] . "'");
            
            $row['order_product'] = $order_product_query->rows;
            
            $row['count'] = count($order_product_query->rows);
            
          }
          
          return $order_query->rows;

        } else {
            
            return false;
        }
   
    }
    
    public function getinfobysid($sendorder_id_str) {
        
        $sendorder_id_str = rtrim($sendorder_id_str,',');
        
        $sendorder_query = $this->db->query("SELECT sid,countweight,freight,serverfee,customsfee,totalfee,deliveryname,olddeliveryname,dabao,dingdan,baozhuang,zengzhi FROM " . DB_PREFIX . "sendorder WHERE sid IN (" . $sendorder_id_str . ")");
        
        return $sendorder_query->rows;
    }

}

?>
