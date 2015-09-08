<?php

/* * ****************************************************************************
 * @description：国际运单列表及相关操作
 * @author： cnstorm01@cnstorm.com
 * @date:     2014.7.24
 * ***************************************************************************** */

class ControllerOrderSendorder extends Controller {

//国际运单
    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('order/order');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('order/order');
        $this->load->model('order/sendorder');

        if (isset($this->request->get['username_id'])) {
            $username_id = $this->request->get['username_id'];
        } else {
            $username_id = null;
        }


        if (isset($this->request->get['order_status_id'])) {
            $order_status_id = $this->request->get['order_status_id'];
        } else {
            $order_status_id = -1;
        }
        $this->data['order_status_id'] = $order_status_id;

        if (isset($this->request->get['order_quxiao_id'])) {
            $order_quxiao_id = $this->request->get['order_quxiao_id'];

            $sendorder_info = $this->model_order_order->getSendorderById($order_quxiao_id);
            if ($sendorder_info['oids']) {
                $oids = $sendorder_info['oids'];
            } else {
                $oids = '';
            }
            if (strstr($oids, ','))
                $oids = explode(",", $oids);
            else
                $oids = $oids;



			$this->model_order_order->order_updat($oids, 6);
			$customer_id=$this->customer->getId();
			//退还余额到账户 已经付款
			if($sendorder_info['state']== 1 ){
				$user_balance = $this->customer->getMoney();
				$user_balance += $sendorder_info['totalfee'];
				$customer = $this->model_order_order->guoji_quxiao($order_quxiao_id,$user_balance,$customer_id);
			}else{
				//退还余额到账户 已经付款
				$this->model_order_order->no_payment_guoji_quxiao($order_quxiao_id,$customer_id);
			}
			$this->load->model('account/customer');
			$shipping_number = $this->model_account_customer->get_shippingnumber();


            if ($shipping_number - 1) {

                $this->model_account_customer->del_shippingnumber();
            }
        } else {
            $order_quxiao_id = null;
        }

        if (isset($this->request->get['consignee'])) {
            $consignee = $this->request->get['consignee'];
        } else {
            $consignee = null;
        }

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

        $username_id = $this->session->data['customer_id'];
        $this->data['customer_id'] = $this->session->data['customer_id'];

        $limit = 10;

        $data = array(
            'username_id' => $username_id,
            'order_status_id' => $order_status_id,
            'consignee' => $consignee,
            'start' => ($page - 1) * $limit,
            'limit' => $limit);

        $data_total = array(
            'username_id' => $username_id,
            'order_status_id' => $order_status_id,
            'consignee' => $consignee,
        );

        $order_statuses = $this->model_order_order->getYundanOrderStatuses();

        $data_daigou = array(
            'username_id' => $this->customer->getId()
        );
        $this->data['num_daigou'] = $this->model_order_order->getYundanTotalOrders($data_daigou);
        $customerId = $this->customer->getId();
        foreach ($order_statuses as $k => $status) {
            $totalSignalStatus = $this->model_order_order->totalYundanSignalStatus($status['id'], $customerId);
            $this->data['order_statuses'][$k] = array(
                'order_status_id' => $status['id'],
                'name' => $status['name'],
                'total' => $totalSignalStatus['total']
            );
        }
        if (isset($this->request->get['order_status_id']) && $this->request->get['order_status_id'] >= 0) {
            $this->data['pass_order_status_id'] = $this->request->get['order_status_id'];
        }
        $this->data['consignee'] = $consignee;
        $order_total = $this->model_order_order->getTotalOrders(1);
        $this->data['filter_order_status_id'] = $order_status_id; //
        $this->data['kuaidi_query'] = '&time=' . time() . '&check=' . sha1(time() . 'cnstorm');
        $results = $this->model_order_sendorder->select_send_porduct($data);

        $results_total = $this->model_order_sendorder->total_yundan_porduct($data_total);

        $status_yundan = $this->model_order_order->sendorder_status();

