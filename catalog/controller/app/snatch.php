<?php

/**
 * @description：手机接口自助购部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-13
 */
Class ControllerAppSnatch extends Controller {

	//查询自助购列表
	public function snatch_list () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];

			$this->load->model('app/order');
			$products = $this->model_app_order->get_selfproduct($customerId);
			$data = array();
			foreach ($products as $product) {
				$data[] = array(
					'productId'           => $product['id'],
	    			'name'                => $product['product_name'],
	    			'href'                => $product['producturl'],
	    			'quantity'            => $product['qty'],
	    			'color'               => $product['color'],
	    			'size'                => $product['size'],
	    			'note'				  => $product['remark'],
	    			'thumb'               => $product['img'],
	    			'storename'           => $product['store_name'],
	    			'storeurl'            => $product['store_url'],
	    			'price'				  => $product['price'],
	    			'yunfei'			  => $product['yunfei']
					);
			}
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $data)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//自助购提交
	public function snatch_commit () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customer_id = $param['customerId'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customer_id);
			if ($customer) {
				$this->load->model('app/order');
				$self_products = $this->model_app_order->get_selfproduct($customer_id);
				
				foreach ($self_products as $self_product) {
            		$storename_array[$self_product['store_url']] = $self_product['store_name'];
            		$storename_array = array_unique($storename_array);
        		}

        		if (isset($storename_array) && is_array($storename_array)) {
	        		foreach ($storename_array as $storeurl => $storename) {
	        			$data = array();
	            		$product_data = array();

			            $data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
	        		    $data['store_id'] = 1;//手机购物通过store_id来区分，为1即手机
			            $data['storename'] = $storename;
	        		    $data['storeurl'] = $storeurl;

		                $data['customer_id'] = $customer_id;
		                $data['customer_group_id'] = $customer['customer_group_id'];
		                $data['firstname'] = $customer['firstname'];
		                $data['lastname'] = $customer['lastname'];
		                $data['email'] = $customer['email'];
		                $data['telephone'] = $customer['telephone'];

			            //店铺地址
			            $data['order_cul_home'] = $storeurl;
			            $data['order_shipping'] = '';
			            $data['total'] = '';

			            $data['fax'] = '';

			            foreach ($self_products as $product) {
	                		if ($product['store_name'] == $storename) {
	                			if ($product['product_id']) {
					            	$num_iid = $product['product_id'];
					            } else {
					            	include_once('cart.php');
									$this->cart = new ControllerAppCart(TRUE);
									$num_iid = $this->cart->getTBId($product['producturl']);
					            }
			                    $product_data[] = array(
	            		            'product_id' => $num_iid,
			                        'producturl' => $product['producturl'],
			                        'model' => '',
			                        'download' => '',
			                        'subtract' => '',
			                        'total' => 0.00,
			                        'name' => $product['product_name'],
			                        'quantity' => $product['qty'],
			                        'color' => $product['color'],
			                        'size' => $product['size'],
			                        'price' => $product['price'],
			                        'note' => $product['remark'],
			                        'source' => 0,
			                        'img' => $product['img'],
			                        'num_iid' => $product['product_id']
									);
	                		}
	            		}

	            		$data['products'] = $product_data;

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

	            		//订单购买状态，默认 1:代购 2:自助   3:代寄
			            $data['order_status_buy'] = 2;
			            //订单状态 3 待发货
			            $data['order_status_id'] = 3;
	        		}

					$this->load->model('app/order');
		        	$self_order = $this->model_app_order->addOrder($data);
		        	if ($self_order) {
	                	$this->model_app_order->del_selfproduct($customer_id);
						$arr = json_encode(array('data' => array('resultCode' => 1)));
						echo($arr);
	            	} else {
	                	$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_submit'))));
	                	echo($arr);
	            	}
	            } else {
	            	$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notfound'))));
                	echo($arr);
	            }
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//增加自助购
	public function snatch_add () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);

			$data_product = array(
            	'producturl' => $param['href'] ? $param['href'] : '',
    	        'price' => $param['price'],
    	        'heading_title' => $param['name'],
        	    'searchfreight' => $param['yunfei'],
        	    'color' => $param['color'],
            	'size' => $param['size'],
            	'qty' => $param['quantity'],
            	'time' => time(),
            	'seller' => $param['storename'],
            	'remark' => $param['note'] ? $param['note'] : '',
            	'img' => $param['thumb'],
            	'storename' => $param['storename'],
            	'storeurl' => $param['storeurl'],
            	'custom_id' => $param['customerId'],
            	'num_iid' => $param['num_iid']
        		);
			$this->load->model('app/order');
			$this->model_app_order->insert_zizhu($data_product);
			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//取消自助购
	public function snatch_delete () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$productId = $param['productId'];

			$data = array(
				'id' => $productId
				);
			$this->load->model('order/order');
			$this->model_order_order->del_one_selfproduct($data);
			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

}