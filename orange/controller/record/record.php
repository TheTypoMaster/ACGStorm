<?php
class ControllerRecordRecord extends Controller {
	public function index() {
        $this->language->load('record/record');
        $this->document->setTitle($this->language->get('heading_title'));
		$this->load->model ('record/record');
		$this->getList ();
	}
	protected function getList() {
		if (isset ( $this->request->get ['filter_rid'] )) {
			$filter_rid = $this->request->get ['filter_rid'];
		} else {
			$filter_rid = null;
		}
		
		$url = '';
		if (isset ( $this->request->get ['filter_uname'] )) {
			$filter_uname = $this->request->get ['filter_uname'];
			$url .= "&filter_uname=" . $filter_uname;
		} else {
			$filter_uname = null;
		}
		
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'o.order_id';
		}
		
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		
		$this->data ['breadcrumbs'] = array ();
		
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/home', 'token=' . $this->session->data ['token'], 'SSL' ),
				'separator' => false 
		);
		
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'heading_title' ),
				'href' => $this->url->link ( 'record/record', 'token=' . $this->session->data ['token'] . $url, 'SSL' ),
				'separator' => ' :: ' 
		);
		
		if (isset ( $this->error ['warning'] )) {
			$this->data ['error_warning'] = $this->error ['warning'];
		} else {
			$this->data ['error_warning'] = '';
		}
		
		if (isset ( $this->session->data ['success'] )) {
			$this->data ['success'] = $this->session->data ['success'];
			
			unset ( $this->session->data ['success'] );
		} else {
			$this->data ['success'] = '';
		}
		
		if (isset ( $this->request->post ['selected'] ) && isset ( $this->request->post ['filter_order_status_id'] )) {
			$select = $this->request->post ['selected'];
			$filter_order_status_id = $this->request->post ['filter_order_status_id'];
			
			// $this->model_yundan_yundan->updata_status($select, $filter_order_status_id);
		} else {
			$order = 'DESC';
		}
		
		$this->data ['token'] = $this->session->data ['token'];
		$this->data ['orders'] = array ();
		
		$data = array (
				'rid' => $filter_rid,
				'uname' => $filter_uname,
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get ( 'config_admin_limit' ),
				'limit' => $this->config->get ( 'config_admin_limit' ) 
		);
		
		date_default_timezone_set ( 'Asia/Shanghai' );
		$results = $this->model_record_record->getRecords ( $data );
		
		foreach ( $results as $result ) {
			if ($result['money'] > 0){ 
				$symbol = '+';
			}else { 
				$symbol = '';
			}
			$this->data ['orders'] [] = array (
					'rid' => $result ['rid'],
					'uname' => $result ['uname'],
					'payname' => $result ['payname'],
					'money' => $result ['money'],
					'accountmoney' => $result ['accountmoney'],
					'remark' => $result ['remark'],
                    'remarktype' => $result ['remarktype'],
					'record' => $result['record'],
                    'remarkdetails' => $result ['remarkdetails'],
					'addtime' => date ( "Y-m-d H:i:s", $result ['addtime'] ),
					'source' => $result ['source'],
					'symbol' => $symbol,
					'selected' => isset ( $this->request->post ['selected'] ) && in_array ( $result ['sid'], $this->request->post ['selected'] ) 
			);
		}
		
		$record_total = $this->model_record_record->totalRecords ();
		
		$pagination = new Pagination ();
		$pagination->total = $record_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get ( 'config_admin_limit' );
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'record/record', 'token=' . $this->session->data ['token'] . $url . '&page={page}', 'SSL' );
		
		$this->data ['pagination'] = $pagination->render ();
		
		$this->template = 'record/record.tpl';
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		
		$this->response->setOutput ( $this->render () );
	}
    
    //查看消费日志详情+
    function record_list() {
        
        if(isset($this->request->get['rid']) && $this->request->get['rid']) {
            
            $rid = $this->request->get['rid'];
            
            $this->load->model ('record/record');
            
            $info = $this->model_record_record->getinfobyrid($rid);
            
            if(1 == $info['remarktype']) {
                
                $this->data['rid'] = $rid;
                
                $order_id_str = $info['remarkdetails'];

                $results = $this->model_record_record->getinfobyoid($order_id_str);
                
                $this->data['results'] = $results;
                
                $this->template = 'record/record_order.tpl';
                
                $this->response->setOutput($this->render());
                
            }else if(2 == $info['remarktype']) {
                
                $this->data['rid'] = $rid;
                
                $sendorder_id_str = $info['remarkdetails'];
                
                $results = $this->model_record_record->getinfobysid($sendorder_id_str);
                
                $this->data['results'] = $results;
                
                $this->template = 'record/record_sendorder.tpl';
                
                $this->response->setOutput($this->render());
                
                
            }else{
                
                $this->response->setOutput("小C迷路了,请联系客服MM查询吧! ^-^");
           }   
      }
   }

   //删除订单查看消费日志详情+
   function delete_order_list() {
   	if(isset($this->request->get['rid']) && $this->request->get['rid']) {
   		$rid = $this->request->get['rid'];
   		$results = explode('::',$rid);
   		$this->data['rid'] = $results[0];
   		$this->data['result'] = $results;
   		$this->template = 'record/delete_order_list.tpl';
   		$this->response->setOutput($this->render());
   	}
   }
   
}

?>