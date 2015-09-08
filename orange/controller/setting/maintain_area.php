<?php
class ControllerSettingMaintainArea extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('国家维护');

		$this->load->model('setting/maintain');

		$this->getList();
	}

	public function insert() {
		$this->document->setTitle('国家维护');

		$this->load->model('setting/maintain');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_maintain->addArea($this->request->post);

			$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle('国家维护');

		$this->load->model('setting/maintain');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_setting_maintain->editArea($this->request->get['aid'], $this->request->post);

			$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('国家维护');

		$this->load->model('setting/maintain');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			$flag = false;
			foreach ($this->request->post['selected'] as $aid) {
				//分类下有问题记录
				if ($this->model_setting_maintain->getDeliveryByAreaId($aid)) {
					$flag = true;
					break;
				} else {
					$this->model_setting_maintain->deleteArea($aid);
				}
			}

			if ($flag)
				$this->session->data['error_warning'] = '删除失败，该国家下有配送信息记录！';
			else
				$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'] . $url, 'SSL'));
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
			'text'      => '国家维护',
			'href'      => $this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('setting/maintain_area/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('setting/maintain_area/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['areas'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$area_total = $this->model_setting_maintain->getTotalAreas();

		$results = $this->model_setting_maintain->getAreas($data);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/maintain_area/update', 'token=' . $this->session->data['token'] . '&aid=' . $result['aid'] . $url, 'SSL')
			);

			$this->data['areas'][] = array(
				'aid'          => $result['aid'],
				'name_cn'      => $result['name_cn'],
				'name_en'      => $result['name_en'],
				'serverfeepct' => $result['serverfeepct'],
				'serverfee'    => $result['serverfee'],
				'def'          => $result['def'],
				'listorder'    => $result['listorder'],
				'selected'     => isset($this->request->post['selected']) && in_array($result['aid'], $this->request->post['selected']),
				'action'       => $action
			);
		}
		
		$this->data['heading_title'] = '国家维护';

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

		if (isset($this->session->data['error_warning'])) {
			$this->data['error_warning'] = $this->session->data['error_warning'];

			unset($this->session->data['error_warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		$pagination = new Pagination();
		$pagination->total = $area_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'setting/maintain_area_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = '国家维护';

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');

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
			'text'      => '国家维护',
			'href'      => $this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['aid'])) {
			$this->data['action'] = $this->url->link('setting/maintain_area/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/maintain_area/update', 'token=' . $this->session->data['token'] . '&aid=' . $this->request->get['aid'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('setting/maintain_area', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['aid']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$area = $this->model_setting_maintain->getArea($this->request->get['aid']);
		}

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['name_cn'])) {
			$this->data['name_cn'] = $this->request->post['name_cn'];
		} elseif (!empty($area)) {
			$this->data['name_cn'] = $area['name_cn'];
		} else {
			$this->data['name_cn'] = '';
		}

		if (isset($this->request->post['name_en'])) {
			$this->data['name_en'] = $this->request->post['name_en'];
		} elseif (!empty($area)) {
			$this->data['name_en'] = $area['name_en'];
		} else {
			$this->data['name_en'] = '';
		}

		if (isset($this->request->post['serverfee'])) {
			$this->data['serverfee'] = $this->request->post['serverfee'];
		} elseif (!empty($area)) {
			$this->data['serverfee'] = $area['serverfee'];
		} else {
			$this->data['serverfee'] = 0;
		}

		if (isset($this->request->post['serverfeepct'])) {
			$this->data['serverfeepct'] = $this->request->post['serverfeepct'];
		} elseif (!empty($area)) {
			$this->data['serverfeepct'] = $area['serverfeepct'];
		} else {
			$this->data['serverfeepct'] = 0;
		}

		if (isset($this->request->post['listorder'])) {
			$this->data['listorder'] = $this->request->post['listorder'];
		} elseif (!empty($area)) {
			$this->data['listorder'] = $area['listorder'];
		} else {
			$this->data['listorder'] = 0;
		}

		$this->template = 'setting/maintain_area_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/maintain_area')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['name_cn']) < 2 || (utf8_strlen($this->request->post['name_cn']) > 255)) {
			$this->error['warning'] = '国家名称长度必须大于2并小于255';
		}

		if (utf8_strlen($this->request->post['name_en']) < 2 || (utf8_strlen($this->request->post['name_en']) > 255)) {
			$this->error['warning'] = '国家英文名称长度必须大于2并小于255';
		}

		if (!is_numeric($this->request->post['serverfee']) || !is_numeric($this->request->post['serverfeepct'])) {
			$this->error['warning'] = '服务费及服务百分比必须为数字';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/maintain_area')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}