<?php

class ModelAccountCustomer extends Model {

    public function addCustomer($data) {
        if (isset($data['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($data['customer_group_id'], $this->config->get('config_customer_group_display'))) {
            $customer_group_id = $data['customer_group_id'];
        } else {
            $customer_group_id = $this->config->get('config_customer_group_id');
        }

        $this->load->model('account/customer_group');

        $customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer_group_id);

        $oauthuid = '';
        if (array_key_exists('oauthuid', $data))
            $oauthuid = $data['oauthuid'];
        $face = '';
        if (array_key_exists('face', $data))
            $face = $data['face'];


        $this->db->query("INSERT INTO " . DB_PREFIX . "customer SET  firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($data['password'])))) . "', newsletter = '" . (isset($data['newsletter']) ? (int) $data['newsletter'] : 0) . "', customer_group_id = '" . (int) $customer_group_id . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', status = '1', tname= '" . $this->db->escape($data['tname']) . "', approved = '" . (int) !$customer_group_info['approval'] . "', `from` = '" . $this->db->escape($data['from']) . "', `oauthuid` = '" . $oauthuid . "', `face` = '" . $face . "', regtime = UNIX_TIMESTAMP(NOW()), date_added = NOW(),logintime= UNIX_TIMESTAMP(NOW()),country='".$this->db->escape($data['country'])."' ");



        $customer_id = $this->db->getLastId();

        //$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$customer_id . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', company = '" . $this->db->escape($data['company']) . "', company_id = '" . $this->db->escape($data['company_id']) . "', tax_id = '" . $this->db->escape($data['tax_id']) . "', address_1 = '" . $this->db->escape($data['address_1']) . "', address_2 = '" . $this->db->escape($data['address_2']) . "', city = '" . $this->db->escape($data['city']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', country_id = '" . (int)$data['country_id'] . "', zone_id = '" . (int)$data['zone_id'] . "'");
    }

    public function editCustomer($data) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET sex = '" . $this->db->escape($data['sex']) . "', sexuality = '" . $this->db->escape($data['sex_choose']) . "', marriage = '" . $this->db->escape($data['marriage']) . "', children = '" . $this->db->escape($data['children']) . "', education = '" . $this->db->escape($data['education']) . "', job = '" . $this->db->escape($data['job']) . "', salary = '" . $this->db->escape($data['salary']) . "', hometown = '" . $this->db->escape($data['hometown']) . "', live = '" . $this->db->escape($data['live']) . "', blog = '" . $this->db->escape($data['blog']) . "', lastname = '" . $this->db->escape($data['lastname']) . "' WHERE customer_id = '" . (int) $this->customer->getId() . "'");
    }

