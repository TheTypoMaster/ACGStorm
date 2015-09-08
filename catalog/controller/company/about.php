<?php  
class ControllerCompanyAbout extends Controller {

    public function index() {

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/company/about.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/company/about.tpl';
        } else {
            $this->template = 'default/template/company/about.tpl';
        }

        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>