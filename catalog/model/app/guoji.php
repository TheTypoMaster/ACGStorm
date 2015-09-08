<?php

class ModelAppGuoji extends Model {

    public function address_yundan($area_id, $mingan) {
    if ($mingan == 1 ||  6 == $area_id) {
        if ($area_id) {
                    
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid =" .  (int)$area_id . " AND `state` = 1 AND `shield` = 1");
                    
        } else {
                    
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid ='14' AND `state` = 1 AND `shield` = 1");
                    
        }
    } else {
        if(15 == $area_id || 17 == $area_id) {
                    
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','新马专线') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");
                    
        }else{   
                    
            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR','DHL品牌价') AND areaid =" . (int)$area_id . " AND state = 1 AND `shield` = 1");
                    
        }
                   
    }
        return $query->rows;
    }

    public function update_status($order_id, $order_status_id, $customer_email, $customer_name) {
        if(is_array($order_id))
        {
            foreach($order_id as $order_id_signal)
            {
                 $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $order_status_id . "' WHERE order_id = '" . (int) $order_id_signal . "'");
            }
        }
        else
        {
             $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $order_status_id . "' WHERE order_id = '" . (int) $order_id . "'");
        }
        $this->cart->clear();
    }
}