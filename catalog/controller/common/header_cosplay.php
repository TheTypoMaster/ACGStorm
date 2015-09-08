<?php

class ControllerCommonHeaderCosplay extends Controller {

    protected function index() {

        $this->data['logged'] = $this->customer->isLogged();
        $uname = $this->customer->getFirstName();
        $this->data['uname'] = $uname;

        //minicart 迷你购物车商品数量
        $count = $this->cart->countProducts();
        $this->data['count'] = $count;

        //已入库订单数
        $row = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE firstname = '" . $uname . "' AND order_status_id = 6"); //SQL 范围 FROM=wechat  oauthuid 
        $this->data['count2'] = $row->num_rows;
            

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_cosplay.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_cosplay.tpl';
        } else {
            $this->template = 'default/template/common/header_cosplay.tpl';
        }

        $this->render();
    }
}
?>