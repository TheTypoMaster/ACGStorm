<?php

class ControllerCommonUcBusiness extends Controller {

    protected function index() {

        $this->data['currentUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $this->data['make'] = HTTP_SERVER . "order-make.html";
        $this->data['order_one'] = HTTP_SERVER . "order.html";
        $this->data['order_two'] = HTTP_SERVER . "order-order-order_two.html";
        $this->data['order_three'] = HTTP_SERVER . "order-order-order_three.html";
        $this->data['storage'] = HTTP_SERVER . "order-order-order_myhome.html";
        $this->data['wishlist'] = HTTP_SERVER . "account-wishlist.html";
        $this->data['sendorder'] = HTTP_SERVER . "order-sendorder.html";
        $this->data['address'] = HTTP_SERVER . "account-address.html";
        $this->data['msg'] = HTTP_SERVER . "account-webnews.html";
        $this->data['advisory'] = HTTP_SERVER . "account-advisory.html";
        $this->data['account'] = HTTP_SERVER . "index.php?route=account/edit";
        $this->data['rmbaccount'] = HTTP_SERVER . "account-rmbaccount.html";
        $this->data['expense'] = HTTP_SERVER . "account-expense.html";
        $this->data['scorerecord'] = HTTP_SERVER . "account-scorerecord.html";
        $this->data['coupons'] = HTTP_SERVER . "account-coupons.html";
		$this->data['cancel'] = HTTP_SERVER . "order-cancel.html";
		$this->data['cancelso'] = HTTP_SERVER . "order-cancel-cancelso.html";
		  
        if (isset($this->session->data['customer_id'])) {
            $username_id = $this->session->data['customer_id'];
            $this->data['customer_id'] = $this->session->data['customer_id'];
            $customer = $this->customer->getFirstname();
            $this->data['money'] = $this->customer->getMoney();
            $this->data['score'] = $this->customer->getScore();
            $this->data['customer_name'] = $this->customer->getFirstname();
            $this->data['customer_email'] = $this->customer->getEmail();
			$this->data['face'] =$this->customer->getFace();
		
        } else {
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        date_default_timezone_set("PRC");
        $h = date('H');
        if ($h > 5 && $h < 12) {
            $time_name = "上午好";
        } else if (11 < $h && $h < 19) {
            $time_name = "下午好";
        } else if (18 < $h && $h < 25 || $h < 6) {

            $time_name = "晚上好";
        }
        $this->data['time_name'] = $time_name;

        $this->template = 'cnstorm/template/common/uc_business.tpl';
        $this->response->setOutput($this->render());
    }

}
