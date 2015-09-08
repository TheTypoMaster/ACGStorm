<?php

/**
 * @description：手机接口个人帐户部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-18
 */
Class ControllerAppAccount extends Controller {

	/**
	 * 查询优惠券，可以根据状态分类查询
	 * @param customerId(用户id) value(页数)	state(分类==0全部，1未使用，2已使用，3已过期)
	 * @return json
	 */
	public function coupons_list() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$page = array_key_exists('value', $param) ? $param['value'] : 0;
			if (array_key_exists('state', $param))
				$value = $param['state'] ? $param['state'] : 0;
			if ($value == 0)
				$state = 0;
			elseif ($value == 1)//未使用
				$state = '1, 2';
			elseif ($value == 2)//已使用
				$state = 3;
			elseif ($value == 3)//已过期
				$state = 4;

			$limit = $this->config->get('config_catalog_limit');
			$data = array(
				'customerId' => $customerId,
				'state' => $state,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);

			$this->load->model('app/account');
			$coupons = $this->model_app_account->getCoupon($data);

			if ($coupons) {
				foreach ($coupons as $coupon) {
					if ($coupon['state'] == 3) {//已使用
						$status = 2;
					} else {
						if (time() > $coupon['endtime'])//已过期
							$status = 3;
						elseif ($coupon['state'] == 1 || $coupon['state'] == 2)//未使用
							$status = 1;
					}
					$result[] = array(
						'cid' => $coupon['cid'],
						'sn' => $coupon['sn'],
						'uid' => $coupon['uid'],
						'uname' => $coupon['uname'],
						'getway' => $coupon['getway'],
						'endtime' => $coupon['endtime'],
						'addtime' => $coupon['addtime'],
						'money' => $coupon['money'],
						'sellmoney' => $coupon['sellmoney'] ? $coupon['sellmoney'] : 0,
						'state' => $status
						);
				}
			} else {
				$result = array();
			}

			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	/**
	 * 查询充值记录，可以根据时间范围查找
	 * @param  customerId(用户id) value(页数) scope(时间范围==0全部，1近一个月，2近三个月，3近半年，4近一年)
	 * @return json 
	 */
	public function recharge_record($scope=0) {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$page = $param['value'];
			if (array_key_exists('scope', $param))
				$scope = $param['scope'] ? $param['scope'] : 0;
			if ($scope == 0)//全部记录
				$addtime = 0;
			elseif ($scope == 1)//近一个月
				$addtime = strtotime("-1 months", time());
			elseif ($scope == 2)//近三个月
				$addtime = strtotime("-3 months", time());
			elseif ($scope == 3)//近半年
				$addtime = strtotime("-6 months", time());
			elseif ($scope == 4)//近一年
				$addtime = strtotime("-1 year", time());

			$limit = $this->config->get('config_catalog_limit');
			$data = array(
				'customerId' => $customerId,
				'addtime' => $addtime,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);

			$this->load->model('app/account');
			$records = $this->model_app_account->getRechargeRecord($data);

			if ($records) {
				foreach ($records as $record) {
					$result[] = array(
						'rid' => $record['rid'],
						'customer_id' => $record['customer_id'],
						'firstname' => $record['firstname'],
						'sn' => $record['sn'] ? $record['sn'] : '',
						'amount' => $record['amount'],
						'currency' => $record['currency'],
						'money' => $record['money'],
						'paytype' => $record['paytype'],
						'payname' => $record['payname'],
						'accountmoney' => $record['accountmoney'],
						'addtime' => $record['addtime'],
						'successtime' => $record['successtime'] ? $record['successtime'] : '',
						'remark' => $record['remark'] ? $record['remark'] : '',
						'state' => $record['state']
						);
				}
			} else {
				$result = array();
			}

			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	/**
	 * 查询消费记录
	 * @param  customerId(用户id) value(页数) scope(分类==0全部，1代购，2运单)
	 * @return json
	 */
	public function expense_record($scope=0) {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$page = $param['value'];
			if (array_key_exists('scope', $param))
				$scope = $param['scope'] ? $param['scope'] : 0;
			/*if ($scope == 0)
				$action = 0;
			elseif ($scope == 1)
				$action = '1, 2';
			elseif ($scope == 2)
				$action = 3;
			elseif ($scope == 3)
				$action = 5;*/

			$limit = $this->config->get('config_catalog_limit');
			$data = array(
				'customerId' => $customerId,
				'scope' => $scope,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);

			$this->load->model('app/account');
			$records = $this->model_app_account->getExpenseRecord($data);

			if ($records) {
				foreach ($records as $record) {
					$type = $record['type'];
					$action = $record['action'];
					if ($type == 2 && $action != 3)//代购
						$type = 1;
					else//运单
						$type = 2;
					if (array_key_exists('remarktype', $record) && !empty($record['remarktype'])) {
						$type = $record['remarktype'];
						if (1 == $type) 
							$action = 2;//代购
						elseif (2 == $type) 
							$action = 3;//运单
					}
					if (array_key_exists('payname', $record)) {
						if ('余额支付' == $record['payname']) 
							$payname = 0;
						elseif ('Paypal支付' == $record['payname']) 
							$payname = 1;
						elseif ('支付宝支付' == $record['payname']) 
							$payname = 2;
						elseif ('支付宝国际信用卡支付' == $record['payname']) 
							$payname = 3;
						else 
							$payname = 5;
					} else 
						$payname = 5;
					$result[] = array(
						'rid' => $record['rid'],
						'uid' => $record['uid'],
						'uname' => $record['uname'],
						'type' => $type,
						'action' => $action,
						'money' => $record['money'],
						'accountmoney' => $record['accountmoney'],
						'remark' => $record['remark'],
						'addtime' => $record['addtime'],
						'payname' => $payname
						);
				}
			} else {
				$result = array();
			}

			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	/**
	 * 在线充值
	 * @param customerId(用户id) amount(充值金额) money(实际到帐金额(有损失)) type(1Paypal 2支付宝国际信用卡 3支付宝)
	 * @return json
	 */
	public function new_online_charge() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$amount = $param['amount'];//要充的
			$money = $param['money'];//实际到帐的
			$type = $param['type'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			if ($customer) {
				$accountmoney = $money + $customer['money'];
				$this->model_account_customer->editBalance($accountmoney, $customerId);

				if ($type == 1) {
					$paytype = 1;
					$payname = 'Paypal';
				} elseif ($type == 2) {
					$paytype = 2;
					$payname = '支付宝';
				} elseif ($type == 3) {
					$paytype = 3;
					$payname = '支付宝国际信用卡';
				}

				$data = array(
					'customerId' => $customerId,
                    'firstname' => $customer['firstname'],
                    'amount' => $amount,
                    'currency' => 'CNY',
                    'money' => $money,
                    'paytype' => $paytype,
                    'payname' => $payname,
                    'accountmoney' => $accountmoney,
                    'addtime' => time(),
                    'remark' => 'OK',
                    'state' => 1
                	);
				$this->load->model('app/account');
             $rid = $this->model_app_account->addRechargerecord($data);

                if ($rid) {
                	$eDate = array(
                		'rid' => $rid,
                		'successtime' => time()
                		);
                	$this->model_app_account->editRechargerecord($eDate);
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				///	$arr = json_encode(array('data' => array('resultCode' => 0,'errorMessage' => $this->language->get('error_savefailed'))));
					echo($arr);
				} else {
					$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_savefailed'))));
					echo($arr);
				}
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//查询当前积分
	public function scores() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);

			if ($customer) {
				$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => array('scores' => $customer['scores']))));
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

	/**
	 * 查询站内消息
	 * @param type(0全部消息，1系统消息，2交易消息)
	 */
	public function message_list() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$page = $param['value'];
			$type = $param['type'];

			$limit = $this->config->get('config_catalog_limit');
			$data = array(
				'customerId' => $customerId,
				'type' => $type,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);

			$this->load->model('app/account');
			$result = $this->model_app_account->getPm($data);

			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $result)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	/**
	 * 消息回复
	 * @param customerId(用户id) mid(消息id) msg(回复消息的内容)
	 */
	public function message_reply() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$mid = $param['mid'];
			$msg = $param['msg'];

			$this->load->model('account/pm');
        	$pm_infos = $this->model_account_pm->getPm2($mid);

        	if ($pm_infos) {
	        	$pm_info = $pm_infos[0];

		        $msg = array(
		            'fromuid' => $pm_info['touid'],
		            'fromuname' => $pm_info['touname'],
		            'touid' => $pm_info['fromuid'],
		            'touname' => $pm_info['fromuname'],
		            'type' => $pm_info['type'],
		            'subject' => $this->language->get('text_title') . $pm_info['touid'] . "原标题：" . $pm_info['subject'],
		            'sendtime' => time(),
		            'writetime' => $mid,
		            'hasview' => 0,
		            'isadmin' => 0,
		            'message' => $msg
		        );

		        $pm = $this->model_account_pm->addPm($msg);

		        if ($pm) {
					$arr = json_encode(array('data' => array('resultCode' => 1)));
					echo($arr);
				} else {
					$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_failed'))));
					echo($arr);
				}
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notfound'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	/* 此接口已合到支付中去
	public function record_add() {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$type = $param['type'];
			$oid = $param['oid'];
			$money = $param['money'];

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);

			if ($customer) {
				if ($type == 1) {
					$action = 3;
					$remark = '提交运单费用，运单ID：';
				} elseif ($type == 2) {
					$action = 2;
					$remark = '提交代购订单费用，订单ID：';
				}
				$data = array(
					'uid' => $customerId,
	                'firstname' => $customer['firstname'],
	                'type' => $type,
	                'action' => $action,
	                'money' => $money,
	                'accountmoney' => $customer['money'],
	                'remark' => $remark . $oid,
	                'addtime' => time()
	                );
				$this->load->model('app/account');
	            $this->model_app_account->addRecord($data);

				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notlogin'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}*/

}