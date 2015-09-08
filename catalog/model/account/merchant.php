<?php

class ModelAccountMerchant extends Model {

    public function addApply($data) {
        $this->db->query("INSERT INTO " . DB_PREFIX . "merchant_apply SET  uname = '" . $data['customer_name'] . "', biz_type = '" . (int) $data['biz_type'] . "', company_industry = '" . (int) $data['company_industry'] . "', website_url = '" . $this->db->escape($data['website_url']) . "', sale_mode = '" . $this->db->escape($data['loc']) . "', apply_time = '" . (int) $data['time'] . "'");
    }
}
?>