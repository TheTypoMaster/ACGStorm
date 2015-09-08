<?php

class ControllerPaymentPPStandard extends Controller {

    protected function index() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/onlinecharge', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('payment/pp_standard');

        $this->data['text_testmode'] = $this->language->get('text_testmode');

        $this->data['button_confirm'] = $this->language->get('button_confirm');

        $this->data['testmode'] = $this->config->get('pp_standard_test');

        if (!$this->config->get('pp_standard_test')) {
            $this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        //总运费
        $amount_rmb = $this->session->data['order_total'];

        $currency_value = $this->currency->getValue("CNY");

        $amount = number_format($amount_rmb * $currency_value * 1.039, 2);

        //test测试专用
        //$amount = 0.01;

        $this->load->model('checkout/order');
        $this->load->model('account/customer');

        //获取用户id号
        $customer_id = $this->customer->getId();
        //获取订单号
        $order_id_array = $this->session->data['order_id'];

        if (strstr($order_id_array, ",")) {
            $order_id_array = explode(",", $this->session->data['order_id']);
            $order_id_array = array_filter($order_id_array);
            $order_id = end($order_id_array);
        } else {
            $order_id = $order_id_array;
        }

        $order_info = $this->model_checkout_order->getOrder($order_id);

        if ($order_info) {

            if (isset($this->session->data['order_total']))
                $total_amount = $this->session->data['order_total'];

            $this->data['amount'] = $amount;
            $this->data['business'] = $this->config->get('pp_standard_email');
            $this->data['item_name'] = html_entity_decode("支付订单号:" . $this->session->data['order_id'], ENT_QUOTES, 'UTF-8');
            $this->data['item_number'] = $this->session->data['order_id'];
            $this->data['email'] = $order_info['email'];
            $this->data['return'] = $this->url->link('payment/paysuccess');
            $this->data['notify_url'] = $this->url->link('payment/pp_standard/callback', '', 'SSL');
            $this->data['cancel_return'] = $this->url->link('checkout/checkout', '', 'SSL');
            $this->data['custom'] = $this->session->data['order_id'] . '-' . $customer_id . '-' . $amount_rmb;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_standard.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/pp_standard.tpl';
            } else {
                $this->template = 'default/template/payment/pp_standard.tpl';
            }

            $this->render();
        }
    }

    //充值支付
    public function recharge() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/onlinecharge', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('payment/pp_standard');
        $this->data['text_testmode'] = $this->language->get('text_testmode');
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['testmode'] = $this->config->get('pp_standard_test');
        if (!$this->config->get('pp_standard_test')) {
            $this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }
        $this->load->model('account/customer');
        $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->load->model('account/rechargerecord');
            $first_name = $customer_info['firstname'];
            if ($this->request->post['amount']) {
                $amount = $this->request->post['amount'];
                $amount = (float) str_replace(',', '', $amount);
            } else {
                $amount = 0;
            }
            /* guanzhiqiang 20150818 */
            $this->load->model('localisation/currency');
            $currency_value = $this->currency->getValue("CNY");
            $money = ($amount * (1 - 0.039)) / $currency_value; //充值金额拆算后(人民币)
