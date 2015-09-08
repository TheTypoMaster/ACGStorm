<?php  
class ControllerCompanyPress extends Controller {

    public function index() {

        $this->load->model('help/help');

        //取公告列表
        $bulletins = $this->model_help_help->getBulletins();
        $this->data['bulletins'] = $bulletins;

        //取指定bid公告
        if (array_key_exists('bid', $_REQUEST)) {
            $bulletin = $this->model_help_help->getBulletin($_REQUEST['bid']);
            $this->data['bulletin'] = $bulletin;
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/company/press.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/company/press.tpl';
        } else {
            $this->template = 'default/template/company/press.tpl';
        }

        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>