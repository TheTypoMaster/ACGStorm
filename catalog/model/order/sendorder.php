<?php

class ModelOrderSendorder extends Model {

    public function select_send_porduct($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data ['username_id']) && !is_null($data ['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data ['username_id'] . "'";
        }

        if ($data ['order_status_id'] >= 0) {
            $sql .= " AND o.state = '" . (int) $data ['order_status_id'] . "'";
        }

        if (!empty($data ['consignee'])) {
            $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data ['consignee']) . "%'";
        }

        $sql .= " ORDER BY sid DESC";

        if (isset($data ['start']) || isset($data ['limit'])) {
            if ($data ['start'] < 0) {
                $data ['start'] = 0;
            }

            if ($data ['limit'] < 1) {
                $data ['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data ['start'] . "," . (int) $data ['limit'];
        } else {

            $sql .= " LIMIT 20";
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function total_send_porduct($data) {
        $sql = "SELECT count(*) AS total FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data ['username_id']) && !is_null($data ['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data ['username_id'] . "'";
        }

        if (!empty($data ['order_status_id'])) {
            $sql .= " AND o.state = '" . (int) $data ['order_status_id'] . "'";
        }

        if (!empty($data ['consignee'])) {
            $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data ['consignee']) . "%'";
        }

        $query = $this->db->query($sql);
        return $query->row ['total'];
    }

    public function total_yundan_porduct($data) {
        $sql = "SELECT count(*) AS total FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data ['username_id']) && !is_null($data ['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data ['username_id'] . "'";
        }

        if ($data ['order_status_id'] >= 0) {
            $sql .= " AND o.state = '" . (int) $data ['order_status_id'] . "'";
        }

        if (!empty($data ['consignee'])) {
            $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data ['consignee']) . "%'";
        }

