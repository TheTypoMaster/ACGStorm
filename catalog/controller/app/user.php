<?php
/**
 * @description：手机接口用户部分操作
 * @author：fc@cnstorm.com
 * @date：2014-7-29
 */
Class ControllerAppUser extends Controller {

	//regedit new account
	public function regedit() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;","\"",$this->request->post['param']);
		  	$param = json_decode($str,true) ;
			$email = $param['email'];
			$userName = '';
			if (array_key_exists('userName', $param))
				$userName = $param['userName'];
			$password = '';
			if (array_key_exists('password', $param))
				$password = $param['password'];
			$from = '';
			if (array_key_exists('type', $param)) 
				$from = $param['type'];
			$oauthuid = '';
			if (array_key_exists('uid', $param))
				$oauthuid = $param['uid'];
			$tname = '';
			if (array_key_exists('tname', $param))
				$tname = $param['tname'];
			$face = '';
			if (array_key_exists('face', $param))
				$face = $param['face'];

			$this->load->model('account/customer');
			if ($this->model_account_customer->getTotalCustomersByEmail($email)) {
				$error = $errorMessage = array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_exists')));
				$arr = json_encode($error);
				echo $arr;
			} else if ($this->model_account_customer->getTotalCustomersByFirstname($userName)) {
				$error = $errorMessage = array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_exists_firstname')));
				$arr = json_encode($error);
				echo $arr;
			} else {
				$data = array(
					'firstname' => $userName,
					'lastname' => '',
					'email' => $email,
					'password' => $password,
					'telephone' => '',
					'tname' => $tname,
					'from' => $from,
					'oauthuid' => $oauthuid,
					'face' => $face,
					'company' => '',
					'country'=>''
					);
				$this->model_account_customer->addCustomer($data);
				$this->customer->login($email, $password);
				//add scores
				$this->model_account_customer->editScores(400);
				$arr = json_encode(array('data'=>array('resultCode'=>1)));
				echo $arr;
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//forgotten password
	public function forgotten() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$email = $param['email'];
			$this->load->model('account/customer');
			$this->language->load('mail/forgotten');
			$total = $this->model_account_customer->getTotalCustomersByEmail($email);
			if ($total == 0) {
				$error = $errorMessage = array('data' => array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_email')));
				$arr = json_encode($error);
				echo $arr;
			} else {
				$password = substr(sha1(uniqid(mt_rand(), true)), 0, 10);
				$this->model_account_customer->editPassword($email, $password);

				$subject = sprintf($this->language->get('text_subject'), $this->config->get('config_name'));
				$message = sprintf($this->language->get('text_greeting'), $this->config->get('config_name')) . "\n\n";
				$message .= $this->language->get('text_password') . "\n\n";
				$message .= $password;
				/*$mail = new Mail();
				$mail->protocol = $this->config->get('config_mail_protocol');
				$mail->parameter = $this->config->get('config_mail_parameter');
				$mail->hostname = $this->config->get('config_smtp_host');
				$mail->username = $this->config->get('config_smtp_username');
				$mail->password = $this->config->get('config_smtp_password');
				$mail->port = $this->config->get('config_smtp_port');
				$mail->timeout = $this->config->get('config_smtp_timeout');				
				$mail->setTo($email);
				$mail->setFrom($this->config->get('config_email'));
				$mail->setSender($this->config->get('config_name'));
				$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
				$mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
				$mail->send();*/

                $data = array(
	               'sendto' 	=> $email,
	               'receiver' 	=> $this->config->get('config_email'),
	               'subject' 	=> html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
	               'msg' 		=> html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
                    );
                $this->load->model('tool/sendmail');
                $this->model_tool_sendmail->send($data);

				$error = $errorMessage = array('data' => array('resultCode'=>1, 'errorMessage'=>$this->language->get('text_success')));
				$arr = json_encode($error);
				echo $arr;
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	/**
	 * add by fc
	 * 更新手机app的userid跟channelid
	 * id：用户id
	 * user_id：百度云推送用户编号user_id
	 * channel_id：百度云推送系统分配的channel_id
	 * device：设备类型，1苹果，2安卓
	 * status: 是否已登录，0未登录，1已登录
	 * 先判断是否已存在，若不存在则保存，若已存在但信息不匹配则更新信息
	 */
	private function updateExists($id, $user_id, $channel_id, $device_type, $status) {
		$this->load->model('app/user');
		$app_infos = $this->model_app_user->getAppInfoByCustomer($id);

		$data = array(
			'customer_id' => $id,
			'user_id' => $user_id,
			'channel_id' => $channel_id,
			'device_type' => $device_type,
			'status' => $status
			);
		
		if ($app_infos) {
			$flag = false;
			foreach ($app_infos as $app_info) {
				if ($user_id == $app_info['user_id'] && $channel_id == $app_info['channel_id']) {
					$flag = true;
					break;
				}
			}
			if ($flag) {//更新
				$this->model_app_user->updateAppInfo($data);
			} else {//新建
				$this->model_app_user->addAppInfo($data);
			}
		} else {//不存在
			$this->model_app_user->addAppInfo($data);
		}
	}

	//login
	public function login() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$email = $param['name'];
			$password = $param['password'];
			//百度云推送用户编号user_id
			$user_id = (array_key_exists('userid', $param)) ? $param['userid'] : '';
			//百度云推送系统分配的channel_id
			$channel_id = (array_key_exists('channelid', $param)) ? $param['channelid'] : '';
			//设备类型
			$device_type = (array_key_exists('deviceType', $param)) ? $param['deviceType'] : '';

			$this->load->model('account/customer');
			$this->load->model('app/user');
			
			if ($this->model_app_user->login($email, $password)) {
				$customer_info = $this->model_account_customer->getCustomerByEmail($email);

				if ($user_id != '' || $channel_id != '')
					//更新手机app的userid跟channelid
					$this->updateExists($customer_info['customer_id'], $user_id, $channel_id, $device_type, 1);

				$reg = '/^http:\/\//';
				$customer_info['face'] = preg_match($reg, $customer_info['face']) ? $customer_info['face'] : 'http://' . $this->request->server['HTTP_HOST'] . '/' . $customer_info['face'];
				$arr = json_encode(array('data'=>array('resultCode'=>1, 'result'=>$customer_info)));
				echo $arr;
			} else {
				$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_validate'))));
				echo $arr;
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//logout
	public function logout() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			//百度云推送用户编号user_id
			$user_id = (array_key_exists('userid', $param)) ? $param['userid'] : '';
			//百度云推送系统分配的channel_id
			$channel_id = (array_key_exists('channelid', $param)) ? $param['channelid'] : '';
			//设备类型
			$device_type = (array_key_exists('deviceType', $param)) ? $param['deviceType'] : '';

			if ($user_id != '' || $channel_id != '')
				//更新手机app的userid跟channelid
				$this->updateExists($customerId, $user_id, $channel_id, $device_type, 0);

			$arr = json_encode(array('data'=>array('resultCode'=>1)));
			echo $arr;
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//根据用户id查询用户相关信息
	public function getUserInfo() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			if ($customer) {
				$reg = '/^http:\/\//';
				$customer['face'] = preg_match($reg, $customer['face']) ? $customer['face'] : 'http://' . $this->request->server['HTTP_HOST'] . '/' . $customer['face'];
				$arr = json_encode(array('data'=>array('resultCode'=>1, 'result'=>$customer)));
				echo $arr;
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//edit real name
	public function edit() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$lastname = $param['lastname'];

			$this->load->model('app/user');

			$data = array(
				'lastname' => $lastname
				);
			
			$this->model_app_user->editCustomer($data, $customerId);
			$arr = json_encode(array('data'=>array('resultCode'=>1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//edit password
	public function editPassword() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$oldPassword = $param['oldPassword'];
			$newPassword = $param['newPassword'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);

			if (($customer['password'] == sha1($customer['salt'] . sha1($customer['salt'] . sha1($oldPassword)))) || ($customer['password'] == md5($oldPassword))) {
				$this->model_account_customer->editPassword($customer['email'], $newPassword);
				$arr = json_encode(array('data'=>array('resultCode'=>1)));
				echo $arr;
			} else {
				$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_oldpwd'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

	//第三方登录接口
	public function oauth() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$uid = $param['uid'];
			$type = $param['type'];
			//百度云推送用户编号user_id
			$user_id = (array_key_exists('userid', $param)) ? $param['userid'] : '';
			//百度云推送系统分配的channel_id
			$channel_id = (array_key_exists('channelid', $param)) ? $param['channelid'] : '';
			//设备类型
			$device_type = (array_key_exists('deviceType', $param)) ? $param['deviceType'] : '';

			$this->load->model('app/user');
			$user = $this->model_app_user->getCustomerByOauth($uid, $type);
			if (count($user) == '0') {
				//第一次登录，注册
				$arr = json_encode(array('data'=>array('resultCode'=>2)));
				echo $arr;
			} else {
				//之前登录过
				$cid = $user['customer_id'];
				$this->session->data['customer_id'] = $cid;

				if ($user_id != '' || $channel_id != '')
					//更新手机app的userid跟channelid
					$this->updateExists($uid, $user_id, $channel_id, $device_type, 1);

				$reg = '/^http:\/\//';
				$user['face'] = preg_match($reg, $user['face']) ? $user['face'] : 'http://' . $this->request->server['HTTP_HOST'] . '/' . $user['face'];
				$arr = json_encode(array('data'=>array('resultCode'=>1, 'result' => $user)));
				echo $arr;
			}
		} else {
			$arr = json_encode(array('data'=>array('resultCode'=>0, 'errorMessage'=>$this->language->get('error_post'))));
			echo $arr;
		}
	}

}
?>