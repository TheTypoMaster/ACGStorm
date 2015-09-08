<?php

class ControllerSaleCustomer extends Controller {

    private $error = array();

    public function index() {
        if (isset($_POST['customer_id'])) {
            $this->load->model('sale/customer');
            $only_customer = $this->model_sale_customer->getCustomer($_POST['customer_id']);
            $only_customer_verification = $only_customer['verification'];
            $uname = $only_customer['firstname'];
            if ($only_customer_verification == 0) {
                $this->model_sale_customer->editCustomerVerification($_POST['customer_id'], 1);
                $msg = array('msg' => 0);
                echo json_encode($msg);

                $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>恭喜您，您的学生认证已通过！</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>您的学生认证已通过，感谢您对CNstorm的支持，愿您在国外学业顺利！（<a href='http://www.acgstorm.com/index.php?route=order/order'>查看状态</a>）
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
                    'sendto' => $only_customer['email'],
                    'receiver' => $uname,
                    'subject' => '您的学生认证已通过！',
                    'msg' => $message,
                );
                $this->load->model('tool/sendmail');
                $this->model_tool_sendmail->send($data);
            } else {
                $this->model_sale_customer->editCustomerVerification($_POST['customer_id'], 0);
                $msg = array('msg' => 1);
                echo json_encode($msg);
            }
        } else {
            $this->language->load('sale/customer');
            $this->document->setTitle($this->language->get('heading_title'));
            $this->load->model('sale/customer');
            $this->getList();
        }
    }

