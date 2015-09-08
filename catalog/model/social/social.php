<?php
class ModelSocialSocial extends Model {

        //发表普通消息
	public function addMessage($data) {
	   
	        $this->db->query("INSERT INTO " . DB_PREFIX . "message SET  customer_id = '" . (int)($data['customer_id']) . "' ,firstname= '" . $this->db->escape($data['firstname']) .  "' ,utype= '" . (int)$data['utype'] . "' ,face= '" . $this->db->escape($data['face']) .  "' ,theme_id= '" . $this->db->escape($data['theme_id']) . "' ,country = '" . $this->db->escape($data['country']) .  "', message_text = '" . $this->db->escape($data['message_text']) . 
	                   
	       "', message_flag = '" . (int)$data['message_flag'] . "', imgurl = '" . $this->db->escape($data['imgurl']) . "', videourl = '" . $this->db->escape($data['videourl']) . "', sync_sina= '" . (int)$data['sync_sina'] . "',approved = 1 , addtime = unix_timestamp(NOW()) " );
        
		$message_id = $this->db->getLastId();
        
        //更新达人数
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET sns_daren = (sns_daren + 1) WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		
		return $message_id;
	}
	
	//发表回复消息
	public function addComment($data) {
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "comment SET  message_id = '" . (int)($data['message_id']) . "' , customer_id = '" . (int)($data['customer_id']) . "' ,firstname= '" . $this->db->escape($data['firstname']) . "' ,face= '" . $this->db->escape($data['face']) . "', comment_text = '" . $this->db->escape($data['comment_text']) .  "', type = '" . 
		
		(int)($data['type']) . "', reply_name = '" . $this->db->escape($data['reply_name'])  . "', reply_id = '" . (int)($data['reply_id'])  . "',approved = 1 , addtime = unix_timestamp(NOW()) " );
        
		$comment_id = $this->db->getLastId();
        
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET sns_daren = (sns_daren + 1) WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		
		return $comment_id;
	
	}
	
    //记录登入社区首页的时间
    public function setSnstime() {
        
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET sns = unix_timestamp(NOW()) WHERE customer_id = '" . $this->customer->getId() . "'");
    }
    
    //获取登入社区首页的时间
    public function getSnstime() {
        
        $query = $this->db->query("SELECT sns AS time FROM " . DB_PREFIX . "customer WHERE customer_id = '" . $this->customer->getId() . "'");
        
        return $query->row['time'];
    }
    
    
	//更新消息点赞数  点赞人
	public function updatePoints($message_id) {
		
		$this->db->query("UPDATE  " . DB_PREFIX . "message SET points = (points + 1) , points_customer_id =  concat(points_customer_id , '|'  , '" .  $this->customer->getId() . "')  WHERE message_id = '" . (int)$message_id . "'");
	}
	
    //获取点赞人
    public function getPoints($message_id) {
        
        $query = $this->db->query("SELECT points_customer_id AS customer_array FROM " . DB_PREFIX . "message where message_id =  '" . (int)$message_id . "'");
	
		return $query->row['customer_array'];
    }
	
	//加更新消息评论数
	public function updateComments($message_id) {
	   
	      $this->db->query("UPDATE  " . DB_PREFIX . "message SET comments = (comments + 1)  WHERE message_id = '" . (int)$message_id . "'");
	    
	}
    //减更新消息评论数
     public function dupdateComments($message_id) {
	   
	      $this->db->query("UPDATE  " . DB_PREFIX . "message SET comments = (comments - 1)  WHERE message_id = '" . (int)$message_id . "'");
	    
	}

        
   //删除回复消息
   public function deleteComment($comment_id) {
   
	   $this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE comment_id = '" . (int)$comment_id . "'");
		
	}	
       
  //删除消息及属于其的回复消息
   public function deleteMessage($message_id) {
   
    	$this->db->query("DELETE FROM " . DB_PREFIX . "message WHERE message_id = '" . (int)$message_id . "'");
    	
        $this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE message_id = '" . (int)$message_id . "'");
    
        //更新达人数
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET sns_daren = (sns_daren - 1) WHERE customer_id = '" . (int)$this->customer->getId() . "'");    
    		
	}


       //获取所有的消息
       public function getMessage($data) {
	
	        $record_query = array();
        
            $sql = "SELECT  * FROM " . DB_PREFIX . "message WHERE approved = 1 AND";
            
            if(isset($data['search'])){
            	$sql .= " message_text like  '%".$data['search']."%'";
            }
            
            $sort_data = array(
                'addtime',
                'points',
                'comments'
             );
            
            if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
                $sql .= " ORDER BY " . $data['sort'] . "  desc" ;
            } else {
                $sql .= " ORDER BY zhiding desc,recomment desc,addtime desc";
            }
        
            if (isset($data['start']) || isset($data['limit'])) {
    			if ($data['start'] < 0) {
    				$data['start'] = 0;
    			}				
    
    			if ($data['limit'] < 1) {
    				$data['limit'] = 10;
    			}	
    
    			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
    	    }
        
        
	       $record_query = $this->db->query($sql);
		
           return $record_query->rows;
      }
      
      //获取指定id的消息
      public function getMessageByid($message_id) {
      
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "message WHERE message_id = '" . (int)$message_id . "'");
	
		return $query->row;
      }
	
      //获取指定消息的所有回复
      public function getComment($data) {
	
	        $record_query = array();
        
            $sql = "SELECT  * FROM " . DB_PREFIX . "comment WHERE approved = 1 AND message_id = '" . (int)$data['message_id'] . "' ORDER BY addtime asc" ;
        
            if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}				

			if ($data['limit'] < 1) {
				$data['limit'] = 10;
			}	

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}
        
        
	     $record_query = $this->db->query($sql);
		
          return $record_query->rows;
      }
	
      
      //获取消息的条数
      public function getTotalMessage() {
      
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message WHERE approved = 1");
	
		return $query->row['total'];
      }
      
      //获得消息更新的条数
      public function getTotalUpdate($time) {
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message where approved=1 AND customer_id != '". $this->customer->getId() . "' AND addtime > '" . $time . "'");
	
		return $query->row['total'];
        
      }
      
       
     //获取指定消息的回复条数
     public function getTotalComment($message_id) {
      
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE approved = 1 AND message_id = '" . (int)$message_id . "'");
	
		return $query->row['total'];
      } 
      
      //获取所有主题消息
      public function getTheme($flag=0) {
          if ($flag) {
            $query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "message_theme");
          } else {
      		  $query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "message_theme WHERE `flag` = '" . (int)$flag . "'");
	        }
            return $query->rows;
      	
      }
      
      //获取社区达人前十名
      public function getDaren() {
        
            $query = $this->db->query("SELECT firstname,face,utype,sns_daren  FROM " . DB_PREFIX . "customer ORDER BY sns_daren desc limit 10");
            	
            return $query->rows;
      }
	
      public function getBigImg($message_id) {
      	$query = $this->db->query("SELECT imgurl  FROM " . DB_PREFIX . "message WHERE message_id = '" . (int)$message_id . "'");
      	return $query->row['imgurl'];
      }
      

      //获取轮播图
      public function getLunboPics($type=0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "lunbo_pic WHERE `type` = '" . (int)$type . "' AND `flag`=0 ORDER BY `sort`");

        return $query->rows;
      }
}
?>