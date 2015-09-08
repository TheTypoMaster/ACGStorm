<?php
/**
 * @description：手机接口商品部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-8
 */
Class ControllerAppProduct extends Controller {

	//商品分类
	public function product_categories () {
		$this->load->model('catalog/category');
		$results = $this->model_catalog_category->getCategories();
		foreach ($results as $result) {
			if ($result) {
				if($result['category_id']!=193 && $result['category_id']!=233){
					$product = $this->model_catalog_category->getCategories($result['category_id']);
					if ($product) {
						foreach ($product as $s_product) {
							$sub[] = array(
								'category_id' => $s_product['category_id'],
								'name' => $s_product['name'],
								'image' => $s_product['image']
								);
						}
					}
					$data[] = array(
						'category_id' => $result['category_id'],
						'name' => $result['name'],
						'category' => $sub
						);
					$sub = array();
				}
			}
		}
		$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $data)));
		echo($arr);
	}

	//查询商品列表
	public function product_list () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$category_id = $param['categoryId'];
			$page = $param['value'] ? $param['value'] : 1;
            $limit = $this->config->get('config_catalog_limit');
			
			$data = array(
                'filter_category_id' => $category_id,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
                );
			$this->load->model('catalog/product');
			$result = array();
			$products = $this->model_catalog_product->getProducts($data);

			$reg = '/^http:\/\//';
			foreach ($products as $product) {
				if ($product) {
				
						$result[] = array(
							'product_id' => $product['product_id'],
							'name' => $product['name'],
							'location' => $product['location'],//taobao url
							'image' => preg_match($reg, $product['image']) ? $product['image'] : 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['image'],
							'price' => $product['price'],
							'isbn' => $product['isbn']//运费
							);
						
				}
			}
		
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//根据商品名模糊查询商品
	public function search () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$filter_name = $param['keyWord'];
			$page = $param['value'] ? $param['value'] : 1;
            $limit = $this->config->get('config_catalog_limit');
			
			$data = array(
                'filter_name' => $filter_name,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
                );
			$this->load->model('catalog/product');
			$result = array();
			$products = $this->model_catalog_product->getProducts($data);
			$reg = '/^http:\/\//';
			foreach ($products as $product) {
				if ($product) {
					$result[] = array(
						'product_id' => $product['product_id'],
						'name' => $product['name'],
						'location' => $product['location'],//taobao url
						'image' => preg_match($reg, $product['image']) ? $product['image'] : 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['image'],
						'price' => $product['price'],
						'isbn' => $product['isbn']//运费
						);
				}
			}
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//商品详情
	public function product_details () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$url = $param['url'];
			$url = str_replace("amp;", "", $url);
			$search = htmlspecialchars_decode($url);
			include_once(DIR_SYSTEM . 'taobao.class.php');
			if (preg_match('/[http|https]:\/\/[\w.]+[\w\/]*[\w.]*\??[\w=&\+\%]*/is', $search)) {
				if (false !== strpos($search, 'taobao.com') || false !== strpos($search, 'tmall.com')) {
					$url_info = parse_url($search);
					parse_str($url_info['query'],$param);
					if (!$param['id'] && $param['tradeID'])
						$param['id'] = $param['tradeID'];
	 				if (!$param['id'] && $param['meal_id'])
	 					$param['id'] = $param['meal_id'];
	 				$result = TAOBAO::getItemInfo($param);
				
	 				if ($result) {
	 					$result = array_map('strip_tags',$result);
	 					$result = array_map('trim',$result);
	 					$arr = json_encode(array("data"=>array("resultCode"=>1,"result"=>$result)));
	 					echo($arr);
	 				} else {
	 					$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_sold_out'))));
						echo($arr);
	 				}
				}
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

}
?>