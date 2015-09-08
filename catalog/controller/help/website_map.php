<?php

class ControllerHelpWebsitemap extends Controller {

    private $error = array();

    public function index() {

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['noviceteaching'] = $this->url->link('noviceteaching/noviceteaching');

        $this->data['favorite'] = $this->url->link('product/favorite');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/help/website_map.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/help/website_map.tpl';
        } else {
            $this->template = 'default/template/help/website_map.tpl';
        }

        $this->children = array(
            'common/help_left',
            'common/column_left',
            'common/column_right',
            'common/content_top',
            'common/content_bottom',
            'common/footer',
            'common/header_transport'
        );

        $this->response->setOutput($this->render());
    }

}

?>
