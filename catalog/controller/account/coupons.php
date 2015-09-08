<?php
class ControllerAccountCoupons extends Controller {
	public function index() {
	
	error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
		
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/coupons', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}        
        if (isset($this->request->get['page'])) {            
			$page = $this->request->get['page'];            
		} else { 		  
			$page = 1;
		}	
        $url = '';
        $this->load->model('account/coupon');
        $limit = 15;
		 if(isset($this->session->data['advisory_type']) && $this->session->data['advisory_type'] !=6 ){
				$data = array(
					'type'				=>$this->session->data['advisory_type'],
					'order'				=>'DESC',
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				); 
				$this->data['advisory_type']=$this->session->data['advisory_type'];
				$coupon_info = $this->model_account_coupon->getCoupon($data);        
				$coupon_total = $this->model_account_coupon->getTotalCoupon($this->session->data['advisory_type']);    
		}else{
				$data = array(
					'type'				=>6,
					'order'				=>'DESC',
					'start'              => ($page - 1) * $limit,
					'limit'              => $limit
				); 
				$this->data['advisory_type']=6;
			$coupon_info = $this->model_account_coupon->getCoupon($data);        
			$coupon_total = $this->model_account_coupon->getTotalCoupon();    
		}
		
        

		
        $pagination = new Pagination();        
        $pagination->total = $coupon_total;        
        $pagination->page = $page;        
        $pagination->limit = $limit;        
        $pagination->url = $this->url->link('account/coupons', $url . '&page={page}');
        $this->data['pagination'] = $pagination->render();        
        $this->data['coupon_info'] = $coupon_info;
        
		
		
		
		$this->language->load('account/coupons');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));
        
        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();
        
        $this->data['text_my_coupons'] =  $this->language->get('text_my_coupons');
        $this->data['text_serial_number'] = $this->language->get('text_serial_number');
        $this->data['text_par_value'] = $this->language->get('text_par_value');
        $this->data['text_validity'] = $this->language->get('text_validity');
        $this->data['text_state'] = $this->language->get('text_state');
        $this->data['text_used'] = $this->language->get('text_used');
        $this->data['text_without_use'] = $this->language->get('text_without_use');
        $this->data['text_expired'] = $this->language->get('text_expired');
        $this->data['text_use_source'] = $this->language->get('text_use_source');
        $this->data['text_to'] = $this->language->get('text_to');
		
		
		
        $this->template = 'cnstorm/template/account/coupons_business.tpl';
	
		if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/account/coupons_business_list.tpl';
        }
        
        $this->children = array(
            'common/header_cart',
            'common/footer',
            'common/uc_business');
      
		$this->response->setOutput($this->render());			
	}
	
	 public function  filter_type(){
    
        if(isset($this->request->post['type']) && $this->request->post['type'])
        {
            $type = $this->request->post['type'];
            
            $this->session->data['advisory_type'] = $type;
            
            $url = $this->url->link('account/coupons' , '' , 'SSL');
            
            $this->response->setOutput(json_encode($url));
           
        }
        
   } 
	
	
}
?>