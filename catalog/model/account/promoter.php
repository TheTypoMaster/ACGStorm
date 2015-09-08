<?php 

class ModelAccountPromoter extends Model {

	//计算时间内注册的下级人数
	public function getChild($month){
			$sql="SELECT sid FROM oc_promotion_grade opg LEFT JOIN `oc_customer` oc ON  opg.`sid`= oc.customer_id where pid=". (int) $this->session->data['customer_id'];
			
			if($month==1){
			//当月记录
				$BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
				$endDate=strtotime(date('Y-m-d', strtotime("$BeginDate +1 month -1 day")).' 23:59:59');//1438387199
				$BeginDate=strtotime($BeginDate);	
				
				$sql.=" and oc.regtime >".$BeginDate." and oc.regtime <=  ".$endDate;
			}else if($month==3){
				//3个月记录
				$BeginDate= date('Y-m-t', strtotime('-3 month'));
				$endDate= strtotime(date('Y-m-d', strtotime("$BeginDate +3 month -1 day")).' 23:59:59');
				$BeginDate=strtotime($BeginDate);	
				$sql.=" and oc.regtime >".$BeginDate." and oc.regtime <= ".$endDate;	
			}
			$arr=array();
			
			$row=$this->db->query($sql);
			if($row->rows){
				
				for($i=0;$i<count($row->rows);$i++){
					$arr[]=$row->rows[$i]['sid'];
				}
			}
			return $arr;
	}
	
	//获取当月奖励 
	public function getIndexMonth($Efftime){

	//这个月第一天	
		$BeginDate=strtotime(date('Y-m-01', strtotime(date("Y-m-d"))));
		$endDate=strtotime(date('Y-m-t 23:59:59', strtotime(date("Y-m-d"))));
		$sid=$this->getChildSid();
		if($sid){
		
			if(!$Efftime || $Efftime > $endDate){
			
				$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate ";
				$row=$this->db->query($sql);
				return $row->row['totalfee'];
			
			}else{
			
				$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate and os.confirm_receipt_time <= ".$Efftime;
				$row=$this->db->query($sql);
				$lteff = $row->row['totalfee'];
						
				$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate and os.confirm_receipt_time > ".$Efftime;
				$row=$this->db->query($sql);
				$gteff = $row->row['totalfee'];
				
				return array('lteff'=>$lteff,'gteff'=>$gteff);
			}
			
		}else{
			return 0;
		}
	}
	
	//任意月
	public function getEverMonth($data,$Efftime){
		$BeginDate=strtotime(date("Y-m-01 00:00:00",strtotime($data)));
		$endDate = strtotime(date("Y-m-t 23:59:59",strtotime($data)));
		
		$sid=$this->getChildSid();
		if($sid){
		
		if(!$Efftime ||  $Efftime > $endDate ){ //如果没有生效时间或者 订单在生效时间之前

			$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate ";
			$row=$this->db->query($sql);
		
			return $row->row['totalfee'];

			}else{
	
			$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time < $Efftime and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate ";
			$row=$this->db->query($sql);
		
			$lteff = $row->row['totalfee'];
				
			$sql="select sum(os.totalfee)as totalfee from oc_sendorder os  where  os.state in(3,8) and os.country <> 'China' and os.uid in(".$sid.") and os.confirm_receipt_time > $Efftime and os.confirm_receipt_time >$BeginDate and os.confirm_receipt_time < $endDate ";
			$row=$this->db->query($sql);
		
			$gteff = $row->row['totalfee'];	
		
			return array('lteff'=>$lteff,'gteff'=>$gteff);
	
			}
		}else{
			return 0;
		}
	}
	
