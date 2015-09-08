<?php
class ModelReportOrderForm extends Model {
	public function getOrderForm() {
		$query = $this->db->query ( "SELECT MIN(order_id) AS minDate, MAX(order_id) AS maxDate, SUM(total) AS totalPrice FROM `" . DB_PREFIX . "order` WHERE order_status_buy=1 and order_status_id>1" );
		$minax = $query->row;
		$query = $this->db->query ( "SELECT addtime FROM `" . DB_PREFIX . "order` WHERE order_id=" . $minax ['minDate'] );
		$minDate = $query->row ['addtime'];
		$query = $this->db->query ( "SELECT date_added FROM `" . DB_PREFIX . "order` WHERE order_id=" . $minax ['maxDate'] );
		$maxDate = $query->row ['date_added'];
		$date ['minDate'] = date ( 'Y-m-d', $minDate );
		$date ['maxDate'] = $maxDate;
		$date ['totalPrice'] = $minax ['totalPrice'];
		return $date;
	}
	/* public function getWayBill() {
		$query = $this->db->query ( "SELECT MIN(addtime) AS minDate, MAX(addtime) AS maxDate, SUM(totalfee) AS totalPrice FROM `" . DB_PREFIX . "sendorder` WHERE state > 1" );
		// var_dump($query->row);exit();
		return $query->row;
	} */
	public function getOrderFormByMonth($data) {
		for($i = 1; $i <= 12; $i ++) {
			$iN = $i + 1;
			$datas ['curM'] = $data . '-' . $i . '-01';
			$datas ['nextM'] = $data . '-' . $iN . '-01';
			$sql = "SELECT SUM(total) AS totalPrice FROM `" . DB_PREFIX . "order` WHERE total > 0 and order_status_buy = 1 and order_status_id > 1 and unix_timestamp(date_added) >= unix_timestamp('" . $datas ['curM'] . "') and unix_timestamp(date_added) < unix_timestamp('" . $datas ['nextM'] . "')";
			if ($i == 12) {
				$datas ['nextM'] = ($data + 1) . '-01-01';
				$sql = "SELECT SUM(total) AS totalPrice FROM `" . DB_PREFIX . "order` WHERE total > 0 and order_status_buy = 1 and order_status_id > 1 and unix_timestamp(date_added) >= unix_timestamp('" . $datas ['curM'] . "') and unix_timestamp(date_added) < unix_timestamp('" . $datas ['nextM'] . "')";
			}
			if($i == 1){
				//	echo $sql;
			}
			$query = $this->db->query ( $sql );
			$monthOrder [] = $query->row;
		}
		
		return $monthOrder;
	}
	public function getWayBillByMonth($data) {
		for($i = 1; $i <= 12; $i ++) {
			$iN = $i + 1;
			$datas ['curM'] = $data . '-' . $i . '-01' ;
			$datas ['nextM'] = $data . '-' . $iN . '-01' ;
			$sql = "SELECT SUM(totalfee) AS totalPrice FROM `" . DB_PREFIX . "sendorder` WHERE totalfee > 0 and state >= 1 and addtime >=unix_timestamp('" . $datas ['curM'] . "') and addtime < unix_timestamp('" . $datas ['nextM']."')";
			if ($i == 12) {
				$datas ['nextM'] = strtotime ( ($data + 1) . '-01-01' );
				$sql = "SELECT SUM(totalfee) AS totalPrice FROM `" . DB_PREFIX . "sendorder` WHERE totalfee > 0 and state >= 1 and addtime >= unix_timestamp('" . $datas ['curM'] . "') and addtime < unix_timestamp('" . $datas ['nextM']."')";
			}
	
			$query = $this->db->query ( $sql );
			$monthOrder [] = $query->row;
		}
		// var_dump($sql);
		return $monthOrder;
	}
}
?>