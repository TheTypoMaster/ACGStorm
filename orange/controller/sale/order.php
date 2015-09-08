<?php
class ControllerSaleOrder extends Controller {
	private $error = array ();
	public function index() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		$this->getList ();
	}
	public function pcReq() {
		$this->load->model ( 'sale/order' );
		$this->model_sale_order->updatePcReq ( $_POST ['order_id'], $_POST ['sign'] );
		$msg = array (
				'msg' => '请求成功' 
		);
		echo json_encode ( $msg );
	}
	public function weight() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		$Adult_Value = $this->request->get ['AdultObj'];
		$order_product_id = $this->request->get ['order_product_id'];
		
		$result = $this->model_sale_order->weight_chage ( $order_product_id, $Adult_Value );
		if ($result) {
			$result = 1;
		} else {
			$result = 0;
		}
		$this->response->setOutput ( $result );
	}
	public function express() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		$Adult_Value = $this->request->get ['Adult_Value'];
		$order_product_id = $this->request->get ['order_product_id'];
		
		$result = $this->model_sale_order->express_chage ( $order_product_id, $Adult_Value );
		if ($result) {
			$result = 1;
		} else {
			$result = 0;
		}
		$this->response->setOutput ( $result );
	}
	public function tracking() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		$tracking = $this->request->get ['tracking'];
		$order_product_id = $this->request->get ['order_product_id'];
		
		$result = $this->model_sale_order->ajax_update_tracking ( $order_product_id, $tracking );
		if ($result) {
			$result = 1;
		} else {
			$result = 0;
		}
		$this->response->setOutput ( $result );
	}
	public function addState() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		
		$order_product_id = $this->request->get ['order_product_id'];
		$order_newstate = $this->request->get ['state'];
		$colorid = $this->request->get ['colorid'];
		$results = $this->model_sale_order->ajax_update_orderstues ( $order_product_id, $colorid, $order_newstate );
		
		$this->response->setOutput ( $results );
	}
	public function deleteOrder() {
		$this->language->load ( 'sale/order' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->load->model ( 'sale/order' );
		$this->load->model ( 'sale/customer' );
		
		$customerId = $this->request->post ['customerId'];
		$number = $this->request->post ['number'];
		$price = $this->request->post ['price']*$number;
		$uname = $this->request->post ['uname'];

		$order = $this->request->post ['orderId'];
		$productId = $this->request->post ['productId'];
		$money = $this->model_sale_customer->getmoneybyuid ( $customerId );
		$Newbalance = $price + $money;
		$res = $this->model_sale_order->getorder_special ( $productId );
		$record = implode('::',$res[0]);
		$data = array (
				'productId' => $productId,
				'customerId' => $customerId,
				'uname' => $uname,
				'orderId' => $order,
				'totalProduct' => $this->request->post ['totalProduct'],
				'remark' => $order . '订单商品取消退款' . $price . '元',
				'money' => $price,
				'accountmoney' => $Newbalance,
				'payname' => '取消订单返还',
				'record'=>$record
		);
		$results = isset($res[0]['order_product_id'])?1:0;
		if ($results) {
			$this->model_sale_order->deleteOrder ( $data );
			$this->model_sale_customer->editBalance ( $Newbalance, $uname );
			$email = $this->model_sale_customer->getEmail ( $uname );
			// 邮件发送模块
			$subject = "CNstorm订单". $order ."退款通知";
			$message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                                <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                                <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                                <div style = 'padding:0;margin:0;'>
                                <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                                <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                                <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                                <p><b style = 'color:#000;'>您的CNstorm订单由于缺货已退款！</b></p>
                                <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>订单号为$order 的订单由于卖家无库存，为保障您的消费权益，我们已申请退款并已将订单金额 ". $price ." 元返还到您的网站账户，请留意谢谢！（<a href = 'http://www.acgstorm.com/order.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看订单</a>）</br>   
                                </div>
                                <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                                1、 继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                                <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                                <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                                <p>4、 立刻勾选您要邮寄的商品提交运送(<a href = 'http://www.acgstorm.com/order.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>查看订单并提交</a>)</p>
                                <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                                <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                                <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                                <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                                </div>
                                </div>
                                </div>
                                <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                                <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                                <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                                <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                                <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                                </div>
                                </div>
                                </div>";
			$data = array (
					'sendto' => $email,
					'receiver' => $this->config->get ( 'config_email' ),
					'subject' => $subject,
					'msg' => $message 
			);
			$this->load->model ( 'tool/sendmail' );
			$this->model_tool_sendmail->send ( $data );
		}
		
		$this->response->setOutput ( $results );
	}
	public function updatefreight() {
		$this->load->model ( 'sale/order' );
		$this->load->model ( 'sale/customer' );
		$this->load->model ( 'record/record' );
		
		if (($this->request->server ['REQUEST_METHOD'] == 'POST')) {
			
			if (isset ( $this->request->post ['order_id'] )) {
				$order_id = $this->request->post ['order_id'];
			}
			
			if (isset ( $this->request->post ['cid'] ) && $this->request->post ['cid']) {
				
				$uid = $this->request->post ['cid'];
				
				$customer_info = $this->model_sale_customer->getCustomer ( $uid );
				
				$uname = $customer_info ['firstname'];
			}
			
			if (isset ( $this->request->post ['freight'] )) {
				
				$freight = $this->request->post ['freight'];
			}
			
			// 原来的订单运费
			$order_freight = $this->model_sale_order->getshippingbyoid ( $order_id );
			
			if ($order_freight > $freight) {
				
				$tempmoney = $order_freight - $freight;
				
				$user_balance = $this->model_sale_customer->getmoneybyuid ( $uid );
				
				$newbalance = round ( $user_balance + $tempmoney, 2 );
				
				$result = $this->model_sale_customer->editBalancebyid ( $newbalance, $uid );
				
				if ($result) {
					
					$note = "调整订单" . $order_id . "的运费为" . $freight . ",原来的运费为" . $order_freight . ",返回金额" . $tempmoney . "至用户的账户余额中";
					
					$data = array (
							'uid' => $uid,
							'uname' => $uname,
							'type' => 1,
							'action' => 5,
							'money' => $tempmoney,
							'accountmoney' => $newbalance,
							'remark' => $note 
					);
					
					$this->model_record_record->addRecord ( $data ); // 写记录
					
					$status = $this->model_sale_order->getstatusbyoid ( $order_id );
					
					if (9 == $status) {
						
						$this->model_sale_order->order_updat ( $order_id, 2 );
					}
				}
			} else if ($order_freight < $freight) {
				
				$tempmoney = $freight - $order_freight;
				
				$user_balance = $this->model_sale_customer->getmoneybyuid ( $uid );
				
				$newbalance = round ( $user_balance - $tempmoney, 2 );
				
				if ($newbalance >= 0) {
					
					$result = $this->model_sale_customer->editBalancebyid ( $newbalance, $uid ); // 扣去账户余额
					
					if ($result) {
						
						$note = "调整订单" . $order_id . "的运费为" . $freight . ",原来的运费为" . $order_freight . ",从用户的账户余额中扣除金额" . $tempmoney;
						
						$data = array (
								'uid' => $uid,
								'uname' => $uname,
								'type' => 1,
								'action' => 5,
								'money' => - $tempmoney,
								'accountmoney' => $newbalance,
								'remark' => $note 
						);
						
						$this->model_record_record->addRecord ( $data ); // 写记录
						
						$status = $this->model_sale_order->getstatusbyoid ( $order_id );
						
						if (9 == $status) {
							
							$this->model_sale_order->order_updat ( $order_id, 2 );
						}
					}
				} else {
					
					$this->model_sale_order->order_updat ( $order_id, "9" );
					
					$this->load->model ( 'tool/sendmail' );
					
					$email_info = $this->model_tool_sendmail->getinfobyoid ( $order_id );
					$email = $email_info ['email'];
					
					$message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                                <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                                <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                                <div style = 'padding:0;margin:0;'>
                                <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                                <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                                <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                                <p><b style = 'color:#000;'>CNstorm正等待您以下订单的操作指示！</b></p>
                                <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>订单号为$order_id 的订单实际运费略高于支付金额，为保障您的消费权益，我们需依据您的指示（取消或补差价购买）以处理该订单（<a href = 'http://www.acgstorm.com/order.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看订单</a>）</br>   
                                </div>
                                <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                                1、 继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                                <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                                <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                                <p>4、 立刻勾选您要邮寄的商品提交运送(<a href = 'http://www.acgstorm.com/order.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>查看订单并提交</a>)</p>
                                <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                                <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                                <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                                <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                                </div>
                                </div>
                                </div>
                                <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                                <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                                <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                                <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                                <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                                </div>
                                </div>
                                </div>";
					
					$data = array (
							'sendto' => $email,
							'receiver' => $uname,
							'subject' => '您的CNstorm订单' . $order_id . '差价提示邮件',
							'msg' => $message 
					);
					
					$this->model_tool_sendmail->send ( $data );
				}
			}
			
			$data = array (
					'order_id' => $order_id,
					'order_shipping' => $freight 
			);
			
			$result = $this->model_sale_order->updatefreight ( $data );
			
			$this->response->setOutput ( $result );
		}
	}
	public function updateweight() {
		$this->load->model ( 'sale/order' );
		if (($this->request->server ['REQUEST_METHOD'] == 'POST')) {
			if (isset ( $this->request->post ['order_id'] )) {
				$order_id = $this->request->post ['order_id'];
			}
			if (isset ( $this->request->post ['pweight'] )) {
				$pweight = $this->request->post ['pweight'];
			}
			if (isset ( $this->request->post ['totalProduct'] )) {
				$totalProduct = $this->request->post ['totalProduct'];
			}
			if (isset ( $this->request->post ['variable'] )) {
				$variable = $this->request->post ['variable'];
			}
			$data = array (
					"order_id" => $order_id,
					"pweight" => $pweight,
					"variable" => $variable 
			);
			if ($variable == 'weight') {
				$totalProductWeight = $totalProduct * $pweight;
				$data ['totalProductWeight'] = $totalProductWeight;
			}
			$result = $this->model_sale_order->updateweight ( $data );
			$this->response->setOutput ( $result );
		}
	}
	public function update() {
		$this->load->model ( 'sale/customer' );
		$this->load->model ( 'sale/order' );
		$this->load->model ( 'record/record' );
		
		if (($this->request->server ['REQUEST_METHOD'] == 'POST')) {
			
			// 获取用户编号
			if (isset ( $this->request->post ['uid'] ) && $this->request->post ['uid']) {
				$uid = $this->request->post ['uid'];
			}
			
			// 获取用户名
			if (isset ( $this->request->post ['uname'] )) {
				$uname = $this->request->post ['uname'];
			}
			
			// 获取订单编号
			if (isset ( $this->request->post ['oid'] )) {
				$order_product_id = $this->request->post ['oid'];
			}
			
			// 获取订单商品编号
			if (isset ( $this->request->post ['oid2'] )) {
				$order_id = $this->request->post ['oid2'];
			}
			
			// 获取商品Url地址
			if (isset ( $this->request->post ['purl'] )) {
				$goodsurl = $this->request->post ['purl'];
			}
			
			// 获取商品名称
			if (isset ( $this->request->post ['pname'] )) {
				$goodsname = $this->request->post ['pname'];
			}
			
			// 获取商品单价
			if (isset ( $this->request->post ['pcost'] )) {
				$goodsprice = $this->request->post ['pcost'];
			}
			
			// 获取商品数量
			if (isset ( $this->request->post ['pqty'] )) {
				$goodsnum = $this->request->post ['pqty'];
			}
			
			// 获取商品颜色
			if (isset ( $this->request->post ['pcolor'] )) {
				$goodscolor = $this->request->post ['pcolor'];
			}
			
			// 获取商品尺寸
			if (isset ( $this->request->post ['psize'] )) {
				$goodssize = $this->request->post ['psize'];
			}
			
			// 获取商品备注
			if (isset ( $this->request->post ['pnote'] )) {
				$pnote = $this->request->post ['pnote'];
			}
			
			// 原来的订单商品总价
			$order_product_info = $this->model_sale_order->get_Order_Products ( $order_product_id );
			
			$old_total = $order_product_info ['price'] * $order_product_info ['quantity'];
			$new_total = $goodsprice * $goodsnum;
			$tempmoney = 0;
			$tempmoney2 = 0;
			$difference = 0.00;
			
			// 处理价格和运费修改扣除用户相应金额账户余额
			
			if ($goodsnum != $order_product_info ['quantity'] || $goodsprice != $order_product_info ['price']) {
				
				// 调整数量或单价对应商品价格调整
				$tempmoney = round ( ($old_total - $new_total), 2 );
				
				$tempgoodsn = round ( $order_product_info ['quantity'] - $goodsnum );
				
				$user_balance = $this->model_sale_customer->getmoneybyuid ( $uid );
				
				$newbalance = round ( $user_balance + $tempmoney, 2 );
				
				if ($newbalance >= 0 && $tempmoney > - 3) {
					$this->model_sale_customer->editBalance ( $newbalance, $uname ); // 扣去账户余额
					
					$note = "调整商品<a href=\'" . $goodsurl . "\' target=\'_blank\'>《" . $goodsname . "》</a>数量：" . + $tempgoodsn . " 价格：" . $tempmoney . " 订单商品ID:" . $order_product_id;
					
					$data = array (
							'uid' => $uid,
							'uname' => $uname,
							'type' => 1,
							'action' => 5,
							'money' => $tempmoney,
							'accountmoney' => $newbalance,
							'remark' => $note 
					);
					
					$this->model_record_record->addRecord ( $data ); // 写记录
					
					$difference = round ( $new_total, 2 );
					$status = $this->model_sale_order->getstatusbyoid ( $order_id );
					if (9 == $status) {
						$this->model_sale_order->order_updat ( $order_id, 2 );
					}
				} else {
					$this->load->model ( 'tool/sendmail' );
					
					$email_info = $this->model_tool_sendmail->getinfobyoid ( $order_id );
					$email = $email_info ['email'];
					$producturl = $email_info ['producturl'];
					$productname = $email_info ['name'];
					
					$message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                            <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                            <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                            <div style = 'padding:0;margin:0;'>
                            <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                            <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                            <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                            <p><b style = 'color:#000;'>CNstorm正等待您以下订单的操作指示！</b></p>
                            <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>订单号为$order_id 的订单实际销售价格略高于支付金额，为保障您的消费权益，我们需依据您的指示（取消或补差价购买）以处理该订单（<a href = 'http://www.acgstorm.com/order.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看订单</a>）</br>
                        订单详情：<a href='$producturl' target = '_blank'>$productname</a>   
                            </div>
                            <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                            1、 继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                            <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                            <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                            <p>4、 立刻勾选您要邮寄的商品提交运送(<a href = 'http://www.acgstorm.com/order.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>查看订单并提交</a>)</p>
                            <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                            <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                            <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                            <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                            </div>
                            </div>
                            </div>
                            <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                            <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                            <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                            <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                            <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                            </div>
                            </div>
                            </div>";
					
					$data = array (
							'sendto' => $email,
							'receiver' => $uname,
							'subject' => '您的CNstorm订单' . $order_id . '差价提示邮件',
							'msg' => $message 
					);
					
					$this->model_tool_sendmail->send ( $data );
					
					$this->model_sale_order->order_updat ( $order_id, "9" );
					
					$difference = round ( $new_total, 2 );
				}
			} else {
				
				$difference = round ( $new_total, 2 );
				
				$status = $this->model_sale_order->getstatusbyoid ( $order_id );
				
				if (9 == $status) {
					$this->model_sale_order->order_updat ( $order_id, 2 );
				}
			}
			
			$dataedit = array (
					"order_id" => $order_id,
					"order_product_id" => $order_product_id,
					"producturl" => $goodsurl,
					"name" => $this->Char_cv ( $goodsname ),
					"price" => round ( $goodsprice, 2 ),
					"total" => round ( $new_total, 2 ),
					'difference' => $difference,
					"quantity" => round ( $goodsnum ),
					"option_size" => $this->Char_cv ( $goodssize ),
					"option_color" => $this->Char_cv ( $goodscolor ),
					"note" => $this->Char_cv ( $pnote ) 
			);
			
			$result = $this->model_sale_order->order_product_modify ( $dataedit );
			echo json_encode ( $result );
		}
	}
	function Char_cv($msg) {
		return str_replace ( array (
				"\t",
				'<',
				'>',
				"\r",
				"\n",
				'  ' 
		), array (
				'',
				'&lt;',
				'&gt;',
				'',
				'',
				'&nbsp; ' 
		), $msg );
	}
	public function update_order() {
		if (isset ( $this->request->post ['filter_order_status_id'] )) {
			$order_status_id = $this->request->post ['filter_order_status_id'];
		} else {
			$order_status_id = '';
		}
		if (isset ( $this->request->post ['auction_id'] )) {
			$auction_id = $this->request->post ['auction_id'];
		} else {
			$auction_id = '';
		}
		
		$this->language->load ( 'sale/order' );
		
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		
		$this->load->model ( 'sale/order' );
		
		if (isset ( $this->request->post ['selected'] ) && ($this->validateDelete ())) {
			
			foreach ( $this->request->post ['selected'] as $order_id ) {
				if ($order_status_id != 0) {
					$this->model_sale_order->order_updat ( $order_id, $order_status_id );
					
					if ($order_status_id == 6) {
						$query = $this->db->query ( "SELECT o.customer_id,o.firstname,o.email,op.producturl,op.name FROM " . DB_PREFIX . "order o LEFT JOIN " . DB_PREFIX . "order_product op ON o.order_id=op.order_id WHERE o.order_id = '" . ( int ) $order_id . "'" );
						$customer_id = $query->row ['customer_id'];
						$uname = $query->row ['firstname'];
						$email = $query->row ['email'];
						$producturl = $query->row ['producturl'];
						$productname = $query->row ['name'];
						
						$message = "<div style='background-color:#f7f7f7;text-align:center;padding:30px 0;margin:0;width:100%;'>
                            <div style = 'max-width:800px;margin:0 auto;text-align:left;padding:0;background-color:#ffffff;'>
                            <div style = 'margin:0;padding:0;text-align:center;'><img src = 'http://www.acgstorm.com/image/data/logo.png' width = '226' height = '52' style = 'margin:45px 0;'></div>
                            <div style = 'padding:0;margin:0;'>
                            <div style = 'margin:0 3px;background-color:#fff;padding:0;'>
                            <div style = 'padding:0 5%;margin:0;word-wrap:break-word;color:#818181;font-size:1em;font-family:helvetica,Arial,NanumGothic,Dotum'>
                            <h3 style = 'margin:0 0 20px 0;padding-top:10px;font-weight:normal;'>您好, " . $uname . " <span style = 'font-size:22px;color:#FF6d85;'>♥</span></h3>
                            <p><b style = 'color:#000;'>我们已接收到您以下CNstorm订单包裹！</b></p>
                            <div style = 'width:98%; margin:0 auto; padding:10px; border:1px solid #E8CCCC'>订单号为$order_id 的订单已完成检验并入库，请您留意并及时处理该订单（<a href = 'http://www.acgstorm.com/order.html' target = '_blank' style = 'color:#fb6e52;font-weight: bold'>查看订单</a>）</br>
                        订单详情：<a href='$producturl' target = '_blank'>$productname</a>   
                            </div>
                            <p style = 'margin:20px 0;'>CNstorm致力于提升海外留学生及华人生活体验，让您在海外生活，也能如同国内一样方便。接下来您可以：</p>
                            1、 继续在中国购物网站挑选商品，并与此次商品合并寄至您指定的海外地址(<a href = 'http://www.acgstorm.com/procurement.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代购</a>)
                            <p>2、 您自行准备商品并邮寄至CNstorm中国大陆地址，通过CNstorm极具性价比的国际物流系统，与本次商品合并快运至您的海外地址。（<a href = 'http://www.acgstorm.com/selfshopping.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>代寄</a>）</p>
                            <p>3、 亲人朋友生日，重大节日，纪念日... CNstorm都能为您下单，将礼物寄至您指定的国内地址(<a href = 'http://www.acgstorm.com/international-express.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>国内送</a>)。</p>
                            <p>4、 立刻勾选您要邮寄的商品提交运送(<a href = 'http://www.acgstorm.com/order.html' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>查看订单并提交</a>)</p>
                            <p>我们为您提供的所有服务都同时接受外币及人民币支付，让您不必再为支付感到烦恼。有关支付方式介绍请<a href = 'http://www.acgstorm.com/index.php?route=help/help&cid=40' style = 'color:#fb6e52;font-size:1em;text-decoration:none;font-weight: bold' target = '_blank'>点此查阅</a>。</p>
                            <p style = 'margin:68px 0 40px 0;'>我们衷心感谢您选择并使用CNstorm为您服务！</p>
                            <p style = 'margin:20px 0 40px 0;'>CNstorm客户关怀部</p>
                            <p style = 'margin:0;text-align:center;'><a href = 'http://www.weibo.com/cnstorm' style = 'margin-right:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Weibo</a> | <a href = 'http://www.acgstorm.com/index.php?route=app/appload' style = 'margin:0 10px;text-decoration:none;color:#fb6e52;' target = '_blank'>Ios App</a> | <a href = 'http://www.acgstorm.com/help.html' style = 'margin-left:10px;text-decoration:none;color:#fb6e52;' target = '_blank'>FAQ</a></p>
                            </div>
                            </div>
                            </div>
                            <div style = 'background-color:#ffffff;height:70px;padding:0;'></div>
                            <div style = 'text-align:center;background-color:#f7f7f7;padding-top:20px;'>
                            <p style = 'color:#b1b1b1;font-size:.85em;'>如果您需要联系我们的客户服务小组，请访问我们的官网(<a href = 'www.acgstorm.com' target = '_blank' style = 'text-decoration:none;color:#fb6e52'>http://www.acgstorm.com</a>)点击右上角帮助中心与我们取得联系。</p>
                            <p style = 'font-size:.7em;color:#818181;'>Copyright © 2014 CNstorm Co., Ltd. 2 Exhibition center, F518 Creative park, Shenzhen, China. All Rights Reserved.<br>
                            <a href = 'http://www.acgstorm.com/help-agreement.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Terms of Service</a> | <a href = 'http://www.acgstorm.com/help-privacy.html' style = 'text-decoration:none;color:#fb6e52;' target = '_blank'>Privacy Policy</a></p>
                            </div>
                            </div>
                            </div>";
						
						$data = array (
								'sendto' => $email,
								'receiver' => $uname,
								'subject' => '您的CNstorm订单' . $order_id . '已到货！',
								'msg' => $message 
						);
						
						// 手机推送消息
						$apps = $this->model_sale_order->getOnlineAppByCustomer ( $customer_id );
						if ($apps) {
							$custom_content = array (
									'order_id' => $order_id,
									'state' => 1 
							);
							include_once (DIR_SYSTEM . 'baepush.class.php');
							$baepush = new Baepush ();
							foreach ( $apps as $app ) {
								if ($app ['device_type'] == 1) { // ios
									$device_type = 4;
								} elseif ($app ['device_type'] == 2) { // android
									$device_type = 3;
								}
								$pm = array (
										'push_type' => 1,
										'user_id' => $app ['user_id'],
										'device_type' => $device_type,
										'description' => '您的订单' . $order_id . '已入库，请下运单。',
										'deploy_status' => 2,
										'custom_content' => $custom_content 
								);
								$baepush->push ( $pm );
							}
						}
						
						$this->load->model ( 'tool/sendmail' );
						$this->model_tool_sendmail->send ( $data );
					}
				}
				if ($auction_id != '') {
					$this->model_sale_order->order_updat2 ( $order_id, $auction_id );
				}
			}
			
			$this->session->data ['success'] = $this->language->get ( 'text_success' );
			
			$url = '';
			
			if (isset ( $this->request->get ['filter_order_id'] )) {
				$url .= '&filter_order_id=' . $this->request->get ['filter_order_id'];
			}
			
			if (isset ( $this->request->get ['filter_customer'] )) {
				$url .= '&filter_customer=' . urlencode ( html_entity_decode ( $this->request->get ['filter_customer'], ENT_QUOTES, 'UTF-8' ) );
			}
			
			if (isset ( $this->request->get ['filter_order_status_id'] )) {
				$url .= '&filter_order_status_id=' . $this->request->get ['filter_order_status_id'];
			}
			
			if (isset ( $this->request->get ['filter_total'] )) {
				$url .= '&filter_total=' . $this->request->get ['filter_total'];
			}
			
			if (isset ( $this->request->get ['filter_date_added'] )) {
				$url .= '&filter_date_added=' . $this->request->get ['filter_date_added'];
			}
			
			if (isset ( $this->request->get ['filter_date_modified'] )) {
				$url .= '&filter_date_modified=' . $this->request->get ['filter_date_modified'];
			}
			
			if (isset ( $this->request->get ['sort'] )) {
				$url .= '&sort=' . $this->request->get ['sort'];
			}
			
			if (isset ( $this->request->get ['order'] )) {
				$url .= '&order=' . $this->request->get ['order'];
			}
			
			if (isset ( $this->request->get ['page'] )) {
				$url .= '&page=' . $this->request->get ['page'];
			}
			
			$this->redirect ( $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . $url, 'SSL' ) );
		}
		
		$this->getList ();
	}
	protected function validateDelete() {
		if (! $this->user->hasPermission ( 'modify', 'sale/order' )) {
			$this->error ['warning'] = $this->language->get ( 'error_permission' );
		}
		
		if (! $this->error) {
			return true;
		} else {
			return false;
		}
	}
	protected function getList() {
		if (isset ( $this->request->get ['filter_order_id'] )) {
			$filter_order_id = $this->request->get ['filter_order_id'];
		} else {
			$filter_order_id = null;
		}
		
		if (isset ( $this->request->get ['filter_customer'] )) {
			$filter_customer = $this->request->get ['filter_customer'];
		} else {
			$filter_customer = null;
		}
		
		if (isset ( $this->request->get ['filter_sn'] )) {
			$filter_sn = $this->request->get ['filter_sn'];
		} else {
			$filter_sn = null;
		}
		
		if (isset ( $this->request->get ['filter_order_status_id'] )) {
			$filter_order_status_id = $this->request->get ['filter_order_status_id'];
		} else {
			$filter_order_status_id = null;
		}
		
		if (isset ( $this->request->get ['filter_total'] )) {
			$filter_total = $this->request->get ['filter_total'];
		} else {
			$filter_total = null;
		}
		
		if (isset ( $this->request->get ['filter_date_added'] )) {
			$filter_date_added = $this->request->get ['filter_date_added'];
		} else {
			$filter_date_added = null;
		}
		
		if (isset ( $this->request->get ['filter_date_modified'] )) {
			$filter_date_modified = $this->request->get ['filter_date_modified'];
		} else {
			$filter_date_modified = null;
		}
		
		if (isset ( $this->request->get ['filter_product_name'] )) {
			$filter_product_name = $this->request->get ['filter_product_name'];
		} else {
			$filter_product_name = null;
		}
		
		if (isset ( $this->request->get ['sort'] )) {
			$sort = $this->request->get ['sort'];
		} else {
			$sort = 'o.order_id';
		}
		
		if (isset ( $this->request->get ['order'] )) {
			$order = $this->request->get ['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		
		$url = '';
		
		if (isset ( $this->request->get ['filter_order_id'] )) {
			$url .= '&filter_order_id=' . $this->request->get ['filter_order_id'];
		}
		
		if (isset ( $this->request->get ['filter_customer'] )) {
			$url .= '&filter_customer=' . urlencode ( html_entity_decode ( $this->request->get ['filter_customer'], ENT_QUOTES, 'UTF-8' ) );
		}
		
		if (isset ( $this->request->get ['filter_order_status_id'] )) {
			$url .= '&filter_order_status_id=' . $this->request->get ['filter_order_status_id'];
		}
		
		if (isset ( $this->request->get ['filter_total'] )) {
			$url .= '&filter_total=' . $this->request->get ['filter_total'];
		}
		
		if (isset ( $this->request->get ['filter_date_added'] )) {
			$url .= '&filter_date_added=' . $this->request->get ['filter_date_added'];
		}
		
		if (isset ( $this->request->get ['filter_date_modified'] )) {
			$url .= '&filter_date_modified=' . $this->request->get ['filter_date_modified'];
		}
		
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}
		
		$this->data ['breadcrumbs'] = array ();
		
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/home', 'token=' . $this->session->data ['token'], 'SSL' ),
				'separator' => false 
		);
		
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'heading_title' ),
				'href' => $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . $url, 'SSL' ),
				'separator' => ' :: ' 
		);
		
		$this->data ['invoice'] = $this->url->link ( 'sale/order/invoice', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['insert'] = $this->url->link ( 'sale/order/insert', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['delete'] = $this->url->link ( 'sale/order/delete', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['emali'] = $this->url->link ( 'sale/contact', 'token=' . $this->session->data ['token'], 'SSL' );
		$this->data ['update_order'] = $this->url->link ( 'sale/order/update_order', 'token=' . $this->session->data ['token'] . $url, 'SSL' );
		$this->data ['orders'] = array ();
		
		$data = array (
				'filter_order_id' => $filter_order_id,
				'filter_customer' => $filter_customer,
				'filter_sn' => $filter_sn,
				'filter_order_status_id' => $filter_order_status_id,
				'filter_total' => $filter_total,
				'filter_date_added' => $filter_date_added,
				'filter_date_modified' => $filter_date_modified,
				'filter_product_name' => $filter_product_name,
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $this->config->get ( 'config_admin_limit' ),
				'limit' => $this->config->get ( 'config_admin_limit' ) 
		);
		
		$order_total = $this->model_sale_order->getTotalOrders ( $data );
		
		$results = $this->model_sale_order->getOrders ( $data );
		//print_r($results );
		$express = $this->model_sale_order->express ();
		$this->data ['order_color'] = $this->language->get ( 'order_color' );
		$this->data ['order_size'] = $this->language->get ( 'order_size' );
		$this->data ['order_product_name'] = $this->language->get ( 'order_product_name' );
		$this->data ['order_remark'] = $this->language->get ( 'order_remark' );
		$this->data ['order_color_value2'] = $this->language->get ( 'order_color_value2' );
		$this->data ['order_color_value'] = $this->language->get ( 'order_color_value' );
		$this->data ['order_Sensitive'] = $this->language->get ( 'order_Sensitive' );
		$this->data ['order_nameplate'] = $this->language->get ( 'order_nameplate' );
		$this->data ['order_rethrowing'] = $this->language->get ( 'order_rethrowing' );
		$this->data ['order_notrethrowing'] = $this->language->get ( 'order_notrethrowing' );
		$this->data ['order_nonameplate'] = $this->language->get ( 'order_nonameplate' );
		$this->data ['order_all_total'] = $this->language->get ( 'order_all_total' );
		$tmp_arr = array ();
		foreach ( $results as $k => $v ) {
			if (in_array ( $v ['order_id'], $tmp_arr )) {
				unset ( $results [$k] );
			} else {
				$tmp_arr = $v;
			}
		}
		foreach ( $results as $result ) {
			$action = array ();
			$action [] = array (
					'text' => $this->language->get ( 'text_view' ),
					'href' => $this->url->link ( 'sale/order/info', 'token=' . $this->session->data ['token'] . '&order_id=' . $result ['order_id'] . $url, 'SSL' ) 
			);
			if (strtotime ( $result ['date_added'] ) > strtotime ( '-' . ( int ) $this->config->get ( 'config_order_edit' ) . ' day' )) {
				$action [] = array (
						'text' => $this->language->get ( 'text_edit' ),
						'href' => $this->url->link ( 'sale/order/update', 'token=' . $this->session->data ['token'] . '&order_id=' . $result ['order_id'] . $url, 'SSL' ) 
				);
			}
			$product_str = array ();
			$product = $this->model_sale_order->getOrderProducts ( $result ['order_id'] );
			$product_total = $this->model_sale_order->sun_product_total ( $result ['order_id'] );
			$totalProduct = count ( $product );
			
			foreach ( $product as $key => $value ) {
				
				$order_product_id = $value ['order_product_id'];
				$product_str [$order_product_id] ['name'] = $value ['name'];
				$product_str [$order_product_id] ['producturl'] = $value ['producturl'];
				$product_str [$order_product_id] ['product_id'] = $value ['product_id'];
				$product_str [$order_product_id] ['price'] = $value ['price'];
				$product_str [$order_product_id] ['quantity'] = $value ['quantity'];
				$product_str [$order_product_id] ['total'] = $value ['total'];
				$product_str [$order_product_id] ['payid'] = $value ['pay_id'];
				$product_str [$order_product_id] ['order_product_id'] = $order_product_id;
				$product_str [$order_product_id] ['order_sensitive'] = $value ['order_sensitive'];
				$product_str [$order_product_id] ['order_branding'] = $value ['order_branding'];
				$product_str [$order_product_id] ['order_huge'] = $value ['order_huge'];
				$product_str [$order_product_id] ['express'] = $value ['express'];
				$product_str [$order_product_id] ['weight'] = $value ['weight'];
				$product_str [$order_product_id] ['color'] = $value ['option_color'];
				$product_str [$order_product_id] ['size'] = $value ['option_size'];
				$product_str [$order_product_id] ['text'] = $value ['note'];
				$product_str [$order_product_id] ['tracking_number'] = $value ['kuaidi_no'];
				$product_str [$order_product_id] ['difference'] = $value ['difference'];
				if ($value ['uptime']) {
					$product_str [$order_product_id] ['uptime'] = date ( "Y-m-d h:i:s", $value ['uptime'] );
				}
			}
			
			// $ordertotal = round($product_total [0] ['ordertotal'] + $result ['order_shipping'],2);
			$order_product_difference_array = array ();
			
			$order_product_difference_info = $this->model_sale_order->getdifferencetotal ( $result ['order_id'] );
			
			foreach ( $order_product_difference_info as $value ) {
				
				if (( float ) $value ['difference']) {
					
					$order_product_difference_array [] = $value ['difference'];
				} else {
					
					$order_product_difference_array [] = $value ['total'];
				}
			}
			
			$order_product_difference = array_sum ( $order_product_difference_array );
			
			$order_difference = $result ['difference'];
			
			$order_product_total = $this->model_sale_order->sum_product_total ( $result ['order_id'] );
			
			if (( float ) $order_product_difference && ( float ) $order_difference) {
				
				$differencetotal = ( float ) $order_product_difference + ( float ) $order_difference;
			} else if (! ( float ) $order_product_difference && ( float ) $order_difference) {
				
				$differencetotal = ( float ) $order_product_total + ( float ) $order_difference;
			} else if (( float ) $order_product_difference && ! ( float ) $order_difference) {
				
				$differencetotal = ( float ) $order_product_difference + ( float ) $result ['order_shipping'];
			} else {
				
				$differencetotal = ( float ) $order_product_difference + ( float ) $order_difference;
			}
			
			$this->data ['orders'] [] = array (
					'order_id' => $result ['order_id'],
					// 'ordertotal' => $ordertotal,
					'remarks'=> $result ['remarks'],
					'ordertotal' => $result ['total'],
					'order_shipping' => $result ['order_shipping'],
					'order_status_buy' => $result ['order_status_buy'],
					'store_name' => $result ['store_name'],
					'store_url' => $result ['store_url'],
					'customer' => $result ['customer'],
					'status' => $result ['status'],
					'product' => $product_str,
					'count' => count ( $product_str ),
					'difference' => $result ['difference'],
					'differencetotal' => round ( $differencetotal, 2 ),
					'express' => $express,
					'firstname' => $result ['firstname'],
					'customer_id' => $result ['customer_id'],
					'total' => $result ['total'],
					'date_added' => date ( "Y-m-d h:i:s", strtotime ( $result ['date_added'] ) ),
					'date_modified' => date ( "Y-m-d h:i:s", strtotime ( $result ['date_modified'] ) ),
					'uptime' => date ( "Y-m-d h:i:s", $result ['uptime'] ),
					'selected' => isset ( $this->request->post ['selected'] ) && in_array ( $result ['order_id'], $this->request->post ['selected'] ),
					'action' => $action,
					'preq' => $result ['preq'],
					'creq' => $result ['creq'],
					'totalProduct' => $totalProduct,
					'store_id' => $result ['store_id'] 
			);
		}
		
		$this->data ['heading_title'] = $this->language->get ( 'heading_title' );
		
		$this->data ['text_no_results'] = $this->language->get ( 'text_no_results' );
		$this->data ['text_missing'] = $this->language->get ( 'text_missing' );
		
		$this->data ['column_order_id'] = $this->language->get ( 'column_order_id' );
		$this->data ['column_customer'] = $this->language->get ( 'column_customer' );
		$this->data ['column_status'] = $this->language->get ( 'column_status' );
		$this->data ['column_total'] = $this->language->get ( 'column_total' );
		$this->data ['column_date_added'] = $this->language->get ( 'column_date_added' );
		$this->data ['column_date_modified'] = $this->language->get ( 'column_date_modified' );
		$this->data ['column_action'] = $this->language->get ( 'column_action' );
		
		$this->data ['button_invoice'] = $this->language->get ( 'button_invoice' );
		$this->data ['button_insert'] = $this->language->get ( 'button_insert' );
		$this->data ['button_delete'] = $this->language->get ( 'button_delete' );
		$this->data ['button_filter'] = $this->language->get ( 'button_filter' );
		
		$this->data ['order_Information'] = $this->language->get ( 'order_Information' );
		$this->data ['order_price'] = $this->language->get ( 'order_price' );
		$this->data ['order_qty'] = $this->language->get ( 'order_qty' );
		$this->data ['order_Payment'] = $this->language->get ( 'order_Payment' );
		$this->data ['order_operating'] = $this->language->get ( 'order_operating' );
		$this->data ['order_Number'] = $this->language->get ( 'order_Number' );
		$this->data ['order_time'] = $this->language->get ( 'order_time' );
		$this->data ['order_Buyers'] = $this->language->get ( 'order_Buyers' );
		
		$this->data ['column_product'] = $this->language->get ( 'column_product' );
		$this->data ['order_color'] = $this->language->get ( 'order_color' );
		$this->data ['order_total'] = $this->language->get ( 'order_total' );
		
		$this->data ['order_update2'] = $this->language->get ( 'order_update2' );
		$this->data ['order_express_Select'] = $this->language->get ( 'order_express_Select' );
		$this->data ['order_express_change'] = $this->language->get ( 'order_express_change' );
		$this->data ['order_price'] = $this->language->get ( 'order_price' );
		$this->data ['order_qty'] = $this->language->get ( 'order_qty' );
		$this->data ['order_Id'] = $this->language->get ( 'order_Id' );
		$this->data ['order_user'] = $this->language->get ( 'order_user' );
		$this->data ['order_member'] = $this->language->get ( 'order_member' );
		$this->data ['order_product'] = $this->language->get ( 'order_product' );
		$this->data ['order_Business'] = $this->language->get ( 'order_Business' );
		$this->data ['order_shipping'] = $this->language->get ( 'order_shipping' );
		$this->data ['order_weight'] = $this->language->get ( 'order_weight' );
		$this->data ['order_express_id'] = $this->language->get ( 'order_express_id' );
		$this->data ['order_express_note'] = $this->language->get ( 'order_express_note' );
		$this->data ['order_company'] = $this->language->get ( 'order_company' );
		$this->data ['order_auction'] = $this->language->get ( 'order_auction' );
		$this->data ['order_subtime'] = $this->language->get ( 'order_subtime' );
		$this->data ['order_updatetime'] = $this->language->get ( 'order_updatetime' );
		$this->data ['order_Status'] = $this->language->get ( 'order_Status' );
		$this->data ['order_package'] = $this->language->get ( 'order_package' );
		$this->data ['order_tag'] = $this->language->get ( 'order_tag' );
		$this->data ['order_modification'] = $this->language->get ( 'order_modification' );
		$this->data ['order_pending'] = $this->language->get ( 'order_pending' );
		$this->data ['order_notSensitive'] = $this->language->get ( 'order_notSensitive' );
		$this->data ['order_noLuxury'] = $this->language->get ( 'order_noLuxury' );
		
		$this->data ['Order_number'] = $this->language->get ( 'Order_number' );
		// $this->data['Order_price'] = $this->language->get('Order_price');
		$this->data ['token'] = $this->session->data ['token'];
		
		if (isset ( $this->error ['warning'] )) {
			$this->data ['error_warning'] = $this->error ['warning'];
		} else {
			$this->data ['error_warning'] = '';
		}
		
		if (isset ( $this->session->data ['success'] )) {
			$this->data ['success'] = $this->session->data ['success'];
			
			unset ( $this->session->data ['success'] );
		} else {
			$this->data ['success'] = '';
		}
		
		$url = '';
		
		if (isset ( $this->request->get ['filter_order_id'] )) {
			$url .= '&filter_order_id=' . $this->request->get ['filter_order_id'];
		}
		
		if (isset ( $this->request->get ['filter_customer'] )) {
			$url .= '&filter_customer=' . urlencode ( html_entity_decode ( $this->request->get ['filter_customer'], ENT_QUOTES, 'UTF-8' ) );
		}
		
		if (isset ( $this->request->get ['filter_order_status_id'] )) {
			$url .= '&filter_order_status_id=' . $this->request->get ['filter_order_status_id'];
		}
		
		if (isset ( $this->request->get ['filter_total'] )) {
			$url .= '&filter_total=' . $this->request->get ['filter_total'];
		}
		
		if (isset ( $this->request->get ['filter_date_added'] )) {
			$url .= '&filter_date_added=' . $this->request->get ['filter_date_added'];
		}
		
		if (isset ( $this->request->get ['filter_date_modified'] )) {
			$url .= '&filter_date_modified=' . $this->request->get ['filter_date_modified'];
		}
		
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$url .= '&page=' . $this->request->get ['page'];
		}
		
		$this->data ['sort_order'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=o.order_id' . $url, 'SSL' );
		$this->data ['sort_customer'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=customer' . $url, 'SSL' );
		$this->data ['sort_status'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=status' . $url, 'SSL' );
		$this->data ['sort_total'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=o.total' . $url, 'SSL' );
		$this->data ['sort_date_added'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=o.date_added' . $url, 'SSL' );
		$this->data ['sort_date_modified'] = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . '&sort=o.date_modified' . $url, 'SSL' );
		
		$url = '';
		
		if (isset ( $this->request->get ['filter_order_id'] )) {
			$url .= '&filter_order_id=' . $this->request->get ['filter_order_id'];
		}
		
		if (isset ( $this->request->get ['filter_customer'] )) {
			$url .= '&filter_customer=' . urlencode ( html_entity_decode ( $this->request->get ['filter_customer'], ENT_QUOTES, 'UTF-8' ) );
		}
		
		if (isset ( $this->request->get ['filter_order_status_id'] )) {
			$url .= '&filter_order_status_id=' . $this->request->get ['filter_order_status_id'];
		}
		
		if (isset ( $this->request->get ['filter_total'] )) {
			$url .= '&filter_total=' . $this->request->get ['filter_total'];
		}
		
		if (isset ( $this->request->get ['filter_date_added'] )) {
			$url .= '&filter_date_added=' . $this->request->get ['filter_date_added'];
		}
		
		if (isset ( $this->request->get ['filter_date_modified'] )) {
			$url .= '&filter_date_modified=' . $this->request->get ['filter_date_modified'];
		}
		
		if (isset ( $this->request->get ['sort'] )) {
			$url .= '&sort=' . $this->request->get ['sort'];
		}
		
		if (isset ( $this->request->get ['order'] )) {
			$url .= '&order=' . $this->request->get ['order'];
		}
		
		$pagination = new Pagination ();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get ( 'config_admin_limit' );
		$pagination->text = $this->language->get ( 'text_pagination' );
		$pagination->url = $this->url->link ( 'sale/order', 'token=' . $this->session->data ['token'] . $url . '&page={page}', 'SSL' );
		
		$this->data ['pagination'] = $pagination->render ();
		
		$this->data ['filter_order_id'] = $filter_order_id;
		$this->data ['filter_customer'] = $filter_customer;
		$this->data ['filter_order_status_id'] = $filter_order_status_id;
		$this->data ['filter_total'] = $filter_total;
		$this->data ['filter_date_added'] = $filter_date_added;
		$this->data ['filter_date_modified'] = $filter_date_modified;
		$this->data ['filter_product_name'] = $filter_product_name;
		
		$this->load->model ( 'localisation/order_status' );
		$this->data ['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses ();
		
		$this->data ['sort'] = $sort;
		$this->data ['order'] = $order;
		
		$this->template = 'sale/order_list.tpl';
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		
		$this->response->setOutput ( $this->render () );
	}
	//修改备注
	function updatabz(){
	$this->load->model ( 'sale/order' );
		if($_POST){
			$content=htmlspecialchars(trim($_POST ['content']));
			$oid= $_POST ['oid'];
			$row=$this->model_sale_order->updatabz ($oid, $content );
			if($row){
				echo 1;
			}else{
				echo 0;
			}
		}else{
			echo 0;
		}
	}
}
?>
