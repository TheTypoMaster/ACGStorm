<?php

class ControllerYundanYundan extends Controller {

    public function index() {

        $this->document->setTitle("运单管理");
        $this->load->model('sale/order');
        $this->load->model('yundan/yundan');

        $this->getList();
    }

    public function remark() {

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');
        $remark = $this->request->get['remark'];
        $order_id = $this->request->get['order_id'];

        $result = $this->model_yundan_yundan->update_order($order_id, $remark);
        if ($result) {
            $result = 1;
        } else {
            $result = 0;
        }
        $this->response->setOutput($result);
    }

    public function weight() {

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');
        $this->load->model('sale/customer');
        $this->load->model('record/record');

        $did = $this->request->get['did'];
        $weight = $this->request->get['weight'];
        $order_id = $this->request->get['order_id'];

//计算最新重量运费
        $query = $this->db->query("SELECT first_weight,continue_weight,first_fee,continue_fee FROM " . DB_PREFIX . "dg_delivery WHERE did = '" . (int) $did . "'");
        $express = $query->rows;

        $first_weight = $express[0]['first_weight'];
        $continue_weight = $express[0]['continue_weight'];
        $first_fee = $express[0]['first_fee'];
        $continue_fee = $express[0]['continue_fee'];

        if ($weight < $first_weight || $weight == $first_weight) {
            $w_price = $first_fee;
        } else {
            $w_price = $first_fee + ceil(($weight - $first_weight) / $continue_weight) * $continue_fee; //根据重量计算的价钱freight
        }

//获取运单相关信息      
        $query2 = $this->db->query("SELECT uname,email,volumn_price,freight FROM " . DB_PREFIX . "sendorder WHERE sid = '" . (int) $order_id . "'");
        $so_info = $query2->rows;
        $uname = $so_info[0]['uname'];
        $email = $so_info[0]['email'];
        $o_freight = $so_info[0]['freight'];
        $v_price = (float)$so_info[0]['volumn_price'];

//体积运费小于重量值 才搞起。
        if ($v_price < $w_price) {
//少了就要补！
            if ($w_price > $o_freight) {

                $cost = round($w_price - $o_freight,2);
                if ($cost != 0) {
                    $update_recharge = $this->model_yundan_yundan->update_debt($order_id, $w_price);

                    $subject = 'CNstorm运单' . $order_id . '重量提示';

                    $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>您的运单$order_id 包裹最新重量为：" . $weight . " g</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>由于包裹实际发出重量超过预估重量，您需要支付额外重量费用 “<a href = 'http://www.acgstorm.com/order-sendorder.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看运单</a>”
                    息。 </br>
                    有关重量问题请参阅：<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=42' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>配送帮助</a>
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                    1、 继续在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                    <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                    <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                    <p>4、 前往Share(晒尔华人互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>晒尔社区</a>)</p>
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
                    </div>";
                }
            } else {

                $cost = round($o_freight - $w_price,2);
                                $subject = '';
                                $message = '';
                if ($cost != 0) {

                    $result = $this->model_sale_customer->getuid_money($uname);
                    $cid = $result ['customer_id'];
                    $user_balance = $result ['money'];

                    $newbalance = round($user_balance + $cost, 2);
                    $this->model_sale_customer->editBalance($newbalance, $uname); // 账户余额注资

                    $note = "运单ID：" . $order_id . "运费差额返还";

                    $data = array(
                        'uid' => $cid,
                        'uname' => $uname,
                        'type' => 1,
                        'action' => 5,
                        'money' => $cost,
                        'accountmoney' => $newbalance,
                        'remark' => $note
                    );

                    $this->model_record_record->addRecord($data); // 写记录

                    $subject = 'CNstorm运单' . $order_id . '重量提示';

                    $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>您的运单：$order_id 重量已变更为" . $weight . " g</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>我们已倾尽全力设计及优化您的包裹并收获成效！</br>原运费" . $o_freight . ",现运费" . $w_price . ",差额" . ($cost) . "已退回您的账号，请查收（<a href = 'http://www.acgstorm.com/order-sendorder.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看运单</a>） </br>
                    有关重量问题请参阅：<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=42' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>配送帮助</a><br>
                    我们很荣幸有机会为您服务，期待您的下次访问！
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                    1、 继续在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                    <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                    <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                    <p>4、 前往Share(晒尔华人互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>晒尔社区</a>)</p>
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
                    </div>";
                }
            }
            $data = array(
                'sendto' => $email,
                'receiver' => $uname,
                'subject' => $subject,
                'msg' => $message,
            );

            $this->load->model('tool/sendmail');
            $this->model_tool_sendmail->send($data);
        }

        $query3 = $this->db->query("UPDATE " . DB_PREFIX . "sendorder SET freight=".$w_price." WHERE sid = '" . (int) $order_id . "'");

        $result = $this->model_yundan_yundan->update_weight($order_id, $weight);

        if ($result) {
            $result = 1;
        } else {
            $result = 0;
        }
        $this->response->setOutput($result);
    }

