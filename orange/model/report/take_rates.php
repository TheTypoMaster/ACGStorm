<?php
class ModelReportTakeRates extends Model {
	public function getOrders($data = array()) {

	if (!empty($data['filter_group'])){
		$group = $data['filter_group'];
		$groupType='group';
	}else{
		$group = 'day';
		$groupType='rili';
	}

	$year=date('Y',strtotime($data['filter_date_start']));
	$sql="select customer_id from ".DB_PREFIX."customer where 1=1 ";
		//判断分组类型
		if ($groupType != 'rili'){
					switch($group){
						case 'year':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(),INTERVAL dayofyear(now())-1 DAY))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" . date('Y-m-d',time()). " 23:59:59')";
						break;
						case 'month':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(DATE_ADD(curdate(),interval -day(curdate())+1 day))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()) . " 23:59:59')";
						break;
						case 'week':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(subdate(curdate(),date_format(curdate(),'%w')-1))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()) . " 23:59:59')";
						break;
						case 'day':
								$sql .= " AND regtime >= UNIX_TIMESTAMP('" . date('Y-m-d'). "')";
								$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()) . " 23:59:59')";
						break;
					}
			} else {
				if (!empty($data['filter_date_start'])){
							$sql .= " AND regtime >= UNIX_TIMESTAMP('" . $this->db->escape($data['filter_date_start']) . "')";
				}
				if (!empty($data['filter_date_end'])){
					$sql .= " AND regtime <= UNIX_TIMESTAMP('" . $this->db->escape($data['filter_date_end']) . " 23:59:59')";
				}
				if(empty($data['filter_date_start'])){
					$sql .= " DATE_FORMAT(FROM_UNIXTIME(regtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d');";
				}
		}
		$query = $this->db->query($sql);
		$userIds=$query->rows;
	
		$struserId='';
		foreach($userIds as $key=>$userId){
			$struserId.=$userId['customer_id'].',';
		}
	
		$sql="select count(distinct o.customer_id )as orderNum ,";
			if ($groupType != 'rili'){
				switch($group) {
					case 'day':
						$sql.="DAY(o.date_added) as weektime,
						FROM_UNIXTIME(UNIX_TIMESTAMP(o.date_added),'%Y-%m-%d')as date_start,
						FROM_UNIXTIME(UNIX_TIMESTAMP(o.date_added),'%Y-%m-%d') as date_end ";
						break;
					case 'week':
						$sql.="WEEK(FROM_UNIXTIME(UNIX_TIMESTAMP(o.date_added),'%Y-%m-%d')) as weektime,
							subdate(curdate(),date_format(curdate(),'%w')-1)as date_start,
							subdate(curdate(),date_format(curdate(),'%w')-7) as date_end ";
						break;	
					case 'month':
						$sql.="MONTH(FROM_UNIXTIME(UNIX_TIMESTAMP(o.date_added),'%Y-%m-%d')) as weektime,
						DATE_ADD(curdate(),interval -day(curdate())+1 day)as date_start,
						LAST_DAY(now()) as date_end ";
						break;
					case 'year':
						$sql.="YEAR(FROM_UNIXTIME(UNIX_TIMESTAMP(o.date_added),'%Y-%m-%d')) as weektime,
							DATE_SUB(CURDATE(),INTERVAL dayofyear(now())-1 DAY)as date_start,
							NOW() as date_end ";
						break;	
				}
				$sql.=" from ".DB_PREFIX."order o  where  o.customer_id in(".rtrim($struserId,',').") AND o.order_status_id > '0'";
			
				switch($group) {
					case 'day':
						$sql .= " GROUP BY DAY(FROM_UNIXTIME(o.date_added,'%Y-%m-%d'))";
						break;
					case 'week':
						$sql .= " GROUP BY WEEK(FROM_UNIXTIME(o.date_added,'%Y-%m-%d'))";
						break;	
					case 'month':
						$sql .= " GROUP BY MONTH(FROM_UNIXTIME(o.date_added,'%Y-%m-%d'))";
						break;
					case 'year':
						$sql .= " GROUP BY YEAR(FROM_UNIXTIME(o.date_added,'%Y-%m-%d'))";
						break;									
				}
			$sql .= " ORDER BY FROM_UNIXTIME(o.date_added,'%Y-%m-%d') DESC";
	
		}else{
		
		$sql.=" '".$this->db->escape($data['filter_date_start'])."' as date_start ,
		'".$this->db->escape($data['filter_date_end'])."' as date_end ";
	
		$sql.=" from ".DB_PREFIX."order o  where o.customer_id in(".rtrim($struserId,',').") AND o.order_status_id > '0'";
			if(!empty($data['filter_date_start'])){
					$sql .= " AND o.date_added >= '" . $this->db->escape($data['filter_date_start']) . "'";
			}
			if (!empty($data['filter_date_end'])){
					$sql .= " AND o.date_added <=  '" . $this->db->escape($data['filter_date_end']) . " 23:59:59'";
			}
		}

		$orders = $this->db->query($sql);
		$orderList=$orders->rows;
		
		$sql="select count(customer_id) as RegisterNum, ";
		switch($group){
			case 'day':
				$sql.=" DAY(FROM_UNIXTIME(regtime,'%Y-%m-%d')) as registertime";
			break;
			case 'week':
				$sql.=" WEEK(FROM_UNIXTIME(regtime,'%Y-%m-%d')) as registertime";
			break;	
			case 'month':
				$sql.=" MONTH(FROM_UNIXTIME(regtime,'%Y-%m-%d')) as registertime";
			break;
			case 'year':
				$sql.=" YEAR(FROM_UNIXTIME(regtime,'%Y-%m-%d')) as registertime";
			break;	
		}
	
		$sql.=" from ".DB_PREFIX."customer where 1=1 ";

		if ($groupType != 'rili'){
					switch($group){
						case 'year':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(DATE_SUB(CURDATE(),INTERVAL dayofyear(now())-1 DAY))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()) . " 23:59:59')";
						break;
						case 'month':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(DATE_ADD(curdate(),interval -day(curdate())+1 day))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()). " 23:59:59')";
						break;
						case 'week':
							$sql .= " AND regtime >= UNIX_TIMESTAMP(subdate(curdate(),date_format(curdate(),'%w')-1))";
							$sql .= " AND regtime <= UNIX_TIMESTAMP('" .  date('Y-m-d',time()) . " 23:59:59')";
						break;
						case 'day':
								$sql .= " AND regtime >= UNIX_TIMESTAMP('" . date('Y-m-d'). "')";
								$sql .= " AND regtime <= UNIX_TIMESTAMP('" . date('Y-m-d',time()) . " 23:59:59')";
						break;
					}
						switch($group) {
							case 'day':
								$sql .= " GROUP BY DAY(FROM_UNIXTIME(regtime,'%Y-%m-%d'))";
								break;
							case 'week':
								$sql .= " GROUP BY WEEK(FROM_UNIXTIME(regtime,'%Y-%m-%d'))";
								break;	
							case 'month':
								$sql .= " GROUP BY MONTH(FROM_UNIXTIME(regtime,'%Y-%m-%d'))";
								break;
							case 'year':
								$sql .= " GROUP BY YEAR(FROM_UNIXTIME(regtime,'%Y-%m-%d'))";
								break;									
						}
					
			} else {
				if (!empty($data['filter_date_start'])){
							$sql .= " AND regtime >= UNIX_TIMESTAMP('" . $this->db->escape($data['filter_date_start']) . "')";
				}
				if (!empty($data['filter_date_end'])){
					$sql .= " AND regtime <= UNIX_TIMESTAMP('" . $this->db->escape($data['filter_date_end']) . " 23:59:59')";
				}
				if(empty($data['filter_date_start'])){
					$sql .= " DATE_FORMAT(FROM_UNIXTIME(regtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d');";
				}
		}
		
		$user = $this->db->query($sql);
		$userList=$user->rows;
	if ($groupType != 'rili'){
			foreach($orderList as $key=>$v){
				foreach($userList as $j){
					if($v['weektime']==$j['registertime']){
						$orderList[$key]['RegisterNum']=$j['RegisterNum'];
					}
				}
			}
		}else{
			$orderList[0]['RegisterNum']=$userList[0]['RegisterNum'];
		}
		
		return $orderList;
	}	
	
	public function getTotalOrders($data = array()) {
	
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT DAY(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			default:
			case 'week':
				$sql = "SELECT COUNT(DISTINCT WEEK(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;	
			case 'month':
				$sql = "SELECT COUNT(DISTINCT MONTH(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(date_added)) AS total FROM `" . DB_PREFIX . "order`";
				break;									
		}
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE order_status_id > '0'";
		}
				/*
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
*/
		$query = $this->db->query($sql);

		return $query->row['total'];	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
	}
	
	public function getTaxes($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'tax'"; 

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY ot.title, DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY ot.title, WEEK(o.date_added)";
				break;	
			case 'month':
				$sql .= " GROUP BY ot.title, MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY ot.title, YEAR(o.date_added)";
				break;									
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	
	
	public function getTotalTaxes($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM (SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'tax'";
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND order_status_id > '0'";
		}
				
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(o.date_added), ot.title";
				break;	
			case 'month':
				$sql .= " GROUP BY MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;									
		}
		
		$sql .= ") tmp";
		
		$query = $this->db->query($sql);

		return $query->row['total'];	
	}	
	
	public function getShipping($data = array()) {
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end, ot.title, SUM(ot.value) AS total, COUNT(o.order_id) AS `orders` FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'shipping'"; 

		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY ot.title, DAY(o.date_added)";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY ot.title, WEEK(o.date_added)";
				break;	
			case 'month':
				$sql .= " GROUP BY ot.title, MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY ot.title, YEAR(o.date_added)";
				break;									
		}
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}	
	
	public function getTotalShipping($data = array()) {
		$sql = "SELECT COUNT(*) AS total FROM (SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_total` ot LEFT JOIN `" . DB_PREFIX . "order` o ON (ot.order_id = o.order_id) WHERE ot.code = 'shipping'";
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND order_status_id > '0'";
		}
				
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'week';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY DAY(o.date_added), ot.title";
				break;
			default:
			case 'week':
				$sql .= " GROUP BY WEEK(o.date_added), ot.title";
				break;	
			case 'month':
				$sql .= " GROUP BY MONTH(o.date_added), ot.title";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added), ot.title";
				break;									
		}
		
		$sql .= ") tmp";
		
		$query = $this->db->query($sql);

		return $query->row['total'];	
	}		
}
?>