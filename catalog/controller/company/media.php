<?php  
class ControllerCompanyMedia extends Controller {

    public function index() {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/company/media.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/company/media.tpl';
        } else {
            $this->template = 'default/template/company/media.tpl';
        }

        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>