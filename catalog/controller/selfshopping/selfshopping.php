<?php
class ControllerSelfshoppingSelfshopping extends Controller {
	
	public function index() {

        $this->data['noviceteaching'] = $this->url->link('newbie/newbie');
        
        $this->data['favorite'] = $this->url->link('product/favorite');
        
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['customer_name'] = $this->customer->getFirstName();

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/selfshopping/selfshopping.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/selfshopping/selfshopping.tpl';
		} else {
			$this->template = 'default/template/selfshopping/selfshopping.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header',
			'common/header_transport'
		);

		$this->response->setOutput($this->render());			
	}  
}
?>
