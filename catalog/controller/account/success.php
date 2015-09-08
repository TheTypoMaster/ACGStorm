<?php

class ControllerAccountSuccess extends Controller {

    public function index() {
        $this->language->load('account/success');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['favorite'] = $this->url->link('product/favorite');

        $this->data['edit'] = $this->url->link('account/edit', '', 'SSL');

        $this->data['customer_id'] = rand(0, 100000);

        $this->data['customer_name'] = $this->customer->getFirstName();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/success.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/success.tpl';
        } else {
            $this->template = 'default/template/common/success.tpl';
        }

        $this->response->setOutput($this->render());

        $customer_name = $this->data['customer_name'];
        $customer_email = $this->customer->getEmail();
        $output = $this->curl(HTTP_SERVER . "index.php?route=account/success/sendmail&name=$customer_name&email=$customer_email", "GET");
    }

    protected function curl($url = "", $type = "GET", $post_data = array()) {
        if ($type = "GET") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $output = curl_exec($ch);
            curl_close($ch);
        } elseif ($type = "POST") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            // post数据
            curl_setopt($ch, CURLOPT_POST, 1);
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            $output = curl_exec($ch);
            curl_close($ch);
        }
        return $output;
    }

    public function sendmail() {
        $customer_name = $this->request->get["name"];
        $customer_email = $this->request->get["email"];
        if (empty($customer_email)) {
            return false;
        }

        //注册成功发邮件用户体验杠杠的
        $subject = "CNstorm注册确认邮件";

        $message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                            <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                            <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                            <div style = 'padding:0;margin:0;'>
                            <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                            <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                            <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $customer_name . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                            <p><b style = 'color:#000;'>您的CNstorm账户已注册成功！</b></p>
                            <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>感谢阁下明智选择CNstorm - 全网最大中国商品购买及国际转运服务提供商（<a href = 'http://www.acgstorm.com/help-aboutus.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>关于我们</a>）<br>
                            <br>
                            </div>
                            <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                            1、 在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                            <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                            <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                            <p>4、 参与Share(晒尔华人留学生互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>前往晒尔社区</a>)</p>
                            <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                            <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                            <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                            <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                            </div>
                            </div>
                            </div>
                            <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                            <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                            <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                            <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                            <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                            </div>
                            </div>
                            </div>
";

        $qq_message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                            <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                            <div style = 'margin:0;padding:0;text-align:center;'>CNstorm</div>
                            <div style = 'padding:0;margin:0;'>
                            <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                            <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                            <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $customer_name . " <span style = 'font-size:22px;color:#FF6d85;'></span></h3>
                            <p><b style = 'color:#000;'>您的CNstorm账户已注册成功！</b></p>
                            <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>感谢阁下明智选择CNstorm - 全网最大中国商品购买及国际转运服务提供商（<a href = 'http://www.acgstorm.com/help-aboutus.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>关于我们</a>）<br>
                            <br>
                            </div>
                            <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                            1、 在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                            <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                            <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                            <p>4、 参与Share(晒尔华人留学生互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>前往晒尔社区</a>)</p>
                            <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                            <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                            <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                            <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                            </div>
                            </div>
                            </div>
                            <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                            <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                            <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                            <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                            <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                            </div>
                            </div>
                            </div>
";

        if (strpos($customer_email, "@qq.com") !== false) {
            $message = $qq_message;
        }

        $data = array(
            'sendto' => $customer_email,
            'receiver' => $customer_name,
            'subject' => $subject,
            'msg' => $message,
        );
        $this->load->model('tool/sendmail');
        $this->model_tool_sendmail->send($data);
    }

}

?>