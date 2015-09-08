<?php

class ModelAccountScorerecord extends Model {

    public function addScorerecord($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET uid = '" . (int) $this->customer->getId() . "', uname = '" . $this->db->escape($data['firstname']) . "', type = '" . (int) ($data['type']) . "', score = '" . (int) ($data['score']) . "', totalscore = '" . (int) ($data['totalscore']) . "', remark = '" . $this->db->escape($data['remark']) . "', addtime = '" . (int) ($data['addtime']) . "'");

        $sid = $this->db->getLastId();

        return $sid;
    }

    public function deleteScorerecord($sid) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "scorerecord WHERE sid = '" . (int) $sid . "'");
    }

    public function getScorerecord($data) {
        $record_query = array();

        $sql = "SELECT  * FROM " . DB_PREFIX . "scorerecord WHERE uid = '" . (int) $this->customer->getId() . "' ORDER BY sid DESC";

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }


        $record_query = $this->db->query($sql);

        return $record_query->rows;
    }

    public function getScorerecords() {

        $record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "scorerecord");

        return $record_query->rows;
    }

    public function getTotalScorerecord() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "scorerecord WHERE uid = '" . (int) $this->customer->getId() . "'");

        return $query->row['total'];
    }

}

?>