    public function change_kuaidi() {

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');
        $change_kuaidi = $this->request->get['change_kuaidi'];
        $order_id = $this->request->get['order_id'];

        $result = $this->model_yundan_yundan->change_kuaidi($order_id, $change_kuaidi);
        if ($result) {
            $result = 1;
        } else {
            $result = 0;
        }
        $this->response->setOutput($result);
    }

    public function change_v() {
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');
        $this->load->model('sale/customer');
        $this->load->model('record/record');
        $order_id = $this->request->get['id'];
        $did = $this->request->get['change_kuaidi'];
        $yundan_long = $this->request->get['yundan_long'];
        $yundan_wide = $this->request->get['yundan_wide'];
        $yundan_height = $this->request->get['yundan_high'];

        if ($did == 17 || $did == 52 || $did == 49) {
            $w = ($yundan_long * $yundan_wide * $yundan_height) / 6;
        } else {
            $w = ($yundan_long * $yundan_wide * $yundan_height) / 5;
        }

        //获取运单相关信息      
        $query = $this->db->query("SELECT uname,email,volumn_price,freight,countweight FROM " . DB_PREFIX . "sendorder WHERE sid = '" . (int) $order_id . "'");
        $so_info = $query->rows;
        $uname = $so_info[0]['uname'];
        $email = $so_info[0]['email'];
        $weight = $so_info[0]['countweight'];
        $o_vp = $so_info[0]['volumn_price'];

        //计算最新体积运费
        $query2 = $this->db->query("SELECT first_weight,continue_weight,first_fee,continue_fee FROM " . DB_PREFIX . "dg_delivery WHERE did = '" . (int) $did . "'");
        $express = $query2->rows;

        $first_weight = $express[0]['first_weight'];
        $continue_weight = $express[0]['continue_weight'];
        $first_fee = $express[0]['first_fee'];
        $continue_fee = $express[0]['continue_fee'];

        if ($w < $first_weight || $w == $first_weight) {
            $v_price = $first_fee;
        } else {
            $v_price = $first_fee + ceil(($w - $first_weight) / $continue_weight) * $continue_fee; //根据重量计算的价钱freight
        }

//体积价没有填过的 且服务费少于体积价的 催钱
        //原先的体积价少于更改后的 催钱
        //重量值小于体积运费 才搞起。
        if ($weight < $w) {

            //少了就要补！
            if ($v_price > $o_vp) {
                $cost = round($v_price - $o_vp,2);
                if ($cost != 0) {
                    $update_recharge = $this->model_yundan_yundan->update_debt($order_id, $v_price);

                    $subject = 'CNstorm运单' . $order_id . '重量提示';

                    $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>您的运单$order_id 包裹最新重量为：" . $w . " g</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>由于包裹实际发出重量超过预估重量，您需要支付额外重量费用 “<a href = 'http://www.acgstorm.com/order-sendorder.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看运单</a>”
                    息。 </br>
                    有关重量问题请参阅：<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=42' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>配送帮助</a>
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                    1、 继续在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                    <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                    <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                    <p>4、 前往Share(晒尔华人互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>晒尔社区</a>)</p>
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
                    </div>";
                }else{
			$subject = '';
			$message = '';
		}
            } else {
                $cost = round($o_vp - $v_price,2);
                if ($cost != 0) {
                    $result = $this->model_sale_customer->getuid_money($uname);
                    $cid = $result ['customer_id'];
                    $user_balance = $result ['money'];

                    $newbalance = round($user_balance + $cost, 2);
                    $this->model_sale_customer->editBalance($newbalance, $uname); // 账户余额注资

                    $note = "运单ID：" . $order_id . "运费差额返还";

                    $data = array(
                        'uid' => $cid,
                        'uname' => $uname,
                        'type' => 1,
                        'action' => 5,
                        'money' => $cost,
                        'accountmoney' => $newbalance,
                        'remark' => $note
                    );

                    $this->model_record_record->addRecord($data); // 写记录

                    $subject = 'CNstorm运单' . $order_id . '重量提示';

                    $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>您的运单：$order_id 重量已变更为" . $w . " g</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>我们已倾尽全力设计及优化您的包裹并收获成效！</br>原运费" . $o_freight . ",现运费" . $w_price . ",差额" . ($cost) . "已退回您的账号，请查收（<a href = 'http://www.acgstorm.com/order-sendorder.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看运单</a>） </br>
                    有关重量问题请参阅：<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=42' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>配送帮助</a><br>
                    我们很荣幸有机会为您服务，期待您的下次访问！
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                    1、 继续在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                    <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                    <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                    <p>4、 前往Share(晒尔华人互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>晒尔社区</a>)</p>
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
                    </div>";
                }else{
			$subject = '';
			$message = '';
		}
            }

            $data = array(
                'sendto' => $email,
                'receiver' => $uname,
                'subject' => $subject,
                'msg' => $message,
            );

            $this->load->model('tool/sendmail');
            $this->model_tool_sendmail->send($data);
        }

        $data = array(
            'yundan_long' => $yundan_long,
            'yundan_wide' => $yundan_wide,
            'yundan_high' => $yundan_height,
            'volumn_price' => $v_price,
            'id' => $order_id
        );
        $result = $this->model_yundan_yundan->change_v($data);
        $this->response->setOutput($result);
    }

