<?php

class ControllerCheckoutCart extends Controller {

    private $error = array();

    public function index() {

        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('checkout/cart');
            //$this->redirect($this->url->link('account/login', '', 'SSL')); //guanzhiqiang 20150520 未登录也可加入购物车，不跳到登录页
        }

        $this->language->load('checkout/cart');

        //shopping
        $this->data['favorite'] = $this->url->link('product/favorite');

        if ($this->cart->hasProducts() || isset($_COOKIE['cart_id'])) {

            $this->load->model('tool/image');

            $this->data['products'] = array();

            $products = $this->cart->getProducts();//获取商品 guanzhiqiang 

            //获取购物车中所有商品总数
            $cart_count = $this->cart->countProducts();

            $this->data['cart_count'] = $cart_count;

            //获取购物车中所有商品所属店铺名称
            $storenamearray = array();

            foreach ($products as $product) {
                
                $storenamearray[$product['storeurl']]['storename'] = $product['storename'];
                $storenamearray[$product['storeurl']]['storeurl'] = $product['storeurl'];
               // $storenamearray[$product['storeurl']]['from'] = $product['from'];
                
                if(isset($product['from'])){
                    if($product['from']=="mall"){
                         $storenamearray[$product['storeurl']]['storename'] = "CNstorm商城";
                         $storenamearray[$product['storeurl']]['storeurl'] = "product-mall.html";
                    }
                }
                
                //$storenamearray = array_unique($storenamearray);
            }


            $this->data['storenamearray'] = $storenamearray;

            foreach ($products as $product) {
                $product_total = 0;

                foreach ($products as $product_2) {
                    if ($product_2['product_id'] == $product['product_id']) {
                        $product_total += $product_2['quantity'];
                    }
                }
                //判断最小商品数大于商品总数
                if ($product['minimum'] > $product_total) {
                    $this->data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
                }

                if ($product['image']) {
                   // $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
                    $image = $this->model_tool_image->resize($product['image'], 240, 240);//图片大小 82*82 240*240 guanzhiqiang 20150626
                    if (!$image)
                        $image = $product['image'];
                } else {
                    $image = '';
                }

                //最新订单
                $this->load->model('order/order');
                $order_product_info = $this->model_order_order->getNewProductInfo(5);
                $this->data['orders'] = $order_product_info;

                // Display prices
                if (isset($product['price']) && $product['price']) {

                    $price = $product['price'];
                } else {

                    $price = 0.00;
                }

                // Display prices
                if (isset($product['price']) && $product['price'] && isset($product['quantity']) && $product['quantity']) {

                    $total = round($product['price'] * $product['quantity'], 2);
                } else {

                    $total = 0.00;
                }


                $size = '';

                if (array_key_exists('size', $product) && $product['size']) {
                    $size = $product['size'];
                }

                $color = '';

                if (array_key_exists('color', $product) && $product['color']) {
                    $color = $product['color'];
                }

                $storename = '';
                if (array_key_exists('storename', $product) && $product['storename']) {
                    $storename = $product['storename'];
                }

                $storeurl = '';
                if (array_key_exists('storeurl', $product) && $product['storeurl']) {
                    $storeurl = $product['storeurl'];
                }

                $yunfei = '';
                if (array_key_exists('yunfei', $product) && $product['yunfei']) {
                    $yunfei = $product['yunfei'];
                }
                $note = '';
                if (array_key_exists('note', $product) && $product['note']) {
                    $note = $product['note'];
                }

                $producturl = '';
                if (array_key_exists('location', $product) && $product['location']) {
                    $producturl = $product['location'];
                    if($product['order_status_buy']==4){//商城url伪装 guanzhiqiang 20150629
                        $producturl = HTTP_SERVER.$product['product_id'].".html";
                    }
                }
	
                if (array_key_exists('cart_id', $product) && $product['cart_id']) {
                    $cart_id = $product['cart_id'];
                    $cart_session_id = 0;
                }

                if (array_key_exists('cart_session_id', $product) && $product['cart_session_id']) {
                    $cart_session_id = $product['cart_session_id'];
                    $cart_id = 0;
                }
				if($product['order_status_buy']==5){
					 $this->load->model('cosplay/main');
					 $row=$this->model_cosplay_main->getCategory1($product['product_id']);
					 $key=$row->num_rows;
					 $rows=$row->rows[$key-1];
					 $producturl='/'.$rows['parent_id'].'_'.$rows['category_id'].'-cosplay.html&product_id='.$product['product_id'];
				}
                $this->data['products'][] = array(
                    'cart_id' => $cart_id,
                    'cart_session_id' => $cart_session_id,
                    'key' => $product['key'],
                    'thumb' => $image,
                    'name' => $product['name'],
                    'model' => $product['model'],
                    'quantity' => $product['quantity'],
                    'price' => $price,
                    'size' => $size,
                    'color' => $color,
                    'note' => $note,
                    'yunfei' => $yunfei,
                    'source' => $product['source'],
                    'producturl' => $producturl,
                    'total' => $total,
                    'storename' => $storename,
                    'storeurl' => $storeurl,
                        //'remove' => $this->url->link('checkout/cart', 'remove=' . $product['key']),
                );
            }

            $this->data['action'] = $this->url->link('checkout/confirm', '', 'SSL');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/cart.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/checkout/cart.tpl';
            } else {
                $this->template = 'default/template/checkout/cart.tpl';
            }

