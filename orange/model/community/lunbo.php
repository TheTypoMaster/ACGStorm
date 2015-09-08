<?php

class ModelCommunityLunbo extends Model {

	public function getLunbos($flag=0,$type) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "lunbo_pic` WHERE `flag` = '" . (int)$flag . "' AND `type` = '". (int)$type ."' ORDER BY sort");

		return $query->rows;
	}

	public function getLunbo($lunbo_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "lunbo_pic` WHERE `flag` = 0 AND `id` = '" . (int)$lunbo_id . "'");

		return $query->row;
	}

	public function getTotalLunboByTR() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "lunbo_pic` WHERE `type` = 2");
		return $query->row;
	}

	public function addLunbo($data,$type) {
		$query = $this->db->query("INSERT INTO `" . DB_PREFIX . "lunbo_pic` SET `name` = '" . $this->db->escape($data['name']) . "', `url` = '" . $this->db->escape($data['url']) . "', `image` = '" . $this->db->escape($data['image']) . "', `sort` = '" . (int)$data['sort_order'] . "', `flag` = 0,`type` = '".(int)$type."' ,`price` = '".$data['price']."'");
		$lunbo_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "lunbo_pic SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$lunbo_id . "'");
		}
	}

	public function editLunbo($lunbo_id, $data) {
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "lunbo_pic` SET `name` = '" . $this->db->escape($data['name']) . "', `url` = '" . $this->db->escape($data['url']) . "', `image` = '" . $this->db->escape($data['image']) . "', `sort` = '" . (int)$data['sort_order'] . "' ,`price` = '".$data['price']."' WHERE `id` = '" . (int)$lunbo_id . "'");
		$lunbo_id = $this->db->getLastId();

		if (isset($data['image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "lunbo_pic SET image = '" . $this->db->escape(html_entity_decode($data['image'], ENT_QUOTES, 'UTF-8')) . "' WHERE id = '" . (int)$lunbo_id . "'");
		}
	}

	public function deleteLunbo($lunbo_id,$type) {
		$query = $this->db->query("DELETE FROM `" . DB_PREFIX . "lunbo_pic` WHERE `id` = '" . (int)$lunbo_id . "' AND `type` = '". (int)$type ."'");
	}
}