<?php

class ModelYundanYundan extends Model {

    public function getOrders($data = array()) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder`";

        if (isset($data['state']) && !is_null($data['state'])) {
            $sql .= " WHERE state = '" . (int) $data['state'] . "'";
        } else {
            $sql .= " WHERE state > '0'";
        }

        if (!empty($data['filter_customer'])) {
            //$sql .= " AND uname  LIKE '%" . $this->db->escape($data['filter_customer']) . "%'";
            $sql .= " AND uname  LIKE '" .  addslashes(html_entity_decode(mysql_real_escape_string($data ['filter_customer'])))  . "'";
        }
        
        if (!empty($data['filter_sn'])) {
            $sql .= " AND sn  LIKE '%" . $this->db->escape($data['filter_sn']) . "%'";
        }
        
        if (!empty($data['filter_sid'])) {
            $sql .= " AND sid = '" . (int) $data['filter_sid'] . "'";
        }

        if (!empty($data['filter_order_status_id'])) {
            $sql .= " AND state = '" . (int) $data['filter_order_status_id'] . "'";
        }

        if (!empty($data['filter_date_added'])) {

            $filter_date_added = strtotime($data['filter_date_added']);

            $sql .= " AND addtime >$filter_date_added";
        }

        if (!empty($data['filter_date_modified'])) {
            $filter_date_modified = strtotime($data['filter_date_modified']);
            $sql .= " AND uptime < $filter_date_modified";
        }
        
	if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " ORDER BY sid DESC";
		} else {
			$sql .= " ORDER BY sid ASC";
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

    public function International_express($areaid) {
	$c=preg_match('/[a-zA-Z]/', $areaid);
	
	if($c){

	$sql0 = "SELECT * FROM `" . DB_PREFIX . "country` where name='$areaid'";
	$query = $this->db->query($sql0);
	$aid = $query->row['areaid'];
	$sql = "SELECT * FROM `" . DB_PREFIX . "dg_delivery` o where areaid='$aid'";
	}else{
        $sql = "SELECT * FROM `" . DB_PREFIX . "dg_delivery` o where areaname='$areaid'";
        }
        $query = $this->db->query($sql);

        return $query->rows;
    }
    
    public function Destination_cn($country){
    	$query = $this->db->query("SELECT name_cn FROM `" . DB_PREFIX . "country` where name='$country'");
    	return $query->rows;
    }

    public function getInternational_express_id($areaid, $deliveryname) {

        $sql = "SELECT * FROM `" . DB_PREFIX . "dg_delivery` o where areaname='$areaid' and deliveryname='$deliveryname'";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getyundanStatuses() {

        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder_status` o";
        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function update_order($order_id, $remark) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  sn = '" . $remark . "'     WHERE  sid = " . (int) $order_id);