            $this->children = array(
                'common/footer',
                'common/header_cart'
            );

            $this->response->setOutput($this->render());
        } else {

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {

                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {

                $this->template = 'default/template/error/not_found.tpl';
            }

            $this->children = array(
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());
        }
    }

    public function add() {
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        $this->load->model('catalog/product');
        $product_info = $this->model_catalog_product->getProduct($product_id);
        //加入购物车的商品的数量
        if ($product_info) {
            if (isset($this->request->post['quantity'])) {
                $quantity = $this->request->post['quantity'];
            } else {
                $quantity = 1;
            }
            if (isset($this->request->post['hsize'])) {
                $searchsize = ($this->request->post['hsize']);
            } else {
                $searchsize = array();
            }
            if (isset($this->request->post['hcolor'])) {
                $searchcolor = ($this->request->post['hcolor']);
            } else {
                $searchcolor = 0;
            }
            if (isset($this->request->post['note'])) {
                $note = $this->request->post['note'];
            } else {
                $note = array();
            }
            //商品颜色
            $option = strip_tags($searchcolor);
            //商品尺寸
            $profile_id = strip_tags($searchsize);

            $this->cart->add($this->request->post['product_id'], $quantity, $option, $profile_id, $note);

            $this->response->setOutput(json_encode(1));
        }
    }

    public function addcosplay() {
        if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        } else {
            $product_id = 0;
        }
        $this->load->model('cosplay/main');
        $product_info = $this->model_cosplay_main->getProduct($product_id);
        //加入购物车的商品的数量
        if ($product_info) {
            if (isset($this->request->post['quantity'])) {
                $quantity = $this->request->post['quantity'];
            } else {
                $quantity = 1;
            }
            if (isset($this->request->post['hsize'])) {
                $searchsize = ($this->request->post['hsize']);
            } else {
                $searchsize = array();
            }
            if (isset($this->request->post['hcolor'])) {
                $searchcolor = ($this->request->post['hcolor']);
            } else {
                $searchcolor = 0;
            }
            if (isset($this->request->post['note'])) {
                $note = $this->request->post['note'];
            } else {
                $note = array();
            }
            //商品颜色
            $option = strip_tags($searchcolor);
            //商品尺寸
            $profile_id = strip_tags($searchsize);

            $cosplay_product_id = 'cosplay_' . $product_id;

            $this->cart->add($cosplay_product_id, $quantity, $option, $profile_id, $note);

            $this->response->setOutput(json_encode(1));
        }
    }

    /**     * ****************************************************************************************************
     * @funtion：定义函数addsearch()用于通过在搜索框中输入天猫或者淘宝的商品Url地址来查看商品详情，添加进购物车

     * @param：   string $num_iid  参数为该单件商品的数字id

     * @param:    string $quantity 参数为将该单价商品放入购物车的数量

     * @return：  json  $json  成功时返回成功提醒语句，商品数量和价格

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.5.20
     * ********************************************************************************************************* */
    public function addsearch() {

        $this->load->model('checkout/cart');


        if (isset($this->request->post['num_iid'])) {
            $num_iid = $this->request->post['num_iid'];
        } else {
            $num_iid = 0;
        }


        if (isset($this->request->post['search_url_value'])) {
            $product_url = $this->request->post['search_url_value'];
        } else {
            $product_url = '';
        }


        if (isset($this->request->post['product_name'])) {
            $product_name = $this->request->post['product_name'];
        } else {
            $product_name = '';
        }

        if (isset($this->request->post['store_name'])) {
            $store_name = $this->request->post['store_name'];
        } else {
            $store_name = '';
        }

        if (isset($this->request->post['store_url'])) {
            $store_url = $this->request->post['store_url'];
        } else {
            $store_url = '';
        }

        if (isset($this->request->post['imgurl'])) {
            $imgurl = $this->request->post['imgurl'];
        } else {
            $imgurl = '';
        }


        if (isset($this->request->post['quantity'])) {
            $quantity = $this->request->post['quantity'];
        } else {
            $quantity = 1;
        }

        if (isset($this->request->post['sizename'])) {
            $searchsize = $this->request->post['sizename'];
        } else {
            $searchsize = '';
        }

        if (isset($this->request->post['colorname'])) {
            $searchcolor = $this->request->post['colorname'];
        } else {
            $searchcolor = 0;
        }

        if (isset($this->request->post['note'])) {
            $note = $this->request->post['note'];
        } else {
            $note = '';
        }

        if (isset($this->request->post['searchfreight'])) {
            $sfreight = $this->request->post['searchfreight'];
        } else {
            $sfreight = '';
        }

        if (isset($this->request->post['searchprice'])) {
            $sprice = $this->request->post['searchprice'];
        } else {
            $sprice = '';
        }
        if (isset($this->request->post['type'])) {
            $type = $this->request->post['type'];
        } else {
            $type = 0;
        }

        $data = array(
            'customer_id' => $this->customer->getId(),
            'firstname' => $this->customer->getFirstName(),
            'num_iid' => $num_iid,
            'product_name' => $product_name,
            'product_url' => $product_url,
            'store_name' => $store_name,
            'store_url' => $store_url,
            'color' => $searchcolor,
            'size' => $searchsize,
            'quantity' => $quantity,
            'note' => $note,
            'imgurl' => $imgurl,
            'price' => $sprice,
            'freight' => $sfreight,
            'type' => $type
        );

        $cart_id = $this->model_checkout_cart->addCart($data);

        $snatch_key = 'snatch_' . $cart_id;

        //商品颜色
        $option = $searchcolor;

        //商品尺寸
        $profile_id = $searchsize;

        if ($cart_id) {
//添加购物车，cookie session都加
            if ($this->customer->getId()) {

                $this->cart->addsearch($snatch_key, $quantity, $option, $profile_id, $note, $sfreight, $sprice);


                if (isset($_COOKIE['cart_id'])) {
                    if (!empty($_COOKIE['cart_id'])) {

                        $temp = $_COOKIE['cart_id'];

                        setcookie('cart_id', $temp . ",$cart_id");
                    }
                } else {

                    setcookie('cart_id', $cart_id);
                }
            } else {

                $this->cart->addsearch($snatch_key, $quantity, $option, $profile_id, $note, $sfreight, $sprice); //guanzhiqiang 20150520 未登录时添加至购物车保存到SESSION cart

                if (isset($_COOKIE['cart_id'])) {
                    if (!empty($_COOKIE['cart_id'])) {

                        $temp = $_COOKIE['cart_id'];

                        setcookie('cart_id', $temp . ",$cart_id");
                    }
                } else {

                    setcookie('cart_id', $cart_id);
                }
            }

            $this->response->setOutput(json_encode($cart_id));
        }
    }

