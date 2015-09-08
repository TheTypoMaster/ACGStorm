<?php
class ControllerSpecialOverseas extends Controller {

    public function index() {
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/overseas_topic.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/overseas_topic.tpl';
        } else {
            $this->template = 'default/template/specialtpl/overseas_topic.tpl';
        }

        $this->response->setOutput($this->render());
    }

}
    
?>