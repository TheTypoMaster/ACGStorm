<?php

class ModelGuojiGuoji extends Model {

    public function address($username_id) {
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "address` o LEFT JOIN " . DB_PREFIX . "country op ON (o.country_id = op.country_id) WHERE  o.customer_id =$username_id ");
        return $query->rows;
    }

    public function getOrders_guoji($username_id) {

        $sql = "SELECT o.order_id, o.order_shipping, o.language_id, o.order_weight,o.order_kaudi,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

        if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
            $sql .= " WHERE o.customer_id = $username_id AND o.order_status_id = '" . (int) $data['order_status_id'] . "'";
        } else {
            $sql .= " WHERE o.customer_id = $username_id AND o.order_status_id = '6' AND o.yundan_or =2";
        }

        if (!empty($data['order_status_buy'])) {
            $sql .= " AND o.order_status_buy = '" . (int) $data['order_status_buy'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float) $data['filter_total'] . "'";
        }
        /*
          if(!empty($username_id)){
          $sql .= " AND o.customer_id = '" . (int)$username_id	;
          }
         */

        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.order_kaudi',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
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

    public function getOrders($username_id) {
        $sql = "SELECT o.order_id, o.order_shipping, o.language_id, o.order_weight,o.order_kaudi,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os.name FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = '" . (int) $this->config->get('config_language_id') . "') AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";

        if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
            $sql .= " WHERE o.order_status_id = '" . (int) $data['order_status_id'] . "'";
        } else {
            $sql .= " WHERE o.order_status_id > '0' AND o.yundan_or =2";
        }

        if (!empty($data['order_status_buy'])) {
            $sql .= " AND o.order_status_buy = '" . (int) $data['order_status_buy'] . "'";
        }

        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float) $data['filter_total'] . "'";
        }


        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.order_kaudi',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
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

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    public function tot_weight($order_id) {


        $query = $this->db->query("SELECT  SUM(weight) as  a FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'   ");

        return $count[] = $query->rows[0]['a'];
    }

    public function Total_weight($chestr) {

        $count = array();
        foreach ($chestr as $r) {
            $order_id = $r['order_id'];
            $query = $this->db->query("SELECT  SUM(weight) as  a FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'   ");
            $count[] = $query->rows[0]['a'];
        }


        $sum = array_sum($count);
        return $sum;
    }

    public function del($order_id) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  order_status_id = 6 , yundan_or = 1   WHERE  order_id = " . (int) $order_id);

        return $query;
    }

    public function order_all_mingan($results) {

        $str = "";
        foreach ($results as $result) {

            $order_id = $result['order_id'];

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

            $mingan = $query->rows;

            foreach ($mingan as $mi) {

                $str.=$mi['order_sensitive'];
            }
        }
        return $str;
    }

    public function get_express($address_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid ='" . $address_id . "'");
        return $query->rows;
    }

    public function address_yundan($address_id, $username_id, $mingan) {
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "address` o LEFT JOIN " . DB_PREFIX . "country op ON (o.country_id = op.country_id) WHERE  o.customer_id =$username_id and o.address_id =$address_id ");
        $county = $query->rows;
        $county_name = $county[0]['name'];
        $area_id = $county[0]['areaid'];

        if ($mingan == '') {
            if ($area_id != 0) {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid = $area_id and `state` = 1");
            } else {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid ='14' and `state` = 1");
            }
        } else {
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','SAL水陆联运') AND areaid = $area_id and `state` = 1");
        }
        return $query->rows;
    }

    function jisuan_yunfei($address_id) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery  WHERE did = '" . (int) $address_id . "'");
        return $query->rows;
    }
	
    function insert_guoji_yundan_bak($data) {
    
    	$couponid = $data['couponId'];
    	$username_id = $data['username_id'];
	$usescore = $data['usescore'];
    	$usrname = $data['usrname'];
    	$email = $data['email'];
    	$soids = $data['soids'];
    	$newscore = $data['newscore'];
    	$deliveryname = $data['deliveryname'];
    	$did       = $data['did'];
    	$status_id = $data['status_id'];
    	$zengzhi = $data['zengzhi'];
    	$cailiao = $data['cailiao'];
    	$dingdan = $data['dingdan'];
    	$dabao = $data['dabao'];
    	$serverfee = $data['serverfee'];
    	$wrapperfee = $data['wrapperfee'];
    	$over_yunfei = $data['over_yunfei'];
    	$all_weight = $data['all_weight'];
    	$address_id = $data['address_id'];
    	$freight = $data['freight'];
    	$remark = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $data['remark']);
    
    	/*
    	 if ($dabao > 0) {
    	$dabao_1 = $dabao;
    	} else {
    
    	$dabao_1 = "";
    	}
    	if ($dingdan > 0) {
    	$dingdan_1 = $dingdan;
    	} else {
    	$dingdan_1 = "";
    	}
    	if ($cailiao > 0) {
    	$cailiao_1 = $cailiao;
    	} else {
    	$cailiao_1 = "";
    	}
    	if ($zengzhi > 0) {
    	$zengzhi_1 = $zengzhi;
    	} else {
    
    	$zengzhi_1 = "";
    	}
    	*/
    
    	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "address` WHERE  address_id = $address_id");
    	$sql = $query->row;
    
    	$country_id = $sql['country_id'];
    	$lastname = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $sql['lastname']);
    	$city_id = $sql['zone_id'];
    	$postcode = $sql['postcode'];
    	$tel = $sql['telephone'];
    	$address_1 = $sql['address_details'];
    	//$address_2 = $sql['address_2'];
    	$address_join = $address_1/* . " " . $address_2*/;
    	$address = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $address_join);
    
    	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country`   WHERE   country_id ='" . $country_id . "'");
    	$sql2 = $query->row;
    
    	$country = $sql2['name'];
    	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone`   WHERE   zone_id ='" . $city_id . "'");
    	$sql3 = $query->row;
    	if (isset($sql3['name'])&&!empty($sql3['name'])){
    		$city = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $sql3['name']);
    	}else{
    		$city = 'unknow';
    	}
    
    	$this->db->query("INSERT INTO " . DB_PREFIX . "sendorder SET  uid = '" . $username_id . "' ,uname = '" . $usrname . "',couponid = '" . $couponid . "',usescore = '" . $usescore . "' ,oids= '" . $soids . "'  ,email = '" . $email . "' ,consignee = '" . $lastname . "' ,country = '" . $country . "' ,customsfee=8,city = '" . $city . "' ,zip = '" . $postcode . "' ,tel = '" . $tel . "' ,address = '" . $address . "' ,remark = '".$remark."', deliveryname='" . $deliveryname . "', did= '" . (int)$did . "',countweight = '" . $all_weight . "' ,freight = '" . $freight . "',totalfee='" . $over_yunfei . "' ,serverfee = '" . $serverfee . "',wrapperfee = '" . $wrapperfee . "' ,dabao = '" . (int)$dabao . "' ,dingdan = '" . (int)$dingdan . "' ,baozhuang = '" . (int)$cailiao . "' ,zengzhi = '" . $this->db->escape($zengzhi) . "' ,state = '" . $status_id . "' ,addtime='" . time() . "',zengzhifee='" . $serverfee . "'");
    	$order_id = $this->db->getLastId();
    
    	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE   o.customer_id = '$username_id' and yundan_or=1");
    	$sql2 = $query->rows;
    	/*
    	 foreach ($sql2 as $sql) {
    	$name = $sql['name'];
    	$qty = $sql['quantity'];
    	$product_id = $sql['product_id'];
    	$order_id_1 = $sql['order_id'];
    
    	$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product`   WHERE   product_id = $product_id");
    	$sql3 = $query->row;
    
    	if ($sqls) {
    
    	$query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or =3    WHERE  order_id = " . (int) $order_id_1);  //屏蔽订单
    	}
    	}
    	}
    
    	public function insert_yundan($yundan_order) {
    
    	foreach ($yundan_order as $order_id) {
    
    	$query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or = 2   WHERE  order_id = " . (int) $order_id);
    	} */
    	return $order_id;
    }
    
    function insert_guoji_yundan($data) {

        $username_id = $data['username_id'];
        $usrname = $data['usrname'];
        $email = $data['email'];
        $soids = $data['soids'];
        $newscore = $data['newscore'];
        $deliveryname = $data['deliveryname'];
        $did       = $data['did'];
        $status_id = $data['status_id'];
        $zengzhi = $data['zengzhi'];
        $cailiao = $data['cailiao'];
        $dingdan = $data['dingdan'];
        $dabao = $data['dabao'];
        $serverfee = $data['serverfee'];
        $over_yunfei = $data['over_yunfei'];
        $all_weight = $data['all_weight'];
        $address_id = $data['address_id'];
        $freight = $data['freight'];
        $remark = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $data['remark']);
        
        /*
        if ($dabao > 0) {
            $dabao_1 = $dabao;
        } else {

            $dabao_1 = "";
        }
        if ($dingdan > 0) {
            $dingdan_1 = $dingdan;
        } else {
            $dingdan_1 = "";
        }
        if ($cailiao > 0) {
            $cailiao_1 = $cailiao;
        } else {
            $cailiao_1 = "";
        }
        if ($zengzhi > 0) {
            $zengzhi_1 = $zengzhi;
        } else {

            $zengzhi_1 = "";
        }
        */

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "address` WHERE  address_id = $address_id");
        $sql = $query->row;

        $country_id = $sql['country_id'];
        $lastname = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $sql['lastname']);
        $city_id = $sql['zone_id'];
        $postcode = $sql['postcode'];
        $tel = $sql['telephone'];
        $address_1 = $sql['address_details'];
        //$address_2 = $sql['address_2'];
        $address_join = $address_1/* . " " . $address_2*/;
        $address = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $address_join);

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country`   WHERE   country_id ='" . $country_id . "'");
        $sql2 = $query->row;

        $country = $sql2['name'];
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone`   WHERE   zone_id ='" . $city_id . "'");
        $sql3 = $query->row;
		if (isset($sql3['name'])&&!empty($sql3['name'])){
			$city = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $sql3['name']);
		}else{
			$city = 'unknow';
		}

        $this->db->query("INSERT INTO " . DB_PREFIX . "sendorder SET  uid = '" . $username_id . "' ,uname = '" . $usrname . "' ,oids= '" . $soids . "'  ,email = '" . $email . "' ,consignee = '" . $lastname . "' ,country = '" . $country . "' ,customsfee=8,city = '" . $city . "' ,zip = '" . $postcode . "' ,tel = '" . $tel . "' ,address = '" . $address . "' ,remark = '".$remark."', deliveryname='" . $deliveryname . "', did= '" . (int)$did . "',countweight = '" . $all_weight . "' ,freight = '" . $freight . "',totalfee='" . $over_yunfei . "' ,serverfee = '" . $serverfee . "' ,dabao = '" . (int)$dabao . "' ,dingdan = '" . (int)$dingdan . "' ,baozhuang = '" . (int)$cailiao . "' ,zengzhi = '" . $this->db->escape($zengzhi) . "' ,state = '" . $status_id . "' ,addtime='" . time() . "',zengzhifee='" . $serverfee . "'");
        $order_id = $this->db->getLastId();

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE   o.customer_id = '$username_id' and yundan_or=1");
        $sql2 = $query->rows;
        /*
          foreach ($sql2 as $sql) {
          $name = $sql['name'];
          $qty = $sql['quantity'];
          $product_id = $sql['product_id'];
          $order_id_1 = $sql['order_id'];

          $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "product`   WHERE   product_id = $product_id");
          $sql3 = $query->row;

          if ($sqls) {

          $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or =3    WHERE  order_id = " . (int) $order_id_1);  //屏蔽订单
          }
          }
          }

          public function insert_yundan($yundan_order) {

          foreach ($yundan_order as $order_id) {

          $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or = 2   WHERE  order_id = " . (int) $order_id);
          } */
        return $order_id;
    }

    public function insert_yundan($yundan_order) {

        foreach ($yundan_order as $order_id) {

            $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or = 2   WHERE  order_id = " . (int) $order_id);
        }
    }

}

?>
