<?php

/* * ****************************************************************************
 * @description：用户中心（代购 代寄）下单
 * @author： cnstorm01@cnstorm.com
 * @date:     2014.7.18
 * ***************************************************************************** */

class ControllerOrderMake extends Controller {

//代购下单
    public function index() {
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['order_daigou'] = $this->language->get('order_daigou');
        $this->data['order_zigou'] = $this->language->get('order_zigou');
        $this->data['order_daiji'] = $this->language->get('order_daiji');
        $this->data['order_yundan'] = $this->language->get('order_yundan');
        $this->data['order_info'] = $this->language->get('order_info');
        $this->data['order_price'] = $this->language->get('order_price');
        $this->data['order_qty'] = $this->language->get('order_qty');
        $this->data['order_Payment'] = $this->language->get('order_Payment');
        $this->data['order_operating'] = $this->language->get('order_operating');
        $this->data['order_time'] = $this->language->get('order_time');
        $this->data['order_Number'] = $this->language->get('order_Number');

        $this->data['order_color'] = $this->language->get('order_color');
        $this->data['order_size'] = $this->language->get('order_size');
        $this->data['order_remark'] = $this->language->get('order_remark');
        $this->data['order_company'] = $this->language->get('order_company');
        $this->data['Int_Transport'] = $this->language->get('Int_Transport');
        $this->data['My_house'] = $this->language->get('My_house');
        $this->data['order_shipping'] = $this->language->get('order_shipping');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');
        $this->data['order_pending'] = $this->language->get('order_pending');
        $this->data['Payment'] = $this->language->get('Payment');
        $this->data['notpaid'] = $this->language->get('order_notpaid');
        $this->data['quehuo'] = $this->language->get('quehuo');
        $this->data['fahuo'] = $this->language->get('order_fahuo');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');
        $this->data['notpaid'] = $this->language->get('order_notpaid');
        $this->data['quehuo'] = $this->language->get('quehuo');

        $this->data['Int_Transport'] = $this->language->get('Int_Transport');
        $this->data['My_house'] = $this->language->get('My_house');
        $this->data['order_shipping'] = $this->language->get('order_shipping');
        $this->data['Customer_Center'] = $this->language->get('Customer_Center');


        $this->data['order_one'] = $this->url->link('order/order', '', 'SSL');
        $this->data['order_two'] = $this->url->link('order/order/order_two', '', 'SSL');
        $this->data['order_three'] = $this->url->link('order/order/order_three', '', 'SSL');
        $this->data['order_four'] = $this->url->link('order/order/order_four', '', 'SSL');
        $this->data['order_daigou_cul'] = $this->url->link('order/order/order_daigou', '', 'SSL');
        $this->data['order_zizhu_cul'] = $this->url->link('order/order/order_zizhu', '', 'SSL');
        $this->data['order_daiji_cul'] = $this->url->link('order/order/order_daiji', '', 'SSL');
        $this->data['order_guoji_cul'] = $this->url->link('order/order/order_guoji', '', 'SSL');
        $this->data['order_center'] = $this->url->link('order/order', '', 'SSL');
        //    $this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        //    $this->data['emali'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
        //    $this->data['update_order'] = $this->url->link('sale/order/update_order', 'token=' . $this->session->data['token'] . $url, 'SSL');

        /* $this->template = 'cnstorm/template/order/make_daigou.tpl';

          $this->children = array(
          'common/header',
          'common/footer',
          'common/column_left'); */

        $this->template = 'cnstorm/template/order/make_dg_business.tpl';

        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business');

        $this->response->setOutput($this->render());
    }

    //代寄下单
    public function order_daiji() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('order/order');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('order/order');

        if (isset($this->request->get['username_id'])) {
            $username_id = $this->request->get['username_id'];
        } else {
            $username_id = null;
        }

        if (isset($this->request->get['order_status_id'])) {
            $order_status_id = $this->request->get['order_status_id'];
        } else {
            $order_status_id = null;
        }
        $username_id = $this->session->data['customer_id'];
        $this->data['customer_id'] = $this->session->data['customer_id'];

