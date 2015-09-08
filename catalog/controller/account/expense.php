<?php
class ControllerAccountExpense extends Controller {
	public function index() {


		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/expense', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
         if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}	
		
        $url = '';
        $this->load->model('account/record');
        $limit = 20;
		
		 if(isset($this->session->data['consume_type']) && $this->session->data['consume_type'] !=6 ){
		 
			$data = array(
				'type'				=>$this->session->data['consume_type'],
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$this->data['consume_type']=$this->session->data['consume_type'];
			$record_info = $this->model_account_record->getRecord($data);
			$record_total = $this->model_account_record->getTotalRecord($this->session->data['consume_type']);
		}else{
			$data = array(
				
				'start'              => ($page - 1) * $limit,
				'limit'              => $limit
			);
			$record_info = $this->model_account_record->getRecord($data);
			$record_total = $this->model_account_record->getTotalRecord();
			$this->data['consume_type']=6;
		}
		
		
        $pagination = new Pagination();        
        $pagination->total = $record_total;        
        $pagination->page = $page;        
        $pagination->limit = $limit;        
        $pagination->url = $this->url->link('account/expense', $url . '&page={page}');
        $this->data['pagination'] = $pagination->render();       
        $this->data['record_info'] = $record_info;
        
		
        //模版赋值
        $this->language->load('account/expense');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->setKeywords($this->language->get('keywords'));
        $this->document->setDescription($this->language->get('description'));
        
        $this->data['heading_title'] = $this->document->getTitle();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['description'] = $this->document->getDescription();
        
        $this->data['text_consumption'] =  $this->language->get('text_consumption');
        $this->data['text_latest_transaction'] = $this->language->get('text_latest_transaction');
        $this->data['text_details'] = $this->language->get('text_details');
        $this->data['text_consumption_amount'] = $this->language->get('text_consumption_amount');
        $this->data['text_account_balance'] = $this->language->get('text_account_balance');
        $this->data['text_all_types'] = $this->language->get('text_all_types');
        $this->data['text_purchase_orders'] = $this->language->get('text_purchase_orders');
        $this->data['text_international_waybill'] = $this->language->get('text_international_waybill');
        $this->data['text_price_adjustment'] = $this->language->get('text_price_adjustment');
        $this->data['text_note'] = $this->language->get('text_note');
        $this->data['text_serial_number'] = $this->language->get('text_serial_number');
        $this->data['text_transaction_time'] = $this->language->get('text_transaction_time');
        $this->data['text_note_the_details'] = $this->language->get('text_note_the_details');
		
        $this->template = 'cnstorm/template/account/expense_business.tpl';
        
		if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/account/expense_business_list.tpl';
        }
        
/*
        $this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
     */ 
	  $this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);       
		$this->response->setOutput($this->render());			
	}    
    //查看消费日志详情+
    function record_list() {        
        if(isset($this->request->get['rid']) && $this->request->get['rid']) {            
            $rid = $this->request->get['rid'];            
            $this->load->model ('account/record');            
            $info = $this->model_account_record->getinfobyrid($rid);            
            if(1 == $info['remarktype']) {                
                $this->data['rid'] = $rid;                
                $order_id_str = $info['remarkdetails'];
                $results = $this->model_account_record->getinfobyoid($order_id_str);                
                $this->data['results'] = $results;                
                $this->template = 'cnstorm/template/account/record_order.tpl';                
                $this->response->setOutput($this->render());                
            }else if(2 == $info['remarktype']) {                
                $this->data['rid'] = $rid;                
                $sendorder_id_str = $info['remarkdetails'];                
                $results = $this->model_account_record->getinfobysid($sendorder_id_str);                
                $this->data['results'] = $results;                
                $this->template = 'cnstorm/template/account/record_sendorder.tpl';                
                $this->response->setOutput($this->render());                
            }else{                
                $this->response->setOutput("小C迷路了,请联系客服MM查询吧! ^-^");
           }   
      }
   }
   
	function getSelected(){
		  if(isset($this->request->post['type']) && $this->request->post['type']) {
            $type = $this->request->post['type'];
            
            $this->session->data['consume_type'] = $type;
            
            $url = $this->url->link('account/expense' , '' , 'SSL');
            
            $this->response->setOutput(json_encode($url));
           
        }
	}
}
?>
