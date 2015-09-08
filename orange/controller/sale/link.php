<?php 

	class ControllerSaleLink extends Controller {
	
		public function index() {
			$this->language->load('sale/link');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->load->model('sale/link');

			$this->getList();
		}
		
			protected function getList() {
		
	error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );

			if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

			$url = '';


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
				'href'      => $this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);

			$this->data['insert'] = $this->url->link('sale/link/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
			$this->data['delete'] = $this->url->link('sale/link/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

			$this->data['user_groups'] = array();

			$data = array(
				'sort'  => "ASC",
				'order' => "link_order",
				'start' => ($page - 1) * $this->config->get('config_admin_limit'),
				'limit' => $this->config->get('config_admin_limit')
			);

			$user_group_total = $this->model_sale_link->getTotalLinks();

			$results = $this->model_sale_link->getTotalLink($data);

			foreach ($results as &$result) {
				$action = array();

				$action[] = array(
					'text' => $this->language->get('text_edit'),
					'href' => $this->url->link('sale/link/update&id='.$result['id'], 'token=' . $this->session->data['token']  . $url, 'SSL')
				);		
				$result['action']=$action;
			}	

			$this->data['results']=$results;
			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_no_results'] = $this->language->get('text_no_results');

			$this->data['column_name'] = $this->language->get('column_name');
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

			

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

	
			$pagination = new Pagination();
			$pagination->total = $user_group_total;
			$pagination->page = $page;
			$pagination->limit = $this->config->get('config_admin_limit');
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

			$this->data['pagination'] = $pagination->render();				

		

			$this->template = 'sale/link.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->setOutput($this->render());
		}
		
	public function insert() {
	
		$this->language->load('sale/link');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/link');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_sale_link->addLink($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		
		$this->getForm();
	}
	
	public function update() {
		$this->language->load('sale/link');
		
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/link');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		
			$this->model_sale_link->editLink($this->request->get['id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
			
				$url .= '&page=' . $this->request->get['page'];
				
			}

			$this->redirect($this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL'));
			
		}else{
			if(isset($this->request->get['id'])){
			
				$row=$this->model_sale_link->getLink($this->request->get['id']);
				$this->data['link_name']=$row['link_name'];
				$this->data['link_url']=$row['link_url'];
				$this->data['link_order']=$row['link_order'];
			}
		}
		$this->getForm();
	}
	
	
	protected function validateForm() {
	

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
		
	public function delete() { 
		$this->language->load('sale/link');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('sale/link');

		if (isset($this->request->post['selected']) ) {
		
			foreach ($this->request->post['selected'] as $user_group_id) {
				$this->model_sale_link->deleteLink($user_group_id);	
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	
	
	
	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_select_all'] = $this->language->get('text_select_all');
		$this->data['text_unselect_all'] = $this->language->get('text_unselect_all');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_url'] = $this->language->get('entry_url');
		$this->data['entry_order'] = $this->language->get('entry_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		$url = '';


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
			'href'      => $this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('sale/link/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
		
			$this->data['action'] = $this->url->link('sale/link/update&id='.$this->request->get['id'], 'token=' . $this->session->data['token'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('sale/link', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$ignore = array(
			'common/home',
			'common/startup',
			'common/login',
			'common/logout',
			'common/forgotten',
			'common/reset',			
			'error/not_found',
			'error/permission',
			'common/footer',
			'common/header'
		);

		$this->data['permissions'] = array();

		if (!isset($this->data['link_name'])) {
				$this->data['link_name'] ='';
		}

		if (!isset($this->data['link_url'])) {
				$this->data['link_url'] = '';
		}
		
		if (!isset($this->data['link_order'])) {
			$this->data['link_order'] ='';
			
		}
		
		$this->template = 'sale/link_group_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
	
	}
?>