	//获取子级id
	public function getChildSid(){
		$sql="select sid from oc_promotion_grade where status=0 and  pid=".$this->session->data['customer_id'];
		$row=$this->db->query($sql);
		$sid='';
		if($row->rows){
			for($i=0;$i<count($row->rows);$i++){
				if($sid==''){
					$sid = $row->rows[$i]['sid'];
				}else{
					$sid .=','.$row->rows[$i]['sid'];
				}
			}
		}
		return $sid;
	}
	//获取消费人数
	public function getChildBuy(){
		$sid=$this->getChildSid();
		
		if($sid){
			$sql="SELECT count(sid)as buyNum FROM oc_sendorder WHERE uid IN(".$sid.") AND state IN(3,8) and country <> 'China'  GROUP BY  uid ";
			$row=$this->db->query($sql);
		
			return $row->num_rows;
		}else{
			return 0;
		}
		
	}
	//获取可提现余额
	public function getCanQuxian($dj,$Efftime){
		$bengin=strtotime(date('Y-m-01 00:00:00',time()));//这个月1号
		
		$totalfee=$this->getChildLastMonth($Efftime,$bengin);	
	
		if(is_array($totalfee)&&!empty($totalfee)){
				$commission_ratio=0.04;
				$lteff=floor($totalfee['lteff']*100*$commission_ratio)/100;
				$commission_ratio=0.06;
				$gteff=floor($totalfee['gteff']*100*$commission_ratio)/100;
				$Total_reward=$lteff+$gteff;
		}else{
			$Total_reward=floor($totalfee*100*$dj)/100;
		}
		
		$sql="select sum(money)as totalmoney from oc_withdraw_cash where Acceptance_state!=3 and uid= ".$this->session->data['customer_id'];
		$row=$this->db->query($sql);
		$totalmoney=$row->row['totalmoney'];	
		return $Total_reward - $totalmoney;
	}

//	public function 
	//获取下级用户贡献的总佣金
	public function getChildLastMonth($efftime,$index=''){
	
		$sid=$this->getChildSid();	
		if($sid){
			if(!$efftime){
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8) and os.country <> 'China'";
								if($index){
									$sql.=" and os.confirm_receipt_time < ".$index;
								}
								$row=$this->db->query($sql);
								return $row->row['totalfee'];
			}else{
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8) and os.country <> 'China' and os.confirm_receipt_time < ".$efftime;
								if($index){
									$sql.=" and os.confirm_receipt_time < ".$index;
								}
				$row=$this->db->query($sql);
				$lteffTotalfee= $row->row['totalfee'];
				
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8) and os.country <> 'China' and os.confirm_receipt_time > ".$efftime;
								if($index){
									$sql.=" and os.confirm_receipt_time < ".$index;
								}
				$row=$this->db->query($sql);
				$gteffTotalfee= $row->row['totalfee'];
			