    public function yundan_list() {

        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');


        if (isset($this->request->get['yundan_id'])) {
            $yundan_id = $this->request->get['yundan_id'];
        } else {

            $yundan_id = 'DESC';
        }

        $result = array();

        $yundan_order = $this->model_yundan_yundan->get_yundan($yundan_id);
	
        $str = explode(",", $yundan_order[0]['oids']);
        sort($str);
        $this->data['sum'] = count($str);
        for ($i = 0; $i < count($str); $i++) {

            $products = $this->model_yundan_yundan->getOrderProducts($str[$i]);
            foreach ($products as $product) {

                $result[$product['order_product_id']]['mpn'] = $product['store_name'];
                $result[$product['order_product_id']]['totalnum'] = $i;
                $result[$product['order_product_id']]['producturl'] = $product['producturl'];
                $result[$product['order_product_id']]['quantity'] = $product['quantity'];
                $result[$product['order_product_id']]['product_id'] = $product['order_id'];
                $result[$product['order_product_id']]['name'] = $product['name'];
                                $result[$product['order_product_id']]['outBound'] = $product['outBound'];
                                $result[$product['order_product_id']]['kuaidi_no'] = $product['kuaidi_no'];
            }
        }
        $this->data['results'] = $result;

        $this->data['token'] = $this->session->data['token'];


        if (isset($this->request->get['product_id'])) {
            $product_id = $this->request->get['product_id'];

            $sum = $this->model_yundan_yundan->warehouse($product_id);
        } else {
            
        }

        if (isset($this->request->get['pack'])) {
            $product_id = $this->request->get['product_id'];

            $sum = $this->model_yundan_yundan->pack($product_id);
        } else {
            
        }

        if ($yundan_order[0]['dabao'] == 1) {
            $this->data['dabao'] = "A:经济打包";
        } elseif ($yundan_order[0]['dabao'] == 2) {
            $this->data['dabao'] = "B:标准打包";
        } elseif ($yundan_order[0]['dabao'] == 3) {
            $this->data['dabao'] = "C:高级打包";
        } else {

            $this->data['dabao'] = "";
        }

        if ($yundan_order[0]['dingdan'] == 1) {
            $this->data['dingdan'] = "A:经济订单";
        } elseif ($yundan_order[0]['dingdan'] == 2) {
            $this->data['dingdan'] = "B:标订单";
        } elseif ($yundan_order[0]['dingdan'] == 3) {
            $this->data['dingdan'] = "C:高级订单";
        } else {

            $this->data['dingdan'] = "";
        }

        if ($yundan_order[0]['baozhuang'] == 1) {
            $this->data['baozhuang'] = "A:经济包装";
        } elseif ($yundan_order[0]['baozhuang'] == 2) {
            $this->data['baozhuang'] = "B:标准包装";
        } elseif ($yundan_order[0]['baozhuang'] == 3) {
            $this->data['baozhuang'] = "C:高级包装";
        } else {

            $this->data['baozhuang'] = "";
        }

        if ($yundan_order[0]['zengzhi'] == 1) {
            $this->data['zengzhi'] = "A:经济增值";
        } elseif ($yundan_order[0]['zengzhi'] == 2) {
            $this->data['zengzhi'] = "B:标准增值";
        } elseif ($yundan_order[0]['zengzhi'] == 3) {
            $this->data['zengzhi'] = "C:高级增值";
        } else {

            $this->data['zengzhi'] = "";
        }

        $this->data['order_id'] = $yundan_id;
        $this->data['consignee'] = $yundan_order[0]['consignee'];
        $this->data['country'] = $yundan_order[0]['country'];
        $this->data['express'] = $yundan_order[0]['deliveryname'];
        $this->template = 'yundan/yundan_list.tpl';
        $this->response->setOutput($this->render());
    }
	public function time_list(){
	    $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('yundan/yundan');


        if (isset($this->request->get['yundan_id'])) {
            $yundan_id = $this->request->get['yundan_id'];
        } else {

            $yundan_id = 'DESC';
        }

        $result = array();

        $yundan_order = $this->model_yundan_yundan->get_yundan($yundan_id);
		
		
	    $this->data['order_id'] = $yundan_id;
		$this->data['consignee'] =$yundan_order[0]['consignee'];
	    $this->data['deliveryname'] = $yundan_order[0]['deliveryname']; 
		
	    $this->data['addtime'] = $yundan_order[0]['addtime']== 0?'未记录': date("Y-m-d H:i:s",$yundan_order[0]['addtime']);
	    $this->data['order_time'] = $yundan_order[0]['order_time']== 0? date("Y-m-d H:i:s",$yundan_order[0]['uptime']): date("Y-m-d H:i:s",$yundan_order[0]['order_time']);
        $this->data['ready_send_time'] = $yundan_order[0]['ready_send_time']==0?'未记录':  date("Y-m-d H:i:s",$yundan_order[0]['ready_send_time']);
        $this->data['delivery_time'] = $yundan_order[0]['delivery_time']==0?'未记录':  date("Y-m-d H:i:s",$yundan_order[0]['delivery_time']);
        $this->data['commenttime'] = $yundan_order[0]['commenttime']==0?'未记录': date("Y-m-d H:i:s",$yundan_order[0]['commenttime']); 
		
	
        $this->template = 'yundan/time_list.tpl';
        $this->response->setOutput($this->render());
		
	}
	
