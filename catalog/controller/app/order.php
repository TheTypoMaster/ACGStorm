<?php

/**
 * @description：手机接口订单部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-7
 */
Class ControllerAppOrder extends Controller {

	//查询所有订单，以及各自状态下的订单
	public function orders_search () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (isset($this->request->post['param'])){
				$str = str_replace("&quot;", "\"", $this->request->post['param']);
			}else{
				$str = '';
			}
			if (!empty($str)){
				$param = json_decode($str, true);
			}else{
				$param = array();
			}
			$customerId = $param['customerId'];
			$page = $param['value'];
			$order_status_id = null;
			if (array_key_exists('order_status_id', $param))
				$order_status_id = $param['order_status_id'] ? $param['order_status_id'] : null;
			$order_status_buy = 0;
			if (array_key_exists('order_status_buy', $param))
				$order_status_buy = $param['order_status_buy'] ? $param['order_status_buy'] : 0;

			$limit = $this->config->get('config_catalog_limit');
			$data = array(
				'username_id' => $customerId,
				'order_status_id' => $order_status_id,//1待付款，3待发货
				'order_status_buy' => $order_status_buy,//1代购，2自助购，3代寄
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);
			$this->load->model('order/order');
			$this->load->model('app/order');
			$results = $this->model_app_order->getOrders($data);

			$resultData = array();
			$goodsList = array();

			//订单表里的商品有两个来源
			//1、从淘宝抓取的，img字段存放形式'http://***'
			//2、从网站商场获取的，img字段存放形式'data/***'
			$reg = '/^http:\/\//';
			$express = '';
			$express_number = '';
			foreach ($results as $result) {
				$products = $this->model_order_order->getOrderProducts($result['order_id']);
				foreach ($products as $product) {
					$goodsList[] = array(
						'url' => $product['producturl'],
						// 'goodsImage' => $product['img'],
						// 'goodsImage' => 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['img'],
						'goodsImage' => preg_match($reg, $product['img']) ? $product['img'] : 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['img'],
						'name' => $product['name'],
						'buyColor' => $product['option_color'],
						'buySize' => $product['option_size'],
						'realPrice' => $product['price'],
						'remark' => $product['note'],
						'buyQuantity' => $product['quantity'],
						'sensitive' => $product['order_sensitive']
						);
					$express = $product['express'] ? $product['express'] : '';
					$express_number = $product['kuaidi_no'] ? $product['kuaidi_no'] : '';
				}
				if (!empty($goodsList)) {
					$resultData[] = array(
						'orderId' => $result['order_id'],
						'storeName' => $result['store_name'],
						'orderStatus' => $result['order_status_id'],//数字状态
	                	'orderStatusC' => $result['status'],//汉字状态
	                	'receiveAddress' => '广东省深圳市宝安区西乡三围航空路30号同安物流园D栋301（信恩世通代寄部）',
	                	'mailCode' => '518101',
	                	'receiver' => $result['customer'],
	                	'telePhone' => '0755-81466633',
	                	'yunfei' => $result['order_shipping'],
	                	'orderDate' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
	                	'orderAllCost' => $result['total'],
	                	'express' => $express,
	                	'express_number' => $express_number,
	                	'goodsList' => $goodsList
						);
				}
				$goodsList = array();
			}
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $resultData)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//查询我的仓库列表
	public function order_myhome () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$page = $param['value'];
			$limit = $this->config->get('config_catalog_limit');
			$data = array(
            	'username_id' => $customerId,
            	'order_status_id' => 6,
            	'start' => ($page - 1) * $limit,
				'limit' => $limit
        		);
			$this->load->model('order/order');
			$this->load->model('app/order');
			$results = $this->model_app_order->getOrders($data);

			$resultData = array();
			$goodsList = array();

			//订单表里的商品有两个来源
			//1、从淘宝抓取的，img字段存放形式'http://***'
			//2、从网站商场获取的，img字段存放形式'data/***'
			$reg = '/^http:\/\//';

			foreach ($results as $result) {
				if ($result['order_status_id'] != 3) {
					$products = $this->model_order_order->getOrderProducts($result['order_id']);
					$weight = 0;
					$packageFee = 0;
					foreach ($products as $product) {
						$goodsList[] = array(
							'url' => $product['producturl'],
							'goodsImage' => preg_match($reg, $product['img']) ? $product['img'] : 'http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['img'],
							'name' => $product['name'],
							'buyColor' => $product['option_color'],
							'buySize' => $product['option_size'],
							'realPrice' => $product['price'],
							'remark' => $product['note'],
							'buyQuantity' => $product['quantity'],
							'isSensitive' => $product['order_sensitive']
							);
						$weight += $product['weight'];
						$packageFee += $product['price'];
					}
					if (!empty($goodsList)) {
						$resultData[] = array(
							'packageNo' => $result['order_id'],
							'packageFee'=> $packageFee,
							'packageWeight' => $weight,
							'packageType' => $result['order_status_buy'],
		                	'packageDate' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
		                	'goodsList' => $goodsList
							);
					}
					$goodsList = array();
				} else {//代寄
					$product = $this->model_order_order->getOrderProducts($result['order_id']);
					$resultData[] = array(
						'packageNo' => $result['order_id'],
						'packageTitle' => $product['name'],
						'packageWeight' => $product['weight'] ? $$product['weight'] : 0,
						'packageType' => $result['order_status_buy'],
		                'packageDate' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
		                'packageRemark' => $product['note'],
		                'isSensitive' => $product['order_sensitive']
						);
				}
			}
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $resultData)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//订单取消
	public function order_cancel () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$order_id = $param['orderId'];
			$this->load->model('order/order');
			$this->model_order_order->deleteOrder($order_id);
			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//查询余额
	public function getBalance () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			if ($customer) {
				$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => array('balance' => $customer['money']))));
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

	//余额支付
	public function balance_payment ($yundan=0) {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$orderIds = $param['orderIds'];
			$total = $param['money'];
			$oid = $orderIds;
			if (array_key_exists('yundan', $param))
				$yundan = $param['yundan'] ? $param['yundan'] : 0;

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			$balance = $customer['money'];
			$difference = $balance - $total;
			if ($difference >= 0) {
				$this->load->model('app/order');
				$this->load->model('order/order');
				$orderIds = explode(',', $orderIds);
				if ($yundan) {//国际运单
					$type = 1;
					$data = array(
						'state'  => 1,
	                	'sid'    => $orderIds[0]
						);
					$this->model_order_order->Updatestate($data);
					$sendorder_info = $this->model_order_order->getSendorderById($orderIds[0]);
					$order_id_array = array();
	                if(strstr($sendorder_info['oids'], ','))
		           		$order_id_array[] = explode("," ,$sendorder_info['oids']);
		         	else
		            	$order_id_array[] = $sendorder_info['oids'];
					$this->model_app_order->order_updat($order_id_array, '8', '1');
					$this->model_account_customer->editBalance($difference, $customerId);
				} else {//订单
					$type = 2;
					foreach ($orderIds as $orderId) {
		                $this->model_app_order->update($orderId, '2', '1');
		                $this->model_account_customer->editBalance($difference, $customerId);
					}
				}

				//增加消费记录
				$data = array(
					'type' => $type,
					'customerId' => $customerId,
					'firstname' => $customer['firstname'],
					'money' => $total,
					'action'=>'S1',
					'accountmoney' => $difference,
					'oid' => $oid,
					'paytype' => '0',
					'balance'=>$balance
					);
				$this->record_add($data);

				$this->send_email($yundan, $customer['email'], $customer['firstname']);
				$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $difference)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_lack_balance'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//第三方支付
	public function third_party_payment ($yundan=0) {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$customerId = $param['customerId'];
			$orderIds = $param['orderIds'];
			$money = $param['money'];
			if (array_key_exists('type', $param)) 
				$paytype = $param['type'];
			else 
				$paytype = '';
			$oid = $orderIds;
			if (array_key_exists('yundan', $param))
				$yundan = $param['yundan'] ? $param['yundan'] : 0;

			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			$this->load->model('app/order');
			$orderIds = explode(',', $orderIds);
			if ($yundan) {//国际运单
				$type = 1;
				$data = array(
					'state'  => 1,
	               	'sid'    => $orderIds[0]
					);
				$this->load->model('order/order');
				$this->model_order_order->Updatestate($data);
				$sendorder_info = $this->model_order_order->getSendorderById($orderIds[0]);
				$order_id_array = array();
	            if(strstr($sendorder_info['oids'], ','))
		      		$order_id_array[] = explode("," ,$sendorder_info['oids']);
		       	else
		          	$order_id_array[] = $sendorder_info['oids'];
				$this->model_app_order->order_updat($order_id_array, '8', '1');
			} else {//订单
				$type = 2;
				foreach ($orderIds as $orderId) {
	                $this->model_app_order->update($orderId, '2', '1');
				}
			}

			//增加消费记录
			$data = array(
				'type' => $type,
				'customerId' => $customerId,
				'firstname' => $customer['firstname'],
				'money' => $money,
				'accountmoney' => $customer['money'],
				'oid' => $oid,
				'paytype' => $paytype
				);
			$this->record_add($data);

			// $this->send_email($yundan, $customer['email'], $customer['firstname']);
			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//增加消费记录
	public function record_add($data) {
		/*if ($data['type'] == 1) {
			$action = 3;
			$remark = '提交运单费用，运单ID：';
		} elseif ($data['type'] == 2) {
			$action = 2;
			$remark = '提交代购订单费用，订单ID：';
		}
		$data2 = array(
			'customerId' => $data['customerId'],
	        'firstname' => $data['firstname'],
	        'type' => $data['type'],
	        'action' => $action,
	        'money' => $data['money'],
	        'accountmoney' => $data['accountmoney'],
	        'remark' => $remark . $data['oid'],
	        'addtime' => time()
	        );
		$this->load->model('app/account');
	    $this->model_app_account->addRecord($data2);*/
	    if ($data['paytype'] === '0') {
	    	$payname = '余额支付';
	    } elseif ($data['paytype'] === '1') {
	    	$payname = 'Paypal支付';
	    } elseif ($data['paytype'] === '2') {
	    	$payname = '支付宝支付';
	    } elseif ($data['paytype'] === '3') {
	    	$payname = '支付宝国际信用卡支付';
	    } else {
	    	$payname = '';
	    }

	    if ($data['type'] == 1) {
			$remark     =$data['action']. '提交运单费用，运单ID：';
			$remarktype = 2;
		} elseif ($data['type'] == 2) {
			$remark     = $data['action'].'提交代购订单费用，订单ID：';
			$remarktype = 1;
		}

		$data2 = array(
			'uid'           => $data['customerId'],
			'firstname'     => $data['firstname'],
			'payname'       => $payname,
			'money'         => -$data['money'],
			'accountmoney'  => $data['accountmoney'],
			'remark'        => $remark . $data['oid'].',原始余额:'.$data['balance'],
			'remarktype'    => $remarktype,
			'remarkdetails' => $data['oid'],
			'addtime'       => time()
			);

		$this->load->model('account/record');
		$this->model_account_record->addRecord($data2);
	}

	//发送邮件
	private function send_email ($yundan, $customer_email, $customer_name) {
        if (!$yundan) {
			$subject = "CNstorm订单确认邮件";
		
		    $message = "
			<div style='width:600px; margin:0 auto;'>
			<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
			<div style='clear:both; height:20px; width:100%'></div>
			<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
			<div style='width:560px; margin:0 auto; font-size:14px'>
			<p >亲爱的 ".$customer_name.",</p>
			<p > </p>
			<p ><strong>您的订单已提交成功！</strong> </p>
			<p >
			<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>接下来我们将在一个工作日内为您处理订单，请您留意并耐心等待（<a href='http://www.acgstorm.com/index.php?route=order/order'>查看订单</a>）</div>
			</p>
			<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。您的商品到货后将可免费保管两个月，接下来您可以： </p>
			<p > </p>
			<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
			<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >自助购</a>） </p>
			<p >3、&nbsp;亲人朋友准备包裹并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。(<a href='http://www.acgstorm.com/index.php?route=international/express' >国际转运</a>)。 </p>
			<p > </p>
			<p >我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href='http://www.acgstorm.com/index.php?route=help/normalquestion' >点此查阅</a>。 </p>
			<p > </p>
			<p >如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或通过下方电子邮件与我们取得联系。 </p>
			<p > </p>
			<p >Email:&nbsp;support@cnstorm.com </p>
			<p > </p>
			<p >我们衷心感谢您选择并使用CNstorm为您服务！ </p>
			<p > </p>
			<p > </p>
			<p >CNstorm客户关怀部 </p>
			<p > </p>
			<p  style='text-align:center'>&#169;Copyright&nbsp;2014&nbsp;CNstorm&nbsp; </p>
			</div>
			</div>
			</div>";
		} else {
			$subject = "CNstorm国际运单确认邮件";
	
            $message = "
			<div style='width:600px; margin:0 auto;'>
			<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
			<div style='clear:both; height:20px; width:100%'></div>
			<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
			<div style='width:560px; margin:0 auto; font-size:14px'>
			<p >亲爱的 ".$customer_name.",</p>
			<p > </p>
			<p ><strong>您的国际运单已提交成功！</strong> </p>
			<p >
			<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>接下来我们将在一个工作日内为您处理运单，请您留意并耐心等待（<a href='http://www.acgstorm.com/index.php?route=order/order/order_guoji'>查看运单</a>）</div>
			</p>
			<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。您的商品到货后将可免费保管两个月，接下来您可以： </p>
			<p > </p>
			<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
			<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >自助购</a>） </p>
			<p >3、&nbsp;亲人朋友准备包裹并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。(<a href='http://www.acgstorm.com/index.php?route=international/express' >国际转运</a>)。 </p>
			<p > </p>
			<p >我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href='http://www.acgstorm.com/index.php?route=help/normalquestion' >点此查阅</a>。 </p>
			<p > </p>
			<p >如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或通过下方电子邮件与我们取得联系。 </p>
			<p > </p>
			<p >Email:&nbsp;support@cnstorm.com </p>
			<p > </p>
			<p >我们衷心感谢您选择并使用CNstorm为您服务！ </p>
			<p > </p>
			<p > </p>
			<p >CNstorm客户关怀部 </p>
			<p > </p>
			<p  style='text-align:center'>&#169;Copyright&nbsp;2014&nbsp;CNstorm&nbsp; </p>
			</div>
			</div>
			</div>";
		}

		/*$mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->hostname = $this->config->get('config_smtp_host');
        $mail->username = $this->config->get('config_smtp_username');
        $mail->password = $this->config->get('config_smtp_password');
        $mail->port = $this->config->get('config_smtp_port');
        $mail->timeout = $this->config->get('config_smtp_timeout');
        $mail->setTo($customer_email);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender($this->config->get('config_name'));
        $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
        $mail->setHtml(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
        $mail->send();*/

        $data = array(
           'sendto' 	=> $customer_email,
           'receiver' 	=> $this->config->get('config_email'),
           'subject' 	=> html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
           'msg' 		=> html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
            );
        $this->load->model('tool/sendmail');
        $this->model_tool_sendmail->send($data);
	}

	//补填快递信息
	public function express_rewrite () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$expresses = $param['expresses'];
			$expressNo = $param['expressNo'];
			$orderId = $param['orderId'];

			$kaidi_data = array(
            	'order_kaudi' => $expresses,
            	'order_kuaidi_no' => $expressNo,
            	'order_id' => $orderId
        		);

			$this->load->model('order/order');
        	$this->model_order_order->update_kuaidi2($kaidi_data);
			$arr = json_encode(array('data' => array('resultCode' => 1)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//物流跟踪
	public function track() {
		$key = '0e0a21c9be52379d';
		$expresser = 'yuantong';
		$expressno = '9380411789';
		// $url = 'http://www.kuaidi100.com/applyurl?key=' . $key . '&com=' . $expresser . '&nu=' . $expressno;
		// $url="http://www.kuaidi100.com/api?id=0e0a21c9be52379d&com=yuantong&nu=9380411789&show=0&muti=1";
		// $url = 'http://wap.kuaidi100.com/wap_result.jsp?rand=20120517&id=yuantong&fromWeb=null&&postid=9380411789';
		$url = 'http://m.kuaidi100.com/index_all.html?type=yuantong&postid=9380411789';
        if (function_exists('curl_init') == 1) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
            curl_setopt($curl, CURLOPT_TIMEOUT, 5);
            $get_content = curl_exec($curl);
            curl_close($curl);
        }
        echo($get_content);
        // echo('<iframe src="' . $get_content .
        //                 '" width="580" height="260" frameborder="0" scrolling="no"><br/>');
        // echo file_get_contents('http://www.baidu.com');
        // echo file_get_contents($get_content);
	}

}
?>