        return $query;
    }

    public function update_weight($order_id, $weight) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  countweight = '" . $weight . "'     WHERE  sid = " . (int) $order_id);

        return $query;
    }

    public function change_kuaidi($order_id, $change_kuaidi) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE did = '" . (int) $change_kuaidi . "'");
        $sql = $query->rows;
        $change_kuaidi2 = $sql[0]['deliveryname'];
        
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  olddeliveryname = deliveryname   WHERE  sid = " . (int) $order_id);

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  deliveryname = '" . $change_kuaidi2 . "'     WHERE  sid = " . (int) $order_id);

        return $query;
    }

    public function getOrder($order_id) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder WHERE sid = '" . (int) $order_id . "'");
        return $query->rows;
    }

    public function change_v($data) {
        $yundan_long = $data['yundan_long'];
        $yundan_wide = $data['yundan_wide'];
        $yundan_heigh = $data['yundan_high'];
        $price = $data['volumn_price'];
        $id = $data['id'];

        date_default_timezone_set('Asia/Shanghai');
        $time = time();

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  length = '" . $yundan_long . "'  ,	width = '" . $yundan_wide . "' ,height = '" . $yundan_heigh . "' , volumn_price = '" . $price . "' , uptime = '" . $time . "'   WHERE  sid = " . (int) $id);

        return $query;
    }

    public function get_yundan($yundan_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder WHERE  sid = " . (int) $yundan_id);
        return $query->rows;
    }

    public function updata_yundan($data) {

        $yundan_id = $data['yundan_id'];
        $kuaiai_on = $data['kuaiai_on'];
        $email = $data['email'];
        $freight = $data['freight'];
        $serverfee = $data['serverfee'];
        $customsfee = $data['customsfee'];
        $consignee = $data['consignee'];
        $country = $data['country'];
        $city = $data['city'];
        $zip = $data['zip'];
        $comment = $data['comment'];
        $reply = $data['reply'];
        $showcomment = $data['showcomment'];
        $address = $data['address'];
        $state=$data['state'];
		/*
		switch( $state){
				case '待付款':
				$state=0;
			break;
				case '已付款':
				$state=1;
			break;
				case '已邮寄':
				$state=2;
			break;
				case '已确认收货':
				$state=3;
			break;
				case '无效运单':
				$state=4;
			break;
				case '准备邮寄':
				$state=5;
			break;
				case '待补交运费':
				$state=6;
			break;
				case '信息不全':
				$state=7;
			break;
				case '已评价':
				$state=8;
			break;
			case '':
				$state=8;
		}/*,state=".$state." 
		*/
        $total = $freight + $serverfee + $customsfee;

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET   address = '" . $address . "'  ,totalfee = '" . $total . "'  ,	sn = '" . $kuaiai_on . "'  ,	email = '" . $email . "' ,freight = '" . $freight . "' , serverfee = '" . $serverfee . "' , customsfee = '" . $customsfee . "', consignee = '" . $consignee . "' , country = '" . $country . "'   ,city = '" . $city . "'   , zip = '" . $zip . "'   , country = '" . $country . "'   , comment = '" . $comment . "'   ,  reply = '" . $reply . "'   , showcomment = '" . $showcomment . "'   , uptime =  now()   WHERE  sid = " . (int) $yundan_id);

        return $query;
    }

    public function select_send_porduct($yundan_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder_product WHERE  sendorder_id = " . (int) $yundan_id);
        return $query->rows;
    }

    public function warehouse($yundan_id) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder_product`   SET   warehouse = 1     WHERE  product_id = " . (int) $yundan_id);

        return $query;
    }

    public function pack($yundan_id) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder_product`   SET   packager = 1     WHERE  product_id = " . (int) $yundan_id);

        return $query;
    }

    public function updata_status($select, $filter_order_status_id) {
		switch($filter_order_status_id){
			case  1:
			$str=",`order_time`= ".time();
			break;
			case  5:
			$str=",ready_send_time= ".time();
			break;
			case  2:
			$str=",delivery_time= ".time();
			break;
			case  8:
			$str=",evaluation_time= ".time();
			break;
		}
        foreach ($select as $s) {
			//$sql="UPDATE `" . DB_PREFIX . "sendorder`   SET   state = $filter_order_status_id  ".$str."   WHERE  sid = " . (int) $s;
			//echo $sql,"<br/>";
			$query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET   state = $filter_order_status_id  ".$str."  WHERE  sid = " . (int) $s);
        }
	
    }

    public function update_debt($oid, $cost) {

            $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET   state = 6,countmoney=".$cost."     WHERE  sid = " . (int) $oid);
    }

    public function total($data) {
		if (empty ( $data )) {
			$query = $this->db->query ( "SELECT count(sid) as a FROM `" . DB_PREFIX . "sendorder` " );
		} elseif (isset($data ['uname'])) {
			$sql = "SELECT count(sid) as a FROM `" . DB_PREFIX . "sendorder`";
			$sql .= " where uname  LIKE '" . $this->db->escape ( $data ['uname'] ) . "'";
			$query = $this->db->query ( $sql );
		} elseif (isset($data ['filter_order_status_id'])) {
            $sql = "SELECT count(sid) as a FROM `" . DB_PREFIX . "sendorder`";
            $sql .= " where state ='" . $this->db->escape ( $data ['filter_order_status_id'] ) . "'";
            $query = $this->db->query ( $sql );
        }else {
			return 0;
		}
		$a = $query->rows;
		
		return $a [0] ['a'];
	}

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT a.*,b.store_name FROM " . DB_PREFIX . "order_product a LEFT JOIN " . DB_PREFIX . "order b ON a.order_id = b.order_id WHERE a.order_id = '" . (int) $order_id . "'");
    
        return $query->rows;
    }

	public function outBound($product_id) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET outBound=1 WHERE  kuaidi_no = '" . $product_id . "'");
		return $query;
    }
	//修改订单
  public function updatabz($oid,$content){
	 $sql="UPDATE " . DB_PREFIX . "sendorder set  remarks= '".$content."' WHERE sid = " . (int) $oid ;
	 $query = $this->db->query($sql);
	 return  $query;
  }  
}

?>