	public function editPassword($email, $password) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET salt = '" . $this->db->escape($salt = substr(md5(uniqid(rand(), true)), 0, 9)) . "', password = '" . $this->db->escape(sha1($salt . sha1($salt . sha1($password)))) . "' WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");
	 	
	 																					 
	}
        
        
            //支出
    public function spend($pay_money) {
        $pay_money = (float) $pay_money;
        $customer_id = (int) $this->customer->getId();
        return $this->db->query("UPDATE oc_customer SET money=(money-$pay_money) WHERE customer_id=$customer_id");
    }

    //充值
    public function topup($pay_money, $customer_id) {
        $pay_money = (float) $pay_money;
        $customer_id = (int) $customer_id;
        return $this->db->query("UPDATE oc_customer SET money=(money+$pay_money) WHERE customer_id=$customer_id");
    }
	
	public function editBalance($Newbalance, $customer_id) {
		$query = $this->db->query("UPDATE " . DB_PREFIX . "customer SET money = '" . $this->db->escape(utf8_strtolower($Newbalance)) . "' WHERE customer_id = '" . (int)$customer_id . "'");
        return $query;
	}
	
	public function editScores($Newscores) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET scores= '" . $this->db->escape(utf8_strtolower($Newscores)) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}
    
    public function editEmail($email,$customer_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET email = '" . $this->db->escape(utf8_strtolower($email)) . "' WHERE customer_id = '" . (int)$customer_id . "'");
    }

    public function editNewsletter($newsletter) {
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET newsletter = '" . (int) $newsletter . "' WHERE customer_id = '" . (int) $this->customer->getId() . "'");
    }

    //成长值	
    public function editGrowth($growth) {

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET growth= '" . $this->db->escape(utf8_strtolower($growth)) . "' WHERE customer_id = '" . (int) $this->customer->getId() . "'");

        if ($growth >= 0 && $growth < 1000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=0 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 0' , datatime=NOW()");
        } else if ($growth >= 1000 && $growth < 3000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=1 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 1' , datatime=NOW()");
        } else if ($growth >= 3000 && $growth < 6000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=2 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 2' , datatime=NOW()");
        } else if ($growth >= 6000 && $growth < 18000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=3 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 3' , datatime=NOW()");
        } else if ($growth >= 18000 && $growth < 36000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=4 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 4' , datatime=NOW()");
        } else if ($growth >= 36000) {
            $this->db->query("UPDATE " . DB_PREFIX . "customer SET utype=5 WHERE customer_id = '" . (int) $this->customer->getId() . "'");
            $this->db->query("INSERT INTO " . DB_PREFIX . "utype_upgrade SET customer_id = '" . (int) $this->customer->getId() . "', firstname = '" . $this->db->escape($this->customer->getFirstname()) . "', remark='update to 5' , datatime=NOW()");
        }
    }
    
    public function editEggDate($customer_id) {
        $result = $this->db->query("UPDATE " . DB_PREFIX . "customer SET egg_date = now() WHERE customer_id = '" . (int)$customer_id . "'");
        return $result;
    }

    public function getEggDate($customer_id) {
        $query = $this->db->query("SELECT egg_date FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");
	$result = $query->row;
        return $result['egg_date'];
    }

    public function addCoupon($data) {  
	$this->db->query("INSERT INTO " . DB_PREFIX . "coupon SET  sn = '" . $this->db->escape($data['sn']) . "' ,uid = '" . (int)$this->customer->getId() .  "', uname = '" . $this->db->escape($data['firstname']) . "', getway = '" . (int)($data['getway']) . "', endtime = '" . (int)($data['endtime']) . "', addtime = '" . (int)($data['addtime']) . "', money = '" . (int)$data['money'] . "', sellmoney = '" . (int)$data['sellmoney'] . "', state = '" . (int)($data['state']) . "'");
    }
    
    public function getCouponsGetway() {
	$record_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "coupon WHERE getway = 3 ORDER BY addtime DESC");
        return $record_query->rows; 
    }

    public function getCustomer($customer_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->row;
    }

    public function getCustomerByEmail($email) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' OR LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row;
    }

    public function getCustomerByToken($token) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE token = '" . $this->db->escape($token) . "' AND token != ''");

        $this->db->query("UPDATE " . DB_PREFIX . "customer SET token = ''");

        return $query->row;
    }

    public function getCustomers($data = array()) {
        $sql = "SELECT *, CONCAT(c.firstname, ' ', c.lastname) AS name, cg.name AS customer_group FROM " . DB_PREFIX . "customer c LEFT JOIN " . DB_PREFIX . "customer_group cg ON (c.customer_group_id = cg.customer_group_id) ";

        $implode = array();

        if (isset($data['filter_name']) && !is_null($data['filter_name'])) {
            $implode[] = "LCASE(CONCAT(c.firstname, ' ', c.lastname)) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "%'";
        }

        if (isset($data['filter_email']) && !is_null($data['filter_email'])) {
            $implode[] = "LCASE(c.email) = '" . $this->db->escape(utf8_strtolower($data['filter_email'])) . "'";
        }

        if (isset($data['filter_customer_group_id']) && !is_null($data['filter_customer_group_id'])) {
            $implode[] = "cg.customer_group_id = '" . $this->db->escape($data['filter_customer_group_id']) . "'";
        }

        if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
            $implode[] = "c.status = '" . (int) $data['filter_status'] . "'";
        }

        if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
            $implode[] = "c.approved = '" . (int) $data['filter_approved'] . "'";
        }

        if (isset($data['filter_ip']) && !is_null($data['filter_ip'])) {
            $implode[] = "c.customer_id IN (SELECT customer_id FROM " . DB_PREFIX . "customer_ip WHERE ip = '" . $this->db->escape($data['filter_ip']) . "')";
        }

        if (isset($data['filter_date_added']) && !is_null($data['filter_date_added'])) {
            $implode[] = "DATE(c.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if ($implode) {
            $sql .= " WHERE " . implode(" AND ", $implode);
        }

        $sort_data = array(
            'name',
            'c.email',
            'customer_group',
            'c.status',
            'c.ip',
            'c.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY name";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);

        return $query->rows;
    }

    public function getTotalCustomersByEmail($email) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "'");

        return $query->row['total'];
    }

    public function getTotalCustomersByFirstname($firstname) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "customer WHERE LOWER(firstname) = '" . $this->db->escape(utf8_strtolower($firstname)) . "'");

        return $query->row['total'];
    }

    public function getIps($customer_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ip` WHERE customer_id = '" . (int) $customer_id . "'");

        return $query->rows;
    }

    public function isBanIp($ip) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "customer_ban_ip` WHERE ip = '" . $this->db->escape($ip) . "'");

        return $query->num_rows;
    }
    
    public function getBusiness() {
        
        $query = $this->db->query("SELECT business as business FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)($this->customer->getId()) . "'");

        return $query->row['business'];
    }
    
    //获取是否新用户
    public function get_shippingnumber() {
        
        $query = $this->db->query("SELECT shipping_number as shipping_number FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)($this->customer->getId()) . "'");

        return $query->row['shipping_number'];
        
    }
    
    
    //更新用户运单提交数加1
    public function add_shippingnumber() {
        
        $query = $this->db->query("UPDATE " . DB_PREFIX . "customer SET shipping_number = shipping_number + 1  WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        
        return $query;
        
    }
    
    //更新用户运单提交数减1
    public function del_shippingnumber() {
        
        $query = $this->db->query("UPDATE " . DB_PREFIX . "customer SET shipping_number = shipping_number - 1  WHERE customer_id = '" . (int)$this->customer->getId() . "'");
        
        return $query;
        
    }
    
    public function checkCustomersPwd(){
	
		  $query = $this->db->query("SELECT password  FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)($this->customer->getId()) . "'");

        return $query->row['password'];
		
	}
	public function getCustomerSalt(){
	
		 $query = $this->db->query("SELECT salt  FROM `" . DB_PREFIX . "customer` WHERE customer_id = '" . (int)($this->customer->getId()) . "'");

        return $query->row['salt'];
		
	}
	
	public function getPromotionPerson($url){
		$sql="select uid from `" . DB_PREFIX . "promotion_personnel` where url='".$url."'";
		$query = $this->db->query($sql);
		  return $query->row['uid'];
	}
	
	public function setPromotionPerson($uid,$child_id){
		$sql="insert into `" . DB_PREFIX . "promotion_grade`(pid,sid) values(".$uid.",'".$child_id."') ";
		$query = $this->db->query($sql);
		if($query ){
			$sql="SELECT  id from `" . DB_PREFIX . "promotion_grade` where pid='".$uid."' and sid='".$child_id."' order by id desc limit 1 ";
			$query = $this->db->query($sql);
			$prAutoId=$query->row['id'];
			$sql="select child from `" . DB_PREFIX . "promotion_personnel` where uid='".$uid."'";
			$query = $this->db->query($sql);
			$child=$query->row['child'];
			if($child==''){
				$child=$prAutoId;
			}else{
				$child.=','.$prAutoId;
			}
			
			$sql="update `" . DB_PREFIX . "promotion_personnel`  set child = '".$child."' where uid=".$uid;
			$this->db->query($sql);
		}
	}
	
}

?>