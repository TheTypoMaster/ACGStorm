<?php
class ControllerAccountCheckemail extends Controller {
	private $error = array();
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/checkemail', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		$this->language->load('account/checkemail');
        	$this->load->model('account/customer');
		$this->document->setTitle($this->language->get('heading_title'));

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_safety'),
			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_editemail'),
			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);
        

		$this->data['heading_title'] = $this->language->get('heading_title');
        	$this->data['action'] = $this->url->link('account/checkemail', '', 'SSL');
	        $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
            
	        if($customer_info['email']){
	            $this->data['register_email'] = $customer_info['email'];
	        }else{
	            $this->data['register_email'] = '';
	        }
        
	        $v = '';
	        if($customer_info['salt']){
	            $v = sha1($customer_info['salt']);  
	        }
		$this->data['v'] = $v;
        
        if ($this->request->server['REQUEST_METHOD'] == 'POST') {
            $v = $this->request->post['v'];
            $subject = $this->language->get('text_subject');
            $message = $this->language->get('text_message')."\n\n";
            $message .= $this->url->link('account/checkemail/editemail','v='.$v,'SLL');
            $data = array(
	        'sendto' => $customer_info['email'],
	        'receiver' => $this->config->get('config_email'),
	        'subject' => $subject,
	        'msg' => $message,
            );
           $this->load->model('tool/sendmail');
           $this->model_tool_sendmail->send($data);
           $this->redirect($this->url->link('account/checkemail/sendsuccess', '', 'SSL'));
        }
        
        $this->data['href'] = $this->url->link('account/checkemail', 'v=' . $v, 'SSL');
        

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/checkemail.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/checkemail.tpl';
		} else {
			$this->template = 'default/template/account/checkemail.tpl';
		}

		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);

		$this->response->setOutput($this->render());			
	}
    
    
    
    public function editemail() {
        
        if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/checkemail', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
        
        $this->load->model('account/customer');
            
        $this->language->load('account/checkemail');
        

        $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
        
        if($this->request->get['v'])
        {
           
            
            if($this->request->get['v'] != sha1($customer_info['salt']))
            {
                 $this->data['breadcrumbs'] = array();

        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_safety'),
        			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
        			'separator' => false
        		);
        
        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_editemail'),
        			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
        			'separator' => $this->language->get('text_separator')
        		);
                
                 if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/illegal.tpl')) {
        			$this->template = $this->config->get('config_template') . '/template/error/illegal.tpl';
        		} else {
        			$this->template = 'default/template/error/illegal.tpl';
        		}
        
        		$this->children = array(
        			'common/column_left',
        			'common/column_right',
        			'common/content_top',
        			'common/content_bottom',
        			'common/footer',
        			'common/header'	
        		);
            }
            else
            {
                $this->data['action'] = $this->url->link('account/checkemail/editemail', 'v='.(sha1($customer_info['salt'])), 'SSL');
                
                $this->data['breadcrumbs'] = array();

        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_safety'),
        			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
        			'separator' => false
        		);
        
        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_editemail'),
        			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
        			'separator' => $this->language->get('text_separator')
        		);

                
                //邮件发送模块
                if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
                    $this->model_account_customer->editEmail($this->request->post['email'],$this->session->data['customer_id']);
                    $vt = sha1(md5($customer_info['salt']));
                    $subject = $this->language->get('text_editsubject');
                    $message = $this->language->get('text_editmessage')."\n\n";
                    $message .= $this->url->link('account/checkemail/finishemail','vt='.$vt,'SLL');
                    $data = array(
	               'sendto' => $this->request->post['email'],
	               'receiver' => $this->config->get('config_email'),
	               'subject' => $subject,
	               'msg' => $message,
                    );
                    $this->load->model('tool/sendmail');
                    $this->model_tool_sendmail->send($data);
                    $this->redirect($this->url->link('account/checkemail/sendsuccess', '', 'SSL'));      
                }
                

                
                if (isset($this->error['email'])) {
        			$this->data['error_email'] = $this->error['email'];
        		} else {
        			$this->data['error_email'] = '';
        		}
                
                
        
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/editemail.tpl')) {
        			$this->template = $this->config->get('config_template') . '/template/account/editemail.tpl';
        		} else {
        			$this->template = 'default/template/account/editemail.tpl';
        		}
        
        		$this->children = array(
        			'common/column_left',
        			'common/column_right',
        			'common/content_top',
        			'common/content_bottom',
        			'common/footer',
        			'common/header'	
        		);
            }

    		$this->response->setOutput($this->render());             
      }
            
   

  }  
    
   public function finishemail(){
    
        if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/checkemail', '', 'SSL');

			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
    
        if($this->request->get['vt'])
        {
            $this->load->model('account/customer');
            
            $this->language->load('account/checkemail');
        
            $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
            
            if($this->request->get['vt'] != sha1(md5($customer_info['salt'])))
            {
                
                $this->data['breadcrumbs'] = array();

        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_safety'),
        			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
        			'separator' => false
        		);
        
        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_editemail'),
        			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
        			'separator' => $this->language->get('text_separator')
        		);
                 
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/illegal.tpl')) {
        			$this->template = $this->config->get('config_template') . '/template/error/illegal.tpl';
        		} else {
        			$this->template = 'default/template/error/illegal.tpl';
        		}
        
        		$this->children = array(
        			'common/column_left',
        			'common/column_right',
        			'common/content_top',
        			'common/content_bottom',
        			'common/footer',
        			'common/header'	
        		);
            }
            else
            {
                $this->data['breadcrumbs'] = array();

        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_safety'),
        			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
        			'separator' => false
        		);
        
        		$this->data['breadcrumbs'][] = array(
        			'text'      => $this->language->get('text_editemail'),
        			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
        			'separator' => $this->language->get('text_separator')
        		);
                
                $this->data['finish_email'] = $customer_info['email'];
                
                $this->data['favorite'] = $this->url->link('product/favorite');
                
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/finishemail.tpl')) {
        			$this->template = $this->config->get('config_template') . '/template/account/finishemail.tpl';
        		} else {
        			$this->template = 'default/template/account/finishemail.tpl';
        		}
        
        		$this->children = array(
        			'common/column_left',
        			'common/column_right',
        			'common/content_top',
        			'common/content_bottom',
        			'common/footer',
        			'common/header'	
        		);
            }
         
          $this->response->setOutput($this->render()); 
        
        } 
    
   } 
   
   
    public function sendsuccess(){
        
        $this->language->load('account/checkemail');
        
        $this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_safety'),
			'href'      => $this->url->link('account/safety',  '',  'SSL'),       	
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_editemail'),
			'href'      => $this->url->link('account/checkemail', '', 'SSL'),
			'separator' => $this->language->get('text_separator')
		);
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sendsuccess.tpl')) {
    		$this->template = $this->config->get('config_template') . '/template/account/sendsuccess.tpl';
    	} else {
    		$this->template = 'default/template/account/sendsuccess.tpl';
    	}
    
    	$this->children = array(
    		'common/column_left',
    		'common/column_right',
    		'common/content_top',
    		'common/content_bottom',
    		'common/footer',
    		'common/header'	
    	);
        
        $this->response->setOutput($this->render()); 
    }

	protected function validate() {
	   
       $this->load->model('account/customer');

       $customer_info = $this->model_account_customer->getCustomer($this->session->data['customer_id']);
            
       if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
			$this->error['email'] = $this->language->get('error_email');
		}

		if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
			$this->error['warning'] = $this->language->get('error_exists');
		}
            
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
}
?>
