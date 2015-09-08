<?php 
class ControllerSocialSnsmanager extends Controller { 
	
    
    //给我评论
	public function index() {
	   
        $this->data['message_url'] =  $this->url->link('social/snsmanager');	   
  
        $this->data['reply_url'] = $this->url->link('social/snsmanager/reply');
        
        $this->data['comment_url'] = $this->url->link('social/snsmanager/comment');
        
        //我的脸
        $this->data['face'] = $this->customer->getface();
        
        if(!$this->data['face']) {
            
           $this->data['face'] =  "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
           
        }
        
        //我的名字
        $this->data['firstname'] = $this->customer->getFirstName();
        
        if (isset($this->request->get['page']))
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $this->load->model('social/snsmanager');
        
        $limit = 10;
        
        $data = array(
            'limit' => $limit,
            'start' => ($page - 1) * $limit
        );
        
        $commented_total = $this->model_social_snsmanager->getCommentedtotal();
        $commented_info  = $this->model_social_snsmanager->getCommented($data);
        
        $this->data['commented_total'] = $commented_total;
        $this->data['commented_info'] = $commented_info;
        
        $pagination = new Pagination();
		$pagination->total = $commented_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('social/snsmanager', 'page={page}', 'SSL');
        
        $this->data['pagination'] = $pagination->render();
        
        $this->template = $this->config->get('config_template') . '/template/social/sns_manager.tpl';

		$this->children = array(
            'common/column_left_snsmng',
			'common/footer',
			'common/header_snsmanager'		
		);

		$this->response->setOutput($this->render());
        
    }
    
    
    //给我回复
    public function reply() {
    
        $this->data['message_url'] =  $this->url->link('social/snsmanager');
        
        $this->data['reply_url'] =  $this->url->link('social/snsmanager/reply');
        
        $this->data['comment_url'] =  $this->url->link('social/snsmanager/comment');
        
        //我的脸
        $this->data['face'] = $this->customer->getface();
        
        if(!$this->data['face']) {
            
           $this->data['face'] =  "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
           
        }
        
        //我的名字
        $this->data['firstname'] = $this->customer->getFirstName();
        
        
        if (isset($this->request->get['page']))
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $this->load->model('social/snsmanager');
        
        $limit = 10;
        
        $data = array(
            'limit' => $limit,
            'start' => ($page - 1) * $limit
        );
        
        $reply_total = $this->model_social_snsmanager->getReplytotal();
        $reply_info  = $this->model_social_snsmanager->getreply($data);
        
        foreach($reply_info as &$info) {
            
            $message_info = $this->model_social_snsmanager->getMessageById($info['message_id']);
            $info['message_text'] = $message_info['message_text'];
            $info['message_flag'] = $message_info['message_flag'];
            
        }
        
        //var_dump($reply_total);
        //var_dump($reply_info);
        
        $this->data['reply_total'] = $reply_total;
        $this->data['reply_info'] = $reply_info;
        
        $pagination = new Pagination();
		$pagination->total = $reply_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('social/snsmanager/reply', 'page={page}', 'SSL');
        
        $this->data['pagination'] = $pagination->render();
        
        
        $this->template = $this->config->get('config_template') . '/template/social/sns_manager_1.tpl';

		$this->children = array(
            'common/column_left_snsmng',
			'common/footer',
			'common/header_snsmanager'		
		);

		$this->response->setOutput($this->render());
        
    }
    
    
    
    //我发表的评论
    public function comment() {

        $this->data['message_url'] =  $this->url->link('social/snsmanager');
        
        $this->data['reply_url'] =  $this->url->link('social/snsmanager/reply');
        
        $this->data['comment_url'] =  $this->url->link('social/snsmanager/comment');
        
        //我的脸
        $this->data['face'] = $this->customer->getface();
        
        if(!$this->data['face']) {
            
           $this->data['face'] =  "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
           
        }
        
        //我的名字
        $this->data['firstname'] = $this->customer->getFirstName();
        
        if (isset($this->request->get['page']))
        {
            $page = $this->request->get['page'];
        }
        else
        {
            $page = 1;
        }

        $this->load->model('social/snsmanager');
        
        $limit = 10;
        
        $data = array(
            'limit' => $limit,
            'start' => ($page - 1) * $limit
        );
        
        $Mycomment_total = $this->model_social_snsmanager->getMycommenttotal();
        $Mycomment_info  = $this->model_social_snsmanager->getMycomment($data);
        
        foreach($Mycomment_info as &$info) {
            
            $message_info = $this->model_social_snsmanager->getMessageById($info['message_id']);
            $info['firstname']    = $message_info['firstname'];
            $info['face']         = $message_info['face'];
            $info['message_text'] = $message_info['message_text'];
            $info['message_flag'] = $message_info['message_flag'];
            
        }
        
        //var_dump($Mycomment_total);
        //var_dump($Mycomment_info);
        
        $this->data['Mycomment_total'] = $Mycomment_total;
        $this->data['Mycomment_info'] = $Mycomment_info;
        
        $pagination = new Pagination();
		$pagination->total = $Mycomment_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('social/snsmanager/comment', 'page={page}', 'SSL');
        
        $this->data['pagination'] = $pagination->render();
        
        $this->template = $this->config->get('config_template') . '/template/social/sns_manager_2.tpl';

		$this->children = array(
            'common/column_left_snsmng',
			'common/footer',
			'common/header_snsmanager'		
		);

		$this->response->setOutput($this->render());
        
    }
 
}   



?>	   