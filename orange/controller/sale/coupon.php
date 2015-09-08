<?php  
class ControllerSaleCoupon extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('sale/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/coupon');
        
        $this->data['reload'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] , 'SSL');

		$this->getList();
	}

	public function insert() {
	
		$this->language->load('sale/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/coupon');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		        
		       
		        if($this->request->post['uname'])
		        {       
		        	$uname = trim($this->request->post['uname']);
		        	$this->request->post['uid'] = $this->model_sale_coupon->getUid($uname);
		        }
		  
			$this->model_sale_coupon->addCoupon($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('sale/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/coupon');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		        //var_dump($this->request->get['cid']);
		        //var_dump($this->request->post);
		        
			$this->model_sale_coupon->editCoupon($this->request->get['cid'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('sale/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/coupon');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $coupon_id) {
				$this->model_sale_coupon->deleteCoupon($coupon_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'addtime';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
        
       	if (isset($this->request->get ['filter_uname']) && $this->request->get ['filter_uname']) {
       	    
			$filter_uname = $this->request->get ['filter_uname'];
            
            $this->data['filter_uname'] = $filter_uname;
            
			$url .= "&filter_uname=" . $filter_uname;
            
		} else {
		  
            $filter_uname = '';
            
            $this->data['filter_uname'] = $filter_uname;
		}
        
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
        
        $this->data ['token'] = $this->session->data ['token'];

		$this->data['insert'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('sale/coupon/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['coupons'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
            'uname' => $filter_uname,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$coupon_total = $this->model_sale_coupon->getTotalCoupons();

		$results = $this->model_sale_coupon->getCoupons($data);
		
		//var_dump($results);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&cid=' . $result['cid'] . '&uid=' . $result['uid'] . $url, 'SSL')
			);

			$this->data['coupons'][] = array(
				'coupon_id'  => $result['cid'],
				'uid'        => $result['uid'],
				'name'       => $result['uname'],
				'discount'      => $result['money'],
				'date_start' => date($this->language->get('date_format_short'), $result['addtime']),
				'date_end'   => date($this->language->get('date_format_short'), $result['endtime']),
				'status'     => $result['state'] ,
				'selected'   => isset($this->request->post['selected']) && in_array($result['cid'], $this->request->post['selected']),
				'action'     => $action 
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_coupon_id'] = $this->language->get('column_coupon_id');
		
		$this->data['column_discount'] = $this->language->get('column_discount');
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_action'] = $this->language->get('column_action');		

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

                $this->data['sort_coupon_id'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=cid' . $url;
		$this->data['sort_name'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=uname' . $url;
		$this->data['sort_code'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=code' . $url;
		$this->data['sort_discount'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=money' . $url;
		$this->data['sort_date_start'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=addtime' . $url;
		$this->data['sort_date_end'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=endtime' . $url;
		$this->data['sort_status'] = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . '&sort=state' . $url;

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $coupon_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = HTTPS_SERVER . 'index.php?route=sale/coupon&token=' . $this->session->data['token'] . $url . '&page={page}';

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'sale/coupon_list.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_uname'] = $this->language->get('entry_uname');
		$this->data['entry_money'] = $this->language->get('entry_money');
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_history'] = $this->language->get('tab_history');

		$this->data['token'] = $this->session->data['token'];
               
                
		if (isset($this->request->get['cid'])) {
			$this->data['cid'] = $this->request->get['cid'];
		} else {
			$this->data['cid'] = 0;
		}
                
                
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['uname'])) {
			$this->data['error_uname'] = $this->error['uname'];
		} else {
			$this->data['error_uname'] = '';
		}

		if (isset($this->error['money'])) {
			$this->data['error_money'] = $this->error['money'];
		} else {
			$this->data['error_money'] = '';
		}		

		if (isset($this->error['date_start'])) {
			$this->data['error_date_start'] = $this->error['date_start'];
		} else {
			$this->data['error_date_start'] = '';
		}	

		if (isset($this->error['date_end'])) {
			$this->data['error_date_end'] = $this->error['date_end'];
		} else {
			$this->data['error_date_end'] = '';
		}	

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['cid'])) {
			$this->data['action'] = $this->url->link('sale/coupon/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$this->data['uid'] = '';
		} else {
			$this->data['action'] = $this->url->link('sale/coupon/update', 'token=' . $this->session->data['token'] . '&cid=' . $this->request->get['cid'] . $url, 'SSL');
			$this->data['uid'] = $this->request->get['uid'];
		}

		$this->data['cancel'] = $this->url->link('sale/coupon', 'token=' . $this->session->data['token'] . $url, 'SSL');

              
                
		if (isset($this->request->get['cid']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$coupon_info = $this->model_sale_coupon->getCoupon($this->request->get['cid']);
			
		}

		if (isset($this->request->post['uname'])) {
			$this->data['uname'] = $this->request->post['uname'];
			
			
		} elseif (!empty($coupon_info)) {
			$this->data['uname'] = $coupon_info['uname'];
		} else {
			$this->data['uname'] = '';
		}

		if (isset($this->request->post['money'])) {
			$this->data['money'] = $this->request->post['money'];
		} elseif (!empty($coupon_info)) {
			$this->data['money'] = $coupon_info['money'];
		} else {
			$this->data['money'] = '';
		}
               
         
		if (isset($this->request->post['date_start'])) {
			$this->data['date_start'] = $this->request->post['date_start'];
		} elseif (!empty($coupon_info)) {
			$this->data['date_start'] = date('Y-m-d', ($coupon_info['addtime']));
		} else {
			$this->data['date_start'] = date('Y-m-d', time());
		}

		if (isset($this->request->post['date_end'])) {
			$this->data['date_end'] = $this->request->post['date_end'];
		} elseif (!empty($coupon_info)) {
			$this->data['date_end'] = date('Y-m-d', ($coupon_info['endtime']));
		} else {
			$this->data['date_end'] = date('Y-m-d', time());
		}

               
                
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($coupon_info)) {
			$this->data['status'] = $coupon_info['state'];
		} else {
			$this->data['status'] = 1;
		}

		$this->template = 'sale/coupon_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render());		
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'sale/coupon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['uname'])) {
			$this->error['warning'] = $this->language->get('error_name');
		}else {
		
			$this->load->model('sale/coupon');
			$uname = trim($this->request->post['uname']);
                        $uid = $this->model_sale_coupon->getUid($uname);
                        if(!$uid)
                        {   
                            $this->error['warning'] = $this->language->get('error_exists');
                        }

		}
		

		if (empty($this->request->post['money']) || !is_numeric($this->request->post['money'])) {
			$this->error['warning'] = $this->language->get('error_money');
		}
		
		
                
                /*
		$coupon_info = $this->model_sale_coupon->getCouponByCode($this->request->post['code']);

		if ($coupon_info) {
			if (!isset($this->request->get['coupon_id'])) {
				$this->error['warning'] = $this->language->get('error_exists');
			} elseif ($coupon_info['coupon_id'] != $this->request->get['coupon_id'])  {
				$this->error['warning'] = $this->language->get('error_exists');
			}
		}
		*/

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'sale/coupon')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	public function history() {
		$this->language->load('sale/coupon');

		$this->load->model('sale/coupon');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_amount'] = $this->language->get('column_amount');
		$this->data['column_date_added'] = $this->language->get('column_date_added');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}  

		$this->data['histories'] = array();

		$results = $this->model_sale_coupon->getCouponHistories($this->request->get['coupon_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'order_id'   => $result['order_id'],
				'customer'   => $result['customer'],
				'amount'     => $result['amount'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
			);
		}

		$history_total = $this->model_sale_coupon->getTotalCouponHistories($this->request->get['coupon_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 10; 
		$pagination->url = $this->url->link('sale/coupon/history', 'token=' . $this->session->data['token'] . '&coupon_id=' . $this->request->get['coupon_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'sale/coupon_history.tpl';		

		$this->response->setOutput($this->render());
	}
}
?>