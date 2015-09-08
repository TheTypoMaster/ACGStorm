<?php 
class ControllerSocialComment extends Controller {
	public function index() {
        if(isset($this->request->get['message_id']) && ($this->request->get['message_id'])) {
	    if (isset($this->request->get['message_id'])){
	    	$message_id = $this->request->get['message_id'];
	    }else{
	    	$message_id = '';
	    }
            //判断用户是否登陆
            if ($this->customer->isLogged()) {                
                $this->data['logged'] = 1;                 
    	    } else {    		  
                $this->data['logged'] = 0;
                $this->data['error_login'] = "";
                $this->data['action'] = $this->url->link('account/login', '', 'SSL');
                $this->data['register'] = $this->url->link('account/register', '', 'SSL');
                $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');    
                $this->data['email'] = '';
                $this->data['password'] = '';
                include_once(DIR_SYSTEM . 'weibo/config.php');
                include_once(DIR_SYSTEM . 'weibo/saetv2.ex.class.php');    
                $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
                $this->data['code_url'] = $o->getAuthorizeURL(WB_CALLBACK_URL);
    	    }
            $this->load->model('social/social');
            $message_info = $this->model_social_social->getMessageByid($message_id);
            if (isset($this->request->get['page'])){
                $page = $this->request->get['page'];
                $this->data['page'] = $page;
            }else{
                $page = 1;
                $this->data['page'] = $page;
            }
            $limit = 20;
            $this->data['limit'] = $limit;
            $data = array(
                'message_id' => $message_id,
                'start'      => ($page - 1) * $limit,
                'limit'      => $limit
            );
            $comment_info = $this->model_social_social->getComment($data);
            $comment_total = $this->model_social_social->getTotalComment($message_id);
            //回复的用户id 
            $this->data['customer_id'] = $this->customer->getId();
             //回复的脸
            $this->data['face'] = $this->customer->getface();
            if(!$this->data['face']) {
               $this->data['face'] =  "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
            }
            $this->data['message'] = $message_info;
            $this->data['comment_info_all'] = $comment_info;
            $this->data['comment_total'] = $comment_total;
            $pagination = new Pagination();
    	    $pagination->total = $comment_total;
    	    $pagination->page = $page;
    	    $pagination->limit = $limit;
    	    $pagination->text = $this->language->get('text_pagination');
    	    $pagination->url = $this->url->link('social/comment', 'message_id=' . $message_id .'&page={page}', 'SSL');
            $this->data['pagination'] = $pagination->render();
            $this->template = $this->config->get('config_template') . '/template/social/comment_list.tpl';
	    $this->children = array(
		'common/footer',
            	'common/social_right',
		'common/header_sns'		
	    );
	    $this->response->setOutput($this->render());
        }
    }
    //详情页的消息回复
}   
?>