<?php
class ControllerProcurementProcurement extends Controller {
	private $error = array();

	public function index() {

        
        $this->data['noviceteaching'] = $this->url->link('newbie/newbie');
        
        $this->data['favorite'] = $this->url->link('product/favorite');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/procurement/procurement.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/procurement/procurement.tpl';
		} else {
			$this->template = 'default/template/procurement/procurement.tpl';
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
