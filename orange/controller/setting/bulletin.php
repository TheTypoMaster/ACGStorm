<?php
class ControllerSettingBulletin extends Controller {
	private $error = array();

	public function index() {
	
	error_reporting(E_ALL);
ini_set( 'display_errors', 'On' );
	
		$this->language->load('setting/bulletin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/bulletin');

		$this->getList();
	}

	public function insert() {
		$this->language->load('setting/bulletin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/bulletin');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_bulletin->addBulletin($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/bulletin', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('setting/bulletin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/bulletin');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_bulletin->editBulletin($this->request->get['bulletin_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/bulletin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function updateColor() {
		$this->language->load('setting/bulletin');
		$this->load->model('setting/bulletin');
		if (($this->request->server['REQUEST_METHOD'] == 'POST')) {
			$bulletinId = $this->request->post['id'];
			$color = $this->request->post['color'];
			$this->model_setting_bulletin->updateColor($bulletinId, $color);
			$this->response->setOutput(1);
		}
	}
	
	public function delete() {
		$this->language->load('setting/bulletin');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/bulletin');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $bulletin_id) {
				$this->model_setting_bulletin->deleteBulletin($bulletin_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/bulletin', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	protected function getList() {
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
			'href'      => $this->url->link('setting/bulletin', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('setting/bulletin/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('setting/bulletin/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['bulletins'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$bulletin_total = $this->model_setting_bulletin->getTotalBulletins();

		$results = $this->model_setting_bulletin->getBulletins($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/bulletin/update', 'token=' . $this->session->data['token'] . '&bulletin_id=' . $result['bulletin_id'] . $url, 'SSL')
			);

			$this->data['bulletins'][] = array(
				'bulletin_id' => $result['bulletin_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['bulletin_id'], $this->request->post['selected']),
				'action'      => $action,
				'color'		  => $result['color'],
				'display'	  => $result['display']
			);
		}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_color'] = $this->language->get('column_color');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_repair'] = $this->language->get('button_repair');

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

		$pagination = new Pagination();
		$pagination->total = $bulletin_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/bulletin', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'setting/bulletin_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
	

	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_social'] = $this->language->get('text_social');
		$this->data['text_down'] = $this->language->get('text_down');
		$this->data['text_both'] = $this->language->get('text_both');

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_social'] = $this->language->get('entry_social');
		$this->data['entry_type'] = $this->language->get('entry_type');

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
			$this->data['error_name'] = array();
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('setting/bulletin', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['bulletin_id'])) {
			$this->data['action'] = $this->url->link('setting/bulletin/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/bulletin/update', 'token=' . $this->session->data['token'] . '&bulletin_id=' . $this->request->get['bulletin_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('setting/bulletin', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['bulletin_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$bulletin_info = $this->model_setting_bulletin->getBulletin($this->request->get['bulletin_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($bulletin_info)) {
			$this->data['name'] = $bulletin_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['content'])) {
			$this->data['content'] = $this->request->post['content'];
		} elseif (!empty($bulletin_info)) {
			$this->data['content'] = $bulletin_info['content'];
		} else {
			$this->data['content'] = '';
		}

		if (isset($this->request->post['type'])) {
			$this->data['type'] = $this->request->post['type'];
		} elseif (!empty($bulletin_info)) {
			$this->data['type'] = $bulletin_info['type'];
		} else {
			$this->data['type'] = 0;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($bulletin_info)) {
			$this->data['sort_order'] = $bulletin_info['sort'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['display'])) {
			$this->data['display'] = $this->request->post['display'];
		} elseif (!empty($bulletin_info)) {
			$this->data['display'] = $bulletin_info['display'];
		} else {
			$this->data['display'] = 1;
		}
		
		
		$this->template = 'setting/bulletin_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/bulletin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['name']) < 2 || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/bulletin')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}