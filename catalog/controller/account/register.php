<?php

class ControllerAccountRegister extends Controller {

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


        if ($this->customer->isLogged()) {
            $this->redirect($this->url->link('order/order', '', 'SSL'));
        }

        //模版赋值
        $this->language->load('account/register');


        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));

        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();

        $this->data['text_fashionPlate'] = $this->language->get('text_fashionPlate');
        $this->data['text_traditional'] = $this->language->get('text_traditional');
        $this->data['text_registration'] = $this->language->get('text_registration');
        $this->data['text_address'] = $this->language->get('text_address');
        $this->data['text_nickname'] = $this->language->get('text_nickname');
        $this->data['text_Password'] = $this->language->get('text_Password');
        $this->data['text_Confirm'] = $this->language->get('text_Confirm');
        $this->data['text_code'] = $this->language->get('text_code');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_change'] = $this->language->get('text_change');
        $this->data['text_Agreemen'] = $this->language->get('text_Agreemen');
        $this->data['text_submit'] = $this->language->get('text_submit');
        $this->data['text_integral'] = $this->language->get('text_integral');
        $this->data['text_login'] = $this->language->get('text_login');
        $this->data['text_share'] = $this->language->get('text_share');
        $this->data['text_say'] = $this->language->get('text_say');
        $this->data['text_click'] = $this->language->get('text_click');

        /*
          $this->document->setTitle($this->language->get('heading_title'));
          $this->document->addScript('catalog/view/javascript/jquery/colorbox/jquery.colorbox-min.js');
          $this->document->addStyle('catalog/view/javascript/jquery/colorbox/colorbox.css');
         */

        $this->load->model('account/customer');
        $this->load->model('account/record');


        if (isset($this->request->get['u'])) {
            $this->data['u'] = $this->request->get['u'] - 9999;
        }
        if (isset($this->request->get['ReturnUrl'])) {
            $this->data['ReturnUrl'] = $this->request->get['ReturnUrl'];
        }
      
	  if(isset($this->request->get['pid'])){
					$pid=$this->request->get['pid'];
					$url="http://www.acgstorm.com/tn=".$pid;
					$uid= $this->model_account_customer->getPromotionPerson($url);
					$this->session->data['PromotionPerson']=$uid;
			}
		
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {//注册成功POST
            if (isset($this->request->post['uhid'])) {
                $this->session->data['u'] = $this->request->post['uhid'];
            }
            //var_dump($this->request->post);
            //第三方授权登录时的唯一标识 add by fc
            /* if (isset($this->request->post['oauthuid']))
              $this->data['oauthuid'] = $this->request->post['oauthuid'];
              else
              $this->request->post['oauthuid'] = ""; */
				
            if (isset($this->request->post['face'])){
                $this->data['face'] = $this->request->post['face'];
            }else{
                $this->request->post['face'] = "";
            }
            if (isset($this->session->data['oauthuid'])){
                $this->request->post['oauthuid'] = $this->session->data['oauthuid'];
            }else{
                $this->request->post['oauthuid'] = '';
            }


            $this->request->post['telephone'] = '';
            $this->request->post['fax'] = '';
            $this->request->post['company'] = '';
            $this->request->post['address_1'] = '';
            $this->request->post['address_2'] = '';
            $this->request->post['city'] = '';
            $this->request->post['postcode'] = '518100';
            $this->request->post['company_id'] = '';
            $this->request->post['tax_id'] = '';
            $this->request->post['country_id'] = 44;
            $this->request->post['zone_id'] = 689;

            $ip = $this->request->server ['REMOTE_ADDR'];
            $info = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
            $info = json_decode($info, true);
            if ($info ['code'] == 0) {
                $country = $info ['data'] ['country'];
            } else {
                $country = '';
            }
            $this->request->post['country'] = $country;


            if (isset($this->session->data['from']))
                $this->request->post['from'] = $this->session->data['from'];
            else
                $this->request->post['from'] = '';

            if (isset($this->request->post['tname']))
                $this->data['tname'] = $this->request->post['tname'];
            else
                $this->request->post['tname'] = '';

            $this->model_account_customer->addCustomer($this->request->post);//添加用户至Customer表
		
            $this->customer->login($this->request->post['email'], $this->request->post['password']);
		
            unset($this->session->data['guest']);
			
			
            // Default Shipping Address
            if ($this->config->get('config_tax_customer') == 'shipping') {
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                $this->session->data['shipping_postcode'] = $this->request->post['postcode'];
            }

            // Default Payment Address
            if ($this->config->get('config_tax_customer') == 'payment') {
                $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];
            }
				if(isset($this->session->data['PromotionPerson'])){
					 $this->model_account_customer->setPromotionPerson($this->session->data['PromotionPerson'],$this->customer->getId());
				}
            //注册送积分
            $this->model_account_customer->editScores(200);
            //增加送积分记录
            $insert_score_record = array(
                'uid' => $this->customer->getId(),
                'firstname' => $this->customer->getFirstName(),
                'remark' => '新用户注册送200积分',
                'score' => '+200',
                'type' => '1',
                'totalscore' => 200
            );
	
            $this->model_account_record->addScoreRecord($insert_score_record);
		
            if ($_COOKIE['runUrl']) {
                $this->redirect('/order-snatch.html');
            } else {
                $this->redirect($this->url->link('account/success'));
            }
        }
        
        //---------------------------------注册页面--------------------------------------------------------------------------------------------

        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_account'),
            'href' => $this->url->link('account/account', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_register'),
            'href' => $this->url->link('account/register', '', 'SSL'),
            'separator' => $this->language->get('text_separator')
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
        $this->data['text_your_details'] = $this->language->get('text_your_details');
        $this->data['text_your_address'] = $this->language->get('text_your_address');
        $this->data['text_your_password'] = $this->language->get('text_your_password');
        $this->data['text_newsletter'] = $this->language->get('text_newsletter');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_select'] = $this->language->get('text_select');
        $this->data['text_none'] = $this->language->get('text_none');

        $this->data['entry_firstname'] = $this->language->get('entry_firstname');
        $this->data['entry_lastname'] = $this->language->get('entry_lastname');
        $this->data['entry_email'] = $this->language->get('entry_email');
        $this->data['entry_telephone'] = $this->language->get('entry_telephone');
        $this->data['entry_fax'] = $this->language->get('entry_fax');
        $this->data['entry_company'] = $this->language->get('entry_company');
        $this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
        $this->data['entry_company_id'] = $this->language->get('entry_company_id');
        $this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
        $this->data['entry_address_1'] = $this->language->get('entry_address_1');
        $this->data['entry_address_2'] = $this->language->get('entry_address_2');
        $this->data['entry_postcode'] = $this->language->get('entry_postcode');
        $this->data['entry_city'] = $this->language->get('entry_city');
        $this->data['entry_country'] = $this->language->get('entry_country');
        $this->data['entry_zone'] = $this->language->get('entry_zone');
        $this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
        $this->data['entry_password'] = $this->language->get('entry_password');
        $this->data['entry_confirm'] = $this->language->get('entry_confirm');

        $this->data['button_continue'] = $this->language->get('button_continue');

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

        if (isset($this->error['company_id'])) {
            $this->data['error_company_id'] = $this->error['company_id'];
        } else {
            $this->data['error_company_id'] = '';
        }

        if (isset($this->error['tax_id'])) {
            $this->data['error_tax_id'] = $this->error['tax_id'];
        } else {
            $this->data['error_tax_id'] = '';
        }

        if (isset($this->error['address_1'])) {
            $this->data['error_address_1'] = $this->error['address_1'];
        } else {
            $this->data['error_address_1'] = '';
        }

        if (isset($this->error['city'])) {
            $this->data['error_city'] = $this->error['city'];
        } else {
            $this->data['error_city'] = '';
        }

        if (isset($this->error['postcode'])) {
            $this->data['error_postcode'] = $this->error['postcode'];
        } else {
            $this->data['error_postcode'] = '';
        }

        if (isset($this->error['country'])) {
            $this->data['error_country'] = $this->error['country'];
        } else {
            $this->data['error_country'] = '';
        }

        if (isset($this->error['zone'])) {
            $this->data['error_zone'] = $this->error['zone'];
        } else {
            $this->data['error_zone'] = '';
        }

       // $this->data['action'] = $this->url->link('account/register', '', 'SSL');
	   $this->data['action'] = '/index.php?route=account/register';

        if (isset($this->request->post['firstname'])) {
            $this->data['firstname'] = $this->request->post['firstname'];
        } else {
            $this->data['firstname'] = '';
        }

        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        if (isset($this->request->post['email'])) {
            $this->data['email'] = $this->request->post['email'];
        } else {
            $this->data['email'] = '';
        }

        if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
        } else {
            $this->data['telephone'] = '';
        }

        if (isset($this->request->post['fax'])) {
            $this->data['fax'] = $this->request->post['fax'];
        } else {
            $this->data['fax'] = '';
        }

        if (isset($this->request->post['company'])) {
            $this->data['company'] = $this->request->post['company'];
        } else {
            $this->data['company'] = '';
        }

        $this->load->model('account/customer_group');

        $this->data['customer_groups'] = array();

        if (is_array($this->config->get('config_customer_group_display'))) {
            $customer_groups = $this->model_account_customer_group->getCustomerGroups();

            foreach ($customer_groups as $customer_group) {
                if (in_array($customer_group['customer_group_id'], $this->config->get('config_customer_group_display'))) {
                    $this->data['customer_groups'][] = $customer_group;
                }
            }
        }

        if (isset($this->request->post['customer_group_id'])) {
            $this->data['customer_group_id'] = $this->request->post['customer_group_id'];
        } else {
            $this->data['customer_group_id'] = $this->config->get('config_customer_group_id');
        }

        // Company ID
        if (isset($this->request->post['company_id'])) {
            $this->data['company_id'] = $this->request->post['company_id'];
        } else {
            $this->data['company_id'] = '';
        }

        // Tax ID
        if (isset($this->request->post['tax_id'])) {
            $this->data['tax_id'] = $this->request->post['tax_id'];
        } else {
            $this->data['tax_id'] = '';
        }

        if (isset($this->request->post['address_1'])) {
            $this->data['address_1'] = $this->request->post['address_1'];
        } else {
            $this->data['address_1'] = '';
        }

        if (isset($this->request->post['address_2'])) {
            $this->data['address_2'] = $this->request->post['address_2'];
        } else {
            $this->data['address_2'] = '';
        }

        if (isset($this->request->post['postcode'])) {
            $this->data['postcode'] = $this->request->post['postcode'];
        } elseif (isset($this->session->data['shipping_postcode'])) {
            $this->data['postcode'] = $this->session->data['shipping_postcode'];
        } else {
            $this->data['postcode'] = '';
        }

        if (isset($this->request->post['city'])) {
            $this->data['city'] = $this->request->post['city'];
        } else {
            $this->data['city'] = '';
        }

        if (isset($this->request->post['country_id'])) {
            $this->data['country_id'] = $this->request->post['country_id'];
        } elseif (isset($this->session->data['shipping_country_id'])) {
            $this->data['country_id'] = $this->session->data['shipping_country_id'];
        } else {
            $this->data['country_id'] = $this->config->get('config_country_id');
        }

        if (isset($this->request->post['zone_id'])) {
            $this->data['zone_id'] = $this->request->post['zone_id'];
        } elseif (isset($this->session->data['shipping_zone_id'])) {
            $this->data['zone_id'] = $this->session->data['shipping_zone_id'];
        } else {
            $this->data['zone_id'] = '';
        }

        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

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

        if (isset($this->request->post['newsletter'])) {
            $this->data['newsletter'] = $this->request->post['newsletter'];
        } else {
            $this->data['newsletter'] = '';
        }


        $this->data['text_agree'] = $this->language->get('text_agree');

        if (isset($this->request->post['agree'])) {
            $this->data['agree'] = $this->request->post['agree'];
        } else {
            $this->data['agree'] = false;
        }
        if (isset($this->request->get['nick'])) {
            $this->data['nick'] = $this->request->get['nick'];
        } else {
            $this->data['nick'] = "";
        }
        if (isset($this->request->get['oauthuid'])) {
            $this->data['oauthuid'] = $this->request->get['oauthuid'];
        } else {
            $this->data['oauthuid'] = "";
        }

		 if (isset($this->request->get['face'])) {
            $this->data['face'] = $this->request->get['face'];
        } else {
            $this->data['face'] = "";
        }
		
        //网站评论
        $this->load->model('order/sendorder');
        $limit = 3;
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

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/register.tpl';
        } else {
            $this->template = 'default/template/account/register.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_cart'
        );

        $this->response->setOutput($this->render());
    }

    protected function validate() {

        if (isset($this->request->post['firstname']) && ( (utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32) )) {
            $this->error['firstname'] = $this->language->get('error_firstname');
        }

        $this->request->post['lastname'] = '';
        if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
            $this->error['email'] = $this->language->get('error_email');
        }



        if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
            $this->error['warning'] = $this->language->get('error_exists');
        }

        if (isset($this->request->post['firstname']) && $this->model_account_customer->getTotalCustomersByFirstname($this->request->post['firstname'])) {
            $this->error['warning'] = $this->language->get('error_exists_firstname');
        }

        if (isset($this->request->post['password']) && (utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
            $this->error['password'] = $this->language->get('error_password');
        }

        if (isset($this->request->post['confirm']) && isset($this->request->post['password']) && ($this->request->post['confirm'] != $this->request->post['password'])) {
            $this->error['confirm'] = $this->language->get('error_confirm');
        }

        if ($this->config->get('config_account_id')) {
            $this->load->model('catalog/information');

            $information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));

            if ($information_info && !isset($this->request->post['agree'])) {
                $this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
            }
        }
        //var_dump($this->error);
        if (!$this->error) {
            return true;
        } else {
            return false;
        }
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

    public function checkemail() {


        if (isset($this->request->post['email']) && $this->request->post['email']) {

            $email = $this->request->post['email'];

            $this->load->model('account/customer');

            $result = $this->model_account_customer->getTotalCustomersByEmail($email);

            if($result) {
               $this->response->setOutput(json_encode(1));
				
            }else{

                $this->response->setOutput(json_encode(0));
            }
        }
    }

    public function checkfirstname() {
        if (isset($this->request->post['firstname']) && $this->request->post['firstname']) {

            $firstname = $this->request->post['firstname'];

            $this->load->model('account/customer');

            $result = $this->model_account_customer->getTotalCustomersByFirstname($firstname);

            if ($result) {
                $this->response->setOutput(json_encode(1));
            } else {
                $this->response->setOutput(json_encode(0));
            }
        }
    }
	
	public function checkpwd(){

	
		if(isset($this->request->post['oldpwd']) && $this->request->post['oldpwd']) {
            
            $oldpwd = $this->request->post['oldpwd'];
            
            $this->load->model('account/customer');
            
            $res_oldpwd = $this->model_account_customer->checkCustomersPwd();
       
			$Salt=$this->model_account_customer->getCustomerSalt();

            if($res_oldpwd == sha1($Salt . sha1($Salt . sha1($oldpwd)))){
               $this->response->setOutput(json_encode(1));
            }else{
              $this->response->setOutput(json_encode(0));	
            }
        }
	}

	public function sendRegPwdEmail(){
	header('Content-type:text/html;charset=utf-8');
	$subject = "CNstorm密码重置邮件";
	
	if (isset($this->request->get['email'])){
		 $customer_email = $this->request->get['email'];
	}else{
		 $customer_email = "";
	}
	$code= base64_encode($customer_email);
	$now=time();
	$expire_time=$now+3600*24;
	$vcode=md5($now);
	$questTime=date('Y-m-d H:i:s',$now);
		$message=<<<Email
<table cellspacing="0" cellpadding="0" align="center" style="width:640px; margin: 30px auto auto auto;">
                        <tbody>
                            <tr>
                                <td>
                                    <table align="center" cellspacing="0" cellpadding="0">
                                        <tbody>
                                          
                                            <tr>
                                                <td style="background-color:#fff; padding: 40px 40px 0;">
                                                    <h4 style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">亲爱的信恩世通用户，您好！</h4>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color:#fff; padding: 0px 40px 0;">
												  <p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">您在{$questTime}提交了密码重置的请求</br> 请在24小时能点击下面的链接重设您的密码</p>
												  
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="center" style="background-color:#fff; padding: 30px 40px;">
                                                    <a href="http://www.acgstorm.com/account-modifypd.html&code=$code&vcode=$vcode" target="_blank" style="display:block;height:50px;width:572px;background-color:#0088cc;font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;font-weight:normal;font-size:20px;color:white;line-height:50px;text-align:center;text-decoration:none;border-radius:3px;">重置密码</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color:#fff; padding: 0px 40px 0;">
                                                    <p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">如果按钮无法点击，请点击下面的链接进行重置</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color:#fff; padding: 0px 40px 0;word-break:break-all;">
                                                    <a href="http://www.acgstorm.com/account-modifypd.html&code=$code&vcode=$vcode" target="_blank" style="display:block;margin-top:5px;padding-bottom:40px;font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#0390ff;font-weight:normal;font-size:18px;text-decoration:none;">http://www.acgstorm.com/account-modifypd.html&code=$code&vcode=$vcode</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="background-color:#fff; padding: 0px 40px 0;word-break:break-all;">
                                                    <p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#838383; font-size:14px; padding-bottom:20px">请注意：为了安全起见，重置链接在自发送之时起24小时后过期。</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p style="color: #a0a0a0; font-size:13px; margin: 10px 0;">如果您在使用中有任何的疑问或者建议，欢迎反馈我们意见至邮件：<a href="mailto:support@teambition.com" style="color: #a0a0a0;">support@cnstorm.com</a>
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
Email;



	$sql="select id from oc_customer_rspwd_url_expire where email='".$customer_email."' and type=0 ";
		$row=$this->db->query($sql);
		if($row->num_rows > 1){  //延迟邮件 或重复邮件
			foreach($row->rows as $v){
				$sql="update oc_customer_rspwd_url_expire  set type=1 where id=".$v['id'];
				$this->db->query($sql);
			}
		}

	$sql="INSERT INTO oc_customer_rspwd_url_expire set expire_time=	$expire_time,random_md5='$vcode', email='$customer_email'";
	$this->db->query($sql);

	$sql="select firstname from oc_customer where email='".$customer_email ."'";
	$resource=$this->db->query($sql);
	$customer_name =$resource->row['firstname'];
	$data = array(
		'sendto' => $customer_email,
		'receiver' => $customer_name,
		'subject' => $subject,
		'msg' => $message,
	);

 $this->load->model('tool/sendmail');
 $a=$this->model_tool_sendmail->send($data);
 echo $a;
	}
	
	public function newForget(){
		   $this->template = $this->config->get('config_template') . '/template/account/newForget.tpl';
		   
		      $this->response->setOutput($this->render());
		   
	}
}
?>