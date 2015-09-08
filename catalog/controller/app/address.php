<?php

/**
 * @description：手机接口收货地址部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-12
 */
Class ControllerAppAddress extends Controller {

	//查询收货地址
	public function address_list () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			if ($customer) {
				$this->load->model('app/address');
				$addresses = $this->model_app_address->getAddresses($customerId);
				if ($addresses) {
					foreach ($addresses as $address) {
						if ($address['address_id'] == $customer['address_id'])
							$isDefault = 1;
						else
							$isDefault = 0;
						$data[] = array(
							'addressId' => $address['address_id'],
							'areaid' => $address['areaid'],
							'recevicer' => $address['lastname'],
							'telePhone' => $address['telephone'],
							'country' => $address['country'],
							'countryId' => $address['country_id'],
							'province' => $address['zone'],
							'provinceId' => $address['zone_id'],
							'addressDetail' => $address['address_1'],
							'mailCode' => $address['postcode'],
							'isDefault' => $isDefault
							);
					}
				} else {
					$data = array();
				}
				$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $data)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//修改/新增收货地址
	public function address_update () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);

			//若传addressId，则为修改，不传为新增
			if (array_key_exists('addressId', $param))
				$addressId = $param['addressId'];

			$data = array(
				'customer_id' => $param['customerId'],
				'lastname' => $param['recevicer'],
				'address_details' => $param['addressDetail'],
				'postcode' => $param['mailCode'],
				'telephone' => $param['telePhone'],
				'zone_id' => $param['province'],
				'country_id' => $param['country'],
				'default' => $param['isDefault']
				);
			$this->load->model('app/address');
			if (isset($addressId))
				$this->model_app_address->editAddress($addressId, $data);
			else
				$this->model_app_address->addAddress($data);

			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//删除收货地址
	public function address_delete () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$address_id = $param['addressId'];
			$customer_id = $param['customerId'];
			
			$this->load->model('app/address');
			$this->model_app_address->deleteAddress($address_id, $customer_id);

			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//修改默认收货地址
	public function change_default () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$address_id = $param['addressId'];
			$customer_id = $param['customerId'];
			
			$this->load->model('app/address');
			$this->model_app_address->changeDefault($address_id, $customer_id);

			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}
}