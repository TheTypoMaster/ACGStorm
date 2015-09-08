<?php

class ControllerAccountLogin extends Controller {

    private $error = array();

    public function index() {

        //语言转换
        if (isset($this->session->data['language'])) {
            $this->data['status'] = $this->session->data['language'];
            $this->data['curUrl'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            if (isset($this->request->get['l'])) {
                if ($this->session->data['language'] == 'cn') {
                    $this->session->data['language'] = 'en';
                    $this->data['status'] = $this->session->data['language'];
                    if (isset($_SERVER['HTTP_REFERER']))
                        $this->redirect($_SERVER['HTTP_REFERER']);
                }else {
                    $this->session->data['language'] = 'cn';
                    $this->data['status'] = $this->session->data['language'];
                    if (isset($_SERVER['HTTP_REFERER']))
                        $this->redirect($_SERVER['HTTP_REFERER']);
                }
            }
        }
        $this->data['error_login'] = "";
        $this->load->model('account/customer');
        if ($this->customer->isLogged()) {
            if (isset($this->request->post['login_social'])) {
                $this->redirect($this->url->link('social/social', '', 'SSL'));
            } else {

                $this->redirect($this->url->link('order/order', '', 'SSL'));
            }
        }

        //模版赋值
        $this->language->load('account/login');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));

        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();

        $this->data['text_fashionPlate'] = $this->language->get('text_fashionPlate');
        $this->data['text_traditional'] = $this->language->get('text_traditional');
        $this->data['text_background'] = $this->language->get('text_background');
        $this->data['text_website'] = $this->language->get('text_website');
        $this->data['text_login'] = $this->language->get('text_login');
        $this->data['text_address'] = $this->language->get('text_address');
        $this->data['text_password'] = $this->language->get('text_password');
        $this->data['text_forgotten'] = $this->language->get('text_forgotten');
        $this->data['text_code'] = $this->language->get('text_code');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_change'] = $this->language->get('text_change');
        $this->data['text_cooperative'] = $this->language->get('text_cooperative');
        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_Register'] = $this->language->get('text_Register');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
		
