<?php

class ControllerCommonHeader2 extends Controller {

    protected function index() {

        $this->language->load('common/header');
        
        $this->data['logged'] = $this->customer->isLogged();

        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');

        $this->children = array(
            'module/language',
            'module/currency',
            'module/cart'
        );

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header2.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/header2.tpl';
        } else {
            $this->template = 'default/template/common/header2.tpl';
        }

        $this->render();
    }

}

?>