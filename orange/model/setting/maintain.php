<?php
class ModelSettingMaintain extends Model {

	public function getTotalAreas() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "dg_area WHERE `state` = 1");

		return $query->row['total'];
	}

	public function getAreas($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "dg_area WHERE `state` = 1 ORDER BY `listorder`, `aid` DESC ";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getAreasIN() {
		$sql = "SELECT `aid`,`name_cn` FROM `" . DB_PREFIX . "dg_area` WHERE `state` = 1 ORDER BY `aid` DESC ";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function addArea($data) {
		$listorder = array_key_exists('listorder', $data) ? $data['listorder'] : 0;

		$sql = "INSERT INTO " . DB_PREFIX . "dg_area SET `name_cn` = '" . $this->db->escape($data['name_cn']) . "', `name_en` = '" . $this->db->escape($data['name_en']) . "', `serverfeepct` = '" . $this->db->escape($data['serverfeepct']) . "', `serverfee` = '" . $this->db->escape($data['serverfee']) . "', `listorder` = '" . (int)$listorder . "'";

		$this->db->query($sql);
	}

	public function getArea($aid) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_area WHERE `aid` = '" . (int)$aid . "'");

		return $query->row;
	}

	public function getDeliveryByAreaId($aid) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "dg_delivery` WHERE `areaid` = '" . (int)$aid . "'");
		return $query->row;
	}

	public function editArea($aid, $data) {
		$sql = "UPDATE " . DB_PREFIX . "dg_area SET `name_cn` = '" . $this->db->escape($data['name_cn']) . "', `name_en` = '" . $this->db->escape($data['name_en']) . "', `serverfeepct` = '" . $this->db->escape($data['serverfeepct']) . "', `serverfee` = '" . $this->db->escape($data['serverfee']) . "', `listorder` = '" . (int)$listorder . "' WHERE `aid` = '" . (int)$aid . "'";

		$this->db->query($sql);
	}

	public function deleteArea($aid) {
		$sql = "UPDATE " . DB_PREFIX . "dg_area SET `state` = 0 WHERE `aid` = '" . (int)$aid . "'";
		$this->db->query($sql);
	}

	public function getTotalDeliveries() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "dg_delivery WHERE `state` = 1");

		return $query->row['total'];
	}

	public function getDeliveries($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE `state` = 1 ORDER BY `areaid` DESC ";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getDelivery($did) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE did = '" . (int)$did . "'");

		return $query->row;
	}

	public function addDelivery($data) {
		$sql = "INSERT INTO " . DB_PREFIX . "dg_delivery SET `areaid` = '" . (int)$this->db->escape($data['areaid']) . "', `areaname` = '" . $this->db->escape($data['areaname']) . 
			"', `serverfee` = '" . (float)$this->db->escape($data['serverfee']) . "', `deliveryname` = '" . $this->db->escape($data['deliveryname']) . 
			"', `delivery_time` = '" . $this->db->escape($data['delivery_time']) . "', `senddate` = '" . time() . "', `queryurl` = '" . $this->db->escape($data['queryurl']) . 
			"', `carrierLogo` = '" . $this->db->escape($data['carrierLogo']) . "', `carrierDesc` = '" . $this->db->escape($data['carrierDesc']) . 
			"', `first_weight` = '" . (float)$this->db->escape($data['first_weight']) . "', `continue_weight` = '" . (float)$this->db->escape($data['continue_weight']) . 
			"', `first_fee` = '" . (float)$this->db->escape($data['first_fee']) . "', `continue_fee` = '" . (float)$this->db->escape($data['continue_fee']) . 
			"', `fuel_fee` = '" . (float)$this->db->escape($data['fuel_fee']) . "', `customs_fee` = '" . (float)$this->db->escape($data['customs_fee']) . 
			"', `state` = 1, `deliveryimg` = '" . $this->db->escape($data['deliveryimg']) . "'";

		$this->db->query($sql);
	}

	public function editDelivery($did, $data) {
		$sql = "UPDATE " . DB_PREFIX . "dg_delivery SET `areaid` = '" . (int)$this->db->escape($data['areaid']) . "', `areaname` = '" . $this->db->escape($data['areaname']) . 
			"', `serverfee` = '" . (float)$this->db->escape($data['serverfee']) . "', `deliveryname` = '" . $this->db->escape($data['deliveryname']) . 
			"', `delivery_time` = '" . $this->db->escape($data['delivery_time']) . "', `senddate` = '" . time() . "', `queryurl` = '" . $this->db->escape($data['queryurl']) . 
			"', `carrierLogo` = '" . $this->db->escape($data['carrierLogo']) . "', `carrierDesc` = '" . $this->db->escape($data['carrierDesc']) . 
			"', `first_weight` = '" . (float)$this->db->escape($data['first_weight']) . "', `continue_weight` = '" . (float)$this->db->escape($data['continue_weight']) . 
			"', `first_fee` = '" . (float)$this->db->escape($data['first_fee']) . "', `continue_fee` = '" . (float)$this->db->escape($data['continue_fee']) . 
			"', `fuel_fee` = '" . (float)$this->db->escape($data['fuel_fee']) . "', `customs_fee` = '" . (float)$this->db->escape($data['customs_fee']) . 
			"', `state` = 1, `deliveryimg` = '" . $this->db->escape($data['deliveryimg']) . "' WHERE `did` = '" . (int)$did . "'";
		$this->db->query($sql);
	}

	public function deleteDelivery($did) {
		$sql = "UPDATE " . DB_PREFIX . "dg_delivery SET `state` = 0 WHERE `did` = '" . (int)$did . "'";
		$this->db->query($sql);
	}
    
    public function updateshield($did) {
		
        $query  = $this->db->query("SELECT shield FROM " . DB_PREFIX . "dg_delivery  WHERE `did` = '" . (int)$did . "'");
        
        $shield = $query->row['shield'];
        
        if($shield) {
            
            $this->db->query("UPDATE " . DB_PREFIX . "dg_delivery SET `shield` = 0 WHERE `did` = '" . (int)$did . "'");
            
        }else{
            
            $this->db->query("UPDATE " . DB_PREFIX . "dg_delivery SET `shield` = 1 WHERE `did` = '" . (int)$did . "'");
        }

	}
    
}