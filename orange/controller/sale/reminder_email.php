<?php 

	class ControllerSaleReminderEmail extends Controller {
	
		public function index(){
		
			$this->language->load('sale/contact');

			$this->document->setTitle($this->language->get('heading_title'));
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_default'] = $this->language->get('text_default');
			$this->data['text_newsletter'] = $this->language->get('text_newsletter');
			$this->data['text_customer_all'] = $this->language->get('text_customer_all');
			$this->data['text_customer'] = $this->language->get('text_customer');
			$this->data['text_customer_group'] = $this->language->get('text_customer_group');
			$this->data['text_affiliate_all'] = $this->language->get('text_affiliate_all');
			$this->data['text_affiliate'] = $this->language->get('text_affiliate');
			$this->data['text_product'] = $this->language->get('text_product');
			$this->data['entry_store'] = $this->language->get('entry_store');
			$this->data['entry_to'] = $this->language->get('entry_to');
			$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
			$this->data['entry_customer'] = $this->language->get('entry_customer');
			$this->data['entry_affiliate'] = $this->language->get('entry_affiliate');
			$this->data['entry_product'] = $this->language->get('entry_product');
			$this->data['entry_subject'] = $this->language->get('entry_subject');
			$this->data['entry_message'] = $this->language->get('entry_message');
			$this->data['button_send'] = $this->language->get('button_send');
			$this->data['button_cancel'] = $this->language->get('button_cancel');
		
			$this->data['token'] = $this->session->data['token'];

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('heading_title'),
				'href' => $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);
			
			
			 $this->data['cancel'] = $this->url->link('sale/contact', 'token=' . $this->session->data['token'], 'SSL');
			 
		 
		 
			if (isset($this->request->post['user'])) {
		
				$user=$this->request->post['user'];
				
				$sql="select customer_id,email from oc_customer where firstname='".$user."'";
				$query=$this->db->query($sql);
				
				if($query->row){
					
					$userID=$query->row['customer_id'];
					$email=$query->row['email'];
					$subject='您的购物清单';
					$sql="select o.order_id,o.total as order_total ,o.date_added  from oc_order o   where o.order_status_id=1 and customer_id=".$userID." order by order_id desc limit 0,4";
					$rows=$this->db->query($sql);
					
					foreach($rows->rows as $k=>$v){
						$sql="select op.name,op.price,op.quantity,op.producturl,op.img,op.total as product_total  from oc_order_product op  where op.order_id=".$v['order_id'];
						$products=$this->db->query($sql);
						$rows->rows[$k]['product']=$products->rows;
					}
					$str="";
					$str.="<style>
						a{text-decoration:none;}
						.shops_s{width:600px; margin:0 auto; border:1px solid #ccc; clear:both; padding:10px 0 0 0}
						.contents {border: 1px solid #e6e6e6;border-top: none;}
						.bundles {border-top: 1px solid #e5e5e5;height: 118px;width:600px}
						.on2 {background: #fff8e1;}
						.bundles_list {padding-left: 20px;}
						.bundles_list li {float: left;padding-top: 6px;list-style-type: none;}
						.bundles_list .bl_checkbox {position: relative;overflow: hidden;margin-left: -10px;}
						.bundles_list .gwc_tu img {width: 80px;height: 80px;border: 1px solid #ddd;display: inline-block;margin: 14px 0 0 10px;}
						.bundles_list .the_price {color: #999;font-size: 12px;line-height: 98px; font-family: '微软雅黑';}
						.bundles_list .gwc_conts {width: 240px;height: 98px;}
						.bundles_list .the_price{width: 167px;text-align: center;}
						.bundles_list .the_price b {color: #333;font-size: 14px; font-weight: bold;}
						.bundles_list a{ text-decoration: none}
						.nav li{width:20%;float:left;list-style-type:none}
					</style>";
					$str.='<div style="width:700px;margin:0px auto">';
					$str.='<div style="height:75px; overflow:hidden; border-bottom:2px solid #ccc"><img src="http://www.acgstorm.com/images/special/sendemail.jpg" style="float:left"><span style="float:right; font-size:20px; color:red; font-weight:bold; line-height:90px">[感谢使用CNstorm]</span></div>';
					$str.='<div class="nav">';
					$str.='<ul>';
					$str.='	<li><a href="http://www.acgstorm.com/procurement.html" target="_break">代购</a></li>';
					$str.='	<li> <a href="http://www.acgstorm.com/international-express.html" target="_break">国际转运</a></li>';
					$str.='	<li><a href="http://www.acgstorm.com/cosplay-main.html" target="_break">Cosplay</a></li>';
					$str.='	<li><a href="http://www.acgstorm.com/product-mall.html" target="_break"> 生活</a></li>';
					$str.='	<li><a href="http://www.acgstorm.com/index.php?route=product/sort&parent_id=222" target="_break"> 礼物</a></li>';
					$str.='	</ul>';
					$str.='</div>';
					$str.='<div style="clear:both; height:20px; width:100%"></div>';
					$str.='<div style="width:700px; margin:0 auto;font-family:lucida Grande,Verdana,Microsoft YaHei;font-size: 14px; border:1px solid #ccc; padding:10px 0 0 0">';
					$str.='<div style="width:600px;margin:0px auto">';
					$str.='<h2>Hi：'.$email.'</h2>';
					$str.='<p>我们注意到您上次来CNstorm的时候，您在网站下的订单尚未完成。</p>';
					$str.='<p>为避免您中意的宝贝价格或库存发生变化，请尽快<a href="http://www.acgstorm.com/order.html" target="_break">查看订单</a>，或点击<a href="http://www.acgstorm.com/account-login.html" target="_break">这里</a>整理下您的订单。</p>';
					$str.='</div>';
					foreach($rows->rows as $key=>$value){
						$str.=' <div class="shops_s ml10" >';
						$str.='		<div class="shop_name">';
						$str.=' <p class="shop_admin">订单编号:'.$value['order_id'].' &nbsp;&nbsp;订单日期:<span class="postAge_s">'.$value['date_added'].'</span> </p>';
						$str.='		 </div>	';
						foreach($value['product'] as $v){
							$str.='	<div class="bundles on2">';
							$str.='		<ul class="bundles_list" style="padding-left:20px;">';
							$str.='	 <li> <a class="gwc_tu" target="_blank" href="http://www.acgstorm.com/order-order.html&order_status_id=1"> <img src="'.$v['img'].'" > </a> </li>';
							$str.='		 <li class="gwc_conts">';
							$str.='		<dl>';
						$str.='<dt> <a target="_blank" href="http://www.acgstorm.com/order-order.html&order_status_id=1"> '.mb_substr($v['name'],0,43,'UTF-8').'...'.' </a> </dt>';
							$str.='		</dl>';
							$str.='		</li>';
							$str.='		  <li class="the_price"><b class="single_price count_mon"> '.$v['price'].'</b> </li>';
							$str.='		</ul>';
							$str.='	</div>	';
						}
						$str.='	</div>	';
				}	
					$str.='<div style="width:600px;margin:0px auto">';
					$str.='<p>非常感谢您对我公司的信任选用我们的服务。如果您使用网站的过程中遇到任何问题，</p>';
					$str.='<p>请及时与我们联系。以便我们及时为您解决。</p>';
					$str.='<div style="height:1px;width:600px;margin:auto 0px;border-bottom:1px solid #000">&nbsp;</div>';
					$str.='<p style="text-align:right">客户关怀部&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>';
					$str.='<p style="height:150px"></p>';
					$str.='<p style="text-align:center">CNstorm帮助海外朋友实现中国商品购买及快速全球送货上门的梦想</p>';
					$str.='<p style="text-align:center">每日100+新品上线</p>';
					$str.='<p style="height:30px"></p>';
					$str.='<p style="text-align:center">Copyright © 2015 All rights reserved</p>';
					$str.='</div>';
					$str.='</div>';
					$str.='</div>';
					$arr=array('email'=>$email,'content'=>$str,'subject'=>$subject);
					echo json_encode($arr);
						die;
				}else{
				echo 0;
						die;
				}
		}
		 
		$this->template = 'sale/reminder_email.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
		}
		
		public function sendEmail(){
		
	if(isset($this->request->post['user'])&&isset($this->request->post['order_email'])&&isset($this->request->post['subject'])&&isset($this->request->post['message'])){
			
				$user=$this->request->post['user'];
				$order_email=$this->request->post['order_email'];
				$subject=$this->request->post['subject'];
				//$message=$this->request->post['message'];
				
				$message = str_replace("&lt;","<",$this->request->post['message']);
                $message = str_replace("&gt;",">",$message);
				$message = str_replace("&quot;",'"',$message);
				$message = str_replace("&amp;nbsp;"," ",$message); 
				   $data = array(
                        'sendto' => $order_email,
                        'receiver' => '',
                        'subject' => $subject,
                        'msg' => $message,
                    );

                    $this->load->model('tool/sendmail');
                   $this->model_tool_sendmail->send($data);
				echo 'true';
					die;
			}else{
				echo 'false';
				die;
			}
		}
	}
?>