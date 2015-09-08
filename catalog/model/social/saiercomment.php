<?php
class ModelSocialSaiercomment extends Model {
    public function getShowComments() {
        $sql = "SELECT * FROM `" . DB_PREFIX . "message` where if_show=1";
        $query = $this->db->query($sql);
        return $query->rows;
    }
}
?>