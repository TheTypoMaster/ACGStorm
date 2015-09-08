<?php
class ControllerCosplayProduct extends Controller {
	private $error = array ();
	public function index() {
	   
       
		$this->data ['categoryName'] = isset ( $_GET ['categoryName'] ) ? $_GET ['categoryName'] : '';
		
		$this->data ['productCategoryName'] = isset ( $_GET ['productCategoryName'] ) ? $_GET ['productCategoryName'] : '';
		
		//$this->language->load ( 'product/product' );
		
		// $this->document->addScript('catalog/view/javascript/jquery2/product.js');
		
		$this->data ['breadcrumbs'] = array ();
		
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/home' ),
				'separator' => false 
		);
		
		$this->load->model ('cosplay/main' );
		
		if (isset ( $this->request->get ['path'] )) {
		  
			$path = '';
			
			$parts = explode ( '_', ( string ) $this->request->get ['path'] );
			
		
			$small_id = isset($parts[1])? $parts[1]:'';
			$category_id = ( int ) array_pop ( $parts );
			$big_id = isset($parts[0]) ? $parts[0]:'';
			// var_dump($big_id.'_'.$small_id);
            //error_log($big_id."_".$small_id."\r\n",3,"./errors.log");
			$this->data ['categoryName'] = $this->model_cosplay_main->getSingalBigCategory ($big_id );
			$this->data ['s_categoryName'] = $this->model_cosplay_main->getSingalSmallCategory ($small_id );
			$this->data ['productCategoryName'] = $this->model_cosplay_main->getSingalProduct ($this->request->get ['product_id'] );
			$this->data ['path1'] = $big_id . '_' . $big_id;
			$this->data ['path'] = $this->request->get ['path'];
			
			foreach ( $parts as $path_id ) {
				if (! $path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_cosplay_main->getCategory ( $path_id );
				
				if ($category_info) {
					$this->data ['breadcrumbs'] [] = array (
							'text' => $category_info ['name'],
							'href' => $this->url->link ( 'cosplay/category', 'path=' . $path ),
							'separator' => $this->language->get ( 'text_separator' ) 
					);
				}
			}
			
			// Set the last category breadcrumb
			$category_info = $this->model_cosplay_main->getCategory ( $category_id );
			
			if ($category_info) {
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
				
				$this->data ['breadcrumbs'] [] = array (
						'text' => $category_info ['name'],
						'href' => $this->url->link ( 'product/category', 'path=' . $this->request->get ['path'] . $url ),
						'separator' => $this->language->get ( 'text_separator' ) 
				);
			}
		} else {
			$this->data ['s_categoryName'] = 0;
			if (isset($this->request->get ['product_id'])){
				$get_product_id = $this->request->get ['product_id'];
			}else{
				$get_product_id = '';
			}
			//查询商品名字
			$this->data ['productCategoryName'] = $this->model_cosplay_main->getSingalProduct ( $get_product_id );
		}

		$this->load->model ( 'catalog/manufacturer' );
		
		if (isset ( $this->request->get ['manufacturer_id'] )) {
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_brand' ),
					'href' => $this->url->link ( 'product/manufacturer' ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			
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
			
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer ( $this->request->get ['manufacturer_id'] );
			
			if ($manufacturer_info) {
				$this->data ['breadcrumbs'] [] = array (
						'text' => $manufacturer_info ['name'],
						'href' => $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $this->request->get ['manufacturer_id'] . $url ),
						'separator' => $this->language->get ( 'text_separator' ) 
				);
			}
		}
		
		if (isset ( $this->request->get ['search'] ) || isset ( $this->request->get ['tag'] )) {
			$url = '';
			
			if (isset ( $this->request->get ['search'] )) {
				$url .= '&search=' . $this->request->get ['search'];
			}
			
			if (isset ( $this->request->get ['tag'] )) {
				$url .= '&tag=' . $this->request->get ['tag'];
			}
			
			if (isset ( $this->request->get ['description'] )) {
				$url .= '&description=' . $this->request->get ['description'];
			}
			
			if (isset ( $this->request->get ['category_id'] )) {
				$url .= '&category_id=' . $this->request->get ['category_id'];
			}
			
			if (isset ( $this->request->get ['sub_category'] )) {
				$url .= '&sub_category=' . $this->request->get ['sub_category'];
			}
			
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
			
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_search' ),
					'href' => $this->url->link ( 'product/search', $url ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
		}
		
		if (isset ( $this->request->get ['product_id'] )) {
			$product_id = ( int ) $this->request->get ['product_id'];
		} else {
			$product_id = 0;
		}
		
		$product_info = $this->model_cosplay_main->getProduct($product_id);


		if ($product_info) {
			$url = '';
			
			if (isset ( $this->request->get ['path'] )) {
				$url .= '&path=' . $this->request->get ['path'];
			}
			
			if (isset ( $this->request->get ['filter'] )) {
				$url .= '&filter=' . $this->request->get ['filter'];
			}
			
			if (isset ( $this->request->get ['manufacturer_id'] )) {
				$url .= '&manufacturer_id=' . $this->request->get ['manufacturer_id'];
			}
			
			if (isset ( $this->request->get ['search'] )) {
				$url .= '&search=' . $this->request->get ['search'];
			}
			
			if (isset ( $this->request->get ['tag'] )) {
				$url .= '&tag=' . $this->request->get ['tag'];
			}
			
			if (isset ( $this->request->get ['description'] )) {
				$url .= '&description=' . $this->request->get ['description'];
			}
			
			if (isset ( $this->request->get ['category_id'] )) {
				$url .= '&category_id=' . $this->request->get ['category_id'];
			}
			
			if (isset ( $this->request->get ['sub_category'] )) {
				$url .= '&sub_category=' . $this->request->get ['sub_category'];
			}
			
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
			
			$this->data ['breadcrumbs'] [] = array (
					'text' => $product_info ['name'],
					'href' => $this->url->link ( 'product/product', $url . '&product_id=' . $this->request->get ['product_id'] ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			
		
			$this->document->addLink ( $this->url->link ( 'product/product', 'product_id=' . $this->request->get ['product_id'] ), 'canonical' );
			
		
			
			$this->load->model ( 'catalog/review' );
			
            $this->data ['heading_title'] = $product_info ['name'];
			
			$this->data ['product_id'] = $this->request->get ['product_id'];
			$this->data ['manufacturer'] = $product_info ['manufacturer'];
			$this->data ['manufacturers'] = $this->url->link ( 'product/manufacturer/info', 'manufacturer_id=' . $product_info ['manufacturer_id'] );
			$this->data ['model'] = $product_info ['model'];
			$this->data ['reward'] = $product_info ['reward'];
			$this->data ['points'] = $product_info ['points'];
			$this->data ['meta_description'] =  $product_info ['meta_description'];
			$this->data ['meta_keyword'] =  $product_info ['meta_keyword'];
			$this->data ['hcolor'] = '';
			$this->data ['hsize'] = '';
			
		
			if(isset($product_info['price_size'])&& !empty($product_info['price_size'])){
					$this->data['price_size']=json_encode(unserialize($product_info['price_size']));
					
					$arrPriceSize=unserialize($product_info['price_size']);
				//	print_r($arrPriceSize);
					$arrSize=array();
					$arrColor=array();
					if(is_array($arrPriceSize)){
						foreach($arrPriceSize as $key=>$v){
							$arrSize[]= $key;
							foreach($v as $k=>$j){
								$arrColor[]=$k;
							}
						}
					}
				//	print_r($arrColor);
				
					$this->data['arrSize']=$arrSize;
					$arrTmp=array_unique($arrColor);
					$newArrColor=array();

					$i=0;
					 while($arrTmp){
						if(isset($arrTmp[$i]) && !empty($arrTmp[$i])){
							$newArrColor[]=$arrTmp[$i];
							unset($arrTmp[$i]);
						}
						$i++;
					} 
					$this->data['arrColor']=$newArrColor;
				}
			if ($product_info ['quantity'] <= 0) {
				$this->data ['stock'] = $product_info ['stock_status'];
			} elseif ($this->config->get ( 'config_stock_display' )) {
				$this->data ['stock'] = $product_info ['quantity'];
			} else {
				$this->data ['stock'] = $this->language->get ( 'text_instock' );
			}
			
			$this->load->model ( 'tool/image' );
			
			if ($product_info ['image']) {
				$this->data ['popup'] = $this->model_tool_image->resize ( $product_info ['image'], $this->config->get ( 'config_image_popup_width' ), $this->config->get ( 'config_image_popup_height' ) );
			} else {
				$this->data ['popup'] = '';
			}
			///echo  $this->config->get ( 'config_image_thumb_width' );
			///echo $this->config->get ( 'config_image_thumb_height' );
			if ($product_info ['image']) {
				$this->data ['thumb'] = $this->model_tool_image->resize ( $product_info ['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) );
			} else {
				$this->data ['thumb'] = '';
			}
			
			$this->data ['images'] = array ();
			
			$results = $this->model_cosplay_main->getProductImages ( $this->request->get ['product_id'] );
			
			foreach ( $results as $result ) {
				$this->data ['images'] [] = array (
						'popup' => $this->model_tool_image->resize ( $result ['image'], $this->config->get ( 'config_image_popup_width' ), $this->config->get ( 'config_image_popup_height' ) ),
						'thumb' => $this->model_tool_image->resize ( $result ['image'], $this->config->get ( 'config_image_additional_width' ), $this->config->get ( 'config_image_additional_height' ) ) 
				);
			}
			
			if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
				// $this->data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				$this->data ['price'] = $product_info ['price'];
			} else {
				$this->data ['price'] = false;
			}
			// var_dump($product_info);
			// add by weikun 商品详情页面获取商品的国内运费，商品来源，颜色分类，尺码分类，图片来源
			// 商场名称
			if ($product_info ['model']) {
				$this->data ['model'] = $product_info ['model'];
			} else {
				$this->data ['model'] = '';
			}
			// 卖家名称
			if ($product_info ['upc']) {
				$this->data ['upc'] = $product_info ['upc'];
			} else {
				$this->data ['upc'] = '';
			}
			
			// 商品来源
			if ($product_info ['mpn']) {
				$this->data ['mpn'] = $product_info ['mpn'];
			} else {
				$this->data ['mpn'] = '';
			}
			
			if ($product_info ['mpnurl']) {
				$this->data ['mpnurl'] = $product_info ['mpnurl'];
			} else {
				$this->data ['mpnurl'] = '';
			}

			// 商品颜色
            
			if ($product_info ['ean']) {
				$ean = explode(',', $product_info['ean']);
                array_filter($ean);
				$this->data['ean'] = $ean;
			} else {
				$this->data['ean'] = '';
			}
            
            //var_dump($this->data['ean']);
            
			// 商品尺寸
			if ($product_info ['jan']) {
				$jan = explode (',', $product_info['jan']);
                array_filter($jan);
				$this->data ['jan'] = $jan;
			} else {
				$this->data ['jan'] = '';
			}
            
            //var_dump($this->data ['jan']);
            
			// 国内运费
			if ($product_info ['isbn']) {
				$this->data ['isbn'] = $product_info ['isbn'];
			} else {
				$this->data ['isbn'] = '';
			}
            
            
            
            //var_dump($this->data);
            
			/*
			if ($product_info ['location']) {
				include_once (DIR_SYSTEM . 'taobao.class.php');
				$site = htmlspecialchars_decode ( $product_info ['location'] );
				$result ['num_iid'] = 0;
				if (false !== strpos ( $site, 'taobao.com' ) || false !== strpos ( $site, 'tmall.com' )) {
					
					$url_info = parse_url ( $site );
					if(isset($url_info['query'])){
					parse_str ( $url_info ['query'], $param );
					if (! isset($param ['id']) && isset($param ['tradeID']))
						$param ['id'] = $param ['tradeID'];
					if (! isset($param ['id']) && isset($param ['meal_id']))
						$param ['id'] = $param ['meal_id'];
					$result = TAOBAO::getItemInfo ( $param );
					
					if ( is_array( $result ) ){
            		 		   $result = array_map('strip_tags',$result);
            		   		   $result = array_map('trim',$result);
                       			}else{
                           		   strip_tags($result);
                        	           trim($result);
                       	                }
					
					$this->result = $result;
					
					$result ['recommended'] = isset($result ['recommended'])?$result ['recommended']:'';
					$result ['prop_imgs'] = isset($result ['prop_imgs'])?$result ['prop_imgs']:'';
					$result ['item_imgs'] = isset($result ['item_imgs'])?$result ['item_imgs']:'';
					$result ['size_number'] = isset($result ['size_number'])?$result ['size_number']:'';
					$result ['color_number'] = isset($result ['color_number'])?$result ['color_number']:'';
					$result ['price'] = isset($result ['price'])?$result ['price']:'';
					$result ['quantity'] = isset($result ['quantity'])?$result ['quantity']:'';
					$result ['size'] = isset($result ['size'])?$result ['size']:'';
					$result ['color'] = isset($result ['color'])?$result ['color']:'';
					$result ['img_color'] = isset($result ['img_color'])?$result ['img_color']:'';
					
					$this->data ['recommended'] = json_decode ( $result ['recommended'], true );
					$this->data ['prop_imgs'] = json_decode ( $result ['prop_imgs'] );
					$this->data ['item_imgs'] = json_decode ( $result ['item_imgs'] );
					$this->data ['size_number'] = json_decode ( $result ['size_number'], true );
					$this->data ['color_number'] = json_decode ( $result ['color_number'], true );
					$this->session->data ['size_color_price'] = json_decode ( $result ['price'], true );
					$this->session->data ['quantity'] = json_decode ( $result ['quantity'], true );
					// var_dump($this->session->data['size_color_price']);
					$this->session->data ['size_number'] = json_decode ( $result ['size_number'], true );
					$this->session->data ['color_number'] = json_decode ( $result ['color_number'], true );
					$this->session->data ['size'] = $result ['size'];
					$this->session->data ['color'] = $result ['color'];
					$this->session->data ['img_color'] = json_decode ( $result ['img_color'], true );
					}
				}
			}
            */
		
			// end
			
			if (( float ) $product_info ['special']) {
				$this->data ['special'] = $this->currency->format ( $this->tax->calculate ( $product_info ['special'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
			} else {
				$this->data ['special'] = false;
			}
			
			if ($this->config->get ( 'config_tax' )) {
				$this->data ['tax'] = $this->currency->format ( ( float ) $product_info ['special'] ? $product_info ['special'] : $product_info ['price'] );
			} else {
				$this->data ['tax'] = false;
			}
			
			$discounts = $this->model_cosplay_main->getProductDiscounts ( $this->request->get ['product_id'] );
			
			$this->data ['discounts'] = array ();
			
			foreach ( $discounts as $discount ) {
				$this->data ['discounts'] [] = array (
						'quantity' => $discount ['quantity'],
						'price' => $this->currency->format ( $this->tax->calculate ( $discount ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) ) 
				);
			}
			
			$this->data ['options'] = array ();
			
			foreach ( $this->model_cosplay_main->getProductOptions ( $this->request->get ['product_id'] ) as $option ) {
				if ($option ['type'] == 'select' || $option ['type'] == 'radio' || $option ['type'] == 'checkbox' || $option ['type'] == 'image') {
					$option_value_data = array ();
					
					foreach ( $option ['option_value'] as $option_value ) {
						if (! $option_value ['subtract'] || ($option_value ['quantity'] > 0)) {
							if ((($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) && ( float ) $option_value ['price']) {
								$price = $this->currency->format ( $this->tax->calculate ( $option_value ['price'], $product_info ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
							} else {
								$price = false;
							}
							
							$option_value_data [] = array (
									'product_option_value_id' => $option_value ['product_option_value_id'],
									'option_value_id' => $option_value ['option_value_id'],
									'name' => $option_value ['name'],
									'image' => $this->model_tool_image->resize ( $option_value ['image'], 50, 50 ),
									'price' => $price,
									'price_prefix' => $option_value ['price_prefix'] 
							);
						}
					}
					
					$this->data ['options'] [] = array (
							'product_option_id' => $option ['product_option_id'],
							'option_id' => $option ['option_id'],
							'name' => $option ['name'],
							'type' => $option ['type'],
							'option_value' => $option_value_data,
							'required' => $option ['required'] 
					);
				} elseif ($option ['type'] == 'text' || $option ['type'] == 'textarea' || $option ['type'] == 'file' || $option ['type'] == 'date' || $option ['type'] == 'datetime' || $option ['type'] == 'time') {
					$this->data ['options'] [] = array (
							'product_option_id' => $option ['product_option_id'],
							'option_id' => $option ['option_id'],
							'name' => $option ['name'],
							'type' => $option ['type'],
							'option_value' => $option ['option_value'],
							'required' => $option ['required'] 
					);
				}
			}
			
			if ($product_info ['minimum']) {
				$this->data ['minimum'] = $product_info ['minimum'];
			} else {
				$this->data ['minimum'] = 1;
			}
			
			$this->data ['review_status'] = $this->config->get ( 'config_review_status' );
			$this->data ['reviews'] = sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $product_info ['reviews'] );
			$this->data ['rating'] = ( int ) $product_info ['rating'];
			$this->data ['description'] = html_entity_decode ( $product_info ['description'], ENT_QUOTES, 'UTF-8' );
			$this->data ['attribute_groups'] = $this->model_cosplay_main->getProductAttributes ( $this->request->get ['product_id'] );
			
			$this->data ['products'] = array ();
			
			$results = $this->model_cosplay_main->getProductRelated ( $this->request->get ['product_id'] );
			
			foreach ( $results as $result ) {
				if ($result ['image']) {
					$image = $this->model_tool_image->resize ( $result ['image'], $this->config->get ( 'config_image_related_width' ), $this->config->get ( 'config_image_related_height' ) );
				} else {
					$image = false;
				}
				
				if (($this->config->get ( 'config_customer_price' ) && $this->customer->isLogged ()) || ! $this->config->get ( 'config_customer_price' )) {
					$price = $this->currency->format ( $this->tax->calculate ( $result ['price'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$price = false;
				}
				
				if (( float ) $result ['special']) {
					$special = $this->currency->format ( $this->tax->calculate ( $result ['special'], $result ['tax_class_id'], $this->config->get ( 'config_tax' ) ) );
				} else {
					$special = false;
				}
				
				if ($this->config->get ( 'config_review_status' )) {
					$rating = ( int ) $result ['rating'];
				} else {
					$rating = false;
				}
				
				$this->data ['products'] [] = array (
						'product_id' => $result ['product_id'],
						'thumb' => $image,
						'name' => $result ['name'],
						'price' => $price,
						'special' => $special,
						'rating' => $rating,
						'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $result ['reviews'] ),
						'href' => $this->url->link ( 'product/product', 'product_id=' . $result ['product_id'] ) 
				);
			}
			
			$this->data ['tags'] = array ();
			
			if ($product_info ['tag']) {
				$tags = explode ( ',', $product_info ['tag'] );
				
				foreach ( $tags as $tag ) {
					$this->data ['tags'] [] = array (
							'tag' => trim ( $tag ),
							'href' => $this->url->link ( 'product/search', 'tag=' . trim ( $tag ) ) 
					);
				}
			}
			
			$this->data ['text_payment_profile'] = $this->language->get ( 'text_payment_profile' );
			$this->data ['profiles'] = $this->model_cosplay_main->getProfiles ( $product_info ['product_id'] );
			
			$this->model_cosplay_main->updateViewed ( $this->request->get ['product_id'] );
			
			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/cosplay/product.tpl' )) {
				$this->template = $this->config->get ( 'config_template' ) . '/template/cosplay/product.tpl';
			} else {
				$this->template = 'default/template/cosplay/product.tpl';
			}
			
			$this->children = array (
					'common/footer',
					'common/header',
					'common/header_cosplay',
					
			);
			
			$this->response->setOutput ( $this->render () );
		} else {
			$url = '';
			
			if (isset ( $this->request->get ['path'] )) {
				$url .= '&path=' . $this->request->get ['path'];
			}
			
			if (isset ( $this->request->get ['filter'] )) {
				$url .= '&filter=' . $this->request->get ['filter'];
			}
			
			if (isset ( $this->request->get ['manufacturer_id'] )) {
				$url .= '&manufacturer_id=' . $this->request->get ['manufacturer_id'];
			}
			
			if (isset ( $this->request->get ['search'] )) {
				$url .= '&search=' . $this->request->get ['search'];
			}
			
			if (isset ( $this->request->get ['tag'] )) {
				$url .= '&tag=' . $this->request->get ['tag'];
			}
			
			if (isset ( $this->request->get ['description'] )) {
				$url .= '&description=' . $this->request->get ['description'];
			}
			
			if (isset ( $this->request->get ['category_id'] )) {
				$url .= '&category_id=' . $this->request->get ['category_id'];
			}
			
			if (isset ( $this->request->get ['sub_category'] )) {
				$url .= '&sub_category=' . $this->request->get ['sub_category'];
			}
			
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
			
			$this->data ['breadcrumbs'] [] = array (
					'text' => $this->language->get ( 'text_error' ),
					'href' => $this->url->link ( 'product/product', $url . '&product_id=' . $product_id ),
					'separator' => $this->language->get ( 'text_separator' ) 
			);
			
			$this->document->setTitle ( $this->language->get ( 'text_error' ) );
			
			$this->data ['heading_title'] = $this->language->get ( 'text_error' );
			
			$this->data ['text_error'] = $this->language->get ( 'text_error' );
			
			$this->data ['button_continue'] = $this->language->get ( 'button_continue' );
			
			$this->data ['continue'] = $this->url->link ( 'common/home' );
			
			$this->response->addHeader ( $this->request->server ['SERVER_PROTOCOL'] . '/1.1 404 Not Found' );
            
            
			
			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/error/not_found.tpl' )) {
				$this->template = $this->config->get ( 'config_template' ) . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
			
			$this->children = array (
					'common/footer',
					'common/header' 
			);
			
			$this->response->setOutput ( $this->render () );
		}
	}
	public function review() {
		$this->language->load ( 'product/product' );
		
		$this->load->model ( 'catalog/review' );
		
		$this->data ['text_on'] = $this->language->get ( 'text_on' );
		$this->data ['text_no_reviews'] = $this->language->get ( 'text_no_reviews' );
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		
		$this->data ['reviews'] = array ();
		
		$review_total = $this->model_catalog_review->getTotalReviewsByProductId ( $this->request->get ['product_id'] );
		
		$results = $this->model_catalog_review->getReviewsByProductId ( $this->request->get ['product_id'], ($page - 1) * 5, 5 );
		
		foreach ( $results as $result ) {
			$this->data ['reviews'] [] = array (
					'author' => $result ['author'],
					'text' => $result ['text'],
					'rating' => ( int ) $result ['rating'],
					'reviews' => sprintf ( $this->language->get ( 'text_reviews' ), ( int ) $review_total ),
					'date_added' => date ( $this->language->get ( 'date_format_short' ), strtotime ( $result ['date_added'] ) ) 
			);
		}
		
		$pagination = new Pagination ();
		$pagination->total = $review_total;
		$pagination->page = $page;
		$pagination->limit = 5;
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'product/product/review', 'product_id=' . $this->request->get ['product_id'] . '&page={page}' );
		
		$this->data ['pagination'] = $pagination->render ();
		
		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/product/review.tpl' )) {
			$this->template = $this->config->get ( 'config_template' ) . '/template/product/review.tpl';
		} else {
			$this->template = 'default/template/product/review.tpl';
		}
		
		$this->response->setOutput ( $this->render () );
	}
	

	public function captcha() {
		$this->load->library ( 'captcha' );
		
		$captcha = new Captcha ();
		
		$this->session->data ['captcha'] = $captcha->getCode ();
		
		$captcha->showImage ();
	}
	public function upload() {
		$this->language->load ( 'product/product' );
		
		$json = array ();
		
		if (! empty ( $this->request->files ['file'] ['name'] )) {
			$filename = basename ( preg_replace ( '/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode ( $this->request->files ['file'] ['name'], ENT_QUOTES, 'UTF-8' ) ) );
			
			if ((utf8_strlen ( $filename ) < 3) || (utf8_strlen ( $filename ) > 64)) {
				$json ['error'] = $this->language->get ( 'error_filename' );
			}
			
			// Allowed file extension types
			$allowed = array ();
			
			$filetypes = explode ( "\n", $this->config->get ( 'config_file_extension_allowed' ) );
			
			foreach ( $filetypes as $filetype ) {
				$allowed [] = trim ( $filetype );
			}
			
			if (! in_array ( substr ( strrchr ( $filename, '.' ), 1 ), $allowed )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			
			// Allowed file mime types
			$allowed = array ();
			
			$filetypes = explode ( "\n", $this->config->get ( 'config_file_mime_allowed' ) );
			
			foreach ( $filetypes as $filetype ) {
				$allowed [] = trim ( $filetype );
			}
			
			if (! in_array ( $this->request->files ['file'] ['type'], $allowed )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			
			// Check to see if any PHP files are trying to be uploaded
			$content = file_get_contents ( $this->request->files ['file'] ['tmp_name'] );
			
			if (preg_match ( '/\<\?php/i', $content )) {
				$json ['error'] = $this->language->get ( 'error_filetype' );
			}
			
			if ($this->request->files ['file'] ['error'] != UPLOAD_ERR_OK) {
				$json ['error'] = $this->language->get ( 'error_upload_' . $this->request->files ['file'] ['error'] );
			}
		} else {
			$json ['error'] = $this->language->get ( 'error_upload' );
		}
		
		if (! $json && is_uploaded_file ( $this->request->files ['file'] ['tmp_name'] ) && file_exists ( $this->request->files ['file'] ['tmp_name'] )) {
			$file = basename ( $filename ) . '.' . md5 ( mt_rand () );
			
			// Hide the uploaded file name so people can not link to it directly.
			$json ['file'] = $this->encryption->encrypt ( $file );
			
			move_uploaded_file ( $this->request->files ['file'] ['tmp_name'], DIR_DOWNLOAD . $file );
			
			$json ['success'] = $this->language->get ( 'text_upload' );
		}
		
		$this->response->setOutput ( json_encode ( $json ) );
	}
	
	/**
	 * **************************************************************************************
	 * @function：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的颜色尺寸对应的价格
	 *
	 * @param
	 *        	： string $key 参数为该单件商品选定的颜色尺寸键值
	 *        	
	 * @return ： json $data 返回该单件商品的价格
	 *        
	 * @author ： kennewei<wk@cnstorm.com>
	 *        
	 *         @date: 2014.5.15
	 *         **************************************************************************************
	 */
	public function getcolorsizeinfo() {
		$size = '';
		
		$color = '';
		
		$data = array ();
		
		if (isset ( $this->request->post ['size'] )) {
			$size = trim ( $this->request->post ['size'] );
			$size = htmlspecialchars_decode ( $size );
		}
		if (isset ( $this->request->post ['color'] )) {
			$color = trim ( $this->request->post ['color'] );
			$color = htmlspecialchars_decode ( $color );
		}
		
		// var_dump($size);
		
		// var_dump($color);
		
		$color = str_replace ( '_', ':', $color );
		
		$color_number = $this->session->data ['color_number'];
		
		$color = $color_number [$color];
		
		$size = str_replace ( '_', ':', $size );
		
		$size_number = $this->session->data ['size_number'];
		
		$size = $size_number [$size];
		
		$size_color_price = $this->session->data ['size_color_price'];
		
		// var_dump($size_color_price);
		
		$key = $size . '_' . $color;
		
		$data ['price'] = $size_color_price [$key];
		
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/**
	 * *************************************************************************************
	 * @funtion：定义函数getcolorsizeinfo()用于通过淘宝API接口获取单件商品的选择颜色对应的尺寸
	 *
	 * @param
	 *        	： string $key 参数为该单件商品选定的颜色
	 *        	
	 * @return ： json $data 返回该单件商品的缺失尺寸
	 *        
	 * @author ： kennewei<wk@cnstorm.com>
	 *        
	 *         @date: 2014.5.15
	 *         ***************************************************************************************
	 */
	public function getsizeinfo() {
		$color = '';
		
		$data = array ();
		
		$size_array = array ();
		
		if (isset ( $this->request->post ['color'] )) {
			$color = trim ( $this->request->post ['color'] );
			$color = htmlspecialchars_decode ( $color );
		}
		
		$color_number = $this->session->data ['color_number'];
		
		// var_dump($color_number);
		
		$color = str_replace ( '_', ':', $color );
		
		// var_dump($color);
		if (isset($color_number [$color])){
			$color = $color_number [$color];
		}else{
			$color = '';
		}
		// var_dump($color);
		
		// var_dump($size_color_price);
		
		$quantity = $this->session->data ['quantity'];
		
		// var_dump($quantity);
		
		$size_value = $this->session->data ['size'];
		
		$size_number = $this->session->data ['size_number'];
		
		$color_number = $this->session->data ['color_number'];
		
		$size_array = explode ( ',', $size_value );
		
		// var_dump($size_array);
		
		foreach ( $size_array as $size ) {
			
			if (! array_key_exists ( $size . '_' . $color, $quantity ) || $quantity [$size . '_' . $color] < 0) {
				$getSize = array_keys ( $size_number, $size );
				if (isset($getSize[0])){
					$data [] = str_replace ( ':', '_', $getSize[0] );
				}else{
					$data [] = '';
				}
			}
		}
		
		// var_dump($data);
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/**
	 * **********************************************************************************
	 * @function：定义函数getcolorinfo()用于通过淘宝API接口获取单件商品的选择尺寸对应的颜色
	 *
	 * @param  ： string $key 参数为该单件商品选定的尺寸
	 *        	
	 *        	
	 * @return ： json $data 返回该单件商品的缺失颜色
	 *        
	 * @author ： kennewei<wk@cnstorm.com>
	 *        
	 * @date: 2014.5.15
	 * **********************************************************************************
	 */
	public function getcolorinfo() {
		
		$size = '';
		
		$data = array ();
		
		$color_array = array ();
		
		if (isset ( $this->request->post ['size'] )) {
			$size = trim ( $this->request->post ['size'] );
			$size = htmlspecialchars_decode ( $size );
		}
		
		$size = str_replace ( '_', ':', $size );
		
		$size_number = $this->session->data ['size_number'];
		
		$size = $size_number [$size];
		
		// var_dump($size);
		
		// $size_color_price = $this->session->data['size_color_price'];
		
		$quantity = $this->session->data ['quantity'];
		
		// var_dump($size_color_price);
		
		$color_value = $this->session->data ['color'];
		
		$color_number = $this->session->data ['color_number'];
		
		$color_array = explode ( ',', $color_value );
		
		foreach ( $color_array as $color ) {
			if (! array_key_exists ( $size . '_' . $color, $quantity ) || $quantity [$size . '_' . $color] < 0) {
				$getColor = array_keys ( $color_number, $color );
				$getColor = isset($getColor[0])?$getColor[0]:'';
				$data [] = str_replace ( ':', '_', $getColor );
			}
		}
		
		$this->response->setOutput ( json_encode ( $data ) );
	}
	
	/**
	 * *************************************************************************************
	 * @funtion：定义函数getimg()用于通过淘宝API接口获取单件商品的选择颜色对应的主图URL地址
	 *
	 * @param
	 *        	： string $key 参数为该单件商品选定的颜色代码
	 *        	
	 * @return ： json $data 返回该单件商品的选择颜色对应的主图URL地址
	 *        
	 * @author ： kennewei<wk@cnstorm.com>
	 *        
	 *         @date: 2014.5.17
	 *         ***************************************************************************************
	 */
	public function getimg() {
		$color = '';
		
		$data = '';
		
		$color_number = array ();
		
		if (isset ( $this->request->post ['color'] )) {
			$color = trim ( $this->request->post ['color'] );
			$color = htmlspecialchars_decode ( $color );
		}
		
		$color_number = $this->session->data ['color_number'];
		
		// var_dump($color_number);
		
		$color = str_replace ( '_', ':', $color );
		if (isset($color_number [$color])){
			$color = $color_number [$color];
		}else{
			$color = '';
		}
		// var_dump($color_number);
		$getColors = array_keys ( $color_number, $color );
		$color_num = isset($getColors[0])?$getColors[0]:'';
		
		$result = $this->session->data ['img_color'];
		
		// var_dump($color_num);
		// var_dump($result);
		if ( isset( $result[$color_num] ) ){
                        $data = $result [$color_num];
                        $this->response->setOutput ( json_encode ( $data ) );
               }
	}
}
?>
