<?php

class ModelAccountPm extends Model {

    public function addPm($data) {

        $this->db->query("INSERT INTO " . DB_PREFIX . "pm SET fromuid = '" . (int) $data['fromuid'] . "', fromuname = '" . $this->db->escape($data['fromuname']) . "', touid = '" . (int) ($data['touid']) . "', touname = '" . $this->db->escape($data['touname']) . "', type = '" . (int) ($data['type']) . "', subject = '" . $this->db->escape($data['subject']) . "', sendtime = '" . (int) ($data['sendtime']) . "', writetime = '" . (int) ($data['writetime']) . "', hasview = '" . (int) ($data['hasview']) . "', isadmin = '" . (int) ($data['isadmin']) . "', message = '" . $this->db->escape($data['message']) . "'");

        $mid = $this->db->getLastId();

        return $mid;
    }

    public function deletePm($mid) {
        $this->db->query("DELETE FROM " . DB_PREFIX . "pm WHERE mid = '" . (int) $mid . "'");
    }

    public function updatePm($mid) {
        $this->db->query("UPDATE `" . DB_PREFIX . "pm` SET hasview = 1 WHERE mid = '" . (int) $mid . "'");
    }

    public function getPm($type) {
        if (3 == $type)
            $record_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $this->customer->getId() . "'");
        else
            $record_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $this->customer->getId() . "' AND type = '" . (int) $type . "'");

        return $record_query->rows;
    }

    public function getPm2($mid) {

        $record_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "pm WHERE mid = '" . (int) $mid . "'");

        return $record_query->rows;
    }

    public function getPm3($fromuid, $formid) {

        $record_query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "pm WHERE fromuid = '" . (int) $fromuid . "' AND writetime='" . (int) $formid . "'");

        return $record_query->rows;
    }

    public function getPms() {

        $record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "pm");

        return $record_query->rows;
    }

    public function getTotalPm($type) {
        if (3 == $type)
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $this->customer->getId() . "'");
        else
            $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $this->customer->getId() . "' AND type = '" . (int) $type . "'");

        return $query->row['total'];
    }
    
    public function getTotalPmNoView() {
    	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "pm WHERE touid = '" . (int) $this->customer->getId() . "' AND hasview = 0 ");
    	return $query->row['total'];
    }

    public function getFaceAndVerification(){
    	$query = $this->db->query("SELECT face,verification FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $this->customer->getId() . "'");
    	return $query->row;
    }

}

?>