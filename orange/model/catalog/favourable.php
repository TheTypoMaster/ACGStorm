<?php
class ModelCatalogFavourable extends Model {
	public function addFavourable($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "favourable SET name = '" . $this->db->escape($data['name']) . "', sort = '" . (int)$data['sort'] . "' , url = '" . $data['url'] . "', source = '" . $data['source'] . "' , add_time = '" . time() . "', des = '" . $data['describe'] . "',discount_type='".$data['discount_type']."',discount='".$data['discount']."',max='".$data['max']."',min='".$data['min']."',starttime='".$data['starttime']."',endtime='".$data['endtime']."'");
		$favourable_id = $this->db->getLastId();
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "favourable SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE favourable_id = '" . (int)$favourable_id . "'");
		}
		$this->cache->delete('favourable');
	}

	public function editFavourable($favourable_id, $data) {
		if($data['discount_type']==1){
			$data['max']='';
			$data['min']='';
		}
		$this->db->query("UPDATE " . DB_PREFIX . "favourable SET name = '" . $this->db->escape($data['name']) . "', sort = '" . (int)$data['sort'] . "', url = '" . $data['url'] . "', source = '" . $data['source'] . "' , add_time = '" . time() . "', des = '" . $data['describe'] . "',discount_type='".$data['discount_type']."',max='".$data['max']."',min='".$data['min']."',starttime='". $data['starttime']."' ,endtime='".$data['endtime']."' ,discount='".$data['discount']."'  WHERE favourable_id = '" . (int)$favourable_id . "'");
		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "favourable SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE favourable_id = '" . (int)$favourable_id . "'");
		}
		$this->cache->delete('favourable');
	}

	public function deleteFavourable($favourable_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "favourable WHERE favourable_id = '" . (int)$favourable_id . "'");
		$this->cache->delete('favourable');
	}	

	public function getFavourable($favourable_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "favourable WHERE favourable_id = '" . (int)$favourable_id . "'");
		return $query->row;
	}

	public function getFavourables($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "favourable";
		if (!empty($data['filter_name'])) {
			$sql .= " WHERE name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}
		$sort_data = array(
			'name',
			'sort'
		);	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY name";	
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
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}				
		$query = $this->db->query($sql);
		return $query->rows;
	}

	public function getTotalFavourables() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "favourable");
		return $query->row['total'];
	}	
}
?>