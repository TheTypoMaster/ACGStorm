<?php  
class ControllerAccountPromoter extends Controller { 

    public function index() {
	
	if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
	
	$customerId = $this->customer->getId();
	
	 $this->load->model('account/short_url');
	
	$url='http://wwww.cnstorm/?u='.$customerId;
	$arrUrl=$this->model_account_short_url->short($url);
	$this->model_account_short_url->save_inviter_url($arrUrl,$url,$customerId);
	
	$myUrl=$this->model_account_short_url->get_my_url($customerId);
	$this->data['url']=$myUrl;
	
     if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter.tpl';
        } else {
            $this->template = 'default/template/account/promoter.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	
	public function reward(){
	


		  if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
		  }
			$this->load->model('account/promoter');
			if (isset($this->request->get['month'])) {
				$month = $this->request->get['month'];
			}else{
				$month = 2;
			}
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			if (isset($this->request->get['month'])) {
				$url .= '&month=' . $this->request->get['month'];
			}
			
			
			$commission=$this->true_ratio();
			//查用户生效时间
			$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
		
			$commission_ratio=$commission*0.01;
			
			$arrChild=$this->model_account_promoter->getChild($month);//获取子级id
			
			$getCommissionRatio=$this->model_account_promoter->getCommissionRatio($this->session->data['customer_id']);//佣金比例
			
			$numChildBuy=$this->model_account_promoter->getChildBuy();
			
			$numCanQuxian=$this->model_account_promoter->getCanQuxian($commission_ratio,$Efftime);
			
			$numCanQuxian=$numCanQuxian > 0? $numCanQuxian:0;
			
			$rowsChildSendOrderAll=array();
			
			$numlastmonth=0;
			
			$Total_reward=0;
			
			$this->data['indexTotalfee']=0;
			
			$arrChildSendOrderAll=array(); 
			
			if(count($arrChild)>0){
			
						$strChild=implode(',',$arrChild);
						
						//下级用户总运费
						$numlastmonth=$this->model_account_promoter->getChildLastMonth($Efftime);
						
						if(is_array($numlastmonth)&& !empty($numlastmonth)){
						
							$commission_ratio=0.04;
							$lteff=floor($numlastmonth['lteff']*100*$commission_ratio)/100;
							$commission_ratio=0.06;
							$gteff=floor($numlastmonth['gteff']*100*$commission_ratio)/100;
							$Total_reward=$lteff+$gteff;
							
						}else{
						//总佣金
						
							$Total_reward = floor($numlastmonth*100*$commission_ratio)/100;
						}
						
						//这个月佣金
						$indexTotalfee=$this->model_account_promoter->getIndexMonth($Efftime);
					
						if(isset($rowsChildSendOrderAll) && is_array($indexTotalfee)){
						
							$lteff=floor($indexTotalfee['lteff']*4)/100;
							$gteff=floor($indexTotalfee['gteff']*6)/100;
							$this->data['indexTotalfee']=$lteff+$gteff;
							
						}else{
							$this->data['indexTotalfee']=floor($indexTotalfee*4)/100;
						}
						
						
						// 下级运单详情
						$rowsChildSendOrderAll=$this->model_account_promoter->getChildSendOrder($strChild,$Efftime);
				
				
				if(isset($rowsChildSendOrderAll['lteff']) && is_array($rowsChildSendOrderAll['lteff'])){
				
						//运单明细
						foreach($rowsChildSendOrderAll as $key=>$rowChildSendOrderAll){
						
							foreach($rowChildSendOrderAll as $k=>&$v){

							//$rowsChildSendOrderAll[$key][$k]['oidtotalfell']=$this->model_account_promoter->getOldFell($v['oids']);
							
							if($key == 'lteff'){
									$commission_ratio=4*0.01;
									$rowsChildSendOrderAll[$key][$k]['yongjin']= floor($v['totalfee']*100*$commission_ratio)/100; 
									
								}else{
									$commission_ratio=6*0.01;
									$rowsChildSendOrderAll[$key][$k]['yongjin']=floor($v['totalfee']*100*$commission_ratio)/100;
								}
							}
						}
						
						$arrChildSendOrderAll=array_merge($rowsChildSendOrderAll['gteff'],$rowsChildSendOrderAll['lteff']);

				}else{
				
							foreach($rowsChildSendOrderAll as $k=>&$v){
						
								$rowsChildSendOrderAll[$k]['yongjin']=floor($v['totalfee']*100*$commission_ratio)/100;
								
							}
							$arrChildSendOrderAll=$rowsChildSendOrderAll;
						}
				}

			$this->data['numChildBuy']=$numChildBuy;
			$this->data['numCanQuxian']=$numCanQuxian;
			$this->data['rows']=$arrChildSendOrderAll;
			
			$this->data['child_reg_num']=count($arrChild);
			$this->data['numlastmonth']=$Total_reward;
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_reward.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/promoter_reward.tpl';
			} else {
				$this->template = 'default/template/account/promoter_reward.tpl';
			}
			$this->children = array(
				'common/header_cart',
				'common/footer',
				'common/uc_business'
			);
			$this->response->setOutput($this->render());
    }
	//提现明细
	public function withdraw() {
	if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
		if (isset($this->request->get['filter_date_start'])) {
		
				$filter_date_start=$this->request->get['filter_date_start'];
			}else{
			
				$filter_date_start='';
			}
		if (isset($this->request->get['filter_date_end'])) {
		
				$filter_date_end=$this->request->get['filter_date_end'];
				
			}else{
			
				$filter_date_end='';
				
			}
		
		if (isset($this->request->get['page'])) {
		
				$page = $this->request->get['page'];
				
		} else {
		
				$page = 1;
		}

		
		if (isset($this->request->get['month'])) {
		
				$month = $this->request->get['month'];
		} else {
		
				$month = 2;
		}
		
		
		$url = '';

		if (isset($this->request->get['page'])) {
		
			$url .= '&page=' . $this->request->get['page'];
			
		}
		
		if (isset($this->request->get['filter_date_start'])) {
		
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
				
		}
		
		if (isset($this->request->get['filter_date_end'])) {
		
			$url .= '&end_time=' . $this->request->get['filter_date_end'];
				
		}
	
		if (isset($this->request->get['month'])) {
		
			$url .= '&month=' . $this->request->get['month'];
				
		}
		
		if($filter_date_start){
		
			$month=2;
		}
	
		$this->data['month']=$month;	
		
		$this->data['filter_date_start']=$filter_date_start;
		
		$this->data['filter_date_end']=$filter_date_end;
		
		$this->load->model('account/promoter');
		
		$customer_id=$this->session->data['customer_id'];
		
		$start=($page - 1) * 10;
		
		$limit=$start.',10';
		
		$tixian_total=$this->model_account_promoter->getTixianTotal($customer_id,$this->data);
		
		$rows=$this->model_account_promoter->getTixianInfo($customer_id,$this->data,$limit);
		
		$this->data['rows']=$rows;
		
		$pagination = new Pagination();
		
		$pagination->total = $tixian_total;
		
		$pagination->page = $page;
		
		$pagination->limit = 10;
		
		$pagination->text = $this->language->get('text_pagination');
		
		$pagination->url = $this->url->link('account/promoter/withdraw', $url.'&'.'page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_withdraw.tpl')) {
		
            $this->template = $this->config->get('config_template') . '/template/account/promoter_withdraw.tpl';
			
        } else {
		
            $this->template = 'default/template/account/promoter_withdraw.tpl';
			
        }
		
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
		
        $this->response->setOutput($this->render());
    }
	
	public function cashalipay() {
		if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }

		$this->load->model('account/promoter');
		
		$isbangding=$this->model_account_promoter->isBinding(1);
		
		$this->data['isbangding']=$isbangding;
		
		$commission=$this->true_ratio();
		//查用户生效时间
		$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
		
		$commission_ratio=$commission*0.01;
		
		$numCanQuxian=$this->model_account_promoter->getCanQuxian($commission_ratio,$Efftime);
		
		$numCanQuxian=$numCanQuxian > 0? $numCanQuxian:0;
		
		$this->data['numCanQuxian']=$numCanQuxian;
		$this->data['error']=isset($this->session->data['addWCFrom_error_1'])?$this->session->data['addWCFrom_error_1']:'';
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_cashalipay.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_cashalipay.tpl';
        } else {
            $this->template = 'default/template/account/promoter_cashalipay.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	
	public function cashpaypal() {
	
		  if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
		  }
		$this->load->model('account/promoter');
		
		$isbangding=$this->model_account_promoter->isBinding(2);
		
	
		$commission=$this->true_ratio();
		
		$commission_ratio=$commission*0.01;
		//查用户生效时间
		$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
		
		$numCanQuxian=$this->model_account_promoter->getCanQuxian($commission_ratio,$Efftime);
		
		$numCanQuxian=$numCanQuxian > 0? $numCanQuxian:0;
		
		$this->data['numCanQuxian']=$numCanQuxian;
		$this->data['isbangding']=$isbangding;
		$this->data['error']=isset($this->session->data['addWCFrom_error_2'])?$this->session->data['addWCFrom_error_2']:'';
		$this->data['hl']=0.16;
		$this->data['sxf']=0.05;
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_cashpaypal.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_cashpaypal.tpl';
        } else {
            $this->template = 'default/template/account/promoter_cashpaypal.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	//	查询真实的佣金比例
	public function true_ratio(){

			$customer_id=$this->session->data['customer_id'];
			$this->load->model('account/promoter');
			$commission_ratio=$this->model_account_promoter->getDj();
			$efftime=$this->model_account_promoter->getUserEff($customer_id);
			if($commission_ratio !=6 ){
			 $childBuyNum=$this->model_account_promoter->getChildBuy();//判断购买人数是否大于3个人
			
			 if($childBuyNum >=3){
				$strChild=$this->model_account_promoter-> getChildSid();//获取子级id
				$arrChildSendorder=$this->model_account_promoter->getChildSendorderByTime($strChild);
				if(count($arrChildSendorder) >= 3){
						$arrUserId=array();
						$arrSid=array();
						foreach($arrChildSendorder as $key=>$v){
							if(!in_array($v['uid'],$arrUserId)){
								$arrUserId[$key]=$v['uid'];
								$arrSid[$key]=$v['confirm_receipt_time'];
							}
						}
						$confirm_time=$arrSid[2];
						//echo date('Y-m-d H:i:s',$confirm_time);
						$commission_ratio=6;
						$Effective_time = strtotime(date('Y-m-d', strtotime("+1 day",$confirm_time)));
						$this->model_account_promoter->setEffectiveTime($customer_id,$Effective_time ); //1414972800 	
					}
				}
			}
			return $commission_ratio;
	}
	
	
	public function addWCFrom(){
	
	if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
	  
		if($this->request->post){
			$this->load->model('account/promoter');
			$uid=$this->session->data['customer_id'];
			$money=$this->request->post['money'];
			$type=$this->request->post['type'];	
			
			$commission=$this->true_ratio();
			//查用户生效时间
			$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
		
			$commission_ratio=$commission*0.01;
			
			$numCanQuxian=$this->model_account_promoter->getCanQuxian($commission_ratio,$Efftime);
			
			if($money !="" && $money < $numCanQuxian ){
			
				if($type==1){
						$data=array(
							'uid'=>$uid,
							'money'=>$money,
							'usd'=>0,
							'type'=>$type,
							'sxf'=>$money*0.05,
							'actual_money'=>$money-$money*0.05
						);
				}else{
						$data=array(
							'uid'=>$uid,
							'money'=>$money,
							'usd'=>$this->request->post['usd'],
							'type'=>$type,
							'sxf'=>$money*0.05,
							'actual_money'=>$money-$money*0.05
						);
				}
					
					$this->model_account_promoter->addWithdrawCash($data);
					$this->redirect('/account-promoter-withdraw.html');
			}else{
				$this->session->data['addWCFrom_error_'.$type]='输入金额有误';
				if($type==1){
					$this->redirect('/account-promoter-cashalipay.html');
				}else{
					$this->redirect('/account-promoter-cashpaypal.html');
				}
			}
		}
		
	}
	
	public function addpaypal() {

	  if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
		$status=0;
      	$sql="select account from oc_withdraw_cash_account where uid='".$this->session->data['customer_id']."' and type=2 ";
		$row=$this->db->query($sql);
		//var_dump($row);
		if($row->num_rows){
			$status=1;
			$this->data['account_status']=1;
			$this->data['account']=$row->row['account'];
			$this->data['step']=3;
		}
		
		if($status != 1){
			if(isset($this->session->data['step']) && $this->session->data['step']==3  &&  $this->session->data['account_type'] != 1){
			$this->data['step']=$this->session->data['step'];
			$this->data['account_status']=$this->session->data['account_status'];
			if($this->session->data['account_status']){
					$sql="select account from oc_withdraw_cash_account where uid='".$this->session->data['customer_id']."' and type=2 ";
					$row=$this->db->query($sql);
					$this->data['account']=$row->row['account'];
				}
			}else{
				$this->data['step']=1;
			}
		}
		
		 if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_addpaypal.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_addpaypal.tpl';
        } else {
            $this->template = 'default/template/account/promoter_addpaypal.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
    }
	
	public function addalipay() {
	 if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
		$status=0;
      	$sql="select account from oc_withdraw_cash_account where uid='".$this->session->data['customer_id']."' and type=1 ";
		$row=$this->db->query($sql);

		if($row->num_rows){
			$status=1;
			$this->data['account_status']=1;
			$this->data['account']=$row->row['account'];
			$this->data['step']=3;
		}
		
		if($status != 1){
			if(isset($this->session->data['step']) && $this->session->data['step']==3  && $status != 1 && $this->session->data['account_type']==1 ){
			$this->data['step']=$this->session->data['step'];
			$this->data['account_status']=$this->session->data['account_status'];
			if($this->session->data['account_status']){
					$sql="select account from oc_withdraw_cash_account where uid='".$this->session->data['customer_id']."' and type=1 ";
					$row=$this->db->query($sql);
					if($row->row){
						$this->data['account']=$row->row['account'];
					}else{
						$this->data['account']='';
					}
				}
			}else{
				$this->data['step']=1;
			}
		}
	
		
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_addalipay.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_addalipay.tpl';
        } else {
            $this->template = 'default/template/account/promoter_addalipay.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
		
    }
	//
	public function saveAliUname(){
		if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		if($this->request->post){
			$_SESSION['account_email']=$this->request->post['apipay_account'];
			$_SESSION['account_name']=$this->request->post['apipay_name'];
			
		}
		
		$this->data['step']=2;
		
		  if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_addalipay.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_addalipay.tpl';
        } else {
            $this->template = 'default/template/account/promoter_addalipay.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());
		
	}
	public function ajaxCheckPaypal(){
	
		if(isset($this->request->post['paypal_code']) && !empty($this->request->post['paypal_code'])){
			$time=time();
			$code=strtoupper($this->request->post['paypal_code']);
			if($_SESSION['account_expiration']+60*30 > $time){
				if(strtoupper($_SESSION['account_code'])==$code){
					echo 111;die;//正确
				}else{
					 echo 222; die;//错误
				}
			}else{
				echo 999;die;//过期
			}
		}  
	}
	//验证2步 输入验证码
	public function checkedAccount(){
		
	  if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
		  }

		$this->data['step']=2;
	   if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/promoter_addpaypal.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/promoter_addpaypal.tpl';
        } else {
            $this->template = 'default/template/account/promoter_addpaypal.tpl';
        }
        $this->children = array(
            'common/header_cart',
			'common/footer',
			'common/uc_business'
        );
        $this->response->setOutput($this->render());

	}
	
	public function ajaxCheckCode(){
		  if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
		  }
		  
		   $msg='';
		if(isset($this->request->post['ali_code']) && !empty($this->request->post['ali_code'])){
		
			$code=strtoupper($this->request->post['ali_code']);
		
			$time=time();
			
			if($_SESSION['account_expiration']+60*30 > $time){
				if(strtoupper($_SESSION['account_code'])==$code){
					echo 111;
					 die;
				}else{
					echo 222; 
					die;
				}
			}else{
				echo 999;
				die;
			}
		}  
		  
	}
	//发送邮件
	public function sendEmail(){
	
		  if (!$this->customer->isLogged()) {
				$this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
				$this->redirect($this->url->link('account/login', '', 'SSL'));
		  }
		  
		  	$type=$this->request->post['type'];	
		  if($type==2){
			$email=$this->request->post['paypal_email'];	
			$_SESSION['account_name']=$this->request->post['paypal_name'];
			$_SESSION['account_email']=$email;
			$_SESSION['account_type']=2;
		  }else{
			$email=$this->request->post['email'];	
			$_SESSION['account_type']=1;
		  }
		  
	  $code='';  
	  $length=4;
	  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	   for ( $i = 0; $i < $length; $i++ ) {
        $code .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
	$_SESSION['account_code']=$code;
	$_SESSION['account_expiration']=time();	
	$sendtime=date('Y-m-d H:i:s',time());
	if($type==2){
		$txt='Paypal';
	}else{
		$txt='支付宝';
	}
$str =<<<EOD
	<table align="center" cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td style="background-color:#fff; padding: 40px 40px 0;">
							<h4 style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">亲爱的Cnstorm用户，您好！</h4>
						</td>
					</tr>
					<tr>
						<td style="background-color:#fff; padding: 0px 40px 0;">
						  <p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">您在{$sendtime}(UTC)提交了绑定{$txt}的请求,本次验证码</p>
						  <p style="font-size:16px">{$code}</p> 
						 <p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;" > 请在30分钟内在验证页面填入此验证码</p>
							<br/>
						</td>
					</tr>
					<tr>
						<td style="background-color:#fff; padding: 0px 40px 0;">
							<p style="font-family:Helvetica Neue Light,Helvetica Neue,'Hiragino Sans GB','Microsoft Yahei',Trebuchet MS,Arial;color:#383838;font-size:16px;">如果您并未发送此请求,则可能是其他用户误输入了您的邮箱，请忽略此邮件</p>
						</td>
					</tr>
					<tr>
					<td align="center">
						<p style="color: #a0a0a0; font-size:13px; margin: 10px 0;">如果您在使用中有任何的疑问或者建议，欢迎反馈我们意见至邮件：<a href="mailto:support@teambition.com" style="color: #a0a0a0;">support@cnstorm.com</a>
						</p>
					</td>
				</tr>
					</tbody>
</table>
EOD;

		$subject='CNstorm安全验证';
		  $data = array(
                        'sendto' => $email,
                        'receiver' => '',
                        'subject' => $subject,
                        'msg' => $str,
                    );

		$this->load->model('tool/sendmail');
	   $this->model_tool_sendmail->send($data);
	     sleep(1);
		 if($type==2){
				echo "<script>window.location.href='/account-promoter-checkedAccount.html';</script>";
		 }else{
			echo 1;
		 }
	}
	//添加提现卡用户记录
	public function addAccount(){

	  if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/edit', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
      }
			$this->load->model('account/promoter');
			$uid=$this->session->data['customer_id'];
			$type=$this->session->data['account_type'];	
			$email=$this->session->data['account_email'];	
			$data=array();
			if($type==1){
				$data=array(
					'uid'	=>$uid,
					'type'	=>$type,
					'username'=>$this->session->data['account_name'],
					'account'=>$email,
					'addtime'=>time()
				);
			}else{
				$data=array(
					'uid'	=>$uid,
					'type'	=>$type,
					'username'=>$this->session->data['account_name'],
					'account'=>$email,
					'addtime'=>time()
				);
			}
			if($data){
				$status=$this->model_account_promoter->addAccount($data);
			}
			
			if($status){
				$this->session->data['step']=3;
				$this->session->data['account_status']=1;
				if($type==1){
					$this->redirect($this->url->link('account/promoter/addalipay', '', 'SSL'));
				}else{
					 $this->redirect($this->url->link('account/promoter/addpaypal', '', 'SSL'));
				}
				
			}else{
				$this->session->data['step']=3;
				$this->session->data['account_status']=0;
				$this->session->data['account_error']='服务器繁忙，请稍后在试！';
				if($type==1){
					$this->redirect($this->url->link('account/promoter/addalipay', '', 'SSL'));
				}
				$this->redirect($this->url->link('account/promoter/addpaypal', '', 'SSL'));
				
				
			}

	}
//任意一个月佣金
	public function evermonth(){
			if($this->request->post){
				$year='';
				$month='';
				$this->load->model('account/promoter');
				
				$commission=$this->true_ratio();
				//查用户生效时间
				$Efftime=$this->model_account_promoter->getUserEff($this->session->data['customer_id']);
				$year=$this->request->post['year'];
				$month=$this->request->post['month'];
				$data=$year.'-'.$month;
				$endDate = strtotime(date("Y-m-t 23:59:59",strtotime($data)));
				
				$everfree=$this->model_account_promoter->getEverMonth($data,$Efftime);
			
				if(isset($everfree) && is_array($everfree)){
					$lteff=floor($everfree['lteff']*4)/100;
					$gtleff=floor($everfree['gteff']*6)/100;
					echo $lteff+$gtleff;
				}else{
					echo  floor($everfree*4)/100;
					//echo $everfree;
				}
			}
		}

	public function checkemail(){

		if($this->request->post){

			$this->load->model('account/promoter');
			$email=$this->request->post['email'];
			$type=$this->request->post['type'];
			
			$row=$this->model_account_promoter->checkEmail1($email,$type);
			
			if($row){
				echo 1;
			}else{
				echo 0;
			}

		}
	}		
	
}
?>