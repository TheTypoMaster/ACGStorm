<?php  
class ControllerCompanyMain extends Controller {

    public function index() {

        $this->data['logged'] = $this->customer->isLogged();
        //$this->data['login'] = $this->url->link('account/login');
        //$this->data['home'] = $this->url->link('common/home');
        //$this->data['favorite'] = $this->url->link('product/favorite');
		$this->data['login'] = HTTP_SERVER . "account-login.html";

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/company/main.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/company/main.tpl';
        } else {
            $this->template = 'default/template/company/main.tpl';
        }

        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>