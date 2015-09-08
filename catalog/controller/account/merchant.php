<?php

class ControllerAccountMerchant extends Controller {

    public function index() {
	if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/merchant', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        $this->data['customer_name'] = $this->customer->getFirstname();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/merchant.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/merchant.tpl';
        } else {
            $this->template = 'default/template/account/merchant.tpl';
        }

        $this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
        $this->response->setOutput($this->render());
    }

    public function apply() {
    	if ($this->request->post){
	        $this->load->model('account/merchant');

	        if (isset($this->request->post['biz_type'])) {
	            $biz_type = $this->request->post['biz_type'];
	        } else {
	            $biz_type = '';
	        }

	        if (isset($this->request->post['company_industry'])) {
	            $company_industry = $this->request->post['company_industry'];
	        } else {
	            $company_industry = '';
	        }

	        if (isset($this->request->post['website_url'])) {
	            $website_url = $this->request->post['website_url'];
	        } else {
	            $website_url = '';
	        }
	        if (isset($this->request->post['loc'])) {
	            $loc = $this->request->post['loc'];
	        } else {
	            $loc = array();
	        }
		$loc = implode(",", $loc);

	        $customer_name = $this->customer->getFirstname();
	        $this->data['customer_name'] = $customer_name;

	        $merchant = array('customer_name' => $customer_name,
	            'biz_type' => $biz_type,
	            'company_industry' => $company_industry,
	            'website_url' => $website_url,
	            'loc' => $loc,
	            'time' => time());
	        $mer_apply = $this->model_account_merchant->addApply($merchant);
	}
	$this->redirect($this->url->link('account/merchant', '', 'SSL'));
        /*if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/merchant.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/merchant.tpl';
        } else {
            $this->template = 'default/template/account/merchant.tpl';
        }

    	$this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
    	$this->response->setOutput($this->render());*/
    }

}

?>