<?php  
class ControllerSpecialEdm extends Controller { 
    //請注意ControllerCompanyMain Company是文件夹名，Main是文件名

    public function index() {

//以下代码定义模版文件路径
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/edm.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/edm.tpl';
        } else {
            $this->template = 'default/template/specialtpl/edm.tpl';
        }

//以下代码定义头尾文件路径
        $this->children = array(
            'common/header_company',
            'common/footer_company'
        );

        $this->response->setOutput($this->render());
    }
    }
?>