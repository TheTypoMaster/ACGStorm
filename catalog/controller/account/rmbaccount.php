<?php

/**
 * ControllerAccountrmbaccount
 * 
 * @package   
 * @author kennewei
 * @copyright www.acgstorm.com
 * @version 2014-06-29 v1.0
 * 
 */
 
class ControllerAccountrmbaccount extends Controller
{

    public function index()
    {
        if (!$this->customer->isLogged())
        {
            $this->session->data['redirect'] = $this->url->link('account/rmbaccount', '','SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
         
        //模版赋值
        $this->language->load('account/rmbaccount');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));
        
        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();
        
        $this->data['rmbaccount'] =  $this->language->get('text_rmbaccount');
        $this->data['rechargerecord'] = $this->language->get('text_rmbaccount_rechargerecord');
        $this->data['allrecord'] = $this->language->get('text_rmbaccount_allrecord');
        $this->data['onemonth'] = $this->language->get('text_rmbaccount_onemonth');
        $this->data['threemonths'] = $this->language->get('text_rmbaccount_threemonths');
        $this->data['halfyear'] = $this->language->get('text_rmbaccount_halfyear');
        $this->data['oneyear'] = $this->language->get('text_rmbaccount_oneyear');
        $this->data['number'] = $this->language->get('text_rmbaccount_number');
        $this->data['addtime'] = $this->language->get('text_rmbaccount_addtime');
        $this->data['type'] = $this->language->get('text_rmbaccount_type');
        $this->data['rechargemoney'] = $this->language->get('text_rmbaccount_rechargemoney');
        $this->data['money'] = $this->language->get('text_rmbaccount_money');
        $this->data['status'] = $this->language->get('text_rmbaccount_status');
        $this->data['success'] = $this->language->get('text_rmbaccount_success');
        $this->data['failed'] = $this->language->get('text_rmbaccount_failed');
        //

        if (isset($this->request->get['page']))
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $url = '';



        $this->data['onlinecharge'] = $this->url->link('account/rmbaccount/onlinecharge','', 'SSL');

        $this->load->model('account/rechargerecord');

        $limit = 20;

        $data = array('start' => ($page - 1) * $limit, 'limit' => $limit);


        $recharge_info = $this->model_account_rechargerecord->getrechargerecord($data);

        $recharge_total = $this->model_account_rechargerecord->getTotalRechargerecord();

        $pagination = new Pagination();

        $pagination->total = $recharge_total;

        $pagination->page = $page;

        $pagination->limit = $limit;

        $pagination->url = $this->url->link('account/rmbaccount', $url . '&page={page}');

        $this->data['pagination'] = $pagination->render();


        $this->data['recharge_info'] = $recharge_info;

       
        $this->template = 'cnstorm/template/account/rmbaccount_business.tpl';
        
        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/account/rmbaccount_business_list.tpl';
        }
		/*
        $this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
			*/
		  $this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);       
        $this->response->setOutput($this->render());
    }


    public function onlinecharge()
    {
        if (!$this->customer->isLogged())
        {
            $this->session->data['redirect'] = $this->url->link('account/onlinecharge', '',
                'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
         //模版赋值
        $this->language->load('account/onlinecharge');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));
        
        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();
        
        $this->data['choose'] =  $this->language->get('text_onlinecharge_choose');
        $this->data['paypal'] = $this->language->get('text_onlinecharge_paypal');
        $this->data['alipay'] = $this->language->get('text_onlinecharge_alipay');
        $this->data['credit'] = $this->language->get('text_onlinecharge_credit');
        $this->data['bank'] = $this->language->get('text_onlinecharge_bank');
        $this->data['nowpaypal'] = $this->language->get('text_onlinecharge_nowpaypal');
        $this->data['nowalipay'] = $this->language->get('text_onlinecharge_nowalipay');
        $this->data['nowcredit'] = $this->language->get('text_onlinecharge_nowcredit');
        $this->data['nowbank'] = $this->language->get('text_onlinecharge_nowbank');
        $this->data['amount'] = $this->language->get('text_onlinecharge_amount');
        $this->data['account'] = $this->language->get('text_onlinecharge_account');
        $this->data['button'] = $this->language->get('text_onlinecharge_button');
        $this->data['rate'] = $this->language->get('text_onlinecharge_rate');
        $this->data['compare'] = $this->language->get('text_onlinecharge_compare');
        $this->data['paypal_info'] = $this->language->get('text_onlinecharge_paypal_info');
        $this->data['alipay_info'] = $this->language->get('text_onlinecharge_alipay_info');
        $this->data['credit_info'] = $this->language->get('text_onlinecharge_credit_info');
        $this->data['dollar'] = $this->language->get('text_onlinecharge_dollar');
        $this->data['rmb'] = $this->language->get('text_onlinecharge_rmb');
        $this->data['paypal_loss'] = $this->language->get('text_onlinecharge_paypal_loss');
        $this->data['alipay_loss'] = $this->language->get('text_onlinecharge_alipay_loss');
        $this->data['credit_loss'] = $this->language->get('text_onlinecharge_credit_loss');
        //question
        $this->data['commonquestion'] = $this->language->get('onlinecharge_commonquestion');
        $this->data['question1'] = $this->language->get('onlinecharge_question1');
        $this->data['answer1'] = $this->language->get('onlinecharge_answer1');
        $this->data['question2'] = $this->language->get('onlinecharge_question2');
        $this->data['answer2'] = $this->language->get('onlinecharge_answer2');
        $this->data['question3'] = $this->language->get('onlinecharge_question3');
        $this->data['answer3_1'] = $this->language->get('onlinecharge_answer3_1');
        $this->data['answer3_2'] = $this->language->get('onlinecharge_answer3_2');
        //
 
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_rmbaccount'),
            'href' => $this->url->link('account/rmbaccount'),
            'separator' => false);

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_onlinecharge'),
            'href' => $this->url->link('account/onlinecharge/onlinecharge', '', 'SSL'),
            'separator' => $this->language->get('text_separator'));


        $this->load->model('localisation/currency');

        $currency_value = $this->currency->getValue("CNY");
        
        $this->data['rate'] = $currency_value;
       
        $this->data['action'] = $this->url->link('payment/pp_standard/recharge');
       

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/onlinerecharge.tpl'))
        {
            $this->template = $this->config->get('config_template') . '/template/account/onlinerecharge.tpl';
        }
        else
        {
            $this->template = 'default/template/account/onlinerecharge.tpl';
        }

        
        
        $this->template = 'cnstorm/template/account/topup_business.tpl';

        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business');
       

        $this->response->setOutput($this->render());
    }


}

?>