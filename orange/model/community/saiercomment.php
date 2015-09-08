﻿<?php

class ModelCommunitySaiercomment extends Model {

    public function getComments($data) {
        $sql = "SELECT * FROM `" . DB_PREFIX . "message` ";

        if (isset($data['uname']) && !is_null($data['uname'])) {
            $sql .=" WHERE firstname='" . addslashes(html_entity_decode($data['uname'])) . "'";
        } else {
            $sql .=" ";
        }

        if (isset($data['appr']) && !is_null($data['appr'])) {
            $sql .=" WHERE if_show=1";
        } else {
            $sql .=" ";
        }

        $sort_data = array(
            'message_id',
            'firstname',
            'addtime'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY addtime";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC";
        } else {
            $sql .= " ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int) $data['start'] . "," . (int) $data['limit'];
        }

        $query = $this->db->query($sql);
        return $query->rows;
    }


public function messageTotalName($uname) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message WHERE firstname='" . addslashes(html_entity_decode($uname)) . "'");
        return $query->row['total'];
    }

    public function totalComments() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message");
        return $query->row['total'];
    }

    public function showComments($state, $message_id) {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "message SET if_show=" . $state . " WHERE message_id=" . $message_id);
        if ($query){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function commentState($message_id) {
    $query2 = $this->db->query("SELECT if_show FROM " . DB_PREFIX . "message WHERE message_id=" . $message_id);
        return $query2->row['if_show'];
    }

    public function totalShowComments() {
    $query3 = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "message WHERE if_show=1");
        return $query3->row['total'];
    }

    //删除消息及属于其的回复消息
   public function deleteMessage($message_id) {
    	$this->db->query("DELETE FROM " . DB_PREFIX . "message WHERE message_id = '" . (int)$message_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "comment WHERE message_id = '" . (int)$message_id . "'");	
   }
  
   public function zhidingMessage($message_id) {
	    $now = time();
    	$query = $this->db->query("UPDATE " . DB_PREFIX . "message SET addtime='".$now."',zhiding=1 WHERE message_id=" . $message_id);
   }

public function cancelZhidingMessage($message_id) {
    	$query = $this->db->query("UPDATE " . DB_PREFIX . "message SET zhiding=0 WHERE message_id=" . $message_id);
   }

   public function deleteImages($message_id){
       $query2 = $this->db->query("SELECT imgurl FROM " . DB_PREFIX . "message WHERE message_id=" . $message_id);
       return $query2->row['imgurl'];
   } 

    public function messageState($message_id) {
        $query2 = $this->db->query("SELECT approved FROM " . DB_PREFIX . "message WHERE message_id=" . $message_id);
        return $query2->row['approved'];
    }
	
	 public function recState($message_id) {
        $query2 = $this->db->query("SELECT recomment FROM " . DB_PREFIX . "message WHERE message_id=" . $message_id);
        return $query2->row['recomment'];
    }

   public function showMessage($state, $message_id) {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "message SET approved=" . $state . " WHERE message_id=" . $message_id);
        if ($query){
            return 1;
        }else{
            return 0;
        }
    }

	public function showRecomment($state, $message_id) {
        $query = $this->db->query("UPDATE " . DB_PREFIX . "message SET recomment=" . $state . " WHERE message_id=" . $message_id);
        if ($query){
            return 1;
        }else{
            return 0;
        }
    }

    public function modifyCountry($message_id,$country){
         $query = $this->db->query("UPDATE " . DB_PREFIX . "message SET country='" . $country . "' WHERE message_id=" . $message_id);
         if ($query){
            return 1;
        }else{
            return 0;
        }
    }

}

?>