<?php 

	class ModelSaleLink extends Model {
	
		public function addLink($data){
			 $sql="insert into ".DB_PREFIX."link set link_name='".$data['link_name']."',link_url='".$data['link_url']."',link_order='".$data['link_order']."',add_time=".time();
			 $this->db->query( $sql);
		}
		public function getTotalLinks(){
			$sql="select * from ".DB_PREFIX."link ";
			$query=$this->db->query( $sql);
			return $query->num_rows;
		}
		public function getTotalLink($data){
			$sql="select * from ".DB_PREFIX."link order by ".$data['order'].' '.$data['sort']." limit ".$data['start'].','.$data['limit'];
			$query=$this->db->query( $sql);
			return $query->rows;
		}
		public function getLink($id){
			$sql="select * from ".DB_PREFIX."link where id=".$id;
			$query=$this->db->query( $sql);
			return $query->row;
		}
		public function editLink($id,$post){
			$sql="update ".DB_PREFIX."link set link_name='".$post['link_name']."',link_url='".$post['link_url']."',link_order='".$post['link_order']."'  where id=".$id;
			$query=$this->db->query( $sql);
		}
		public function deleteLink($id){
			$sql="delete from ".DB_PREFIX."link where id=".$id;
			$query=$this->db->query( $sql);
		}
	}
?>