        $this->data['order_daigou'] = $this->language->get('order_daigou');
        $this->data['order_zigou'] = $this->language->get('order_zigou');
        $this->data['order_daiji'] = $this->language->get('order_daiji');
        $this->data['order_yundan'] = $this->language->get('order_yundan');
        $this->data['order_info'] = $this->language->get('order_info');
        $this->data['order_price'] = $this->language->get('order_price');
        $this->data['order_qty'] = $this->language->get('order_qty');
        $this->data['order_Payment'] = $this->language->get('order_Payment');
        $this->data['order_operating'] = $this->language->get('order_operating');
        $this->data['order_time'] = $this->language->get('order_time');
        $this->data['order_Number'] = $this->language->get('order_Number');

        $this->data['order_color'] = $this->language->get('order_color');
        $this->data['order_size'] = $this->language->get('order_size');
        $this->data['order_remark'] = $this->language->get('order_remark');
        $this->data['order_company'] = $this->language->get('order_company');
        $this->data['Int_Transport'] = $this->language->get('Int_Transport');
        $this->data['My_house'] = $this->language->get('My_house');
        $this->data['woyaodaiji'] = $this->language->get('woyaodaiji');
        $this->data['order_daiji_name'] = $this->language->get('order_daiji_name');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');
        $this->data['express_company'] = $this->language->get('express_company');
        $this->data['express_number'] = $this->language->get('express_number');
        $this->data['order_Parcel'] = $this->language->get('order_Parcel');
        $this->data['order_submit'] = $this->language->get('order_submit');
        $this->data['order_baoguo_name'] = $this->language->get('order_baoguo_name');
        $this->data['Customer_Center'] = $this->language->get('Customer_Center');
        $this->data['notpaid'] = $this->language->get('order_notpaid');
        $this->data['quehuo'] = $this->language->get('quehuo');

        $expresses = $this->model_order_order->express();

        $this->data['expresses'] = $expresses;

        $this->data['order_one'] = $this->url->link('order/order', 'SSL');
        $this->data['order_two'] = $this->url->link('order/order/order_two', 'SSL');
        $this->data['order_three'] = $this->url->link('order/order/order_three', 'SSL');
        $this->data['order_four'] = $this->url->link('order/order/order_four', 'SSL');
        $this->data['order_daigou_cul'] = $this->url->link('order/order/order_daigou', 'SSL');
        $this->data['order_zizhu_cul'] = $this->url->link('order/order/order_zizhu', 'SSL');
        $this->data['order_daiji_cul'] = $this->url->link('order/order/order_daiji', 'SSL');
        $this->data['order_guoji_cul'] = $this->url->link('order/order/order_guoji', 'SSL');
        $this->data['order_center'] = $this->url->link('order/order', 'SSL');


        $this->data['orders'] = array();
        $this->data['customer_name'] = $this->customer->getFirstname();


        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }


        /* $this->template = 'cnstorm/template/order/make_daiji.tpl';

          $this->children = array(
          'common/header',
          'common/footer',
          'common/column_left'); */

        $this->template = 'cnstorm/template/order/make_dj_business.tpl';

        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business');


        $this->response->setOutput($this->render());
    }

    //代寄订单提交
    public function daiji_submit() {
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('order/make/order_daiji', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->post['express_number'])) {

            $express_number = $this->request->post['express_number'];
            if ($express_number == "") {
                $order_status_id = "3";
            } else {
                $order_status_id = "4";
            }
        }

        if (isset($this->request->post['order_daiji_name'])) {

            $order_daiji_name = $this->request->post['order_daiji_name'];
        }

        if (isset($this->request->post['expresses'])) {

            $expresses = $this->request->post['expresses'];
        }

        if (isset($this->request->post['order_Parcel'])) {
            $order_Parcel = h($this->request->post['order_Parcel']);
        }

        $username_id = $this->session->data['customer_id'];
        $this->load->model('order/order');

        if (isset($this->request->post['insert_order']) && !empty($username_id)) {

            $insert_data = array(
                'username_id' => $username_id,
                'order_status_id' => $order_status_id,
                'order_status_buy' => 3,
                'order_Parcel' => $order_Parcel,
                'expresses' => $expresses,
                'order_daiji_name' => $order_daiji_name,
                'express_number' => $express_number
            );

            $order_totals_daigou = $this->model_order_order->insert_daiji_order($insert_data);
            header("location:index.php?route=order/make/order_daiji");
        }
    }

}

?>