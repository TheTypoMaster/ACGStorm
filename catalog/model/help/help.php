<?php

class ModelHelpHelp extends Model {

	public function getCategories($pid) {
		$sql = "SELECT * FROM " . DB_PREFIX . "help_category WHERE 1 ";
		if (isset($pid)) 
			$sql .= "AND `pid` = '" . (int)$pid . "' ";
		$sql .= "ORDER BY `sort`,`name`";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getCategory($id) {
		$sql = "SELECT * FROM " . DB_PREFIX . "help_category WHERE help_category_id = '" . (int)$id . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getQuestions($cid) {
		// $sql = "SELECT * FROM " . DB_PREFIX . "help_question WHERE help_category_id = '" . (int)$cid . "' ";
		$sql = "SELECT * FROM " . DB_PREFIX . "help_question WHERE help_category_id = '" . (int)$cid . "' OR help_category_id IN (SELECT help_category_id FROM " . DB_PREFIX . "help_category WHERE pid = '" . (int)$cid . "')";
		$sql .= "ORDER BY `sort`,`name`";

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function NewgetQuestion($cid) {
		$sql = "(SELECT help_question_id,help_category_id,name FROM " . DB_PREFIX . "help_question WHERE help_category_id in (" . $cid . "))";
		$sql .= "ORDER BY `sort`,`name`";
		$query = $this->db->query($sql);
		return $query->rows;

	}
	
	public function likeTitle($key){
		$sql='SELECT help_question_id,help_category_id,name  FROM oc_help_question WHERE NAME LIKE "%'.$key.'%"';
		$query = $this->db->query($sql);
		return $query->rows;
	}
	
	public function getQuestion($qid) {
		$sql = "SELECT * FROM " . DB_PREFIX . "help_question WHERE help_question_id = '" . (int)$qid . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}

	public function getBulletins($type=0) {
		if ($type == 0) 
			$sql = "SELECT * FROM " . DB_PREFIX . "bulletin where display=1  ORDER BY `sort`,`name`";
		else 
			$sql = "SELECT * FROM " . DB_PREFIX . "bulletin WHERE display=1  and `type` = '" . (int)$type . "' or `type`=3 ORDER BY `sort`,`name`";

		$query = $this->db->query($sql);

		return $query->rows;
	}
    
    public function getHomeBulletins() {

		$sql = "SELECT * FROM " . DB_PREFIX . "bulletin WHERE  display=1 and `type` = 2 OR `type` = 3 ORDER BY `sort`,`name` limit 4";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getBulletin($bid) {
		$sql = "SELECT * FROM " . DB_PREFIX . "bulletin WHERE bulletin_id = '" . (int)$bid . "'";

		$query = $this->db->query($sql);

		return $query->row;
	}
}