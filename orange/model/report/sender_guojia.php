<?php 

//获取时间内国家运单排行
class ModelReportSenderGuojia extends Model {

	function getSenderOrders($start,$end){
			$start=strtotime($start);
			$end=strtotime($end);
			$sql="select country as total from oc_sendorder where addtime >= ".$start." AND addtime <".$end." 
				group by country order by total desc ";
			$query=$this->db->query($sql);
			return $query->num_rows;
	}
		
	function getSenderOrder($start,$end,$limit){
			$start=strtotime($start);
			$end=strtotime($end);
			$sql="select country,count(*) as total from oc_sendorder where addtime >= ".$start." AND addtime <".$end." 
				group by country order by total desc";
				if($limit){
					$sql.=$limit;
				}
			$query=$this->db->query($sql);
			return $query->rows;
	}	
	
}
?>