    public function yundan_updata() {
        $this->load->model('yundan/yundan');


        if (isset($this->request->get['yundan_id'])) {
            $yundan_id = $this->request->get['yundan_id'];
        } else {
            $yundan_id = $this->request->post['yundan_id'];
        }


        if (isset($this->request->post['updata'])) {



            if (isset($this->request->post['kuaiai_on'])) {
                $kuaiai_on = $this->request->post['kuaiai_on'];
            } else {
                $kuaiai_on = 'DESC';
            }

            if (isset($this->request->post['email'])) {
                $email = $this->request->post['email'];
            } else {
                $email = 'DESC';
            }
            if (isset($this->request->post['freight'])) {
                $freight = $this->request->post['freight'];
            } else {
                $freight = 'DESC';
            }
            if (isset($this->request->post['serverfee'])) {
                $serverfee = $this->request->post['serverfee'];
            } else {
                $serverfee = 'DESC';
            }
            if (isset($this->request->post['customsfee'])) {
                $customsfee = $this->request->post['customsfee'];
            } else {
                $customsfee = 'DESC';
            }
            if (isset($this->request->post['totalfee'])) {
                $totalfee = $this->request->post['totalfee'];
            } else {
                $totalfee = 'DESC';
            }
            if (isset($this->request->post['consignee'])) {
                $consignee = $this->request->post['consignee'];
            } else {
                $consignee = 'DESC';
            }
            if (isset($this->request->post['country'])) {
                $country = $this->request->post['country'];
            } else {
                $country = 'DESC';
            }

            if (isset($this->request->post['city'])) {
                $city = $this->request->post['city'];
            } else {
                $city = 'DESC';
            }
            if (isset($this->request->post['zip'])) {
                $zip = $this->request->post['zip'];
            } else {
                $zip = 'DESC';
            }
            if (isset($this->request->post['address'])) {
                $address = $this->request->post['address'];
            } else {
                $address = 'DESC';
            }
            if (isset($this->request->post['comment'])) {
                $comment = $this->request->post['comment'];
            } else {
                $comment = 'DESC';
            }
            if (isset($this->request->post['reply'])) {
                $reply = $this->request->post['reply'];
            } else {
                $reply = 'DESC';
            }
            if (isset($this->request->post['showcomment'])) {
                $showcomment = $this->request->post['showcomment'];
            } else {
                $showcomment = 'DESC';
            }
			 if (isset($this->request->post['state'])) {
                $state = $this->request->post['state'];
            } else {
                $state = '';
            }

            $data = array(
                'yundan_id' => $yundan_id,
                'kuaiai_on' => $kuaiai_on,
                'email' => $email,
                'freight' => $freight,
                'serverfee' => $serverfee,
                'customsfee' => $customsfee,
                'consignee' => $consignee,
                'country' => $country,
                'city' => $city,
                'zip' => $zip,
                'comment' => $comment,
                'reply' => $reply,
                'address' => $address,
                'showcomment' => $showcomment,
				'state'=>$state
            );

            $this->model_yundan_yundan->updata_yundan($data);
        }


        $results = $this->model_yundan_yundan->get_yundan($yundan_id);
        $this->data['sid'] = $results[0]['sid'];
        $this->data['uid'] = $results[0]['uid'];
        $this->data['uname'] = $results[0]['uname'];
        $this->data['email'] = $results[0]['email'];
        $this->data['freight'] = $results[0]['freight'];
        $this->data['serverfee'] = $results[0]['serverfee'];
        $this->data['customsfee'] = $results[0]['customsfee'];
        $this->data['totalfee'] = $results[0]['totalfee'];
        $this->data['countmoney'] = $results[0]['countmoney'];
        $this->data['countweight'] = $results[0]['countweight'];
        $this->data['consignee'] = $results[0]['consignee'];
        $this->data['country'] = $results[0]['country'];
        $this->data['city'] = $results[0]['city'];
        $this->data['zip'] = $results[0]['zip'];
        $this->data['tel'] = $results[0]['tel'];
        $this->data['address'] = $results[0]['address'];
        $this->data['remark'] = $results[0]['remark'];
        $this->data['comment'] = $results[0]['comment'];
        $this->data['reply'] = $results[0]['reply'];
        $this->data['showcomment'] = $results[0]['showcomment'];
        $this->data['state'] = $results[0]['state'];
        $this->data['kuaiai_on'] = $results[0]['sn'];

        $this->data['action'] = $this->url->link('yundan/yundan/yundan_updata', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['quxiao'] = $this->url->link('yundan/yundan', 'token=' . $this->session->data['token'], 'SSL');
        $this->template = 'yundan/yundan_updata.tpl';
        $this->response->setOutput($this->render());
    }

    protected function getList() {
        $passData = array();
        if (isset($this->request->get['filter_order_id'])) {
            $passData = array(
                1
            );
            $filter_order_id = $this->request->get['filter_order_id'];
        } else {
            $filter_order_id = null;
        }

        if (isset($this->request->get['filter_customer'])) {
            $passData = array(
                "uname" => $this->request->get['filter_customer']
            );
            $filter_customer = $this->request->get['filter_customer'];
        } else {
            $filter_customer = null;
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $passData = array(
                "filter_order_status_id" => $this->request->get['filter_order_status_id']
            );
            $filter_order_status_id = $this->request->get['filter_order_status_id'];
        } else {
            $filter_order_status_id = null;
        }
        if (isset($this->request->get['firstname'])) {
            $firstname = $this->request->get['firstname'];
        } else {
            $firstname = null;
        }


        if (isset($this->request->get['filter_sid'])) {
            $passData = array(
                1
            );
            $filter_sid = $this->request->get['filter_sid'];
        } else {
            $filter_sid = null;
        }

        if (isset($this->request->get['filter_sn'])) {
            $filter_sn = $this->request->get['filter_sn'];
        } else {
            $filter_sn = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $filter_date_modified = $this->request->get['filter_date_modified'];
        } else {
            $filter_date_modified = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'o.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_sn'])) {
            $url .= '&filter_sn=' . $this->request->get['filter_sn'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => '运单管理',
            'href' => $this->url->link('yundan/yundan', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );



        if (isset($this->request->post['selected']) && isset($this->request->post['filter_order_status_id'])) {
            $select = $this->request->post['selected'];
            $filter_order_status_id = $this->request->post['filter_order_status_id'];

            $this->model_yundan_yundan->updata_status($select, $filter_order_status_id);

            //手机推送消息
            if ($filter_order_status_id == 2 || $filter_order_status_id == 3) {
                foreach ($this->request->post['selected'] as $order_id) {
                    $sendorder = $this->model_yundan_yundan->getOrder($order_id);
                    $uname = $sendorder['0']['uname'];
                    $email = $sendorder['0']['email'];

                    $apps = $this->model_sale_order->getOnlineAppByCustomer($sendorder['0']['uid']);
                    if ($apps) {
                        //已邮寄2，已确认收货3
                        if ($filter_order_status_id == 2) {
                            $message = '已邮寄，您可以通过快递编号查看运单的物流跟踪信息。';
                            $state = 2;
                        } elseif ($filter_order_status_id == 3) {
                            $message = '已确认收货，戳我进来看看又新进了些啥好货~';
                            $state = 3;
                        }
                        $custom_content = array(
                            'order_id' => $order_id,
                            'state' => $state
                        );
                        include_once(DIR_SYSTEM . 'baepush.class.php');
                        $baepush = new Baepush();
                        foreach ($apps as $app) {
                            if ($app['device_type'] == 1) {//ios
                                $device_type = 4;
                            } elseif ($app['device_type'] == 2) {//android
                                $device_type = 3;
                            }
                            $pm = array(
                                'push_type' => 1,
                                'user_id' => $app['user_id'],
                                'device_type' => $device_type,
                                'description' => '您的运单' . $order_id . $message,
                                'deploy_status' => 2,
                                'custom_content' => $custom_content
                            );
                            $baepush->push($pm);
                        }
                    }

                    if ($filter_order_status_id == 2) {

                        $subject = 'CNstorm运单' . $order_id . '发出提示邮件';

                        $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>您的运单号： $order_id 包裹已发出！</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>接下来，您可访问“用户中心” – “<a href = 'http://www.acgstorm.com/order-sendorder.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>国际运单</a>”查询您的包裹及物流跟踪信
                    息。 </br>
                    别忘了在收到包裹后前往用户中心确认收货，并给我们留下宝贵评价以获赠运单积分哦^^！<br>
                    我们非常荣幸能为您服务，期待您的下次访问!
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                    1、 继续在中国购物网站挑选商品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                    <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                    <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                    <p>4、 前往Share(晒尔华人互动社区)分享您的海外生活轶事(<a href = 'http://www.acgstorm.com/index.php?route=social/social' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>晒尔社区</a>)</p>
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
                    </div>";

                        $data = array(
                            'sendto' => $email,
                            'receiver' => $uname,
                            'subject' => $subject,
                            'msg' => $message,
                        );

                        $this->load->model('tool/sendmail');
                        $this->model_tool_sendmail->send($data);
                    }
                }
            }
        } else {
            $order = 'DESC';
        }


        $this->data['invoice'] = $this->url->link('sale/order/invoice', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['insert'] = $this->url->link('sale/order/insert', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['delete'] = $this->url->link('yundan/yundan', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['emali'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['update_order'] = $this->url->link('yundan/yundan', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['orders'] = array();

        $data = array(
            'filter_order_id' => $filter_order_id,
            'filter_customer' => $filter_customer,
            'firstname' => $firstname,
            'filter_order_status_id' => $filter_order_status_id,
            'filter_sn' => $filter_sn,
            'filter_sid' => $filter_sid,
            'filter_date_added' => $filter_date_added,
            'filter_date_modified' => $filter_date_modified,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );


        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_yundan_yundan->getOrders($data);
    // print_r($results);
        foreach ($results as $result) {
            //var_dump($result);exit();

            $action = array();
            $action[] = array(
                'text' => $this->language->get('text_view'),
                'href' => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['sid'] . $url, 'SSL')
            );

            if ($result['state'] == 1) {
                $state = "已付款";
            } elseif ($result['state'] == 2) {
                $state = "已邮寄";
            } elseif ($result['state'] == 3) {

                $state = "已确认收货";
            } elseif ($result['state'] == 4) {
                $state = "无效运单";
            } elseif ($result['state'] == 5) {
                $state = "准备邮寄";
            } elseif ($result['state'] == 6) {
                $state = "待补交运费";
            }elseif ($result['state'] == 8) {
                $state = "已评价";
            }else{
                $state = "";
            }

            $express_all = $this->model_yundan_yundan->International_express($result['country']);
            $country_cn = $this->model_yundan_yundan->Destination_cn($result['country']);

            $zengzhi = explode(',',$result['zengzhi']);
            if (count($zengzhi) == 1){
                $result['zengzhi'] = $zengzhi[0];
            }else{
                $result['zengzhi'] = $zengzhi;
            }

            $this->data['orders'][] = array(
                'pak_free' => $result['pak_free'],
                'sid' => $result['sid'],
				'remarks'=> $result['remarks'],
                'uname' => $result['uname'],
                'remark' => $result['remark'],
                'sn' => $result['sn'],
                'express' => $result['did'],
                'deliveryname' => $result['deliveryname'],
                'express_all' => $express_all,
                'country' => $result['country'],
                'country_cn' => $country_cn,
                'city' => $result['city'],
                'address' => $result['address'],
                'consignee' => $result['consignee'],
                'freight' => $result['freight'],
                'email' => $result['email'],
                'serverfee' => $result['serverfee'],
                'customsfee' => $result['customsfee'],
                'totalfee' => $result['totalfee'],
                'countweight' => $result['countweight'],
                'dabao' => $result['dabao'],
                'dingdan' => $result['dingdan'],
                'baozhuang' => $result['baozhuang'],
                'zengzhi' => $result['zengzhi'],
                'tel' => $result['tel'],
                'addtime' => date("Y-m-d H:i:s", $result['addtime']),
                'yundan_long' => $result['length'],
                'yundan_wide' => $result['width'],
                'yundan_high' => $result['height'],
                'uptime' => date("Y-m-d H:i:s", $result['uptime']),
                'state' => $state,
                'countweight' => $result['countweight'],
                'volume_free' => $result['volumn_price'],
                'zip' => $result['zip'],
                'selected' => isset($this->request->post['selected']) && in_array($result['sid'], $this->request->post['selected']),
                'action' => $action,
                'wrapperfee'=>$result['wrapperfee'],
                'oldtotalfee'=>$result['oldtotalfee']
            );
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_missing'] = $this->language->get('text_missing');


        $this->data['token'] = $this->session->data['token'];

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
        $this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
        $this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
        $this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
        $this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
        $this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_order_id'])) {
            $url .= '&filter_order_id=' . $this->request->get['filter_order_id'];
        }

        if (isset($this->request->get['filter_customer'])) {
            $url .= '&filter_customer=' . urlencode(html_entity_decode($this->request->get['filter_customer'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_order_status_id'])) {
            $url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
        }

        if (isset($this->request->get['filter_total'])) {
            $url .= '&filter_total=' . $this->request->get['filter_total'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['filter_date_modified'])) {
            $url .= '&filter_date_modified=' . $this->request->get['filter_date_modified'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }
        $order_total = $this->model_yundan_yundan->total($passData);

        $pagination = new Pagination();
        $pagination->total = $order_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('yundan/yundan', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_order_id'] = $filter_order_id;
        $this->data['filter_customer'] = $filter_customer;
        $this->data['filter_order_status_id'] = $filter_order_status_id;
        $this->data['filter_date_added'] = $filter_date_added;
        $this->data['filter_date_modified'] = $filter_date_modified;


        $this->data['order_statuses'] = $this->model_yundan_yundan->getyundanStatuses();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'yundan/yundan.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

        //出库确认
        public function outBound(){
                if (isset($this->request->post['product_id'])) {
            $product_id = $this->request->post['product_id'];
        }else{
                        $product_id = '';
                }
                $this->load->model('yundan/yundan');
                $res = $this->model_yundan_yundan->outBound($product_id);
                if ($res) echo 1;
        }
     
		//修改备注
		public function updatabz(){
			$this->load->model('yundan/yundan');
			$content=htmlspecialchars(trim($_GET['content']));
			$oid= $_GET['oid'];
			$row=$this->model_yundan_yundan->updatabz($oid, $content );
			if($row){
				echo 1;
			}else{
				echo 0;
			}
		
	}
}

?>