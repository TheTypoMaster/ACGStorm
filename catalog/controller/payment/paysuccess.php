<?php 
class ControllerPaymentPaysuccess extends Controller {  
	public function index() {
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/paysuccess.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/payment/paysuccess.tpl';
		} else {
			$this->template = 'default/template/payment/paysuccess.tpl';
		}

		$this->children = array(
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());				
	}
}
?>