//商户认证
	public function bussiness() {
		if (isset($_POST['customer_id'])) {
			$this->load->model('sale/customer');
            $only_bussiness = $this->model_sale_customer->getCustomer($_POST['customer_id']);
            $only_customer_bussiness = $only_bussiness['business'];
            $uname = $only_bussiness['firstname'];
			if ($only_customer_bussiness == 0) {
                $this->model_sale_customer->editCustomerBussiness($_POST['customer_id'], 1);
                $msg = array('msg' => 0);
                echo json_encode($msg);

                $message = "<div style = 'background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                    <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                    <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                    <div style = 'padding:0;margin:0;'>
                    <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                    <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                    <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                    <p><b style = 'color:#000;'>恭喜您，您的商户认证已通过！</b></p>
                    <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>您的商户认证已通过，感谢您对CNstorm的支持，愿您在国外顺心如意！（<a href='http://www.acgstorm.com/index.php?route=order/order'>查看状态</a>）
                    </div>
                    <p style = 'margin:20px 0;'>CNstorm致力于帮助海外华人商业经营，让您在海外经商，也能享受国内低成本渠道。接下来您可以：</p>
                    1、 开始在中国挑选产品，并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/index.php?route=business/service' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代采购供应链服务</a>)
                    <p>2、 您自行采购并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与多件产品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/index.php?route=business/service/self' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>自助型产品整合供应链服务</a>）</p>
                    <p>3、 指定商家采购，或手动输入商品信息下单，通过CNstorm极具性价比的国际物流系统，与多件产品合并快运至您的海外地址。(<a href = 'http://www.acgstorm.com/order-make-order_daiji.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代邮寄产品整合供应链服务</a>)。</p>
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
                    'sendto' => $only_bussiness['email'],
                    'receiver' => $uname,
                    'subject' => '您的商户认证已通过！',
                    'msg' => $message,
                );
                $this->load->model('tool/sendmail');
                $this->model_tool_sendmail->send($data);

			} else {
                $this->model_sale_customer->editCustomerBussiness($_POST['customer_id'], 0);
                $msg = array('msg' => 1);
                echo json_encode($msg);
            }
		}
	}

    public function insert() {
        $this->language->load('sale/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_sale_customer->addCustomer($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip=' . $this->request->get['filter_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

            $this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function update() {
        $this->language->load('sale/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

    	if (isset($this->request->get['customer_id'])){
            $this->model_sale_customer->editCustomerByAdmin($this->request->get['customer_id'], $this->request->post);
	}else if(isset($this->request->post['customer_id'])){
	    $this->model_sale_customer->editCustomer($this->request->post['customer_id'], $this->request->post);
	}
            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip=' . $this->request->get['filter_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

            $this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('sale/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/customer');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $customer_id) {
                $this->model_sale_customer->deleteCustomer($customer_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip=' . $this->request->get['filter_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

            $this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    public function approve() {
        $this->language->load('sale/customer');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('sale/customer');

        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        } elseif (isset($this->request->post['selected'])) {
            $approved = 0;

            foreach ($this->request->post['selected'] as $customer_id) {
                $customer_info = $this->model_sale_customer->getCustomer($customer_id);

                if ($customer_info && !$customer_info['approved']) {
                    $this->model_sale_customer->approve($customer_id);

                    $approved++;
                }
            }

            $this->session->data['success'] = sprintf($this->language->get('text_approved'), $approved);

            $url = '';

            if (isset($this->request->get['filter_name'])) {
                $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_email'])) {
                $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
            }

            if (isset($this->request->get['filter_customer_group_id'])) {
                $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
            }

            if (isset($this->request->get['filter_status'])) {
                $url .= '&filter_status=' . $this->request->get['filter_status'];
            }

            if (isset($this->request->get['filter_approved'])) {
                $url .= '&filter_approved=' . $this->request->get['filter_approved'];
            }

            if (isset($this->request->get['filter_ip'])) {
                $url .= '&filter_ip=' . $this->request->get['filter_ip'];
            }

            if (isset($this->request->get['filter_date_added'])) {
                $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

            $this->redirect($this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = null;
        }

        if (isset($this->request->get['filter_email'])) {
            $filter_email = $this->request->get['filter_email'];
        } else {
            $filter_email = null;
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $filter_customer_group_id = $this->request->get['filter_customer_group_id'];
        } else {
            $filter_customer_group_id = null;
        }

        if (isset($this->request->get['filter_status'])) {
            $filter_status = $this->request->get['filter_status'];
        } else {
            $filter_status = null;
        }

        if (isset($this->request->get['filter_approved'])) {
            $filter_approved = $this->request->get['filter_approved'];
        } else {
            $filter_approved = null;
        }

        if (isset($this->request->get['filter_ip'])) {
            $filter_ip = $this->request->get['filter_ip'];
        } else {
            $filter_ip = null;
        }

        if (isset($this->request->get['filter_date_added'])) {
            $filter_date_added = $this->request->get['filter_date_added'];
        } else {
            $filter_date_added = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'name';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_ip'])) {
            $url .= '&filter_ip=' . $this->request->get['filter_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        } else {
            $url .= '&sort=DESC';
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
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['approve'] = $this->url->link('sale/customer/approve', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['insert'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['delete'] = $this->url->link('sale/customer/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $this->data['customers'] = array();

        $data = array(
            'filter_name' => $filter_name,
            'filter_email' => $filter_email,
            'filter_customer_group_id' => $filter_customer_group_id,
            'filter_status' => $filter_status,
            'filter_approved' => $filter_approved,
            'filter_date_added' => $filter_date_added,
            'filter_ip' => $filter_ip,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $customer_total = $this->model_sale_customer->getTotalCustomers($data);

        $results = $this->model_sale_customer->getCustomers($data);

        date_default_timezone_set('PRC');

        foreach ($results as $result) {
            $action = array();
            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['customer_id'] . $url, 'SSL')
            );
			if(empty($result['country'])){
		
				if($result['ip']){
					$ip = $this->request->server ['REMOTE_ADDR'];
					$info = file_get_contents ('http://ip.taobao.com/service/getIpInfo.php?ip='.$result['ip']);
					$info = json_decode ( $info, true );
					if ($info ['code'] == 0) {
						$country = $info ['data'] ['country'];
					} else {
						$country = '';
					}
				}else{
					$country = '';
				}
			}else{
				$country=$result['country'];
			}

            $this->data['customers'][] = array(
                'customer_id' => $result['customer_id'],
                'name' => $result['firstname'],
                'email' => $result['email'],
                'customer_group' => $result['customer_group'],
                'money' => $result['money'],
                'score' => $result['scores'],
                'status' => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
                'approved' => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
                'ip' => $result['ip'],
                'date_added' => $result['date_added'],//$this->language->get('date_format_short')
                'from' => $result['from'],
                'selected' => isset($this->request->post['selected']) && in_array($result['customer_id'], $this->request->post['selected']),
                'action' => $action,
                'verification' => $result['verification'],
				'business'=>$result['business'],
				'logintime'=>$result['logintime']==''?'':date('Y-m-d H:i:s',$result['logintime']),
				'orderNum'=>$result['orderNum']==''?0:$result['orderNum'],
				'country'=>$country==''?'未知':'('.$country.')'
            );
        }
        
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_email'] = $this->language->get('column_email');
        $this->data['column_customer_group'] = $this->language->get('column_customer_group');
        $this->data['column_status'] = $this->language->get('column_status');
        $this->data['column_approved'] = $this->language->get('column_approved');
        $this->data['column_ip'] = $this->language->get('column_ip');
        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_login'] = $this->language->get('column_login');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_approve'] = $this->language->get('button_approve');
        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_filter'] = $this->language->get('button_filter');

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

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_ip'])) {
            $url .= '&filter_ip=' . $this->request->get['filter_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_cid'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.customer_id' . $url, 'SSL');
        $this->data['sort_name'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $this->data['sort_email'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
        $this->data['sort_customer_group'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
        $this->data['sort_status'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.status' . $url, 'SSL');
        $this->data['sort_approved'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.approved' . $url, 'SSL');
        $this->data['sort_ip'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.ip' . $url, 'SSL');
        $this->data['sort_date_added'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&sort=c.date_added' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_ip'])) {
            $url .= '&filter_ip=' . $this->request->get['filter_ip'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
        }

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $customer_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_email'] = $filter_email;
        $this->data['filter_customer_group_id'] = $filter_customer_group_id;
        $this->data['filter_status'] = $filter_status;
        $this->data['filter_approved'] = $filter_approved;
        $this->data['filter_ip'] = $filter_ip;
        $this->data['filter_date_added'] = $filter_date_added;

        $this->load->model('sale/customer_group');

        $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

        $this->load->model('setting/store');

        $this->data['stores'] = $this->model_setting_store->getStores();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'sale/customer_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm() {
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_wait'] = $this->language->get('text_wait');
        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_add_ban_ip'] = $this->language->get('text_add_ban_ip');
        $this->data['text_remove_ban_ip'] = $this->language->get('text_remove_ban_ip');

        $this->data['column_ip'] = $this->language->get('column_ip');
        $this->data['column_total'] = $this->language->get('column_total');
        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_balance'] = $this->language->get('entry_balance');
        $this->data['entry_score'] = $this->language->get('entry_score');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['entry_confirm'] = $this->language->get('entry_confirm');
        $this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_company'] = $this->language->get('entry_company');
        $this->data['entry_company_id'] = $this->language->get('entry_company_id');
        $this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
        $this->data['entry_address_1'] = $this->language->get('entry_address_1');
        $this->data['entry_address_2'] = $this->language->get('entry_address_2');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_postcode'] = $this->language->get('entry_postcode');
        $this->data['entry_zone'] = $this->language->get('entry_zone');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_default'] = $this->language->get('entry_default');
        $this->data['entry_comment'] = $this->language->get('entry_comment');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_amount'] = $this->language->get('entry_amount');
        $this->data['entry_points'] = $this->language->get('entry_points');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');
        $this->data['button_add_address'] = $this->language->get('button_add_address');
        $this->data['button_add_history'] = $this->language->get('button_add_history');
        $this->data['button_add_transaction'] = $this->language->get('button_add_transaction');
        $this->data['button_add_reward'] = $this->language->get('button_add_reward');
        $this->data['button_remove'] = $this->language->get('button_remove');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_address'] = $this->language->get('tab_address');
        $this->data['tab_history'] = $this->language->get('tab_history');
        $this->data['tab_transaction'] = $this->language->get('tab_transaction');
        $this->data['tab_reward'] = $this->language->get('tab_reward');
        $this->data['tab_ip'] = $this->language->get('tab_ip');

        $this->data['token'] = $this->session->data['token'];

        if (isset($this->request->get['customer_id'])) {
            $this->data['customer_id'] = $this->request->get['customer_id'];
        } else {
            $this->data['customer_id'] = 0;
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['firstname'])) {
            $this->data['error_firstname'] = $this->error['firstname'];
        } else {
            $this->data['error_firstname'] = '';
        }

        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }

        if (isset($this->error['email'])) {
            $this->data['error_email'] = $this->error['email'];
        } else {
            $this->data['error_email'] = '';
        }

        if (isset($this->error['telephone'])) {
            $this->data['error_telephone'] = $this->error['telephone'];
        } else {
            $this->data['error_telephone'] = '';
        }

        if (isset($this->error['password'])) {
            $this->data['error_password'] = $this->error['password'];
        } else {
            $this->data['error_password'] = '';
        }

        if (isset($this->error['confirm'])) {
            $this->data['error_confirm'] = $this->error['confirm'];
        } else {
            $this->data['error_confirm'] = '';
        }

        if (isset($this->error['address_firstname'])) {
            $this->data['error_address_firstname'] = $this->error['address_firstname'];
        } else {
            $this->data['error_address_firstname'] = '';
        }

        if (isset($this->error['address_lastname'])) {
            $this->data['error_address_lastname'] = $this->error['address_lastname'];
        } else {
            $this->data['error_address_lastname'] = '';
        }

        if (isset($this->error['address_tax_id'])) {
            $this->data['error_address_tax_id'] = $this->error['address_tax_id'];
        } else {
            $this->data['error_address_tax_id'] = '';
        }

        if (isset($this->error['address_address_1'])) {
            $this->data['error_address_address_1'] = $this->error['address_address_1'];
        } else {
            $this->data['error_address_address_1'] = '';
        }

        if (isset($this->error['address_city'])) {
            $this->data['error_address_city'] = $this->error['address_city'];
        } else {
            $this->data['error_address_city'] = '';
        }

        if (isset($this->error['address_postcode'])) {
            $this->data['error_address_postcode'] = $this->error['address_postcode'];
        } else {
            $this->data['error_address_postcode'] = '';
        }

        if (isset($this->error['address_country'])) {
            $this->data['error_address_country'] = $this->error['address_country'];
        } else {
            $this->data['error_address_country'] = '';
        }

        if (isset($this->error['address_zone'])) {
            $this->data['error_address_zone'] = $this->error['address_zone'];
        } else {
            $this->data['error_address_zone'] = '';
        }

        $url = '';

        if (isset($this->request->get['filter_name'])) {
            $url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_email'])) {
            $url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
        }

        if (isset($this->request->get['filter_customer_group_id'])) {
            $url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
        }

        if (isset($this->request->get['filter_status'])) {
            $url .= '&filter_status=' . $this->request->get['filter_status'];
        }

        if (isset($this->request->get['filter_approved'])) {
            $url .= '&filter_approved=' . $this->request->get['filter_approved'];
        }

        if (isset($this->request->get['filter_date_added'])) {
            $url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['customer_id'])) {
            $this->data['action'] = $this->url->link('sale/customer/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . $url, 'SSL');
        }

        $this->data['cancel'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . $url, 'SSL');

        if (isset($this->request->get['customer_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $customer_info = $this->model_sale_customer->getCustomer($this->request->get['customer_id']);
        }

        if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
        } elseif (!empty($customer_info)) {
            $this->data['firstname'] = $customer_info['firstname'];
        } else {
            $this->data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($customer_info)) {
            $this->data['lastname'] = $customer_info['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } elseif (!empty($customer_info)) {
            $this->data['email'] = $customer_info['email'];
        } else {
            $this->data['email'] = '';
        }

        if (isset($this->request->post['balance'])) {
            $this->data['balance'] = $this->request->post['balance'];
        } elseif (!empty($customer_info)) {
            $this->data['balance'] = $customer_info['money'];
        } else {
            $this->data['balance'] = '';
        }

        if (isset($this->request->post['score'])) {
            $this->data['score'] = $this->request->post['score'];
        } elseif (!empty($customer_info)) {
            $this->data['score'] = $customer_info['scores'];
        } else {
            $this->data['score'] = '';
        }

        if (isset($this->request->post['newsletter'])) {
            $this->data['newsletter'] = $this->request->post['newsletter'];
        } elseif (!empty($customer_info)) {
            $this->data['newsletter'] = $customer_info['newsletter'];
        } else {
            $this->data['newsletter'] = '';
        }

        $this->load->model('sale/customer_group');

        $this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

        if (isset($this->request->post['customer_group_id'])) {
            $this->data['customer_group_id'] = $this->request->post['customer_group_id'];
        } elseif (!empty($customer_info)) {
            $this->data['customer_group_id'] = $customer_info['customer_group_id'];
        } else {
            $this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
        }

        if (isset($this->request->post['status'])) {
            $this->data['status'] = $this->request->post['status'];
        } elseif (!empty($customer_info)) {
            $this->data['status'] = $customer_info['status'];
        } else {
            $this->data['status'] = 1;
        }

        if (isset($this->request->post['password'])) {
            $this->data['password'] = $this->request->post['password'];
        } else {
            $this->data['password'] = '';
        }

        if (isset($this->request->post['confirm'])) {
            $this->data['confirm'] = $this->request->post['confirm'];
        } else {
            $this->data['confirm'] = '';
        }

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        if (isset($this->request->post['address'])) {
            $this->data['addresses'] = $this->request->post['address'];
        } elseif (isset($this->request->get['customer_id'])) {
            $this->data['addresses'] = $this->model_sale_customer->getAddresses($this->request->get['customer_id']);
        } else {
            $this->data['addresses'] = array();
        }

        if (isset($this->request->post['address_id'])) {
            $this->data['address_id'] = $this->request->post['address_id'];
        } elseif (!empty($customer_info)) {
            $this->data['address_id'] = $customer_info['address_id'];
        } else {
            $this->data['address_id'] = '';
        }

        $this->data['ips'] = array();

        if (!empty($customer_info)) {
            $results = $this->model_sale_customer->getIpsByCustomerId($this->request->get['customer_id']);

            foreach ($results as $result) {
                $ban_ip_total = $this->model_sale_customer->getTotalBanIpsByIp($result['ip']);

                $this->data['ips'][] = array(
                    'ip' => $result['ip'],
                    'total' => $this->model_sale_customer->getTotalCustomersByIp($result['ip']),
                    'date_added' => date('d/m/y', strtotime($result['date_added'])),
                    'filter_ip' => $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_ip=' . $result['ip'], 'SSL'),
                    'ban_ip' => $ban_ip_total
                );
            }
        }

        $this->template = 'sale/customer_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }

        /*if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }*/

        if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }

        $customer_info = $this->model_sale_customer->getCustomerByEmail($this->request->post['email']);

        if (!isset($this->request->get['customer_id'])) {
            if ($customer_info) {
                $this->error['warning'] = $this->language->get('error_exists');
            }
        } else {
            if ($customer_info && ($this->request->get['customer_id'] != $customer_info['customer_id'])) {
                $this->error['warning'] = $this->language->get('error_exists');
            }
        }

        /*if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }*/

        if ($this->request->post['password'] || (!isset($this->request->get['customer_id']))) {
            if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
                $this->error['password'] = $this->language->get('error_password');
            }

            if ($this->request->post['password'] != $this->request->post['confirm']) {
                $this->error['confirm'] = $this->language->get('error_confirm');
            }
        }

        if (isset($this->request->post['address'])) {
            foreach ($this->request->post['address'] as $key => $value) {
                if ((utf8_strlen($value['firstname']) < 1) || (utf8_strlen($value['firstname']) > 32)) {
                    $this->error['address_firstname'][$key] = $this->language->get('error_firstname');
                }

                if ((utf8_strlen($value['lastname']) < 1) || (utf8_strlen($value['lastname']) > 32)) {
                    $this->error['address_lastname'][$key] = $this->language->get('error_lastname');
                }

                if ((utf8_strlen($value['address_details']) < 3) || (utf8_strlen($value['address_details']) > 128)) {
                    $this->error['address_address_1'][$key] = $this->language->get('error_address_1');
                }

                /*if ((utf8_strlen($value['city']) < 2) || (utf8_strlen($value['city']) > 128)) {
                    $this->error['address_city'][$key] = $this->language->get('error_city');
                }*/

                $this->load->model('localisation/country');

                $country_info = $this->model_localisation_country->getCountry($value['country_id']);

                if ($country_info) {
                    if ($country_info['postcode_required'] && (utf8_strlen($value['postcode']) < 2) || (utf8_strlen($value['postcode']) > 10)) {
                        $this->error['address_postcode'][$key] = $this->language->get('error_postcode');
                    }

                    // VAT Validation
                    $this->load->helper('vat');

                    if ($this->config->get('config_vat') && $value['tax_id'] && (vat_validation($country_info['iso_code_2'], $value['tax_id']) == 'invalid')) {
                        $this->error['address_tax_id'][$key] = $this->language->get('error_vat');
                    }
                }

                if ($value['country_id'] == '') {
                    $this->error['address_country'][$key] = $this->language->get('error_country');
                }

                if (!isset($value['zone_id']) || $value['zone_id'] == '') {
                    $this->error['address_zone'][$key] = $this->language->get('error_zone');
                }
            }
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    protected function validateDelete() {
        if (!$this->user->hasPermission('modify', 'sale/customer')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function login() {
        $json = array();

        if (isset($this->request->get['customer_id'])) {
            $customer_id = $this->request->get['customer_id'];
        } else {
            $customer_id = 0;
        }

        $this->load->model('sale/customer');

        $customer_info = $this->model_sale_customer->getCustomer($customer_id);

        if ($customer_info) {
            $token = md5(mt_rand());

            $this->model_sale_customer->editToken($customer_id, $token);

            if (isset($this->request->get['store_id'])) {
                $store_id = $this->request->get['store_id'];
            } else {
                $store_id = 0;
            }

            $this->load->model('setting/store');

            $store_info = $this->model_setting_store->getStore($store_id);

            if ($store_info) {
                $this->redirect($store_info['url'] . 'index.php?route=account/login&token=' . $token);
            } else {
                $this->redirect(HTTP_CATALOG . 'index.php?route=account/login&token=' . $token);
            }
        } else {
            $this->language->load('error/not_found');

            $this->document->setTitle($this->language->get('heading_title'));

            $this->data['heading_title'] = $this->language->get('heading_title');

            $this->data['text_not_found'] = $this->language->get('text_not_found');

            $this->data['breadcrumbs'] = array();

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_home'),
                'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => false
            );

            $this->data['breadcrumbs'][] = array(
                'text' => $this->language->get('heading_title'),
                'href' => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
                'separator' => ' :: '
            );

            $this->template = 'error/not_found.tpl';
            $this->children = array(
                'common/header',
                'common/footer'
            );

            $this->response->setOutput($this->render());
        }
    }

    public function history() {
        $this->language->load('sale/customer');

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) {
            $this->model_sale_customer->addHistory($this->request->get['customer_id'], $this->request->post['comment']);

            $this->data['success'] = $this->language->get('text_success');
        } else {
            $this->data['success'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
            $this->data['error_warning'] = $this->language->get('error_permission');
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_comment'] = $this->language->get('column_comment');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['histories'] = array();

        $results = $this->model_sale_customer->getHistories($this->request->get['customer_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $this->data['histories'][] = array(
                'comment' => $result['comment'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $transaction_total = $this->model_sale_customer->getTotalHistories($this->request->get['customer_id']);

        $pagination = new Pagination();
        $pagination->total = $transaction_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/customer/history', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'sale/customer_history.tpl';

        $this->response->setOutput($this->render());
    }

    public function transaction() {
        $this->language->load('sale/customer');

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) {
            $this->model_sale_customer->addTransaction($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['amount']);

            $this->data['success'] = $this->language->get('text_success');
        } else {
            $this->data['success'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
            $this->data['error_warning'] = $this->language->get('error_permission');
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_balance'] = $this->language->get('text_balance');

        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_description'] = $this->language->get('column_description');
        $this->data['column_amount'] = $this->language->get('column_amount');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['transactions'] = array();

        $results = $this->model_sale_customer->getTransactions($this->request->get['customer_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $this->data['transactions'][] = array(
                'amount' => $this->currency->format($result['amount'], $this->config->get('config_currency')),
                'description' => $result['description'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $this->data['balance'] = $this->currency->format($this->model_sale_customer->getTransactionTotal($this->request->get['customer_id']), $this->config->get('config_currency'));

        $transaction_total = $this->model_sale_customer->getTotalTransactions($this->request->get['customer_id']);

        $pagination = new Pagination();
        $pagination->total = $transaction_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/customer/transaction', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'sale/customer_transaction.tpl';

        $this->response->setOutput($this->render());
    }

    public function reward() {
        $this->language->load('sale/customer');

        $this->load->model('sale/customer');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->user->hasPermission('modify', 'sale/customer')) {
            $this->model_sale_customer->addReward($this->request->get['customer_id'], $this->request->post['description'], $this->request->post['points']);

            $this->data['success'] = $this->language->get('text_success');
        } else {
            $this->data['success'] = '';
        }

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && !$this->user->hasPermission('modify', 'sale/customer')) {
            $this->data['error_warning'] = $this->language->get('error_permission');
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['text_no_results'] = $this->language->get('text_no_results');
        $this->data['text_balance'] = $this->language->get('text_balance');

        $this->data['column_date_added'] = $this->language->get('column_date_added');
        $this->data['column_description'] = $this->language->get('column_description');
        $this->data['column_points'] = $this->language->get('column_points');

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $this->data['rewards'] = array();

        $results = $this->model_sale_customer->getRewards($this->request->get['customer_id'], ($page - 1) * 10, 10);

        foreach ($results as $result) {
            $this->data['rewards'][] = array(
                'points' => $result['points'],
                'description' => $result['description'],
                'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
            );
        }

        $this->data['balance'] = $this->model_sale_customer->getRewardTotal($this->request->get['customer_id']);

        $reward_total = $this->model_sale_customer->getTotalRewards($this->request->get['customer_id']);

        $pagination = new Pagination();
        $pagination->total = $reward_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('sale/customer/reward', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['customer_id'] . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'sale/customer_reward.tpl';

        $this->response->setOutput($this->render());
    }

    public function addBanIP() {
        $this->language->load('sale/customer');

        $json = array();

        if (isset($this->request->post['ip'])) {
            if (!$this->user->hasPermission('modify', 'sale/customer')) {
                $json['error'] = $this->language->get('error_permission');
            } else {
                $this->load->model('sale/customer');

                $this->model_sale_customer->addBanIP($this->request->post['ip']);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function removeBanIP() {
        $this->language->load('sale/customer');

        $json = array();

        if (isset($this->request->post['ip'])) {
            if (!$this->user->hasPermission('modify', 'sale/customer')) {
                $json['error'] = $this->language->get('error_permission');
            } else {
                $this->load->model('sale/customer');

                $this->model_sale_customer->removeBanIP($this->request->post['ip']);

                $json['success'] = $this->language->get('text_success');
            }
        }

        $this->response->setOutput(json_encode($json));
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sale/customer');

            $data = array(
                'filter_name' => $this->request->get['filter_name'],
                'start' => 0,
                'limit' => 20
            );

            $results = $this->model_sale_customer->getCustomers($data);

            foreach ($results as $result) {
                $json[] = array(
                    'customer_id' => $result['customer_id'],
                    //'customer_group_id' => $result['customer_group_id'],
                    //'name' => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
                    'customer_group' => $result['customer_group'],
                    'firstname' => $result['firstname'],
                    //'lastname' => $result['lastname'],
                    'email' => $result['email'],
                    //'telephone' => $result['telephone'],
                    //'fax' => $result['fax'],
                    'address' => $this->model_sale_customer->getAddresses($result['customer_id'])
                );
            }
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['firstname'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->setOutput(json_encode($json));
    }

    public function country() {
        $json = array();

        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

        if ($country_info) {
            $this->load->model('localisation/zone');

            $json = array(
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'address_format' => $country_info['address_format'],
                'postcode_required' => $country_info['postcode_required'],
                'zone' => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
                'status' => $country_info['status']
            );
        }

        $this->response->setOutput(json_encode($json));
    }

    public function address() {
        $json = array();

        if (!empty($this->request->get['address_id'])) {
            $this->load->model('sale/customer');

            $json = $this->model_sale_customer->getAddress($this->request->get['address_id']);
        }

        $this->response->setOutput(json_encode($json));
    }

    public function editUser() {
    $this->load->model('sale/customer');
        $this->model_sale_customer->editCustomer($this->request->post['customer_id'], $this->request->post);
        $this->response->setOutput(json_encode('1'));
    }

}

?>