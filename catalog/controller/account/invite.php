<?php
class ControllerAccountInvite extends Controller {

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/invite', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		//$this->language->load('account/rmbaccount');

		//$this->document->setTitle($this->language->get('heading_title'));
		
		//$this->data['heading_title'] = $this->language->get('heading_title');
        

		//$this->data['onlinecharge'] = $this->url->link('account/rmbaccount/onlinecharge', '', 'SSL');
        //$this->data['checkemail'] = $this->url->link('account/checkemail', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/invite.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/invite.tpl';
		} else {
			$this->template = 'default/template/account/invite.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());			
	}
    
	
}
?>
