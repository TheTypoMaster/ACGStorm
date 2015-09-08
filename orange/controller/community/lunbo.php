<?php
class ControllerCommunityLunbo extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('轮播图管理');

		$this->load->model('community/lunbo');

		$this->getList();
	}

	public function insert() {
		$this->document->setTitle('轮播图管理');

		$this->load->model('community/lunbo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			if (isset($this->request->get['type'])) {
				$type = $this->request->get['type'];
			} else {
				$type = 0;
			}
			$this->model_community_lunbo->addLunbo($this->request->post,$type);

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle('轮播图管理');

		$this->load->model('community/lunbo');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_community_lunbo->editLunbo($this->request->get['lunbo_id'], $this->request->post);

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('轮播图管理');

		$this->load->model('community/lunbo');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			if (isset($this->request->get['type'])) {
				$type = $this->request->get['type'];
			} else {
				$type = 0;
			}
			foreach ($this->request->post['selected'] as $lunbo_id) {
				$this->model_community_lunbo->deleteLunbo($lunbo_id,$type);
			}

			$this->session->data['success'] = '成功： 您已成功更新主题！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			$this->redirect($this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}
		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['type'])) {
			$this->redirect($this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}
			
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
			'text'      => '轮播图管理',
			'href'      => $this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('community/lunbo/insert', 'type=0&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert1'] = $this->url->link('community/lunbo/insert', 'type=1&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['insert2'] = $this->url->link('community/lunbo/insert', 'type=2&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('community/lunbo/delete', 'type=0&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete1'] = $this->url->link('community/lunbo/delete', 'type=1&token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete2'] = $this->url->link('community/lunbo/delete', 'type=2&token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['lunbos'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$results = $this->model_community_lunbo->getLunbos(0,0);

		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('community/lunbo/update', 'token=' . $this->session->data['token'] . '&lunbo_id=' . $result['id'] . $url, 'SSL')
			);

			$this->data['lunbos'][] = array(
				'lunbo_id'    => $result['id'],
				'name'		  => $result['name'],
				'url'		  => $result['url'],
				'sort_order'  => $result['sort'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
				'action'      => $action
			);
		}
		
		$results1 = $this->model_community_lunbo->getLunbos(0,1);

		foreach ($results1 as $result) {
			$action1 = array();

			$action1[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('community/lunbo/update', 'token=' . $this->session->data['token'] . '&lunbo_id=' . $result['id'] . $url, 'SSL')
			);

			$this->data['lunbos1'][] = array(
				'lunbo_id'    => $result['id'],
				'name'		  => $result['name'],
				'url'		  => $result['url'],
				'sort_order'  => $result['sort'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
				'action'      => $action1
			);
		}
		
		$results2 = $this->model_community_lunbo->getLunbos(0,2);

		foreach ($results2 as $result) {
			$action2 = array();

			$action2[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('community/lunbo/update', 'token=' . $this->session->data['token'] . '&lunbo_id=' . $result['id'] . $url, 'SSL')
			);

			$this->data['lunbos2'][] = array(
				'lunbo_id'    => $result['id'],
				'name'		  => $result['name'],
				'url'		  => $result['url'],
				'price'  => $result['price'],
				'sort_order'  => $result['sort'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['id'], $this->request->post['selected']),
				'action'      => $action2
			);
		}
		$total = $this->model_community_lunbo->getTotalLunboByTR();
		if ($total['total'] < 6){
			$this->data['flag'] = true;
		}else{
			$this->data['flag'] = false;
		}
		$this->data['heading_title'] = '晒尔轮播图管理';
		$this->data['heading_title1'] = '推荐购轮播图管理';
		$this->data['heading_title2'] = '推荐购轮播右侧图管理';

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
		$pagination->url = $this->url->link('community/lunbo', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'community/lunbo_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = '轮播图管理';

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
			'text'      => '轮播图管理',
			'href'      => $this->url->link('community/lunbo', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		if (isset($this->request->get['type'])) {
			$type = $this->request->get['type'];
			$this->data['type'] = $type;
		} else {
			$type = 0;
			$this->data['type'] = $type;
		}
		if (!isset($this->request->get['lunbo_id'])) {
			$this->data['action'] = $this->url->link('community/lunbo/insert', 'type='.$type.'&token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('community/lunbo/update', 'token=' . $this->session->data['token'] . '&lunbo_id=' . $this->request->get['lunbo_id'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('community/lunbo', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['lunbo_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$lunbo_info = $this->model_community_lunbo->getLunbo($this->request->get['lunbo_id']);
		}

		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->post['name'])) {
			$this->data['name'] = $this->request->post['name'];
		} elseif (!empty($lunbo_info)) {
			$this->data['name'] = $lunbo_info['name'];
		} else {
			$this->data['name'] = '';
		}

		if (isset($this->request->post['url'])) {
			$this->data['url'] = $this->request->post['url'];
		} elseif (!empty($lunbo_info)) {
			$this->data['url'] = $lunbo_info['url'];
		} else {
			$this->data['url'] = '';
		}
		
		if (isset($this->request->post['price'])) {
			$this->data['price'] = $this->request->post['price'];
		} elseif (!empty($lunbo_info)) {
			$this->data['price'] = $lunbo_info['price'];
		} else {
			$this->data['price'] = 0.00;
		}

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($lunbo_info)) {
			$this->data['sort_order'] = $lunbo_info['sort'];
		} else {
			$this->data['sort_order'] = 0;
		}

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = '/image/' . $this->request->post['image'];
		} elseif (!empty($lunbo_info) && $lunbo_info['image'] && file_exists(DIR_IMAGE . $lunbo_info['image'])) {
			$this->data['thumb'] = '/image/' . $lunbo_info['image'];
		} else {
			$this->data['thumb'] = '/image/cache/no_image-100x100.jpg';
		}

		$this->data['no_image'] = '/image/cache/no_image-100x100.jpg';

		$this->template = 'community/lunbo_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'community/lunbo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['name']) < 2 || (utf8_strlen($this->request->post['name']) > 255)) {
			$this->error['name'] = $this->language->get('error_name');
		}

		if ($this->request->post['url']) {
			if ((strpos($this->request->post['url'], 'http://') === false) && (strpos($this->request->post['url'], 'https://') === false)) {
				$this->error['warning'] = '请填写完整的轮播图路径，如 http://www.acgstorm.com/';
			}
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
		if (!$this->user->hasPermission('modify', 'community/lunbo')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}