        $this->data['status_yundan'] = $status_yundan;
        foreach ($results as $result) {
            //$express_guoji = $this->model_order_order->express_guoji($result['express']);
            $status_yundan_id = $this->model_order_order->sendorder_status_id($result['state']);
            if (empty($status_yundan_id)) {
                $status_yundan_id[0]['name'] = 'unknow';
            }

            $this->data['orders'][] = array(
                'sid' => $result['sid'],
                'consignee' => $result['consignee'],
                'addtime' => $result['addtime'],
                'express_guoji' => $result['deliveryname'],
                'state' => $result['state'],
                'countweight' => $result['countweight'],
                'totalfee' => $result['totalfee'],
                'express' => $result['deliveryname'],
                'state_name' => $status_yundan_id[0]['name'],
                'country' => $result['country'],
                'comment' => $result['comment'],
                'kuaiai_on' => $result['sn']
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

        $pagination->url = $this->url->link('order/sendorder', '&page={page}');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'cnstorm/template/order/sendorder_business.tpl';

        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {

            $this->template = 'cnstorm/template/order/sendorder_business_list.tpl';
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

    public function details() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->get['sid'])) {
            $send_id = $this->request->get['sid'];
        } else {
            $send_id = null;
        }
        $this->load->model('order/order');

        $result = $this->model_order_order->getSendorderById($send_id);

        if ($this->customer->getFirstName() == $result['uname']) {  //安全过滤防偷窥
            $status_yundan[0]['name'] = '';
            $status_yundan = $this->model_order_order->sendorder_status_id($result['state']);
            $this->data['status']="";
            if(!empty($status_yundan)){
                 $this->data['status'] = $status_yundan[0]['name'];
            }
           
            $oids = explode(",", $result['oids']);

            $this->data['order_products'] = array();

            foreach ($oids as $oid) {

                $order_products = $this->model_order_order->getOrderProducts($oid);
                if (!empty($order_products)) {
                    $this->data['order_products'][] = $order_products;
                }
            }

            $this->data['result'] = $result;

            $this->template = 'cnstorm/template/order/sendorder_details.tpl';
            /*$this->children = array(
                'common/header',
                'common/column_left',
                'common/footer');*/
				$this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);	
            $this->response->setOutput($this->render());
        } else {
            echo "<script type='text/javascript'>alert('warning:Permission denied! -  警告：权限不足！');history.back();</script>";
        }
    }

    public function confirm() {
        $this->load->model('order/sendorder');
        $this->load->model('order/order');
        $this->load->model('account/customer');

        if (isset($this->request->get['Confirm_id'])) {
            $Confirm_id = $this->request->get['Confirm_id'];
            $customer = $this->model_order_sendorder->Confirm($Confirm_id);

            //赠送成长值
            $growth = $this->customer->getGrowth();
            $totalfee = $this->model_order_order->gettotalfeeBySid($Confirm_id);
            $add_growth = (int) $totalfee;
            if ($add_growth < 300) {
                $total = $growth + $add_growth;
            } else {
                $total = $growth + 300;
            }
            $this->model_account_customer->editGrowth($total);
        }

        $this->response->setOutput(json_encode('ok'));
    }

    public function comment() {
        if (isset($this->request->post['massageImage']) && !empty($this->request->post['massageImage'])) {
            $massageImage = $this->request->post['massageImage'];
            $massageImage = implode(',', $massageImage);
        } else {
            $massageImage = null;
        }

        if (isset($this->request->post['sid'])) {
            $send_id = $this->request->post['sid'];
        } else {
            $send_id = null;
        }

        if (isset($this->request->post['comment'])) {
            $comment = $this->request->post['comment'];
        } else {
            $comment = null;
        }
        //	echo   $send_id,$comment;

        if (isset($this->request->post['evaluate'])) {
            $evaluate = $this->request->post['evaluate'];
        } else {
            $evaluate = null;
        }
        if (isset($this->request->post['semblance'])) {
            $semblance = $this->request->post['semblance'];
        } else {
            $semblance = null;
        }
        if (isset($this->request->post['manner'])) {
            $manner = $this->request->post['manner'];
        } else {
            $manner = null;
        }
        if (isset($this->request->post['delivery'])) {
            $delivery = $this->request->post['delivery'];
        } else {
            $delivery = null;
        }

        if (isset($this->request->post['efficient'])) {
            $efficient = $this->request->post['efficient'];
        } else {
            $efficient = null;
        }

        $data = array(
            'massageImage' => $massageImage,
            'send_id' => $send_id,
            'evaluate' => $evaluate,
            'semblance' => $semblance,
            'manner' => $manner,
            'delivery' => $delivery,
            'efficient' => $efficient,
            'comment' => $comment
        );
        $this->load->model('order/sendorder');

        $customer = $this->model_order_sendorder->addComment($data);

        $scores = $this->customer->getScore();
        $usrname = $customer['uname'];
        $username_id = $customer['uid'];

        if ($customer['totalfee'] >= $customer['volumn_price']) {
            $scoreget = $customer['totalfee'];
        } else {
            $scoreget = $customer['volumn_price'];
        }
        $newscore = $scores + $scoreget;

        $this->load->model('account/record');
        $this->load->model('account/customer');
        $this->model_account_customer->editScores($newscore);

        $insert_score_record = array(
            'uid' => $username_id,
            'firstname' => $usrname,
            'remark' => '评价运单得积分' . $scoreget,
            'score' => '+' . $scoreget,
            'type' => 1,
            'totalscore' => $newscore
        );

        $this->model_account_record->addScoreRecord($insert_score_record);
        //评论获取成长值
        $growth = $this->customer->getGrowth();
        $total = $growth + 10;
        $this->model_account_customer->editGrowth($total);

        $this->response->setOutput(json_encode(1));
    }

    public function payback() {

        $this->load->model('order/sendorder');
        $this->load->model('order/order');
        $this->load->model('account/customer');
        $this->load->model('account/record');

        if (isset($this->request->post['sid']) && $this->request->post['sid']) {

            $sid = $this->request->post['sid'];

            $sendorder_info = $this->model_order_sendorder->getSendorderbysid($sid);

            if ($sendorder_info['countmoney'] > 0) {

                $freight = $sendorder_info['freight'];

                $countmoney = $sendorder_info['countmoney'];

                $user_balance = $this->customer->getMoney();

                $uid = $this->customer->getId();

                $firstname = $this->customer->getFirstName();

                $sendorder_money = $freight;

                $tempmoney = $countmoney - $sendorder_money;

                $newbalance = round($user_balance - $tempmoney, 2);

                if ($newbalance >= 0) {

                    $result = $this->model_account_customer->editBalance($newbalance, $uid); // 扣去账户余额


                    if ($result) {

                        $note = "用户" . $firstname . "补交运单" . $sid . "的差价金额" . $tempmoney;

                        $data = array(
                            'uid' => $uid,
                            'firstname' => $firstname,
                            'payname' => "余额支付",
                            'money' => -$tempmoney,
                            'accountmoney' => $newbalance,
                            'remark' => $note,
                            'remarktype' => 2,
                            'remarkdetails' => $sid,
                            'addtime' => time()
                        );

                        $this->model_account_record->addRecord($data); // 写记录

                        $data1 = array(
                            'sid' => $sid,
                            'state' => "1"
                        );

                        $result = $this->model_order_order->Updatestate($data1);

                        $this->model_order_sendorder->Updatefreightbysid($countmoney, $sid);

                        $this->response->setOutput(json_encode(1));
                    }
                }
            } else {

                $this->response->setOutput(json_encode(2));
            }
        }
    }

    //待补差价状态时，更改运输方式
    public function change_delivery() {

        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('order/sendorder', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->get['sid']) && ($this->request->get['sid'])) {

            $sid = $this->request->get['sid'];

            $this->load->model('order/sendorder');
            $this->load->model('account/customer');

            $business = $this->model_account_customer->getBusiness();

            //获取运单的信息
            $sendorder_info = $this->model_order_sendorder->getSendorderById($sid);

            //已经付费
            $payed_totalfee = $sendorder_info['totalfee'];

            //判断运单中订单是否含有敏感商品
            $sensitive_array = $this->model_order_sendorder->getsensitive($sendorder_info['oids']);

            foreach ($sensitive_array as $key => $value) {
                $sensitive[$key] = $value['order_sensitive'];
            }

            if (in_array(2, $sensitive)) {
                $sensitive = 1;
            } else {
                $sensitive = 0;
            }

            //获取所有匹配的运输方式
            $data = array(
                'name' => $sendorder_info['country'],
                'sensitive' => $sensitive
            );

            $delivery_info = $this->model_order_sendorder->getdeliveryinfo($data);

            if ($sendorder_info['countweight'] < 21000 || !$business) {
                for ($i = 0; $i < count($delivery_info); $i++) {
                    if (107 == $delivery_info[$i]['did']) {
                        unset($delivery_info[$i]);
                        break;
                    }
                }
            }

            foreach ($delivery_info as &$delivery) {

                $planned_totalfee = $this->totalfee($delivery, $sendorder_info);

                $delivery['difference'] = ($planned_totalfee - $payed_totalfee) + ($sendorder_info['countmoney'] - $payed_totalfee);
            }

            $this->data['delivery_info'] = $delivery_info;

            $this->data['sendorder_did'] = $sendorder_info['did'];

            $this->data['sid'] = $sid;

            //获取本运单所有适用的运输方式和应该补交的差价
            $this->template = 'cnstorm/template/order/user_list_sendorder_change.tpl';

            $this->response->setOutput($this->render());
        }
    }

    //获取相应运输方式各项费用以及总费用
    protected function totalfee($delivery_info, $sendorder_info) {

        //获取用户会员等级
        $utype = $this->customer->getUtype();

        $total_weight = $sendorder_info['countweight'];
        //运费
        $freight = 0.00;

        if ($sendorder_info['oldtotalfee']) {

            if ($total_weight <= $delivery_info['first_weight']) {

                $freight = (float) $delivery_info['first_fee'];
            } else if ($total_weight > $delivery_info['first_weight'] && $total_weight <= 30000) {

                $first_fee = $delivery_info['first_fee'];

                $continue_fee = $delivery_info['continue_fee'] * ceil(($total_weight - $delivery_info['first_weight']) / $delivery_info['continue_weight']);

                $freight = (float) $first_fee + (float) $continue_fee;
            } else {

                $first_fee = $delivery_info['first_fee'];

                $continue_fee = $delivery_info['continue_fee'] * ceil(($total_weight - $delivery_info['first_weight']) / $delivery_info['continue_weight']);

                $subcontracting_fee = $delivery_info['first_fee'] - $delivery_info['continue_fee'];

                $freight = (float) $first_fee + (float) $continue_fee + (float) $subcontracting_fee;
            }

            //获取订单总费用
            $total_fee = $this->model_order_sendorder->getTotalByoid($sendorder_info['oids']);

            $unpack = $sendorder_info['dabao'];

            $checkorder = $sendorder_info['dingdan'];

            $wrapper = $sendorder_info['baozhuang'];

            $this->load->model('account/customer');

            //个人版or商户版
            $business = $this->model_account_customer->getBusiness();

            //打包策略费用
            if ($business) {
                if (0 == $unpack) {
                    $dabaofee = 0.00;
                } else if (1 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.012;
                } else if (2 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.025;
                } else if (3 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.035;
                }

                //订单处理费用
                if (0 == $checkorder) {
                    $checkorderfee = 0.00;
                } else if (1 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.018;
                } else if (2 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.029;
                } else if (3 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.038;
                }

                //包装耗材
                if (1 == $wrapper) {
                    $wrapperfee = ($freight + $total_fee) * 0.008;
                } else if (2 == $wrapper) {
                    $wrapperfee = ($freight + $total_fee) * 0.018;
                } else {
                    $wrapperfee = 0;
                }
            } else {

                if (0 == $unpack) {
                    $dabaofee = 0.00;
                } else if (1 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.01;
                } else if (2 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.02;
                } else if (3 == $unpack) {
                    $dabaofee = ($freight + $total_fee) * 0.03;
                }

                //订单处理费用
                if (0 == $checkorder) {
                    $checkorderfee = 0.00;
                } else if (1 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.018;
                } else if (2 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.029;
                } else if (3 == $checkorder) {
                    $checkorderfee = ($freight + $total_fee) * 0.038;
                }

                //包装耗材
                if (1 == $wrapper) {
                    $wrapperfee = ($freight + $total_fee) * 0.015;
                } else if (2 == $wrapper) {
                    $wrapperfee = ($freight + $total_fee) * 0.025;
                } else {
                    $wrapperfee = 0;
                }
            }


            //增值服务费用
            $zengzhifee = $sendorder_info['zengzhifee'];

            $serverfee = $dabaofee + $checkorderfee + $zengzhifee;

            $oldtotalfee = round(($freight + $serverfee + $wrapperfee + 8.00), 2);

            if (1 == $utype) {
                $totalfee = round($oldtotalfee * 0.99, 2);
            } else if (2 == $utype) {
                $totalfee = round($oldtotalfee * 0.98, 2);
            } else if (3 == $utype) {
                $totalfee = round($oldtotalfee * 0.97, 2);
            } else if (4 == $utype) {
                $totalfee = round($oldtotalfee * 0.96, 2);
            } else if (5 == $utype) {
                $totalfee = round($oldtotalfee * 0.95, 2);
            } else if (0 == $utype) {
                $totalfee = $oldtotalfee;
            }

            //如果有优惠卷
            if ($sendorder_info['couponid']) {

                $this->load->model('account/coupon');

                $cid = $sendorder_info['couponid'];

                $coupon_info = $this->model_account_coupon->getCouponbycid($cid);

                if ($coupon_info['money']) {

                    $totalfee = $totalfee - $coupon_info['money'];
                }
            }

            //积分信息
            if ($sendorder_info['usescore']) {

                $scoreuse = $sendorder_info['usescore'];

                $totalfee = $totalfee - round($scoreuse / 100, 2);
            }


            return $totalfee;
        } else {

            $serverfee = $sendorder_info['serverfee'];

            if ($total_weight <= $delivery_info['first_weight']) {

                $freight = (float) $delivery_info['first_fee'];
            } else if ($total_weight > $delivery_info['first_weight'] && $total_weight <= 30000) {

                $first_fee = $delivery_info['first_fee'];

                $continue_fee = $delivery_info['continue_fee'] * ceil(($total_weight - $delivery_info['first_weight']) / $delivery_info['continue_weight']);

                $freight = (float) $first_fee + (float) $continue_fee;
            } else {

                $first_fee = $delivery_info['first_fee'];

                $continue_fee = $delivery_info['continue_fee'] * ceil(($total_weight - $delivery_info['first_weight']) / $delivery_info['continue_weight']);

                $subcontracting_fee = $delivery_info['first_fee'] - $delivery_info['continue_fee'];

                $freight = (float) $first_fee + (float) $continue_fee + (float) $subcontracting_fee;
            }

            $oldtotalfee = round(($freight + $serverfee + 8.00), 2);

            if (1 == $utype) {
                $totalfee = round($oldtotalfee * 0.99, 2);
            } else if (2 == $utype) {
                $totalfee = round($oldtotalfee * 0.98, 2);
            } else if (3 == $utype) {
                $totalfee = round($oldtotalfee * 0.97, 2);
            } else if (4 == $utype) {
                $totalfee = round($oldtotalfee * 0.96, 2);
            } else if (5 == $utype) {
                $totalfee = round($oldtotalfee * 0.95, 2);
            } else if (0 == $utype) {
                $totalfee = $oldtotalfee;
            }

            //如果有优惠卷
            if ($sendorder_info['couponid']) {

                $this->load->model('account/coupon');

                $cid = $sendorder_info['couponid'];

                $coupon_info = $this->model_account_coupon->getCouponbycid($cid);

                if ($coupon_info['money']) {

                    $totalfee = $totalfee - $coupon_info['money'];
                }
            }

            //积分信息
            if ($sendorder_info['usescore']) {

                $scoreuse = $sendorder_info['usescore'];

                $totalfee = $totalfee - round($scoreuse / 100, 2);
            }


            return $totalfee;
        }
    }

    public function track_details() {
        $expressno = $this->request->get['sn'];

        if (isset($this->request->get['carrier'])) {
            $carrier = $this->request->get['carrier'];
            $this->data['carrier'] = $carrier;
            if ($carrier == 'malay') {
                $url = 'http://www.com1express.com/tracking/hawb/' . $expressno;
            } else if ($carrier == 'au') {
                $url = 'http://www.lwe.com.hk/tracking/track?hawb=' . $expressno;

                /* 物流跟踪正则抓取 guanzhiqiang 20150518 */
                $content = file_get_contents($url);
                preg_match_all('/<div class="row-fluid item-detail">(.*)<\/div><\/div>/iUs', $content, $out, PREG_SET_ORDER);
                if ($out) {
                    $this->data['au_text'] = $out[0][0];
                } else {
                    $this->data['au_text'] = "跟踪信息无法获取，請联系客服了解更多资讯谢谢！";
                }
            } else if ($carrier == 'chinapost') {
                $url = 'http://www.17track.net/api/Zh-cn/result/express.shtml?et=0&num=' . $expressno;
            } else {
                $url = 'http://www.17track.net/api/Zh-cn/result/express.shtml?et=100001&num=' . $expressno;
            }
        } else {
            $url = 'http://www.1001000.cc/page/queryTrack?queryCode=' . $expressno;

            /* 物流跟踪正则抓取 boss 20150520 */
            $content = file_get_contents($url);
            preg_match_all('/<div class="admin_table" style=" HEIGHT: 280px;">(.*)<\/div>/iUs', $content, $out, PREG_SET_ORDER);
            if ($out) {
                $this->data['track_text'] = $out[0][0];
            } else {
                $this->data['au_text'] = "跟踪信息无法获取，請联系客服了解更多资讯谢谢！";
            }
        }
        $this->data['link'] = $url;

        $this->template = 'cnstorm/template/order/sendorder_track.tpl';

        $this->children = array(
            'common/header_business',
            'common/footer_business');


        $this->response->setOutput($this->render());
    }

    //余额付款更改运输方式
    public function pay_difference() {

        //判断用户登录是否失效
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('order/sendorder', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }


        $this->load->model('order/sendorder');
        $this->load->model('order/order');
        $this->load->model('account/customer');
        $this->load->model('account/record');


        if (isset($this->request->post['sid']) && $this->request->post['sid']) {
            $sid = $this->request->post['sid'];
        }

        if (isset($this->request->post['did']) && $this->request->post['did']) {
            $did = $this->request->post['did'];
        }

        if (isset($this->request->post['de_difference'])) {
            $de_difference = $this->request->post['de_difference'];
        }


        $user_balance = $this->customer->getMoney();

        $uid = $this->customer->getId();

        $firstname = $this->customer->getFirstName();

        $newbalance = round($user_balance - $de_difference, 2);

        if ($newbalance >= 0) {

            $result = $this->model_account_customer->editBalance($newbalance, $uid); // 扣去账户余额

            if ($result) {

                if ($de_difference >= 0) {

                    $note = "用户" . $firstname . "更改运单" . $sid . "的运输方式，补交差价" . $de_difference;
                } else {
                    $note = "用户" . $firstname . "更改运单" . $sid . "的运输方式，返还差价" . abs($de_difference);
                }


                $data = array(
                    'uid' => $uid,
                    'firstname' => $firstname,
                    'payname' => "余额支付",
                    'money' => -$de_difference,
                    'accountmoney' => $newbalance,
                    'remark' => $note,
                    'remarktype' => 2,
                    'remarkdetails' => $sid,
                    'addtime' => time()
                );

                $this->model_account_record->addRecord($data); // 写记录
                //更改运输方式
                $deliveryname = $this->model_order_sendorder->getdeliveryname($did);

                $up_data = array(
                    'sid' => $sid,
                    'did' => $did,
                    'deliveryname' => $deliveryname
                );

                $this->model_order_sendorder->updatedelivery($up_data);

                if ($de_difference) {

                    $data1 = array(
                        'sid' => $sid,
                        'state' => "1"
                    );

                    $this->model_order_order->Updatestate($data1);

                    //更改运单已付总额
                    $sendorder_info = $this->model_order_sendorder->getSendorderById($sid);

                    $new_totalfee = $sendorder_info['totalfee'] + $de_difference;

                    $data2 = array(
                        'sid' => $sid,
                        'totalfee' => $new_totalfee
                    );

                    $this->model_order_sendorder->updatetotalfee($data2);
                }

                $this->response->setOutput(json_encode(1));
            }
        } else {

            $this->response->setOutput(json_encode(2));
        }
    }

}

?>