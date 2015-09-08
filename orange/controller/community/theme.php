<?php
class ControllerCommunityTheme extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('主题管理');

		$this->load->model('community/theme');

		$this->getList();
	}

	public function insert() {
		$this->document->setTitle('主题管理');

		$this->load->model('community/theme');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_community_theme->addTheme($this->request->post);

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('community/theme', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle('主题管理');

		$this->load->model('community/theme');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_community_theme->editTheme($this->request->get['theme_id'], $this->request->post);

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('community/theme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('主题管理');

		$this->load->model('community/theme');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $theme_id) {
				$this->model_community_theme->deleteTheme($theme_id);
			}

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('community/theme', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'text'      => '主题管理',
			'href'      => $this->url->link('community/theme', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('community/theme/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('community/theme/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['themes'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$results = $this->model_community_theme->getThemes(0);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('community/theme/update', 'token=' . $this->session->data['token'] . '&theme_id=' . $result['theme_id'] . $url, 'SSL')
			);

			$this->data['themes'][] = array(
				'theme_id'    => $result['theme_id'],
				'description' => $result['description'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['theme_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = '主题管理';

		$this->data['text_no_results'] = $this->language->get('text_no_results');

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
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('community/theme', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'community/theme_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = '主题管理';

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
			'text'      => '主题管理',
			'href'      => $this->url->link('community/theme', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['theme_id'])) {
			$this->data['action'] = $this->url->link('community/theme/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('community/theme/update', 'token=' . $this->session->data['token'] . '&theme_id=' . $this->request->get['theme_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('community/theme', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['theme_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$theme_info = $this->model_community_theme->getTheme($this->request->get['theme_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['description'])) {
			$this->data['description'] = $this->request->post['description'];
		} elseif (!empty($theme_info)) {
			$this->data['description'] = $theme_info['description'];
		} else {
			$this->data['description'] = '';
		}

		$this->template = 'community/theme_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'community/theme')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['description']) < 2 || (utf8_strlen($this->request->post['description']) > 255)) {
			$this->error['description'] = $this->language->get('error_name');
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
		if (!$this->user->hasPermission('modify', 'community/theme')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}