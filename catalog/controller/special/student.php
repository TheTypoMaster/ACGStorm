<?php
class ControllerSpecialStudent extends Controller {

    public function index() {
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/student_verify.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/student_verify.tpl';
        } else {
            $this->template = 'default/template/specialtpl/student_verify.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>