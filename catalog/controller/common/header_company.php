<?php

class ControllerCommonHeaderCompany extends Controller {

    protected function index() {
        //语言部分
        /*$this->language->load('common/header_company');
        $this->data['text_home'] = $this->language->get('text_home');

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );*/

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header_company.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header_company.tpl';
        } else {
            $this->template = 'default/template/common/header_company.tpl';
        }

        $this->render();
    }
}
?>