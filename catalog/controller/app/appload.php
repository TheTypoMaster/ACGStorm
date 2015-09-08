<?php 
class ControllerAppAppload extends Controller { 
	
	public function index() {
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/app/appload.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/app/appload.tpl';
		} else {
			$this->template = 'default/template/account/appload.tpl';
		}

		$this->response->setOutput($this->render());
	}
	
}

?>