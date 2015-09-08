<?php

class ControllerCommonColumnLeftSnsMng extends Controller {

    protected function index() {

        $this->load->model('design/layout');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('catalog/information');

        //菜单
        $this->load->model('order/order');
        $this->load->model('order/sendorder');
        //代购

		//语言部分
		$this->language->load('common/column_left_snsmng');
		$this->data['text_perfectExperience'] = $this->language->get('text_perfectExperience');
		$this->data['text_userCenter'] = $this->language->get('text_userCenter');
		$this->data['text_orderManagement'] = $this->language->get('text_orderManagement');
		$this->data['text_myOrder'] = $this->language->get('text_myOrder');
		$this->data['text_placeOrder'] = $this->language->get('text_placeOrder');
		$this->data['text_internationalAirWaybill'] = $this->language->get('text_internationalAirWaybill');
		$this->data['text_myWarehouse'] = $this->language->get('text_myWarehouse');
		$this->data['text_myCollection'] = $this->language->get('text_myCollection');
		$this->data['text_accountManagement'] = $this->language->get('text_accountManagement');
		$this->data['text_RMBaccount'] = $this->language->get('text_RMBaccount');
		$this->data['text_recordsConsumption'] = $this->language->get('text_recordsConsumption');
		$this->data['text_myCoupons'] = $this->language->get('text_myCoupons');
		$this->data['text_myIntegral'] = $this->language->get('text_myIntegral');
		$this->data['text_newsStation'] = $this->language->get('text_newsStation');
		$this->data['text_customerServiceConsulting'] = $this->language->get('text_customerServiceConsulting');
		$this->data['text_communityNews'] = $this->language->get('text_communityNews');
		$this->data['text_myInvitation'] = $this->language->get('text_myInvitation');
		$this->data['text_personalSettings'] = $this->language->get('text_personalSettings');
		$this->data['text_personalData'] = $this->language->get('text_personalData');
		$this->data['text_accountSecurity'] = $this->language->get('text_accountSecurity');
		$this->data['text_deliveryAddress'] = $this->language->get('text_deliveryAddress');
		$this->data['text_commonlyUsedWidgets'] = $this->language->get('text_commonlyUsedWidgets');
		$this->data['text_checkParcel'] = $this->language->get('text_checkParcel');
		$this->data['text_costEstimating'] = $this->language->get('text_costEstimating');
		$this->data['text_sizeConversion'] = $this->language->get('text_sizeConversion');
		$this->data['text_exchangeRateConversion'] = $this->language->get('text_exchangeRateConversion');
		$this->data['text_feedback'] = $this->language->get('text_feedback');
		$this->data['text_yourSuggestion'] = $this->language->get('text_yourSuggestion');
		$this->data['text_submit'] = $this->language->get('text_submit');
		$this->data['text_clickReply'] = $this->language->get('text_clickReply');
		$this->data['text_photo'] = $this->language->get('text_photo');
		$this->data['text_modifyPhoto'] = $this->language->get('text_modifyPhoto');
		$this->data['text_studentCertificationIcon'] = $this->language->get('text_studentCertificationIcon');
		$this->data['text_gradeMembership'] = $this->language->get('text_gradeMembership');
		$this->data['text_growthValue'] = $this->language->get('text_growthValue');
		$this->data['text_memberIntegral'] = $this->language->get('text_memberIntegral');
		$this->data['text_accountBalance'] = $this->language->get('text_accountBalance');
		$this->data['text_lockTheBalance'] = $this->language->get('text_lockTheBalance');
		$this->data['text_yuan'] = $this->language->get('text_yuan');
		$this->data['text_immediatelyRecharge'] = $this->language->get('text_immediatelyRecharge');
		$this->data['text_detailedPersonalInformation'] = $this->language->get('text_detailedPersonalInformation');
		$this->data['text_myWarehouseDddress'] = $this->language->get('text_myWarehouseDddress');
		$this->data['text_prompt'] = $this->language->get('text_prompt');
		$this->data['text_answer'] = $this->language->get('text_answer');
		$this->data['text_sign'] = $this->language->get('text_sign');
		$this->data['text_recToFriends'] = $this->language->get('text_recToFriends');

        //$this->data['order_one'] = $this->url->link('order/order', '', 'SSL');
        //$this->data['make'] = $this->url->link('order/make', '', 'SSL');

        $this->data['order_one'] = HTTP_SERVER."order.html";
        $this->data['make'] = HTTP_SERVER."order-make.html";

        $this->data['order_daigou'] = $this->url->link('order/order/order_daigou', '', 'SSL');
        $data_daigou = array(
            'order_status_buy' => 1,
            'username_id'      => $this->customer->getId()
        );
        $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);
        
