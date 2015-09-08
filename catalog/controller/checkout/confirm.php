<?php

class ControllerCheckoutConfirm extends Controller {

    public function index() {

        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('checkout/confirm');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $redirect = '';

        //总金额替换总额和总运费
        $total_account = array();

        //订单号数组
        $order_id_array = array();


        $currency_value = $this->currency->getValue("CNY");

        $this->data['rate'] = $currency_value;

        $this->data['money'] = $this->customer->getMoney();

        //购物车中选中的商品Key值
        if (isset($this->request->post['wanna_buy']) && $this->request->post['wanna_buy']) {
            $key_array = $this->request->post['wanna_buy'];

            $select_product_key = explode("###", $key_array);
        }else{
	        $select_product_key = array();
	    }

        //批量支付订单
        if (isset($this->request->post['batch_pay']) && $this->request->post['batch_pay']) {
            $batch_oid = $this->request->post['batch_pay'];

            $this->data['order_id'] = $batch_oid;

            $batch_pay_array = explode(",", $batch_oid);

            $this->data['order_id_array'] = $batch_pay_array;

            $this->session->data['order_id'] = $batch_oid;
        }

        //单个支付订单   
        if (isset($this->request->get['single_pay']) && $this->request->get['single_pay'] == "yes") {

            $total_amount = base64_decode($this->request->get['total_amount']);

            $total_freight = base64_decode($this->request->get['total_freight']);

            $single_pay = $this->request->get['single_pay'];

            $this->data['single_pay'] = $single_pay;

            $this->data['order_id'] = str_replace("'", "", base64_decode($this->request->get['order_id']));

            $order_id_array[] = $this->data['order_id'];

            $this->data['order_id_array'] = $order_id_array;

            $this->session->data['order_id'] = $this->data['order_id'];
        }


        if (!$redirect) {

            $store_array = array();
            $store_url_array = array();


            if (isset($this->request->get['single_pay']) && $single_pay == "yes") {

                $this->data['total_money'] = $total_amount + $total_freight;

                $this->session->data['order_total'] = $this->data['total_money'];
            } else if (isset($this->request->post['batch_pay']) && $this->request->post['batch_pay']) {
                $this->load->model("order/order");

                $order_array = implode(",", array_filter($batch_pay_array));

                $total_money = 0;

                $total_money = $this->model_order_order->getTotalBySelect($order_array);

                $this->data['total_money'] = $total_money;

                $this->session->data['order_total'] = $total_money;
            } else {
                
                foreach ($this->cart->getProducts() as $product) {
                    
                    if (in_array($product['key'], $select_product_key)) {//guanzhiqiang 20150629 订单来源
                      
                        $store_array[] = $product['storename'];
                        $store_array = array_unique($store_array);

                        if(isset($product['order_status_buy'])){
                            $order_status_buy=(int)$product['order_status_buy'];
                        }else{
                            $order_status_buy=0;
                        }
                        
                        $store_url_array[$product['storename']] = array(
                            "storeurl"=>$product['storeurl'],
                            "order_status_buy"=>$order_status_buy
                            );
                    }
                }

                foreach ($store_array as $store) {
                    $total_data = array();
                    $total = 0;
                    $taxes = $this->cart->getTaxes();

                    $this->load->model('setting/extension');

                    $sort_order = array();

                    $results = $this->model_setting_extension->getExtensions('total');

                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                    }

                    array_multisort($sort_order, SORT_ASC, $results);

                    foreach ($results as $result) {
                        if ($this->config->get($result['code'] . '_status')) {
                            $this->load->model('total/' . $result['code']);

                            $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                        }
                    }

                    $sort_order = array();

                    foreach ($total_data as $key => $value) {
                        $sort_order[$key] = $value['sort_order'];
                    }

                    array_multisort($sort_order, SORT_ASC, $total_data);

                    $this->language->load('checkout/checkout');

                    $data = array();

                    $data['invoice_prefix'] = $this->config->get('config_invoice_prefix');

                    $data['store_id'] = $this->config->get('config_store_id');

                    $data['storename'] = $store;

                    $data['storeurl'] = $store_url_array[$store]['storeurl'];
                   


                    if ($this->customer->isLogged()) {
                        $data['customer_id'] = $this->customer->getId();
                        $data['customer_group_id'] = $this->customer->getCustomerGroupId();
                        $data['firstname'] = $this->customer->getFirstName();
                        $data['lastname'] = $this->customer->getLastName();
                        $data['email'] = $this->customer->getEmail();
                        $data['telephone'] = $this->customer->getTelephone();
                        $data['money'] = $this->customer->getMoney();

                        $this->load->model('account/address');

                        //$payment_address = $this->model_account_address->getAddress($this->session->data['payment_address_id']);
                    } elseif (isset($this->session->data['guest'])) {
                        $data['customer_id'] = 0;
                        $data['customer_group_id'] = $this->session->data['guest']['customer_group_id'];
                        $data['firstname'] = $this->session->data['guest']['firstname'];
                        $data['lastname'] = $this->session->data['guest']['lastname'];
                        $data['email'] = $this->session->data['guest']['email'];
                        $data['telephone'] = $this->session->data['guest']['telephone'];
                        $data['money'] = $this->session->data['guest']['money'];

                        //$payment_address = $this->session->data['guest']['payment'];
                    }


                    $product_data = array();

                    $yunfei_array = array();

                    $sub_total = array();

                    foreach ($this->cart->getProducts() as $product) {
						
                        if (in_array($product['key'], $select_product_key)) {
                            if ($product['storename'] == $store) {
                                //店铺地址
                                $data['order_cul_home'] = $product['storeurl'];
                                //商品运费
                                $yunfei_array[] = $product['yunfei'];
                                //商品总额
                                $sub_total[] = $product['quantity'] * $product['price'];

                                $product_data[] = array(
                                    'product_id' => $product['product_id'],
                                    'name' => $product['name'],
                                    'model' => $product['model'],
                                    'color' => $product['color'], 
									'size' => $product['size'],
                                    'producturl' => $product['location'],
                                    'source' => $product['source'],
                                    'download' => $product['download'],
                                    'quantity' => $product['quantity'],
                                    'subtract' => $product['subtract'],
                                    'price' => $product['price'],
                                    'total' => $product['total'],
                                    'note' => $product['note'],
                                    'img' => $product['image']
                                );
                            }
                        }
                    }

                    sort($yunfei_array);

                    $data['order_shipping'] = end($yunfei_array);

                    $data['total'] = array_sum($sub_total) + end($yunfei_array);

                    $total_account[] = $data['total'];

                    $data['products'] = $product_data;

                    $data['totals'] = $total_data;

                    $data['ip'] = $this->request->server['REMOTE_ADDR'];

                    if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                        $data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                    } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                        $data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                    } else {
                        $data['forwarded_ip'] = '';
                    }

                    if (isset($this->request->server['HTTP_USER_AGENT'])) {
                        $data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                    } else {
                        $data['user_agent'] = '';
                    }

                    if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {

                        $data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                    } else {

                        $data['accept_language'] = '';
                    }

                    //订单购买状态，默认 1:代购 2:自助 3:代寄 4:商城 5:Cosplay商城
                    $data['order_status_buy'] = $store_url_array[$store]["order_status_buy"];
					
					//获取该商品在商场中的地址
					
					if($data['order_status_buy'] ==5){

						 $this->load->model('cosplay/main');
						 foreach( $data['products'] as &$v){
							$rows=$this->model_cosplay_main->getCategory1($v['product_id']);
							
							$v['producturl']="http://www.acgstorm.com/".$rows->row['parent_id']."_".$rows->row['category_id']."-cosplay.html&product_id=".$v['product_id'];
						}
					}
					
                    //订单状态, 1 未付款 2 已付款
                    $data['order_status_id'] = 1;

                    $this->load->model('checkout/order');

                    $order_id_temp = $this->model_checkout_order->addOrder($data);

                    $order_id_array[] = $order_id_temp;

                    $this->data['order_id'] = $order_id_temp;
                }

