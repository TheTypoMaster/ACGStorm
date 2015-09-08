<?php

class Modelwaybilltransport extends Model {
    
    //获取单个用户的所有地址个数
    public function getaddresscount() {
        
        $query = $this->db->query("SELECT COUNT(*) as address_count FROM `" . DB_PREFIX . "address` WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        
        return $query->row['address_count'];
        
    }
    
    //获取单个用户的所有收货地址    
    public function getaddress($username_id) {
        
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "address` a LEFT JOIN " . DB_PREFIX . "country c ON (a.country_id = c.country_id)  WHERE  a.customer_id =$username_id ");
        
        return $query->rows;
    }
    
    //通过区域id获取国家名称
    public function getcountrybycid($country_id) {
        
        $query = $this->db->query("SELECT name as country FROM `" . DB_PREFIX . "country`  WHERE  country_id = $country_id");
        
        return $query->row['country'];
    }
    
    //通过区域id获取城市名称
    public function getcitybyzid($zone_id) {
        
        $query = $this->db->query("SELECT name as city FROM `" . DB_PREFIX . "zone`  WHERE  zone_id = $zone_id");
        
        return $query->row['city'];
    }
    
    //通过id获取收货地址信息
    public function getaddressbyaid($address_id) {
        
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "address`  WHERE  address_id =$address_id ");
        