        //自助
        $this->data['order_two'] = $this->url->link('order/order/order_two', '', 'SSL');
        $this->data['order_zizhu'] = $this->url->link('order/order/order_zizhu', '', 'SSL');
        $data_zizhu = array(
            'order_status_buy' => 2,
            'username_id'      => $this->customer->getId()
        );
        $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);
        
        //代寄
        $this->data['order_three'] = $this->url->link('order/order/order_three', '', 'SSL');
        $this->data['order_daiji'] = $this->url->link('order/order/order_daiji', '', 'SSL');
        $data_daiji = array(
            'order_status_buy' => 3,
            'username_id'      => $this->customer->getId()
        );
        $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);
        
        //国际
        $this->data['order_four'] = $this->url->link('order/order/order_four', '', 'SSL');

        //$this->data['order_guoji'] = $this->url->link('order/sendorder', '', 'SSL');

        $this->data['order_guoji'] = HTTP_SERVER."order-sendorder.html";

        $data_guoji = array(
        	'username_id' => $this->customer->getId()
        );
        $this->data['num_guoji'] = $this->model_order_sendorder->total_send_porduct($data_guoji);
        
        //仓库
        //$this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');

        $this->data['order_my_cangku'] = HTTP_SERVER.'order-order-order_myhome.html';

        $data_cangku = array(
            'username_id'     => $this->customer->getId(),
            'order_status_id' => 6,
            'yundan_or'	      => 1
        );
        $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);
        


        //我的收藏
        //$this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');

        $this->data['wishlist'] = HTTP_SERVER."account-wishlist.html";

        if(isset($this->session->data['wishlist']))
            $this->data['num_wishlist'] = count($this->session->data['wishlist']);
        else
            $this->data['num_wishlist'] = 0;
    
        //人民币账户
        //$this->data['rmbaccount'] = $this->url->link('account/rmbaccount', '', 'SSL');

        $this->data['rmbaccount'] = HTTP_SERVER."account-rmbaccount.html";

        //消费记录
        //$this->data['expense'] = $this->url->link('account/expense', '', 'SSL');

        $this->data['expense'] = HTTP_SERVER."account-expense.html";

        //我的优惠卷
        //$this->data['coupons'] = $this->url->link('account/coupons', '', 'SSL');

        $this->data['coupons'] = HTTP_SERVER."account-coupons.html";

        //我的积分
        //$this->data['scorerecord'] = $this->url->link('account/scorerecord', '', 'SSL');

        $this->data['scorerecord'] = HTTP_SERVER."account-scorerecord.html";

        //站内消息
        //$this->data['webnews'] = $this->url->link('account/webnews', '', 'SSL');

        $this->data['webnews'] = HTTP_SERVER."account-webnews.html";

        $this->load->model('account/pm');
        $this->data['num_webnews'] = $this->model_account_pm->getTotalPm(3);
        
        
        if($this->customer->getface())
        {
        	$this->data['face'] = $this->customer->getface();
        }
        else
        {
        	$this->data['face'] = '';
        }
        
        if($this->customer->getVerify())
        {
        	$this->data['verification'] = $this->customer->getVerify();
        }
        else
        {
        	$this->data['verification'] = '';
        }

        //客户咨询
        //$this->data['advisory'] = $this->url->link('account/advisory', '', 'SSL');

        $this->data['advisory'] = HTTP_SERVER."account-advisory.html";
        
        //社区消息
        //$this->data['snsmanager'] =  $this->url->link('social/snsmanager', '', 'SSL');
		$this->data['snsmanager'] =  'social-snsmanager.html';
        //我的邀请
        $this->data['invite'] = $this->url->link('account/invite', '', 'SSL');
        //个人资料
        $this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
        //账户安全
        $this->data['safety'] = $this->url->link('account/safety', '', 'SSL');
        //收货地址
        $this->data['address'] = $this->url->link('account/address', '', 'SSL');
        //帮助中心
        $this->data['populartools'] = $this->url->link('help/populartools', '', 'SSL');

        //用户中心右侧顶部
        if (isset($this->request->get['username_id'])) {
            $username_id = $this->request->get['username_id'];
        } else {
            $username_id = null;
        }

        if (isset($this->session->data['customer_id'])) {
            $username_id = $this->session->data['customer_id'];
            $this->data['customer_id'] = $this->session->data['customer_id'];
            $customer = $this->customer->getFirstname();
            $this->data['money'] = $this->customer->getMoney();
            $this->data['score'] = $this->customer->getScore();
            $this->data['utype'] = $this->customer->getUtype();
            $this->data['growth'] = $this->customer->getGrowth();
        } else {
            $customer = "";
        }

        $this->data['customer_name'] = $customer;

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


        //column left continue
        if (isset($this->request->get['route'])) {
            $route = (string) $this->request->get['route'];
        } else {
            $route = 'common/home';
        }

        $layout_id = 0;

        if ($route == 'product/category' && isset($this->request->get['path'])) {
            $path = explode('_', (string) $this->request->get['path']);

            $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
        }

        if ($route == 'product/product' && isset($this->request->get['product_id'])) {
            $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
        }

        if ($route == 'information/information' && isset($this->request->get['information_id'])) {
            $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
        }

        if (!$layout_id) {
            $layout_id = $this->model_design_layout->getLayout($route);
        }

        if (!$layout_id) {
            $layout_id = $this->config->get('config_layout_id');
        }

        $module_data = array();

        $this->load->model('setting/extension');

        $extensions = $this->model_setting_extension->getExtensions('module');

        foreach ($extensions as $extension) {
            $modules = $this->config->get($extension['code'] . '_module');

            if ($modules) {
                foreach ($modules as $module) {
                    if ($module['layout_id'] == $layout_id && $module['position'] == 'column_left' && $module['status']) {
                        $module_data[] = array(
                            'code' => $extension['code'],
                            'setting' => $module,
                            'sort_order' => $module['sort_order']
                        );
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($module_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $module_data);

        $this->data['modules'] = array();

        foreach ($module_data as $module) {
            $module = $this->getChild('module/' . $module['code'], $module['setting']);

            if ($module) {
                $this->data['modules'][] = $module;
            }
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/column_left_snsmng.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/column_left_snsmng.tpl';
        } else {
            $this->template = 'default/template/common/column_left.tpl';
        }

        $this->render();
    }

}

?>