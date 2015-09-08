<?php
class ModelReportProduct extends Model {
	public function getProductsViewed($data = array()) {
		$sql = "SELECT pd.name, p.model, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.viewed > 0 ORDER BY p.viewed DESC";

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

	public function getTotalProductsViewed() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE viewed > 0");

		return $query->row['total'];
	}

	public function getTotalProductViews() {
		$query = $this->db->query("SELECT SUM(viewed) AS total FROM " . DB_PREFIX . "product");

		return $query->row['total'];
	}

	public function reset() {
		$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = '0'");
	}

	public function getPurchased($data = array()) {
		$sql = "SELECT op.name, op.producturl, SUM(op.quantity) AS quantity, SUM(op.total) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '1' AND o.order_status_buy = '1' ";

		if (!empty($data['filter_source'])) {
			$sql .= " AND op.source = '" . $this->db->escape($data['filter_source']) . "'";
		} else {
            $sql .= " AND op.source = '0' ";
		}
          
        if (!empty($data['filter_order_come'])) {
			$sql .= " AND o.store_id =  '" .  $this->db->escape($data['filter_order_come']) . "'";
		} else {
		    $sql .= " AND o.store_id = '0' " ;
		} 
         
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$sql .= " GROUP BY op.producturl ORDER BY total DESC";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        
        //var_dump($sql);

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalPurchased($data) {
		$sql = "SELECT COUNT(DISTINCT op.producturl) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '1' AND o.order_status_buy = '1' ";

		if (!empty($data['filter_source'])) {
			$sql .= " AND op.source = '" . $this->db->escape($data['filter_source']) . "'";
		} else {
            $sql .= " AND op.source = '0' ";
		}
          
        if (!empty($data['filter_order_come'])) {
			$sql .= " AND o.store_id =  '" .  $this->db->escape($data['filter_order_come']) . "'";
		} else {
		    $sql .= " AND o.store_id = '0' " ;
		} 

		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);
        
        //var_dump($query->row['total']);

		return $query->row['total'];
	}
	
	public function getTotalByType($type,$come) {
		$sql = "SELECT COUNT(DISTINCT op.producturl) AS total FROM `" . DB_PREFIX . "order_product` op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) WHERE o.order_status_id > '1' AND o.order_status_buy = '". $type ."' AND o.store_id = '". $come ."' ";
		$query = $this->db->query($sql);
		return $query->row['total'];
	}
}
?>