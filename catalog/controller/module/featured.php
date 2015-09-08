<?php
class ControllerModuleFeatured extends Controller {
	protected function index($setting) {
		$this->language->load('module/featured'); 

		$this->data['heading_title'] = $this->language->get('heading_title');
       
		$this->data['button_cart'] = $this->language->get('button_cart');
		
		$this->load->model('catalog/product'); 
		
		$this->load->model('tool/image');

		$this->data['products'] = array();
        //add by weikun 从数据表中获取所有分类的数据
        $this->data['products_categoryid_info'] = array();
        
        $this->data['categoryids'] = array();
        
        $this->data['s_categoryids'] = array();
        $results = $this->model_catalog_category->getCategories();
        
        $categoryid_all = array();
        
        foreach ($results as $result) {
            if ($result) {
                 $categoryid_all[]=$result['category_id'];
                         
                 $s_results = $this->model_catalog_category->getCategories($result['category_id']);
                        
                 if($s_results)
                 {
                     foreach($s_results as $s_result)
                     {  
                        $this->data['s_categoryids'][] = array(
                           's_category_id' => $s_result['category_id'],
                           'name' => $s_result['name'],
                           's_parent_category_id' =>$result['category_id'],
                           'href' => $this->url->link('product/category', 'path=' . $result['category_id']."_".$s_result['category_id'])
                                 
                        );
                     }
                 }
                     $this->data['categoryids'][] = array(
                         'category_id' => $result['category_id'],
                         'name' => $result['name'] 
                     );
                     
                     
                 
                
            }      
        }
       
        
		$products = explode(',', $this->config->get('featured_product'));		

		if (empty($setting['limit'])) {
			$setting['limit'] = 5;
		}
		
		$products = array_slice($products, 0, (int)$setting['limit']);
        
        //add by weikun 以商品分类ID从数据库中获取相应的6条数据显示
        foreach ($categoryid_all as $categoryid_all_info) {
            $data = array();
            $data['filter_category_id'] = $categoryid_all_info;
            $data['start'] = 0;
            $data['limit'] = 6;
            
            $products_categoryid_info = $this->model_catalog_product->getProducts($data);
            
            foreach ($products_categoryid_info as $product_categoryid_info) {
                if ($product_categoryid_info) {
                    //限定图片大小尺寸
    				if ($product_categoryid_info['image']) {
    					$image = $this->model_tool_image->resize($product_categoryid_info['image'], $setting['image_width'], $setting['image_height']);
    				} else {
    					$image = false;
    				}
    
    				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
    					$price = $this->currency->format($this->tax->calculate($product_categoryid_info['price'], $product_categoryid_info['tax_class_id'], $this->config->get('config_tax')));
    				} else {
    					$price = false;
    				}
    						
    				if ((float)$product_categoryid_info['special']) {
    					$special = $this->currency->format($this->tax->calculate($product_categoryid_info['special'], $product_categoryid_info['tax_class_id'], $this->config->get('config_tax')));
    				} else {
    					$special = false;
    				}
    				
    				if ($this->config->get('config_review_status')) {
    					$rating = $product_categoryid_info['rating'];
    				} else {
    					$rating = false;
    				}
    					
    				$this->data['products_categoryid_info'][] = array(
                        'category_product_id' => $categoryid_all_info,
    					'product_id' => $product_categoryid_info['product_id'],
    					'thumb'   	 => $image,
    					'name'    	 => $product_categoryid_info['name'],
    					'price'   	 => $price,
    					'special' 	 => $special,
    					'rating'     => $rating,
    					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_categoryid_info['reviews']),
    					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_categoryid_info['product_id'])
    				);
    			}
            }
  
         }
  

        
		foreach ($products as $product_id) {
			$product_info = $this->model_catalog_product->getProduct($product_id);
			
			if ($product_info) {
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = false;
				}

				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
						
				if ((float)$product_info['special']) {
					$special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = $product_info['rating'];
				} else {
					$rating = false;
				}
					
				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'   	 => $image,
					'name'    	 => $product_info['name'],
					'price'   	 => $price,
					'special' 	 => $special,
					'rating'     => $rating,
					'reviews'    => sprintf($this->language->get('text_reviews'), (int)$product_info['reviews']),
					'href'    	 => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/featured.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/featured.tpl';
		} else {
			$this->template = 'default/template/module/featured.tpl';
		}
        
		$this->render();
	}
}
?>