                $this->data['order_id_array'] = $order_id_array;

                if (!empty($order_id_array)) {
                    foreach ($select_product_key as $signal_key) {
                        if (strstr($signal_key, 'snatch')) {
                            $key_info = explode('_', $signal_key);
                            $id = $key_info[1];

                            if ($id) {
                                $this->load->model('checkout/cart');

                                $this->model_checkout_cart->delCartbyId($id);
                            }
                            $this->cart->remove($signal_key);
                        } else {
                            $this->cart->remove($signal_key);
                        }
                    }
                }

                $this->session->data['order_id'] = implode(",", $order_id_array);
                $total_account_sum = array_sum($total_account);
                $this->session->data['order_total'] = $total_account_sum;
                $this->data['total_money'] = $total_account_sum;
            }
        } else {

            $this->redirect($redirect);
        }

        $this->data['type'] = "order";


        $this->data['paypal'] = $this->getChild('payment/pp_standard');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/confirm.tpl')) {

            $this->template = $this->config->get('config_template') . '/template/checkout/confirm.tpl';
        } else {

            $this->template = 'default/template/checkout/confirm.tpl';
        }

        $this->children = array(
            'common/help_left',
            'common/column_left',
            'common/footer',
            'common/header_cart'
        );

        $this->response->setOutput($this->render());
    }

    //运单提交支付
    public function sendorder2() {
        
         //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('checkout/confirm', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        
        if(isset($this->request->post['sendorder_id']) && $this->request->post['sendorder_id']) {
            
            $this->load->model('checkout/order');
            
            $this->load->model('waybill/transport');
            
            $sendorder_id = $this->request->post['sendorder_id'];
            
            $scores = $this->customer->getScore();
            
            $usrname = $this->customer->getFirstname();
            
            $username_id = $this->customer->getId();
            
            $customer_money = $this->customer->getMoney();
            
            $customer_money = str_replace(',','',$customer_money);
            
            $this->data['money'] = (float)$customer_money;
            
            //获取汇率
            $currency_value = $this->currency->getValue("CNY");

            $this->data['rate'] = $currency_value;
            
            
            //获取运费信息
            $sendorder_info = $this->model_waybill_transport->getsendorderbysid($sendorder_id);
            
            //变更订单状态
            $all_order_id = explode(",", $sendorder_info['oids']);
            foreach ($all_order_id as $signal_order_id) {
                $this->model_checkout_order->update_status($signal_order_id, '8');
            }
            
            
            $total_freight = $sendorder_info['totalfee'];
            
            //备注信息
            if (isset($this->request->post['addnote'])) {
                $note_content = $this->request->post['addnote'];
                $data = array(
                    'remark' => $note_content,
                    'sid' => $sendorder_id
                );
                $this->model_waybill_transport->updateremarkbysid($data);
                
            } else {
                $note_content = null;
            }
            
            //优惠卷信息
            if(isset($this->request->post['usecoupon']) && $this->request->post['usecoupon']) {
                
                $this->load->model('account/coupon');
                
                $cid = $this->request->post['usecoupon'];
                
                $coupon_info = $this->model_account_coupon->getCouponbycid($cid);
                
                if($coupon_info['state'] == 1 || $coupon_info['state'] == 2){
                    
                    $this->model_account_coupon->updateCoupon($cid,3);
                
                    $total_freight = $total_freight - (float)$coupon_info['money'];
                    
                    $data = array(
                        'couponid' => $cid,
                        'sid' => $sendorder_id
                    );
                    $this->model_waybill_transport->updatecouponbysid($data);
                }
                
            
            }
            
            //积分信息
            if(!$sendorder_info['usescore']) {
                
                if (isset($this->request->post['scoreuse'])) {
                $scoreuse = $this->request->post['scoreuse'];
                $newscore = $scores - $scoreuse;
                if ($newscore >= 0 && $scoreuse != 0) {
                    $this->load->model('account/record');
                    $this->load->model('account/customer');
                    
                    $data = array(
                        'usescore' => $scoreuse,
                        'sid' => $sendorder_id
                    );
                    $this->model_waybill_transport->updatescorebysid($data);
                    
                    $total_freight = $total_freight - round($scoreuse/100,2);
                    
                    $data = array(
                        'totalfee' => $total_freight,
                        'sid' => $sendorder_id
                    );
                    
                    $this->model_waybill_transport->updatetotalfeebysid($data);
                    
                    $this->model_account_customer->editScores($newscore);
    
                    $insert_score_record = array(
                        'uid' => $username_id,
                        'firstname' => $usrname,
                        'remark' => $scoreuse . '积分抵扣运费--运单'.$sendorder_id,
                        'score' => '-' . $scoreuse,
                        'type' => '2',
                        'totalscore' => $newscore
                    );
    
                    $this->model_account_record->addScoreRecord($insert_score_record);
                    
                } else {
                   
                    $scoreuse = 0;
                    $newscore = $scores;
                   
                }
              }
                
            }
            
            
            $this->data['total_money'] =  (float)$total_freight;
            
            
            
            $paypal_total = $total_freight*$currency_value;
            $paypal_total = str_replace(',','',$paypal_total);
            $this->data['paypal_total'] = (float)$paypal_total;
            
           
            $this->data['order_id'] = $sendorder_id;
            
            $this->session->data['waybill'] = $sendorder_id;
    
            $this->session->data['old_sid'] = $sendorder_id;
    
            $this->data['order_id_array'] = array($sendorder_id);
    
            $this->data['single_pay'] = '';
    
            $this->data['action'] = $this->url->link('payment/pp_standard/waybill');
    
            $this->data['type'] = "waybill";
    
            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/sendorder_confirm.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/checkout/sendorder_confirm.tpl';
            } else {
                $this->template = 'default/template/checkout/sendorder_confirm.tpl';
            }
    
            $this->children = array(
                'common/footer',
                'common/header_cart'
            );
    
            $this->data['alipay'] = $this->getChild('payment/alipay');
            $this->response->setOutput($this->render());
            
        }
   
    }

