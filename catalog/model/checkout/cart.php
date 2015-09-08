<?php

class ModelCheckoutCart extends Model {

    public function updateCartProducts($carts_id, $content) {
        $this->db->query("UPDATE " . DB_PREFIX . "cart SET note = '" . $content . "' WHERE cart_id = '" . (int) $carts_id . "'");
    }

    public function addCart($data) {
        
        if(!array_key_exists("type", $data)){
            $data['type']=0;
        }
        
        $this->db->query("INSERT INTO `" . DB_PREFIX . "cart` SET num_iid = '" . $this->db->escape($data['num_iid']) .
                "', customer_id = '" . $this->db->escape($data['customer_id']) .
                "', firstname = '" . $this->db->escape($data['firstname']) .
                "', product_name = '" . $this->db->escape($data['product_name']) . "', product_url = '" . $this->db->escape($data['product_url']) . "', store_name = '" . $this->db->escape($data['store_name']) . "', store_url = '" . $this->db->escape($data['store_url']) .
                "', color = '" . $this->db->escape($data['color']) . "', size = '" . $this->db->escape($data['size']) .
                "', quantity = '" . $this->db->escape($data['quantity']) . "', note = '" . $this->db->escape($data['note']) .
                "', imgurl = '" . $this->db->escape($data['imgurl']) . "', price = '" . (float) $data['price'] .
                "', freight = '" . (float) $data['freight'] . "', addtime = NOW(),type=" . $data['type']);

        $cart_id = $this->db->getLastId();

        return $cart_id;
    }

    public function delCartbyId($id) {
        $customer_Id = intval($this->customer->getId());
        $this->db->query("DELETE  FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int) $id . "' AND customer_id={$customer_Id}");
    }

    public function addnote($data) {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "recommended_cart` SET customer_id = '" . (int) $data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', note = '" . $this->db->escape($data['note']) . "'");

        $note_id = $this->db->getLastId();

        return $note_id;
    }

    public function getnote($id) {

        $query = $this->db->query("SELECT note AS note FROM " . DB_PREFIX . "recommended_cart WHERE recommended_cart_id = '" . (int) $id . "'");

        return $query->row['note'];
    }

    public function updatenote($data) {

        $this->db->query("UPDATE " . DB_PREFIX . "recommended_cart SET note = '" . $this->db->escape($data['note']) . "' WHERE recommended_cart_id = '" . (int) $data['note_id'] . "'");
    }

    public function updatesnatch($data) {
        $this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int) $data['quantity'] . "' WHERE cart_id = '" . (int) $data['cart_id'] . "'");
    }

}

?>