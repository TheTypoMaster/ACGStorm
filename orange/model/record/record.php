<?php

class ModelRecordRecord extends Model {

    public function getRecords($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "record`";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE uname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }

        $sort_data = array(
            'rid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY rid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getRecordsForRC($data) {
        $sql = "SELECT rid,uid,uname,type,action,money as rmoney,accountmoney,remark,addtime FROM `" . DB_PREFIX . "record`";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE uname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }

        $sort_data = array(
            'rid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY rid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getRCRecords($data) {
        $sql = "select * from (select rid,'充值' as name,customer_id,firstname,'-' as type,'-' as action,sn,amount,currency,money,paytype,payname,accountmoney,addtime,successtime,remark,state from " . DB_PREFIX . "rechargerecord union all select rid,'消费',uid,uname,type,action,'-',money,'-','-','-','-',accountmoney,addtime,'-',remark,'-' from " . DB_PREFIX . "record) as total";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .= " WHERE firstname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }
        
        $sql .= " order by addtime desc";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function totalRCRecords($data) {
        $sql1 = "SELECT count(rid) as a FROM " . DB_PREFIX . "rechargerecord";
        $sql2 = "SELECT count(rid) as a FROM " . DB_PREFIX . "record";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql1 .= " WHERE firstname='" . addslashes(html_entity_decode($data['uname'])) . "'";
            $sql2 .= " WHERE uname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }

        return $this->db->query($sql1)->row['a'] + $this->db->query($sql2)->row['a'];
    }

    public function totalRecords() {

        $query = $this->db->query("SELECT count(rid) as a FROM `" . DB_PREFIX . "record` ");
        $a = $query->rows;

        return $a[0]['a'];
    }

    public function getRechargeRecords($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "rechargerecord`";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE firstname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }

        $sort_data = array(
            'rid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY rid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function totalRechargeRecords() {

        $query = $this->db->query("SELECT count(rid) as a FROM `" . DB_PREFIX . "rechargerecord` ");
        $a = $query->rows;

        return $a[0]['a'];
    }

    public function getScoreRecords($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "scorerecord`";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE uname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        }

        $sort_data = array(
            'sid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY sid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function totalScoreRecords() {

        $query = $this->db->query("SELECT count(sid) as a FROM `" . DB_PREFIX . "scorerecord` ");
        $a = $query->rows;

        return $a[0]['a'];
    }

    public function addRecord($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "record SET uid = '" . $this->db->escape($data['uid']) . "', uname = '" . $this->db->escape($data['uname']) . "', type = '" . $this->db->escape($data['type']) . "', money = '" . $this->db->escape($data['money']) . "', accountmoney = '" . $this->db->escape($data['accountmoney']) . "', remark= '" . $data['remark'] . "',source=1, addtime = '" . time() . "'");

        $record_id = $this->db->getLastId();
    }
    
     public function addScoreRecord($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET uid = '" . (int)$this->db->escape($data['uid']) . "', uname = '" . $this->db->escape($data['uname']) . "', remark = '" . $this->db->escape($data['remark']) . "', score = '" . $this->db->escape($data['score']) . "', totalscore = '" . $this->db->escape($data['totalscore']) . "', type = '" . (int)$data['type'] . "', addtime = '" . time() . "'");
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
        
        $sendorder_query = $this->db->query("SELECT sid,oids,addtime,countweight,freight,serverfee,customsfee,totalfee,deliveryname,olddeliveryname,dabao,dingdan,baozhuang,zengzhi FROM " . DB_PREFIX . "sendorder WHERE sid IN (" . $sendorder_id_str . ")");
        
        return $sendorder_query->rows;
    }
    
    

}

?>