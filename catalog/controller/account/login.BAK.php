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

        include_once(DIR_SYSTEM . 'weibo/config.php');
        include_once(DIR_SYSTEM . 'weibo/saetv2.ex.class.php');
        $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
        $this->data['code_url'] = $o->getAuthorizeURL(WB_CALLBACK_URL);
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/login.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/login.tpl';
        } else {
            $this->template = 'default/template/account/login.tpl';
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

            $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime ='" . time() . "' WHERE customer_id= '" . $customer_info['customer_id'] . "'");

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
            $uid = $uid_get['uid'];

            $user_message = $c->show_user_by_id($uid); //根据ID获取用户等基本信息

            $uname = isset($user_message['screen_name']) ? $user_message['screen_name'] : '';
//echo "<div style='display:hidden'>".$uname ."-".$uid."</div>";
            $row = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `from` = 'weibo' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $uid . "'");

            if (count($row->row) == "0") {
                $this->session->data['from'] = 'weibo';
                $this->session->data['nick'] = $uname;
                $this->session->data['oauthuid'] = $uid;
                print("<script language='javascript'>alert('登录成功！请补充注册信息以便我们更好为您服务！');</script>");
                $this->jumpurl("index.php?route=account/register&nick=" . $uname . "&oauthuid=" . $uid);
            } else {
                //weibo.oauthuid为空时，修改成oauthuid
                if ($row->row['oauthuid'] == "") {
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET oauthuid= '" . $uid . "' WHERE `from` = 'weibo' AND firstname = '" . $uname . "'");
                }
                unset($this->session->data['guest']);
                $row2 = $this->db->query("SELECT `customer_id` FROM " . DB_PREFIX . "customer WHERE `from` = 'weibo' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $uid . "'");
                $cids = $row2->row;
                $cid = $cids['customer_id'];
                $this->session->data['customer_id'] = $cid;
                if ($cid == 248) {
                    $row3 = $this->db->query("SELECT `blog` FROM " . DB_PREFIX . "customer WHERE `from` = 'weibo' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $uid . "'");
                    $cids1 = $row3->row;
                    $loginlog = $cids1['blog'];
                    $loginlog.=',' . time();
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime ='" . time() . "',blog='" . $loginlog . "' WHERE `from` = 'weibo' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $uid . "'");
                } else {
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime ='" . time() . "' WHERE `from` = 'weibo' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $uid . "'");
                }
                if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                    //未登录并下单
                    $this->jumpurl('/order-snatch.html');
                } else {
                    $this->jumpurl("/index.php");
                }
            }
        } else {
            //         print("<script language='javascript'>alert('网络忙，请稍后重试!');</script>");
            print("<script language='javascript'>alert('登入成功!');</script>");
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
            //var_dump($user);
            // echo("Hello " . $user->openid);die;

            $userinfo = json_decode(file_get_contents('https://graph.qq.com/user/get_user_info?access_token=' . $params['access_token'] . '&oauth_consumer_key=' . $app_id . '&openid=' . $user->openid), true);

            // var_dump($userinfo);die;
            $uname = $userinfo['nickname'];
            $row = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND (oauthuid= '" . $user->openid . "' OR firstname = '" . $uname . "' OR tname= '" . $uname . "')"); //SQL 范围 FROM=QQ

//echo "SELECT * FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND (oauthuid= '" . $user->openid . "' OR firstname = '" . $uname . "' OR tname= '" . $uname . "')";
//exit;

            if (count($row->row) == "0") {
                $this->session->data['from'] = 'qq';
                $this->session->data['nick'] = $uname;
                $this->session->data['oauthuid'] = $user->openid;
                print("<script language='javascript'>alert('Q Q登录成功！第一次登录您需要补充注册信息以便我们更好为您服务！');</script>");
                //$this->jumpurl("/index.php?route=account/register&nick=" . $uname . "&oauthuid=" . $user->openid."&face=".$userinfo['figureurl_qq_2']);
                $this->jumpurl("/index.php?route=account/register&face=" . $userinfo['figureurl_qq_2']);
            } else {
                if ($row->row['oauthuid'] == "") {
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET oauthuid= '" . $user->openid . "' WHERE `from` = 'qq' AND firstname = '" . $uname . "'");
                }
                unset($this->session->data['guest']);

                //$row2 = $this->db->query("SELECT `customer_id` FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND firstname = '" . $uname . "' OR tname= '" . $uname . "' OR oauthuid= '" . $user->openid . "'");
                $row2 = $this->db->query("SELECT `customer_id` FROM " . DB_PREFIX . "customer WHERE `from` = 'qq' AND oauthuid= '" . $user->openid . "'"); //QQ oauthuid 验证 guanzhiqiang 20150601


                if (empty($row2->row['customer_id'])) {//customer_id查询为空时,说明是QQ初次登录，需完善注册信息  guanzhiqiang 20150601
                    $this->session->data['from'] = 'qq';
                    $this->session->data['nick'] = $uname;
                    $this->session->data['oauthuid'] = $user->openid;
                    print("<script language='javascript'>alert('QQ登录成功！第一次登录您需要补充注册信息以便我们更好为您服务！');</script>");
                    //$this->jumpurl("/index.php?route=account/register&nick=" . $uname . "&oauthuid=" . $user->openid."&face=".$userinfo['figureurl_qq_2']);
                    $this->jumpurl("/index.php?route=account/register&face=" . $userinfo['figureurl_qq_2']);
                }

                $cid = $row2->row['customer_id'];
                $this->session->data['customer_id'] = $cid;
                if (!empty($user->openid)) {
                    $this->db->query("UPDATE " . DB_PREFIX . "customer SET logintime = UNIX_TIMESTAMP(NOW()) WHERE `from` = 'qq' AND oauthuid= '" . $user->openid . "' AND oauthuid!=''");
                }
                //if(!empty($this->cookie->data['runUrl'])){
                if (isset($_COOKIE['taobao_id']) && !empty($_COOKIE['taobao_id'])) {
                    //未登录并下单
                    $this->jumpurl('/order-snatch.html');
                } else {
                    $this->jumpurl("/order.html");
                }
            }
        } else {
            //echo("The state does not match. You may be a victim of CSRF.");
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