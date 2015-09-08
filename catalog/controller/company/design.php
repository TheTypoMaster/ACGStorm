<?php  
class ControllerCompanyDesign extends Controller {

    public function index() {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/company/design.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/company/design.tpl';
        } else {
            $this->template = 'default/template/company/design.tpl';
        }

        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>