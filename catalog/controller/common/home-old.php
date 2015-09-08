<?php  
class ControllerCommonHomeold extends Controller {
	public function index() {
	   
       if (isset($this->request->cookie['hometip'])) {
            $this->data['hometip'] = $this->request->cookie['hometip'];
        } else {
            $this->data['hometip'] = 0;
        }

        $this->data['login'] = $this->url->link('account/login');
        
        $this->data['home'] = $this->url->link('common/home');

        $this->data['favorite'] = $this->url->link('product/favorite');

        $this->data['newbie'] = HTTP_SERVER."newbie.html";
        
        $this->data['procurement'] = HTTP_SERVER."procurement.html";
        
        $this->data['selfshopping'] = HTTP_SERVER."selfshopping.html";
        
        $this->data['express'] = HTTP_SERVER."international-express.html";

        $this->load->model('catalog/category');
        
        $results = $this->model_catalog_category->getCategories();
        
        $this->data['categories'] = array();
        
        foreach($results as $result)
        {
             if ($result) {
                
                 $this->data['categories'][] = array(
                         'category_id' => $result['category_id'],
                         'name' => $result['name'],
                         'href' => $result['category_id'].'_'.$result['category_id'].".html" 
                        );
             }
        }
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/home.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/home.tpl';
		} else {
			$this->template = 'default/template/common/home.tpl';
		}
		
		$this->children = array(
			'common/footer',
			'common/header'
		);
										
		$this->response->setOutput($this->render());
	}
    
    public function hometip() {
        
        setcookie('hometip', 1 , time() + 3600 * 24 * 365 * 5, '/');
    }
}
?>