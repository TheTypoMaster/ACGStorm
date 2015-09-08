<?php

class ModelCommunityTheme extends Model {

	public function getThemes($flag=0) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "message_theme` WHERE `flag` = '" . (int)$flag . "'");

		return $query->rows;
	}

	public function getTheme($theme_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "message_theme` WHERE `flag` = 0 AND `theme_id` = '" . (int)$theme_id . "'");

		return $query->row;
	}

	public function addTheme($data) {
		$query = $this->db->query("INSERT INTO `" . DB_PREFIX . "message_theme` SET `description` = '" . $this->db->escape($data['description']) . "', `flag` = 0");
	}

	public function editTheme($theme_id, $data) {
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "message_theme` SET `description` = '" . $this->db->escape($data['description']) . "' WHERE `theme_id` = '" . (int)$theme_id . "'");
	}

	public function deleteTheme($theme_id) {
		$query = $this->db->query("UPDATE `" . DB_PREFIX . "message_theme` SET `flag` = 1 WHERE `theme_id` = '" . (int)$theme_id . "'");
	}
}