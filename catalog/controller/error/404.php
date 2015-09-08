<?php   
class ControllerError404 extends Controller {
	public function index() {		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/404.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/error/404.tpl';
		} else {
			$this->template = 'default/template/error/404.tpl';
		}
		$this->children = array(
			'common/footer',
			'common/header'
		);
		$this->response->setoutput($this->render());
	}
}
?>