				return array('lteff'=>$lteffTotalfee,'gteff'=>$gteffTotalfee);
			}
			
		}
		return 0;
	}
	//获取所有下级用户运单
	public function getChildSendOrder($sid,$efftime){
	
		if($efftime){
		
			$sql="select os.sid,os.uptime,os.addtime,os.confirm_receipt_time,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) and os.country <> 'China' ";
			
			$sql.=" and confirm_receipt_time <  ".$efftime;
			
			$sql.=" order by confirm_receipt_time desc ";
			
			$row=$this->db->query($sql);
			
			$arrLtEff= $row->rows;
		
			$sql="select os.sid,os.uptime,os.addtime,os.confirm_receipt_time,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) and os.country <> 'China' " ;
		
			$sql.=" and confirm_receipt_time >  ".$efftime;
		
			$sql.=" order by confirm_receipt_time desc ";
		
			$row=$this->db->query($sql);
			
			$arrGtEff = $row->rows;
			
			$arr['lteff']=$arrLtEff;
			
			$arr['gteff']=$arrGtEff;
			
			return $arr;die;
		}else{
		
			$sql="select os.sid,os.uptime,os.confirm_receipt_time,os.addtime,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) and os.country <> 'China' order by confirm_receipt_time desc ";
		
			$row=$this->db->query($sql);
			
			return $row->rows;
			
		}
	
	}
	//获取用户有效期时间
	public function getUserEff($uid){
		$sql="select commission_time from oc_promotion_personnel where uid=".$uid;
		
		$row=$this->db->query($sql);
		if($row->row){
			return $row->row['commission_time'];
		}else{
			return '';
		}
	}
	//
	public function setEffectiveTime($uid,$Effective_time){
		$sql="update oc_promotion_personnel  set commission_ratio=6,grade=2,commission_time=".$Effective_time." where uid= ".$uid;
		$this->db->query($sql);
		
	}
	//获取订单总金额
	public function getOldFell($oid){
		$sql="select sum(total) as oidtotalfell  from oc_order where order_id in($oid)";
		$row=$this->db->query($sql);
			//var_dump($row);
		return $row->row['oidtotalfell'];
	}
	//获取佣金比例
	public function getCommissionRatio($uid){
		$sql="select commission_ratio   from oc_promotion_personnel where uid =".$uid;
		$row=$this->db->query($sql);
			//var_dump($row);
		if($row->row){
			return $row->row['commission_ratio'];
		}else{
			return 4;
		}
		
	}
	//添加提现记录
	public function addWithdrawCash($data){
	$sql="insert into oc_withdraw_cash(uid,money,type,add_time,usd,actual_money,sxf)values('".$data['uid']."','".$data['money']."','".$data['type']."','".time()."','".$data['usd']."','".$data['actual_money']."','".$data['sxf']."')";
		$this->db->query($sql);
	}
	
	//查询提现总记录
	public function getTixianTotal($uid,$data){
			$sql="select *  from oc_withdraw_cash where uid =".$uid;
	
				if($data['month']==1){
					 $BeginDate=strtotime(date('Y-m-01', strtotime(date("Y-m-d"))));
					 $sql.=" and add_time > ". $BeginDate;
					
				}else if($data['month']==2){
					
					if($data['filter_date_start']){
						$sql.=" and add_time >'".strtotime($data['filter_date_start'])."'"; 
					}
					if($data['filter_date_end']){
						$sql.=" and add_time < ".strtotime($data['filter_date_end']);
					}
				}else if($data['month']==3){
					$BeginDate= strtotime(date('Y-m-t', strtotime('-3 month')));
					$sql.=" and add_time > ". $BeginDate;
				}
			$row=$this->db->query($sql);
			return $row->num_rows;
	}
	
	//查询提现记录
	public function getTixianInfo($uid,$data,$limit){
	
			$sql="select *  from oc_withdraw_cash where uid =".$uid;
			
			if($data['month']==1){
			
				 $BeginDate=strtotime(date('Y-m-01', strtotime(date("Y-m-d"))));
				 $sql.=" and add_time > ". $BeginDate;
				 
			}else if($data['month']==2){
			
				if($data['filter_date_start']){
					$sql.=" and add_time >'".strtotime($data['filter_date_start'])."'"; 
				}
				if($data['filter_date_end']){
					$sql.=" and add_time < ".strtotime($data['filter_date_end']);
				}
			}else if($data['month']==3){
			
				$BeginDate= strtotime(date('Y-m-t', strtotime('-3 month')));
				$sql.=" and add_time > ". $BeginDate;
			}
			
			$sql.=" limit ".$limit;
			$row=$this->db->query($sql);
			return $row->rows;
	}
	public function  addAccount($data){
		$sql="insert into oc_withdraw_cash_account(uid,type,username,account,addtime)values('".$data['uid']."','".$data['type']."','".$data['username']."','".$data['account']."','".$data['addtime']."')";
		$status=$this->db->query($sql);
		return $status;
	}
	public function isBinding($type){
		$sql="select * from oc_withdraw_cash_account where uid=".$this->session->data['customer_id']." and type=".$type;
		$row=$this->db->query($sql);
		return $row->num_rows;
	}
	public function getDj(){
		$sql="select commission_ratio from oc_promotion_personnel where uid=".$this->session->data['customer_id'];
		$row=$this->db->query($sql);
		if($row->row){
			return $row->row['commission_ratio'];
		}else{
			return 4;
		}
	}

	public function checkEmail1($email,$type){

		$sql="select * from oc_withdraw_cash_account where account='".$email."' and type='".$type."' and uid=".$this->session->data['customer_id'];
		$row=$this->db->query($sql);
		return $row->num_rows;
	}
	
	public function getChildSendorderByTime($strChild){
		$sql="SELECT sid,uid,confirm_receipt_time FROM oc_sendorder WHERE uid IN (".$strChild.") AND state IN(3,8) and country <> 'China' ORDER BY confirm_receipt_time ASC";
		$row=$this->db->query($sql);
		return $row->rows;
	}
	//获取真实佣金比例
		public function true_ratio(){
			$customer_id=$this->session->data['customer_id'];
			$commission_ratio=$this->getDj();
			if($commission_ratio !=6 ){
			
			 $childBuyNum=$this->getChildBuy();
			 
			if($childBuyNum >=3){
					$strChild=$this->getChildSid();//获取子级id
					$arrChildSendorder=$this->getChildSendorderByTime($strChild);
					$arrUserId=array();
					$arrSid=array();
					foreach($arrChildSendorder as $key=>$v){
						if(!in_array($v['uid'],$arrUserId)){
							$arrUserId[$key]=$v['uid'];
							$arrSid[$key]=$v['confirm_receipt_time'];
						}
					}
					$confirm_time=$arrSid[2];
				
					$commission_ratio=6;
					$Effective_time = strtotime(date('Y-m-d', strtotime("+1 day",$confirm_time)));
					$this->setEffectiveTime($customer_id,$Effective_time );//1414972800 	
					

				}
			}
			return $commission_ratio;
	}
}
?>