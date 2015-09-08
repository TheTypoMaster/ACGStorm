<?php
class ControllerAccountSafety extends Controller {

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/safety', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}

		$this->language->load('account/password');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['heading_title'] = $this->language->get('heading_title');


		$this->data['editpassword'] = $this->url->link('account/password', '', 'SSL');
        $this->data['checkemail'] = $this->url->link('account/checkemail', '', 'SSL');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/safety.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/safety.tpl';
		} else {
			$this->template = 'default/template/account/safety.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());			
	}

	
}
?>
