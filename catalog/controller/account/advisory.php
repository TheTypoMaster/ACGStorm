<?php
class ControllerAccountAdvisory extends Controller {

	public function index() {
	   
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/advisory', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
        
         if (isset($this->request->get['page'])) {
            
			$page = $this->request->get['page'];
            
		} else { 
		  
			$page = 1;
		}	
        
        $url = '';   
        $limit = 5;
  
       	$this->load->model('account/guestbook');
        if(isset($this->session->data['advisory_type']) && $this->session->data['advisory_type']) 
        {
             $data = array(
				'order'				=>'DESC',
				'start'              => ($page - 1) * $limit,
                'type'               => $this->session->data['advisory_type'],
				'limit'              => $limit
			);
            
            $guestbook_info = $this->model_account_guestbook->getGuestbook($data);
        
            $guestbook_info_total = $this->model_account_guestbook->getTotalGuestbook($this->session->data['advisory_type']);
            
            $pagination = new Pagination();
        
            $pagination->total = $guestbook_info_total;
            
            $pagination->page = $page;
            
            $pagination->limit = $limit;
            
            $pagination->url = $this->url->link('account/advisory', $url . '&page={page}');
    
            $this->data['pagination'] = $pagination->render();
        }   
        else
        {   
            $data = array(
				'order'				=>'DESC',
				'start'              => ($page - 1) * $limit,
                'type'               => 6,
				'limit'              => $limit
			);
            
            $guestbook_info = $this->model_account_guestbook->getGuestbook($data);
        
            $guestbook_info_total = $this->model_account_guestbook->getTotalGuestbook(6);
            
            $pagination = new Pagination();
        
            $pagination->total = $guestbook_info_total;
            
            $pagination->page = $page;
            
            $pagination->limit = $limit;
            
            $pagination->url = $this->url->link('account/advisory', $url . '&page={page}');
    
            $this->data['pagination'] = $pagination->render();
        }
       
        
        $this->data['guestbook_info'] = $guestbook_info;
        
        $this->data['guestbook_info_total'] = $guestbook_info_total;
        
       	$this->getlist();	
	}
    
    public function getlist() {
        
         $this->data['action'] = $this->url->link('account/advisory/insert');
         
         if(isset($this->session->data['advisory_type']) && $this->session->data['advisory_type'])
            $this->data['advisory_type'] = $this->session->data['advisory_type'];
         else
            $this->data['advisory_type'] = 6;
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/advisory.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/advisory.tpl';
		} else {
			$this->template = 'default/template/account/advisory.tpl';
		}

        
        
        $this->template = 'cnstorm/template/account/advisory_business.tpl';

        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business');
       
		$this->response->setOutput($this->render());	
    }
    
    public function insert(){
        
        if(isset($this->request->post['question']) && $this->request->post['question'])
            $type = $this->request->post['question'];
        
        if(isset($this->request->post['msg']) && $this->request->post['msg'])
            $msg = $this->request->post['msg'];
            
            
        $this->load->model('account/guestbook');
        
        $uid = $this->customer->getId();
        
        $uname = $this->customer->getFirstName();
        
        $data = array();
        
        if($type && $msg && $uid && $uname)
        {
        
            $data = array(
            'uid'      =>   $uid,
            'uname'    =>   $uname,
            'state'    =>   0,
            'msg'      =>   $msg,
            'addtime'  =>   time(),
            'reply'    =>   0,
            'type'     =>   $type
             );
        
            $this->model_account_guestbook->addGuestbook($data);
            
        }
        
        $this->index();
        
    }
  
   public function  filter_type(){
    
        if(isset($this->request->post['type']) && $this->request->post['type'])
        {
            $type = $this->request->post['type'];
            
            $this->session->data['advisory_type'] = $type;
            
            $url = $this->url->link('account/advisory' , '' , 'SSL');
            
            $this->response->setOutput(json_encode($url));
           
        }
        
   } 
    

	
}
?>
