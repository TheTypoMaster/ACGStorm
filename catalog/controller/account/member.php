<?php  
class ControllerAccountMember extends Controller { 
    public function index() {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/member.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/member.tpl';
        } else {
            $this->template = 'default/template/account/member.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	
	public function task() {
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/member_task.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/member_task.tpl';
        } else {
            $this->template = 'default/template/account/member_task.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	
	
}
?>