<?php
class ControllerCosplayCategory extends Controller {
	public function index() {
	
		$categoryName = isset ( $_GET ['categoryName'] ) ? $_GET ['categoryName'] : '';
		
		$s_categoryName = isset ( $_GET ['s_categoryName'] ) ? $_GET ['s_categoryName'] : '';
		
		$sort = isset ( $_GET ['sort'] ) ? $_GET ['sort'] : '';
	
		$this->data ['categoryName'] = $categoryName;
		
		$this->data ['s_categoryName'] = $s_categoryName;

		$this->data ['home'] = $this->url->link ( 'common/home' );
        
		$this->load->model ( 'cosplay/main' );
		
		$this->load->model ( 'tool/image' );
		
		$this->data ['products'] = array ();
		
		// add by weikun 从数据表中获取所有分类的数据
		$this->data ['products_categoryid_info'] = array ();
		
		$this->data ['categoryids'] = array ();
		
		$this->data ['s_categoryids'] = array ();
		
		$results = $this->model_cosplay_main->getCategories();
		
		$categoryid_all = array ();
		
		foreach ( $results as $result ) {
			if ($result) {
				$categoryid_all [] = $result ['category_id'];
				
				$s_results = $this->model_cosplay_main->getCategories ( $result ['category_id'] );
				
				if ($s_results) {
					foreach ( $s_results as $s_result ) {
						$this->data ['s_categoryids'] [] = array (
								's_category_id' => $s_result ['category_id'],
								'name' => $s_result ['name'],
								's_parent_category_id' => $result ['category_id'],
								'href' => $result ['category_id'] . "_" . $s_result ['category_id'] . "-cosplay.html" 
						);
						
					}
				}
				
				$this->data ['categoryids'] [] = array (
						'category_id' => $result ['category_id'],
						'name' => $result ['name'],
						 'href'=>'http://www.acgstorm.com/'.$result['parent_id'].'_'.$result['category_id'].'-cosplay.html'
				);
			}
		}
        
       // var_dump($this->data ['s_categoryids']);
       // var_dump($this->data ['categoryids']);
		
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
        
        //var_dump($this->request->get ['path']);
        	$url = '';
			
			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}
			
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
	                        $this->data['categoryName'] = $this->model_cosplay_main->getSingalBigCategory ( $big_id );
	                        $this->data['s_categoryName'] = $this->model_cosplay_main->getSingalSmallCategory ( $small_id );
	                        $this->data['path'] = $big_id.'_'.$big_id;
				foreach ( $parts as $path_id ) {
					if (! $path)	$path = ( int ) $path_id;
					else	$path .= '_' . ( int ) $path_id;
				}
			}	
	
			$category_info = $this->model_cosplay_main->getCategory ( $category_id ); 
			
			foreach($this->data ['categoryids'] as $value){
				if($value['category_id']==$category_info['parent_id']){
					$category_info['indexParent']=$value['name'];
				}
			}		
	
			if ($category_info) {
			
			$this->document->addScript ( 'catalog/view/javascript/jquery/jquery.total-storage.min.js' );
			
			
			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}
			
			if (isset ( $this->request->get ['page'] )) {
				$url .= '&page=' . $this->request->get ['page'];
			}
			
			if (isset ( $this->request->get ['limit'] )) {
				$url .= '&limit=' . $this->request->get ['limit'];
			}
			
			if ($category_info['image']) {
				$this->data ['thumb'] = $this->model_tool_image->resize ( $category_info ['image'], $this->config->get ( 'config_image_category_width' ), $this->config->get ( 'config_image_category_height' ) );
			} else {
				$this->data ['thumb'] = '';
			}
			$this->data['indexPath']=$this->request->get['path'].'-cosplay.html';
			$this->data ['description'] = html_entity_decode ( $category_info ['description'], ENT_QUOTES, 'UTF-8' );
			$this->data ['compare'] = $this->url->link ( 'product/compare' );
			if(isset($category_info ['indexParent'])){
				$this->data ['indexParent'] =$category_info ['indexParent'];
			}
			$this->data ['indexCartgory'] =  $category_info ['name'];
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
			
			$results = $this->model_cosplay_main->getCategories ( $category_id );
			// var_dump($results);
			
			foreach ( $results as $result ) {
				$data = array (
						'filter_category_id' => $result ['category_id'],
						'filter_sub_category' => true 
				);
				
				// var_dump($data);
				$product_total = $this->model_cosplay_main->getTotalProducts ( $data );
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

/*
			//将查询结果集放到文件中，失效时间未过时从文件中读取
			//add by fc

			$fn = '';
			$f = isset($this->request->get['path']) ? $this->request->get['path'] : '0_0';
			$b = isset($this->request->get['page']) ? $this->request->get['page'] : '1';
			$fn = $f . '_' . $b;
			require_once(DIR_SYSTEM . 'cache.class.php');
			$cache = new MyCache();
			$results = $cache->file2array('cosplayproductcache', $fn);
			
			if (null == $results) {
				// echo('11111111111');
				$results = $this->model_cosplay_main->getProducts ( $data );
				
				$cache->array2file($results, 'cosplayproductcache', $fn);
			}
			*/
			$results = $this->model_cosplay_main->getProducts ( $data );
			$product_total = $this->model_cosplay_main->getTotalProducts ( $data );
			
			$this->data ['product_total'] = $product_total;
		
			if ($results) {

				foreach ( $results as $result ) {
					
					if ($result ['image']) {
						$image = "image/" . $result ['image'];
					} else {
						$image = false;
					}
					
					if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
						$price = $result ['price'];
					} else {
						$price = false;
					}
					
					$this->data ['products'] [] = array (
							'viewed' => $result ['viewed'],
							'date_added' => $result ['date_added'],
							'product_id' => $result ['product_id'],
						'thumb' =>  $this->model_tool_image->resize ( $result['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) ),
							'name' => $result ['name'],
							'description' => utf8_substr ( strip_tags ( html_entity_decode ( $result ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ) . '..',
							'price' => $price,
							'href' => $this->request->get ['path']. "-cosplay.html&product_id=" . $result ['product_id'] . $url
					);
				}
			
             //var_dump($this->data ['products']);
            	
			 //var_dump($this->request->get ['path']);
            
			 $sort= isset ( $_GET ['sort'] ) ? $_GET ['sort'] : ''; 
			 if ($sort== 'id') { $this->data['sort_id'] = isset ( $_GET ['sort_id'] ) ? $_GET ['sort_id'] : ''; $this->data['sort_id'] = $this->data['sort_id'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_id = $this->data['sort_id']; $this->data['sort_name'] = 1; $this->data['sort_age'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'viewed', $sort_id ); }
			 if ($sort== 'name') { $this->data['sort_name'] = isset ( $_GET ['sort_name'] ) ? $_GET ['sort_name'] : ''; $this->data['sort_name'] = $this->data['sort_name'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_name = $this->data['sort_name']; $this->data['sort_id'] = 1; $this->data['sort_age'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'date_added', $sort_name ); }
			 if ($sort== 'age') { $this->data['sort_age'] = isset ( $_GET ['sort_age'] ) ? $_GET ['sort_age'] : ''; $this->data['sort_age'] = $this->data['sort_age'] == SORT_ASC ? SORT_DESC : SORT_ASC; $sort_age = $this->data['sort_age']; $this->data['sort_id'] = 1; $this->data['sort_name'] = 1; $this->data['products'] = $this->multi_array_sort ( $this->data['products'], 'price', $sort_age ); }
			 if ($sort== '') { $this->data['sort_id'] = 1; $this->data['sort_name'] = 1; $this->data['sort_age'] = 1; }
				 
				
				$pagination = new Pagination ();
				
				$pagination->total = $product_total;
				
				$pagination->page = $page;
				
				$pagination->limit = $limit;
				
				$pagination->text = $this->language->get ( 'text_pagination' );
				
				// $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
                
                
				$pagination->url = $this->request->get ['path'] . '-cosplay.html&page={page}' . $url;
   
				$this->data ['urlNew'] = $this->request->get ['path']."-cosplay.html";
    
				
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
                
			$this->data ['heading_title']='CNstorm Cosplay商城_'.$this->data['categoryName'].'_'.$this->data['s_categoryName'];
			$this->data ['keywords']='Cosplay,Cosplay服装,Cosplay衣服,动漫服装,Cosplay道具';             
			$this->data ['description']='CNstorm Cosplay商城网罗了全系列的原创动漫Cosplay服饰和周边衍生产品，如动漫主题周边、影视主题周边、游戏主题周边、Cosplay道具等。Cosplay骨灰级玩家的首选';
				if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/cosplay/category.tpl' )) {
					$this->template = $this->config->get ( 'config_template' ) . '/template/cosplay/category.tpl';
				} else {
					$this->template = 'default/template/cosplay/category.tpl';
				}
				
				$this->children = array (
						'common/footer',
						'common/header_cosplay' 
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
			$this->data ['heading_title']='CNstorm Cosplay商城';
			$this->data ['keywords']='Cosplay,Cosplay服装,Cosplay衣服,动漫服装,Cosplay道具';             
			$this->data ['description']='CNstorm Cosplay商城网罗了全系列的原创动漫Cosplay服饰和周边衍生产品，如动漫主题周边、影视主题周边、游戏主题周边、Cosplay道具等。Cosplay骨灰级玩家的首选';
				$this->response->setOutput ( $this->render () );
			}
		} 
		
		}else if(!empty($sort)){
			
			switch($sort){
				case 'viewed':
				$sort = 'p.viewed';
				$this->data ['indexCartgory']='人气热卖';
				$this->data['is_display']=0;
				break;
				case 'date_modified':
				$sort = 'p.date_modified';
				$this->data ['indexCartgory']='所有宝贝';
				$this->data['is_display']=0;
				break;
				case 'price':
				$sort = 'p.price';
				$this->data ['indexCartgory']='综合排序';
				$this->data['is_display']=0;
				break;
				case 'sort_order':
				$sort = 'p.sort_order';
				$this->data ['indexCartgory']='最新上架';
				$this->data['is_display']=0;
				break;
			}
			$data = array (
							'filter_category_id' =>'', 
							'sort' => $sort,
							'order' => '',
							'start' => ($page - 1) * $limit,
							'limit' => $limit 
			);
			$results = $this->model_cosplay_main->getProducts ( $data );
		
			$product_total = $this->model_cosplay_main->getTotalProducts ( $data );
			
			$this->data ['product_total'] = $product_total;
			$path='';
			 foreach ( $results as $result ) {
					
					if ($result ['image']) {
						$image = "image/" . $result ['image'];
					} else {
						$image = false;
					}
					
					if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
						$price = $result ['price'];
					} else {
						$price = false;
					}
					$category=$this->model_cosplay_main->getCategory1($result['product_id']);
					//var_dump($category);
					if(isset($category->rows[2])){
					
						$path='/'.$category->rows[2]['category_id'].'_'.$category->rows[2]['parent_id']."-cosplay.html&product_id=" . $result ['product_id'] . $url;
					}else{
						$path='/cosplay-product.html&product_id='.$result['product_id'];
					}
					
					
					
					$this->data ['products'] [] = array (
							'viewed' => $result ['viewed'],
							'date_added' => $result ['date_added'],
							'product_id' => $result ['product_id'],
							'thumb' => $image,
							'name' => $result ['name'],
							'description' => utf8_substr ( strip_tags ( html_entity_decode ( $result ['description'], ENT_QUOTES, 'UTF-8' ) ), 0, 100 ) . '..',
							'price' => $price,
							'href' => $path
					);
				}
   
				$pagination = new Pagination ();
				
				$pagination->total = $product_total;
				
				$pagination->page = $page;
				
				$pagination->limit = $limit;
				
				$pagination->text = $this->language->get ( 'text_pagination' );
				
				// $pagination->url = $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url . '&page={page}');
                
                
				$pagination->url =  '/index.php?route=cosplay/category&page={page}' . $url;
   
				$this->data ['urlNew'] = "/index.php?route=cosplay/category";
    
				
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
                
                
				if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/cosplay/category.tpl' )) {
					$this->template = $this->config->get ( 'config_template' ) . '/template/cosplay/category.tpl';
				} else {
					$this->template = 'default/template/cosplay/category.tpl';
				}
			$this->data ['heading_title']='CNstorm Cosplay商城';
			$this->data ['keywords']='Cosplay,Cosplay服装,Cosplay衣服,动漫服装,Cosplay道具';             
			$this->data ['description']='CNstorm Cosplay商城网罗了全系列的原创动漫Cosplay服饰和周边衍生产品，如动漫主题周边、影视主题周边、游戏主题周边、Cosplay道具等。Cosplay骨灰级玩家的首选';
				$this->children = array (
						
						'common/footer',
						'common/header_cosplay' 
				);
				
				$this->response->setOutput ( $this->render () );
		
		}else {
			$this->session->data['redirect'] = $this->url->link('cosplay/main', '', 'SSL');
            $this->redirect($this->url->link('cosplay/main', '', 'SSL'));
		}
  
  
  
        }
        
		public function search(){

				$this->load->model('tool/image');
				
			
				
				
				if (isset($this->request->get['keyword'])) {
					$keyword = $this->request->get['keyword'];
				} else {
					$keyword = '';
				}
				if (isset($this->request->get['page'])) {
					$page = $this->request->get['page'];
				} else {
					$page = 1;
				}
				
				$url = '';
				if (isset($this->request->get['keyword'])) {
					$url .= '&keyword=' . urlencode(html_entity_decode($this->request->get['keyword'], ENT_QUOTES, 'UTF-8'));
				}
				$this->data['indexCartgory']="<span style='color:green'>".$this->request->get['keyword']."</span>".'的搜索结果';
				$limit=$this->config->get('config_admin_limit');
				$this->load->model('cosplay/main');
				$this->data['filter_name']=	$keyword;
				$this->data['start']=($page-1)*$limit;
				$this->data['limit']=$limit;
		
				$product_total = $this->model_cosplay_main->getTotalProducts($this->data);
				$results = $this->model_cosplay_main->getProducts($this->data);
						
			foreach($results as $key=>$result){
				if ($result ['image']) {
					$results[$key] ['thumb'] = $this->model_tool_image->resize ( $result['image'], $this->config->get( 'config_image_thumb_width' ),$this->config->get ( 'config_image_thumb_height' ) );
					
				} else {
					$results[$key] ['thumb'] = '';
				}
				
					$rows=$this->model_cosplay_main->getCategory1($result['product_id']);
					$index=count($rows->rows)-1;
					$results[$key]['href']=$rows->rows[$index]['parent_id'].'_'.$rows->rows[$index]['category_id'].'-cosplay.html&product_id='.$result['product_id'];
			}
				$this->data['products']=$results;
				$pagination = new Pagination();
				$pagination->total = $product_total;
				$pagination->page = $page;
				$pagination->limit = $this->config->get('config_admin_limit');
				$pagination->text = $this->language->get('text_pagination');
				$pagination->url = $this->url->link('cosplay/category/search'.$url.'&page={page}');

				$this->data['pagination'] = $pagination->render();
				
				$results = $this->model_cosplay_main->getCategories();
        
				$categoryid_all = array();
				
				foreach ($results as $result) {
					
					if ($result) {
						
						 $categoryid_all[]=$result['category_id'];
								  
						 $s_results = $this->model_cosplay_main->getCategories($result['category_id']);
							  
						 if($s_results)
						 {
							 foreach($s_results as $s_result)
							 {  
								$this->data['s_categoryids'][] = array(
								   's_category_id' => $s_result['category_id'],
								   'name' => $s_result['name'],
								   's_parent_category_id' => $result['category_id'],
								   'href' => $result['category_id']."_".$s_result['category_id']."-cosplay".".html"     
								);
															
							 }
						 }
						 
						 $this->data['categoryids'][] = array(
								 'category_id' => $result['category_id'],
								 'name' => $result['name'] 
						 );
		   
		   
		   
					}      
				}
				
				
			   $this->children = array(
							'common/footer',
							'common/header_cosplay'
							);
				$this->template = 'cnstorm/template/cosplay/category.tpl';
				$this->response->setOutput ( $this->render());
			}
        
	
}

?>