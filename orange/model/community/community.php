<?php

class ModelCommunityCommunity extends Model {

    public function getComments($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder`";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE uname='" . $data['uname'] . "' AND comment is not null AND comment<>''";
        } else {
            $sql .=" WHERE comment is not null AND comment<>''";
        }

        $sort_data = array(
            'sid',
            'uname',
            'commenttime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY commenttime";
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

    public function totalComments() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sendorder WHERE comment is not null AND comment<>''");

        return $query->row['total'];
    }

    public function showComments($state, $sid) {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET showcomment=" . $state . " WHERE sid=" . $sid);
    }
    
    public function commentState($sid) {
    $query2 = $this->db->query("SELECT showcomment FROM " . DB_PREFIX . "sendorder WHERE sid=" . $sid);
        return $query2->row['showcomment'];
    }
    
    public function replyComments($msg, $sid) {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET reply='" . $msg . "' WHERE sid=" . $sid);
    }

}

?>