//运单列表付款
    public function sendorder() {
        

         //判断用户登录是否失效
        if (!$this->customer->isLogged()) {
            
            $this->session->data['redirect'] = $this->url->link('checkout/confirm', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $currency_value = $this->currency->getValue("CNY");

        $this->data['rate'] = $currency_value;
        $this->data['money'] = $this->customer->getMoney();
        $this->data['action'] = $this->url->link('payment/pp_standard/waybill');
        $this->data['single_pay'] = '';

        //运单直接支付
        if (isset($this->request->get['order_id']) && $this->request->get['order_id']) {
            //运单号
            $waybill_id = str_replace("'", "", base64_decode($this->request->get['order_id']));

            $this->data['order_id'] = $waybill_id;

            $total_amount = base64_decode($this->request->get['total_amount']);

            $this->data['total_money'] = $total_amount;

            $this->data['paypal_total'] = $total_amount * $currency_value * 1.039;

            $waybill_id_array = explode(',', $waybill_id);

            $this->data['order_id_array'] = $waybill_id_array;

            $this->session->data['waybill'] = $waybill_id;
        }

        //运单列表单个支付
        if (isset($this->request->get['single_pay']) && $this->request->get['single_pay']) {
            $single_pay = $this->request->get['single_pay'];

            $this->data['single_pay'] = $single_pay;

            $total_amount = base64_decode($this->request->get['total_amount']);

            $this->data['total_amount'] = $total_amount;

            //运单号
            $waybill_id = str_replace("'", "", base64_decode($this->request->get['order_id']));

            $this->data['order_id'] = $waybill_id;

            $waybill_id_array = explode(',', $waybill_id);

            $this->data['order_id_array'] = $waybill_id_array;

            $this->session->data['waybill'] = $waybill_id;
        }

        //运单列表批量支付
        if (isset($this->request->post['waybillbatch_pay']) && $this->request->post['waybillbatch_pay']) {
            $waybill_id = $this->request->post['waybillbatch_pay'];
            
            //运单号
            $this->data['order_id'] = $waybill_id;

            $waybill_id_array = explode(",", $waybill_id);

            $waybill_id_array = array_filter($waybill_id_array);

            $this->session->data['waybill'] = implode(',', $waybill_id_array);
            
            
            //获取运费信息
            $this->load->model('waybill/transport');
            
            $this->load->model('checkout/order');
            
            foreach($waybill_id_array as $sendorder_id){
                $oids = $this->model_waybill_transport->getoidsbysid($sendorder_id);
                //变更订单状态
                $all_order_id = explode(",", $oids);
                foreach ($all_order_id as $signal_order_id) {
                    $this->model_checkout_order->update_status($signal_order_id, '8');
                }  
            }
                
            
            
            
             //优惠卷信息
            if(isset($this->request->post['usecoupon']) && $this->request->post['usecoupon']) {
                
                $total_freight = $this->model_waybill_transport->gettotalfeeBySid($waybill_id_array[0]);
                
                $this->load->model('account/coupon');
                
                $cid = $this->request->post['usecoupon'];
                
                $coupon_info = $this->model_account_coupon->getCouponbycid($cid);
                
                if($coupon_info['state'] == 1 || $coupon_info['state'] == 2){
                    
                    $this->model_account_coupon->updateCoupon($cid,3);
                
                    $total_freight = $total_freight - (float)$coupon_info['money'];
                    
                    $data = array(
                        'couponid' => $cid,
                        'sid' => $waybill_id_array[0]
                    );
                    $this->model_waybill_transport->updatecouponbysid($data);
                    
                    $data2 = array(
                        'sid' => $waybill_id_array[0],
                        'totalfee' =>$total_freight
                    );
                    
                    $this->model_waybill_transport->updatetotalfeebysid($data2);
                }
                
            
            }
            
            //积分信息  
            if (isset($this->request->post['scoreuse']) && $this->request->post['scoreuse']) {
                
                $scoreuse = $this->request->post['scoreuse'];
                
                $scores = $this->customer->getScore();
                
                $usrname = $this->customer->getFirstname();
            
                $username_id = $this->customer->getId();
                
                $newscore = $scores - $scoreuse;
                
                
                
                $total_freight = $this->model_waybill_transport->gettotalfeeBySid($waybill_id_array[0]);
                
                if ($newscore >= 0 && $scoreuse != 0) {
                    $this->load->model('account/record');
                    $this->load->model('account/customer');
                    
                    $data = array(
                        'usescore' => $scoreuse,
                        'sid' => $waybill_id_array[0]
                    );
                    $this->model_waybill_transport->updatescorebysid($data);
                    
                    $total_freight = $total_freight - round($scoreuse/100,2);
                    
                    $data = array(
                        'totalfee' => $total_freight,
                        'sid' => $waybill_id_array[0]
                    );
                    
                    $this->model_waybill_transport->updatetotalfeebysid($data);
                    
                    $this->model_account_customer->editScores($newscore);
    
                    $insert_score_record = array(
                        'uid' => $username_id,
                        'firstname' => $usrname,
                        'remark' => $scoreuse . '积分抵扣运费',
                        'score' => '-' . $scoreuse,
                        'type' => '2',
                        'totalscore' => $newscore
                    );
    
                    $this->model_account_record->addScoreRecord($insert_score_record);
                    
                } 
          }
                
          
            
            //备注信息
            if (isset($this->request->post['addnote']) && $this->request->post['addnote']) {
                
                $note_content = $this->request->post['addnote'];
                
                foreach($waybill_id_array as $sendorder_id) {
                     $data = array(
                        'remark' => $note_content,
                        'sid' => $sendorder_id
                    );
                    $this->model_waybill_transport->updateremarkbysid($data);   
                }
            } 
            


            $this->load->model('order/order');

            $total_money = $this->model_order_order->gettotalfeeBySid(implode(',', $waybill_id_array));

            $this->data['total_money'] = $total_money;

            $this->data['paypal_total'] = $total_money * $currency_value * 1.039;

            $this->data['order_id_array'] = $waybill_id_array;
        }

        $this->data['type'] = "waybill";

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/sendorder_confirm.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/checkout/sendorder_confirm.tpl';
        } else {
            $this->template = 'default/template/checkout/sendorder_confirm.tpl';
        }

        $this->children = array(
            'common/footer',
            'common/header_cart'
        );

        $this->response->setOutput($this->render());
    }

    //订单付款操作
    public function Border() {

        if (isset($this->request->post['total']) && $this->request->post['total'])
            $total = str_replace(",", "", $this->request->post['total']);

        if (isset($this->request->post['balance']) && $this->request->post['balance'])
            $balance = str_replace(",", "", $this->request->post['balance']);

        if (isset($this->request->post['type']) && $this->request->post['type'])
            $type = $this->request->post['type'];

        $this->load->model('account/customer');
        $this->load->model('checkout/order');
        $this->load->model('account/record');
        $this->load->model('order/order');

        $uid = $this->customer->getId();
        $customer_email = $this->customer->getEmail();
        $customer_name = $this->customer->getFirstName();
		$userinfo=$this->model_account_customer->getCustomer($uid);
		$total=0;
	   if (isset($this->request->post['oids']) && $this->request->post['oids']){	
			$oids = explode(':', $this->request->post['oids']);
			if(count($oids)>1){
				array_pop($oids);
			}
			   foreach ($oids as $oid){
				if("order" == $type){
						$sql="select total from oc_order where order_id = ".$oid." and customer_id= ".$uid ;
					}else{
						$sql="select totalfee as total from oc_sendorder where sid = ".$oid." and uid = ".$uid ;
					}
					$row=$this->db->query($sql);
					 foreach($row->rows as $v){
						$total+= $v['total'];
					 }
			}
		}
			
		$money=$userinfo['money'];
		$difference = $money - $total;
	
		//print_r($userinfo);die;
        if ($total > 0 && $difference >= 0 && isset($this->request->post['oids'])) {

            if ("order" == $type) {
                
                foreach ($oids as $oid) {

                    $this->model_checkout_order->update($oid, "2");

                }
					$this->model_account_customer->editBalance($difference, $uid);
                //插入消费记录       
                $order_record = implode(",", $oids);
                $data = array(
                    'uid' => $uid,
                    'firstname' => $customer_name,
                    'payname' => "余额支付",
                    'money' => -$total,
                    'accountmoney' => $difference,
                    'remark' => "提交代购订单费用，订单ID：" . $order_record.",原始余额为:".$money,
                    'remarktype' => 1,
                    'remarkdetails' => $order_record,
                    'addtime' => time()
                );

                $this->model_account_record->addRecord($data);

            } else if ("waybill" == $type) {
                if (isset($this->request->post['oids']) && $this->request->post['oids'])
                    $waybill_ids = $this->request->post['oids'];


					$waybill_ids = explode(':', $waybill_ids);
				
					foreach ($waybill_ids as $waybill_id) {
						//更新运单未付款状态至已付款状态
						$data = array(
							'state' => 1,
							'sid' => $waybill_id
						);
						
						$this->model_order_order->Updatestate($data);

						$oids_str = $this->model_order_order->getoidBySid($waybill_id);

						$oids = explode(",", $oids_str);

						$oids = array_filter($oids);

						$this->model_order_order->order_updat($oids, '8');

						//插入消费记录       
						$data = array(
							'uid' => $uid,
							'firstname' => $customer_name,
							'payname' => "余额支付",
							'money' => -$total,
							'accountmoney' => $difference,
							'remark' => "提交运单费用，运单ID：" . $waybill_id . "包含订单号：" . $oids_str ,
							'remarktype' => 2,
							'remarkdetails' => $waybill_id,
							'addtime' => time()
						);

						$this->model_account_record->addRecord($data);
					}

                $this->model_account_customer->editBalance($difference, $uid);
				}
				echo $difference;
			} else {
				echo "no";
			
		}
	}
	public function sendEmail(){
		
		if (isset($this->request->get['type']) && $this->request->get['type']){
			$type = $this->request->get['type'];
		}else{
			$type='';
		}
		 $uid = $this->customer->getId();
		 
        $customer_email = $this->customer->getEmail();
        $customer_name = $this->customer->getFirstName();
		if($type){
			if('order'==$type){
			
                $subject = "CNstorm订单确认邮件";
                $message = "
    				<div style='width:600px; margin:0 auto;'>
    				<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
    				<div style='clear:both; height:20px; width:100%'></div>
    				<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
    				<div style='width:560px; margin:0 auto; font-size:14px'>
    				<p >亲爱的 " . $customer_name . ",</p>
    				<p > </p>
    				<p ><strong>您的订单已提交成功！</strong> </p>
    				<p >
    				<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>接下来我们将在一个工作日内为您处理订单，请您留意并耐心等待（<a href='http://www.acgstorm.com/index.php?route=order/order'>查看订单</a>）</div>
    				</p>
    				<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。您的商品到货后将可免费保管两个月，接下来您可以： </p>
    				<p > </p>
    				<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
    				<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >自助购</a>） </p>
    				<p >3、&nbsp;亲人朋友准备包裹并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。(<a href='http://www.acgstorm.com/index.php?route=international/express' >国际转运</a>)。 </p>
    				<p > </p>
    				<p >我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href='http://www.acgstorm.com/index.php?route=help/normalquestion' >点此查阅</a>。 </p>
    				<p > </p>
    				<p >如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或通过下方电子邮件与我们取得联系。 </p>
    				<p > </p>
    				<p >Email:&nbsp;support@cnstorm.com </p>
    				<p > </p>
    				<p >我们衷心感谢您选择并使用CNstorm为您服务！ </p>
    				<p > </p>
    				<p > </p>
    				<p >CNstorm客户关怀部 </p>
    				<p > </p>
    				<p  style='text-align:center'>&#169;Copyright&nbsp;2014&nbsp;CNstorm&nbsp; </p>
    				</div>
    				</div>
    				</div>";

			}else if("waybill" == $type){
					$subject = "CNstorm国际运单确认邮件";
					$message = "
					<div style='width:600px; margin:0 auto;'>
					<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
					<div style='clear:both; height:20px; width:100%'></div>
					<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
					<div style='width:560px; margin:0 auto; font-size:14px'>
					<p >亲爱的 " . $customer_name . ",</p>
					<p > </p>
					<p ><strong>您的国际运单已提交成功！</strong> </p>
					<p >
					<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>接下来我们将在一个工作日内为您处理运单，请您留意并耐心等待（<a href='http://www.acgstorm.com/index.php?route=order/order/order_guoji'>查看运单</a>）</div>
					</p>
					<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。您的商品到货后将可免费保管两个月，接下来您可以： </p>
					<p > </p>
					<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
					<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >自助购</a>） </p>
					<p >3、&nbsp;亲人朋友准备包裹并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。(<a href='http://www.acgstorm.com/index.php?route=international/express' >国际转运</a>)。 </p>
					<p > </p>
					<p >我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href='http://www.acgstorm.com/index.php?route=help/normalquestion' >点此查阅</a>。 </p>
					<p > </p>
					<p >如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或通过下方电子邮件与我们取得联系。 </p>
					<p > </p>
					<p >Email:&nbsp;support@cnstorm.com </p>
					<p > </p>
					<p >我们衷心感谢您选择并使用CNstorm为您服务！ </p>
					<p > </p>
					<p > </p>
					<p >CNstorm客户关怀部 </p>
					<p > </p>
					<p  style='text-align:center'>&#169;Copyright&nbsp;2014&nbsp;CNstorm&nbsp; </p>
					</div>
					</div>
					</div>";
            }
			
                $data = array(
                    'sendto' => $customer_email,
                    'receiver' => $customer_name,
                    'subject' => $subject,
                    'msg' => $message,
                );
                $this->load->model('tool/sendmail');
                 $this->model_tool_sendmail->send($data);
				 echo 'true';
		}else{
			echo 'false';
		}
			   
	}
	
	

}

?>
