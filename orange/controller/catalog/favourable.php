<?php    
class ControllerCatalogFavourable extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/favourable');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/favourable');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/favourable');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/favourable');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_favourable->addFavourable($this->request->post);

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

			if (!isset($this->request->post['discount'])) {
					$this->request->post['discount']='';
				}
			if (!isset($this->request->post['max'])) {
					$this->request->post['max']='';
				}
			if (!isset($this->request->post['min'])) {
					$this->request->post['min']='';
				}
			
			$this->redirect($this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/favourable');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/favourable');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_favourable->editFavourable($this->request->get['favourable_id'], $this->request->post);

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

			$this->redirect($this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/favourable');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/favourable');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $favourable_id) {
				$favourable_info = $this->model_catalog_favourable->getFavourable($favourable_id);
				if (file_exists(DIR_IMAGE . $favourable_info['image'])){
					unlink(DIR_IMAGE . $favourable_info['image']);
				}
				$this->model_catalog_favourable->deleteFavourable($favourable_id);
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

			$this->redirect($this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

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

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('catalog/favourable/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/favourable/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');	

		$this->data['favourables'] = array();

		$data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$manufacturer_total = $this->model_catalog_favourable->getTotalFavourables();

		$results = $this->model_catalog_favourable->getFavourables($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/favourable/update', 'token=' . $this->session->data['token'] . '&favourable_id=' . $result['favourable_id'] . $url, 'SSL')
			);

			$this->data['favourables'][] = array(
				'favourable_id' => $result['favourable_id'],
				'name'            => $result['name'],
				'sort'      => $result['sort'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['favourable_id'], $this->request->post['selected']),
				'action'          => $action,
				'image'      => $result['image'],
				'source'      => $result['source'],
				'url'      => $result['url']
			);
		}	

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
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

		$this->data['sort_name'] = $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
		$this->data['sort_sort_order'] = $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $manufacturer_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/favourable_list.tpl';
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
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');			
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_source'] = $this->language->get('entry_source');
		$this->data['entry_link'] = $this->language->get('entry_link');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');

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
			'href'      => $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['favourable_id'])) {
			$this->data['action'] = $this->url->link('catalog/favourable/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/favourable/update', 'token=' . $this->session->data['token'] . '&favourable_id=' . $this->request->get['favourable_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/favourable', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['favourable_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$favourable_info = $this->model_catalog_favourable->getFavourable($this->request->get['favourable_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($favourable_info)) {
			$this->data['name'] = $favourable_info['name'];
		} else {	
			$this->data['name'] = '';
		}

		if (isset($this->request->post['describe'])) {
			$this->data['describe'] = $this->request->post['describe'];
		} elseif (!empty($favourable_info)) {
			$this->data['describe'] = $favourable_info['des'];
		} else {
			$this->data['describe'] = '';
		}	

		if (isset($this->request->post['url'])) {
			$this->data['url'] = $this->request->post['url'];
		} elseif (!empty($favourable_info)) {
			$this->data['url'] = $favourable_info['url'];
		} else {
			$this->data['url'] = '';
		}

		if (isset($this->request->post['keyword'])) {
			$this->data['source'] = $this->request->post['source'];
		} elseif (!empty($favourable_info)) {
			$this->data['source'] = $favourable_info['source'];
		} else {
			$this->data['source'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($favourable_info)) {
			$this->data['image'] = $favourable_info['image'];
		} else {
			$this->data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 440, 180);
		} elseif (!empty($favourable_info) && $favourable_info['image'] && file_exists(DIR_IMAGE . $favourable_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($favourable_info['image'], 440, 180);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		if (isset($this->request->post['sort'])) {
			$this->data['sort'] = $this->request->post['sort'];
		} elseif (!empty($favourable_info)) {
			$this->data['sort'] = $favourable_info['sort'];
		} else {
			$this->data['sort'] = '';
		}

		if (isset($this->request->post['discount'])) {
			$this->data['discount'] = $this->request->post['discount'];
		} elseif (!empty($favourable_info)) {
			$this->data['discount'] = $favourable_info['discount'];
		} else {
			$this->data['discount'] = '';
		}
		
		if (isset($this->request->post['discount_type'])) {
			$this->data['discount_type'] = $this->request->post['discount_type'];
		} elseif (!empty($favourable_info)) {
			$this->data['discount_type'] = $favourable_info['discount_type'];
		} else {
			$this->data['discount_type'] = '';
		}
		
		if (isset($this->request->post['max'])) {
			$this->data['max'] = $this->request->post['max'];
		} elseif (!empty($favourable_info)) {
			$this->data['max'] = $favourable_info['max'];
		} else {
			$this->data['max'] = '';
		}
		
		if (isset($this->request->post['min'])) {
			$this->data['min'] = $this->request->post['min'];
		} elseif (!empty($favourable_info)) {
			$this->data['min'] = $favourable_info['min'];
		} else {
			$this->data['min'] = '';
		}
		
		if (isset($this->request->post['starttime'])) {
			$this->data['starttime'] = $this->request->post['starttime'];
		} elseif (!empty($favourable_info)) {
			$this->data['starttime'] = $favourable_info['starttime'];
		} else {
			$this->data['starttime'] = '';
		}
		
		if (isset($this->request->post['endtime'])) {
			$this->data['endtime'] = $this->request->post['endtime'];
		} elseif (!empty($favourable_info)) {
			$this->data['endtime'] = $favourable_info['endtime'];
		} else {
			$this->data['endtime'] = '';
		}
		
		$this->template = 'catalog/favourable_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
		$this->response->setOutput($this->render());
	}  

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/favourable')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 64)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/favourable')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $manufacturer_id) {
			$product_total = $this->model_catalog_product->getTotalProductsByManufacturerId($manufacturer_id);

			if ($product_total) {
				$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);
			}	
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}  
	}
}
?>