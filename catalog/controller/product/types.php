<?php
class ControllerProductTypes extends Controller {
	public function index() {
		$categoryName = isset ( $_GET ['categoryName'] ) ? $_GET ['categoryName'] : '';
		
		$s_categoryName = isset ( $_GET ['s_categoryName'] ) ? $_GET ['s_categoryName'] : '';
		
		$this->data ['categoryName'] = $categoryName;
		
		$this->data ['s_categoryName'] = $s_categoryName;
		
		$this->data ['home'] = $this->url->link ( 'common/home' );
		
		$this->load->model ( 'catalog/product' );
		
		$this->load->model ( 'catalog/category' );
		
		$this->load->model ( 'tool/image' );
		
		$this->data ['products'] = array ();
		
		// add by weikun 从数据表中获取所有分类的数据
		$this->data ['products_categoryid_info'] = array ();
		
		$this->data ['categoryids'] = array ();
		
		$this->data ['s_categoryids'] = array ();
		
		$results = $this->model_catalog_category->getCategories ();
		
		$categoryid_all = array ();
		
		foreach ( $results as $result ) {
			if ($result) {
				$categoryid_all [] = $result ['category_id'];
				
				$s_results = $this->model_catalog_category->getCategories ( $result ['category_id'] );
				
				if ($s_results) {
					foreach ( $s_results as $s_result ) {
						$this->data ['s_categoryids'] [] = array (
								's_category_id' => $s_result ['category_id'],
								'name' => $s_result ['name'],
								's_parent_category_id' => $result ['category_id'],
								'href' => $result ['category_id'] . "_" . $s_result ['category_id'] .".html" 
						);
					}
				}
				
				$this->data ['categoryids'] [] = array (
						'category_id' => $result ['category_id'],
						'name' => $result ['name'] 
				);
			}
		}
		
		if (isset ( $this->request->get ['filter'] )) {
			$filter = $this->request->get ['filter'];
		} else {
			$filter = '';
		}
		
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'p.sort_order';
		}
		
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		
		if (isset ( $this->request->get ['limit'] )) {
			$limit = $this->request->get ['limit'];
		} else {
			$limit = $this->config->get ( 'config_catalog_limit' );
		}
		$category_id = 0;
		if (isset ( $this->request->get ['path'] )) {
			
			$url = '';
			
			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}
			
			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}
			
			if (isset ( $this->request->get ['limit'] )) {
				$url .= '&limit=' . $this->request->get ['limit'];
			}
			
			if (isset ( $this->request->get ['page'] )) {
				$page = $this->request->get ['page'];
			} else {
				$page = 1;
			}
			
			$path = '';
			if (!empty($this->request->get ['path'])){
				$parts = explode ( '_', ( string ) $this->request->get ['path'] );
	                        $small_id = $parts[1];
				$category_id = ( int ) array_pop ( $parts );
	                        $big_id = $parts[0]; 
	                        $this->data['categoryName'] = $this->model_catalog_category->getSingalBigCategory ( $big_id );
	                        $this->data['s_categoryName'] = $this->model_catalog_category->getSingalSmallCategory ( $small_id );
	                        $this->data['path'] = $big_id.'_'.$big_id;
				foreach ( $parts as $path_id ) {
					if (! $path)	$path = ( int ) $path_id;
					else	$path .= '_' . ( int ) $path_id;
				}
			}	
		}
		$category_info = $this->model_catalog_category->getCategory ( $category_id );
		// var_dump($category_info);		
		if ($category_info) {
			
			$this->document->addScript ( 'catalog/view/javascript/jquery/jquery.total-storage.min.js' );
			
			$url = '';
			
			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}
			
			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}
			
			if (isset ( $this->request->get ['page'] )) {
				$url .= '&page=' . $this->request->get ['page'];
			}
			
			if (isset ( $this->request->get ['limit'] )) {
				$url .= '&limit=' . $this->request->get ['limit'];
			}
			
			if ($category_info ['image']) {
				$this->data ['thumb'] = $this->model_tool_image->resize ( $category_info ['image'], $this->config->get ( 'config_image_category_width' ), $this->config->get ( 'config_image_category_height' ) );
			} else {
				$this->data ['thumb'] = '';
			}
			
			$this->data ['description'] = html_entity_decode ( $category_info ['description'], ENT_QUOTES, 'UTF-8' );
			$this->data ['compare'] = $this->url->link ( 'product/compare' );
			
			$url = '';
			
			if (isset ( $this->request->get ['filter'] )) {
				$url .= '&filter=' . $this->request->get ['filter'];
			}
			
			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}
			
			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}
			
			if (isset ( $this->request->get ['limit'] )) {
				$url .= '&limit=' . $this->request->get ['limit'];
			}
			
			$this->data ['categories'] = array ();
			
			$results = $this->model_catalog_category->getCategories ( $category_id );
			// var_dump($results);
			
			foreach ( $results as $result ) {
				$data = array (
						'filter_category_id' => $result ['category_id'],
						'filter_sub_category' => true 
				);
				
				// var_dump($data);
				$product_total = $this->model_catalog_product->getTotalProducts ( $data );
				// var_dump($product_total);
				// var_dump($this->config->get('config_product_count'));
				// var_dump($this->data['categories']);
				$this->data ['categories'] [] = array (
						'name' => $result ['name'] . ($this->config->get ( 'config_product_count' ) ? ' (' . $product_total . ')' : ''),
						'href' => $this->url->link ( 'product/category', 'path=' . $this->request->get ['path'] . '_' . $result ['category_id'] . $url ) 
				);
			}
			
			$this->data ['products'] = array ();
			
			$sort = isset ( $_GET ['sort'] ) ? $_GET ['sort'] : '';
			if ($sort == 'viewed') {
				$sort = 'p.viewed';
				$this->data ['sort_id'] = isset ( $_GET ['sort_id'] ) ? $_GET ['sort_id'] : '';
				$this->data ['sort_id'] = $this->data ['sort_id'] == 'ASC' ? 'DESC' : 'ASC';
				$order = $this->data ['sort_id'];
				$this->data ['sort_name'] = 1;
				$this->data ['sort_age'] = 1;
			}
			if ($sort == 'date_modified') {
				$sort = 'p.date_modified';
				$this->data ['sort_name'] = isset ( $_GET ['sort_name'] ) ? $_GET ['sort_name'] : '';
				$this->data ['sort_name'] = $this->data ['sort_name'] == 'ASC' ? 'DESC' : 'ASC';
				$order = $this->data ['sort_name'];
				$this->data ['sort_id'] = 1;
				$this->data ['sort_age'] = 1;
			}
			if ($sort == 'price') {
				$sort = 'p.price';
				$this->data ['sort_age'] = isset ( $_GET ['sort_age'] ) ? $_GET ['sort_age'] : '';
				$this->data ['sort_age'] = $this->data ['sort_age'] == 'ASC' ? 'DESC' : 'ASC';
				$order = $this->data ['sort_age'];
				$this->data ['sort_id'] = 1;
				$this->data ['sort_name'] = 1;
			}
			if ($sort == '') {
				$sort = 'p.sort_order';
				$order = null;
				$this->data ['sort_id'] = 1;
				$this->data ['sort_name'] = 1;
				$this->data ['sort_age'] = 1;
			}
			
			$data = array (
					'filter_category_id' => $category_id,
					'sort' => $sort,
					'order' => $order,
					'start' => ($page - 1) * $limit,
					'limit' => $limit 
			);

			//将查询结果集放到文件中，失效时间未过时从文件中读取
			//add by fc
			$fn = '';
			$f = isset($this->request->get['path']) ? $this->request->get['path'] : '0_0';
			$b = isset($this->request->get['page']) ? $this->request->get['page'] : '1';
			$fn = $f . '_' . $b;
			require_once(DIR_SYSTEM . '/cache.class.php');
			$cache = new MyCache();
			$results = $cache->file2array('productcache', $fn);
			if (null == $results) {
				// echo('11111111111');
				$results = $this->model_catalog_product->getProducts ( $data );
				$cache->array2file($results, 'productcache', $fn);
			}
			
			$product_total = $this->model_catalog_product->getTotalProducts ( $data );
			
			// var_dump($product_total);
			
			$this->data ['product_total'] = $product_total;
			
			// var_dump($results);
			
			if ($results) {
				foreach ( $results as $result ) {
					// var_dump($result);exit();
					if ($result ['image']) {
						$image = "image/" . $result ['image'];
					} else {
						$image = false;
					}
					
					if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
						// $price = $this->currency->format($result['price']);
						$price = $result ['price'];
					} else {
						$price = false;
					}
					
					$this->data ['products'] [] = array (
							'viewed' => $result ['viewed'],
							'date_added' => $result ['date_added'],
							'product_id' => $result ['product_id'],
							'thumb' => $image,
							'name' => $result ['name'],
							'description' => utf8_substr ( strip_tags ( html_entity_decode ( $result ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ) . '..',
							'price' => $price,
							'href' => $this->request->get ['path']. ".html&product_id=" . $result ['product_id'] . $url
					);
				}
				
				/*
				 * $sort= isset ( $_GET ['sort'] ) ? $_GET ['sort'] : ''; if ($sort== 'id') { $this->data['sort_id'] = isset ( $_GET ['sort_id'] ) ? $_GET ['sort_id'] : ''; $this->data['sort_id'] = $this->data['sort_id'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_id = $this->data['sort_id']; $this->data['sort_name'] = 1; $this->data['sort_age'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'viewed', $sort_id ); } if ($sort== 'name') { $this->data['sort_name'] = isset ( $_GET ['sort_name'] ) ? $_GET ['sort_name'] : ''; $this->data['sort_name'] = $this->data['sort_name'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_name = $this->data['sort_name']; $this->data['sort_id'] = 1; $this->data['sort_age'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'date_added', $sort_name ); } if ($sort== 'age') { $this->data['sort_age'] = isset ( $_GET ['sort_age'] ) ? $_GET ['sort_age'] : ''; $this->data['sort_age'] = $this->data['sort_age'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_age = $this->data['sort_age']; $this->data['sort_id'] = 1; $this->data['sort_name'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'price', $sort_age ); } if ($sort== '') { $this->data['sort_id'] = 1; $this->data['sort_name'] = 1; $this->data['sort_age'] = 1; }
				 */
				
				$pagination = new Pagination ();
				
				$pagination->total = $product_total;
				
				$pagination->page = $page;
				
				$pagination->limit = $limit;
				
				$pagination->text = $this->language->get ( 'text_pagination' );
				
				// $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
				$pagination->url = $this->request->get ['path'] . '.html&page={page}' . $url;
				
				$this->data ['urlNew'] = $this->request->get ['path'].".html";
				
				$this->data ['pagination'] = $pagination->render ();
				
				// var_dump($pagination);
				
				$this->data ['url'] = $pagination->url;
				
				$this->data ['page'] = $page;
				$total = $pagination->total;
				$limit = $pagination->limit;
				
				if ($total % $limit)
					$pagenum = ($total % $limit) + 1;
				else
					$pagenum = $total / $limit;
				
				$this->data ['pagenum'] = $pagenum;
				
				if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/types.tpl' )) {
					$this->template = $this->config->get ( 'config_template' ) . '/template/product/types.tpl';
				} else {
					$this->template = 'default/template/product/types.tpl';
				}
				
				$this->children = array (
						
						'common/footer',
						'common/header' 
				);
				
				$this->response->setOutput ( $this->render () );
			} else {
				$this->data ['name'] = $category_info ['name'];
				
				$this->response->addHeader ( $this->request->server ['SERVER_PROTOCOL'] . '/1.1 404 Not Found' );
				
				if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/error/search_no_results.tpl' )) {
					$this->template = $this->config->get ( 'config_template' ) . '/template/error/search_no_results.tpl';
				} else {
					$this->template = 'default/template/error/search_no_results.tpl';
				}
				
				$this->children = array (
						
						'common/footer',
						'common/header' 
				);
				
				$this->response->setOutput ( $this->render () );
			}
		} else {
			$this->session->data['redirect'] = $this->url->link('product/favorite', '', 'SSL');
            $this->redirect($this->url->link('product/favorite', '', 'SSL'));
		}
	}
}

?>