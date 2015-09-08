<?php

/**
 * @description：手机接口一些小功能部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-19
 */
Class ControllerAppApp extends Controller {

    //意见反馈
    public function advisory_add() {
        $this->language->load('app/app');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $str = str_replace("&quot;", "\"", $this->request->post['param']);
            $param = json_decode($str, true);
            $customerId = $param['customerId'];
            $msg = $param['msg'];

            $this->load->model('account/customer');
            $customer = $this->model_account_customer->getCustomer($customerId);

            if ($customer) {
                $data = array(
                    'uid' => $customer['customer_id'],
                    'uname' => $customer['firstname'],
                    'state' => 0,
                    'msg' => $msg,
                    'addtime' => time(),
                    'reply' => 0,
                    'type' => 5
                );

                $this->load->model('account/guestbook');
                $this->model_account_guestbook->addGuestbook($data);

                $arr = json_encode(array('data' => array('resultCode' => 1)));
                echo($arr);
            } else {
                $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
                echo($arr);
            }
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
            echo($arr);
        }
    }

    //查询意见反馈
    public function advisory_list() {
        $this->language->load('app/app');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $str = str_replace("&quot;", "\"", $this->request->post['param']);
            $param = json_decode($str, true);
            $customerId = $param['customerId'];
            $page = $param['value'];

            $limit = $this->config->get('config_catalog_limit');
            $data = array(
                'customerId' => $customerId,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $this->load->model('app/account');
            $guestbooks = $this->model_app_account->getGuestbooks($data);

            $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $guestbooks)));
            echo($arr);
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
            echo($arr);
        }
    }

    //查询汇率
    public function currency_rate() {

        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $param = json_decode(str_replace("&quot;", "\"", $this->request->post['param']), true);
            //$param = "{\"fromCurrency\":\"CNY\",\"toCurrency\":\"USD\",\"amount\":1}";
            //$param = json_decode(str_replace("&quot;", "\"", $param), true);
            $ch = curl_init();
            $url = "http://apis.baidu.com/apistore/currencyservice/currency?fromCurrency={$param['fromCurrency']}&toCurrency={$param['toCurrency']}&amount={$param['amount']}";
            $header = array(
                'apikey:5fb5abba3684ebc1203e118d8b828701',
            );
            // 添加apikey到header
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // 执行HTTP请求
            curl_setopt($ch, CURLOPT_URL, $url);
            $res = curl_exec($ch);
            $result = json_decode($res, true);
            if (!empty($result)) {
                if (array_key_exists('retData', $result)) {
                    $arr = json_encode(array('data' => array('resultCode' => 0, 'result' => $result['retData'])));
                } else {
                    $arr = json_encode(array('data' => array('resultCode' => 1, 'errorMessage' => "查询失败")));
                }
            } else {
                $arr = json_encode(array('data' => array('resultCode' => 2, 'errorMessage' => "请求失败")));
            }
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 3, 'errorMessage' => $this->language->get('error_post'))));
        }
        echo $arr;
    }

    public function getCountry() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "country");
        echo json_encode($query->rows);
    }

    //费用估算
    public function cost_estimate() {
        $this->language->load('app/app');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $str = str_replace("&quot;", "\"", $this->request->post['param']);
            $param = json_decode($str, true);
            $area_id = $param['areaId'];
            $weight = $param['weight'];

            $this->load->model('guoji/guoji');
            $expresses = $this->model_guoji_guoji->get_express($area_id);
            if ($expresses) {
                foreach ($expresses as $express) {
                    $first_weight = $express['first_weight'];
                    $continue_weight = $express['continue_weight'];
                    $first_fee = $express['first_fee'];
                    $continue_fee = $express['continue_fee'];

                    if ($weight <= $first_weight) {
                        $freight = $express['first_fee'];
                    } else {
                        $freight = $express['first_fee'] + ceil(($weight - $first_weight) / $continue_weight) * $continue_fee;
                    }
                   // $servefee = round($freight * 0.038, 2);
					$servefee =0;
                    $result[] = array(
                        'deliveryName' => $express['deliveryname'],
                        'deliveryTime' => $express['delivery_time'],
                        'carrierLogo' => $express['carrierLogo'] ? $express['carrierLogo'] : '',
                        'freight' => $freight,
                        'servefee' => $servefee,
                        'customsFee' => $express['customs_fee'],
                        'total' => round($freight + $servefee + 8, 2)
                    );
                }
            } else {
                $result = array();
            }
            $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
            echo($arr);
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
            echo($arr);
        }
    }

    //运单评价列表
    public function comments_list() {
        $this->language->load('app/app');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $str = str_replace("&quot;", "\"", $this->request->post['param']);
            $param = json_decode($str, true);
            $page = $param['value'];
            $sort = '';
            $order = '';
            if (array_key_exists('sort', $param))
                $sort = $param['sort'];
            if (array_key_exists('order', $param))
                $order = $param['order'];
            $limit = $this->config->get('config_catalog_limit');

            $data = array(
                'sort' => $sort,
                'order' => $order,
                'start' => ($page - 1) * $limit,
                'limit' => $limit
            );

            $this->load->model('order/sendorder');
            $comments = $this->model_order_sendorder->getComments($data);

            $result = array();
            $reg = '/^http:\/\//';
            foreach ($comments as $comment) {
                $result[] = array(
                    'face' => preg_match($reg, $comment['face']) ? $comment['face'] : 'http://' . $this->request->server['HTTP_HOST'] . '/' . $comment['face'],
                    'uname' => $comment['uname'],
                    'country' => $comment['country'],
                    'reply' => $comment['reply'] ? $comment['reply'] : '满意的话下次要继续使用CNstorm哦！O(∩_∩)O~',
                    'utype' => $comment['utype'],
                    'comment' => $comment['comment']
                );
            }

            $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
            echo($arr);
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
            echo($arr);
        }
    }

    //网站底部评价列表，目前是写死的
    public function evaluate_list() {
        $result['evaluationList'] = array(
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/xiaoxin_oct.jpg',
                'nickName' => 'xiaoxin_oct',
                'memberGrade' => '白金会员',
                'country' => '美国',
                'content' => '货都收到了，哈哈，衣服都超爱的，谢谢你们啦！ 而已真的也就几天到了！只是寄到我家来，结果没等到快递，跑到邮局拿，重死了！'
            ),
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/user2.jpg',
                'nickName' => 'aicas',
                'memberGrade' => '白金会员',
                'country' => '加拿大',
                'content' => '速度实在太快了，包裹包的也很好很完美，物品没有丝毫损坏！实在忍不住赞一个！认定你们这家了哦~~~~！'
            ),
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/user3.jpg',
                'nickName' => 'Lydia.yang',
                'memberGrade' => '白金会员',
                'country' => '美国',
                'content' => '非常好~速度比想象的快多了，挺开心的~谢谢CN全体服务人员的工作效率和工作态度~'
            )
        );
        // var_dump($result);
        $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
        echo($arr);
    }

    //大家最爱处的轮播图片，目前也是写死的
    public function luobo_list() {
        $result = array(
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/banner_login.jpg',
				'id'=>11111
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=product/types&path=59_64'
            ),
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/student_vefity.jpg',
				'id'=>22222
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=product/types&path=59_93'
            ),
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/banner_buy.jpg',
				'id'=>33333
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=special/overseas'
            ),
            array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/favorite_banner_4.jpg',
				'id'=>44444
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=special/stylestreet'
            ),
           array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/favorite_banner_3.jpg',
				'id'=>55555
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=special/stylestreet'
            ),
           array(
                'imageUrl' => 'http://' . $this->request->server['HTTP_HOST'] . '/catalog/view/theme/cnstorm/images/banner_class.jpg',
				'id'=>66666
            // 'href' => 'http://' . $this->request->server['HTTP_HOST'] . '/index.php?route=special/stylestreet'
            )
        );
        $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
        echo($arr);
    }

    //版本控制
    public function version() {
        $this->language->load('app/app');
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $str = str_replace("&quot;", "\"", $this->request->post['param']);
            $param = json_decode($str, true);
            $type = array_key_exists('type', $param) ? $param['type'] : '';

            if ($type) {
                //type=1iPhone、2iPad、3Android
                $this->load->model('app/user');
                $result = $this->model_app_user->getVersion($type);

                $arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
                echo($arr);
            } else {
                $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notfound'))));
            }
        } else {
            $arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
            echo($arr);
        }
    }

}
