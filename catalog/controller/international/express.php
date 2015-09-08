<?php
class ControllerInternationalExpress extends Controller {
	

	public function index() {

		$this->data['logged'] = $this->customer->isLogged();
        $this->data['customer_name'] = $this->customer->getFirstName();
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/international/express.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/international/express.tpl';
		} else {
			$this->template = 'default/template/international/express.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header_transport'			
		);

		$this->response->setOutput($this->render());			
	}  
}
?>
