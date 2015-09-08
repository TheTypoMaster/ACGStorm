<?php
class ControllerSettingMaintainDelivery extends Controller {
	private $error = array();

	public function index() {
		$this->document->setTitle('配送维护');

		$this->load->model('setting/maintain');

		$this->getList();
	}

	public function insert() {
		$this->document->setTitle('配送维护');

		$this->load->model('setting/maintain');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {

			$area = explode(',', $this->request->post['area']);
			$this->request->post['areaid'] = $area[0];
			$this->request->post['areaname'] = $area[1];
			if ('' == $this->request->post['carrierLogo'] && null != $this->request->post['deliveryimg'])
				$this->request->post['carrierLogo'] = $this->request->post['deliveryimg'];
			if ('' == $this->request->post['deliveryimg'] && null != $this->request->post['carrierLogo'])
				$this->request->post['deliveryimg'] = $this->request->post['carrierLogo'];

			$this->model_setting_maintain->addDelivery($this->request->post);

			$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'] . $url, 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->document->setTitle('配送维护');

		$this->load->model('setting/maintain');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$area = explode(',', $this->request->post['area']);
			$this->request->post['areaid'] = $area[0];
			$this->request->post['areaname'] = $area[1];
			if ('' == $this->request->post['carrierLogo'] && null != $this->request->post['deliveryimg'])
				$this->request->post['carrierLogo'] = $this->request->post['deliveryimg'];
			if ('' == $this->request->post['deliveryimg'] && null != $this->request->post['carrierLogo'])
				$this->request->post['deliveryimg'] = $this->request->post['carrierLogo'];

			// var_dump($this->request->post);die;
			$this->model_setting_maintain->editDelivery($this->request->get['did'], $this->request->post);

			$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->document->setTitle('配送维护');

		$this->load->model('setting/maintain');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $did) {
				$this->model_setting_maintain->deleteDelivery($did);
			}

			$this->session->data['success'] = '更新成功！';

			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
    
    
    public function shield() {
        
        $this->load->model('setting/maintain');
        
        if(isset($this->request->post['did']) && $this->request->post['did']) {
            
            $did = $this->request->post['did'];
            
            $this->model_setting_maintain->updateshield($did);

            $this->response->setOutput(1);
        }
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
			'text'      => '配送维护',
			'href'      => $this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['insert'] = $this->url->link('setting/maintain_delivery/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('setting/maintain_delivery/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        
        $this->data['token'] = $this->session->data['token'];

		$this->data['deliveries'] = array();

		$data = array(
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);

		$delivery_total = $this->model_setting_maintain->getTotalDeliveries();

		$results = $this->model_setting_maintain->getDeliveries($data);

		date_default_timezone_set('Asia/Shanghai');
		foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('setting/maintain_delivery/update', 'token=' . $this->session->data['token'] . '&did=' . $result['did'] . $url, 'SSL')
			);

			$this->data['deliveries'][] = array(
				'did'             => $result['did'],
				'deliveryname'    => $result['deliveryname'],
				'areaname'        => $result['areaname'],
				'delivery_time'    => $result['delivery_time'],
				'first_weight'    => $result['first_weight'],
				'first_fee'       => $result['first_fee'],
				'continue_weight' => $result['continue_weight'],
				'continue_fee'    => $result['continue_fee'],
				'fuel_fee'        => $result['fuel_fee'],
				'customs_fee'     => $result['customs_fee'],
				'serverfee'       => $result['serverfee'],
				'senddate'        => date("Y-m-d H:i:s", $result['senddate']),
				'deliveryimg'     => $result['deliveryimg'],
				'selected'        => isset($this->request->post['selected']) && in_array($result['did'], $this->request->post['selected']),
                'shield'          => $result['shield'],
				'action'          => $action
			);
		}
		
		$this->data['heading_title'] = '配送维护';

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
		$pagination->total = $delivery_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->template = 'setting/maintain_delivery_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = '配送维护';

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
			'text'      => '配送维护',
			'href'      => $this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['did'])) {
			$this->data['action'] = $this->url->link('setting/maintain_delivery/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('setting/maintain_delivery/update', 'token=' . $this->session->data['token'] . '&did=' . $this->request->get['did'], 'SSL');
		}

		$this->data['cancel'] = $this->url->link('setting/maintain_delivery', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['did']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$delivery = $this->model_setting_maintain->getDelivery($this->request->get['did']);
		}

		$this->data['areas'] = $this->model_setting_maintain->getAreasIN();

		$this->data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['deliveryname'])) {
			$this->data['deliveryname'] = $this->request->post['deliveryname'];
		} elseif (!empty($delivery)) {
			$this->data['deliveryname'] = $delivery['deliveryname'];
		} else {
			$this->data['deliveryname'] = '';
		}

		if (isset($this->request->post['areaname'])) {
			$this->data['areaname'] = $this->request->post['areaname'];
		} elseif (!empty($delivery)) {
			$this->data['areaname'] = $delivery['areaname'];
		} else {
			$this->data['areaname'] = '';
		}

		if (isset($this->request->post['areaid'])) {
			$this->data['areaid'] = $this->request->post['areaid'];
		} elseif (!empty($delivery)) {
			$this->data['areaid'] = $delivery['areaid'];
		} else {
			$this->data['areaid'] = '';
		}

		$this->data['selectedValue'] = $this->data['areaid'] . ',' . $this->data['areaname'];

		if (isset($this->request->post['serverfee'])) {
			$this->data['serverfee'] = $this->request->post['serverfee'];
		} elseif (!empty($delivery)) {
			$this->data['serverfee'] = $delivery['serverfee'];
		} else {
			$this->data['serverfee'] = 0;
		}

		if (isset($this->request->post['delivery_time'])) {
			$this->data['delivery_time'] = $this->request->post['delivery_time'];
		} elseif (!empty($delivery)) {
			$this->data['delivery_time'] = $delivery['delivery_time'];
		} else {
			$this->data['delivery_time'] = '';
		}

		if (isset($this->request->post['first_weight'])) {
			$this->data['first_weight'] = $this->request->post['first_weight'];
		} elseif (!empty($delivery)) {
			$this->data['first_weight'] = $delivery['first_weight'];
		} else {
			$this->data['first_weight'] = 0;
		}

		if (isset($this->request->post['first_fee'])) {
			$this->data['first_fee'] = $this->request->post['first_fee'];
		} elseif (!empty($delivery)) {
			$this->data['first_fee'] = $delivery['first_fee'];
		} else {
			$this->data['first_fee'] = 0;
		}

		if (isset($this->request->post['continue_weight'])) {
			$this->data['continue_weight'] = $this->request->post['continue_weight'];
		} elseif (!empty($delivery)) {
			$this->data['continue_weight'] = $delivery['continue_weight'];
		} else {
			$this->data['continue_weight'] = 0;
		}

		if (isset($this->request->post['continue_fee'])) {
			$this->data['continue_fee'] = $this->request->post['continue_fee'];
		} elseif (!empty($delivery)) {
			$this->data['continue_fee'] = $delivery['continue_fee'];
		} else {
			$this->data['continue_fee'] = 0;
		}

		if (isset($this->request->post['fuel_fee'])) {
			$this->data['fuel_fee'] = $this->request->post['fuel_fee'];
		} elseif (!empty($delivery)) {
			$this->data['fuel_fee'] = $delivery['fuel_fee'];
		} else {
			$this->data['fuel_fee'] = 0;
		}

		if (isset($this->request->post['customs_fee'])) {
			$this->data['customs_fee'] = $this->request->post['customs_fee'];
		} elseif (!empty($delivery)) {
			$this->data['customs_fee'] = $delivery['customs_fee'];
		} else {
			$this->data['customs_fee'] = 0;
		}

		if (isset($this->request->post['serverfee'])) {
			$this->data['serverfee'] = $this->request->post['serverfee'];
		} elseif (!empty($delivery)) {
			$this->data['serverfee'] = $delivery['serverfee'];
		} else {
			$this->data['serverfee'] = 0;
		}

		if (isset($this->request->post['queryurl'])) {
			$this->data['queryurl'] = $this->request->post['queryurl'];
		} elseif (!empty($delivery)) {
			$this->data['queryurl'] = $delivery['queryurl'];
		} else {
			$this->data['queryurl'] = '';
		}

		if (isset($this->request->post['carrierLogo'])) {
			$this->data['carrierLogo'] = $this->request->post['carrierLogo'];
		} elseif (!empty($delivery)) {
			$this->data['carrierLogo'] = $delivery['carrierLogo'];
		} else {
			$this->data['carrierLogo'] = '';
		}

		if (isset($this->request->post['carrierDesc'])) {
			$this->data['carrierDesc'] = $this->request->post['carrierDesc'];
		} elseif (!empty($delivery)) {
			$this->data['carrierDesc'] = $delivery['carrierDesc'];
		} else {
			$this->data['carrierDesc'] = '';
		}

		if (isset($this->request->post['deliveryimg'])) {
			$this->data['deliveryimg'] = $this->request->post['deliveryimg'];
		} elseif (!empty($delivery)) {
			$this->data['deliveryimg'] = $delivery['deliveryimg'];
		} else {
			$this->data['deliveryimg'] = '';
		}

		$this->template = 'setting/maintain_delivery_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'setting/maintain_delivery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (utf8_strlen($this->request->post['deliveryname']) < 2 || (utf8_strlen($this->request->post['deliveryname']) > 255)) {
			$this->error['warning'] = '快递名称长度必须大于2并小于255';
		}

		if (!is_numeric($this->request->post['first_weight']) || !is_numeric($this->request->post['first_fee']) || !is_numeric($this->request->post['continue_weight']) || !is_numeric($this->request->post['continue_fee']) || !is_numeric($this->request->post['fuel_fee']) || !is_numeric($this->request->post['customs_fee']) || !is_numeric($this->request->post['serverfee'])) {
			$this->error['warning'] = '费用及重量必须为数字';
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'setting/maintain_delivery')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}
}