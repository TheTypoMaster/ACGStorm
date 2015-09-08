<?php

class ControllerCommonHeaderMall extends Controller {

    public function index() {

    	$this->data['logged'] = $this->customer->isLogged();
    	$uname = $this->customer->getFirstName();
    	$this->data['uname'] = $uname;

        //minicart 迷你购物车商品数量
        $count = $this->cart->countProducts();
        $this->data['count'] = $count;

		//已入库订单数
 		$row = $this->db->query("SELECT order_id FROM " . DB_PREFIX . "order WHERE firstname = '" . $uname . "' AND order_status_id = 6"); //SQL 范围 FROM=wechat  oauthuid 
 		$this->data['count2'] = $row->num_rows - 1;
            

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_mall.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_mall.tpl';
        } else {
            $this->template = 'default/template/common/header_mall.tpl';
        }

       $this->render();
    }
}
?>