//            if($this->request->post['money']){
//                $money = $this->request->post['money'];
//                $money   = str_replace(',','',$money);
//            }else{
//                $money   = '';
//            }
            //$amount  = str_replace(',','',$amount);
            //$money   = str_replace(',','',$money);

            $accountmoney = $customer_info['money'] + $money;

            $data = array(
                "firstname" => $first_name,
                'amount' => $amount,
                'currency' => "USD",
                'money' => $money,
                'accountmoney' => $accountmoney,
                'paytype' => '1',
                'payname' => "Paypal",
                'addtime' => time(),
                'state' => 0
            );

            $rid = $this->model_account_rechargerecord->addRechargerecord($data);
            $this->data['custom'] = 'cz-' . $rid . '-' . $this->session->data['customer_id'];


            $this->data['business'] = $this->config->get('pp_standard_email');
            $this->data['email'] = $customer_info['email'];
            $this->data['return'] = $this->url->link('payment/paysuccess');
            $this->data['notify_url'] = $this->url->link('payment/pp_standard/callback', '', 'SSL');

            $this->data['item_name'] = html_entity_decode("充值订单号:" . $rid, ENT_QUOTES, 'UTF-8');
            $this->data['item_number'] = $rid;
            $this->data['currency_code'] = "USD";
            $this->data['amount'] = $amount;
            $this->data['rid'] = $rid;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_recharge.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/pp_recharge.tpl';
            } else {
                $this->template = 'default/template/payment/pp_recharge.tpl';
            }

            $this->response->setOutput($this->render());
        }
    }

    //运单支付
    public function waybill() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/onlinecharge', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->language->load('payment/pp_standard');
        //$this->data['text_testmode'] = $this->language->get('text_testmode');
        $this->data['button_confirm'] = $this->language->get('button_confirm');
        $this->data['testmode'] = $this->config->get('pp_standard_test');
        if (!$this->config->get('pp_standard_test')) {
            $this->data['action'] = 'https://www.paypal.com/cgi-bin/webscr';
        } else {
            $this->data['action'] = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
        }

        $this->load->model('account/customer');

        $customer_id = $this->customer->getId();

        $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);


        if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
            $this->load->model('account/rechargerecord');

            $first_name = $customer_info['firstname'];

            if ($this->request->post['yundan_id'])
                $yundan_id = $this->request->post['yundan_id'];

            if ($this->request->post['amount_yundan'])
                $amount_yundan = $this->request->post['amount_yundan'];

            if ($this->request->post['money_yundan'])
                $money_yundan = $this->request->post['money_yundan'];


            $this->data['business'] = $this->config->get('pp_standard_email');

            $this->data['email'] = $customer_info['email'];

            $this->data['return'] = $this->url->link('payment/paysuccess');

            $this->data['notify_url'] = $this->url->link('payment/pp_standard/callback', '', 'SSL');

            $this->data['item_name'] = html_entity_decode("国际运单号:" . $yundan_id, ENT_QUOTES, 'UTF-8');

            $this->data['item_number'] = $yundan_id;

            $this->data['currency_code'] = "USD";

            //test测试专用
            //$amount_yundan = 0.01;

            $this->data['amount'] = $amount_yundan;

            $this->data['rid'] = $yundan_id;

            $this->data['custom'] = 'yd-' . $yundan_id . "-" . $customer_id . "-" . $money_yundan;

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pp_recharge.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/payment/pp_recharge.tpl';
            } else {
                $this->template = 'default/template/payment/pp_recharge.tpl';
            }

            $this->response->setOutput($this->render());
        }
    }

    public function callback() {

        if (isset($this->request->post['custom'])) {

            $order_id = $this->request->post['custom'];
        } else {

            $order_id = 0;
        }

        $this->log->log_paypal('PP_STANDARD :: kenne_back_value: ' . $this->request->post['custom']);

        if (strstr($order_id, 'cz')) {

            $request = 'cmd=_notify-validate';

            foreach ($this->request->post as $key => $value) {
                $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }

            if (!$this->config->get('pp_standard_test')) {
                $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
            } else {
                $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
            }

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            if (!$response) {
                $this->log->log_paypal('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            }

            if ($this->config->get('pp_standard_debug')) {
                $this->log->log_paypal('PP_STANDARD :: IPN REQUEST: ' . $request);
                $this->log->log_paypal('PP_STANDARD :: IPN RESPONSE: ' . $response);
            }

            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {

                $payment_status = $this->request->post['payment_status'];

                if (strcmp($payment_status, 'Completed') == 0) {

                    $rid_array = explode("-", $order_id);
                    $rid = $rid_array[1];
                    $customer_id = $rid_array[2];

                    $data = array(
                        'state' => 1,
                        'successtime' => time(),
                        'remark' => "OK",
                        'rid' => $rid
                    );

                    $this->load->model('account/rechargerecord');
                    $this->load->model('account/customer');
                    
                    //guanzhiqiang 20150818 修复账户金额漏洞
                    $topup_info = $this->model_account_rechargerecord->getInfo($rid);
                    if ($topup_info['state'] == 0) {
                        if ($this->model_account_rechargerecord->updateRechargerecord($data)) {
                            //$money = $this->model_account_rechargerecord->getMoneybyid($rid);
                            //$this->model_account_customer->editBalance($money, $customer_id);
                            $this->model_account_customer->topup($topup_info['money'], $customer_id);
                        }
                    }
                }
            }

            curl_close($curl);
        } else if (strstr($order_id, 'yd')) {

            $request = 'cmd=_notify-validate';

            foreach ($this->request->post as $key => $value) {
                $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
            }

            if (!$this->config->get('pp_standard_test')) {
                $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
            } else {
                $curl = curl_init('https://www.sandbox.paypal.com/cgi-bin/webscr');
            }

            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($curl);

            if (!$response) {
                $this->log->log_paypal('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
            }

            if ($this->config->get('pp_standard_debug')) {
                $this->log->log_paypal('PP_STANDARD :: IPN REQUEST: ' . $request);
                $this->log->log_paypal('PP_STANDARD :: IPN RESPONSE: ' . $response);
            }


            if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {

                $payment_status = $this->request->post['payment_status'];

                if (strcmp($payment_status, 'Completed') == 0) {
                    $sendorder_id_array = explode("-", $order_id);
                    $sendorder_id = $sendorder_id_array[1];
                    $customer_id = $sendorder_id_array[2];
                    $amount_yundan = $sendorder_id_array[3];
                    $amount_yundan = str_replace(',', '', $amount_yundan);

                    $sendorder_id_array = explode(',', $sendorder_id);
                    $sendorder_id_array = array_filter($sendorder_id_array);

                    foreach ($sendorder_id_array as $sendorder_id) {
                        $data = array(
                            'state' => 1,
                            'sid' => $sendorder_id
                        );

                        $this->load->model('order/order');
                        $this->model_order_order->Updatestate($data);

                        //更新运单所属订单状态
                        $oids_str = $this->model_order_order->getoidBySid($sendorder_id);

                        $oids = explode(",", $oids_str);

                        $oids = array_filter($oids);

                        $this->model_order_order->order_updat($oids, '8');

                        //插入消费记录
                        $this->load->model('account/customer');
                        $customer_info = $this->model_account_customer->getCustomer($customer_id);
                        $first_name = $customer_info['firstname'];
                        $accountmoney = $customer_info['money'];
                        $data = array(
                            'firstname' => $first_name,
                            'payname' => 'Paypal支付',
                            'money' => -$amount_yundan,
                            'accountmoney' => $accountmoney,
                            'remark' => "提交运单费用，运单ID：" . $sendorder_id,
                            'remarktype' => 2,
                            'remarkdetails' => $sendorder_id,
                            'addtime' => time()
                        );

                        $this->load->model('account/record');
                        $this->model_account_record->addRecord($data);
                    }
                }
            }

            curl_close($curl);
        } else {

            $this->load->model('checkout/order');

            $order_id_array = explode("-", $order_id);
            $order_id = $order_id_array[0];
            $customer_id = $order_id_array[1];
            $amount = $order_id_array[2];
            $amount = str_replace(',', '', $amount);

            $orders_id = explode(",", $order_id);

            $order_id = $orders_id[0];

            $order_info = $this->model_checkout_order->getOrder($order_id);

            if ($order_info) {
                $request = 'cmd=_notify-validate';

                foreach ($this->request->post as $key => $value) {
                    $request .= '&' . $key . '=' . urlencode(html_entity_decode($value, ENT_QUOTES, 'UTF-8'));
                }

                if (!$this->config->get('pp_standard_test')) {
                    $curl = curl_init('https://www.paypal.com/cgi-bin/webscr');
                } else {
                    $curl = curl_init('http://www.sandbox.paypal.com/cgi-bin/webscr');
                }

                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_TIMEOUT, 30);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

                $response = curl_exec($curl);

                if (!$response) {
                    $this->log->log_paypal('PP_STANDARD :: CURL failed ' . curl_error($curl) . '(' . curl_errno($curl) . ')');
                }

                if ($this->config->get('pp_standard_debug')) {
                    $this->log->log_paypal('PP_STANDARD :: IPN REQUEST: ' . $request);
                    $this->log->log_paypal('PP_STANDARD :: IPN RESPONSE: ' . $response);
                }

                if ((strcmp($response, 'VERIFIED') == 0 || strcmp($response, 'UNVERIFIED') == 0) && isset($this->request->post['payment_status'])) {

                    $payment_status = $this->request->post['payment_status'];

                    if (strcmp($payment_status, 'Completed') == 0) {
                        $this->load->model('checkout/order');
                        $order_status['payed'] = '2';
                        $this->model_checkout_order->update_status($orders_id, $order_status['payed']);

                        //插入消费记录
                        $this->load->model('account/customer');
                        $customer_info = $this->model_account_customer->getCustomer($customer_id);
                        $first_name = $customer_info['firstname'];
                        $accountmoney = $customer_info['money'];

                        $account_order = implode(",", $orders_id);
                        $data = array(
                            'uid' => $customer_id,
                            'firstname' => $first_name,
                            'payname' => 'Paypal支付',
                            'money' => -$amount,
                            'accountmoney' => $accountmoney,
                            'remark' => "提交代购订单费用，订单ID：" . $account_order,
                            'remarktype' => 1,
                            'remarkdetails' => $account_order,
                            'addtime' => time()
                        );


                        $this->load->model('account/record');
                        $this->model_account_record->addRecord($data);
                    }
                }

                curl_close($curl);
            }
        }
    }

}

?>
