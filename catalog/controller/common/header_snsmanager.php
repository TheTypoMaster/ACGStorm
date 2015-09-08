<?php

class ControllerCommonHeaderSnsmanager extends Controller {

    protected function index() {
        $this->data['title'] = $this->document->getTitle();

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

        //$this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
        //$this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('order/order', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));
        //$this->data['home'] = $this->url->link('common/home');
        //$this->data['register'] = $this->url->link('account/register', '', 'SSL');
        //$this->data['login'] = $this->url->link('account/login', '', 'SSL');
        //$this->data['procurement'] = $this->url->link('procurement/procurement');
        //$this->data['selfshopping'] = $this->url->link('selfshopping/selfshopping');
        //$this->data['express'] = $this->url->link('international/express');
        //$this->data['freight'] = $this->url->link('international/freight');
        //$this->data['favorite'] = $this->url->link('product/favorite');
        //$this->data['newbie'] = $this->url->link('newbie/newbie');
        //$this->data['comments'] = $this->url->link('information/comments');
        //$this->data['freight'] =  $this->url->link('international/freight');
        //$this->data['populartools'] = $this->url->link('help/populartools');
        //$this->data['order'] = $this->url->link('order/order', '', 'SSL');
        //$this->data['help'] = $this->url->link('help/help');
        //$this->data['shopping_cart'] = $this->url->link('checkout/cart');
        //$this->data['student'] = $this->url->link('special/student');

        $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), HTTP_SERVER . 'account-login.html', HTTP_SERVER . 'account-register.html');
        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['home'] = HTTP_SERVER . 'common-home.html';
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
        //$this->data['social'] = $this->url->link('social/social');
        $this->data['social'] = HTTP_SERVER . 'social.html';
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
        foreach ($products as $product) {
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

            $total += $product['price'] * $product['quantity'];
        }
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

        // A dirty hack to try to set a cookie for the multi-store feature
        $this->load->model('setting/store');

        $this->data['stores'] = array();

        if ($this->config->get('config_shared') && $status) {
            $this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();

            $stores = $this->model_setting_store->getStores();

            foreach ($stores as $store) {
                $this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
            }
        }

        // Search		
        if (isset($this->request->get['search'])) {
            $this->data['search'] = $this->request->get['search'];
        } else {
            $this->data['search'] = '';
        }

        // Menu
        $this->load->model('catalog/category');

        $this->load->model('catalog/product');

        $this->data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            if ($category['top']) {
                // Level 2
                $children_data = array();

                $children = $this->model_catalog_category->getCategories($category['category_id']);

                foreach ($children as $child) {
                    $data = array(
                        'filter_category_id' => $child['category_id'],
                        'filter_sub_category' => true
                    );

                    $product_total = $this->model_catalog_product->getTotalProducts($data);

                    $children_data[] = array(
                        'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $product_total . ')' : ''),
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                    );
                }

                // Level 1
                $this->data['categories'][] = array(
                    'name' => $category['name'],
                    'children' => $children_data,
                    'column' => $category['column'] ? $category['column'] : 1,
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                );
            }
        }

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_snsmanager.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_snsmanager.tpl';
        } else {
            $this->template = 'default/template/common/header.tpl';
        }

        $this->render();
    }

}

?>