        return $query->row;
    }
    
    public function getareaid($address_id) {
        
        $query = $this->db->query("SELECT  areaid AS area_id FROM `" . DB_PREFIX . "country` oc LEFT JOIN " . DB_PREFIX . "address oa ON (oc.country_id = oa.country_id) WHERE  oa.address_id = " . (int)$address_id);
        
        return $query->row['area_id'];
        
    }
    
    //获取区域可匹配的快递运输信息
    public function getdelivery($data) {
        
        $query = $this->db->query("SELECT  areaid AS area_id FROM `" . DB_PREFIX . "country` oc LEFT JOIN " . DB_PREFIX . "address oa ON (oc.country_id = oa.country_id) WHERE  oa.address_id = " . (int)$data['address_id']);
       
        if (!empty($query)){
            
            $area_id = $query->row['area_id'];
    
            if (!$data['sensitive'] || 6 == $area_id) {
                
                if(!$data['brand'] || 6 == $area_id) {
                    
                    if ($area_id) {
                        
                       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid =" .  (int)$area_id . " AND `state` = 1 AND `shield` = 1");
                       
                    } else {
                        
                       $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid ='14' AND `state` = 1 AND `shield` = 1");
                    }
                    
                }else{
                    
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','DHL品牌价') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");
                    
                }
                
                         
            } else {

                if(15 == $area_id || 17 == $area_id) {

                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','新马专线') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");     
                 
                }else if(8 == $area_id && !$data['brand'] ){
				
					  $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','澳洲精选线') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");
					  
				}
				else{

                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");

                }
     
            }
            
         return $query->rows;
	  }
      
    }
    
    //通过did areaid获取运输信息
    public function getdeliverybyid($data) {
        
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid =" .  (int)$data['areaid'] . " AND did =" . (int)$data['did'] ." AND `state` = 1");
        
        return $query->row;
    }
    
    //通过订单号获取总重量
    public function gettotalweight($order_id_array){
        
        $total_weight = 0.00;
        
        foreach($order_id_array as $order_id) {
            
            $query = $this->db->query("SELECT  SUM(weight) as  weight FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");
            
            $total_weight += $query->row['weight'];
        }
        
        return $total_weight;
            
    }
    
    //通过订单号获取总费用
    public function getTotalByoid($order_str) {
        
    	$query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_id IN (" . $order_str . ")");
    	
    	return $query->row['total'];
    }
    
    //准备提交运送
    public function updateshipping_order($order_id_array,$flag) {
    
        if(is_array($order_id_array)) {
            foreach ($order_id_array as $order_id) {
            
                $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET  yundan_or = ".  (int)$flag  ."  WHERE  order_id = " . (int) $order_id);
            }
        }else{
            
            $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET  yundan_or = ".  (int)$flag  ."  WHERE  order_id = " . (int) $order_id_array);
        }
        
    }
    
    //获取准备发货的订单
    public function getshipping_order() {
        
        $query = $this->db->query("SELECT  order_id  FROM `" . DB_PREFIX . "order`  WHERE  order_status_id = 6  AND yundan_or = 2  AND customer_id = '" . (int)$this->customer->getId() . "'");
        
        return $query->rows;
        
    }
    
    //获取准备发货订单的商品信息
    public function getshipping_order_product($order_id) {
        
        $query = $this->db->query("SELECT  order_product_id, producturl,name,img,option_color,option_size,weight,order_sensitive,order_branding,order_huge  FROM `" . DB_PREFIX . "order_product`  WHERE  order_id = '" . (int)$order_id . "'");
        
        return $query->rows;
        
    }
    
    public function getsensitive($order_id) {
        
        $query = $this->db->query("SELECT order_sensitive  FROM `" . DB_PREFIX . "order_product`  WHERE  order_id = '" . (int)$order_id . "'");
 
        return $query->rows;
    }
    
    //提交运单，插入运单数据
    public function addsendorder($data) { 

        $this->db->query("INSERT INTO " . DB_PREFIX . "sendorder SET  uid = '" . (int)$data['uid'] . "' ,uname = '" . $this->db->escape($data['uname']) . "' ,consignee = '" . $this->db->escape($data['consignee']) . "'  ,email = '" . $this->db->escape($data['email']) .  "' ,oids= '" . $this->db->escape($data['oids'])  . "'  ,freight = '" . (float)$data['freight'] . "' ,serverfee = '" . (float)$data['serverfee'] . "' ,wrapperfee = '" . (float)$data['wrapperfee'] . "' ,customsfee =  '" . (float)$data['customsfee'] . "' ,totalfee = '" . (float)$data['totalfee'] . "' ,oldtotalfee = '" . (float)$data['oldtotalfee'] . "' ,country = '" . $this->db->escape($data['country']) . "' ,city = '" . $this->db->escape($data['city']) . "', zip='" . $this->db->escape($data['zip']) . "', tel= '" . $this->db->escape($data['tel']) . "',address= '" . $this->db->escape(oc_filter($data['address'])) . "' ,did = '" . (int)$data['did'] . "',deliveryname ='" . $this->db->escape($data['deliveryname']) . "' ,countweight = '" . (float)$data['countweight'] . "' ,pak_free = '" . (int)$data['pak_free'] . "' ,dabao = '" . (int)$data['dabao'] . "' ,dingdan = '" . (int)$data['dingdan'] . "' ,zengzhi = '" . $this->db->escape($data['zengzhi']) . "' ,baozhuang = '" . (int)$data['baozhuang'] . "',state='" . (int)$data['state'] . "',dabaofee='" . (float)$data['dabaofee'] . "',dingdanfee='" . (float)$data['dingdanfee'] . "',zengzhifee='" . (float)$data['zengzhifee'] . "',donation='" . (float)$data['donation'] . "' ,addtime='" . time() .  "'");
       
        $sendorder_id = $this->db->getLastId();

        return $sendorder_id;
    }
    
    //删除运单
    public function delsendorder($sid) {
        
        $this->db->query("DELETE  FROM " . DB_PREFIX . "sendorder  WHERE  sid = '" . (int)$sid . "'");
  
    }
    
    
    //更新运单优惠卷内容
    public function updatecouponbysid($data) {
        
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder` SET  couponid = ".  (int)$data['couponid']  ."  WHERE  sid = " . (int)$data['sid']);
    }
    
    //更新运单积分内容
    public function updatescorebysid($data) {
        
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder` SET  usescore = ".  (float)$data['usescore']  ."  WHERE  sid = " . (int)$data['sid']);
    }
    
    
    //更新运单备注内容
    public function updateremarkbysid($data) {
        
        $data['remark'] = str_replace(array("\t", '<', '>', "\r", "\n", "'", '  '), array('', '&lt;', '&gt;', '', '', '', '&nbsp; '), $data['remark']);
        
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder` SET  remark = '".  $this->db->escape($data['remark'])  ."'  WHERE  sid = " . (int)$data['sid']);
    }
    
    //更新运单金额
    public function updatetotalfeebysid($data) {
        
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder` SET  totalfee = ".  (float)$data['totalfee']  ."  WHERE  sid = " . (int)$data['sid']);
    }
    
    //获取运单金额
    public function gettotalfeebysid($sid) {
        
        $query = $this->db->query("SELECT  totalfee as totalfee  FROM `" . DB_PREFIX . "sendorder`  WHERE  sid = '" . (int)$sid . "'");
        
        return $query->row['totalfee'];
    }
    
    //获取运单中订单
    public function getoidsbysid($sid) {
        
        $query = $this->db->query("SELECT  oids as oids  FROM `" . DB_PREFIX . "sendorder`  WHERE  sid = '" . (int)$sid . "'");
        
        return $query->row['oids'];
        
    }
    
    //获取运单内容
    public function getsendorderbysid($sid) {
        
        $query = $this->db->query("SELECT  *  FROM `" . DB_PREFIX . "sendorder`  WHERE  sid = '" . (int)$sid . "'");
        
        return $query->row;
        
    }


}

?>
