<?php 

/* * ****************************************************************************
 * @description：用户中心待取消订单列表及相关操作
 * @author： lcd@cnstorm.com
 * @date:     2014.6.9
 * ***************************************************************************** */

class ControllerOrderCancel extends Controller{

	public function index(){

		if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
	   $this->language->load('order/order');
		$this->load->model('order/order');
	
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
			 //代购

            $data_daigou = array(
                'order_status_buy' => 1,
                'username_id' => $this->customer->getId()
            );
            $this->data['num_daigou'] = $this->model_order_order->getTotalOrders($data_daigou);

			 $username_id = $this->session->data['customer_id'];
             $results_total = $this->model_order_order->getTotalOrders(array('username_id' => $username_id, 'order_status_buy' => 1,'order_status_id'=>10));
		
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
			 if (isset($this->request->get['page'])) {
                $page = $this->request->get['page'];
            } else {
                $page = 1;
            }
			$limit=10;
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
                'order_status_id' => 10,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $results = $this->model_order_order->getOrders($data);
			 foreach ($results as $result){
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
					switch($result['order_status_buy']){
						case 1:
						$restore_id = 1;
						break;
						case 2:
						$restore_id = 3;
						break;
						case 3:
						$restore_id = 1;
						break;
					}
					  $this->data['orders'][] = array(
							'order_id' => $result['order_id'],
							'order_shipping' => $result['order_shipping'],
							'storename' => $result['store_name'],
							'storeurl' => $result['store_url'],
							'order_status_buy'=>$result['order_status_buy'],
							'customer' => $result['customer'],
							'status' => $result['status'],
							'order_status_id' => $result['order_status_id'],
							'product_total' => $product_total[0]['ordertotal'],
							'product' => $product_str,
							'restore_id'=>$restore_id,
							'total' => $this->currency->format($result['total'], $result['currency_code'], $result['currency_value']),
							'date_added' => $result['date_added'],
							'date_modified' => date($this->language->get('date_format_short'), strtotime($result['date_modified'])),
							'selected' => isset($this->request->post['selected']) && in_array($result['order_id'], $this->request->post['selected']),
							'preq' => $result['preq'],
							'creq' => $result['creq']
						);
				 }
			 }
	
			$this->data['text_check_all'] = $this->language->get('text_check_all');
			$this->data['text_store_title'] = $this->language->get('text_store_title');
			$this->data['text_merge_pay'] = $this->language->get('text_merge_pay');
			$this->data['order_qty'] = $this->language->get('order_qty');
			$this->data['order_Payment'] = $this->language->get('order_Payment');
			$this->data['order_price'] = $this->language->get('order_price');
			$this->data['text_all_order'] = $this->language->get('text_all_order');
			$this->data['order_info'] = $this->language->get('order_info');
			$this->data['order_operating'] = $this->language->get('order_operating');
			$this->data['order_time'] = $this->language->get('order_time');
			$this->data['order_Number'] = $this->language->get('order_Number');
			$this->data['order_color'] = $this->language->get('order_color');
			$this->data['order_size'] = $this->language->get('order_size');
			$this->data['order_remark'] = $this->language->get('order_remark');
			$this->data['order_shipping'] = $this->language->get('order_shipping');
			$this->template = 'cnstorm/template/order/cancel_business.tpl';
			if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
				$this->template = 'cnstorm/template/order/cancel_business_list.tpl';
			}
			
			
			$pagination = new Pagination();
            
            $pagination->total = $results_total;

            $pagination->page = $page;

            $pagination->limit = $limit;
            
            $pagination->url = $this->url->link('order/order', '&page={page}');

            $this->data['pagination'] = $pagination->render();
            
            $this->template = 'cnstorm/template/order/cancel_business.tpl';
            
            if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
                
                $this->template = 'cnstorm/template/order/cancel_business_list.tpl';

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
	
	/* * ****************************************************************************
 * @description：用户中心待取消运单列表及相关操作
 * @author： lcd@cnstorm.com
 * @date:     2014.6.9
 * ***************************************************************************** */
	public function cancelso(){
	
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
            $customer = $this->model_order_order->guoji_quxiao($order_quxiao_id);
            
            $this->load->model('account/customer');
            $shipping_number = $this->model_account_customer->get_shippingnumber();
            
            if($shipping_number-1) {
                
                 $this->model_account_customer->del_shippingnumber(); 
            }
            
        }
        else {
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
            'order_status_id' => 10,
            'consignee' => $consignee,
            'start' => ($page - 1) * $limit,
            'limit' => $limit);

        $data_total = array(
            'username_id' => $username_id,
            'order_status_id' => 10,
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

        $this->template = 'cnstorm/template/order/cancelso_business.tpl';
        
        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            
            $this->template = 'cnstorm/template/order/cancelso_business_list.tpl';
        }

		$this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);		
		$this->response->setOutput($this->render());
	}
}
?>