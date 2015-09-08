<?php
class ModelSettingHelp extends Model {

	public function getTotalCategories() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "help_category");

		return $query->row['total'];
	}

	public function getCategories($data) {
		// $sql = "SELECT * FROM " . DB_PREFIX . "help_category WHERE 1=1 ";
		$sql = "SELECT if(isnull(p.`name`),c.`name`,group_concat(p.`name`,' &gt; ',c.`name`)) as rname,c.* FROM " . DB_PREFIX . "help_category c left join " . DB_PREFIX . "help_category p on c.`pid`=p.`help_category_id` WHERE 1 ";
		if (isset($data['filter_name']))
			$sql .= "AND c.name like '%" . $this->db->escape($data['filter_name']) . "%'";
		if (isset($data['parent_id']))
			$sql .= " AND c.pid = " . (int)$data['parent_id'];

		$sql .= " group by c.`help_category_id` order by `rname`";

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

	public function addCategory($data) {
		$pid = array_key_exists('parent_id', $data) ? $data['parent_id'] : 0;
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		if (array_key_exists('path', $data)) {
			if ($data['path'] == '') {
				$pid = 0;
			}
		}

		$sql = "INSERT INTO " . DB_PREFIX . "help_category SET `pid` = '" . (int)$pid . "', `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', date_added = NOW(), date_modified = NOW()";

		$this->db->query($sql);
	}

	public function getCategory($category_id) {
		$query = $this->db->query("SELECT c.*, p.name as `path` FROM " . DB_PREFIX . "help_category c left join " . DB_PREFIX . "help_category p on c.pid = p.help_category_id WHERE c.`help_category_id` = '" . (int)$category_id . "'");

		return $query->row;
	}

	public function getQuestionByCategoryId($category_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "help_question` WHERE `help_category_id` = '" . (int)$category_id . "'");
		return $query->row;
	}

	public function editCategory($category_id, $data) {
		$pid = array_key_exists('parent_id', $data) ? $data['parent_id'] : 0;
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		if (array_key_exists('path', $data)) {
			if ($data['path'] == '') {
				$pid = 0;
			}
		}

		$sql = "UPDATE " . DB_PREFIX . "help_category SET `pid` = '" . (int)$pid . "', `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', date_modified = NOW() WHERE `help_category_id` = '" . (int)$category_id . "'";

		$this->db->query($sql);
	}

	public function deleteCategory($category_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "help_category WHERE `help_category_id` = '" . (int)$category_id . "' OR `pid` = '" . (int)$category_id . "'";
		$this->db->query($sql);
	}

	public function getTotalQuestions() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "help_question");

		return $query->row['total'];
	}

	public function getQuestions($data) {
		$sql = "SELECT * FROM " . DB_PREFIX . "help_question ";
		
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

	public function getQuestion($question_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "help_question WHERE help_question_id = '" . (int)$question_id . "'");

		return $query->row;
	}


	
	public function addQuestion($data) {
		$category_id = array_key_exists('category_id', $data) ? $data['category_id'] : 0;
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		$content = array_key_exists('content', $data) ? $data['content'] : '';
		$social = array_key_exists('social', $data) ? $data['social'] : 0;

		$sql = "INSERT INTO " . DB_PREFIX . "help_question SET `help_category_id` = '" . (int)$category_id . "', `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', content = '" . $this->db->escape($content) . "', `social` = '" . (int)$social . "', date_added = NOW(), date_modified = NOW()";

		$this->db->query($sql);
	}

	public function editQuestion($question_id, $data) {
		$category_id = array_key_exists('category_id', $data) ? $data['category_id'] : 0;
		$sort = array_key_exists('sort_order', $data) ? $data['sort_order'] : 0;
		$content = array_key_exists('content', $data) ? $data['content'] : '';
		$social = array_key_exists('social', $data) ? $data['social'] : 0;

		$sql = "UPDATE " . DB_PREFIX . "help_question SET `help_category_id` = '" . (int)$category_id . "', `name` = '" . $this->db->escape($data['name']) . "', `sort` = '" . (int)$sort . "', content = '" . $this->db->escape($content) . "', `social` = '" . (int)$social . "', date_modified = NOW() WHERE `help_question_id` = '" . (int)$question_id . "'";

		$this->db->query($sql);
	}

	public function deleteQuestion($question_id) {
		$sql = "DELETE FROM " . DB_PREFIX . "help_question WHERE `help_question_id` = '" . (int)$question_id . "'";
		$this->db->query($sql);
	}
}