<?php 

	class ModelPromotionPromotion extends Model {
		//推广员信息管理
		public function  getPromotionTotal(){
			$sql="SELECT op.*, oc.firstname,oc.ip,oc.logintime,oc.regtime,oc.status,(SELECT COUNT(*) FROM oc_promotion_grade WHERE pid=op.uid)level_num FROM oc_promotion_personnel op LEFT JOIN  oc_customer  oc ON oc.customer_id=op.uid  ";
			$row=$this->db->query($sql);
			return $row->num_rows;
		}
		//获取推广员下级用户id
		public function getChildSid($uid){
			$sql="select sid from oc_promotion_grade where status=0 and  pid=".$uid;
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
		
		public function getCommission_ratio($uid){
				$sql="select commission_ratio from oc_promotion_personnel where uid=".$uid;
				$row=$this->db->query($sql);
				return $row->row['commission_ratio'];
		}
		//获取用户升级时间
	public function getUserEff($uid){
		$sql="select commission_time from oc_promotion_personnel where uid=".$uid;
		
		$row=$this->db->query($sql);
		if($row->row){
			return $row->row['commission_time'];
		}else{
			return '';
		}
	}
		//获取推广员等级
		public function true_ratio(){
		
				$customer_id=$this->session->data['customer_id'];
				
				$commission_ratio=$this->getCommission_ratio($customer_id);
				
				if($commission_ratio !=6 ){
				
				 $childBuyNum=$this->getChildBuyNum();
				 
				 if( $childBuyNum >= 3 ){
				 
						$strChild=$this->getChildSid($customer_id);//获取子级id
						$efftime=$this->getUserEff();
						$arrChildSendorder=$this->getChildSendOrder($strChild,$efftime);//获取子级运单
						if(count($arrChildSendorder) > 3){
							$commission_ratio=6;
							$arrChildSendorder=array_reverse($arrChildSendorder);
							$confirm_time=$arrChildSendorder[2]['confirm_receipt_time']?$arrChildSendorder[2]['confirm_receipt_time']:$arrChildSendorder[2]['uptime'];
							$Effective_time = strtotime(date('Y-m-d', strtotime("+1 day",$confirm_time)));
							$this->setEffectiveTime($customer_id,$Effective_time );
						}
					}
				}
				return $commission_ratio;
		}
		
		//设置用户升级时间
		public function setEffectiveTime($uid,$Effective_time){
			$sql="update oc_promotion_personnel  set commission_ratio=6,grade=2,commission_time=".$Effective_time." where uid= ".$uid;
			$this->db->query($sql);
		}	
	
		public function getChildSendOrder($sid,$efftime){
	
		if($efftime){
		
			$sql="select os.sid,os.uptime,os.addtime,os.confirm_receipt_time,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) ";
			
			$sql.=" and addtime <  ".$efftime;
			
			$sql.=" order by addtime desc ";
			
			$row=$this->db->query($sql);
			
			$arrLtEff= $row->rows;
		
			$sql="select os.sid,os.uptime,os.addtime,os.confirm_receipt_time,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) " ;
		
			$sql.=" and addtime >  ".$efftime;
		
			$sql.=" order by addtime desc ";
		
			$row=$this->db->query($sql);
			
			$arrGtEff = $row->rows;
			
			$arr['lteff']=$arrLtEff;
			
			$arr['gteff']=$arrGtEff;
			
			return $arr;die;
		}else{
		
			$sql="select os.sid,os.uptime,os.confirm_receipt_time,os.addtime,os.uname,os.totalfee,oc.date_added,os.oids from oc_sendorder os left join oc_customer oc  on os.uid=oc.customer_id where uid in (".$sid.") and os.state in(3,8) order by addtime desc ";
		
			$row=$this->db->query($sql);
			
			return $row->rows;
			
		}
	
	}
		
		//获取推广员下级用户消费运单数
		public function getChildBuyNum($sid){
			$sql="SELECT count(sid)as buyNum FROM oc_sendorder WHERE uid IN(".$sid.") AND state IN(3,8) GROUP BY  uid ";
			$row=$this->db->query($sql);
			return $row->num_rows;
		}
		
		//获取推广员下级用户消费金额
		public function getChildBuyMoney($sid){
			$sql="SELECT sum(totalfee)as buyNum FROM oc_sendorder WHERE uid IN(".$sid.") AND state IN(3,8) ";
			$row=$this->db->query($sql);
			return $row->row['buyNum'];
		}
		
		//推广员信息管理	
		public function  getPromotion($limit){
		$sql="SELECT op.*, oc.firstname,oc.ip,oc.logintime,oc.regtime,oc.status,(SELECT COUNT(*) FROM oc_promotion_grade WHERE pid=op.uid)level_num,(SELECT SUM(money)AS tcmoney FROM oc_withdraw_cash WHERE uid=op.uid)AS money FROM oc_promotion_personnel op LEFT JOIN  oc_customer  oc ON oc.customer_id=op.uid  limit ".$limit;
			$row=$this->db->query($sql);
			return $row->rows;
		}
		//提现
		public function getTixianMargenTotal($filter_date_start,$filter_date_end,$type,$status,$name){
			$customer_id='';
			if($name){
				$sql="select customer_id from oc_customer where firstname ='".$name."'";
				$row=$this->db->query($sql);
				$customer_id=$row->row['customer_id'];
			}
		
			$sql="select ow.*,oc.firstname from oc_withdraw_cash  ow left join oc_customer oc on ow.uid=oc.customer_id where 1=1 ";
			if($filter_date_start){
				$sql.=" and ow.add_time > ".strtotime($filter_date_start);
			}
			if($filter_date_end){
				$sql.=" and ow.add_time <= ".strtotime($filter_date_end);
			}
			if($type){
				$sql.=" and ow.type = ".$type;
			}
			if($status){
				$sql.=" and ow.status = ".$status;
			}
			if($customer_id){
				$sql.=" and ow.uid = ".$customer_id;
			}
			$row=$this->db->query($sql);
			return $row->num_rows;
		}
		//提现
		public function getTixianMargen($filter_date_start,$filter_date_end,$type,$status,$name,$limit){
		$customer_id='';
			if($name){
				$sql="select customer_id from oc_customer where firstname ='".$name."'";
				$row=$this->db->query($sql);
				$customer_id=$row->row['customer_id'];
			}
		
			$sql="select ow.*,oc.firstname from oc_withdraw_cash  ow left join oc_customer oc on ow.uid=oc.customer_id where 1=1 ";
			
			if($filter_date_start){
				$sql.=" and ow.add_time > ".strtotime($filter_date_start);
			}
			if($filter_date_end){
				$sql.=" and ow.add_time <= ".strtotime($filter_date_end);
			}
			
			if($type){
				$sql.=" and ow.type = ".$type;
			}
			
			if($status){
				$sql.=" and ow.status = ".$status;
			}
			
			if($customer_id){
				$sql.=" and ow.uid = ".$customer_id;
			}
			$sql.=" limit ".$limit;
			
			$row=$this->db->query($sql);
			
			return $row->rows;
		}
		public function getOneTixian($id){
				$sql="SELECT ow.*,oc.firstname FROM oc_withdraw_cash ow LEFT JOIN oc_customer oc ON oc.customer_id= ow.uid where id=".$id;
				$row=$this->db->query($sql);
				return $row->row;
		}
		//累计一个人的提现金额
		public function getTixianMoney($uid){
			$sql='select sum(money) as money from oc_withdraw_cash where uid='.$uid;
			$row=$this->db->query($sql);
			if($row->row['money']){
				return $row->row['money'];
			}else{
				return 0;
			}
		}
		//获取推广员消费金额
		
		public function getCommission($username,$limit,$filter_date_start,$filter_date_end){
			$sql="select sid  from  oc_promotion_grade where status=0 and pid=(select customer_id from oc_customer where firstname='".$username."')";
			$rows=$this->db->query($sql);
			if($rows->num_rows){
				$strSid='';
				foreach($rows->rows as $v){
					if($strSid == ''){
						$strSid=$v['sid'];
					}else{
						$strSid.=','.$v['sid'];	
					}
				}
				$sql="SELECT IF(os.totalfee,os.totalfee,0)AS totalfee,os.addtime,oc.regtime,
				   oc.`logintime`,os.oids,os.uptime,oc.firstname,oc.ip,os.confirm_receipt_time,
				   IF(SUM(os.totalfee)>0,SUM(os.totalfee),0)AS allTotalFee ,oc.email,oc.customer_id,
				   IF(opp.commission_ratio,opp.commission_ratio,4)AS commission_ratio,
				   IF(opp.grade,opp.grade,1) AS grade,(SELECT IF(SUM(total),SUM(total),0)AS total FROM oc_order WHERE order_id IN(os.oids))AS ordertotal FROM oc_customer oc 
				   LEFT JOIN oc_promotion_grade opg ON opg.sid=oc.customer_id
				   LEFT JOIN oc_promotion_personnel opp ON opp.uid= oc.customer_id
				   LEFT JOIN oc_sendorder os ON oc.customer_id=os.uid WHERE  oc.customer_id IN(".$strSid.") AND  opg.status=0 ";
					if($filter_date_start){
						$sql.=" and os.confirm_receipt_time > ".strtotime($filter_date_start);;
					}
					if($filter_date_end){
						$sql.=" and os.confirm_receipt_time < ".strtotime($filter_date_end);;
					}
				  $sql.=" GROUP BY oc.customer_id ";
				 $rows=$this->db->query($sql);
					return $rows->rows;
			}else{
				return false;
			}
		}
		//
		public function getTotalCommission($uid,$efftime){
			if($efftime){
				$sql="SELECT SUM(totalfee)as alltotalfee  FROM oc_sendorder WHERE uid=".$uid." AND  state IN(3,8) and uptime < ".$efftime;
				$lteffTotalfee=$this->db->query($sql)->row['alltotalfee'];
				
				$sql="SELECT SUM(totalfee)as alltotalfee   FROM oc_sendorder WHERE uid=".$uid." and state IN(3,8) AND uptime > ".$efftime;
				
				 $gteffTotalfee=$this->db->query($sql)->row['alltotalfee'];
				 
				if($lteffTotalfee){
				
					$lteffTotalfee=floor($lteffTotalfee*4)/100;
				}else{
					$lteffTotalfee=0;
				}
				
				if($gteffTotalfee){
				
					$gteffTotalfee=floor($gteffTotalfee*6)/100;
					
				}else{
				
					$gteffTotalfee=0;
				}
				
				return $lteffTotalfee+$gteffTotalfee;
			}else{
				return 0;
			}
		}

		//获取下级用户贡献的总佣金
	public function getChildLastMonth($sid,$efftime,$index=''){
		if($sid){
			if(!$efftime){
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8)";
								if($index){
									$sql.=" and os.confirm_receipt_time < ".$index;
								}
								$row=$this->db->query($sql);
								return $row->row['totalfee'];
			}else{
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8) and os.confirm_receipt_time < ".$efftime;
						if($index){
							$sql.=" and os.confirm_receipt_time < ".$index;
						}
						$row=$this->db->query($sql);
						$lteffTotalfee= $row->row['totalfee'];
				$sql="select os.sid,os.uname,sum(os.totalfee)as totalfee,oc.date_added,os.oids from oc_sendorder  os 
								left join oc_customer oc  on os.uid=oc.customer_id  
								left join oc_promotion_grade opg on  os.uid=opg.sid  
								where uid in (".$sid.") and  opg.status=0 and  os.state in(3,8) and os.confirm_receipt_time > ".$efftime;
								if($index){
									$sql.=" and os.confirm_receipt_time < ".$index;
								}
				$row=$this->db->query($sql);
				$gteffTotalfee= $row->row['totalfee'];
				$lteff=floor($lteffTotalfee*4)/100;
				$gteff=	floor($gteffTotalfee*6)/100;
				//return array('lteff'=>$lteffTotalfee,'gteff'=>$gteffTotalfee);
				return $lteff+$gteff;
			}
		}
		return 0;
	}
		
		
		public function getCommissionTotal($username){
		
			$sql="select sid  from  oc_promotion_grade where  status=0 and pid=(select customer_id from oc_customer where firstname='".$username."')";
			
			$rows=$this->db->query($sql);
			if($rows->rows){
				$strSid='';
				
				foreach($rows->rows as $v){
				
					if($strSid == ''){
					
						$strSid=$v['sid'];
					}else{

						$strSid.=','.$v['sid'];	
					}
					
				}
				
				$sql="SELECT IF(os.totalfee,os.totalfee,0)AS totalfee,os.addtime,IF(oc.regtime, FROM_UNIXTIME(oc.regtime, '%Y-%m-%d %H:%i:%S'),date_added) AS  regtime,
			   IF(oc.`logintime`,FROM_UNIXTIME(oc.logintime, '%Y-%m-%d %H:%i:%S'),'')AS logintime,os.oids,oc.firstname,oc.ip,
			   IF(SUM(os.totalfee)>0,SUM(os.totalfee),0)AS allTotalFee ,oc.email,oc.customer_id,
			   IF(opp.commission_ratio,opp.commission_ratio,4)AS commission_ratio,
			   IF(opp.grade,opp.grade,1) AS grade,(SELECT IF(SUM(total),SUM(total),0)AS total FROM oc_order WHERE order_id IN(os.oids))AS ordertotal FROM oc_customer oc 
			   LEFT JOIN oc_promotion_grade opg ON opg.sid=oc.customer_id
			   LEFT JOIN oc_promotion_personnel opp ON opp.uid= oc.customer_id
			   LEFT JOIN oc_sendorder os ON oc.customer_id=os.uid WHERE  oc.customer_id IN(".$strSid.") AND  opg.status=0 AND os.`state`IN(3,8) ";
				
				$rows=$this->db->query($sql);
				
				return $rows->num_rows;
				
			}else{
				return  false;
			}
		}
		//获取当前推广员信息Byname
		public function getPromotionPerson($uname){
		
		 $sql="SELECT opp.grade,opp.commission_ratio,oc.firstname,oc.customer_id,oc.`ip`,oc.`regtime`,oc.`logintime`,SUM(totalfee)AS totalfee FROM oc_promotion_personnel opp
		 LEFT JOIN oc_customer oc ON oc.`customer_id`=opp.`uid` 
		LEFT JOIN oc_sendorder os ON oc.`customer_id`=os.`uid`
		WHERE oc.`firstname`='".$uname."' ";
			
			$rows=$this->db->query($sql);
			return $rows->row;
		}
		//获取当前推广员信息Byid
		public function getPromotionPersonById($uid){
		
		 $sql="SELECT opp.grade,opp.commission_ratio,oc.firstname,oc.customer_id,oc.`ip`,
		 IF(oc.`regtime` ,oc.`regtime`,oc.`date_added`) as add_time,oc.`logintime`,SUM(totalfee)AS totalfee FROM oc_promotion_personnel opp
		 LEFT JOIN oc_customer oc ON oc.`customer_id`=opp.`uid` 
		LEFT JOIN oc_sendorder os ON oc.`customer_id`=os.`uid`
		WHERE oc.`customer_id`='".$uid."' AND os.state IN (3,8)";
			
			$rows=$this->db->query($sql);
			return $rows->row;
		}	
		
		
		//解除关系
		public function remove_child($cid,$pid){
			$sql="update oc_promotion_grade set status=1 where sid='".$cid."' and pid='".$pid."'";
			$this->db->query($sql);
				
		}
		public function selectUid($uid){
			$sql="select id from oc_promotion_personnel where uid=".$uid;
			$row=$this->db->query($sql);
			return $row->row['id'];
		}
		
		public function selectid($id){
			$sql="select id from oc_withdraw_cash where id=".$id;
			$row=$this->db->query($sql);
			return $row->row['id'];
		}
		
		public function setPromotionPerson($uid,$grade,$commission_ratio){
			$sql="update oc_promotion_personnel set grade=".$grade." , commission_ratio=".$commission_ratio." where uid=".$uid;
	
			$this->db->query($sql);
		}
		public function editTixian($id,$data){
			$sql="update oc_withdraw_cash set status=".$data['status'].",remark='".$data['remark']."',serial_no=".$data['serial_no']." , Acceptance_state=".$data['Acceptance_state'].",eff_time=".time()." where id= ".$id." and uid=".$data['uid'];
		
			$this->db->query($sql);
		}
	}
?>