<?php
class ControllerSpecial315 extends Controller {

    public function index() {
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/315.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/315.tpl';
        } else {
            $this->template = 'default/template/specialtpl/315.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>