<?php 
//获取 代购 自助购 代寄 指定时间的数量	
	class ModelReportOrderDetail extends Model {

		public function getDesignatedTotal($filter_group,$order_status_buy,$filter_date_start,$filter_date_end){
		
			$sql="SELECT COUNT(*) AS total ";

			if($filter_group==1){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%m-%d') days ";
					
			}else if($filter_group==2){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%u') weeks ";
					
			}else if($filter_group==3){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%m') months ";
			}
			
				$sql.=" FROM oc_order WHERE order_status_id > 0  AND order_status_buy =".$order_status_buy ;
				
			if($filter_group==1){

					$sql.= " AND date_added > '2015-01-01'  GROUP BY days";
					
			}else if($filter_group==2){
			
					$sql.=" AND date_added > '2015-01-01'  GROUP BY weeks";
					
			}else if($filter_group==3){
			
					$sql.=" AND date_added > '2015-01-01'  GROUP BY months";
			}else{
				$sql.=" AND date_added > '".$filter_date_start."' AND date_added < '".$filter_date_end."'";
			}
				

			$row=$this->db->query($sql);
	
			return $row->num_rows;
		}
		
		
			public function getDesignatedInfo($filter_group,$order_status_buy,$filter_date_start,$filter_date_end,$limit){
		
			$sql="SELECT COUNT(*) AS total ";

			if($filter_group==1){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%m-%d') days ";
					
			}else if($filter_group==2){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%u') weeks ";
					
			}else if($filter_group==3){
			
					$sql.=" ,DATE_FORMAT(date_added,'%Y-%m') months ";
			}
			
				$sql.=" FROM oc_order WHERE order_status_id > 0  AND order_status_buy =".$order_status_buy ;
				
			if($filter_group==1){

					$sql.= " AND date_added > '2015-01-01'  GROUP BY days";
					
			}else if($filter_group==2){
			
					$sql.=" AND date_added > '2015-01-01'  GROUP BY weeks";
					
			}else if($filter_group==3){
			
					$sql.=" AND date_added > '2015-01-01'  GROUP BY months";
			}else{
				$sql.=" AND date_added > '".$filter_date_start."' AND date_added < '".$filter_date_end."'";
			}
				
				$sql.=$limit;
			$row=$this->db->query($sql);
	
			return $row->rows;
		}
		
		
	
	}
?>