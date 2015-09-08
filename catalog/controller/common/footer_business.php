<?php

class ControllerCommonFooterBusiness extends Controller {

    protected function index() {        
		//语言转换
		if (isset($this->session->data['language'])){
			$this->data['status'] = $this->session->data['language'];
			$this->data['curUrl'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			if (isset($this->request->get['l']) && $this->request->get['l'] == "en"){
				//var_dump($_SERVER['HTTP_REFERER']);exit('cn');
				$this->session->data['language'] = 'en';
				if ( isset($_SERVER['HTTP_REFERER']) ) $this->redirect($_SERVER['HTTP_REFERER']);
			}else if (isset($this->request->get['l']) && $this->request->get['l'] == "cn"){
				//var_dump($_SERVER['HTTP_REFERER']);exit('en');
				$this->session->data['language'] = 'cn';
				if ( isset($_SERVER['HTTP_REFERER']) ) $this->redirect($_SERVER['HTTP_REFERER']);
			}
		}

		//语言部分
		$this->language->load('common/footer_business');
		$this->data['text_help'] = $this->language->get('text_help');
		$this->data['text_contactUs'] = $this->language->get('text_contactUs');
		$this->data['text_freight'] = $this->language->get('text_freight');
		$this->data['text_safety'] = $this->language->get('text_safety');
		$this->data['text_mobileApplication'] = $this->language->get('text_mobileApplication');
		$this->data['text_shopping'] = $this->language->get('text_shopping');
		$this->data['text_english'] = $this->language->get('text_english');
		$this->data['text_about'] = $this->language->get('text_about');
		$this->data['text_personalConsumption'] = $this->language->get('text_personalConsumption');
		$this->data['text_jobChance'] = $this->language->get('text_jobChance');
		$this->data['text_siteMap'] = $this->language->get('text_siteMap');
		$this->data['text_useGuide'] = $this->language->get('text_useGuide');
		$this->data['text_cooperation'] = $this->language->get('text_cooperation');
		$this->data['text_feedBack'] = $this->language->get('text_feedBack');
		$this->data['text_copyright'] = $this->language->get('text_copyright');
		$this->data['text_privacy'] = $this->language->get('text_privacy');
		$this->data['text_agreement'] = $this->language->get('text_agreement');
		$this->data['text_tips'] = $this->language->get('text_tips');

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer_business.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/footer_business.tpl';
        } else {
            $this->template = 'default/template/common/footer_business.tpl';
        }

        $this->render();
    }
}
?>