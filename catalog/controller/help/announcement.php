<?php
class ControllerHelpAnnouncement extends Controller {
	private $error = array();

	public function index() {

		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->data['noviceteaching'] = $this->url->link('noviceteaching/noviceteaching');
        
        $this->data['favorite'] = $this->url->link('product/favorite');

        $this->load->model('help/help');

        //取公告列表
        $bulletins = $this->model_help_help->getBulletins();
        $this->data['bulletins'] = $bulletins;

        //取指定bid公告
        if (array_key_exists('bid', $_REQUEST)) {
            $bulletin = $this->model_help_help->getBulletin($_REQUEST['bid']);
            $this->data['bulletin'] = $bulletin;
        }
        if (array_key_exists('social', $_REQUEST)) {
        	$this->data['social'] = $_REQUEST['social'];
        }

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/help/announcement.tpl')) {
			// $this->template = $this->config->get('config_template') . '/template/help/announcement.tpl';
			$this->template = $this->config->get('config_template') . '/template/help/bulletin.tpl';
		} else {
			$this->template = 'default/template/help/announcement.tpl';
		}

		$this->children = array(
            'common/help_left',
			//'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header',
			'common/header_transport'	
		);

		$this->response->setOutput($this->render());			
	}  
}
?>
