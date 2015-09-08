<?php

class ModelInteractionInteraction extends Model {

    public function getMerchantApply($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "merchant_apply`";
        
        if(isset($data['uname']) && !is_null($data['uname'])){
        	$sql .=" WHERE uname='".$data['uname']."'";
        }

        $sort_data = array(
            'aid',
            'biz_type',
            'apply_time'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY aid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getPms($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "pm`";
        
        if(isset($data['uname']) && !is_null($data['uname'])){
        	$sql .=" WHERE fromuname='".$data['uname']."'";
        }

        $sort_data = array(
            'mid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY mid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function totalPms() {

        $query = $this->db->query("SELECT count(mid) as a FROM `" . DB_PREFIX . "pm` ");
        $a = $query->rows;

        return $a[0]['a'];
    }
    
    public function totalMerchantApply() {

        $query = $this->db->query("SELECT count(aid) as a FROM `" . DB_PREFIX . "merchant_apply` ");
        $a = $query->rows;

        return $a[0]['a'];
    }
    
	public function getFirstUname($q){
		$query = $this->db->query("SELECT distinct fromuname FROM `" . DB_PREFIX . "pm` WHERE fromuname LIKE '%M" . addslashes(html_entity_decode($q)) ."%' ESCAPE 'M' limit 25");

        return $query->rows;
	}

	public function getUname($q){
		$query = $this->db->query("SELECT distinct uname FROM `" . DB_PREFIX . "guestbook` WHERE uname LIKE '%M" . addslashes(html_entity_decode($q)) ."%' ESCAPE 'M' limit 25");

        return $query->rows;
	}

        public function replyPm($data) {
    
    	$this->db->query("INSERT INTO `" . DB_PREFIX . "pm` SET fromuid = 0, fromuname= '".$data['fromuname'] ."', touid='". $data['touid'] . "', touname='". $data['touname'] . "', type=1, hasview=0, subject='". $data['subject'] . "', message='". $data['message'] . "', sendtime='".time()."',writetime='".time()."'" );

        return $this->db->getLastId();
    }
    
    public function getConsults($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "guestbook`";
        
        if(isset($data['uname']) && !is_null($data['uname'])){
        	$sql .=" WHERE uname='".$data['uname']."'";
        }

        $sort_data = array(
            'gid',
            'type',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY gid";
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

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function totalConsults() {

        $query = $this->db->query("SELECT count(gid) as a FROM `" . DB_PREFIX . "guestbook` ");
        $a = $query->rows;

        return $a[0]['a'];
    }
    
    public function replyConsult($reply_gid, $reply_msg) {
    
    	$this->db->query("UPDATE `" . DB_PREFIX . "guestbook` SET state=1, reply = '" . $reply_msg . "' WHERE gid = '" . (int) $reply_gid . "'");
    
    }

    public function getConsult($gid) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "guestbook` WHERE gid = '" . (int)$gid . "'");
        return $query->row;
    }

    public function getPm($mid) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "pm` WHERE mid = '" . (int)$mid . "'");
        return $query->row;
    }

}

?>