//有调用此函数的地方请改成调用下面cart_update函数并传入相关参数
    public function updateQty() {

        if (!empty($this->request->post["quantity"]) && !empty($this->request->post["id"])) {
            $snatch = strstr($this->request->post["id"], 'snatch');
            $key = $this->request->post["id"];
            $value = $this->request->post["quantity"];
            if (empty($snatch)) {
                $this->cart->update($key, $value);
            } else {
                $cart_id = explode('_', $key);
                $cart_id = $cart_id[1];
                $data = array(
                    'quantity' => $value,
                    'cart_id' => $cart_id
                );
                $this->load->model('checkout/cart');
                $this->model_checkout_cart->updatesnatch($data);
            }
        } else {

            echo "fuck me";
        }
    }

    /**     * ****************************************************************************************************
     * @funtion：定义函数delcart() 用于删除购物车中的选中商品

     * @author：  kennewei<wk@cnstorm.com>

     * @date:     2014.7.25
     * ********************************************************************************************************* */
    //有调用此函数的地方请改成调用下面cart_delete函数并传入相关参数
    public function remove() {

        if (isset($this->request->get['remove'])) {

            $result = $this->cart->remove($this->request->get['remove']);

            $this->response->setOutput(json_encode($result));
        }
    }

//从购物车中删除商品
    public function cart_delete() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            //$customerId = $this->request->post['customerId'];
            $customerId = (int) $this->customer->getId();
            $productId = $this->request->post['productId'];
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
                $this->cart->remove($key); //清理session


                if (strstr($key, 'snatch')) {
                    $key_info = explode('_', $key);
                    $id = $key_info[1];
                    if ($id) {
                        
                        /* 清理cookie  guanzhiqiang 20150525 */
                        if (!empty($_COOKIE['cart_id'])) {
                            $cart_id_array = explode(",", $_COOKIE['cart_id']);
                            foreach ($cart_id_array as $key => $val) {
                             
                                if ($id == $val) {
                                    unset($cart_id_array[$key]);
                                    break;
                                }
                            }
                            $cart_ids = "";
                            if (!empty($cart_id_array)) {
                                $cart_ids = implode(",", $cart_id_array);
                            }
                            setcookie('cart_id', $cart_ids);
                        }

                        if (!empty($customerId)) {
                            $this->load->model('checkout/cart');
                            $this->model_checkout_cart->delCartbyId($id);
                        }
                    }
                }
                if (!empty($customerId)) {
                    $this->load->model('app/user');
                    $this->model_app_user->updateCart($customerId);
                }
                $arr = json_encode(1);
                echo($arr);
            } else {
                $arr = json_encode(0);
                echo($arr);
            }
        } else {
            $arr = json_encode(0);
            echo($arr);
        }
    }

    public function delcart() {
        if (isset($this->request->post['wanna_buy']) && $this->request->post['wanna_buy']) {
            $key_info = $this->request->post['wanna_buy'];

            $key = explode('#', $key_info);
            
            /* 清理cookie  guanzhiqiang 20150525 */
            $cart_id_array = array();
            if (!empty($_COOKIE['cart_id'])) {
                $cart_id_array = explode(",", $_COOKIE['cart_id']);
            }

            foreach ($key as $key_signal) {
                if ($key_signal) {
                    if (strstr($key_signal, 'snatch')) {
                        $signal_key_info = explode('_', $key_signal);
                        $id = $signal_key_info[1];

                        if ($id) {

                            /* 清理cookie  guanzhiqiang 20150525 */
                            if (!empty($_COOKIE['cart_id'])) {
                                foreach ($cart_id_array as $key => $val) {
                                    if ($id == $val) {
                                        unset($cart_id_array[$key]);
                                        break;
                                    }
                                }
                            }

                            if ($this->customer->getId()) {
                                $this->load->model('checkout/cart');
                                $this->model_checkout_cart->delCartbyId($id);
                            }
                        }

                        $this->cart->remove($key_signal);
                    } else {
                        $this->cart->remove($key_signal);
                    }
                }
            }

            $cart_ids = "";
            if (!empty($cart_id_array)) {
                $cart_ids = implode(",", $cart_id_array);
            }
            setcookie('cart_id', $cart_ids);

            $this->response->setOutput(json_encode(1));
        }
    }

//修改购物车数量/备注
    public function cart_update() {
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $customerId = $this->request->post['customerId'];
            $productId = $this->request->post['productId'];
            $quantity = $this->request->post['number'] ? $this->request->post['number'] : 1;
            $remark = $this->request->post['content'] ? $this->request->post['content'] : '';
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
                if (strstr($key, 'snatch')) {
                    $key_info = explode('_', $key);
                    $id = $key_info[1];
                    //更新购物车中订单数量或者
                    if ($id) {
                        $data = array(
                            'cart_id' => $id,
                            'quantity' => $value,
                            'note' => $value2
                        );

                        $this->load->model('app/user');
                        $this->model_app_user->updatesnatch($data);
                    }
                } else {
                    if (!empty($value))
                        $this->cart->update($key, $value);
                    $this->cart->updateRemark($key, $value2);
                }

                $this->load->model('app/user');
                $this->model_app_user->updateCart($customerId);
                $arr = json_encode(1);
                echo($arr);
            } else {
                $arr = json_encode(0);
                echo($arr);
            }
        } else {
            $arr = json_encode(0);
            echo($arr);
        }
    }

}

?>