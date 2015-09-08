<?php

class ControllerCommonHeaderBusiness extends Controller {

    protected function index() {
        //语言部分
        $this->language->load('common/header_business');
        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_serviceAndPrice'] = $this->language->get('text_serviceAndPrice');
        $this->data['text_mediaReports'] = $this->language->get('text_mediaReports');
        $this->data['text_aboutUs'] = $this->language->get('text_aboutUs');
        $this->data['text_login'] = $this->language->get('text_login');
        $this->data['text_register'] = $this->language->get('text_register');
        $this->data['text_logged'] = $this->language->get('text_logged');
        $this->data['text_logout'] = $this->language->get('text_logout');

        $this->data['logged'] = $this->customer->isLogged();
        $logged = $this->customer->isLogged();
        if ($logged){$this->data['business'] = $this->customer->getBusinessVerify();}

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_business.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_business.tpl';
        } else {
            $this->template = 'default/template/common/header_business.tpl';
        }

        $this->render();
    }
}
?>