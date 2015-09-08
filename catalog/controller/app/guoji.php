<?php

/**
 * @description：手机接口国际运单部分操作
 * @author：fc@cnstorm.com
 * @date：2014-8-15
 */
Class ControllerAppGuoji extends Controller {

	//查询运输方式
	public function address () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$areaid = $param['areaid'];
			$mingan = $param['mingan'];
			
			$this->load->model('app/guoji');
			$data = $this->model_app_guoji->address_yundan($areaid, $mingan);

			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => $data)));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//国际运单提交
	public function submit_bak () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);

			$customerId = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			$name = $customer['firstname'];
			$email = $customer['email'];

			$this->load->model('app/guoji');
			$orderIds = $param['orderIds'];
			$orderIdsArr = explode(',', $orderIds);
			foreach ($orderIdsArr as $orderId) {
				$this->model_app_guoji->update_status($orderId, '8', $email, $name);
			}
			
			$scoreuse = array_key_exists('scoreuse', $param) ? $param['scoreuse'] : 0;
			$scores = $customer['scores'];
			$newscore = $scores - $scoreuse;
			if ($newscore >= 0 && $scoreuse > 0) {
				$this->load->model('account/record');
            	$this->load->model('app/user');
            	$this->model_app_user->editScores($newscore, $customerId);
            	$insert_score_record = array(
            		'uid' => $customerId,
            		'firstname' => $name,
            		'remark' => $scoreuse.'积分抵扣运费',
            		'score' => '-'.$scoreuse,
            		'totalscore' => $newscore,
            		'type' => 2//1获取2消费
        			);
            	$this->model_account_record->addScoreRecord($insert_score_record);
			} else {
				$scoreuse = 0;
            	$newscore = $scores;
			}

			//优惠券
			$couponId = array_key_exists('couponId', $param) ? $param['couponId'] : 0;

	        $insert_data = array(
	        	'couponId'=>$couponId,
	        	'usescore'=>$scoreuse,
	            'address_id' => $param['address_id'],
	            'username_id' => $customerId,
	            'zengzhi' => $param['zengzhi'],
	            'cailiao' => $param['cailiao'],
	            'dingdan' => $param['dingdan'],
	            'dabao' => $param['dabao'],
	            'usrname' => $name,
	            'email' => $customer['email'],
	            'soids' => $orderIds,
	            'newscore' => $newscore,
	            'deliveryname' => $param['deliveryname'],
	            'status_id' => "0",
	            'freight' => $param['freight'],
	            'over_yunfei' => $param['total_freight'],
	            'all_weight' => $param['all_weight'],
	            'serverfee' => $param['serverfee'],
	        	'wrapperfee' => $param['wrapperfee'],
	            'did' => array_key_exists('did', $param) ? $param['did'] : 0,
	            'remark' => array_key_exists('remark', $param) ? $param['remark'] : 0
	        	);
        	$this->load->model('guoji/guoji');

        	$insert_guoji_yundan = $this->model_guoji_guoji->insert_guoji_yundan_bak($insert_data);

        	$subject = '您的CNstorm运单' . $insert_guoji_yundan . '已经提交运送！';

        	$message = "<div style='width:600px; margin:0 auto;'>
    				<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/image/data/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
    				<div style='clear:both; height:20px; width:100%'></div>
    				<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
    				<div style='width:560px; margin:0 auto; font-size:14px'>
    				<p >亲爱的&nbsp;$name, </p>
    				<p > </p>
    				<p ><strong>您的订单已提交运送！</strong> </p>
    				<p >
    				<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>感谢您选择并使用 CNstorm 为您服务！我们已经收到了您的运单号： $insert_guoji_yundan 提交运送申请，接下来我们将开始打包您的包裹
    				 并将在 2 个工作日内(除周日)将您的包裹交付指定的快递公司.在我们发送您的包裹后，您可访问“会员中心” – “<a href='http://www.acgstorm.com/index.php?route=order/order/order_guoji' >运单</a>”查询您的物流跟踪信
    				 息。 
    				 如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或回复本邮件与我们取得联系。
    				 我们非常荣幸能为您服务，期待您的下次访问! </br>
    	                         
    	                        </div>
    				</p>
    				<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以： </p>
    				<p > </p>
    				<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
    				<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >代寄</a>） </p>
    				<p >3、&nbsp;亲人朋友生日，重大节日，纪念日...&nbsp;CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href='http://www.acgstorm.com/index.php?route=international/express' >国内送</a>)。 </p>
    				<p >4、&nbsp;立刻勾选您要邮寄的商品提交运送(<a href='http://www.acgstorm.com/index.php?route=order/order/order_myhome' >查看订单并提交</a>) </p>
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

			$data = array(
	           'sendto'     => $email,
	           'receiver'   => $this->config->get('config_email'),
	           'subject'    => html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
	           'msg'        => html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
	            );
	        $this->load->model('tool/sendmail');
	        $this->model_tool_sendmail->send($data);

        	if ($insert_guoji_yundan) {
        		//修改优惠券的状态
        		if ($couponId) {
        			$data = array(
        				'couponId' => $couponId,
        				'state' => 3
        				);
        			$this->load->model('app/account');
        			$this->model_app_account->updateCoupon($data);
				}

				$arr = json_encode(array('data' => array('resultCode' => 1, 'data' => $insert_guoji_yundan)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_failed'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//国际运单提交
	public function submit () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
	
			$customerId = $param['customerId'];
			$this->load->model('account/customer');
			$customer = $this->model_account_customer->getCustomer($customerId);
			$name = $customer['firstname'];
			$email = $customer['email'];
	
			$this->load->model('app/guoji');
			$orderIds = $param['orderIds'];
			$orderIdsArr = explode(',', $orderIds);
			foreach ($orderIdsArr as $orderId) {
				$this->model_app_guoji->update_status($orderId, '8', $email, $name);
			}
				
			$scoreuse = array_key_exists('scoreuse', $param) ? $param['scoreuse'] : 0;
			$scores = $customer['scores'];
			$newscore = $scores - $scoreuse;
			if ($newscore >= 0 && $scoreuse > 0) {
				$this->load->model('account/record');
				$this->load->model('app/user');
				$this->model_app_user->editScores($newscore, $customerId);
				$insert_score_record = array(
						'uid' => $customerId,
						'firstname' => $name,
						'remark' => $scoreuse.'积分抵扣运费',
						'score' => '-'.$scoreuse,
						'totalscore' => $newscore,
						'type' => 2//1获取2消费
				);
				$this->model_account_record->addScoreRecord($insert_score_record);
			} else {
				$scoreuse = 0;
				$newscore = $scores;
			}
	
			//优惠券
			$couponId = array_key_exists('couponId', $param) ? $param['couponId'] : 0;
	
			$insert_data = array(
					'address_id' => $param['address_id'],
					'username_id' => $customerId,
					'zengzhi' => $param['zengzhi'],
					'cailiao' => $param['cailiao'],
					'dingdan' => $param['dingdan'],
					'dabao' => $param['dabao'],
					'usrname' => $name,
					'email' => $customer['email'],
					'soids' => $orderIds,
					'newscore' => $newscore,
					'deliveryname' => $param['deliveryname'],
					'status_id' => "0",
					'freight' => $param['freight'],
					'over_yunfei' => $param['total_freight'],
					'all_weight' => $param['all_weight'],
					'serverfee' => $param['serverfee'],
					'did' => array_key_exists('did', $param) ? $param['did'] : 0,
					'remark' => array_key_exists('remark', $param) ? $param['remark'] : 0
			);
			$this->load->model('guoji/guoji');
	
			$insert_guoji_yundan = $this->model_guoji_guoji->insert_guoji_yundan($insert_data);
	
			$subject = '您的CNstorm运单' . $insert_guoji_yundan . '已经提交运送！';
	
			$message = "<div style='width:600px; margin:0 auto;'>
			<div style='height:75px; overflow:hidden; border-bottom:2px solid #ccc'><img src='http://www.acgstorm.com/image/data/logo.png' style='float:left'/><span style='float:right; font-size:20px; color:red; font-weight:bold; line-height:90px'>[感谢使用CNstorm]</span></div>
			<div style='clear:both; height:20px; width:100%'></div>
			<div style='width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0'>
			<div style='width:560px; margin:0 auto; font-size:14px'>
			<p >亲爱的&nbsp;$name, </p>
			<p > </p>
			<p ><strong>您的订单已提交运送！</strong> </p>
			<p >
			<div style='width:90%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>感谢您选择并使用 CNstorm 为您服务！我们已经收到了您的运单号： $insert_guoji_yundan 提交运送申请，接下来我们将开始打包您的包裹
			并将在 2 个工作日内(除周日)将您的包裹交付指定的快递公司.在我们发送您的包裹后，您可访问“会员中心” – “<a href='http://www.acgstorm.com/index.php?route=order/order/order_guoji' >运单</a>”查询您的物流跟踪信
			息。
			如果您需要联系我们的客户服务小组，请访问我们的官网(www.acgstorm.com)点击左上角客服中心，或回复本邮件与我们取得联系。
			我们非常荣幸能为您服务，期待您的下次访问! </br>
	
			</div>
			</p>
			<p >CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以： </p>
			<p > </p>
			<p >1、&nbsp;继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href='http://www.acgstorm.com/index.php?route=procurement/procurement' >代购</a>) </p>
			<p >2、&nbsp;您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href='http://www.acgstorm.com/index.php?route=selfshopping/selfshopping' >代寄</a>） </p>
			<p >3、&nbsp;亲人朋友生日，重大节日，纪念日...&nbsp;CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href='http://www.acgstorm.com/index.php?route=international/express' >国内送</a>)。 </p>
			<p >4、&nbsp;立刻勾选您要邮寄的商品提交运送(<a href='http://www.acgstorm.com/index.php?route=order/order/order_myhome' >查看订单并提交</a>) </p>
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
	
			$data = array(
			'sendto'     => $email,
			'receiver'   => $this->config->get('config_email'),
			'subject'    => html_entity_decode($subject, ENT_QUOTES, 'UTF-8'),
			'msg'        => html_entity_decode($message, ENT_QUOTES, 'UTF-8'),
			);
			$this->load->model('tool/sendmail');
			$this->model_tool_sendmail->send($data);
	
			if ($insert_guoji_yundan) {
				//修改优惠券的状态
				if ($couponId) {
					$data = array(
						'couponId' => $couponId,
						'state' => 3
					);
					$this->load->model('app/account');
					$this->model_app_account->updateCoupon($data);
				}

				$arr = json_encode(array('data' => array('resultCode' => 1, 'data' => $insert_guoji_yundan)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_failed'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}
	
	//查询国际运单列表
	public function guoji_list () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$page = $param['value'];
			$limit = $this->config->get('config_catalog_limit');
			if (array_key_exists('status', $param)) {
				//=0全部，1待付款，2待发货，3待收货
				//待付款数据库是0，待发货数据库是1，5，待收货数据库是2
				$status = $param['status'] ? $param['status'] : 0;
			} else {
				$status = 0;
			}
			$this->load->model('order/order');

			$data = array(
				'username_id' => $param['customerId'],
				'order_status_id' => $status,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
				);
			$this->load->model('order/order');
			$this->load->model('app/order');
			$results = $this->model_app_order->select_send_porduct($data);
			$temp = array();
			$goodsList = array();
			$result = array();
			foreach ($results as $yundan) {
				$oids = explode(',', $yundan['oids']);
				foreach ($oids as $oid) {
					$this->load->model('app/order');
					$order = $this->model_app_order->getOrder($oid);

					$products = $this->model_order_order->getOrderProducts($oid);
					foreach ($products as $product) {
						$temp[] = array(
							'url' => $product['producturl'] ? $product['producturl'] : '',
							'goodsImage' => $product['img'] ? ('http://' . $this->request->server['HTTP_HOST'] . '/image/' . $product['img']) : '',
							'name' => $product['name'] ? $product['name'] : '',
							'buyColor' => $product['option_color'] ? $product['option_color'] : '',
							'buySize' => $product['option_size'] ? $product['option_size'] : '',
							'realPrice' => $product['total'] ? $product['total'] : float(0.00),
							'remark' => $product['note'] ? $product['note'] : '',
							'buyQuantity' => $product['quantity'] ? $product['quantity'] : 0
							);
					}					
					$goodsList[] = array(
						'oid' => $oid,
						'type' => $order['order_status_buy'],
						'goodsList' => $temp
						);
					$temp = array();
				}
				$result[] = array(
					'yunfei' => $yundan['totalfee'] ? $yundan['totalfee'] : float(0.00),
                	'wayStatus' => $yundan['state'],
                	'wayNo' => $yundan['sid'],
	                'receiveAddress' => $yundan['country'] . ' ' . $yundan['city'] . ' ' . $yundan['address'],
	                'mailCode' => $yundan['zip'] ? $yundan['zip'] : '',
	                'receiver' => $yundan['consignee'] ? $yundan['consignee'] : '',
	                'telePhone' => $yundan['tel'] ? $yundan['tel'] : '',
	                'weight' => $yundan['countweight'] ? $yundan['countweight'] : '',
	                'wayDate' => $yundan['uptime'] ? date('Y-m-d H:i:s', $yundan['uptime']) : date('Y-m-d H:i:s', $yundan['addtime']),
	                'express' => $yundan['deliveryname'] ? $yundan['deliveryname'] : '',
					'express_number' => $yundan['sn'] ? $yundan['sn'] : '',
	                'ordersList' => $goodsList
					);
				$goodsList = array();
			}
$arr=array();
			$arr = json_encode(array('data' => array('resultCode' => 1, 'result' => array())));
			echo($arr);
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

	//取消国际运单
	public function cancel () {
		$this->language->load('app/app');
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			$str = str_replace("&quot;", "\"", $this->request->post['param']);
			$param = json_decode($str, true);
			$sid = $param['wayId'];
			
			$this->load->model('order/order');
			//将物品由已提交运送状态改为已入库状态
			$sendorder = $this->model_order_order->getSendorderById($sid);
			if ($sendorder) {
				$oids = explode(',', $sendorder['oids']);
				$this->model_order_order->order_updat($oids, 6);
				
				$this->model_order_order->guoji_quxiao($sid);
				$arr = json_encode(array('data' => array('resultCode' => 1)));
				echo($arr);
			} else {
				$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_notfound'))));
				echo($arr);
			}
		} else {
			$arr = json_encode(array('data' => array('resultCode' => 0, 'errorMessage' => $this->language->get('error_post'))));
			echo($arr);
		}
	}

}