<?php

/**
 * @description：手机接口收藏夹部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-8
 */
Class ControllerAppWishlist extends Controller {

	//添加收藏
	public function add () {
	
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
		
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);

			$product_id = $param['productId'];
			$customerId = $param['customerId'];
			
			
			if (!isset($this->session->data['wishlist'])) {
				$this->session->data['wishlist'] = array();
			}
			
			$this->load->model('catalog/product');
			$product_info = $this->model_catalog_product->getProduct($product_id);
			if ($product_info) {
				if (!in_array($product_id, $this->session->data['wishlist'])) {	
					$this->session->data['wishlist'][] = $product_id;
				}
				$sql="select wishlist from oc_customer where customer_id=".$customerId ;
				$qury=$this->db->query($sql);
				$str=$qury->row['wishlist'];
			
				$this->load->model('app/user');
				$this->model_app_user->updateWishlist($customerId);
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

	//取消收藏
	public function remove () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$product_id = $param['productId'];
			$customerId = $param['customerId'];
			if (isset($this->session->data['wishlist'])){
				$key = array_search($product_id, $this->session->data['wishlist']);
			}else{
				$key = false;
			}
			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
				$this->load->model('app/user');
				$this->model_app_user->updateWishlist($customerId);
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_not_in_wishlist'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//显示所有收藏
	public function index () {
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		$this->language->load('app/app');
		/*if (isset($this->session->data['wishlist']))
			$wishlists = $this->session->data['wishlist'];
		else
			$wishlists = array();*/
		$str = str_replace("&quot;", "\"", $this->request->post['param']);
		$param = json_decode($str, true);
		$customerId = $param['customerId'];
		$this->load->model('account/customer');
		$customer = $this->model_account_customer->getCustomer($customerId);
		if ($customer['wishlist'] && is_string($customer['wishlist'])) {
			if (!isset($this->session->data['wishlist'])) {
                $this->session->data['wishlist'] = array();
            }
            $wishlist = unserialize($customer['wishlist']);
            foreach ($wishlist as $product_id) {
                if (!in_array($product_id, $this->session->data['wishlist'])) {
                    $this->session->data['wishlist'][] = $product_id;
                }
            }
        } else {
        	$this->session->data['wishlist'] = array();
        }
        $reg = '/^http:\/\//';
		foreach ($this->session->data['wishlist'] as $key => $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);

			if ($product_info) {
				// if ($product_info['image']) {
				// 	$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
				// } else {
				// 	$image = false;
				// }
				$image = $product_info['image'];

				if ($product_info['quantity'] <= 0) {
					$stock = $product_info['stock_status'];
				} elseif ($this->config->get('config_stock_display')) {
					$stock = $product_info['quantity'];
				} else {
					$stock = $this->language->get('text_instock');
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
	                $price = $product_info['price'];
				} else {
					$price = false;
				}

				if ((float)$product_info['special']) {
	                $special = $product_info['special'];
				} else {
					$special = false;
				}

				$this->data[] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => preg_match($reg, $image) ? $image : 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					//'stock'      => $stock,
					'price'      => $price,		
					//'special'    => $special,
					'location'   => $product_info['location']
				);
			} else {
				unset($this->session->data['wishlist'][$key]);
			}
		}
		$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $this->data)));
		echo($arr);
	}

	//检查是否被收藏
	public function check () {
		$str = str_replace("&quot;", "\"", $this->request->post['param']);
		$param = json_decode($str, true);
		$product_id = $param['productId'];
		if (isset($this->session->data['wishlist'])) {
			$wishlists = $this->session->data['wishlist'];
			if (in_array($product_id, $wishlists)) {
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0)));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0)));
			echo($arr);
		}
	}
	public function checkSC(){
		var_dump( $this->customer->getId());
		var_dump($this->session->data['wishlist']);
	}
	
}
?>