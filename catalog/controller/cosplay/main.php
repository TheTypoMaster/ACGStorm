<?php
class ControllerCosplayMain extends Controller {

    public function index() {
	
	/* error_reporting(E_ALL);
	ini_set( 'display_errors', 'On' ); */

        $this->data['login'] = $this->url->link('account/login');
        
        $this->data['home'] = $this->url->link('common/home');
        
        $this->load->model('cosplay/main');
		
		$this->load->model('tool/image');

		$this->data['products'] = array();
  
        $this->data['products_categoryid_info'] = array();
        
        $this->data['categoryids'] = array();
        
        $this->data['s_categoryids'] = array();
        
        $results = $this->model_cosplay_main->getCategories();
        
        $categoryid_all = array();
      
        foreach ($results as $result) {
            
            if ($result) {
                
                 $categoryid_all[]=$result['category_id'];
                          
                 $s_results = $this->model_cosplay_main->getCategories($result['category_id']);
                      
                 if($s_results)
                 {
                     foreach($s_results as $s_result)
                     {  
                        $this->data['s_categoryids'][] = array(
                           's_category_id' => $s_result['category_id'],
                           'name' => $s_result['name'],
                           's_parent_category_id' => $result['category_id'],
                           'href' => $result['category_id']."_".$s_result['category_id']."-cosplay".".html"     
                        );
                     }
                 }
                 
                 $this->data['categoryids'][] = array(
                         'category_id' => $result['category_id'],
                         'name' => $result['name'],
						 'href'=>'http://www.acgstorm.com/'.$result['parent_id'].'_'.$result['category_id'].'-cosplay.html'
                 );
   
            }      
        }
        
        //人气单品
        $data = array(
            'sort' => 'view',
            'start' => 0,
			'recommend'=>1,
			'notin'=>'32,33',//不想取的分类下的产品
            'limit' => 8
        );
                
        $hots = $this->model_cosplay_main->getProducts($data);
       
        foreach($hots as &$hot) {
            $hot['image'] = $this->model_tool_image->resize ( $hot['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) );
			 $rows=$this->model_cosplay_main->getCategory1($hot['product_id']);
			 $index=count($rows->rows)-1;
			 $hot['href']=$rows->rows[$index]['parent_id'].'_'.$rows->rows[$index]['category_id'].'-cosplay.html&product_id='.$hot['product_id'];
			 
        }
        
        $this->data['hots'] = $hots;
        
        //时尚中长款
         $data1 = array(
                'filter_category_id' => 32,
				'recommend'=>1,
                'start' => 0,
                'limit' => 8
         );
        
        $long_wig = $this->model_cosplay_main->getProducts($data1);
         // print_r($long_wig);
        foreach($long_wig as &$long) {
            $long['image'] = $this->model_tool_image->resize ( $long['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) );;
			
			
			 $rows1=$this->model_cosplay_main->getCategory1($long['product_id']);
			 $index1=count($rows1->rows)-1;
			 $long['href']=$rows1->rows[$index1]['parent_id'].'_'.$rows1->rows[$index1]['category_id'].'-cosplay.html&product_id='.$long['product_id'];
			 
        }
        //帅气短发
        $data2 = array(
                'filter_category_id' => 33,
				'recommend'=>1,
                'start' => 0,
                'limit' => 8
         );
        
        $short_wig = $this->model_cosplay_main->getProducts($data2);
      
        foreach($short_wig as &$short) {
            $short['image'] = $this->model_tool_image->resize ( $short['image'], $this->config->get ( 'config_image_thumb_width' ), $this->config->get ( 'config_image_thumb_height' ) ); 
			
			 $rows=$this->model_cosplay_main->getCategory1($short['product_id']);
			 $index=count($rows->rows)-1;
			 $short['href']=$rows->rows[$index]['parent_id'].'_'.$rows->rows[$index]['category_id'].'-cosplay.html&product_id='.$short['product_id'];
        }
        
        $this->data['long_wig'] = $long_wig;
        
        $this->data['short_wig'] = $short_wig;
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/cosplay/main.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/cosplay/main.tpl';
        } else {
            $this->template = 'default/template/cosplay/main.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header_cosplay'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>