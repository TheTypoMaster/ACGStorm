<?php
class ControllerSettingHelpQuestion extends Controller {
	private $error = array();

	public function index() {
		$this->language->load('setting/help_question');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/help');

		$this->getList();
	}

	public function insert() {
		$this->language->load('setting/help_question');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/help');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_help->addQuestion($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/help_question', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('setting/help_question');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/help');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_help->editQuestion($this->request->get['question_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/help_question', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('setting/help_question');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/help');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $question_id) {
				$this->model_setting_help->deleteQuestion($question_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/help_question', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}

	/*public function clearHtml($content) {
		$result = preg_replace('/<a[^>]*>/i', '', $content);
		$result = preg_replace('/<\/a>/i', '', $content);
		$result = preg_replace('/<div[^>]*>/i', '', $content);
		$result = preg_replace('/<\/div>/i', '', $content);
		$result = preg_replace('/<!--[^>]*-->/i', '', $content);
		$result = preg_replace("/style=.+?['|\"]/i", '', $content);
		$result = preg_replace("/class=.+?['|\"]/i", '', $content);
		$result = preg_replace("/id=.+?['|\"]/i", '', $content);
		$result = preg_replace("/lang=.+?['|\"]/i", '', $content);
		$result = preg_replace("/width=.+?['|\"]/i", '', $content);
		$result = preg_replace("/height=.+?['|\"]/i", '', $content);
		$result = preg_replace("/border=.+?['|\"]/i", '', $content);
		$result = preg_replace("/face=.+?['|\"]/i", '', $content);
		$result = preg_replace("/face=.+?['|\"]/", '', $content);
		return $result;
	}*/

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
			'href'      => $this->url->link('setting/help_question', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('setting/help_question/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('setting/help_question/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['questions'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$question_total = $this->model_setting_help->getTotalQuestions();

		$results = $this->model_setting_help->getQuestions($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/help_question/update', 'token=' . $this->session->data['token'] . '&question_id=' . $result['help_question_id'] . $url, 'SSL')
			);

			$content = $result['content'];
			/*if ($content != '') {
				$content = $this->clearHtml(htmlspecialchars_decode($content));
			}*/

			$category_info = $this->model_setting_help->getCategory($result['help_category_id']);
			$path = $category_info['path'] == null ? $category_info['name'] : $category_info['path'] . ' > ' . $category_info['name'];

			$this->data['questions'][] = array(
				'question_id' => $result['help_question_id'],
				'category_id' => $result['help_category_id'],
				'name'        => $result['name'],
				'path' 	  	  => $path,
				'sort_order'  => $result['sort'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['help_question_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_category'] = $this->language->get('column_category');
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
		$pagination->total = $question_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/help_question', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'setting/help_question_list.tpl';
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

		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_social'] = $this->language->get('entry_social');

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
			'href'      => $this->url->link('setting/help_question', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['question_id'])) {
			$this->data['action'] = $this->url->link('setting/help_question/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/help_question/update', 'token=' . $this->session->data['token'] . '&question_id=' . $this->request->get['question_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('setting/help_question', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['question_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$question_info = $this->model_setting_help->getQuestion($this->request->get['question_id']);
			$category_info = $this->model_setting_help->getCategory($question_info['help_category_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($question_info)) {
			$this->data['name'] = $question_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['content'])) {
			$this->data['content'] = $this->request->post['content'];
		} elseif (!empty($question_info)) {
			$this->data['content'] = $question_info['content'];
		} else {
			$this->data['content'] = '';
		}

		if (isset($this->request->post['path'])) {
			$this->data['path'] = $this->request->post['path'];
		} elseif (!empty($category_info)) {
			$this->data['path'] = $category_info['path'] == null ? $category_info['name'] : $category_info['path'] . ' > ' . $category_info['name'];
		} else {
			$this->data['path'] = '';
		}

		if (isset($this->request->post['category_id'])) {
			$this->data['category_id'] = $this->request->post['category_id'];
		} elseif (!empty($question_info)) {
			$this->data['category_id'] = $question_info['help_category_id'];
		} else {
			$this->data['category_id'] = 0;
		}

		/*if (isset($this->request->post['social'])) {
			$this->data['social'] = $this->request->post['social'];
		} elseif (!empty($question_info)) {
			$this->data['social'] = $question_info['social'];
		} else {
			$this->data['social'] = 0;
		}*/

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($question_info)) {
			$this->data['sort_order'] = $question_info['sort'];
		} else {
			$this->data['sort_order'] = 0;
		}

		$this->template = 'setting/help_question_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/help_question')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['name']) < 2 || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if (empty($this->request->post['category_id'])) {
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

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('setting/help');

			$data = array(
				'filter_name' => $this->request->get['filter_name']
				//'start'       => 0
				//'limit'       => 30
			);

			$results = $this->model_setting_help->getCategories($data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['help_category_id'], 
					'name'        => strip_tags(html_entity_decode($result['rname'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/help_question')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}