        $query = $this->db->query($sql);
        return $query->row ['total'];
    }

    public function addComment($data = array()) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET multyimg = '" . $data['massageImage'] . "', comment = '" . $this->db->escape($data['comment']) . "', state=8, commenttime='" . time() . "',evaluate=" . $data['evaluate'] . ",semblance=" . $data['semblance'] . ",manner=" . $data['manner'] . ",
		delivery=" . $data['delivery'] . ",efficient=" . $data['efficient'] . "	WHERE  sid = " . (int) $data['send_id']);
        $query2 = $this->db->query("SELECT uid,uname,totalfee,volumn_price FROM " . DB_PREFIX . "sendorder WHERE  sid = " . (int) $data['send_id']);
        return $query2->row;
    }

    public function Confirm($sid) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  state = 3  , confirm_receipt_time=".time()."  WHERE  sid = " . (int) $sid);
    }

    public function getComments($data) {
        $sql = "SELECT so.uname,so.country,so.comment,so.reply,c.utype,so.multyimg,c.face FROM `" . DB_PREFIX . "sendorder` so ," . DB_PREFIX . "customer c WHERE so.uname=c.firstname AND so.showcomment=1";
        $sort_data = array(
            'sid',
            'uname',
            'commenttime'
        );

        if (isset($data ['sort']) && in_array($data ['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data ['sort'];
        } else {
            $sql .= " ORDER BY commenttime";
        }

        if (isset($data ['order']) && ($data ['order'] == 'DESC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
        }

        if (isset($data ['start']) || isset($data ['limit'])) {
            if ($data ['start'] < 0) {
                $data ['start'] = 0;
            }

            if ($data ['limit'] < 1) {
                $data ['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data ['start'] . "," . (int) $data ['limit'];
        } else {

            $sql .= " LIMIT 20";
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function totalComments() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sendorder WHERE showcomment=1");

        return $query->row ['total'];
    }

    public function getSendorderById($sid) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder WHERE `sid` = " . (int) $sid);

        return $query->row;
    }

    public function getSendorderbysid($sid) {

        $query = $this->db->query("SELECT freight,countmoney FROM " . DB_PREFIX . "sendorder WHERE sid = '" . (int) $sid . "'");

        return $query->row;
    }

    public function Updatefreightbysid($freight, $sid) {

        $query = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET freight = '" . $freight . "' WHERE sid = '" . (int) $sid . "'");

        return $query;
    }

    //修改运输方式获取所有的运输方式
    public function getdeliveryinfo($data) {

        $query = $this->db->query("SELECT  areaid AS area_id FROM `" . DB_PREFIX . "country` WHERE  name = '" . $this->db->escape($data['name']) . "'");

        if (!empty($query)) {

            $area_id = $query->row['area_id'];

            if (!$data['sensitive'] || 6 == $area_id) {
                if ($area_id) {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid =" . (int) $area_id . " AND `state` = 1");
                } else {
                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE areaid ='14' AND `state` = 1");
                }
            } else {
                $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE deliveryname IN ('EMS','AIR') AND areaid =" . (int) $area_id . " AND state = 1");
            }

            return $query->rows;
        }
    }

    public function getsensitive($order_id) {

        $query = $this->db->query("SELECT order_sensitive FROM `" . DB_PREFIX . "order_product`  WHERE  order_id IN (" . $order_id . ")");

        return $query->rows;
    }

    //通过订单号获取总费用
    public function getTotalByoid($order_str) {

        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_id IN (" . $order_str . ")");

        return $query->row['total'];
    }

    //通过id获取运输方式的名称
    public function getdeliveryname($did) {

        $query = $this->db->query("SELECT deliveryname AS deliveryname FROM `" . DB_PREFIX . "dg_delivery` WHERE did = '" . (int) $did . "'");

        return $query->row['deliveryname'];
    }

    //更新运输方式id和名称
    public function updatedelivery($data) {

        $query = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET did = '" . (int) $data['did'] . "',deliveryname = '" . $data['deliveryname'] . "' WHERE sid = '" . (int) $data['sid'] . "'");

        return $query;
    }

    //更改运单总费用
    public function updatetotalfee($data) {

        $query = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET totalfee = '" . (float) $data['totalfee'] . "' WHERE sid = '" . (int) $data['sid'] . "'");

        return $query;
    }

    //获取好评率 guanzhiqiang 20150526
    public function getGoodRate() {
        $sql = "SELECT evaluate,COUNT(*)counts FROM oc_sendorder WHERE evaluate>0 GROUP BY evaluate";
        $result = $this->db->query($sql);
        $evaluate_count = 0;
        $good_evaluate_count = 0;
        foreach ($result->rows as $key => $val) {
            if (intval($val['evaluate']) > 1) {
                $good_evaluate_count += intval($val['counts']);
            }
            $evaluate_count+= intval($val['counts']);
        }
        $goodrate = round(($good_evaluate_count / $evaluate_count) * 100);

        return $goodrate;
    }

    //获取好评率详情 guanzhiqiang 20150526
    public function getGoodRateDetail() {
        //星级
        $sql = "SELECT AVG(semblance)semblance,AVG(manner)manner,AVG(delivery)delivery,AVG(efficient)efficient FROM oc_sendorder WHERE evaluate>0";
        $query = $this->db->query($sql);

        //初始值 
        $good_rate_detail = array(
            "goodrate" => 95,
            "semblance" => 4.8,
            "manner" => 4.6,
            "delivery" => 4.4,
            "efficient" => 4.2,
        );

        if (($result = $query->row) != false) {
            $good_rate_detail = array(
                "goodrate" => $this->getGoodRate(),
                "semblance" => sprintf("%.1f", (float) $result['semblance']),
                "manner" => sprintf("%.1f", (float) $result['manner']),
                "delivery" => sprintf("%.1f", (float) $result['delivery']),
                "efficient" => sprintf("%.1f", (float) $result['efficient']),
            );
        }

        return $good_rate_detail;
    }

}

?>
