<?php
class ModelSocialSnsmanager extends Model {
    
    
    public function getCommentedtotal() {
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message AS m left join " .DB_PREFIX . "comment c ON m.message_id = c.message_id WHERE m.comments>0 AND c.type=0 AND m.customer_id = '" . $this->customer->getId() . "'");
        
        return $query->row['total'];

    }
    
    //给我评论
    public function  getCommented($data) {
         //联表查询  1 message_id message_text 2 message_flag |  3 firstname 4 comment_id comment_text 5 addtime   条件comments>0  customer_id=getId()  type=0 
        $sql = "SELECT m.message_id, m.message_text, m.message_flag ,c.firstname,c.face,c.comment_id,c.comment_text,c.addtime FROM " . DB_PREFIX . "message AS m left join " .DB_PREFIX . "comment c ON m.message_id = c.message_id WHERE m.comments>0 AND c.type=0 AND m.customer_id = '" . $this->customer->getId() . "'";
         
        if (isset($data['start']) || isset($data['limit'])) {
    		if ($data['start'] < 0) {
    			$data['start'] = 0;
    		}				
    
    		if ($data['limit'] < 1) {
    			$data['limit'] = 10;
    		}	
    
    		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	    }
        
        $query = $this->db->query($sql);
                                    
        return $query->rows;
           
    }
    
    //给我回复
    
    public function getReplytotal() {
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE type=1 AND reply_name = '" . addslashes(html_entity_decode($this->db->escape($this->customer->getFirstName()))) . "'");
        
        return $query->row['total'];    
        
    }
    
    public function getreply($data) {
        
        //联表查询 1 comment_id firstname face 
        $sql = "SELECT comment_id,firstname,face,comment_text,message_id,addtime FROM " . DB_PREFIX . "comment WHERE type=1 AND reply_name = '" . addslashes(html_entity_decode($this->db->escape($this->customer->getFirstName()))) . "'";
         
        if (isset($data['start']) || isset($data['limit'])) {
    		if ($data['start'] < 0) {
    			$data['start'] = 0;
    		}				
    
    		if ($data['limit'] < 1) {
    			$data['limit'] = 10;
    		}	
    
    		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	    }
        
        $query = $this->db->query($sql);
                                    
        return $query->rows;
        
        
    }
    
    public function getMessageById($message_id) {
        
        $query = $this->db->query("SELECT message_text ,message_flag,firstname,face FROM " . DB_PREFIX . "message WHERE message_id = '" . (int)$message_id . "'");
        
        return $query->row;  
        
    }
    
    //我发表的评论   
    public function getMycommenttotal() {
        
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "comment WHERE type=0 AND customer_id = '" . $this->customer->getId() . "'");
        
        return $query->row['total'];    
    }
    
    public function getMycomment($data) {
        
        $sql = "SELECT comment_id,comment_text,message_id,addtime FROM " . DB_PREFIX . "comment WHERE type=0 AND customer_id = '" . $this->customer->getId() . "'";
         
        if (isset($data['start']) || isset($data['limit'])) {
    		if ($data['start'] < 0) {
    			$data['start'] = 0;
    		}				
    
    		if ($data['limit'] < 1) {
    			$data['limit'] = 10;
    		}	
    
    		$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
	    }
        
        $query = $this->db->query($sql);
                                    
        return $query->rows;
        
    }
    
}
    
    
?>