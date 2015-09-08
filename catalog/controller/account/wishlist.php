<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/wishlist');

		$this->load->model('catalog/product');
        
        $this->load->model('cosplay/main');

		$this->load->model('tool/image');

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->get['remove'])) {
		  
            $remove_key = $this->request->get['remove'];
                
            $key = array_search($remove_key, $this->session->data['wishlist']);
           
            if($key !== false) {
                
                unset($this->session->data['wishlist'][$key]);
            }
            
			$this->session->data['success'] = $this->language->get('text_remove');

			$this->redirect($this->url->link('account/wishlist'));
		}

		$this->document->setTitle($this->language->get('heading_title'));	

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/wishlist'),
			'separator' => $this->language->get('text_separator')
		);

		$this->data['heading_title'] = $this->language->get('heading_title');	

		$this->data['text_empty'] = $this->language->get('text_empty');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_stock'] = $this->language->get('column_stock');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_cart'] = $this->language->get('button_cart');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['products'] = array();
        
        //var_dump($this->session->data['wishlist']);
        
		foreach ($this->session->data['wishlist'] as $key => $product_id) {
		     
            
           if(strstr($product_id,'cosplay')) {
            
                $product_id = explode('_',$product_id);
            
                $id = $product_id[1];
            
                $product_info =  $this->model_cosplay_main->getProduct($id);
                
                if($product_info) {
                    
                    $products_href = $this->url->link('cosplay/product', 'product_id=' . $product_info['product_id']);
                    
                    $addCart = $this->url->link('cosplay/product', 'product_id=' . $product_info['product_id']);
                    
                    $remove_href = $this->url->link('account/wishlist', 'remove=cosplay_' . $product_info['product_id']);      
                }
                
            }elseif(strstr($product_id,'snatch')) {
                
                $product_id = explode('_',$product_id);
            
                $id = $product_id[1];
                
                $product_info = $this->cart->getProductCart($id);
                
                if($product_info) {
                    
                    $products_href = $product_info['location'];;
                    
                    $addCart = $this->url->link('product/snatch', 'search=' . urlencode(str_replace('&amp;','&',$product_info['location'])));
                    
                    $remove_href = $this->url->link('account/wishlist', 'remove=snatch_' . $id);    
                }
                
            }elseif($this->model_catalog_product->getProduct($product_id)) {
                
                $product_info = $this->model_catalog_product->getProduct($product_id);
                
                if($product_info) {
                    
                    $products_href = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
                    
                    $addCart = $this->url->link('product/product', 'product_id=' . $product_info['product_id']);
                    
                    $remove_href = $this->url->link('account/wishlist', 'remove=' . $product_info['product_id']);      
                }
               
            }else{
                
                $product_info = '';
                
            }
            
			//file_put_contents("1.log", var_export($product_info,true)."\r\n",FILE_APPEND);
            
			if (!empty($product_info)) {
			 
				if ($product_info['image']) {
					$image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'))?$this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height')):$product_info['image'];
                                        //file_put_contents("1.log", var_export($image,true)."\r\n",FILE_APPEND);
				} else {
					$image = false;
				}
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

				$this->data['products'][] = array(
					'product_id' => $product_info['product_id'],
					'thumb'      => $image,
					'name'       => $product_info['name'],
					'model'      => $product_info['model'],
					'stock'      => $stock,
					'price'      => $price,		
					'special'    => $special,
					'href'       => $products_href,
                    'addCart'    => $addCart,
					'remove'     => $remove_href
				);
			} else {
				unset($this->session->data['wishlist'][$key]);
			}
		}	

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/wishlist.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/wishlist.tpl';
		} else {
			$this->template = 'default/template/account/wishlist.tpl';
		}

		$this->children = array(
			'common/uc_business',
			'common/footer',
			'common/header_cart'	
		);

		$this->response->setOutput($this->render());		
	}

	public function add() {
	   
		$this->language->load('account/wishlist');

		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}

		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}

		$this->load->model('catalog/product');
        
        $this->load->model('cosplay/main');
        
        if(strstr($product_id,'cosplay')) {
            
            $product_id = explode('_',$product_id);
            
            $id = $product_id[1];
            
            $product_info =  $this->model_cosplay_main->getProduct($id);
            
        }elseif(strstr($product_id,'snatch')) {
            
            $product_id = explode('_',$product_id);
            
            $id = $product_id[1];
            
            $product_info = $this->cart->getProductCart($id);
            
        }elseif($this->model_catalog_product->getProduct($product_id)) {
            
            $product_info = $this->model_catalog_product->getProduct($product_id);
            
        }else{
            
            $product_info = '';
            
        }
        

		if (!empty($product_info)) {
		  
			if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {	
				$this->session->data['wishlist'][] = $this->request->post['product_id'];
			}

			if ($this->customer->isLogged()) {			
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			} else {
				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			}

			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}	

		$this->response->setOutput(json_encode($json));
	}	
}
?>
