<?php  
class ControllerBusinessMain extends Controller {

    public function index() {

        $this->data['logged'] = $this->customer->isLogged();
        //$this->data['login'] = $this->url->link('account/login');
        //$this->data['home'] = $this->url->link('common/home');
        //$this->data['favorite'] = $this->url->link('product/favorite');
		$this->data['login'] = HTTP_SERVER . "account-login.html";
		$this->data['home'] = HTTP_SERVER . "common-home.html";
		$this->data['favorite'] = HTTP_SERVER . "product-favorite.html";
        $this->data['newbie'] = HTTP_SERVER . "newbie.html";
        $this->data['procurement'] = HTTP_SERVER . "procurement.html";
        $this->data['selfshopping'] = HTTP_SERVER . "selfshopping.html";
        $this->data['express'] = HTTP_SERVER . "international-express.html";

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/business/home.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/business/home.tpl';
        } else {
            $this->template = 'default/template/business/home.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_business'
        );

        $this->response->setOutput($this->render());
    }

    public function press() {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/business/press.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/business/press.tpl';
        } else {
            $this->template = 'default/template/business/press.tpl';
        }

        $this->children = array(
            'common/footer_business',
            'common/header_business'
        );

        $this->response->setOutput($this->render());

    }
}
?>