<?php

class ModelLogCustomerLogin extends Model {

    public function addInfo($customer_id = 0, $from = "") {
        $ip = $this->db->escape($this->request->server['REMOTE_ADDR']);
        $customer_id = (int) $customer_id;
        $from = $this->db->escape($from);
        $sql = "INSERT INTO " . DB_PREFIX . "log_customer_login SET customer_id=$customer_id,login_time=NOW(),ip='$ip',`from`='$from'";
        $this->db->query($sql);
    }

}
