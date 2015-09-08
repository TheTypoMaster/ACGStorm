<?php

 /**
 * ControllerPaymentAlipay
 * 
 * @package 支付宝支付接口处理类  
 * @author kennewei
 * @copyright www.acgstorm.com
 * @version 2014.07.09
 * @access public
 */


require_once("alipay.php");
require_once("alipay_function.php");
require_once("alipay_notify.php");
require_once("alipay_service.php");


class ControllerPaymentAlipay extends Controller {

    public function index() {
        
        $currency_code = 'CNY';
        $_input_charset = "utf-8";
        $sign_type = "MD5";
        $transport = "http";
        $notify_url = HTTP_SERVER . 'catalog/controller/payment/alipay_callback.php';
        $return_url = HTTPS_SERVER . 'index.php?route=payment/paysuccess';
        
       
        $trade_type = $this->config->get('alipay_trade_type');
        $partner = $this->config->get('alipay_partner');
        $security_code = $this->config->get('alipay_security_code');
        $item_name = $this->config->get('config_store');
        $seller_email = $this->config->get('alipay_seller_email');
        
        $trade_type_international    = "alipay.trade.direct.forcard.pay";
        $partner_international       = "2088511796637269";
        //$partner_international       = "2088011357497434";
        $security_code_international = "lzwlxledgojm22pz0vgkjtjkm907agf2";
        //$security_code_international = "qo58xp4g1ywibtiiyns1gftw5mbv5rs3";
        $seller_email_international  = "zhifubao3@cnstorm.com";
        //$seller_email_international  = "zhifubao@cnstorm.com";
         
        $this->load->library('encryption');

        $encryption = new Encryption($this->config->get('config_encryption'));

        $this->load->model('checkout/order');
        $this->load->model('account/customer');
        
        if(isset($this->session->data['customer_id'])) {
        
            $customer_id   = $this->customer->getId();
    
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['action']) && ("recharge" == $this->request->post['action'])) {
    
                //$return_url = HTTPS_SERVER . 'index.php?route=account/rmbaccount';
    
                //人民币充值金额
                if (isset($this->request->post['amount']) && $this->request->post['amount'])
                {
                    $amount = $this->request->post['amount'];
                    
                } else {
                    
                    $amount = '';
                }
    
                if (isset($this->request->post['money']) && $this->request->post['money'])
                {
                    $money = $this->request->post['money'];
                    
                } else {
                    
                    $money = '';
                }
    
                $this->load->model('account/rechargerecord');
                 
                
                $first_name    = $this->customer->getFirstName();
                $accountmoney  = $this->customer->getMoney();
                
                if (isset($this->request->post['js_return']) && $this->request->post['js_return']) {
                    
                    $security_code = $security_code_international;
                    $extend_param = $this->request->post['js_return'];
                    //$notify_url = HTTP_SERVER . 'catalog/controller/payment/callback_international.php';
                    
                    if (isset($this->request->post['type']) && $this->request->post['type'])
                        $type = $this->request->post['type'];
                    
                    $data = array(
                        "firstname" => $first_name,
                        'amount' => $amount,
                        'currency' => $currency_code,
                        'money' => $money,
                        'paytype' => '3',
                        'payname' => "支付宝国际信用卡",
                        'accountmoney' => $accountmoney + $money,
                        'addtime' => time(),
                        'state' => 0
                    );
                    $rid = $this->model_account_rechargerecord->addRechargerecord($data);
                   
                    $parameter = array(
                        "service" => $trade_type_international,
                        "partner" => $partner_international,
                        "return_url" => $return_url,
                        "notify_url" => $notify_url,
                        "_input_charset" => trim(strtolower($_input_charset)),
                        "subject" => $item_name . ' Order:' . $rid,
                        "out_trade_no" => 'cz-' . $rid . '-' . $customer_id,
                        "default_bank" => "cybs-" . $type,
                        "extend_param"	=> str_replace(" ","",$extend_param),
                        "total_fee"	=> $amount,
                        "currency"	=> $currency_code,
                        "paymethod" => trim("jvm-3d"),
                        "sign_type"  => "MD5",
                        "sign"       => $security_code_international,
                        "seller_logon_id" => $seller_email_international
                    );
                    
                } else {
                    
                    if(isset($this->request->post['recharge_defaultbank']) && $this->request->post['recharge_defaultbank']) {
                        
                         $defaultbank = $this->request->post['recharge_defaultbank'];
                         $payname = "网络银行";
                            
                    }else{
                        
                         $defaultbank = '';
                         $payname = "支付宝";
                    }

                    $data = array(
                        "firstname" => $first_name,
                        'amount' => $amount,
                        'currency' => $currency_code,
                        'money' => $money,
                        'paytype' => '2',
                        'payname' => $payname,
                        'accountmoney' => $accountmoney + $money,
                        'addtime' => time(),
                        'state' => 0
                    );
                    $rid = $this->model_account_rechargerecord->addRechargerecord($data);
                    

                    $parameter = array(
                        "paymethod" => "bankPay",
                        "defaultbank" => $defaultbank,
                        "service" => $trade_type,
                        "partner" => $partner,
                        "return_url" => $return_url,
                        "notify_url" => $notify_url,
                        "_input_charset" => $_input_charset,
                        "subject" => $item_name . ' Order:' . $rid,
                        "body" => 'Owner ' . $first_name,
                        "out_trade_no" => 'cz-' . $rid . '-' . $customer_id,
                        "total_fee" => $amount,
                        "payment_type" => "1",
                        "seller_email" => $seller_email
                    );
                }
    
                
                $alipay = new alipay_service($parameter, $security_code, $sign_type);
                $action = $alipay->build_url();
                $this->response->setOutput(json_encode($action));
            }
            
            
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['action']) && ("waybill" == $this->request->post['action'])) {
                
                //$return_url = HTTPS_SERVER . 'index.php?route=order/order/order_guoji';
                
                if (isset($this->request->post['js_return']) && $this->request->post['js_return']) {
                    
                    //$notify_url = HTTP_SERVER . 'catalog/controller/payment/callback_international.php';
    
                    if (isset($this->session->data['waybill'])) {
                    $this->load->model('order/order');
                         $waybill = $this->session->data['waybill'];
    
                    if (isset($this->request->post['type']) && $this->request->post['type'])
                        $type = $this->request->post['type'];
    
                    
    
                     if (isset($this->request->post['amount']) && $this->request->post['amount']) {
                        $amount = $this->request->post['amount'];
                    }
                    
                    //测试专用
                    //$amount = 0.01;
                    
                    $extend_param = $this->request->post['js_return'];
                      
                    $security_code = $security_code_international;
    
                    $parameter = array(
                        "service" => $trade_type_international,
                        "partner" => $partner_international,
                        "return_url" => $return_url,
                        "notify_url" => $notify_url,
                        "_input_charset" => $_input_charset,
                        "subject" => $item_name . ' Order:' . $waybill,
                        "out_trade_no" => 'yd-' . $waybill . '-' .$customer_id,
                        "default_bank" => "cybs-" . $type,
                        "extend_param"	=> str_replace(" ","",$extend_param),
                        "total_fee" => $amount,
                        "payment_type" => "1",
                        "paymethod" => trim("jvm-3d"),
                        "sign_type"  => "MD5",
                        "sign"       => $security_code_international,
                        "seller_email" => $seller_email_international
                    );
    
                    
                }
             }
             else
             {
                   // log_result("Waybill".$this->session->data['waybill']);
                    if (isset($this->session->data['waybill'])) {
                        $this->load->model('order/order');
                        //$return_url = HTTPS_SERVER . 'index.php?route=order/order/order_guoji';
            
                        $waybill = $this->session->data['waybill'];
        
                        if (isset($this->request->post['amount']) && $this->request->post['amount']) {
                            $amount = $this->request->post['amount'];
                        }else{
                            $amount = 0;
                        }
                      
                       //测试专用
                       //$amount = 0.01;
                       if(isset($this->request->post['waybill_defaultbank']) && $this->request->post['waybill_defaultbank']) {
                        
                             $defaultbank = $this->request->post['waybill_defaultbank'];
                                
                        }else{
                            
                             $defaultbank = '';
                        }
                    	
                    	
                        $parameter = array(
                            "paymethod" => "bankPay",
                            "defaultbank" => $defaultbank,
                            "service" => $trade_type,
                            "partner" => $partner,
                            "return_url" => $return_url,
                            "notify_url" => $notify_url,
                            "_input_charset" => $_input_charset,
                            "subject" => $item_name . ' Order:' . $waybill,
                            "out_trade_no" => 'yd-' . $waybill . '-' . $customer_id,
                            "total_fee" => $amount,
                            "payment_type" => "1",
                            "seller_email" => $seller_email
                        );
                     }
                 
                 }
                 
               
                 $alipay = new alipay_service($parameter, $security_code, $sign_type);
                 $action = $alipay->build_url();
                 $this->response->setOutput(json_encode($action));
             
            }
            
            
    
            if (($this->request->server['REQUEST_METHOD'] == 'POST') && isset($this->request->post['action']) && ("order" == $this->request->post['action'])) {
                     
                    //$return_url = HTTPS_SERVER . 'index.php?route=order/order';
                     
                    if (isset($this->request->post['js_return']) && $this->request->post['js_return']) {
                    
                        if (isset($this->session->data['order_id'])) {
                        
                            $return_url = HTTPS_SERVER . 'index.php?route=order/order';
                            //$notify_url = HTTP_SERVER . 'catalog/controller/payment/callback_international.php';
                            $extend_param = $this->request->post['js_return'];
                            $security_code = $security_code_international;
                            
                            $order_id_array = explode(",",$this->session->data['order_id']);
                            $order_id = end($order_id_array);                        
                            $amount = round(($this->session->data['order_total']) * (1 + 0.01 + 0.001), 2);
                            
                            //测试专用
                    	//$amount = 0.01;
                
                            if (isset($this->request->post['type']) && $this->request->post['type'])
                                    $type = $this->request->post['type'];
                
                            $parameter = array(
                                "service" => $trade_type_international,
                                "partner" => $partner_international,
                                "return_url" => $return_url,
                                "notify_url" => $notify_url,
                                "_input_charset" => trim(strtolower($_input_charset)),
                                "subject" => $item_name . ' Order:' . $order_id,
                                "out_trade_no" => $this->session->data['order_id'].'-' . $customer_id,
                                "default_bank" => "cybs-" . $type,
                                "extend_param"	=> str_replace(" ","",$extend_param),
                                "total_fee"	=> $amount,
                                "currency"	=> $currency_code,
                                "paymethod" => trim("jvm-3d"),
    	                        "sign_type"  => "MD5",
    	                        "sign"       => $security_code_international,
                                "seller_logon_id" => $seller_email_international
                               );
                         }
                     
                     }else{
                        
                        if (isset($this->session->data['order_id'])) {
                
                        $order_id_array = explode(",",$this->session->data['order_id']);
                        $order_id = end($order_id_array);
                        $amount = round(($this->session->data['order_total']) * (1 + 0.01 + 0.001), 2);
                        
                        if(isset($this->request->post['order_defaultbank']) && $this->request->post['order_defaultbank']) {
                            
                            $defaultbank = $this->request->post['order_defaultbank'];
                            
                        } else {
                            
                            $defaultbank = '';
                        }
                        
                        //测试专用
                      // $amount = 0.01;
            
                        $parameter = array(
                        
                            "paymethod" => "bankPay",
                            "defaultbank" => $defaultbank,
                            "service" => $trade_type,
                            "partner" => $partner,
                            "return_url" => $return_url,
                            "notify_url" => $notify_url,
                            "_input_charset" => $_input_charset,
                            "subject" => $item_name . ' Order:' . $order_id,
                            "out_trade_no" => $this->session->data['order_id'].'-' . $customer_id,
                            "payment_type" => "1",
                            "total_fee"	=> $amount,
                            "seller_email" => $seller_email
                        );
    
                       }
            
                  }
          
                 $alipay = new alipay_service($parameter, $security_code, $sign_type);
                 $action = $alipay->build_url();
                 $this->response->setOutput(json_encode($action));
         
          }
    
        }
   }
   
    public function callback() {
        //trade_create_by_buyer 双接口 ,create_direct_pay_by_user 直接到帐，create_partner_trade_by_buyer 担保接口
        $trade_type = $this->config->get('alipay_trade_type');

        log_result("Alipay :: exciting callback function.");
        $oder_success = FALSE;
        $this->load->library('encryption');

        $seller_email = $this->config->get('alipay_seller_email'); // 商家邮箱
        $partner = $this->config->get('alipay_partner'); //合作伙伴ID
        $security_code = $this->config->get('alipay_security_code'); //安全检验码

        $_input_charset = "utf-8";
        $sign_type = "MD5";
        $transport = 'http';

        $alipay = new alipay_notify($partner, $security_code, $sign_type, $_input_charset, $transport);
        $verify_result = $alipay->notify_verify();

        $order_status = array(
            "paying" => 1,
            "payed" => 2,
            "shiping" => 3,
            "shipped" => 4,
            "stayin" => 5,
            "storage" => 6
        );

       
        if ($verify_result) {
            $order_id = $_POST['out_trade_no'];   
            $trade_status = $_POST['trade_status'];
            $total_fee = $_POST['total_fee'];

            if (strstr($order_id, 'cz')) {

                if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                    $order_id_array = explode("-", $order_id);

                    $order_id = $order_id_array[1];
                    $customer_id = $order_id_array[2];
                    
                    $this->load->model('account/rechargerecord');
                    $this->load->model('account/customer');
                    
                    $remark = $this->model_account_rechargerecord->getRemarkbyrid($order_id);
                    
                    if('OK' != $remark) {
                    
                        $data = array(
                            'state' => 1,
                            'successtime' => time(),
                            'remark' => "OK",
                            'rid' => $order_id
                        );
                        
                        $this->model_account_rechargerecord->updateRechargerecord($data);
                        $money = $this->model_account_rechargerecord->getMoneybyid($order_id);
                        $this->model_account_customer->editBalance($money, $customer_id);
                    }
                    
                    echo "success";
                } else {
                    echo "fail";
                }
            } else if (strstr($order_id, 'yd')) {
               
                $this->load->model('order/order');
                
                $sendorder_id_array = explode("-", $order_id);
                $sendorder_id = $sendorder_id_array[1];
                $customer_id  = $sendorder_id_array[2];
                
                
                $sendorder_array = explode(',',$sendorder_id);
                $sendorder_array = array_filter($sendorder_array);

                $sendorder_info = $this->model_order_order->getSendorderById($sendorder_array[0]);
                
                if($sendorder_info['state'] < 1)
                {
                    if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                  
                    $this->model_order_order->UpdateSendorderPay($sendorder_array);
                   
                     //插入消费记录       
                    $this->load->model('account/customer');
                    $customer_info = $this->model_account_customer->getCustomer($customer_id);
                    $first_name = $customer_info['firstname'];
                    $accountmoney = $customer_info['money'];
                    $data2 = array(
                        'uid'       => $customer_id,
                        'firstname' => $first_name,
                        'payname' => '支付宝支付',
                        'money' => -$total_fee,
                        'accountmoney' => $accountmoney,
                        'remark' => "提交运单费用，运单ID：" . $sendorder_id,
                        'remarktype' => 2,
                        'remarkdetails' => $sendorder_id,
                        'addtime' => time()
                    );
                    
                    
        
                    $this->load->model('account/record');
                    $this->model_account_record->addRecord($data2);
                    
                    echo "success";
                }
                else
                {
                    echo "fail";
                }
                
                
             } else {
                  echo "fail";
             }
            } else {
                $this->load->model('checkout/order');
                $order_customer = explode("-",$order_id);
                $order_id = $order_customer[0];
                $customer_id = $order_customer[1];
                
                $orders_id = explode(",",$order_id);
                
                $order_id = $orders_id[0];
                $order_info = $this->model_checkout_order->getOrder($order_id);
                

                if ($order_info) {
                    $order_status_id = $order_info["order_status_id"];
                   
                   
                    // 确定订单没有重复支付
                    if ($order_status_id < $order_status['payed']) {
                        
                        // 根据接口类型动态使用支付方法
                        if ($trade_type == 'trade_create_by_buyer') {
                            $this->func_trade_create_by_buyer($order_id, $order_status_id, $order_status, $trade_status);
                            echo "success";
                        } else if ($trade_type == 'create_direct_pay_by_user') {
                            $this->func_create_direct_pay_by_user($orders_id, $order_status_id, $order_status, $trade_status);
                            //插入消费记录       
                            $this->load->model('account/customer');
                            $customer_info = $this->model_account_customer->getCustomer($customer_id);
                            $first_name = $customer_info['firstname'];
                            $accountmoney = $customer_info['money'];
                            $order_record = implode(",",$orders_id);
                            $data1 = array(
                                'uid'       => $customer_id,
                                'firstname' => $first_name,
                                'payname' => '支付宝支付',
                                'money' => -$total_fee,
                                'accountmoney' => $accountmoney,
                                'remark' => "提交代购订单费用，订单ID：" . $order_record,
                                'remarktype' => 1,
                                'remarkdetails' => $order_record,
                                'addtime' => time()
                            );
                
                            $this->load->model('account/record');
                            $this->model_account_record->addRecord($data1);
                            echo "success";
                        } else if ($trade_type == 'create_partner_trade_by_buyer') {
                            $this->func_create_partner_trade_by_buyer($order_id, $order_status_id, $order_status, $trade_status);
                            echo "success";
                        }
                        
                    } else {
                        echo "fail";
                    }
                } else {
                    
                    echo "fail";
                }
                
            }
        }
    }
    
    public function callback_international() {
        //trade_create_by_buyer 双接口 ,create_direct_pay_by_user 直接到帐，create_partner_trade_by_buyer 担保接口
        log_result("Alipay :: exciting callback_international function.");
        $oder_success = FALSE;
        $this->load->library('encryption');
        
        $trade_type    = "alipay.trade.direct.forcard.pay";
        $seller_email = "zhifubao@cnstorm.com"; // 商家邮箱
        $partner = "2088011357497434"; //合作伙伴ID
        $security_code = "qo58xp4g1ywibtiiyns1gftw5mbv5rs3"; //安全检验码
        
        $_input_charset = "utf-8";
        $sign_type = "MD5";
        $transport = 'http';

        $alipay = new alipay_notify($partner, $security_code, $sign_type, $_input_charset, $transport);
        $verify_result = $alipay->notify_verify();

        
        $order_status = array(
            "paying" => 1,
            "payed" => 2,
            "shiping" => 3,
            "shipped" => 4,
            "stayin" => 5,
            "storage" => 6
        );

        if ($verify_result) {
            $order_id = $_POST['out_trade_no'];   //$_POST['out_trade_no'];
            $trade_status = $_POST['trade_status'];
            $total_fee = $_POST['total_fee'];

            //log_result("order_id:" . $order_id . "trade_status:" . $trade_status . "total_fee:" . $total_fee);
            if (strpos($order_id, 'cz')) {

                if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                    $order_id_array = explode("-", $order_id);

                    $order_id = $order_id_array[1];
                    $customer_id = $order_id_array[2];

                    //log_result("alipay_international_cz this is test order_id:" . $order_id . "this is test customer_id". $customer_id);
                    
                    $data = array(
                        'state' => 1,
                        'successtime' => time(),
                        'remark' => "OK",
                        'rid' => $order_id
                    );
                    
                    $this->load->model('account/rechargerecord');
                    $this->load->model('account/customer');
                    $this->model_account_rechargerecord->updateRechargerecord($data);
                    $money = $this->model_account_rechargerecord->getMoneybyid($order_id);
                    
                    
                    $this->model_account_customer->editBalance($money, $customer_id);
                    
                    echo "success";
                } else {
                    echo "fail";
                }
            } else if (strpos($order_id, 'yd')) {
               
                $this->load->model('order/order');
                
                $sendorder_id_array = explode("-", $order_id);
                $sendorder_id = $sendorder_id_array[1];
                $customer_id  = $sendorder_id_array[2];
                //log_result("sendorder0".$sendorder_id_array[0]."-sendorder1".$sendorder_id_array[1]."-sendorder2".$sendorder_id_array[2]);
                
                //log_result("kennewei".$sendorder_id);
                $sendorder_array = explode(",",$sendorder_id);
                //$sendorder_array = array_filter($sendorder_array);

                $sendorder_info = $this->model_order_order->getSendorderById($sendorder_array[0]);
                
                if($sendorder_info['state'] < 1)
                {
                    if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
    
                        
                        $this->model_order_order->UpdateSendorderPay($sendorder_array);
                        
                        //插入消费记录       
                        $this->load->model('account/customer');
                        $customer_info = $this->model_account_customer->getCustomer($customer_id);
                        $first_name = $customer_info['firstname'];
                        $accountmoney = $customer_info['money'];
                        $data2 = array(
                            'uid'       => $customer_id,
                            'firstname' => $first_name,
                            'payname' => '支付宝支付',
                            'money' => -$total_fee,
                            'accountmoney' => $accountmoney,
                            'remark' => "提交运单费用，运单ID：" . $sendorder_id,
                            'remarktype' => 2,
                            'remarkdetails' => $sendorder_id,
                            'addtime' => time()
                        );
                        
                        //log_result("firstname".$first_name . "---money".$total_fee . "---accountmoney".$accountmoney ."---sendorder_id".$value);
            
                        $this->load->model('account/record');
                        $this->model_account_record->addRecord($data2);
                    
                        echo "success";
                }
                else
                {
                    echo "fail";
                }
                
                
             } else {
                  echo "fail";
             }
            } else {
                $this->load->model('checkout/order');
                $order_customer = explode("-",$order_id);
                $order_id = $order_customer[0];
                $customer_id = $order_customer[1];
                
                $orders_id = explode(",",$order_id);
                
                $order_id = $orders_id[0];
                $order_info = $this->model_checkout_order->getOrder($order_id);
                //log_result("Alipay order_id :: " . $order_id);

                if ($order_info) {
                    $order_status_id = $order_info["order_status_id"];
                    //log_result("Alipay order_id :: " . $order_id . " order_status_id = " . $order_status_id . " , trade_status :: " . $trade_status);
                    //log_result("Alipay order_id :: Complete status = " . $order_status['Complete']);
                    // 确定订单没有重复支付
                    if ($order_status_id < $order_status['payed']) {
                       
                        // 根据接口类型动态使用支付方法,默认使用直接到账接口类型
                        $this->func_create_direct_pay_by_user($orders_id, $order_status_id, $order_status, $trade_status);
                        //插入消费记录       
                        $this->load->model('account/customer');
                        $customer_info = $this->model_account_customer->getCustomer($customer_id);
                        $first_name = $customer_info['firstname'];
                        $accountmoney = $customer_info['money'];
                        $order_record = implode(",",$orders_id);
                        $data1 = array(
                            'uid'       => $customer_id,
                            'firstname' => $first_name,
                            'payname' => '支付宝支付',
                            'money' => -$total_fee,
                            'accountmoney' => $accountmoney,
                            'remark' => "提交代购订单费用，订单ID：" . $order_record,
                            'remarktype' => 1,
                            'remarkdetails' => $order_record,
                            'addtime' => time()
                        );
            
                        $this->load->model('account/record');
                        $this->model_account_record->addRecord($data1);
                        echo "success";
                     
                        
                    } else {
                        echo "fail";
                    }
                } else {
                    //log_result("Alipay No Order Found.");
                    echo "fail";
                }
                
            }
        }
    }

    // 双接口
    private function func_trade_create_by_buyer($order_id, $order_status_id, $order_status, $trade_status) {
        if ($trade_status == 'WAIT_BUYER_PAY') {
// 				log_result("Alipay order_id :: ".$order_id." WAIT_BUYER_PAY, order_status_id = ".$order_status_id);
            if ($order_status['Pending'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Pending']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_SELLER_SEND_GOODS, update order_status_id from ".$order_status_id." to ".$this->config->get('alipay_order_status_id'));
            if ($this->config->get('alipay_order_status_id') > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $this->config->get('alipay_order_status_id'));
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_BUYER_CONFIRM_GOODS,update order_status_id from ".$order_status_id." to ".$order_status['Complete']);
            if ($order_status['Complete'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Complete']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == TRADE_FINISHED / TRADE_SUCCESS, update order_status_id from ".$order_status_id." to ".$order_status['Complete']);
            if ($order_status['Complete'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Complete']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        }
    }

    // 直接到帐
    private function func_create_direct_pay_by_user($orders_id, $order_status_id, $order_status, $trade_status) {
        if ($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
            //log_result("Alipay order_id :: " . print_r($orders_id) . " trade_status ==TRADE_FINISHED / TRADE_SUCCESS,  update order_status_id from " . $order_status_id . " to " . $this->config->get('alipay_order_status_id'));
           
                 if ($this->config->get('alipay_order_status_id') > $order_status_id) {
                     //log_result("order_id[0]". $orders_id[0] . "order_id[1]".$orders_id[1]);
                     $this->model_checkout_order->update_status($orders_id, '2');
                 }
           
        }
    }

    // 双接口
    private function func_create_partner_trade_by_buyer($order_id, $order_status_id, $order_status, $trade_status) {
        if ($trade_status == 'WAIT_BUYER_PAY') {
// 				log_result("Alipay order_id :: ".$order_id."  trade_status ==  WAIT_BUYER_PAY,  update order_status_id from ".$order_status_id." to ".$order_status['Pending']);
            if ($order_status['Pending'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Pending']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'WAIT_SELLER_SEND_GOODS') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_SELLER_SEND_GOODS, update order_status_id from ".$order_status_id." to ".$this->config->get('alipay_order_status_id'));
            if ($this->config->get('alipay_order_status_id')) {
                $this->model_checkout_order->confirm($order_id, $this->config->get('alipay_order_status_id'));
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'WAIT_BUYER_CONFIRM_GOODS') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == WAIT_BUYER_CONFIRM_GOODS, update order_status_id from ".$order_status_id." to ".$order_status['Complete']);
            if ($order_status['Complete'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Complete']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        } else if ($trade_status == 'TRADE_FINISHED') {
// 				log_result("Alipay order_id :: ".$order_id." trade_status == TRADE_FINISHED ,update order_status_id from ".$order_status_id." to ".$order_status['Complete']);
            if ($order_status['Complete'] > $order_status_id) {
                $this->model_checkout_order->confirm($order_id, $order_status['Complete']);
// 					log_result("Alipay order_id :: ".$order_id." Update Successfully.");
            }
        }
    }

}

?>