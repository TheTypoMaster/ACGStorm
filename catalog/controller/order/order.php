<?php

/* * ****************************************************************************
 * @description：用户中心订单 （代购 自助购 代寄 国际运单 仓库） 列表及相关操作
 * @author： lcd@cnstorm.com
 * @date:     2014.6.9
 * ***************************************************************************** */

class ControllerOrderOrder extends Controller {

    //用户中心代购页面
    public function index() {

        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');
        $this->load->model('order/order');

        if (isset($this->request->post['order_product_id'])) {

            $this->model_order_order->updateOrderOnlyProducts($this->request->post['order_product_id'], $this->request->post['content']);

            $msg = array('msg' => $this->language->get('text_modify_success'));

            $this->response->setOutput(json_encode($msg));
        } else {

            $url = '';

            //第一次被推荐过来买过东西时送现金15
            //区分是不是第一次被推荐进来买了东西，是则执行
            if (!isset($this->session->data['onceBuy'])) {
                //被推荐且注册过了买了东西才进来这执行
                if (isset($this->session->data['u'])) {

                    if ($this->model_order_order->getosTotalOrder()) {
                        $this->model_order_order->addRecMoney($this->session->data['u'], 15);
                    }
                    $this->session->data['onceBuy'] = '1';
                }
            }

            $this->document->setTitle($this->language->get('heading_title'));


            $this->data['text_head'] = $this->language->get('text_head');
            $this->data['text_meta_keywords'] = $this->language->get('text_meta_keywords');
            $this->data['text_meta_description'] = $this->language->get('text_meta_description');
            $this->data['text_procurement_orders'] = $this->language->get('text_procurement_orders');
            $this->data['text_by_id'] = $this->language->get('text_by_id');
            $this->data['text_by_keywords'] = $this->language->get('text_by_keywords');
            $this->data['text_search_placeholder'] = $this->language->get('text_search_placeholder');
            $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
            $this->data['text_startTime_placeholder'] = $this->language->get('text_startTime_placeholder');
            $this->data['text_endTime_placeholder'] = $this->language->get('text_endTime_placeholder');
            $this->data['text_search_keywords'] = $this->language->get('text_search_keywords');
            $this->data['text_mailable_order'] = $this->language->get('text_mailable_order');
            $this->data['text_all_order'] = $this->language->get('text_all_order');
            $this->data['text_check_all'] = $this->language->get('text_check_all');
            $this->data['text_store_title'] = $this->language->get('text_store_title');
            $this->data['text_modify'] = $this->language->get('text_modify');
            $this->data['text_merge_pay'] = $this->language->get('text_merge_pay');
            $this->data['text_product_img'] = $this->language->get('text_product_img');
            $this->data['text_urged'] = $this->language->get('text_urged');
            $this->data['text_urged_buy'] = $this->language->get('text_urged_buy');
            $this->data['text_check_logistics'] = $this->language->get('text_check_logistics');
            $this->data['text_requested_photo'] = $this->language->get('text_requested_photo');
            $this->data['text_photograph_photo'] = $this->language->get('text_photograph_photo');
            $this->data['text_check_agio'] = $this->language->get('text_check_agio');
            $this->data['text_pay_agio'] = $this->language->get('text_pay_agio');
            $this->data['text_loading'] = $this->language->get('text_loading');
            $this->data['text_time_format'] = $this->language->get('text_time_format');
            $this->data['text_keyword_format'] = $this->language->get('text_keyword_format');
            $this->data['text_time_notnull'] = $this->language->get('text_time_notnull');
            $this->data['text_payagio_success'] = $this->language->get('text_payagio_success');
            $this->data['text_payagio_failed1'] = $this->language->get('text_payagio_failed1');
            $this->data['text_payagio_failed2'] = $this->language->get('text_payagio_failed2');
            $this->data['text_payagio_money'] = $this->language->get('text_payagio_money');
            $this->data['text_payagio_failed3'] = $this->language->get('text_payagio_failed3');
            $this->data['text_failed'] = $this->language->get('text_failed');
            $this->data['text_photo_request'] = $this->language->get('text_photo_request');
            $this->data['text_photo_requested'] = $this->language->get('text_photo_requested');

            //$this->data['column_action'] = $this->language->get('column_action');
            $this->data['order_daigou'] = $this->language->get('order_daigou');
            $this->data['order_zigou'] = $this->language->get('order_zigou');
            $this->data['order_daiji'] = $this->language->get('order_daiji');
            //$this->data['order_yundan'] = $this->language->get('order_yundan');
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
            //$this->data['Int_Transport'] = $this->language->get('Int_Transport');
            $this->data['My_house'] = $this->language->get('My_house');
            $this->data['order_shipping'] = $this->language->get('order_shipping');
            $this->data['order_pending'] = $this->language->get('order_pending');
            $this->data['order_quxiao'] = $this->language->get('order_quxiao');
            $this->data['quehuo'] = $this->language->get('quehuo');
            $this->data['Payment'] = $this->language->get('Payment');
            //$this->data['Customer_Center'] = $this->language->get('Customer_Center');
            //$this->data['notpaid'] = $this->language->get('order_notpaid');
            //$this->data['fahuo'] = $this->language->get('order_fahuo');

            $order_statuses = $this->model_order_order->getOrderStatuses();


            $customerId = $this->customer->getId();
            foreach ($order_statuses as $k => $status) {
                $totalSignalStatus = $this->model_order_order->totalSignalStatus($status['order_status_id'], $customerId, 1);
                $this->data['order_statuses'][$k] = array(
                    'order_status_id' => $status['order_status_id'],
                    'name' => $status['name'],
                    'total' => $totalSignalStatus['total']
                );
            }


            if (isset($this->request->get['order'])) {
                $order = $this->request->get['order'];
            } else {
                $order = 'DESC';
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_customer'])) {
                $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status_id'])) {
                $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
            } else {
                $this->data['filter_order_status_id'] = '';
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total=' . $this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            //代购

            $data_daigou = array(
                'order_status_buy' => 1,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

            //自助

            $data_zizhu = array(
                'order_status_buy' => 2,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);

            //代寄

            $data_daiji = array(
                'order_status_buy' => 3,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);

            //国际

            $data_guoji = array(
                'username_id' => $this->customer->getId()
            );
            $this->data['num_guoji'] = $this->model_order_order->total_send_porduct($data_guoji);

            //仓库

            $data_cangku = array(
                'username_id' => $this->customer->getId(),
                'order_status_id' => 6,
                'yundan_or' => 1
            );
            $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);


            $this->data['order_one'] = $this->url->link('order/order', '', 'SSL');
            $this->data['order_two'] = $this->url->link('order/order/order_two', '', 'SSL');
            $this->data['order_three'] = $this->url->link('order/order/order_three', '', 'SSL');
            $this->data['order_four'] = $this->url->link('order/order/order_four', '', 'SSL');
            $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');
            $this->data['orders'] = array();
            $username_id = $this->session->data['customer_id'];
            $this->data['customer_id'] = $this->session->data['customer_id'];
            $limit = 10;


            $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => 1));
            $this->data['order_status_id'] = 0;
            if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] != 0) {
                $order_status_id = $this->request->get['order_status_id'];
                $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
                $url .= "&order_status_id=" . $order_status_id;
                $results_total = $this->model_order_order->getSingalOrder($order_status_id);
                $this->data['order_status_id'] = $order_status_id;
            } else {
                $order_status_id = null;
            }
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
                $results_total = 1;
            } else {
                $order_id = '';
            }
            if (isset($this->request->get['st']) && isset($this->request->get['et'])) {
                $startTime = $this->request->get['st'];
                $endTime = $this->request->get['et'];
                $url .= "&st=" . $startTime . "&et=" . $endTime;
                $startTime = strtotime($startTime);
                $endTime = strtotime($endTime);
                $results_total = $this->model_order_order->getSearchForTimeTotalOrder(strtotime($this->request->get['st']), strtotime($this->request->get['et']));
            } else {
                $startTime = 0;
                $endTime = 0;
            }
            if (isset($this->request->get['sk'])) {
                $sk = $this->request->get['sk'];
                $url .= "&sk=" . $sk;
                $results_total = 20;
            } else {
                $sk = '';
            }
            $data = array(
                'sk' => $sk,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'order_id' => $order_id,
                'username_id' => $username_id,
                'order_status_id' => $order_status_id,
                'order_status_buy' => 1,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );


            $results = $this->model_order_order->getOrders($data);
            foreach ($results as $result) {

                $product_str = array();
                $product = $this->model_order_order->getOrderProducts($result['order_id']);
                $product_total = $this->model_order_order->sun_product_total($result['order_id']);
                if (!empty($product)) {
                    foreach ($product as $key => $value) {
                        $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);
                        $order_product_id = $value['order_product_id'];

                        $product = $this->model_order_order->cul_home_Products($value['product_id']);

                        $product_str[$order_product_id]['name'] = $value['name'];
                        $product_str[$order_product_id]['price'] = $value['price'];
                        $product_str[$order_product_id]['quantity'] = $value['quantity'];
                        $product_str[$order_product_id]['total'] = $value['total'];
                        $product_str[$order_product_id]['order_product_id'] = $order_product_id;
                        $product_str[$order_product_id]['order_sensitive'] = $value['order_sensitive'];
                        $product_str[$order_product_id]['order_branding'] = $value['order_branding'];
                        $product_str[$order_product_id]['order_huge'] = $value['order_huge'];
                        $product_str[$order_product_id]['kuaidi_no'] = $value['kuaidi_no'];
                        $product_str[$order_product_id]['express'] = $value['express'];
                        $product_str[$order_product_id]['weight'] = $value['weight'];

                        $product_str[$order_product_id]['color'] = $value['option_color'];
                        $product_str[$order_product_id]['size'] = $value['option_size'];
                        $product_str[$order_product_id]['note'] = $value['note'];
                        $product_str[$order_product_id]['producturl'] = urlencode($value['producturl']);


                        $pan = "http";
                        $com = explode($pan, $value['img']);

                        if (count($com) > 1) {
                            $product_str[$order_product_id]['img'] = $value['img'];
                        } else {
                            $this->load->model('tool/image');
                            $value['img'] = $this->model_tool_image->resize($value['img'], $this->config->
                                            get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                            $product_str[$order_product_id]['img'] = $value['img'];
                        }

                        if (isset($product[0]['image'])) {
                            $product_str[$order_product_id]['image'] = $product[0]['image'];
                        }
                    }
                    $this->data['orders'][] = array(
                        'order_id' => $result['order_id'],
                        'order_shipping' => $result['order_shipping'],
                        'storename' => $result['store_name'],
                        'storeurl' => $result['store_url'],
                        'customer' => $result['customer'],
                        'status' => $result['status'],
                        'order_status_id' => $result['order_status_id'],
                        'product_total' => $product_total[0]['ordertotal'],
                        'product' => $product_str,
                        'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                        'date_added' => $result['date_added'],
                        'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                        'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                        'preq' => $result['preq'],
                        'creq' => $result['creq']
                    );
                }
            }



            $pagination = new Pagination();

            $pagination->total = $results_total;

            $pagination->page = $page;

            $pagination->limit = $limit;

            $pagination->url = $this->url->link('order/order', '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $this->template = 'cnstorm/template/order/order.tpl';

            if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {

                $this->template = 'cnstorm/template/order/order_business_list.tpl';

                $this->children = array(
                    'common/header_business',
                    'common/footer_business',
                    'common/uc_business'
                );
            }

            $this->children = array(
                'common/header_cart',
                'common/footer',
                'common/uc_business'
            );

            $this->response->setOutput($this->render());
        }
    }
    //cosplay商城
   public function cosplaymall(){

       if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');
        $this->load->model('order/order');

        if (isset($this->request->post['order_product_id'])) {

            $this->model_order_order->updateOrderOnlyProducts($this->request->post['order_product_id'], $this->request->post['content']);

            $msg = array('msg' => $this->language->get('text_modify_success'));

            $this->response->setOutput(json_encode($msg));
        } else {

            $url = '';

            //第一次被推荐过来买过东西时送现金15
            //区分是不是第一次被推荐进来买了东西，是则执行
            if (!isset($this->session->data['onceBuy'])) {
                //被推荐且注册过了买了东西才进来这执行
                if (isset($this->session->data['u'])) {

                    if ($this->model_order_order->getosTotalOrder()) {
                        $this->model_order_order->addRecMoney($this->session->data['u'], 15);
                    }
                    $this->session->data['onceBuy'] = '1';
                }
            }

            $this->document->setTitle($this->language->get('heading_title'));


            $this->data['text_head'] = $this->language->get('text_head');
            $this->data['text_meta_keywords'] = $this->language->get('text_meta_keywords');
            $this->data['text_meta_description'] = $this->language->get('text_meta_description');
            $this->data['text_procurement_orders'] = $this->language->get('text_procurement_orders');
            $this->data['text_by_id'] = $this->language->get('text_by_id');
            $this->data['text_by_keywords'] = $this->language->get('text_by_keywords');
            $this->data['text_search_placeholder'] = $this->language->get('text_search_placeholder');
            $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
            $this->data['text_startTime_placeholder'] = $this->language->get('text_startTime_placeholder');
            $this->data['text_endTime_placeholder'] = $this->language->get('text_endTime_placeholder');
            $this->data['text_search_keywords'] = $this->language->get('text_search_keywords');
            $this->data['text_mailable_order'] = $this->language->get('text_mailable_order');
            $this->data['text_all_order'] = $this->language->get('text_all_order');
            $this->data['text_check_all'] = $this->language->get('text_check_all');
            $this->data['text_store_title'] = $this->language->get('text_store_title');
            $this->data['text_modify'] = $this->language->get('text_modify');
            $this->data['text_merge_pay'] = $this->language->get('text_merge_pay');
            $this->data['text_product_img'] = $this->language->get('text_product_img');
            $this->data['text_urged'] = $this->language->get('text_urged');
            $this->data['text_urged_buy'] = $this->language->get('text_urged_buy');
            $this->data['text_check_logistics'] = $this->language->get('text_check_logistics');
            $this->data['text_requested_photo'] = $this->language->get('text_requested_photo');
            $this->data['text_photograph_photo'] = $this->language->get('text_photograph_photo');
            $this->data['text_check_agio'] = $this->language->get('text_check_agio');
            $this->data['text_pay_agio'] = $this->language->get('text_pay_agio');
            $this->data['text_loading'] = $this->language->get('text_loading');
            $this->data['text_time_format'] = $this->language->get('text_time_format');
            $this->data['text_keyword_format'] = $this->language->get('text_keyword_format');
            $this->data['text_time_notnull'] = $this->language->get('text_time_notnull');
            $this->data['text_payagio_success'] = $this->language->get('text_payagio_success');
            $this->data['text_payagio_failed1'] = $this->language->get('text_payagio_failed1');
            $this->data['text_payagio_failed2'] = $this->language->get('text_payagio_failed2');
            $this->data['text_payagio_money'] = $this->language->get('text_payagio_money');
            $this->data['text_payagio_failed3'] = $this->language->get('text_payagio_failed3');
            $this->data['text_failed'] = $this->language->get('text_failed');
            $this->data['text_photo_request'] = $this->language->get('text_photo_request');
            $this->data['text_photo_requested'] = $this->language->get('text_photo_requested');

            //$this->data['column_action'] = $this->language->get('column_action');
            $this->data['order_daigou'] = $this->language->get('order_daigou');
            $this->data['order_zigou'] = $this->language->get('order_zigou');
            $this->data['order_daiji'] = $this->language->get('order_daiji');
            //$this->data['order_yundan'] = $this->language->get('order_yundan');
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
            //$this->data['Int_Transport'] = $this->language->get('Int_Transport');
            $this->data['My_house'] = $this->language->get('My_house');
            $this->data['order_shipping'] = $this->language->get('order_shipping');
            $this->data['order_pending'] = $this->language->get('order_pending');
            $this->data['order_quxiao'] = $this->language->get('order_quxiao');
            $this->data['quehuo'] = $this->language->get('quehuo');
            $this->data['Payment'] = $this->language->get('Payment');
            //$this->data['Customer_Center'] = $this->language->get('Customer_Center');
            //$this->data['notpaid'] = $this->language->get('order_notpaid');
            //$this->data['fahuo'] = $this->language->get('order_fahuo');

            $order_statuses = $this->model_order_order->getOrderStatuses();

            $customerId = $this->customer->getId();
            foreach ($order_statuses as $k => $status) {
                $totalSignalStatus = $this->model_order_order->totalSignalStatus($status['order_status_id'], $customerId, 5);
                $this->data['order_statuses'][$k] = array(
                    'order_status_id' => $status['order_status_id'],
                    'name' => $status['name'],
                    'total' => $totalSignalStatus['total']
                );
            }


            if (isset($this->request->get['order'])) {
                $order = $this->request->get['order'];
            } else {
                $order = 'DESC';
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_customer'])) {
                $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status_id'])) {
                $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
            } else {
                $this->data['filter_order_status_id'] = '';
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total=' . $this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            //代购

            $data_daigou = array(
                'order_status_buy' => 5,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

            //自助

            $data_zizhu = array(
                'order_status_buy' => 2,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);

            //代寄

            $data_daiji = array(
                'order_status_buy' => 3,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);

            //国际

            $data_guoji = array(
                'username_id' => $this->customer->getId()
            );
            $this->data['num_guoji'] = $this->model_order_order->total_send_porduct($data_guoji);

            //仓库

            $data_cangku = array(
                'username_id' => $this->customer->getId(),
                'order_status_id' => 6,
				'order_status_buy'=>5,
                'yundan_or' => 1
            );
            $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);


            $this->data['order_one'] = $this->url->link('order/order', '', 'SSL');
            $this->data['order_two'] = $this->url->link('order/order/order_two', '', 'SSL');
            $this->data['order_three'] = $this->url->link('order/order/order_three', '', 'SSL');
            $this->data['order_four'] = $this->url->link('order/order/order_four', '', 'SSL');
            $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');
            $this->data['orders'] = array();
            $username_id = $this->session->data['customer_id'];
            $this->data['customer_id'] = $this->session->data['customer_id'];
            $limit = 10;


            $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => 5));
            $this->data['order_status_id'] = 0;
            if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] != 0) {
                $order_status_id = $this->request->get['order_status_id'];
                $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
                $url .= "&order_status_id=" . $order_status_id;
                $results_total = $this->model_order_order->getSingalOrder($order_status_id);
                $this->data['order_status_id'] = $order_status_id;
            } else {
                $order_status_id = null;
            }
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
                $results_total = 1;
            } else {
                $order_id = '';
            }
            if (isset($this->request->get['st']) && isset($this->request->get['et'])) {
                $startTime = $this->request->get['st'];
                $endTime = $this->request->get['et'];
                $url .= "&st=" . $startTime . "&et=" . $endTime;
                $startTime = strtotime($startTime);
                $endTime = strtotime($endTime);
                $results_total = $this->model_order_order->getSearchForTimeTotalOrder(strtotime($this->request->get['st']), strtotime($this->request->get['et']));
            } else {
                $startTime = 0;
                $endTime = 0;
            }
            if (isset($this->request->get['sk'])) {
                $sk = $this->request->get['sk'];
                $url .= "&sk=" . $sk;
                $results_total = 20;
            } else {
                $sk = '';
            }
            $data = array(
                'sk' => $sk,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'order_id' => $order_id,
                'username_id' => $username_id,
                'order_status_id' => $order_status_id,
                'order_status_buy' => 5,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );


            $results = $this->model_order_order->getOrders($data);
            foreach ($results as $result) {

                $product_str = array();
                $product = $this->model_order_order->getOrderProducts($result['order_id']);
                $product_total = $this->model_order_order->sun_product_total($result['order_id']);
                if (!empty($product)) {
                    foreach ($product as $key => $value) {
                        $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);
                        $order_product_id = $value['order_product_id'];

                        $product = $this->model_order_order->cul_home_Products($value['product_id']);

                        $product_str[$order_product_id]['name'] = $value['name'];
                        $product_str[$order_product_id]['price'] = $value['price'];
                        $product_str[$order_product_id]['quantity'] = $value['quantity'];
                        $product_str[$order_product_id]['total'] = $value['total'];
                        $product_str[$order_product_id]['order_product_id'] = $order_product_id;
                        $product_str[$order_product_id]['order_sensitive'] = $value['order_sensitive'];
                        $product_str[$order_product_id]['order_branding'] = $value['order_branding'];
                        $product_str[$order_product_id]['order_huge'] = $value['order_huge'];
                        $product_str[$order_product_id]['kuaidi_no'] = $value['kuaidi_no'];
                        $product_str[$order_product_id]['express'] = $value['express'];
                        $product_str[$order_product_id]['weight'] = $value['weight'];

                        $product_str[$order_product_id]['color'] = $value['option_color'];
                        $product_str[$order_product_id]['size'] = $value['option_size'];
                        $product_str[$order_product_id]['note'] = $value['note'];
                        $product_str[$order_product_id]['producturl'] = urlencode($value['producturl']);


                        $pan = "http";
                        $com = explode($pan, $value['img']);

                        if (count($com) > 1) {
                            $product_str[$order_product_id]['img'] = $value['img'];
                        } else {
                            $this->load->model('tool/image');
                            $value['img'] = $this->model_tool_image->resize($value['img'], $this->config->
                                            get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                            $product_str[$order_product_id]['img'] = $value['img'];
                        }

                        if (isset($product[0]['image'])) {
                            $product_str[$order_product_id]['image'] = $product[0]['image'];
                        }
                    }
                    $this->data['orders'][] = array(
                        'order_id' => $result['order_id'],
                        'order_shipping' => $result['order_shipping'],
                        'storename' => 'COSPLAY商城',
                        'storeurl' => '/cosplay-main.html',
                        'customer' => $result['customer'],
                        'status' => $result['status'],
                        'order_status_id' => $result['order_status_id'],
                        'product_total' => $product_total[0]['ordertotal'],
                        'product' => $product_str,
                        'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                        'date_added' => $result['date_added'],
                        'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                        'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                        'preq' => $result['preq'],
                        'creq' => $result['creq']
                    );
                }
            }



            $pagination = new Pagination();

            $pagination->total = $results_total;

            $pagination->page = $page;

            $pagination->limit = $limit;

            $pagination->url = $this->url->link('order/order', '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $this->template = 'cnstorm/template/order/order_cosplaymall.tpl';

            if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {

                $this->template = 'cnstorm/template/order/order_cosplaymall_list.tpl';

                $this->children = array(
                    'common/header_business',
                    'common/footer_business',
                    'common/uc_business'
                );
            }

            $this->children = array(
                'common/header_cart',
                'common/footer',
                'common/uc_business'
            );

            $this->response->setOutput($this->render());
        }
   }
    public function mall() {

        $order_status_buy = 4;

        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');
        $this->load->model('order/order');

        if (isset($this->request->post['order_product_id'])) {

            $this->model_order_order->updateOrderOnlyProducts($this->request->post['order_product_id'], $this->request->post['content']);

            $msg = array('msg' => $this->language->get('text_modify_success'));

            $this->response->setOutput(json_encode($msg));
        } else {

            $url = '';

            //第一次被推荐过来买过东西时送现金15
            //区分是不是第一次被推荐进来买了东西，是则执行
            if (!isset($this->session->data['onceBuy'])) {
                //被推荐且注册过了买了东西才进来这执行
                if (isset($this->session->data['u'])) {

                    if ($this->model_order_order->getosTotalOrder()) {
                        $this->model_order_order->addRecMoney($this->session->data['u'], 15);
                    }
                    $this->session->data['onceBuy'] = '1';
                }
            }

            $this->document->setTitle($this->language->get('heading_title'));


            $this->data['text_head'] = $this->language->get('text_head');
            $this->data['text_meta_keywords'] = $this->language->get('text_meta_keywords');
            $this->data['text_meta_description'] = $this->language->get('text_meta_description');
            $this->data['text_procurement_orders'] = $this->language->get('text_procurement_orders');
            $this->data['text_by_id'] = $this->language->get('text_by_id');
            $this->data['text_by_keywords'] = $this->language->get('text_by_keywords');
            $this->data['text_search_placeholder'] = $this->language->get('text_search_placeholder');
            $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
            $this->data['text_startTime_placeholder'] = $this->language->get('text_startTime_placeholder');
            $this->data['text_endTime_placeholder'] = $this->language->get('text_endTime_placeholder');
            $this->data['text_search_keywords'] = $this->language->get('text_search_keywords');
            $this->data['text_mailable_order'] = $this->language->get('text_mailable_order');
            $this->data['text_all_order'] = $this->language->get('text_all_order');
            $this->data['text_check_all'] = $this->language->get('text_check_all');
            $this->data['text_store_title'] = $this->language->get('text_store_title');
            $this->data['text_modify'] = $this->language->get('text_modify');
            $this->data['text_merge_pay'] = $this->language->get('text_merge_pay');
            $this->data['text_product_img'] = $this->language->get('text_product_img');
            $this->data['text_urged'] = $this->language->get('text_urged');
            $this->data['text_urged_buy'] = $this->language->get('text_urged_buy');
            $this->data['text_check_logistics'] = $this->language->get('text_check_logistics');
            $this->data['text_requested_photo'] = $this->language->get('text_requested_photo');
            $this->data['text_photograph_photo'] = $this->language->get('text_photograph_photo');
            $this->data['text_check_agio'] = $this->language->get('text_check_agio');
            $this->data['text_pay_agio'] = $this->language->get('text_pay_agio');
            $this->data['text_loading'] = $this->language->get('text_loading');
            $this->data['text_time_format'] = $this->language->get('text_time_format');
            $this->data['text_keyword_format'] = $this->language->get('text_keyword_format');
            $this->data['text_time_notnull'] = $this->language->get('text_time_notnull');
            $this->data['text_payagio_success'] = $this->language->get('text_payagio_success');
            $this->data['text_payagio_failed1'] = $this->language->get('text_payagio_failed1');
            $this->data['text_payagio_failed2'] = $this->language->get('text_payagio_failed2');
            $this->data['text_payagio_money'] = $this->language->get('text_payagio_money');
            $this->data['text_payagio_failed3'] = $this->language->get('text_payagio_failed3');
            $this->data['text_failed'] = $this->language->get('text_failed');
            $this->data['text_photo_request'] = $this->language->get('text_photo_request');
            $this->data['text_photo_requested'] = $this->language->get('text_photo_requested');

            //$this->data['column_action'] = $this->language->get('column_action');
            $this->data['order_daigou'] = $this->language->get('order_daigou');
            $this->data['order_zigou'] = $this->language->get('order_zigou');
            $this->data['order_daiji'] = $this->language->get('order_daiji');
            //$this->data['order_yundan'] = $this->language->get('order_yundan');
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
            //$this->data['Int_Transport'] = $this->language->get('Int_Transport');
            $this->data['My_house'] = $this->language->get('My_house');
            $this->data['order_shipping'] = $this->language->get('order_shipping');
            $this->data['order_pending'] = $this->language->get('order_pending');
            $this->data['order_quxiao'] = $this->language->get('order_quxiao');
            $this->data['quehuo'] = $this->language->get('quehuo');
            $this->data['Payment'] = $this->language->get('Payment');
            //$this->data['Customer_Center'] = $this->language->get('Customer_Center');
            //$this->data['notpaid'] = $this->language->get('order_notpaid');
            //$this->data['fahuo'] = $this->language->get('order_fahuo');

            $order_statuses = $this->model_order_order->getOrderStatuses();


            $customerId = $this->customer->getId();
            foreach ($order_statuses as $k => $status) {
                $totalSignalStatus = $this->model_order_order->totalSignalStatus($status['order_status_id'], $customerId, $order_status_buy);
                $this->data['order_statuses'][$k] = array(
                    'order_status_id' => $status['order_status_id'],
                    'name' => $status['name'],
                    'total' => $totalSignalStatus['total']
                );
            }


            if (isset($this->request->get['order'])) {
                $order = $this->request->get['order'];
            } else {
                $order = 'DESC';
            }

            if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }

            if (isset($this->request->get['filter_order_id'])) {
                $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
            }

            if (isset($this->request->get['filter_customer'])) {
                $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_order_status_id'])) {
                $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
            } else {
                $this->data['filter_order_status_id'] = '';
            }

            if (isset($this->request->get['filter_total'])) {
                $url .= '&filter_total=' . $this->request->get['filter_total'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
            }

            if (isset($this->request->get['filter_date_modified'])) {
                $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
            }

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            //代购

            $data_daigou = array(
                'order_status_buy' => 1,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

            //自助

            $data_zizhu = array(
                'order_status_buy' => 2,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);

            //代寄
            $data_daiji = array(
                'order_status_buy' => 3,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);

            //CNstorm商城
            $data_mall = array(
                'order_status_buy' => 4,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_mall'] = $this->model_order_order->getTotalOrders($data_mall);


            //国际

            $data_guoji = array(
                'username_id' => $this->customer->getId()
            );
            $this->data['num_guoji'] = $this->model_order_order->total_send_porduct($data_guoji);

            //仓库

            $data_cangku = array(
               // 'order_status_buy' => 4,
                'username_id' => $this->customer->getId(),
                'order_status_id' => 6,
                'yundan_or' => 1
            );
            $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);


            $this->data['order_one'] = $this->url->link('order/order', '', 'SSL');
            $this->data['order_two'] = $this->url->link('order/order/order_two', '', 'SSL');
            $this->data['order_three'] = $this->url->link('order/order/order_three', '', 'SSL');
            $this->data['order_four'] = $this->url->link('order/order/order_four', '', 'SSL');
            $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');
            $this->data['orders'] = array();
            $username_id = $this->session->data['customer_id'];
            $this->data['customer_id'] = $this->session->data['customer_id'];
            $limit = 10;


            $this->data['order_status_buy'] = $order_status_buy;
            $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => $order_status_buy));
            
            $this->data['order_status_id'] = 0;
            if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] != 0) {
                $order_status_id = $this->request->get['order_status_id'];
                $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
                $url .= "&order_status_id=" . $order_status_id;
               //$results_total = $this->model_order_order->getSingalOrder($order_status_id); 
                $results_total = $this->model_order_order->getSingalOrderByOrderStatusBuy($order_status_id,$order_status_buy); //商城订单
                $this->data['order_status_id'] = $order_status_id;
            } else {
                $order_status_id = null;
            }
            if (isset($this->request->get['order_id'])) {
                $order_id = $this->request->get['order_id'];
                $results_total = 1;
            } else {
                $order_id = '';
            }
            if (isset($this->request->get['st']) && isset($this->request->get['et'])) {
                $startTime = $this->request->get['st'];
                $endTime = $this->request->get['et'];
                $url .= "&st=" . $startTime . "&et=" . $endTime;
                $startTime = strtotime($startTime);
                $endTime = strtotime($endTime);
                $results_total = $this->model_order_order->getSearchForTimeTotalOrder(strtotime($this->request->get['st']), strtotime($this->request->get['et']));
            } else {
                $startTime = 0;
                $endTime = 0;
            }
            if (isset($this->request->get['sk'])) {
                $sk = $this->request->get['sk'];
                $url .= "&sk=" . $sk;
                $results_total = 20;
            } else {
                $sk = '';
            }
            
        
            $data = array(
                'sk' => $sk,
                'startTime' => $startTime,
                'endTime' => $endTime,
                'order_id' => $order_id,
                'username_id' => $username_id,
                'order_status_id' => $order_status_id,
                'order_status_buy' => $order_status_buy,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );


            $results = $this->model_order_order->getOrders($data);

            foreach ($results as $result) {

                $product_str = array();
                $product = $this->model_order_order->getOrderProducts($result['order_id']);
                $product_total = $this->model_order_order->sun_product_total($result['order_id']);
                if (!empty($product)) {
                    foreach ($product as $key => $value) {
                        $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);
                        $order_product_id = $value['order_product_id'];

                        $product = $this->model_order_order->cul_home_Products($value['product_id']);

                        $product_str[$order_product_id]['name'] = $value['name'];
                        $product_str[$order_product_id]['price'] = $value['price'];
                        $product_str[$order_product_id]['quantity'] = $value['quantity'];
                        $product_str[$order_product_id]['total'] = $value['total'];
                        $product_str[$order_product_id]['order_product_id'] = $order_product_id;
                        $product_str[$order_product_id]['order_sensitive'] = $value['order_sensitive'];
                        $product_str[$order_product_id]['order_branding'] = $value['order_branding'];
                        $product_str[$order_product_id]['order_huge'] = $value['order_huge'];
                        $product_str[$order_product_id]['kuaidi_no'] = $value['kuaidi_no'];
                        $product_str[$order_product_id]['express'] = $value['express'];
                        $product_str[$order_product_id]['weight'] = $value['weight'];

                        $product_str[$order_product_id]['color'] = $value['option_color'];
                        $product_str[$order_product_id]['size'] = $value['option_size'];
                        $product_str[$order_product_id]['note'] = $value['note'];
                        // $product_str[$order_product_id]['producturl'] = urlencode($value['producturl']);
                        $product_str[$order_product_id]['producturl'] = urlencode(HTTP_SERVER . $value['product_id'] . ".html");



                        $pan = "http";
                        $com = explode($pan, $value['img']);

                        if (count($com) > 1) {
                            $product_str[$order_product_id]['img'] = $value['img'];
                        } else {
                            $this->load->model('tool/image');
                            $value['img'] = $this->model_tool_image->resize($value['img'], $this->config->
                                            get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                            $product_str[$order_product_id]['img'] = $value['img'];
                        }

                        if (isset($product[0]['image'])) {
                            $product_str[$order_product_id]['image'] = $product[0]['image'];
                        }
                    }

                    $this->data['orders'][] = array(
                        'order_id' => $result['order_id'],
                        'order_shipping' => $result['order_shipping'],
                        'storename' => $result['store_name'],
                        'storeurl' => $result['store_url'],
                        'storename' => "CNstorm商城",
                        'storeurl' => HTTP_SERVER . "product-mall.html",
                        'customer' => $result['customer'],
                        'status' => $result['status'],
                        'order_status_id' => $result['order_status_id'],
                        'product_total' => $product_total[0]['ordertotal'],
                        'product' => $product_str,
                        'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                        'date_added' => $result['date_added'],
                        'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                        'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                        'preq' => $result['preq'],
                        'creq' => $result['creq']
                    );
                }
            }



            $pagination = new Pagination();

            $pagination->total = $results_total;

            $pagination->page = $page;

            $pagination->limit = $limit;

            $pagination->url = $this->url->link('order/order/mall', '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $this->template = 'cnstorm/template/order/order_mall.tpl';

            if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {

                $this->template = 'cnstorm/template/order/order_business_list.tpl';

                $this->children = array(
                    'common/header_business',
                    'common/footer_business',
                    'common/uc_business'
                );
            }

            $this->children = array(
                'common/header_cart',
                'common/footer',
                'common/uc_business'
            );

            $this->response->setOutput($this->render());
        }
    }

    //采购催促
    public function pcReq() {
        $this->load->model('order/order');
        $this->model_order_order->updatePcReq($_POST['order_id'], $_POST['sign']);
        $msg = array('msg' => '请求成功');
        echo json_encode($msg);
    }

    //拍照请求
    public function reqphoto() {

        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('order/order', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->post['order_id']) && $this->request->post['order_id']) {

            $this->load->model('order/order');

            $this->load->model('account/customer');

            $this->load->model('account/record');

            $order_id = $this->request->post['order_id'];

            $sign = $this->request->post['sign'];

            $user_balance = $this->customer->getMoney();

            $uid = $this->customer->getId();

            $firstname = $this->customer->getFirstName();

            $photofee = $this->model_order_order->getcountbyid($order_id);

            $newbalance = round($user_balance - $photofee, 2);

            if ($newbalance >= 0) {

                $this->model_order_order->updatePcReq($order_id, $sign);

                $photofee = $this->model_order_order->getcountbyid($order_id);

                $result = $this->model_account_customer->editBalance($newbalance, $uid); // 扣去账户余额

                if ($result) {

                    $data = array(
                        'uid' => $uid,
                        'firstname' => $firstname,
                        'payname' => "余额支付",
                        'money' => -$photofee,
                        'accountmoney' => $newbalance,
                        'remark' => '订单拍照扣除金额' . $photofee,
                        'remarktype' => 1,
                        'remarkdetails' => $order_id,
                        'addtime' => time()
                    );

                    $this->model_account_record->addRecord($data); // 写记录

                    $this->response->setOutput(json_encode(1));
                } else {

                    $this->response->setOutput(json_encode(2));
                }
            } else {

                $this->response->setOutput(json_encode(3));
            }
        }
    }

    public function refund() {
        $this->load->model('order/order');
        $this->model_order_order->updateRefund($_POST['order_id']);
        $msg = array('msg' => '请求成功');
        echo json_encode($msg);
    }

    //add by weikun  用户中心自助购页面
    public function order_two() {
        $url = '';

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


        if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] != 0) {
            $order_status_id = $this->request->get['order_status_id'];
            $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
            $url .= "&order_status_id=" . $order_status_id;
            $results_total = $this->model_order_order->getSingalOrder($order_status_id);
            $this->data['order_status_id'] = $order_status_id;
        } else {
            $order_status_id = null;
        }

        $this->data['text_by_id'] = $this->language->get('text_by_id');
        $this->data['text_by_keywords'] = $this->language->get('text_by_keywords');
        $this->data['text_search_placeholder'] = $this->language->get('text_search_placeholder');
        $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
        $this->data['text_startTime_placeholder'] = $this->language->get('text_startTime_placeholder');
        $this->data['text_endTime_placeholder'] = $this->language->get('text_endTime_placeholder');
        $this->data['text_search_keywords'] = $this->language->get('text_search_keywords');
        $this->data['text_time_format'] = $this->language->get('text_time_format');
        $this->data['text_keyword_format'] = $this->language->get('text_keyword_format');
        $this->data['text_time_notnull'] = $this->language->get('text_time_notnull');
        $this->data['text_product_img'] = $this->language->get('text_product_img');

        $this->data['text_selfhelpbuy_orders'] = $this->language->get('text_selfhelpbuy_orders');
        $this->data['text_mailable_order'] = $this->language->get('text_mailable_order');
        $this->data['text_all_order'] = $this->language->get('text_all_order');
        $this->data['text_search_placeholder_k'] = $this->language->get('text_search_placeholder_k');
        $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['order_info'] = $this->language->get('order_info');
        $this->data['order_price'] = $this->language->get('order_price');
        $this->data['order_qty'] = $this->language->get('text_search');
        $this->data['order_company'] = $this->language->get('order_company');
        $this->data['order_operating'] = $this->language->get('order_operating');
        $this->data['text_all_order'] = $this->language->get('text_all_order');
        $this->data['order_Number'] = $this->language->get('order_Number');
        $this->data['order_time'] = $this->language->get('order_time');
        $this->data['text_store_title'] = $this->language->get('text_store_title');
        $this->data['order_color'] = $this->language->get('order_color');
        $this->data['order_size'] = $this->language->get('order_size');
        $this->data['order_remark'] = $this->language->get('order_remark');
        $this->data['text_fillin_logistics'] = $this->language->get('text_fillin_logistics');
        $this->data['text_select_express'] = $this->language->get('text_select_express');
        $this->data['text_express_no'] = $this->language->get('text_express_no');
        $this->data['text_submit'] = $this->language->get('text_submit');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');
        $this->data['text_fillin_nubmer'] = $this->language->get('text_fillin_nubmer');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');
        $this->data['text_check_logistics'] = $this->language->get('text_check_logistics');
        $this->data['text_loading'] = $this->language->get('text_loading');
        $this->data['text_fillin_nubmer'] = $this->language->get('text_fillin_nubmer');
        $this->data['text_loading'] = $this->language->get('text_loading');

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
        $this->data['Customer_Center'] = $this->language->get('Customer_Center');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');

        $this->data['text_urged'] = $this->language->get('text_urged');
        $this->data['text_urged_buy'] = $this->language->get('text_urged_buy');
        $this->data['text_failed'] = $this->language->get('text_failed');
        $this->data['text_requested_photo'] = $this->language->get('text_requested_photo');
        $this->data['text_photograph_photo'] = $this->language->get('text_photograph_photo');

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        } else {
            $this->data['filter_order_status_id'] = '';
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        //      $this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['order_one'] = $this->url->link('order/order', 'SSL');
        $this->data['order_two'] = $this->url->link('order/order/order_two', 'SSL');
        $this->data['order_three'] = $this->url->link('order/order/order_three', 'SSL');
        $this->data['order_four'] = $this->url->link('order/order/order_four', 'SSL');
        $this->data['order_daigou_cul'] = $this->url->link('order/order/order_daigou', 'SSL');
        $this->data['order_zizhu_cul'] = $this->url->link('order/order/order_zizhu', 'SSL');
        $this->data['order_daiji_cul'] = $this->url->link('order/order/order_daiji', 'SSL');
        $this->data['order_guoji_cul'] = $this->url->link('order/order/order_guoji', 'SSL');
        $this->data['order_center'] = $this->url->link('order/order', 'SSL');
        $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', 'SSL');
        //  $this->data['delete'] = $this->url->link('sale/order/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        //  $this->data['emali'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
        //  $this->data['update_order'] = $this->url->link('sale/order/update_order', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['orders'] = array();

        $username_id = $this->session->data['customer_id'];

        $this->data['customer_id'] = $this->session->data['customer_id'];

        $limit = 10;
        $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => 2));
        $this->data['order_status_id'] = 0;
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
            $results_total = 1;
        } else {
            $order_id = '';
        }
        if (isset($this->request->get['st']) && isset($this->request->get['et'])) {
            $startTime = $this->request->get['st'];
            $endTime = $this->request->get['et'];
            $url .= "&st=" . $startTime . "&et=" . $endTime;
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $results_total = $this->model_order_order->getSearchForTimeTotalOrder(strtotime($this->request->get['st']), strtotime($this->request->get['et']));
        } else {
            $startTime = 0;
            $endTime = 0;
        }
        if (isset($this->request->get['sk'])) {
            $sk = $this->request->get['sk'];
            $url .= "&sk=" . $sk;
            $results_total = 10;
        } else {
            $sk = '';
        }
        $data = array(
            'sk' => $sk,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'order_id' => $order_id,
            'username_id' => $username_id,
            'order_status_id' => $order_status_id,
            'order_status_buy' => 2,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        //代购
        $data2 = array('username_id' => $username_id, 'order_status_buy' => 1);
        $order_totals_daigou = $this->model_order_order->getTotalOrders($data2);
        $this->data['order_totals_daigou'] = $order_totals_daigou;

        //自购物
        $data3 = array('username_id' => $username_id, 'order_status_buy' => 2);
        $order_totals_zizhu = $this->model_order_order->getTotalOrders($data3);
        $this->data['order_totals_zizhu'] = $order_totals_zizhu;

        //代寄
        $data4 = array('username_id' => $username_id, 'order_status_buy' => 3);
        $order_totals_daiji = $this->model_order_order->getTotalOrders($data4);
        $this->data['order_totals_daiji'] = $order_totals_daiji;
        $order_statuses = $this->model_order_order->getOrderStatuses();


        $customerId = $this->customer->getId();
        foreach ($order_statuses as $k => $status) {
            $totalSignalStatus = $this->model_order_order->totalSignalStatus($status['order_status_id'], $customerId, 2);
            $this->data['order_statuses'][$k] = array(
                'order_status_id' => $status['order_status_id'],
                'name' => $status['name'],
                'total' => $totalSignalStatus['total']
            );
        }


        $order_total = $this->model_order_order->getTotalOrders(1);

        //代购
        $this->data['order_daigou_url'] = $this->url->link('order/order/order_daigou', '', 'SSL');
        $data_daigou = array(
            'order_status_buy' => 1,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

        //自助
        $this->data['order_zizhu_url'] = $this->url->link('order/order/order_zizhu', '', 'SSL');
        $data_zizhu = array(
            'order_status_buy' => 2,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);

        //代寄
        $this->data['order_daiji_url'] = $this->url->link('order/order/order_daiji', '', 'SSL');
        $data_daiji = array(
            'order_status_buy' => 3,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);

        //国际
        $this->data['order_guoji_url'] = $this->url->link('order/order/order_guoji', '', 'SSL');
        $data_guoji = array(
            'username_id' => $this->customer->getId()
        );
        $this->data['num_guoji'] = $this->model_order_order->total_send_porduct($data_guoji);

        //仓库
        $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');
        $data_cangku = array(
            'username_id' => $this->customer->getId(),
            'order_status_id' => 6,
            'yundan_or' => 1
        );
        $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);


        $results = $this->model_order_order->getOrders($data);
        $expresses = $this->model_order_order->express();
        $this->data['expresses'] = $expresses;

        foreach ($results as $result) {
            $action = array();
            $action[] = array(//    'text' => $this->language->get('text_view'),
                    //      'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );
            if (strtotime($result['date_added']) > strtotime('-' . (int) $this->config->get('config_order_edit') .
                            ' day')) {
                $action[] = array(//        'text' => $this->language->get('text_edit'),
                        //      'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
                );
            }
            $product_str = array();
            $product = $this->model_order_order->getOrderProducts($result['order_id']);

            $product_total = $this->model_order_order->sun_product_total($result['order_id']);
            foreach ($product as $key => $value) {
                $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);
                $order_product_id = $value['order_product_id'];

                $product = $this->model_order_order->cul_home_Products($value['product_id']);


                $product_str[$order_product_id]['name'] = $value['name'];
                $product_str[$order_product_id]['price'] = $value['price'];
                $product_str[$order_product_id]['quantity'] = $value['quantity'];
                $product_str[$order_product_id]['total'] = $value['total'];
                $product_str[$order_product_id]['order_product_id'] = $order_product_id;
                $product_str[$order_product_id]['order_sensitive'] = $value['order_sensitive'];
                $product_str[$order_product_id]['order_branding'] = $value['order_branding'];
                $product_str[$order_product_id]['order_huge'] = $value['order_huge'];
                //      $product_str[$order_product_id]['tracking_number']= $value['tracking_number'];
                $product_str[$order_product_id]['express'] = $value['express'];
                $product_str[$order_product_id]['weight'] = $value['weight'];
                $product_str[$order_product_id]['kuaidi_no'] = $value['kuaidi_no'];
                $product_str[$order_product_id]['color'] = $value['option_color'];
                $product_str[$order_product_id]['size'] = $value['option_size'];
                $product_str[$order_product_id]['note'] = $value['note'];
                $product_str[$order_product_id]['producturl'] = $value['producturl'];
                $pan = "http";
                $com = explode($pan, $value['img']);
                if (count($com) > 1) {
                    $product_str[$order_product_id]['img'] = $value['img'];
                } else {
                    $this->load->model('tool/image');
                    $value['img'] = $this->model_tool_image->resize($value['img'], $this->config->
                                    get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                    $product_str[$order_product_id]['img'] = $value['img'];
                }
            }

            $kauidi = $this->model_order_order->order_kuaidgongsi($result['order_kaudi']);

            $this->data['orders'][] = array(
                'order_id' => $result['order_id'],
                'order_shipping' => $result['order_shipping'],
                'order_status_id' => $result['order_status_id'],
                'customer' => $result['customer'],
                'status' => $result['status'],
                'status' => $result['status'],
                'order_kaudi' => $result['order_kaudi'],
                'storename' => $result['store_name'],
                'storeurl' => $result['store_url'],
                'order_kaudigongsi' => $kauidi['name'],
                'product' => $product_str,
                'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                'date_added' => $result['date_added'],
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                'preq' => $result['preq'],
                'creq' => $result['creq']
            );
            //var_dump($this->data['orders']);
        }

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


        $pagination = new Pagination();

        $pagination->total = $results_total;

        $pagination->page = $page;

        $pagination->limit = $limit;

        $pagination->url = $this->url->link('order/order/order_two', '&page={page}');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'cnstorm/template/order/uc_zzg_business.tpl';

        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {

            $this->template = 'cnstorm/template/order/uc_zzg_business_list.tpl';
        }
        /*
          $this->children = array(
          'common/header_business',
          'common/footer_business',
          'common/uc_business');
         */
        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business'
        );



        $this->response->setOutput($this->render());
    }

    public function order_three() {
        $url = '';
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


        if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] != 0) {
            $order_status_id = $this->request->get['order_status_id'];
            $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
            $url .= "&order_status_id=" . $order_status_id;
            $results_total = $this->model_order_order->getSingalOrder($order_status_id);
            $this->data['order_status_id'] = $order_status_id;
        } else {
            $order_status_id = null;
        }


        $username_id = $this->session->data['customer_id'];
        $this->data['customer_id'] = $this->session->data['customer_id'];

        $this->data['text_by_id'] = $this->language->get('text_by_id');
        $this->data['text_by_keywords'] = $this->language->get('text_by_keywords');
        $this->data['text_search_placeholder'] = $this->language->get('text_search_placeholder');
        $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
        $this->data['text_startTime_placeholder'] = $this->language->get('text_startTime_placeholder');
        $this->data['text_endTime_placeholder'] = $this->language->get('text_endTime_placeholder');
        $this->data['text_search_keywords'] = $this->language->get('text_search_keywords');
        $this->data['text_time_format'] = $this->language->get('text_time_format');
        $this->data['text_keyword_format'] = $this->language->get('text_keyword_format');
        $this->data['text_time_notnull'] = $this->language->get('text_time_notnull');
        $this->data['text_product_img'] = $this->language->get('text_product_img');

        $this->data['text_search_placeholder_k'] = $this->language->get('text_search_placeholder_k');
        $this->data['text_search_timerange'] = $this->language->get('text_search_timerange');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_mailable_order'] = $this->language->get('text_mailable_order');
        $this->data['text_all_order'] = $this->language->get('text_all_order');
        $this->data['order_operating'] = $this->language->get('order_operating');
        $this->data['text_fillin_logistics2'] = $this->language->get('text_fillin_logistics2');
        $this->data['text_check_logistics'] = $this->language->get('text_check_logistics');
        $this->data['text_select_express'] = $this->language->get('text_select_express');
        $this->data['text_fillin_nubmer'] = $this->language->get('text_fillin_nubmer');
        $this->data['text_submit'] = $this->language->get('text_submit');
        $this->data['text_loading'] = $this->language->get('text_loading');
        $this->data['text_select_express'] = $this->language->get('text_select_express');
        $this->data['order_quxiao'] = $this->language->get('order_quxiao');

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
        $this->data['notpaid'] = $this->language->get('order_notpaid');
        $this->data['quehuo'] = $this->language->get('quehuo');
        $this->data['express_company'] = $this->language->get('express_company');
        $this->data['express_number'] = $this->language->get('express_number');
        $this->data['order_Parcel'] = $this->language->get('order_Parcel');
        $this->data['order_submit'] = $this->language->get('order_submit');
        $this->data['order_baoguo_name'] = $this->language->get('order_baoguo_name');
        $this->data['Customer_Center'] = $this->language->get('Customer_Center');

        $this->data['text_urged'] = $this->language->get('text_urged');
        $this->data['text_urged_buy'] = $this->language->get('text_urged_buy');
        $this->data['text_failed'] = $this->language->get('text_failed');
        $this->data['text_requested_photo'] = $this->language->get('text_requested_photo');
        $this->data['text_photograph_photo'] = $this->language->get('text_photograph_photo');


        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        } else {
            $this->data['filter_order_status_id'] = '';
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }



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

        $limit = 10;
        $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => 3));
        $this->data['order_status_id'] = 0;
        if (isset($this->request->get['order_id'])) {
            $order_id = $this->request->get['order_id'];
            $results_total = 1;
        } else {
            $order_id = '';
        }
        if (isset($this->request->get['st']) && isset($this->request->get['et'])) {
            $startTime = $this->request->get['st'];
            $endTime = $this->request->get['et'];
            $url .= "&st=" . $startTime . "&et=" . $endTime;
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
            $results_total = $this->model_order_order->getSearchForTimeTotalOrder(strtotime($this->request->get['st']), strtotime($this->request->get['et']));
        } else {
            $startTime = 0;
            $endTime = 0;
        }
        if (isset($this->request->get['sk'])) {
            $sk = $this->request->get['sk'];
            $url .= "&sk=" . $sk;
            $results_total = 10;
        } else {
            $sk = '';
        }
        $data = array(
            'sk' => $sk,
            'startTime' => $startTime,
            'endTime' => $endTime,
            'order_id' => $order_id,
            'username_id' => $username_id,
            'order_status_id' => $order_status_id,
            'order_status_buy' => 3,
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        //代购
        $data2 = array(
            'username_id' => $username_id,
            'order_status_buy' => 1
        );
        $order_totals_daigou = $this->model_order_order->getTotalOrders($data2);
        $this->data['order_totals_daigou'] = $order_totals_daigou;

        //自购物
        $data3 = array(
            'username_id' => $username_id,
            'order_status_buy' => 2
        );
        $order_totals_zizhu = $this->model_order_order->getTotalOrders($data3);
        $this->data['order_totals_zizhu'] = $order_totals_zizhu;

        //代寄
        $data4 = array(
            'username_id' => $username_id,
            'order_status_buy' => 3
        );
        $order_totals_daiji = $this->model_order_order->getTotalOrders($data4);
        $this->data['order_totals_daiji'] = $order_totals_daiji;

        //代购
        $this->data['order_daigou_url'] = $this->url->link('order/order/order_daigou', '', 'SSL');
        $data_daigou = array(
            'order_status_buy' => 1,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

        //自助
        $this->data['order_zizhu_url'] = $this->url->link('order/order/order_zizhu', '', 'SSL');
        $data_zizhu = array(
            'order_status_buy' => 2,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_zizhu'] = $this->model_order_order->getTotalOrders($data_zizhu);

        //代寄
        $this->data['order_daiji_url'] = $this->url->link('order/order/order_daiji', '', 'SSL');
        $data_daiji = array(
            'order_status_buy' => 3,
            'username_id' => $this->customer->getId()
        );
        $this->data['num_daiji'] = $this->model_order_order->getTotalOrders($data_daiji);

        //国际
        $this->data['order_guoji_url'] = $this->url->link('order/order/order_guoji', '', 'SSL');
        $data_guoji = array(
            'username_id' => $this->customer->getId()
        );
        $this->data['num_guoji'] = $this->model_order_order->total_send_porduct($data_guoji);

        //仓库
        $this->data['order_my_cangku'] = $this->url->link('order/order/order_myhome', '', 'SSL');
        $data_cangku = array(
            'username_id' => $this->customer->getId(),
            'order_status_id' => 6,
            'yundan_or' => 1
        );
        $this->data['num_cangku'] = $this->model_order_order->getTotalOrders($data_cangku);


        $order_statuses = $this->model_order_order->getOrderStatuses();


        $customerId = $this->customer->getId();
        foreach ($order_statuses as $k => $status) {
            $totalSignalStatus = $this->model_order_order->totalSignalStatus($status['order_status_id'], $customerId, 3);
            $this->data['order_statuses'][$k] = array(
                'order_status_id' => $status['order_status_id'],
                'name' => $status['name'],
                'total' => $totalSignalStatus['total']
            );
        }


        $order_total = $this->model_order_order->getTotalOrders();

        $results = $this->model_order_order->getOrders($data);
        $expresses = $this->model_order_order->express();

        $this->data['expresses'] = $expresses;

        foreach ($results as $result) {

            $action = array();
            $action[] = array(
                    //  'text' => $this->language->get('text_view'),
                    //      'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
            );
            if (strtotime($result['date_added']) > strtotime('-' . (int) $this->config->get('config_order_edit') . ' day')) {
                $action[] = array(
                        //      'text' => $this->language->get('text_edit'),
                        //      'href' => $this->url->link('sale/order/update', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'] . $url, 'SSL')
                );
            }
            $product_str = array();
            $product = $this->model_order_order->getOrderProducts($result['order_id']);

            $product_total = $this->model_order_order->sun_product_total($result['order_id']);
            foreach ($product as $key => $value) {
                $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);
                $order_product_id = $value['order_product_id'];

                $product = $this->model_order_order->cul_home_Products($value['product_id']);
                $kauidi = $this->model_order_order->order_kuaidgongsi($value['express']);

                $product_str[$order_product_id]['name'] = $value['name'];
                $product_str [$order_product_id]['price'] = $value['price'];
                $product_str[$order_product_id]['quantity'] = $value['quantity'];
                $product_str[$order_product_id]['total'] = $value['total'];
                $product_str[$order_product_id]['order_product_id'] = $order_product_id;
                $product_str[$order_product_id]['order_sensitive'] = $value['order_sensitive'];
                $product_str[$order_product_id]['order_branding'] = $value['order_branding'];
                $product_str[$order_product_id]['order_huge'] = $value['order_huge'];
//          $product_str[$order_product_id]['tracking_number']= $value['tracking_number'];
                $product_str[$order_product_id]['kuaidi_no'] = $value['kuaidi_no'];
                $product_str[$order_product_id]['express'] = $value['express'];
                $product_str[$order_product_id]['weight'] = $value['weight'];
                $product_str[$order_product_id]['kuaid_gongsi'] = $kauidi['name_cn'];

                $product_str[$order_product_id]['color'] = $value['option_color'];
                $product_str[$order_product_id]['size'] = $value['option_size'];
                $product_str[$order_product_id]['note'] = $value['note'];

                $pan = "http";
                $com = explode($pan, $value['img']);
                if (count($com) > 1) {
                    $product_str[$order_product_id]['img'] = $value['img'];
                } else {
                    $this->load->model('tool/image');
                    $value['img'] = $this->model_tool_image->resize($value['img'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                    $product_str[$order_product_id]['img'] = $value['img'];
                }
            }

            $this->data['orders'][] = array(
                'order_id' => $result['order_id'],
                'order_shipping' => $result['order_shipping'],
                'order_status_id' => $result['order_status_id'],
                'customer' => $result['customer'],
                'status' => $result['status'],
                'product' => $product_str,
                'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                'date_added' => $result['date_added'],
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                'preq' => $result['preq'],
                'creq' => $result['creq']
            );
        }



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


        $pagination = new Pagination();

        $pagination->total = $results_total;

        $pagination->page = $page;

        $pagination->limit = $limit;

        $pagination->url = $this->url->link('order/order/order_three', '&page={page}');

        $this->data['pagination'] = $pagination->render();


        $this->template = 'cnstorm/template/order/uc_dj_business.tpl';

        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/order/uc_dj_business_list.tpl';
        }
        /*
          $this->children = array(
          'common/header_business',
          'common/footer_business',
          'common/uc_business');
         */
        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }

    public function ajax_weight() {
        $this->language->load('order/order');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('order/order');

        if (isset($this->request->get['chestr'])) {
            $chestr = $this->request->get['chestr'];
            $results = $this->model_order_order->Total_weight($chestr);
            echo $results;
        }
    }

    //我的仓库
    public function order_myhome() {
        //public function order_storage() {

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
            $username_id = '';
        }

        if (isset($this->request->get['order_status_id'])) {
            $order_status_id = $this->request->get['order_status_id'];
            if ($order_status_id == 0) {
                echo "<script >alert('请选择订单状态')</script>";
                return false;
            }
        } else {
            $order_status_id = '';
        }

        $this->data['text_mystore_head'] = $this->language->get('text_mystore_head');
        $this->data['text_mystore_list'] = $this->language->get('text_mystore_list');
        $this->data['text_mystore_address'] = $this->language->get('text_mystore_address');
        $this->data['text_check_all'] = $this->language->get('text_check_all');
        $this->data['text_package_info'] = $this->language->get('text_package_info');
        $this->data['text_order_no'] = $this->language->get('text_order_no');
        $this->data['text_come_time'] = $this->language->get('text_come_time');
        $this->data['text_weight'] = $this->language->get('text_weight');
        $this->data['text_sensitivity'] = $this->language->get('text_sensitivity');
        $this->data['text_chosen'] = $this->language->get('text_chosen');
        $this->data['text_chosen2'] = $this->language->get('text_chosen2');
        $this->data['text_create_waybill'] = $this->language->get('text_create_waybill');
        $this->data['text_mystore_address2'] = $this->language->get('text_mystore_address2');
        $this->data['text_mystore_introduction'] = $this->language->get('text_mystore_introduction');

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
        $this->data['Customer_Center'] = $this->language->get('Customer_Center');


        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        } else {
            $this->data['filter_order_status_id'] = '';
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }


        $username_id = $this->session->data['customer_id'];

        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            if (isset($this->request->post['selected'])) {
                $yundan_order = $this->request->post['selected'];
                $cc = $this->model_order_order->insert_yundan($yundan_order, $username_id);
            }
        }


        $this->data['order_one'] = $this->url->link('order/order', 'SSL');
        $this->data['order_two'] = $this->url->link('order/order/order_two', 'SSL');
        $this->data['order_three'] = $this->url->link('order/order/order_three', 'SSL');
        $this->data['order_four'] = $this->url->link('order/order/order_four', 'SSL');
        $this->data['order_daigou_cul'] = $this->url->link('order/order/order_daigou', 'SSL');
        $this->data['order_zizhu_cul'] = $this->url->link('order/order/order_zizhu', 'SSL');
        $this->data['order_daiji_cul'] = $this->url->link('order/order/order_daiji', 'SSL');
        $this->data['order_guoji_cul'] = $this->url->link('order/order/order_guoji', 'SSL');
        $this->data['order_center'] = $this->url->link('order/order', 'SSL');
        $this->data['order_myhome_uqdate'] = $this->url->link('waybill/transport', '', 'SSL');
        $this->data['orders'] = array();
        $this->data['customer_id'] = $this->session->data['customer_id'];
        $this->data['order_status_id'] = $order_status_id;
        $this->data['customer_name'] = $this->customer->getFirstName();


        $data = array(
            'username_id' => $username_id,
            'order_status_id' => 6
        );

        $this->data['order_statuses'] = $this->model_order_order->getOrderStatuses();

        $results = $this->model_order_order->getOrders($data);

        foreach ($results as $result) {

            $product_str = array();
            $order_weight = $this->model_order_order->Total_weight($result['order_id']);
            $product = $this->model_order_order->getOrderProducts($result['order_id']);
            $str = array();
            $product_total = $this->model_order_order->sun_product_total($result['order_id']);

            $order_sensitive = '';
            $order_branding = '';
            $order_huge = '';

            $order_signal_weight = '';
            $sensitive = '';

            foreach ($product as $key => $value) {

                $attributes = $this->model_order_order->getOrderOptions($result['order_id'], $value['order_product_id']);

                $order_product_id = $value['order_product_id'];

                $pan = "http";

                $com = explode($pan, $value['img']);

                if (count($com) > 1) {
                    $product_str[$order_product_id]['img'] = $value['img'];
                } else {
                    $product_str[$order_product_id]['img'] = 'image/' . $value['img'];
                }

                $product_str[$order_product_id]['name'] = $value['name'];

                $product_str[$order_product_id]['producturl'] = $value['producturl'];

                $product_str[$order_product_id]['quantity'] = $value['quantity'];

                if (2 == $value['order_sensitive']) {
                    $order_sensitive = '敏感';
                } else {
                    $order_sensitive = '';
                }

                if (2 == $value['order_branding']) {
                    $order_branding = '品牌';
                } else {
                    $order_branding = '';
                }

                if (2 == $value['order_huge']) {
                    $order_huge = '重抛';
                } else {
                    $order_huge = '';
                }


                $sensitive .= "</br></br>" . $order_sensitive . " " . $order_branding . " " . $order_huge . "</br></br>";
            }


            $this->data['orders'][] = array(
                'order_id' => $result['order_id'],
                'order_shipping' => $result['order_shipping'],
                'customer' => $result['customer'],
                'store_url' => $result['store_url'],
                'status' => $result['status'],
                'product' => $product_str,
                'order_sensitive' => $sensitive,
                'order_weight' => $order_weight,
                'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
                'date_added' => $result['date_added'],
                'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
                'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
                'shop' => $result['store_name']
            );
        }

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

        if (isset($this->request->get['id'])) {
            $this->data['id'] = $this->request->get['id'];
        }

        $this->template = 'cnstorm/template/order/uc_storage_business.tpl';
        /*
          $this->children = array(
          'common/header_business',
          'common/footer_business',
          'common/uc_business');
         */
        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }

    //补填快递信息
    function express_rewrite() {
        $order_id = $this->request->post['oid'];
        $expresses = $this->request->post['expresses'];
        $express_number = $this->request->post['express_number'];

        $kaidi_data = array(
            'order_kaudi' => $expresses,
            'order_kuaidi_no' => $express_number,
            'order_id' => $order_id
        );
        $this->load->model('order/order');
        $update_expressinfo = $this->model_order_order->update_kuaidi2($kaidi_data);
    }

    //会员中心签到
    public function qiandao() {
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('social/social', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->load->model('order/order');
        $this->load->model('account/customer');
        if ($this->session->data['customer_id']) {

            $customer_id = $this->session->data['customer_id'];
            $userinfo = $this->model_account_customer->getCustomer($customer_id);
            $uname = $userinfo['firstname'];

            //file_put_contents('./1.log',$this->request->get['uname']."\r\n",FILE_APPEND);
            $score = $this->customer->getScore();
            if (!empty($score)) {
                $newscore = $score + 10;
                $product = $this->model_order_order->qiandao($customer_id, $newscore, $uname);

                if (is_array($product)) {
                    foreach ($product as $v) {
                        $v['addtime'] = date('Y-m-d', $v['addtime']);
                        $v = $v['addtime'];
                        $temp[] = $v;
                    }
                    $temp = array_unique($temp);
                    foreach ($temp as $k => $v) {
                        $v = array('addtime' => $v);
                        $productArr[] = $v;
                    }
                    echo json_encode($productArr);
                } else {
                    echo $product;
                }
            }
        }
    }

    //会员中心答题
    public function question() {

        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('social/social', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('order/order');

        if ($this->session->data['customer_id']) {
            $username_id = $this->session->data['customer_id'];
            $product = $this->model_order_order->question($username_id);

            //return  $product[0]['q'];
            echo $product;
            die;
        } else {
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
    }

    public function question2() {
	
	 	if($_SERVER['REQUEST_METHOD']=="GET" || $_SERVER['HTTP_HOST']!='www.acgstorm.com'){
			echo 'today';die;
		} 
        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('social/social', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
		
        $this->language->load('order/order');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('order/order');
        $this->load->model('account/customer');
        if (isset($this->request->post['answer'])) {
            $answer = $this->request->post['answer'];
        }

        if (isset($this->request->post['question_id'])) {
            $question_id = $this->request->post['question_id'];
        }


        if ($this->session->data['customer_id']) {

            $customer_id = $this->session->data['customer_id'];

            $userinfo = $this->model_account_customer->getCustomer($customer_id);

            $uname = $userinfo['firstname'];

			$sql="SELECT sid from oc_scorerecord where uname='$uname' AND uid=$customer_id AND  addtime > ".strtotime(date('Y-m-d',time()))." and addtime < ".strtotime(date('Y-m-d',time()).' 23:59:59'); 
			
			$query =$this->db->query($sql);
			if(isset($query->row['sid']) && count($query->num_rows) > 2  ){
			
				echo 'today';
				
				die;
			}
            $score = $this->customer->getScore();

            if (!empty($score)) {
                $newscore = $score + 10;
                $product = $this->model_order_order->question2($customer_id, $question_id, $answer, $newscore, $uname);
                echo $product;
                die;
            }
        }
    }

    //双11上传图片送积分
    public function shuang11() {
        $this->load->model('order/order');
        if (isset($this->request->post['uname_id'])) {
            $uname_id = $this->request->post['uname_id'];
            $uname = $this->request->post['uname'];
            $score = $this->customer->getScore();
            if (!empty($score)) {
                $newscore = $score + 100;
                $product = $this->model_order_order->shuang11($uname_id, $newscore, $uname);
            }
            echo 1;
        }
    }

    //物流跟踪
    public function track() {
        $key = '0e0a21c9be52379d';
        $url = 'http://api.kuaidi100.com/api?id=' . $key .
                '&com=%s&nu=%s&show=2&muti=1&order=asc';
        $expresser = $_GET['expreser'];
        $expressno = $_GET['no'];

        //安全判断，拒绝盗用
        if (strpos($_SERVER['HTTP_REFERER'], 'cnstorm.com') !== FALSE) {
            //部分快递公司调用接口

            if ($expresser == 'DHL') {
                echo json_encode(array(
                    'express' => "DHL",
                    //'urlsec'=>$urlsec,
                    'sn' => $expressno,
                ));
            } elseif (in_array($expresser, array(
                        'shentong',
                        'shunfeng',
                        'yunda',
                        'yuantong',
                        'zhongtong',
                        'youzhengguonei',
                        'youzhengguoji',
                        'tiantian',
                        'ems',
                        'emsen'))) {

                $url = 'http://www.kuaidi100.com/applyurl?key=' . $key . '&com=' . $expresser .
                        '&nu=' . $expressno;
                if (function_exists('curl_init') == 1) {
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, $url);
                    curl_setopt($curl, CURLOPT_HEADER, 0);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

                    $get_content = curl_exec($curl);
                    curl_close($curl);

                    //将上面获得的返回结果传入iframe的src值
                    $message = "<iframe src='" . $get_content . "' width='580' height='260' frameborder='0' scrolling='no'><br/>";
                    echo json_encode($message);
                }
            } else {

                $url = sprintf($url, $expresser, $expressno);
                $message = file_get_contents($url);
                //$urlsec = "http://cnstorm.com/m.php?name=orderlist";

                echo json_encode($message);
            }
        } else {
            //不符合规则 则跳出 网络错误
            echo json_encode(array('message' => '网络忙，请<a href="#">刷新</a>重试!',));
        }
    }

    public function track_details() {
        $expressno = $this->request->get['sn'];

        if (isset($this->request->get['carrier'])) {
            $carrier = $this->request->get['carrier'];
            $this->data['carrier'] = $carrier;
            if ($carrier == 'malay') {
                $url = 'http://www.com1express.com/tracking/hawb/' . $expressno;
            } else {
                $url = 'http://www.17track.net/api/Zh-cn/result/express.shtml?et=0&num=' . $expressno;
            }
        } else {
            $url = 'http://www.1001000.cc/page/queryTrack?queryCode=' . $expressno;
        }
        $this->data['link'] = $url;

        $this->template = 'cnstorm/template/order/sendorder_track_business.tpl';

        $this->children = array(
            'common/header_business',
            'common/footer_business');


        $this->response->setOutput($this->render());
    }

    public function remove() {

        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('order/order', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }


        $this->load->model('order/order');
        $this->load->model('account/customer');

        if (isset($this->request->get['order_dede_id'])) {

            $order_dede_id = $this->request->get['order_dede_id'];
            $order_info = $this->model_order_order->getOrderByid($order_dede_id);



            if (isset($order_info['order_status_id']) && ( 10 == $order_info['order_status_id'] || 7 == $order_info['order_status_id'] || 9 == $order_info['order_status_id'] )) {
                $money = $this->customer->getMoney();

                $Newbalance = $money + $order_info['total'];

                $customer_id = $this->customer->getId();

                $result = $this->model_account_customer->editBalance($Newbalance, $customer_id);

                //插入消费记录
                if ($result) {

                    $first_name = $this->customer->getFirstName();

                    $product_info = $this->model_order_order->getOrderProducts($order_dede_id);

                    $data = array(
                        'uid' => $customer_id,
                        'firstname' => $first_name,
                        'payname' => "余额返还",
                        'money' => $order_info['total'],
                        'accountmoney' => $Newbalance,
                        'remark' => $first_name . "取消订单" . $order_dede_id . ",返还订单金额" . $order_info['total'],
                        'remarktype' => '',
                        'remarkdetails' => '',
                        'addtime' => time()
                    );

                    $this->load->model('account/record');

                    $this->model_account_record->addRecord($data);

                    $this->model_order_order->deleteOrder($order_dede_id);
                }
            } else {
                $this->model_order_order->deleteOrder($order_dede_id);
            }
        }
    }

    //删除自助购订单
    public function remove_zizhu() {
        $this->load->model('order/order');
        if (isset($this->request->get['order_id'])) {
            $order_dede_id = $this->request->get['order_id'];
            $this->model_order_order->deleteOrder($order_dede_id);
            $this->openbay->deleteOrder($order_dede_id);
        }
    }

    //补交差价
    public function payback() {

        $this->load->model('order/order');
        $this->load->model('account/customer');
        $this->load->model('account/record');

        if (isset($this->request->post['order_id']) && $this->request->post['order_id']) {

            $order_id = $this->request->post['order_id'];

            $order_info = $this->model_order_order->getOrderdifference($order_id);

            //$order_product_difference = $this->model_order_order->getdifferencetotal($order_id);

            $order_product_difference_array = array();

            $order_product_difference_info = $this->model_order_order->getdifferencetotal($order_id);

            foreach ($order_product_difference_info as $value) {

                if ((float) $value['difference']) {

                    $order_product_difference_array[] = $value['difference'];
                } else {

                    $order_product_difference_array[] = $value['total'];
                }
            }


            $order_product_difference = array_sum($order_product_difference_array);



            $tempmoney = 0.00;

            if ($order_info['difference'] > 0 || $order_product_difference > 0) {

                $user_balance = $this->customer->getMoney();

                $uid = $this->customer->getId();

                $firstname = $this->customer->getFirstName();

                if ($order_product_difference > 0 && !($order_info['difference'] > 0)) {

                    $tempmoney = $order_product_difference + $order_info['order_shipping'] - $order_info['total'];
                } else if ($order_info['difference'] > 0 && !($order_product_difference > 0)) {

                    $tempmoney = $order_info['difference'] - $order_info['order_shipping'];
                } else {

                    $tempmoney = $order_product_difference + $order_info['difference'] - $order_info['total'];
                }

                $newbalance = round($user_balance - $tempmoney, 2);

                if ($newbalance >= 0) {

                    $result = $this->model_account_customer->editBalance($newbalance, $uid); // 扣去账户余额


                    if ($result) {

                        $note = "用户" . $firstname . "补交订单" . $order_id . "的差价" . $tempmoney;

                        $data = array(
                            'uid' => $uid,
                            'firstname' => $firstname,
                            'payname' => "余额支付",
                            'money' => -$tempmoney,
                            'accountmoney' => $newbalance,
                            'remark' => $note,
                            'remarktype' => 1,
                            'remarkdetails' => $order_id,
                            'addtime' => time()
                        );

                        $this->model_account_record->addRecord($data); // 写记录

                        $result = $this->model_order_order->order_updat($order_id, 2);

                        $this->response->setOutput(json_encode($result));
                    }
                }
            } else {

                $this->response->setOutput(2);
            }
        }
    }

    //查询差价
    function query_difference() {

        $this->load->model('order/order');
        $this->load->model('account/customer');
        $this->load->model('account/record');


        if (isset($this->request->post['order_id']) && $this->request->post['order_id']) {

            $order_id = $this->request->post['order_id'];

            $order_info = $this->model_order_order->getOrderdifference($order_id);

            //$order_product_difference = $this->model_order_order->getdifferencetotal($order_id);

            $order_product_difference_array = array();

            $order_product_difference_info = $this->model_order_order->getdifferencetotal($order_id);

            foreach ($order_product_difference_info as $value) {

                if ((float) $value['difference']) {

                    $order_product_difference_array[] = $value['difference'];
                } else {

                    $order_product_difference_array[] = $value['total'];
                }
            }

            $order_product_difference = array_sum($order_product_difference_array);



            $tempmoney = 0.00;

            if ($order_info['difference'] > 0 || $order_product_difference > 0) {

                $user_balance = $this->customer->getMoney();

                $uid = $this->customer->getId();

                $firstname = $this->customer->getFirstName();

                if ($order_product_difference > 0 && !($order_info['difference'] > 0)) {

                    $tempmoney = $order_product_difference + $order_info['order_shipping'] - $order_info['total'];
                } else if ($order_info['difference'] > 0 && !($order_product_difference > 0)) {

                    $tempmoney = $order_info['difference'] - $order_info['order_shipping'];
                } else {

                    $tempmoney = $order_product_difference + $order_info['difference'] - $order_info['total'];
                }
            }

            if ($tempmoney) {
                $tempmoney = number_format($tempmoney, 2);

                $this->response->setOutput(json_encode($tempmoney));
            }
        }
    }

}

?>
