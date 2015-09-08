<?php

class ControllerAccountAddress extends Controller {

    private $error = array();

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('account/address');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/address');

        $this->getFormList();
    }

    public function insert() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('account/address');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/address');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
            $go = $this->model_account_address->addAddress($this->request->post);
            //echo $go;
        }

        //$this->getFormList();
        $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function update() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('account/address');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/address');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateFormList()) {
            $this->model_account_address->editAddress($this->request->get['address_id'], $this->request->post);

            // Default Shipping Address
            if (isset($this->session->data['shipping_address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address_id'])) {
                $this->session->data['shipping_country_id'] = $this->request->post['country_id'];
                $this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
                $this->session->data['shipping_postcode'] = $this->request->post['postcode'];

                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
            }

            // Default Payment Address
            if (isset($this->session->data['payment_address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address_id'])) {
                $this->session->data['payment_country_id'] = $this->request->post['country_id'];
                $this->session->data['payment_zone_id'] = $this->request->post['zone_id'];

                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
            }

            $this->session->data['success'] = $this->language->get('text_update');

            $this->redirect($this->url->link('account/address', '', 'SSL'));
        }

       $this->getFormList();
		
	//	var_dump($_SERVER);
      //  $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function delete() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/address', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->language->load('account/address');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('account/address');

        if (isset($this->request->get['address_id']) && $this->validateDelete()) {
            $this->model_account_address->deleteAddress($this->request->get['address_id']);

            // Default Shipping Address
            if (isset($this->session->data['shipping_address_id']) && ($this->request->get['address_id'] == $this->session->data['shipping_address_id'])) {
                unset($this->session->data['shipping_address_id']);
                unset($this->session->data['shipping_country_id']);
                unset($this->session->data['shipping_zone_id']);
                unset($this->session->data['shipping_postcode']);
                unset($this->session->data['shipping_method']);
                unset($this->session->data['shipping_methods']);
            }

            // Default Payment Address
            if (isset($this->session->data['payment_address_id']) && ($this->request->get['address_id'] == $this->session->data['payment_address_id'])) {
                unset($this->session->data['payment_address_id']);
                unset($this->session->data['payment_country_id']);
                unset($this->session->data['payment_zone_id']);
                unset($this->session->data['payment_method']);
                unset($this->session->data['payment_methods']);
            }

            $this->session->data['success'] = $this->language->get('text_delete');

            $this->redirect($this->url->link('account/address', '', 'SSL'));
        }

      $this->getFormList();	
       // $this->redirect($_SERVER['HTTP_REFERER']);
    }

    protected function getFormList() {

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['action'] = $this->url->link('account/address/insert', '', 'SSL');

        $total = $this->model_account_address->getTotalAddresses();
        $this->data['total'] = $total;

	$this->data['text_none'] = "没有地址";

        //getTotalAddresses
        //真实姓名
        if (isset($this->error['lastname'])) {
            $this->data['error_lastname'] = $this->error['lastname'];
        } else {
            $this->data['error_lastname'] = '';
        }

        //所在国家
        if (isset($this->error['country'])) {
            $this->data['error_country'] = $this->error['country'];
        } else {
            $this->data['error_country'] = '';
        }

        //所在省市

        if (isset($this->error['zone'])) {
            $this->data['error_zone'] = $this->error['zone'];
        } else {
            $this->data['error_zone'] = '';
        }


        //详细地址
        if (isset($this->error['address_1'])) {
            $this->data['error_address_1'] = $this->error['address_1'];
        } else {
            $this->data['error_address_1'] = '';
        }

        //邮政编码
        if (isset($this->error['postcode'])) {
            $this->data['error_postcode'] = $this->error['postcode'];
        } else {
            $this->data['error_postcode'] = '';
        }

        //联系电话
        if (isset($this->error['telephone'])) {
            $this->data['error_telephone'] = $this->error['telephone'];
        } else {
            $this->data['error_telephone'] = '';
        }

        if (!isset($this->request->get['address_id'])) {
            $this->data['action'] = $this->url->link('account/address/insert', '', 'SSL');
        } else {
            $this->data['action'] = $this->url->link('account/address/update', 'address_id=' . $this->request->get['address_id'], 'SSL');
        }

        if (isset($this->request->get['address_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $address_info = $this->model_account_address->getAddress($this->request->get['address_id']);
        }

        //真实姓名
        if (isset($this->request->post['lastname'])) {
            $this->data['lastname'] = $this->request->post['lastname'];
        } elseif (!empty($address_info)) {
            $this->data['lastname'] = $address_info['lastname'];
        } else {
            $this->data['lastname'] = '';
        }

        //所在国家
        if (isset($this->request->post['country_id'])) {
            $this->data['country_id'] = $this->request->post['country_id'];
        } elseif (!empty($address_info)) {
            $this->data['country_id'] = $address_info['country_id'];
        } else {
            $this->data['country_id'] = $this->config->get('config_country_id');
        }

        //所在省市
        if (isset($this->request->post['zone_id'])) {
            $this->data['zone_id'] = $this->request->post['zone_id'];
        } elseif (!empty($address_info)) {
            $this->data['zone_id'] = $address_info['zone_id'];
        } else {
            $this->data['zone_id'] = '';
        }

        //详细地址
        if (isset($this->request->post['address_details'])) {
            $this->data['address_details'] = $this->request->post['address_details'];
        } elseif (!empty($address_info)) {
            $this->data['address_details'] = $address_info['address_details'];
        } else {
            $this->data['address_details'] = '';
        }

        //邮政编码
        if (isset($this->request->post['postcode'])) {
            $this->data['postcode'] = $this->request->post['postcode'];
        } elseif (!empty($address_info)) {
            $this->data['postcode'] = $address_info['postcode'];
        } else {
            $this->data['postcode'] = '';
        }

        //联系电话
        if (isset($this->request->post['telephone'])) {
            $this->data['telephone'] = $this->request->post['telephone'];
        } elseif (!empty($address_info)) {
            $this->data['telephone'] = $address_info['telephone'];
        } else {
            $this->data['telephone'] = '';
        }


        //所在国家
        $this->load->model('localisation/country');

        $this->data['countries'] = $this->model_localisation_country->getCountries();

        if (isset($this->request->post['default'])) {
            $this->data['default'] = $this->request->post['default'];
        } elseif (isset($this->request->get['address_id'])) {
            $this->data['default'] = $this->customer->getAddressId() == $this->request->get['address_id'];
        } else {
            $this->data['default'] = false;
        }

        $this->data['addresses'] = array();

        $results = $this->model_account_address->getAddresses();



        foreach ($results as $result) {

            //var_dump($result);

            $this->data['addresses'][] = array(
                'address_id' => $result['address_id'],
                'address' => $result,
                'update' => $this->url->link('account/address/update', 'address_id=' . $result['address_id'], 'SSL'),
                'delete' => $this->url->link('account/address/delete', 'address_id=' . $result['address_id'], 'SSL')
            );
        }

        //var_dump($this->data['addresses']);
        //$this->data['back'] = $this->url->link('account/address', '', 'SSL');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/address.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/address.tpl';
        } else {
            $this->template = 'default/template/account/address.tpl';
        }
        
        
        $this->template = 'cnstorm/template/account/address_business.tpl';
/*
        $this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
   */             
  $this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);		
        $this->response->setOutput($this->render());
    }

    protected function validateFormList() {

        //真实姓名
        if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
            $this->error['lastname'] = $this->language->get('error_lastname');
        }

        //详细地址
        if ((utf8_strlen($this->request->post['address_details']) < 3) || (utf8_strlen($this->request->post['address_details']) > 128)) {
            $this->error['address_1'] = $this->language->get('error_address_1');
        }

        //电话号码
        if ((utf8_strlen($this->request->post['telephone']) < 6) || (utf8_strlen($this->request->post['telephone']) > 20)) {
            $this->error['telephone'] = $this->language->get('error_telephone');
        }

        $this->load->model('localisation/country');

        $country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

        if ($country_info) {
            if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
                $this->error['postcode'] = $this->language->get('error_postcode');
            }

            // VAT Validation
            $this->load->helper('vat');

            if ($this->config->get('config_vat') && !empty($this->request->post['tax_id']) && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
                $this->error['tax_id'] = $this->language->get('error_vat');
            }
        }

        if ($this->request->post['country_id'] == '') {
            $this->error['country'] = $this->language->get('error_country');
        }

        if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '') {
            //$this->error['zone'] = $this->language->get('error_zone');
            $this->request->post['zone_id'] = '';
        }


        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    protected function validateDelete() {
        if ($this->model_account_address->getTotalAddresses() == 1) {
            $this->error['warning'] = $this->language->get('error_delete');
        }

        if ($this->customer->getAddressId() == $this->request->get['address_id']) {
            $this->error['warning'] = $this->language->get('error_default');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function country() {
        $json = array();



        $this->load->model('localisation/country');

        $this->load->model('localisation/zone');

        $country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

        //$info = $this->model_localisation_zone->getZonesByCountryId(44);
        //var_dump($info);

        if ($country_info) {
            $this->load->model('localisation/zone');

            $json = array(
                'country_id' => $country_info['country_id'],
                'name' => $country_info['name'],
                'iso_code_2' => $country_info['iso_code_2'],
                'iso_code_3' => $country_info['iso_code_3'],
                'address_format' => $country_info['address_format'],
                'postcode_required' => $country_info['postcode_required'],
                'zone' => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
                'status' => $country_info['status']
            );
        }

        $this->response->setOutput(json_encode($json));
    }

}

?>