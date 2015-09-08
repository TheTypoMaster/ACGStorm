<?php

class ModelAppAddress extends Model {

	public function getAddresses($customer_id) {
		$address_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . $customer_id . "'");
	
		foreach ($query->rows as $result) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");
			
			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
				$areaid = $country_query->row['areaid'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';	
				$address_format = '';
				$areaid = '';
			}
			
			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");
			
			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				$zone_code = '';
			}		
		
			$address_data[$result['address_id']] = array(
				'address_id'     => $result['address_id'],
				'areaid'		 => $areaid,
				//'firstname'      => $result['firstname'],
				'lastname'       => $result['lastname'],
				//'company'        => $result['company'],
				//'company_id'     => $result['company_id'],
				//'tax_id'         => $result['tax_id'],				
				'address_1'      => $result['address_details'],
				//'address_2'      => $result['address_2'],
				'postcode'       => $result['postcode'],
                'telephone'      => $result['telephone'],
				//'city'           => $result['city'],
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
				//'zone_code'      => $zone_code,
				'country_id'     => $result['country_id'],
				'country'        => $country
				//'iso_code_2'     => $iso_code_2,
				//'iso_code_3'     => $iso_code_3,
			    //'address_format' => $address_format
			);
		}		
		
		return $address_data;
	}

	public function addAddress($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$this->db->escape($data['customer_id']) .  "', lastname = '" . $this->db->escape($data['lastname']) . "', address_details = '" . $this->db->escape($data['address_details']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "'");
        
		$address_id = $this->db->getLastId();
		
		if (!empty($data['default']) && $data['default'] == 1) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->db->escape($data['customer_id']) . "'");
		}
		
		return $address_id;
	}

	public function editAddress($address_id, $data) {
        $this->db->query("UPDATE " . DB_PREFIX . "address SET lastname = '" . $this->db->escape($data['lastname']) . "', address_details = '" . $this->db->escape($data['address_details']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "' WHERE address_id  = '" . (int)$address_id . "' AND customer_id = '" . $this->db->escape($data['customer_id']) . "'");
        
		if (!empty($data['default']) && $data['default'] == 1) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->db->escape($data['customer_id']) . "'");
		}
	}

	public function deleteAddress($address_id, $customer_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$customer_id . "'");
		//删除默认收货地址
		$this->load->model('account/customer');
		$customer = $this->model_account_customer->getCustomer($customer_id);
		if($customer['address_id'] == $address_id) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = 0 WHERE customer_id = '" . (int)$customer_id . "'");
		}
	}

	public function changeDefault($address_id, $customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$customer_id . "'");
	}
}