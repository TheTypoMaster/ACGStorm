<?php
class ModelSettingBulletin extends Model {

	public function getTotalBulletins() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "bulletin");

		return $query->row['total'];
	}

	public function getBulletins($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "bulletin ";
		
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

	public function getBulletin($bulletin_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "bulletin WHERE bulletin_id = '" . (int)$bulletin_id . "'");

		return $query->row;
	}

	public function addBulletin($data) {
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		$content = array_key_exists('content', $data) ? $data['content'] : '';
		$type = array_key_exists('type', $data) ? $data['type'] : 0;

		$sql = "INSERT INTO " . DB_PREFIX . "bulletin SET `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', content = '" . $this->db->escape($content) . "', type = '" . (int)$type . "', date_added = NOW(), date_modified = NOW(),display=".(int)$data['display'];

		$this->db->query($sql);
	}

	public function editBulletin($bulletin_id, $data) {
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		$content = array_key_exists('content', $data) ? $data['content'] : '';
		$type = array_key_exists('type', $data) ? $data['type'] : 0;

		$sql = "UPDATE " . DB_PREFIX . "bulletin SET `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', content = '" . $this->db->escape($content) . "', type = '" . (int)$type . "', date_modified = NOW(),display=".$data['display']." WHERE `bulletin_id` = " . (int)$bulletin_id ;

		$this->db->query($sql);
	}

	public function deleteBulletin($bulletin_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "bulletin WHERE `bulletin_id` = '" . (int)$bulletin_id . "'";
		$this->db->query($sql);
	}
	
	public function updateColor($bulletin_id,$color) {
		$sql = "UPDATE " . DB_PREFIX . "bulletin SET `color` = '" . $color . "' WHERE `bulletin_id` = '" . (int)$bulletin_id . "'";
		$this->db->query($sql);
	}
}