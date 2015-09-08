<?php

class ControllerCommonHeaderCart extends Controller {

    protected function index() {

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

        $this->data['base'] = $server;
        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        $this->data['name'] = $this->config->get('config_name');

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        $this->language->load('common/header');

        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_checkout'] = $this->language->get('text_checkout');

        $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), HTTP_SERVER . 'account-login.html', HTTP_SERVER . 'account-register.html');
        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['home'] = HTTP_SERVER;
        $this->data['register'] = HTTP_SERVER . 'account-register.html';
        $this->data['login'] = HTTP_SERVER . 'account-login.html';
        //add by weikun
        $this->data['procurement'] = HTTP_SERVER . 'procurement.html';
        $this->data['selfshopping'] = HTTP_SERVER . 'selfshopping.html';
        $this->data['express'] = HTTP_SERVER . 'international-express.html';
        $this->data['freight'] = HTTP_SERVER . 'international-freight.html';
        $this->data['favorite'] = HTTP_SERVER . 'product-favorite.html';
        $this->data['newbie'] = HTTP_SERVER . 'newbie.html';
        $this->data['comments'] = HTTP_SERVER . 'information-comments.html';
        $this->data['freight'] = HTTP_SERVER . 'international-freight.html';
        $this->data['populartools'] = HTTP_SERVER . 'help-populartools.html';
        $this->data['order'] = HTTP_SERVER . 'order.html';
        $this->data['help'] = HTTP_SERVER . 'help.html';
        $this->data['shopping_cart'] = HTTP_SERVER . 'checkout-cart.html';
        $this->data['student'] = HTTP_SERVER . 'special-student.html';
        $this->data['social'] = $this->url->link('social/social');
        $this->data['customer_id'] = $this->customer->getId();
        $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        //end
        $this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['account'] = $this->url->link('order/order', '', 'SSL');
        $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        // minicart 迷你购物车中是否有商品
        $flag = $this->cart->hasProducts();
        $this->data['flag'] = $flag;
        // minicart 迷你购物车商品信息和商品价格总和(不包含运费)
        $this->data['products'] = array();

        $this->load->model('tool/image');
        $products = $this->cart->getProducts();
        //minicart 迷你购物车商品数量
        $count = $this->cart->countProducts();
        $this->data['count'] = $count;

        $total = 0;
         //dump($products);
		 //只取4条
		 $counter=0;
        foreach ($products as $key=>$product) {
		
		if( $counter < 3){
            //image
            if ($product['image']) {
                $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                if (!$image)
                    $image = $product['image'];
            } else {
                $image = '';
            }

            $this->data['products'][] = array(
                'thumb' => $image,
                'name' => $product['name'],
                'quantity' => $product['quantity'],
                'price' => $product['price']
            );
			$counter++;
		}
          //  $total += $product['price'] * $product['quantity'];
			
        }
		$this->data['surplus'] =   $count - 3 > 0 ?$count - 3:0 ;
        //var_dump($this->data['products']);
        $this->data['totalprice'] = $total;
		
        // Daniel's robot detector
        $status = true;

        if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $robots = explode("\n", trim($this->config->get('config_robots')));

            foreach ($robots as $robot) {
                if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
                    $status = false;

                    break;
                }
            }
        }

        // Search		
        if (isset($this->request->get['search'])) {
            $this->data['search'] = $this->request->get['search'];
        } else {
            $this->data['search'] = '';
        }

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_cart.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_cart.tpl';
        } else {
            $this->template = 'default/template/common/header_cart.tpl';
        }

        $this->render();
    }

    public function getProducts() {
        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (isset($this->session->data['error']) && !empty($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

        $this->data['base'] = $server;
        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        $this->data['name'] = $this->config->get('config_name');

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . 'image/' . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        $this->language->load('common/header');

        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_checkout'] = $this->language->get('text_checkout');

        $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), HTTP_SERVER . 'account-login.html', HTTP_SERVER . 'account-register.html');
        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['home'] = HTTP_SERVER;
        $this->data['register'] = HTTP_SERVER . 'account-register.html';
        $this->data['login'] = HTTP_SERVER . 'account-login.html';
        //add by weikun
        $this->data['procurement'] = HTTP_SERVER . 'procurement.html';
        $this->data['selfshopping'] = HTTP_SERVER . 'selfshopping.html';
        $this->data['express'] = HTTP_SERVER . 'international-express.html';
        $this->data['freight'] = HTTP_SERVER . 'international-freight.html';
        $this->data['favorite'] = HTTP_SERVER . 'product-favorite.html';
        $this->data['newbie'] = HTTP_SERVER . 'newbie.html';
        $this->data['comments'] = HTTP_SERVER . 'information-comments.html';
        $this->data['freight'] = HTTP_SERVER . 'international-freight.html';
        $this->data['populartools'] = HTTP_SERVER . 'help-populartools.html';
        $this->data['order'] = HTTP_SERVER . 'order.html';
        $this->data['help'] = HTTP_SERVER . 'help.html';
        $this->data['shopping_cart'] = HTTP_SERVER . 'checkout-cart.html';
        $this->data['student'] = HTTP_SERVER . 'special-student.html';
        $this->data['social'] = $this->url->link('social/social');
        $this->data['customer_id'] = $this->customer->getId();
        $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        //end
        $this->data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['account'] = $this->url->link('order/order', '', 'SSL');
        $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        // minicart 迷你购物车中是否有商品
        $flag = $this->cart->hasProducts();
        $this->data['flag'] = $flag;
        // minicart 迷你购物车商品信息和商品价格总和(不包含运费)
        $this->data['products'] = array();

        $this->load->model('tool/image');
        $products = $this->cart->getProducts();
        //minicart 迷你购物车商品数量
        $count = $this->cart->countProducts();
        $this->data['count'] = $count;

        $total = 0;
	//只取最后添加的3个产品
	$counter=0;
        foreach ($products as $product) {
		if($counter<3){
				//image
				if ($product['image']) {
					$image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
					if (!$image)
						$image = $product['image'];
				} else {
					$image = '';
				}

				$this->data['products'][] = array(
					'thumb' => $image,
					'name' => $product['name'],
					'quantity' => $product['quantity'],
					'price' => $product['price']
				);

				//$total += $product['price'] * $product['quantity'];
				$counter++;
			}
        }
		
		$this->data['surplus']= $count-3 >0?$count-3:0;
   
        $this->data['totalprice'] = $total;



        // Daniel's robot detector
        $status = true;

        if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $robots = explode("\n", trim($this->config->get('config_robots')));

            foreach ($robots as $robot) {
                if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
                    $status = false;

                    break;
                }
            }
        }

        // Search		
        if (isset($this->request->get['search'])) {
            $this->data['search'] = $this->request->get['search'];
        } else {
            $this->data['search'] = '';
        }



        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/cart_list.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/cart_list.tpl';
        } else {
            $this->template = 'default/template/common/cart_list.tpl';
        }
		
        echo json_encode(array(
            "cartlist" =>$this->render(),
            "count" => $count
        ));
		
    }

}

?>