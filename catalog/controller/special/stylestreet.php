<?php
class ControllerSpecialStylestreet extends Controller {

    public function index() {
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/styleshopping.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/styleshopping.tpl';
        } else {
            $this->template = 'default/template/specialtpl/styleshopping.tpl';
        }

        $this->response->setOutput($this->render());
    }

}
    
?>