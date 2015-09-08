<?php

class ControllerSalePlaceorder extends Controller {

    private $error = array();

    public function index() {

        $this->document->setTitle("代下单");

        $this->data['token'] = $this->session->data['token'];

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => '代下单',
            'href' => $this->url->link('sale/placeorder', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->load->model('sale/order');
        $this->data['expresses'] = $this->model_sale_order->express();

        $this->template = 'sale/placeorder.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    function getParam($str) {
        return isset($this->request->post[$str]) ? $this->request->post[$str] : '';
    }

    public function order() {
        $success = '下单成功！';
        $error   = '下单失败，请重试！';
        $type = $this->getParam('type');
        $receiver_id = $this->getParam('receiver_id');
        if ($receiver_id != '') {
            $this->load->model('sale/order');
            if ($type == 1 || $type == 2) {//代购 or 自助购
                $products = $this->getParam('products');
                if ($products != '-|--|--|--|--|--|-' && $products != '') {
                    $reg = '/^http:\/\//';

                    $receiver               = $this->getParam('receiver');
                    $data['storename']      = $this->getParam('storename');
                    $storeurl               = $this->getParam('storeurl');
                    $data['storeurl']       = preg_match($reg, $storeurl) ? $storeurl : 'http://' . $storeurl;
                    $freight                = $this->getParam('freight');
                    $model                  = $this->getParam('model');
                    $img                    = '/uploads/big/0b4a96400b2372d25da769647bfe4059.jpg';
                    $data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
                    $data['store_id']       = $this->config->get('config_store_id');
                    $data['customer_id']    = $receiver_id;

                    $customer = $this->model_sale_order->getCustomer($receiver_id);
                    if (!$customer) {
                        echo json_encode('haha');
                        exit;
                    }

                    $data['customer_group_id'] = isset($customer['customer_group_id']) ? $customer['customer_group_id'] : 1;
                    $data['firstname']         = $customer['firstname'];
                    $data['lastname']          = isset($customer['lastname']) ? $customer['lastname'] : '';
                    $data['email']             = isset($customer['email']) ? $customer['email'] : '';
                    $data['telephone']         = isset($customer['telephone']) ? $customer['telephone'] : '';

                    $product_data = array();
                    $sub_total = array();

                    $productsArr = explode('=|=', $products);
                    // 每件商品属性的顺序
                    // 0 productname，1 url，2 price，3 quantity，4 color，5 size，6 remark
                    foreach ($productsArr as $product) {
                        $productArr = explode('-|-', $product);

                        //商品总额
                        $sub_total[] = $productArr[2] * $productArr[3];

                        $product_data[] = array(
                            'product_id' => '',
                            'name'       => $productArr[0],
                            'producturl' => preg_match($reg, $productArr[1]) ? $productArr[1] : 'http://' . $productArr[1],
                            'price'      => $productArr[2],
                            'quantity'   => $productArr[3],
                            'color'      => $productArr[4],
                            'size'       => $productArr[5],
                            'note'       => $productArr[6],//备注
                            'total'      => $type == 1 ? $productArr[2] * $productArr[3] : 0.00,//总价
                            'model'      => $model,//商品来源
                            'img'        => $img,
                            'source'     => 0
                            );
                    }

                    if ($type == 1) {
                        $data['order_shipping'] = $freight;
                        $data['total'] = array_sum($sub_total) + $freight;

                        //订单购买状态，默认 1:代购 2:自助   3:代寄
                        $data['order_status_buy'] = 1;
                        //订单状态, 1 未付款 2 已付款
                        $data['order_status_id'] = 1;
                    } elseif ($type == 2) {
                        $data['order_shipping'] = '';
                        $data['total'] = '';

                        //订单购买状态，默认 1:代购 2:自助   3:代寄
                        $data['order_status_buy'] = 2;
                        //订单状态, 3 待发货
                        $data['order_status_id'] = 3;
                    }
                    
                    $data['products'] = $product_data;

                    $data['ip'] = $this->request->server['REMOTE_ADDR'];

                    if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                        $data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                    } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                        $data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                    } else {
                        $data['forwarded_ip'] = '';
                    }

                    if (isset($this->request->server['HTTP_USER_AGENT'])) {
                        $data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                    } else {
                        $data['user_agent'] = '';
                    }

                    if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                        $data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                    } else {
                        $data['accept_language'] = '';
                    }

                    $order_id = $this->model_sale_order->addOrder($data);
                    if ($order_id)
                        echo json_encode($success);
                    else 
                        echo json_encode($error);
                } else {
                    echo json_encode($error);
                }
            } elseif ($type == 3) {//代寄
                $express_number = $this->getParam('express_number');
                if ($express_number == "") {
                    $order_status_id = "3";
                } else {
                    $order_status_id = "4";
                }
                $order_daiji_name = $this->getParam('order_daiji_name');
                $expresses        = $this->getParam('expresses');
                $order_Parcel     = $this->getParam('order_Parcel');
                $data = array(
                    'username_id' => $receiver_id,
                    'order_status_id' => $order_status_id,
                    'order_status_buy' => 3,
                    'order_Parcel' => $order_Parcel,
                    'expresses' => $expresses,
                    'order_daiji_name' => $order_daiji_name,
                    'express_number' => $express_number
                    );
                $this->model_sale_order->insert_daiji_order($data);
                echo json_encode($success);
            } else {
                echo json_encode($error);
            }
        } else {
            echo json_encode($error);
        }
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sale/customer');

            $data = array(
                'filter_name' => $this->request->get['filter_name']
            );

            $results = $this->model_sale_customer->getCustomersByName($data);

            foreach ($results as $result) {
                $json[] = array(
                    'receiver_id' => $result['customer_id'], 
                    'receiver'    => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
                );
            }       
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['receiver'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->setOutput(json_encode($json));
    }

}

?>