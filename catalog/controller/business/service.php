<?php
class ControllerBusinessService extends Controller {

    public function index() {
	  $this->data['logged'] = $this->customer->isLogged();
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/business/service.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/business/service.tpl';
        } else {
            $this->template = 'default/template/business/service.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_business'
        );

        $this->response->setOutput($this->render());
    }

    public function self() {
	$this->data['logged'] = $this->customer->isLogged();
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/business/service-self.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/business/service-self.tpl';
        } else {
            $this->template = 'default/template/business/service-self.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_business'
        );

        $this->response->setOutput($this->render());
    }

    public function fees() {
	 $this->data['logged'] = $this->customer->isLogged();
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/business/fees.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/business/fees.tpl';
        } else {
            $this->template = 'default/template/business/fees.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_business'
        );

        $this->response->setOutput($this->render());
    }

}

?>