<?php
/**
 * @description：手机接口购物车部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-1
 */
Class ControllerAppCart extends Controller {

	//添加商品到购物车
	public function add() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$productId 	= $param['productId'];
			$colorId 	= $param['color'] 		? $param['color'] : 0;
			$sizeId 	= $param['size'] 		? $param['size'] : array();
			$quantity 	= $param['quantity'] 	? $param['quantity'] : 1;
			$remark 	= $param['remark'] 		? $param['remark'] : array();
			$type		= $param['type'] 		? $param['type'] : 0;   
			$this->load->model('catalog/product');
			$this->load->model('account/customer');
			$this->load->model('cosplay/main');
			
		
			if (!empty($customerId)) {
				unset($this->session->data['customer_id']);
				$this->session->data['customer_id'] = $customerId;
				//同步下session中cart里的数据
				$customer = $this->model_account_customer->getCustomer($customerId);
	
					if($customer['cart'] && is_string($customer['cart'])) {
					
			                $cart = unserialize($customer['cart']);
							
			                foreach ($cart as $key => $value) {
			                    if (!array_key_exists($key, $this->session->data['cart'])) {
			                        $this->session->data['cart'][$key] = $value;
			                    }
			                }
	            	}
						
				//	echo json_encode($this->session->data['cart']);die;
					if($type!=5){
						$product_info = $this->model_catalog_product->getProduct($productId);
					}else{
						$product_info = $this->model_cosplay_main->getProduct($productId);	
						$productId='cosplay_'.$productId;
					}
				
				if ($product_info) {
					$this->cart->add($productId, $quantity, $colorId, $sizeId, $remark);
			
					$this->load->model('app/user');
					$this->model_app_user->updateCart($customerId);
					
					$arr = json_encode(array('data' => array('resultCode' => 1)));//, 'cart' => $this->session->data['cart']
					echo($arr);
				} else {
					//商品不存在
					$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notexists'))));
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

	//添加抓取商品到购物车
	public function cart_addsearch () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customer_id = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customer_id);

			$quantity = $param['quantity'] ? $param['quantity'] : 1;
			$color = $param['color'] ? $param['color'] : 0;
			$size = $param['size'] ? $param['size'] : '';
			$note = $param['remark'] ? $param['remark'] : '';
			$freight = $param['yunfei'] ? $param['yunfei'] : '';
			$price = $param['price'] ? $param['price'] : '';
			
			$data = array(
				'num_iid' => $param['num_iid'],
	            'customer_id' => $customer_id,
				'firstname' => $customer['firstname'],
				'product_name' => $param['name'],
				'product_url' => $param['url'],
				'store_name' => $param['storename'],
				'store_url' => $param['storeurl'],
				'color' => $color,
				'size' => $size,
				'quantity' => $quantity,
				'note' => $note,
				'imgurl' => $param['img'],
				'price' => $price,
				'freight' => $freight,
				'type' => 1
        		);
        
        	$this->load->model('checkout/cart');
        	$cart_id = $this->model_checkout_cart->addCart($data);
        	$snatch_key = 'snatch_'.$cart_id;
        	$this->cart->addsearch($snatch_key, $quantity, $color, $size, $note, $freight, $price);
        	$this->load->model('app/user');
		
		$this->load->model('account/customer');
		$customer = $this->model_account_customer->getCustomer($customer_id);				
		if ($customer) {
			if ($customer['cart'] && is_string($customer['cart'])) {
                		$cart = unserialize($customer['cart']);
                		foreach ($cart as $key => $value) {
                    			if (!array_key_exists($key, $this->session->data['cart'])) {
                        			$this->session->data['cart'][$key] = $value;
                    			}
                		}
			}
		}
		
			$this->model_app_user->updateCart($customer_id);

			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//查询购物车列表
	public function cart() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$data = array();
			$this->load->model('tool/image');
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			if ($customer) {
				if ($customer['cart'] && is_string($customer['cart'])) {
	                $cart = unserialize($customer['cart']);
	                foreach ($cart as $key => $value) {
	                    if (!array_key_exists($key, $this->session->data['cart'])) {
	                        $this->session->data['cart'][$key] = $value;
	                    }
	                }
	            }
	            // var_dump($this->session->data['cart']);
				$products = $this->cart->getProducts();
				ksort($products);
				foreach ($products as $product) {
					$product_total = 0;
					foreach ($products as $product_2) {
						if ($product_2['product_id'] == $product['product_id']) {
	                        $product_total += $product_2['quantity'];
	                    }
					}
					//understock
	                if ($product['minimum'] > $product_total) {
	                    $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_understock'))));
	                    echo($arr);
	                    exit();
	                }
	                //resize image
	                // if (array_key_exists('image', $product) && $product['image']) {
	                // 	$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
	                // 	if (!$image)
	                // 		$image = $product['image'];
	                // } else {
	                // 	$image = '';
	                // }
	                
	                $reg = '/^http:\/\//';
	                $image = preg_match($reg, $product['image']) ? $product['image'] : ('http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['image']);
	                // Display price
	                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	                    $price = $product['price'];
	                } else {
	                    $price = false;
	                }
	                // Display total prices
	                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	                    $total = $product['price'] * $product['quantity'];
	                } else {
	                    $total = false;
	                }
	                //size
	                $size = '';
	                if (array_key_exists('size', $product) && $product['size']) {
	                    $size = $product['size'];
	                }
	                //color
	                $color = '';
	                if (array_key_exists('color', $product) && $product['color']) {
	                    $color = $product['color'];
	                }
	                //note
	                $note = '';
	                if (array_key_exists('note', $product) && $product['note']) {
	                    $note = $product['note'];
	                }
	                //yunfei
	                $yunfei = '';
	                if (array_key_exists('yunfei', $product) && $product['yunfei']) {
	                    $yunfei = $product['yunfei'];
	                }
	                //producturl
	                $producturl = '';
	                if (array_key_exists('location', $product) && $product['location']) {
	                    $producturl = $product['location'];
	                }
	                //storeurl
	                $storeurl = '';
	                if (array_key_exists('storeurl', $product) && $product['storeurl']) {
	                    $storeurl = $product['storeurl'];
	                }
	                //storename
	                $storename = '';
	                if (array_key_exists('storename', $product) && $product['storename']) {
	                    $storename = $product['storename'];
	                }
					
					if($product['order_status_buy']==5){
						$storename='Cosplay商城';
					}
						
	                //href
	                $href = '';
	                if (strlen($product['key']) < 8) {
	                    $href = $this->url->link('product/product', 'product_id=' . $product['product_id']);
	                } else {
	                    $href = 'http://item.taobao.com/item.html?id=' . $product['product_id'];
	                }
	                //profile description
	                $profile_description = '';
	                if ($product['recurring']) {
	                    $frequencies = array(
	                        'day' => $this->language->get('text_day'),
	                        'week' => $this->language->get('text_week'),
	                        'semi_month' => $this->language->get('text_semi_month'),
	                        'month' => $this->language->get('text_month'),
	                        'year' => $this->language->get('text_year'),
	                    );
	                    if ($product['recurring_trial']) {
	                        $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));
	                        $profile_description = sprintf($this->language->get('text_trial_description'), $recurring_price, $product['recurring_trial_cycle'], $frequencies[$product['recurring_trial_frequency']], $product['recurring_trial_duration']) . ' ';
	                    }
	                    $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));
	                    if ($product['recurring_duration']) {
	                        $profile_description .= sprintf($this->language->get('text_payment_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
	                    } else {
	                        $profile_description .= sprintf($this->language->get('text_payment_until_canceled_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
	                    }
	                }

					$data['products'][] = array(
		    			'key'                 => $product['key'],
		    			'thumb'               => $image,
		    			'name'                => $product['name'],
		    			'model'               => $product['model'],
		    			'quantity'            => $product['quantity'],
		    			'stock'               => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
		    			'reward'              => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
		    			'price'               => $price,
		    			'total'               => $total,
		    			'size'                => $size,
		    			'color'               => $color,
		    			'note'		     	  => $note,
		    			'yunfei'              => $yunfei,
		    			'producturl'          => $producturl,
		    			'storename'           => $storename,
		    			'storeurl'            => $storeurl,
		    			'href'                => $href,
		    			'remove'              => $this->url->link('checkout/cart', 'remove=' . $product['key']),
		    			'recurring'           => $product['recurring'],
		    			'profile_name'        => $product['profile_name'],
		    			'profile_description' => $profile_description
		    		);
				}

				$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $data)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0 , 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//修改购物车数量/备注
	public function cart_update() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$productId = $param['productId'];
			$quantity = $param['quantity'] ? $param['quantity'] : 1;
			$remark = $param['remark'] ? $param['remark'] : '';
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);				
			if ($customer) {
				if ($customer['cart'] && is_string($customer['cart'])) {
	                		$cart = unserialize($customer['cart']);
	                		foreach ($cart as $key => $value) {
	                    			if (!array_key_exists($key, $this->session->data['cart'])) {
	                        			$this->session->data['cart'][$key] = $value;
	                    			}
	                		}
				}
			}
			if (!empty($productId)) {
				$key = $productId;
                		$value = $quantity;
				$value2 = $remark;
				if(strstr($key,'snatch')) {
                    			$key_info = explode('_',$key);
                    			$id = $key_info[1];
                    			//更新购物车中订单数量或者
                    			if($id) {
                         			$data = array(
                        				'cart_id' => $id,
                   	       				 'quantity' => $value,
                        				'note' => $value2
                    	 			);
                        
                        			$this->load->model('app/user');
                       				$this->model_app_user->updatesnatch($data);
                    			}
                		}else{
	    				if (!empty($value))
	    					$this->cart->update($key, $value);  
	    				$this->cart->updateRemark($key, $value2);
                		}

				$this->load->model('app/user');
				$this->model_app_user->updateCart($customerId);
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notexists'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//从购物车中删除商品
	public function cart_delete() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$productId = $param['productId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);				
			if ($customer) {
				if ($customer['cart'] && is_string($customer['cart'])) {
	                		$cart = unserialize($customer['cart']);
	                		foreach ($cart as $key => $value) {
	                    			if (!array_key_exists($key, $this->session->data['cart'])) {
	                        			$this->session->data['cart'][$key] = $value;
	                    			}
	                		}
				}
			}
			if (!empty($productId)) {
				$key = $productId;
				$this->cart->remove($key);
				
				if(strstr($key,'snatch')) {
                    $key_info = explode('_',$key);
                    $id = $key_info[1];
                    if($id) {
                        $this->load->model('checkout/cart');
                        $this->model_checkout_cart->delCartbyId($id);
                    }
                }

				$this->load->model('app/user');
				$this->model_app_user->updateCart($customerId);
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notexists'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//购物车商品提交
	public function cart_submit() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$products = $param['products'];
		
			if (!empty($products)) {
				$this->load->model('account/customer');
				$customer = $this->model_account_customer->getCustomer($customerId);

				$productIds = array();
				foreach ($products as $key => $value) {
					// $productIds[] = substr($key, 0, strpos($key, ':'));
					$productIds[] = $key;
				}
				
				if ($customer) {
					if ($customer['cart'] && is_string($customer['cart'])) {
		                		$cart = unserialize($customer['cart']);
		                		foreach ($cart as $key => $value) {
		                    			if (!array_key_exists($key, $this->session->data['cart'])) {
		                        			$this->session->data['cart'][$key] = $value;
		                    			}
		                		}
					}
				}
			
				$store_array = array();
            			$store_url_array = array();
            			$order_id_array = array();
				
				$getProducts = $this->cart->getProductsMobile();
				
				//file_put_contents("./4.log",var_export($getProducts,TRUE)."\r\n",FILE_APPEND);
				foreach ($getProducts as $product) {
					if(in_array($product['key'], $productIds)) {
						$store_array[] = $product['storename'];
						$store_array = array_unique($store_array);
						$store_url_array[$product['storename']] = $product['storeurl'];
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
		                        $data['store_id'] = 1;//手机购物通过store_id来区分，为1即手机
		                        $data['storename'] = $store;
		                        $data['storeurl'] = $store_url_array[$store];


		                        $data['customer_id'] = $customerId;
		                        $data['customer_group_id'] = $customer['customer_group_id'];
				        $data['firstname'] = $customer['firstname'];
				        $data['lastname'] = $customer['lastname'];
				        $data['email'] = $customer['email'];
				        $data['telephone'] = $customer['telephone'];
		                        $data['money'] = $customer['money'];

                    			$data['fax'] = '';

                    			$product_data = array();
                    			$yunfei_array = array();
                    			$sub_total = array();
                    			foreach ($this->cart->getProducts() as $product) {
                    				if(in_array($product['key'], $productIds)) {
		                    			if ($product['storename'] == $store) {
		                    				$num_iid = $this->getTBId($product['location']);
		                    				// if (strlen($product['key']) < 8) {//存放在数据库product表中的商品
		                    				// 	$num_iid = $this->getTBId($product['location']);
					                    	// } else {//通过淘宝抓取来的商品
					                    	// 	$num_iid = $product['product_id'];
					                    	// }
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
					                            'img' => $product['image'],
					                            'num_iid' => $num_iid
					                        );
		                    			}
		                		}
                    			}
                    			sort($yunfei_array);

		                        $data['order_shipping'] = end($yunfei_array);
		                        $data['total'] = array_sum($sub_total) + end($yunfei_array);
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

		                        //订单购买状态，默认 1:代购 2:自助 3:代寄
		                        $data['order_status_buy'] = 1;
		                        //订单状态, 1 未付款 2 已付款
		                        $data['order_status_id'] = 1;

		                        $this->load->model('app/order');
		                        $order_id_temp = $this->model_app_order->addOrder($data);
							
		                        $order_id_array[] = $order_id_temp;
		                        $this->data['order_id'] = $order_id_temp;
				}
					$this->data['order_id_array'] = $order_id_array;
            
                		if(!empty($order_id_array)) {
		                    foreach($products as $k => $v) {
		                        if(strstr($k,'snatch')) {
		                            $key_info = explode('_',$k);
		                            $id = $key_info[1];
		                            if($id) {
		                                $this->load->model('checkout/cart');
		                                $this->model_checkout_cart->delCartbyId($id);
		                            }
		                            $this->cart->remove($k);
		                        } else {
		                            $this->cart->remove($k);
		                        }
		                    }
                    		    $this->load->model('app/user');
				    $this->model_app_user->updateCart($customerId);
                    		    $result=array('order_ids' => $order_id_array, 'balance' => $data['money']);
        	   		    $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
				    echo($arr);
                		} else {
                			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_failed'))));
					echo($arr);
                		}
            		} else {
                		$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notchoose'))));
				echo($arr);
            		}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	public function getTBId($strurl) {
	    $strurl = strtolower ( $strurl );
	    if (strpos ( $strurl, 'id' ) !== false) {
	        $arr = explode ( '?', $strurl );
	        $arr = explode ( '&', $arr [1] );
	        $NO = 0;
	        foreach ( $arr as $k => $v ) {
	            if (is_string ( $v )) {
	                //判断是否含有id
	                if (strpos ( $v, 'id' ) !== false) {
	                    //处理含有item或者num项 返还id数
	                    if (strpos ( $v, 'item' ) !== false || strpos ( $v, 'num' ) !== false) {
	                        //echo $v,'<br/>';
	                        $i = strrpos ( $v, '=' );
	                        $str = substr ( $v, $i + 1 );
	                        if (is_numeric ( $str )) {
	                            return $NO = $str;
	                        }
	                    } else {
	                        //echo $v,'<br/>';
	                        $i = strrpos ( $v, '=' );
	                        $str = substr ( $v, $i + 1 );
	                        $x = strlen ( $str );
	                        if (is_numeric ( $str )) {
	                            if ($x ==11) {
	                                $NO = $str;
	                            } else if ($NO == 0 || ($x > 9 && $x < 11)) {
	                                $NO = $str;
	                            }
	                        }
	                    }
	                }
	            }
	        }
	        return $NO;
	    }
	}

}
?>