            unset($this->session->data['guest']);
            //自助购异步登录
            if (isset($this->request->post['isAjax'])) {
                echo '';
                die;
            }
            //网站头部登录 并判断是否有自助购商品
            if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                $this->redirect($this->url->link('order/snatch', '', 'SSL'));
            }

            //跳转到历史页面 guanzhiqiang 20150625
            if (!empty($this->request->post['redirect'])) {
                $this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
            }

            if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {

                $this->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
            } elseif (isset($this->session->data['redirect'])) {
                $this->data['redirect'] = $this->session->data['redirect'];
                unset($this->session->data['redirect']);
            } else {
                if (isset($this->request->post['login_social'])) {
                    $this->redirect($this->url->link('social/social', '', 'SSL'));
                } else {

                    $this->redirect($this->url->link('order/order', '', 'SSL'));
                }
            }
        } else {
            if (isset($_SERVER['HTTP_REFERER'])) {
                $this->session->data['redirect'] = $_SERVER['HTTP_REFERER'];
            }
        }
        $this->data['action'] = $this->url->link('account/login', '', 'SSL');
        $this->data['register'] = $this->url->link('account/register', '', 'SSL');
        $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');
        // Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
        if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
            $this->data['redirect'] = $this->request->post['redirect'];
        } elseif (isset($this->session->data['redirect'])) {
            $this->data['redirect'] = $this->session->data['redirect'];
            unset($this->session->data['redirect']);
        } else {
            $this->data['redirect'] = '';
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } else {
            $this->data['email'] = '';
        }

        if (isset($this->request->post['password'])) {
            $this->data['password'] = $this->request->post['password'];
        } else {
            $this->data['password'] = '';
        }

        if (isset($this->request->get['source'])) {
            $business = 1;
        } else {
            $business = 0;
        }

        if ($business) {
            //网站评论
            $this->load->model('order/sendorder');
            $limit = 6;
            $data = array(
                'start' => 0,
                'limit' => $limit
            );

            $results = $this->model_order_sendorder->getComments($data);
            foreach ($results as $result) {
                $this->data ['comments'] [] = array(
                    'face' => $result ['face'],
                    'uname' => $result ['uname'],
                    'from' => $result ['country'],
                    'utype' => $result ['utype'],
                    'message' => $result ['comment'],
                );
            }
            $this->template = 'cnstorm/template/account/login-business.tpl';
        }

        if (isset($_COOKIE['loginSign'])) {
            $this->data['loginSign'] = $_COOKIE['loginSign'];
        } else {
            $this->data['loginSign'] = 0;
            setcookie('loginSign', 0);
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/login.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/login.tpl';
        } else {
            $this->template = 'default/template/account/login.tpl';
        }
        $this->children = array(
            'common/footer2',
            'common/header_cart'
        );
        $this->response->setOutput($this->render());
    }

    //验证登陆
    protected function validate() {
        if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
            $this->error['warning'] = $this->language->get('error_login');
            if (isset($this->request->post['isAjax'])) {
                echo $this->error['warning'];
                die;
            }
        }

        $customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

        //var_dump($customer_info);die;


        if ($customer_info && !$customer_info['approved']) {
            $this->error['warning'] = $this->language->get('error_approved');
            if (isset($this->request->post['isAjax'])) {
                echo $this->language->get('error_approved');
                die;
            }

        }

        //var_dump($this->error);

        if (!$this->error) {
            $this->data['loginSign'] = setcookie('loginSign', 0);
			
			//setcookie('customer',$customer_info['customer_id']);
			
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime = UNIX_TIMESTAMP(NOW()) WHERE customer_id= '" . $customer_info['customer_id'] . "'");

            $this->load->model('log/customer_login');
            $this->model_log_customer_login->addInfo($customer_info['customer_id'], 'email'); //添加日志

            return true;
        } else {
            if (!isset($_COOKIE['loginSign'])) {
                setcookie('loginSign', 0);
            } else {
                setcookie('loginSign', ($_COOKIE['loginSign'] + 1));
                $this->data['loginSign'] = $_COOKIE['loginSign'];
            }
            $this->data['error_login'] = "您输入的密码和账户名不匹配，请重新输入！";
        }
    }

    //微博登陆
    public function login_weibo() {
        include_once(DIR_SYSTEM . 'weibo/config.php');
        include_once(DIR_SYSTEM . 'weibo/saetv2.ex.class.php');
        $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

        if (isset($_GET['code'])) {

            $keys = array();
            $keys['code'] = $_GET['code'];
            $keys['redirect_uri'] = WB_CALLBACK_URL;

            try {
                $token = $o->getAccessToken('code', $keys);
            } catch (OAuthException $e) {
                
            }
        }

        if (isset($token) && !empty($token)) {
            $this->session->data['token'] = $token;
            setcookie('weibojs_' . $o->client_id, http_build_query($token));
            $c = new SaeTClientV2(WB_AKEY, WB_SKEY, $_SESSION['token']['access_token']);
            $ms = $c->home_timeline(); // done
            $uid_get = $c->get_uid();
            $email_get = $c->get_email();
            $uid = $uid_get['uid'];
            if (isset($email_get['error']) || !$email_get['email']) {
                $email = "";
            } else {
                $email = "&email=" . $email_get['email'];
            }

            $user_message = $c->show_user_by_id($uid); //根据ID获取用户等基本信息

            $uname = isset($user_message['screen_name']) ? $user_message['screen_name'] : '';
            $oauthuid = $uid;
            $sex = $user_message['gender'];
            $face = $user_message['avatar_large'];

            $row = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `from` = 'weibo' AND oauthuid= '" . $uid . "'");
            //判定用户是否存在
            if (count($row->row) == "0") {
                $ip = $this->request->server ['REMOTE_ADDR'];
                $info = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
                $info = json_decode($info, true);
                if ($info ['code'] == 0) {
                    $country = $info ['data'] ['country'];
                } else {
                    $country = '';
                }

                $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET  firstname = '" . $this->db->escape($uname) . "', sex = '" . $this->db->escape($sex) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($oauthuid)))) . "', customer_group_id = 1, ip = '" . $this->db->escape($ip) . "', status = '1', tname= '" . $this->db->escape($uname) . "', approved = 1, `from` = 'weibo', `oauthuid` = '" . $oauthuid . "', `face` = '" . $face . "', regtime = UNIX_TIMESTAMP(NOW()), date_added = NOW(),logintime= UNIX_TIMESTAMP(NOW()),country='" . $this->db->escape($country) . "' ");
                $row2 = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE `from` = 'weibo' AND oauthuid= '" . $oauthuid . "'"); //SQL 范围 FROM=weibo  oauthuid 
                $this->session->data['customer_id'] = $row2->row['customer_id'];
                $this->jumpurl("/index.php?route=account/reg_mail&code=微博登陆" . $email);
            } else {
                $cid = $row->row['customer_id'];
                $this->session->data['customer_id'] = $cid;

                if ($row->row['email'] == "") {
                    $this->jumpurl("/index.php?route=account/reg_mail&code=微博登陆" . $email);
                } else {
                    unset($this->session->data['guest']);

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime = UNIX_TIMESTAMP(NOW()) WHERE `from` = 'weibo' AND  oauthuid= '" . $uid . "' AND oauthuid!='' LIMIT 1");

                    $this->load->model('log/customer_login');
                    $this->model_log_customer_login->addInfo($cid, 'weibo'); //添加日志
                }

                if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                    //未登录并下单
                    $this->jumpurl('/order-snatch.html');
                } else {
                    $this->jumpurl("/index.php");
                }
            }
        } else {
            print("<script language='javascript'>alert('登录超时，請重试!');</script>");
            $this->jumpurl("index.php");
        }
    }

    //QQ登陆
    public function login_qq() {
        //应用的APPID
        $app_id = "100360874";

        //应用的APPKEY
        $app_secret = "7a42d46a007a24b36b6db81d23724e21";

        //成功授权后的回调地址
        $my_url = "http://www.acgstorm.com/index.php?route=account/login/login_qq";

        //Step1：获取Authorization Code
        //session_start();
        $code = $_REQUEST["code"];

        //Step2：通过Authorization Code获取Access Token
        if ($code) {
            //拼接URL   
            $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&" . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $app_secret . "&code=" . $code;

            $response = file_get_contents($token_url);
            if (strpos($response, "callback") !== false) {
                $lpos = strpos($response, "(");
                $rpos = strrpos($response, ")");
                $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
                $msg = json_decode($response);
                if (isset($msg->error)) {
                    print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
                    $this->jumpurl("/index.php");
                }
            }

            //Step3：使用Access Token来获取用户的OpenID
            $params = array();
            parse_str($response, $params);

            $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $params['access_token'];

            $str = file_get_contents($graph_url);
            if (strpos($str, "callback") !== false) {
                $lpos = strpos($str, "(");
                $rpos = strrpos($str, ")");
                $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
            }
            $user = json_decode($str);
            if (isset($user->error)) {

                print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
                $this->jumpurl("/index.php");
            }

            $userinfo = json_decode(file_get_contents('https://graph.qq.com/user/get_user_info?access_token=' . $params['access_token'] . '&oauth_consumer_key=' . $app_id . '&openid=' . $user->openid), true);

            $uname = $userinfo['nickname'];
            $oauthuid = $user->openid;
            $sex = $userinfo['gender'];
            $face = $userinfo['figureurl_qq_2'];

            $row = $this->db->query("SELECT customer_id,email FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND oauthuid= '" . $user->openid . "'"); //SQL 范围 FROM=QQ  QQ名改后，就无法登录，需重新注册 
            //判定用户是否存在
            if (count($row->row) == "0") {

                $ip = $this->request->server ['REMOTE_ADDR'];
                $info = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
                $info = json_decode($info, true);
                if ($info ['code'] == 0) {
                    $country = $info ['data'] ['country'];
                } else {
                    $country = '';
                }

                $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET  firstname = '" . $this->db->escape($uname) . "', sex = '" . $this->db->escape($sex) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($oauthuid)))) . "', customer_group_id = 1, ip = '" . $this->db->escape($ip) . "', status = '1', tname= '" . $this->db->escape($uname) . "', approved = 1, `from` = 'qq', `oauthuid` = '" . $oauthuid . "', `face` = '" . $face . "', regtime = UNIX_TIMESTAMP(NOW()), date_added = NOW(),logintime= UNIX_TIMESTAMP(NOW()),country='" . $this->db->escape($country) . "' ");
                $row2 = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND oauthuid= '" . $oauthuid . "'"); //SQL 范围 FROM=qq  oauthuid 
                $this->session->data['customer_id'] = $row2->row['customer_id'];
                $this->jumpurl("/index.php?route=account/reg_mail&code=QQ登陆");
            } else {
                $cid = $row->row['customer_id'];
                $this->session->data['customer_id'] = $cid;

                if ($row->row['email'] == "") {
                    $this->jumpurl("/index.php?route=account/reg_mail&code=QQ登陆");
                } else {
                    unset($this->session->data['guest']);

                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime = UNIX_TIMESTAMP(NOW()) WHERE `from` = 'qq' AND  oauthuid= '" . $oauthuid . "' AND oauthuid!='' LIMIT 1");

                    $this->load->model('log/customer_login');
                    $this->model_log_customer_login->addInfo($cid, 'qq'); //添加日志
                }

                if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                    //未登录并下单
                    $this->jumpurl('/order-snatch.html');
                } else {
                    $this->jumpurl("/order.html");
                }
            }
        } else {
            print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
            $this->jumpurl("/index.php");
        }
    }

    //微信登陆
    public function login_wx() {
        //https://open.weixin.qq.com/connect/qrconnect?appid=wxc77f5c41a5df661b&redirect_uri=http://www.acgstorm.com/index.php?route=account/login/login_wx&response_type=code&scope=snsapi_login&state=STATE#wechat_redirect
        //应用的APPID
        $app_id = "wxc77f5c41a5df661b";

        //应用的APPKEY
        $app_secret = "38caaaef09b1ecdd60ee0006c721a25e";

        //Step1：获取Authorization Code
        //session_start();
        $code = $_REQUEST["code"];

        //Step2：通过Authorization Code获取Access Token
        if ($code) {

            //拼接URL   
            $token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $app_id . "&grant_type=authorization_code&secret=" . $app_secret . "&code=" . $code;

            $response = file_get_contents($token_url);
            $msg = json_decode($response);

            if (isset($msg->errcode)) {
                print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");

                $this->jumpurl("/index.php");
            }

            //Step3：使用Access Token来获取用户的OpenID
            $graph_url = "https://api.weixin.qq.com/sns/userinfo?openid=OPENID&access_token=" . $msg->access_token;

            $str = file_get_contents($graph_url);

            $user = json_decode($str);
            if (isset($user->errcode)) {

                print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
                $this->jumpurl("/index.php");
            }

            $uname = $user->nickname;
            $sex = $user->sex;
            $face = $user->headimgurl;
            $oauthuid = $user->unionid;

            $row = $this->db->query("SELECT customer_id,email FROM " . DB_PREFIX . "customer WHERE `from` = 'wechat' AND oauthuid= '" . $user->unionid . "'"); //SQL 范围 FROM=wechat  oauthuid 
            //判定用户是否存在
            if (count($row->row) == "0") {
                $ip = $this->request->server ['REMOTE_ADDR'];
                $info = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
                $info = json_decode($info, true);
                if ($info ['code'] == 0) {
                    $country = $info ['data'] ['country'];
                } else {
                    $country = '';
                }

                $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET  firstname = '" . $this->db->escape($uname) . "', sex = '" . $this->db->escape($sex) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($oauthuid)))) . "', customer_group_id = 1, ip = '" . $this->db->escape($ip) . "', status = '1', tname= '" . $this->db->escape($uname) . "', approved = 1, `from` = 'wechat', `oauthuid` = '" . $oauthuid . "', `face` = '" . $face . "', regtime = UNIX_TIMESTAMP(NOW()), date_added = NOW(),logintime= UNIX_TIMESTAMP(NOW()),country='" . $this->db->escape($country) . "' ");
                $row2 = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer WHERE `from` = 'wechat' AND oauthuid= '" . $oauthuid . "'"); //SQL 范围 FROM=wechat  oauthuid 
                $this->session->data['customer_id'] = $row2->row['customer_id'];
                $this->jumpurl("/index.php?route=account/reg_mail&code=微信登陆");
            } else {
                $cid = $row->row['customer_id'];
                $this->session->data['customer_id'] = $cid;

                if ($row->row['email'] == "") {
                    $this->jumpurl("/index.php?route=account/reg_mail&code=微信登陆");
                } else {
                    unset($this->session->data['guest']);
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime = UNIX_TIMESTAMP(NOW()) WHERE `from` = 'wechat' AND  oauthuid= '" . $oauthuid . "' AND oauthuid!='' LIMIT 1");

                    $this->load->model('log/customer_login');
                    $this->model_log_customer_login->addInfo($cid, 'wechat'); //添加日志
                }

                if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                    //未登录并下单
                    $this->jumpurl('/order-snatch.html');
                } else {
                    $this->jumpurl("/order.html");
                }
            }
        } else {
            print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
            $this->jumpurl("/index.php");
        }
    }

    //简单跳转的函数
    protected function jumpurl($url, $time = 1000, $mode = 'js') {
        if ($mode == 'js') {
            echo "<script>
            function redirect() {
                window.location.replace('$url');
            }
            setTimeout('redirect();', $time);
            </script>";
        } else {
            $time = $time / 1000;
            echo "<html><head><title></title><meta http-equiv=\"refresh\" content=\"$time;url=$url\"></head><body></body></html>";
        }
        exit;
    }

    public function login_open() {
        $this->template = 'cnstorm/template/account/login-open.tpl';
        $this->response->setOutput($this->render());
    }

    public function ajax_login() {
        
    }

}

?>