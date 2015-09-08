<?php  
class ControllerCommonHelpLeft extends Controller {
	protected function index() {
        
        //菜单
        //关于我们
        
        $this->data['aboutus'] = $this->url->link('help/aboutus','id=1');
        //公告动态
        $this->data['announcement'] = $this->url->link('help/announcement','id=2');
        //常见问题
        $this->data['contactus'] = $this->url->link('help/contactus','id=3');
        //联系我们
        $this->data['normalquestion'] = $this->url->link('help/normalquestion','id=4');
        //常用工具
        $this->data['populartools'] = $this->url->link('help/populartools','id=5');
        //加入我们
        $this->data['joinus'] = $this->url->link('help/joinus','id=6');
        //网站地图
        $this->data['website'] = $this->url->link('help/website_map','id=7');
        //友情链接
        $this->data['friends'] = $this->url->link('help/friends','id=8');
	$this->data['now'] = isset($this->request->get['id']) ? $this->request->get['id'] : 1;
	

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/help_left.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/help_left.tpl';
		} else {
			$this->template = 'default/template/common/help_left.tpl';
		}

		$this->render();
	}
}
?>