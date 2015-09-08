<?php

class ModelOrderOrder extends Model {

    public function getosTotalOrder() {
        $query1 = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order WHERE customer_id = '" . (int) $this->customer->getId() . "' AND order_status_id = 2");
        $total1 = $query1->row['total'];
        $query2 = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "sendorder WHERE uid = '" . (int) $this->customer->getId() . "' AND state = 1");
        $total2 = $query2->row['total'];
        return ($total1 + $total2);
    }

    public function addRecMoney($id, $money) {
        $query = $this->db->query("SELECT money FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $id . "'");
        $currentMoney = $query->row['money'];
        $this->db->query("UPDATE " . DB_PREFIX . "customer SET money = " . ($currentMoney + $money) . " WHERE customer_id = '" . (int) $id . "'");
    }

    public function updatePcReq($order_id, $sign) {
        if ($sign == 1) {
            $this->db->query("UPDATE " . DB_PREFIX . "order SET preq= '" . $sign . "' WHERE order_id = '" . (int) $order_id . "'");
        }
        if ($sign == 2) {
            $this->db->query("UPDATE " . DB_PREFIX . "order SET creq= '" . $sign . "' WHERE order_id = '" . (int) $order_id . "'");
        }
    }

    public function updateRefund($order_id) {
        $this->db->query("UPDATE " . DB_PREFIX . "order SET order_status_id= 10 WHERE order_id = '" . (int) $order_id . "'");
    }

    public function updateOrderOnlyProducts($order_products_id, $content) {
        $this->db->query("UPDATE " . DB_PREFIX . "order_product SET note = '" . $content . "' WHERE order_product_id = '" . (int) $order_products_id . "'");
    }

    public function getSingalOrder($order_status_id) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order WHERE order_status_id = '" . (int) $order_status_id . "'AND customer_id='" . (int) $this->customer->getId() . "'";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getSingalOrderByOrderStatusBuy($order_status_id, $order_status_buy) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order WHERE order_status_buy=$order_status_buy AND order_status_id = '" . (int) $order_status_id . "'AND customer_id='" . (int) $this->customer->getId() . "'";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function addOrder($data) {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET invoice_prefix = '" . $this->db->escape($data['invoice_prefix']) . "', store_id = '" . (int) $data['store_id'] . "', store_name = '" . $this->db->escape($data['storename']) . "', store_url = '" . $this->db->escape($data['storeurl']) . "', customer_id = '" . (int) $data['customer_id'] . "', firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "', order_status_buy = '" . (int) $data['order_status_buy'] . "', order_status_id = '" . (int) $data['order_status_id'] . "', total = '" . (float) $data['total'] . "', order_shipping = '" . $this->db->escape($data['order_shipping']) . "', ip = '" . $this->db->escape($data['ip']) . "', forwarded_ip = '" . $this->db->escape($data['forwarded_ip']) . "', user_agent = '" . $this->db->escape($data['user_agent']) . "', accept_language = '" . $this->db->escape($data['accept_language']) . "', date_added = NOW(), date_modified = NOW()");
        $order_id = $this->db->getLastId();

        foreach ($data['products'] as $product) {

            $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', product_id = '" . (int) $product['product_id'] . "', name = '" . $this->db->escape($product['name']) . "', model = '" . $this->db->escape($product['model']) . "', quantity = '" . (int) $product['quantity'] . "', price = '" . (float) $product['price'] . "', total = '" . (float) $product['total'] . "', option_color = '" . $this->db->escape($product['color']) . "', option_size = '" . $this->db->escape($product['size']) . "', img = '" . $this->db->escape($product['img']) . "', producturl = '" . $this->db->escape($product['producturl']) . "', source = '" . $this->db->escape($product['source']) . "'");
        }

        return $order_id;
    }

    public function deleteOrder($order_id) {
        $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {
            $product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

            foreach ($product_query->rows as $product) {
                $this->db->query("UPDATE `" . DB_PREFIX . "product` SET quantity = (quantity + " . (int) $product['quantity'] . ") WHERE product_id = '" . (int) $product['product_id'] . "' AND subtract = '1'");

                $option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . (int) $product['order_product_id'] . "'");

                foreach ($option_query->rows as $option) {
                    $this->db->query("UPDATE " . DB_PREFIX . "product_option_value SET quantity = (quantity + " . (int) $product['quantity'] . ") WHERE product_option_value_id = '" . (int) $option['product_option_value_id'] . "' AND subtract = '1'");
                }
            }
        }

        $this->db->query("DELETE FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "order_fraud WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "customer_transaction WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "affiliate_transaction WHERE order_id = '" . (int) $order_id . "'");
        $this->db->query("DELETE `or`, ort FROM " . DB_PREFIX . "order_recurring `or`, " . DB_PREFIX . "order_recurring_transaction ort WHERE order_id = '" . (int) $order_id . "' AND ort.order_recurring_id = `or`.order_recurring_id");
    }

    public function getOrder($order_id) {
        $order_query = $this->db->query("SELECT *, (SELECT CONCAT(c.firstname, ' ', c.lastname) FROM " . DB_PREFIX . "customer c WHERE c.customer_id = o.customer_id) AS customer FROM `" . DB_PREFIX . "order` o WHERE o.order_id = '" . (int) $order_id . "'");

        if ($order_query->num_rows) {
            $reward = 0;

            $order_product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

            foreach ($order_product_query->rows as $product) {
                $reward += $product['reward'];
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['payment_country_id'] . "'");

            if ($country_query->num_rows) {
                $payment_iso_code_2 = $country_query->row['iso_code_2'];
                $payment_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $payment_iso_code_2 = '';
                $payment_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['payment_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $payment_zone_code = $zone_query->row['code'];
            } else {
                $payment_zone_code = '';
            }

            $country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int) $order_query->row['shipping_country_id'] . "'");

            if ($country_query->num_rows) {
                $shipping_iso_code_2 = $country_query->row['iso_code_2'];
                $shipping_iso_code_3 = $country_query->row['iso_code_3'];
            } else {
                $shipping_iso_code_2 = '';
                $shipping_iso_code_3 = '';
            }

            $zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int) $order_query->row['shipping_zone_id'] . "'");

            if ($zone_query->num_rows) {
                $shipping_zone_code = $zone_query->row['code'];
            } else {
                $shipping_zone_code = '';
            }

            if ($order_query->row['affiliate_id']) {
                $affiliate_id = $order_query->row['affiliate_id'];
            } else {
                $affiliate_id = 0;
            }

            $this->load->model('sale/affiliate');

            $affiliate_info = $this->model_sale_affiliate->getAffiliate($affiliate_id);

            if ($affiliate_info) {
                $affiliate_firstname = $affiliate_info['firstname'];
                $affiliate_lastname = $affiliate_info['lastname'];
            } else {
                $affiliate_firstname = '';
                $affiliate_lastname = '';
            }

            $this->load->model('localisation/language');

            $language_info = $this->model_localisation_language->getLanguage($order_query->row['language_id']);

            if ($language_info) {
                $language_code = $language_info['code'];
                $language_filename = $language_info['filename'];
                $language_directory = $language_info['directory'];
            } else {
                $language_code = '';
                $language_filename = '';
                $language_directory = '';
            }

            $amazonOrderId = '';

            if ($this->config->get('amazon_status') == 1) {
                $amazon_query = $this->db->query("
					SELECT `amazon_order_id`
					FROM `" . DB_PREFIX . "amazon_order`
					WHERE `order_id` = " . (int) $order_query->row['order_id'] . "
					LIMIT 1")->row;

                if (isset($amazon_query['amazon_order_id']) && !empty($amazon_query['amazon_order_id'])) {
                    $amazonOrderId = $amazon_query['amazon_order_id'];
                }
            }

            if ($this->config->get('amazonus_status') == 1) {
                $amazon_query = $this->db->query("
						SELECT `amazonus_order_id`
						FROM `" . DB_PREFIX . "amazonus_order`
						WHERE `order_id` = " . (int) $order_query->row['order_id'] . "
						LIMIT 1")->row;

                if (isset($amazon_query['amazonus_order_id']) && !empty($amazon_query['amazonus_order_id'])) {
                    $amazonOrderId = $amazon_query['amazonus_order_id'];
                }
            }

            return array(
                'amazon_order_id' => $amazonOrderId,
                'order_id' => $order_query->row['order_id'],
                'invoice_no' => $order_query->row['invoice_no'],
                'invoice_prefix' => $order_query->row['invoice_prefix'],
                'store_id' => $order_query->row['store_id'],
                'store_name' => $order_query->row['store_name'],
                'store_url' => $order_query->row['store_url'],
                'customer_id' => $order_query->row['customer_id'],
                'customer' => $order_query->row['customer'],
                'customer_group_id' => $order_query->row['customer_group_id'],
                'firstname' => $order_query->row['firstname'],
                'lastname' => $order_query->row['lastname'],
                'telephone' => $order_query->row['telephone'],
                'fax' => $order_query->row['fax'],
                'email' => $order_query->row['email'],
                'payment_zone_code' => $payment_zone_code,
                'payment_country_id' => $order_query->row['payment_country_id'],
                'payment_country' => $order_query->row['payment_country'],
                'payment_iso_code_2' => $payment_iso_code_2,
                'payment_iso_code_3' => $payment_iso_code_3,
                'payment_address_format' => $order_query->row['payment_address_format'],
                'payment_method' => $order_query->row['payment_method'],
                'payment_code' => $order_query->row['payment_code'],
                'shipping_firstname' => $order_query->row['shipping_firstname'],
                'shipping_lastname' => $order_query->row['shipping_lastname'],
                'shipping_company' => $order_query->row['shipping_company'],
                'shipping_address_1' => $order_query->row['shipping_address_1'],
                'shipping_address_2' => $order_query->row['shipping_address_2'],
                'shipping_postcode' => $order_query->row['shipping_postcode'],
                'shipping_city' => $order_query->row['shipping_city'],
                'shipping_zone_id' => $order_query->row['shipping_zone_id'],
                'shipping_zone' => $order_query->row['shipping_zone'],
                'shipping_zone_code' => $shipping_zone_code,
                'shipping_country_id' => $order_query->row['shipping_country_id'],
                'shipping_country' => $order_query->row['shipping_country'],
                'shipping_iso_code_2' => $shipping_iso_code_2,
                'shipping_iso_code_3' => $shipping_iso_code_3,
                'shipping_address_format' => $order_query->row['shipping_address_format'],
                'shipping_method' => $order_query->row['shipping_method'],
                'shipping_code' => $order_query->row['shipping_code'],
                'comment' => $order_query->row['comment'],
                'total' => $order_query->row['total'],
                'reward' => $reward,
                'order_status_id' => $order_query->row['order_status_id'],
                'affiliate_id' => $order_query->row['affiliate_id'],
                'affiliate_firstname' => $affiliate_firstname,
                'affiliate_lastname' => $affiliate_lastname,
                'commission' => $order_query->row['commission'],
                'language_id' => $order_query->row['language_id'],
                'language_code' => $language_code,
                'language_filename' => $language_filename,
                'language_directory' => $language_directory,
                'currency_id' => $order_query->row['currency_id'],
                'currency_code' => $order_query->row['currency_code'],
                'currency_value' => $order_query->row['currency_value'],
                'ip' => $order_query->row['ip'],
                'forwarded_ip' => $order_query->row['forwarded_ip'],
                'user_agent' => $order_query->row['user_agent'],
                'accept_language' => $order_query->row['accept_language'],
                'date_added' => $order_query->row['date_added'],
                'date_modified' => $order_query->row['date_modified'],
                'order_shipping' => $order_query->row['order_shipping'],
                'order_status_buy' => $order_query->row['order_status_buy']
            );
        } else {
            return false;
        }
    }

    public function getOrders($data = array()) {
        $order_status_name = $this->config->get('config_language_id') == 2 ? 'name' : 'name_en';
        if (empty($data['sk'])) {
            $sql = "SELECT o.order_id,o.preq ,o.creq ,o.order_shipping, o.language_id,o.store_url,o.store_name, o.order_status_id, o.order_weight,o.order_kaudi,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os." . $order_status_name . " FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = 2) AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o";
            if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
                $sql .= " WHERE o.order_status_id = '" . (int) $data['order_status_id'] . "'";
            } else {
                $sql .= " WHERE o.order_status_id > '0'";
            }
        } else {
            $sql = "SELECT o.order_id,o.preq ,o.creq ,o.order_shipping, o.language_id,o.store_url,o.store_name, o.order_status_id, o.order_weight,o.order_kaudi,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os." . $order_status_name . " FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = 2) AS status, o.total, o.currency_code, o.currency_value, o.date_added, o.date_modified FROM `" . DB_PREFIX . "order` o , `" . DB_PREFIX . "order_product` op WHERE op.order_id = o.order_id AND op.name LIKE '%{$data['sk']}%'";
            if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
                $sql .= " AND o.order_status_id = '" . (int) $data['order_status_id'] . "'";
            } else {
                $sql .= " AND o.order_status_id > '0'";
            }
        }
        if (!empty($data['order_id'])) {
            $sql .= " AND o.order_id = '" . (int) $data['order_id'] . "'";
        }


        if (!empty($data['username_id'])) {
            $sql .= " AND o.customer_id = '" . (int) $data['username_id'] . "'";
        }

        if (!empty($data['order_status_buy'])) {
            $sql .= " AND o.order_status_buy = '" . (int) $data['order_status_buy'] . "'";
        }


        if (!empty($data['yundan_or'])) {

            $sql .= " AND o.yundan_or = '" . (int) $data['yundan_or'] . "'";
        }




        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(o.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND o.total = '" . (float) $data['filter_total'] . "'";
        }


        if (!empty($data['startTime']) && !empty($data['endTime'])) {
            $sql .= " AND unix_timestamp(o.date_added) > " . $data['startTime'] . " AND unix_timestamp(o.date_added) < " . $data['endTime'];
        }

        $sort_data = array(
            'o.order_id',
            'customer',
            'status',
            'o.date_added',
            'o.date_modified',
            'o.order_kaudi',
            'o.total'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            $sql .= " ORDER BY " . $data['sort'];
        } else {
            $sql .= " ORDER BY o.order_id";
        }

        if (isset($data['order']) && ($data['order'] == 'ASC')) {
            $sql .= " ASC";
        } else {
            $sql .= " DESC";
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

    public function getSearchForTimeTotalOrder($st, $et) {
        $sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order WHERE unix_timestamp(date_added) > '" . $st . "' AND unix_timestamp(date_added) < '" . $et . "' AND customer_id='" . (int) $this->customer->getId() . "' AND order_status_buy = 1";
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function getOrderProducts($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    public function getOrderByid($order_id) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order WHERE order_id = '" . (int) $order_id . "'");

        return $query->row;
    }

    public function getOrderOptions($order_id, $order_product_id) {
        $query = $this->db->query("SELECT oo.* FROM " . DB_PREFIX . "order_option AS oo LEFT JOIN " . DB_PREFIX . "product_option po USING(product_option_id) LEFT JOIN `" . DB_PREFIX . "option` o USING(option_id) WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . (int) $order_product_id . "' ORDER BY o.sort_order");

        return $query->rows;
    }

    public function getOrderDownloads($order_id, $order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_download WHERE order_id = '" . (int) $order_id . "' AND order_product_id = '" . (int) $order_product_id . "'");

        return $query->rows;
    }

    public function getOrderVouchers($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_voucher WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    public function getOrderVoucherByVoucherId($voucher_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE voucher_id = '" . (int) $voucher_id . "'");

        return $query->row;
    }

    public function getOrderTotals($order_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int) $order_id . "' ORDER BY sort_order");

        return $query->rows;
    }

    public function getTotalOrders($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order`";

        if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
            $sql .= " WHERE order_status_id = '" . (int) $data['order_status_id'] . "'";
        } else {
            $sql .= " WHERE order_status_id > '0'";
        }

        if (!empty($data['order_status_buy'])) {
            $sql .= " AND order_status_buy = '" . (int) $data['order_status_buy'] . "'";
        }

        if (!empty($data['username_id'])) {
            $sql .= " AND customer_id = '" . (int) $data['username_id'] . "'";
        }


        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND total = '" . (float) $data['filter_total'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getYundanTotalOrders($data = array()) {
        $sql = "SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "sendorder`";

        if (isset($data['order_status_id']) && !is_null($data['order_status_id'])) {
            $sql .= " WHERE state = '" . (int) $data['order_status_id'] . "'";
        } else {
            $sql .= " WHERE state >= '0'";
        }

        if (!empty($data['username_id'])) {
            $sql .= " AND uid = '" . (int) $data['username_id'] . "'";
        }


        if (!empty($data['filter_date_added'])) {
            $sql .= " AND DATE(date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
        }

        if (!empty($data['filter_date_modified'])) {
            $sql .= " AND DATE(o.date_modified) = DATE('" . $this->db->escape($data['filter_date_modified']) . "')";
        }

        if (!empty($data['filter_total'])) {
            $sql .= " AND total = '" . (float) $data['filter_total'] . "'";
        }

        $query = $this->db->query($sql);

        return $query->row['total'];
    }

    public function getTotalOrdersByStoreId($store_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE store_id = '" . (int) $store_id . "'");

        return $query->row['total'];
    }

    public function getTotalOrdersByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id = '" . (int) $order_status_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByLanguageId($language_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE language_id = '" . (int) $language_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalOrdersByCurrencyId($currency_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` WHERE currency_id = '" . (int) $currency_id . "' AND order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalSales() {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0'");

        return $query->row['total'];
    }

    public function getTotalBySelect($order_array) {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_id IN (" . $order_array . ")");

        return $query->row['total'];
    }

    public function getTotalSalesByYear($year) {
        $query = $this->db->query("SELECT SUM(total) AS total FROM `" . DB_PREFIX . "order` WHERE order_status_id > '0' AND YEAR(date_added) = '" . (int) $year . "'");

        return $query->row['total'];
    }

    public function createInvoiceNo($order_id) {
        $order_info = $this->getOrder($order_id);

        if ($order_info && !$order_info['invoice_no']) {
            $query = $this->db->query("SELECT MAX(invoice_no) AS invoice_no FROM `" . DB_PREFIX . "order` WHERE invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "'");

            if ($query->row['invoice_no']) {
                $invoice_no = $query->row['invoice_no'] + 1;
            } else {
                $invoice_no = 1;
            }

            $this->db->query("UPDATE `" . DB_PREFIX . "order` SET invoice_no = '" . (int) $invoice_no . "', invoice_prefix = '" . $this->db->escape($order_info['invoice_prefix']) . "' WHERE order_id = '" . (int) $order_id . "'");

            return $order_info['invoice_prefix'] . $invoice_no;
        }
    }

    public function addOrderHistory($order_id, $data) {
        $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = '" . (int) $data['order_status_id'] . "', date_modified = NOW() WHERE order_id = '" . (int) $order_id . "'");

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_history SET order_id = '" . (int) $order_id . "', order_status_id = '" . (int) $data['order_status_id'] . "', notify = '" . (isset($data['notify']) ? (int) $data['notify'] : 0) . "', comment = '" . $this->db->escape(strip_tags($data['comment'])) . "', date_added = NOW()");

        $order_info = $this->getOrder($order_id);

        // Send out any gift voucher mails
        if ($this->config->get('config_complete_status_id') == $data['order_status_id']) {
            $this->load->model('sale/voucher');

            $results = $this->getOrderVouchers($order_id);

            foreach ($results as $result) {
                $this->model_sale_voucher->sendVoucher($result['voucher_id']);
            }
        }

        if ($data['notify']) {
            $language = new Language($order_info['language_directory']);
            $language->load($order_info['language_filename']);
            $language->load('mail/order');

            $subject = sprintf($language->get('text_subject'), $order_info['store_name'], $order_id);

            $message = $language->get('text_order') . ' ' . $order_id . "\n";
            $message .= $language->get('text_date_added') . ' ' . date($language->get('date_format_short'), strtotime($order_info['date_added'])) . "\n\n";

            $order_status_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_status WHERE order_status_id = '" . (int) $data['order_status_id'] . "' AND language_id = '" . (int) $order_info['language_id'] . "'");

            if ($order_status_query->num_rows) {
                $message .= $language->get('text_order_status') . "\n";
                $message .= $order_status_query->row['name'] . "\n\n";
            }

            if ($order_info['customer_id']) {
                $message .= $language->get('text_link') . "\n";
                $message .= html_entity_decode($order_info['store_url'] . 'index.php?route=account/order/info&order_id=' . $order_id, ENT_QUOTES, 'UTF-8') . "\n\n";
            }

            if ($data['comment']) {
                $message .= $language->get('text_comment') . "\n\n";
                $message .= strip_tags(html_entity_decode($data['comment'], ENT_QUOTES, 'UTF-8')) . "\n\n";
            }

            $message .= $language->get('text_footer');

            $mail = new Mail();
            $mail->protocol = $this->config->get('config_mail_protocol');
            $mail->parameter = $this->config->get('config_mail_parameter');
            $mail->hostname = $this->config->get('config_smtp_host');
            $mail->username = $this->config->get('config_smtp_username');
            $mail->password = $this->config->get('config_smtp_password');
            $mail->port = $this->config->get('config_smtp_port');
            $mail->timeout = $this->config->get('config_smtp_timeout');
            $mail->setTo($order_info['email']);
            $mail->setFrom($this->config->get('config_email'));
            $mail->setSender($order_info['store_name']);
            $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
            $mail->setText(html_entity_decode($message, ENT_QUOTES, 'UTF-8'));
            $mail->send();
        }

        $this->load->model('payment/amazon_checkout');
        $this->model_payment_amazon_checkout->orderStatusChange($order_id, $data);
    }

    public function getOrderHistories($order_id, $start = 0, $limit = 10) {
        $order_status_name = $this->config->get('config_language_id') == 2 ? 'name' : 'name_en';
        if ($start < 0) {
            $start = 0;
        }

        if ($limit < 1) {
            $limit = 10;
        }

        $query = $this->db->query("SELECT oh.date_added, os." . $order_status_name . " AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int) $order_id . "' AND os.language_id = 2 ORDER BY oh.date_added ASC LIMIT " . (int) $start . "," . (int) $limit);

        return $query->rows;
    }

    public function getTotalOrderHistories($order_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_id = '" . (int) $order_id . "'");

        return $query->row['total'];
    }

    public function getTotalOrderHistoriesByOrderStatusId($order_status_id) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_history WHERE order_status_id = '" . (int) $order_status_id . "'");

        return $query->row['total'];
    }

    public function getEmailsByProductsOrdered($products, $start, $end) {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int) $product_id . "'";
        }

        $query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0' LIMIT " . (int) $start . "," . (int) $end);

        return $query->rows;
    }

    public function getTotalEmailsByProductsOrdered($products) {
        $implode = array();

        foreach ($products as $product_id) {
            $implode[] = "op.product_id = '" . (int) $product_id . "'";
        }

        $query = $this->db->query("SELECT DISTINCT email FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE (" . implode(" OR ", $implode) . ") AND o.order_status_id <> '0'");

        return $query->row['total'];
    }

    public function ajax_getorder_stues($order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query->rows;
    }

    public function ajax_update_orderstues($order_product_id, $colorid) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET order_sensitive =  $colorid   WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query->rows;
    }

    public function ajax_update_nonameplate($order_product_id, $colorid) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET order_nameplate = $colorid  WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query->rows;
    }

    public function order_updat($order_id, $order_status_id) {
        if (is_array($order_id)) {
            foreach ($order_id as $id) {
                $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = $order_status_id  WHERE order_id = '" . (int) $id . "'");
            }
        } else {
            $query = $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id = $order_status_id  WHERE order_id = '" . (int) $order_id . "'");
        }

        return $query;
    }

    public function ajax_update_rethrowing($order_product_id, $colorid) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET order_parabolic = $colorid   WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query->rows;
    }

    public function ajax_update_tracking($order_product_id, $tracking) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET tracking_number = '" . $tracking . "' WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query;
    }

    public function express() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "express ");
        return $query->rows;
    }

    public function express_chage($order_product_id, $Adult_Value) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET express = $Adult_Value   WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query;
    }

    public function weight_chage($order_product_id, $Adult_Value) {
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product` SET weight = $Adult_Value   WHERE order_product_id = '" . (int) $order_product_id . "'");
        return $query;
    }

    public function get_Order_Products($order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_product_id = '" . (int) $order_product_id . "'");

        return $query->rows;
    }

    public function editOrder2($order_product_id, $data) {
        $total = $data['order_commodity_price'] * $data['order_update_qty'];
        $tracking = $data['tracking_remark'];
        $express_change = $data['express_change'];
        $name = $data['order_commodity_name'];
        $weight = $data['weight'];
        $cul = $data['order_commodity_address'];
        $order_id = $data['order_id'];
        $seller = $data['order_update_seller'];
        $kuaidi_no = $data['kuaidi_no'];
        $order_express_price = $data['order_express_price'];
        $order_change = $data['order_change'];

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product`  SET  quantity = " . (int) $data['order_update_qty'] . ",price = " . $data['order_commodity_price'] . "  ,name = '" . $name . "'  ,total = " . (int) $total . ",express = '" . $express_change . "'   ,tracking_number = '" . $tracking . "' ,weight = '" . $weight . "'      ,kuaidi_no = '" . $kuaidi_no . "'                  WHERE  order_product_id = " . (int) $order_product_id);

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  store_url = '" . $cul . "' , store_name = '" . $seller . "'  , order_shipping = '" . $order_express_price . "'   , order_status_id = '" . $order_change . "'                     WHERE  order_id = " . (int) $order_id);
    }

    public function get_order_list($order_product_id) {
        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE   op.order_product_id = $order_product_id");
        return $query;
    }

    public function sun_product_total($order_id) {
        $query = $this->db->query("SELECT SUM(total) AS ordertotal FROM  " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");
        return $query->rows;
    }

    public function cul_home_Products($order_product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product WHERE product_id = '" . (int) $order_product_id . "'");
        return $query->rows;
    }

    public function getOrderStatuses($data = array()) {
        if ($data) {
            if ($this->session->data['language'] == 'en')
                $sql = "SELECT order_status_id, name_en AS name, name AS sort FROM " . DB_PREFIX . "order_status ORDER BY sort";
            else
                $sql = "SELECT * FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int) $this->config->get('config_language_id') . "'";
            $sql .= " ORDER BY name";
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
        } else {
            $order_status_data = $this->cache->get('order_status.' . (int) $this->config->get('config_language_id'));
            if (!$order_status_data) {
                if ($this->session->data['language'] == 'en')
                    $query = $this->db->query("SELECT order_status_id, name_en AS name, name AS sort FROM " . DB_PREFIX . "order_status ORDER BY sort");
                else
                    $query = $this->db->query("SELECT order_status_id, name FROM " . DB_PREFIX . "order_status WHERE language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY name");
                $order_status_data = $query->rows;
                $this->cache->set('order_status.' . (int) $this->config->get('config_language_id'), $order_status_data);
            }
            return $order_status_data;
        }
    }

    public function getYundanOrderStatuses() {
        $query = $this->db->query("SELECT id, name FROM " . DB_PREFIX . "sendorder_status ORDER BY name");
        $order_status_data = $query->rows;
        return $order_status_data;
    }

    public function insert_daiji_order($insert_data) {


        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $insert_data['username_id'] . "'");

        $user = $query->row;



        $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET order_status_buy = '" . $insert_data['order_status_buy'] . "', customer_id = '" . (int) $insert_data['username_id'] . "', firstname = '" . $this->db->escape($user['firstname']) . "', lastname = '" . $this->db->escape($user['lastname']) . "', email = '" . $this->db->escape($user['email']) . "',   order_status_id = '" . $insert_data['order_status_id'] . "', language_id = '" . (int) $this->config->get('config_language_id') . "', date_added = NOW(), date_modified = '0',addtime='" . time() . "'");

        $order_id = $this->db->getLastId();

        $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', name = '" . $this->db->escape($insert_data['order_daiji_name']) . "', kuaidi_no = '" . $this->db->escape($insert_data['express_number']) . "',express = '" . $this->db->escape($insert_data['expresses']) . "', note = '" . $insert_data['order_Parcel'] . "' ,addtime='" . time() . "'");
    }

    public function insert_zizhu($data_product) {

        $query = $this->db->query("INSERT INTO " . DB_PREFIX . "taobao_order SET  Shop = '" . $this->db->escape($data_product['seller']) . "', custom_id = '" . (int) $data_product['custom_id'] . "'");

        $taobao_id = $this->db->getLastId();

        $query2 = $this->db->query("INSERT INTO " . DB_PREFIX . "taobao_product SET  img = '" . $this->db->escape($data_product['img']) . "' ,remark = '" . $this->db->escape($data_product['remark']) . "' ,qty = '" . (int) $data_product['qty'] . "',taobao_order_id = " . (int) $taobao_id . ",custom_id = '" . (int) $data_product['custom_id'] . "',date_add = '" . (int) $data_product['time'] . "',product_name = '" . $this->db->escape($data_product['heading_title']) . "',price = '" . $this->db->escape($data_product['price']) . "',size = '" . $this->db->escape($data_product['size']) . "',color = '" . $this->db->escape($data_product['color']) . "',store_name = '" . $this->db->escape($data_product['storename']) . "',store_url = '" . $this->db->escape($data_product['storeurl']) . "',  yunfei = '" . $this->db->escape($data_product['searchfreight']) . "', producturl= '" . $this->db->escape($data_product['producturl']) . "'");
        $taobao_product_id = $this->db->getLastId();
        return $taobao_product_id;
    }

    public function getTotalOrder_taobao($username_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "taobao_order WHERE custom_id = '" . (int) $username_id . "'   ");
        return $query->rows;
    }

    public function getTotalproduct_taobao($product_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "taobao_product WHERE taobao_order_id = '" . (int) $product_id . "'   ");
        return $query->rows;
    }

    public function dede_taobao_product($id) {

        $query = $this->db->query("SELECT taobao_order_id FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int) $id . "'   ");
        $rest = $query->rows['taobao_order_id'];

        if (isset($rest)) {
            $taobao_id = $rest;

            $query = $this->db->query("SELECT  count(*) as  a FROM " . DB_PREFIX . "taobao_product WHERE taobao_order_id = '" . (int) $taobao_id . "'   ");
            $count = $query->rows;
            if ($count[0]['a'] == 1) {

                $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int) $id . "'");
                $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_order WHERE id = '" . (int) $taobao_id . "'");
            } else if ($count[0]['a'] > 1) {

                $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int) $id . "'");
            }
        }
    }

    public function total_taobao() {
        $query = $this->db->query("SELECT  count(*) as  a FROM " . DB_PREFIX . "taobao_order");
        return $query->rows;
    }

    public function get_selfproduct_total() {

        if ($this->customer->getId()) {
            $query = $this->db->query("SELECT  count(*) as total  FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int) $this->customer->getId() . "'");
            return $query->row['total'];
        } else if (!$this->customer->getId() && !empty($_COOKIE['taobao_id'])) {
            $query = $this->db->query("SELECT  count(*)  as total FROM " . DB_PREFIX . "taobao_product WHERE id in(" . $_COOKIE['taobao_id'] . ")");
            return $query->row['total'];
        } else {
            return 0;
        }
    }

    public function get_selfproduct() {
        if ($this->customer->getId()) {
            $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int) $this->customer->getId() . "' order by id desc ");
            return $query->rows;
        } else if (!$this->customer->getId() && !empty($_COOKIE['taobao_id'])) {

            $query = $this->db->query("SELECT  * FROM " . DB_PREFIX . "taobao_product WHERE id in(" . $_COOKIE['taobao_id'] . ") order by id desc ");

            return $query->rows;
        } else {
            return '';
        }
    }

    public function del_selfproduct() {

        $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int) $this->customer->getId() . "'");
    }

    public function del_one_selfproduct($data) {
        $query = $this->db->query("SELECT taobao_order_id  FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int) $data['id'] . "'");
        $taobao_id = $query->row['taobao_order_id'];
        $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int) $data['id'] . "'");
        $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_order WHERE id = '" . (int) $taobao_id . "'");
        //var_dump("DELETE FROM " . DB_PREFIX . "taobao_product WHERE id = '" . (int)$data['id'] . "'");
    }

    public function order_kuaidgongsi($id) {
        $query = $this->db->query("SELECT  *  FROM " . DB_PREFIX . "express WHERE name_en = '" . $id . "'   ");
        $kuaid = $query->rows;

        if (isset($kuaid[0])) {
            return $kuaid[0];
        }
    }

    public function update_kuaidi($kaidi_data) {
        $order_kaudi = $kaidi_data['order_kaudi'];
        $order_kuaidi_no = $kaidi_data['order_kuaidi_no'];
        $order_id = $kaidi_data['order_id'];
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  order_kaudi = '" . $order_kaudi . "' , order_kuaidi_no = '" . $order_kuaidi_no . "'     WHERE  order_id = " . (int) $order_id);
    }

//补填快递号
    public function update_kuaidi2($kaidi_data) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  order_status_id = 4 WHERE  order_id = " . (int) $kaidi_data['order_id']);
        $query = $this->db->query("UPDATE `" . DB_PREFIX . "order_product`   SET  express = '" . $kaidi_data['order_kaudi'] . "' , kuaidi_no = '" . $kaidi_data['order_kuaidi_no'] . "'     WHERE  order_id = " . (int) $kaidi_data['order_id']);
    }

    public function insert_taobao_order($username_id) {

        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "taobao_order WHERE custom_id = '" . (int) $username_id . "'   ");
        $sqls = $query->rows;

        for ($i = 0; $i < count($sqls); $i++) {

            $taobao_order_id = $sqls[$i]['id'];

            $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $sqls[$i]['custom_id'] . "'");

            $user = $query->row;

            $this->db->query("INSERT INTO `" . DB_PREFIX . "order` SET order_status_buy = 2, customer_id = '" . (int) $sqls[$i]['custom_id'] . "', customer_group_id = '" . (int) $user['customer_group_id'] . "', store_name = '" . $this->db->escape($user['storename']) . "', store_url = '" . $this->db->escape($user['storeurl']) . "', firstname = '" . $this->db->escape($user['firstname']) . "', lastname = '" . $this->db->escape($user['lastname']) . "', email = '" . $this->db->escape($user['email']) . "', telephone = '" . $this->db->escape($user['telephone']) . "',   order_status_id = 1, language_id = '" . (int) $this->config->get('config_language_id') . "', date_added = NOW(), date_modified = NOW()");

            $order_id = $this->db->getLastId();

            $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "taobao_product WHERE taobao_order_id = '" . (int) $taobao_order_id . "'   ");
            $sqls2 = $query2->rows;



            for ($c = 0; $c < count($sqls2); $c++) {
                $total = $sqls2[$c]['price'] * $sqls2[$c]['qty'];

                $this->db->query("INSERT INTO " . DB_PREFIX . "order_product SET order_id = '" . (int) $order_id . "', total = $total, name = '" . $this->db->escape($sqls2[$c]['product_name']) . "',note = '" . $this->db->escape($sqls2[$c]['remark']) . "',option_color = '" . $sqls2[$c]['color'] . "',option_size = '" . $this->db->escape($sqls2[$c]['size']) . "',img = '" . $this->db->escape($sqls2[$c]['img']) . "',quantity = '" . $sqls2[$c]['qty'] . "', price = '" . $sqls2[$c]['price'] . "'");
            }

            $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_product WHERE custom_id = '" . (int) $sqls[$i]['custom_id'] . "'");
            $this->db->query("DELETE FROM " . DB_PREFIX . "taobao_order WHERE custom_id = '" . (int) $sqls[$i]['custom_id'] . "'");
        }
    }

    public function getSignFlag($customer) {
        $signHistory = $this->db->query("SELECT qiandao FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer . "' order by qiandao DESC limit 1");
        return $signHistory->row;
    }

    public function qiandao($customer, $score, $uname) {
        $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer . "'   ");
        $sqls2 = $query2->rows;
        if (isset($sqls2[0]['qiandao'])) {
            if ($sqls2[0]['qiandao'] == date('Y-m-d')) {
                $signHistory = $this->db->query("SELECT addtime FROM " . DB_PREFIX . "scorerecord WHERE uid = '" . (int) $customer . "'   ");
                return $signHistory->rows;
            } else {
                $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET qiandao = '" . date('Y-m-d') . "', scores='" . (int) $score . "'  WHERE customer_id = '" . (int) $customer . "'");
                $description = "每日签到送积分：10";
                $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET score = 10 ,uid = '" . (int) $customer . "',uname ='" . $uname . "',remark = '" . $description . " ' ,addtime='" . time() . "',totalscore='" . (int) $score . "',type=1");

                return 2;
            }
        }
    }

    public function shuang11($customer, $score, $uname) {
        $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET scores='" . (int) $score . "'  WHERE customer_id = '" . (int) $customer . "'");
        $description = "双11上传图片送积分：100";
        $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET score = 100 ,uid = '" . (int) $customer . "',uname ='" . $uname . "',remark = '" . $description . " ' ,addtime='" . time() . "',totalscore='" . (int) $score . "',type=1");
        return 1;
    }

    public function monthQiandao($customer) {
        $signHistory = $this->db->query("SELECT addtime FROM " . DB_PREFIX . "scorerecord WHERE uid = '" . (int) $customer . "'   ");
        return $signHistory->rows;
    }

    public function question($customer) {

        $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $customer . "'   ");
        $sqls2 = $query2->rows;
        if (isset($sqls2[0]['question'])) {
            if ($sqls2[0]['question'] == date('Y-m-d', time())) {
                return 'today';
            } else {

                $question_array = include(DIR_SYSTEM . 'question.php');
                return json_encode($question_array);
            }
        }
    }

    public function question2($customer, $question_id, $answer, $score, $uname) {

        $question_array = include(DIR_SYSTEM . 'question.php');

        $ans = $question_array[$question_id]['r'];

        if ($answer == $ans) {

            $this->db->query("UPDATE `" . DB_PREFIX . "customer` SET question = '" . date('Y-m-d', time()) . "', scores='" . (int) $score . "'  WHERE customer_id = '" . (int) $customer . "'");

            $description = "每日答题送积分：10";

            $this->db->query("INSERT INTO " . DB_PREFIX . "scorerecord SET score = 10 ,uid = '" . (int) $customer . "',uname ='" . $uname . "',remark = '" . $description . " ' ,addtime='" . time() . "',totalscore='" . (int) $score . "',type=1");
            return 'ok';
        } else {

            return "fail";
        }
    }

    public function customer($username_id) {

        $query2 = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int) $username_id . "'   ");
        $sqls2 = $query2->rows;
        return $sqls2[0]['firstname'];
    }

    public function key_world($data_keyword) {
        $order_status_name = $this->config->get('config_language_id') == 2 ? 'name' : 'name_en';
        $keyworld = $data_keyword['keyworld'];
        $order_status_buy = $data_keyword['order_status_buy'];
        $username_id = $data_keyword['username_id'];
        $query = $this->db->query("SELECT o.order_id, o.order_shipping, o.language_id,o.order_kaudi,CONCAT(o.firstname, ' ', o.lastname) AS customer, (SELECT os." . $order_status_name . " FROM " . DB_PREFIX . "order_status os WHERE os.order_status_id = o.order_status_id AND os.language_id = 2) AS status, o.total, o.currency_code, o.currency_value,o.addtime, o.date_added, o.date_modified  FROM `" . DB_PREFIX . "order` o LEFT JOIN " . DB_PREFIX . "order_product op ON (o.order_id = op.order_id) WHERE   o.order_status_buy = '$order_status_buy'  and o.customer_id = '$username_id'  and op.name  LIKE '%$keyworld%'    ");
        return $query->rows;
    }

    public function Total_weight($chestr) {
        $arr = explode(",", $chestr);
        $count = array();
        for ($i = 0; $i < count($arr); $i++) {

            if ($arr[$i] != "") {
                $order_id = $arr[$i];
                $query = $this->db->query("SELECT  SUM(weight) as  a FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'   ");

                $count[] = $query->rows[0]['a'];
            }
        }

        $sum = array_sum($count);
        return $sum;
    }

    public function insert_yundan($yundan_order) {




        foreach ($yundan_order as $order_id) {

            $query = $this->db->query("UPDATE `" . DB_PREFIX . "order`   SET  yundan_or = 1   WHERE  order_id = " . (int) $order_id);
        }
    }

    public function addSendorder($data) {

        $this->db->query("INSERT INTO `" . DB_PREFIX . "sendorder` SET sn = '" . (int) $data['sn'] . "', uid = '" . (int) $data['uid'] . "', uname = '" . $this->db->escape($data['uname']) . "', email = '" . $data['email'] . "', oids = '" . (int) $data['oids'] . "', couponid = '" . (int) $data['couponid'] . "', freight = '" . $data['freight'] . "', customsfee = 8,totalfee='" . $data['totalfee'] . "', countmoney = '" . $data['countmoney'] . "', countweight = '" . $data['countweight'] . "', consignee = '" . $data['consignee'] . "', country = '" . $data['country'] . "', city = '" . $data['city'] . "', zip = '" . $data['zip'] . "', tel = '" . $data['tel'] . "', address = '" . $data['address'] . "', remark = '" . $data['remark'] . "', deliveryname = '" . $data['deliveryname'] . "', areaname = '" . $data['areaname'] . "', addtime = time(), uptime = time()");

        return $sendorder_id;
    }

    public function getSendorderById($sid) {

        $query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "sendorder` WHERE sid =  '" . (int) $sid . "' ");

        return $query->row;
    }

    public function getoidBySid($sid) {

        $query = $this->db->query("SELECT oids AS 'oids' FROM `" . DB_PREFIX . "sendorder` WHERE sid =  '" . (int) $sid . "'");

        return $query->row['oids'];
    }

    public function gettotalfeeBySid($sid) {

        $query = $this->db->query("SELECT SUM(totalfee) AS totalfee FROM  " . DB_PREFIX . "sendorder WHERE sid IN (" . $sid . ")");

        return $query->row['totalfee'];
    }

    public function Updatestate($data) {

        $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  state = '" . (int) $data['state'] . "', uptime = unix_timestamp(now()),order_time=  unix_timestamp(now()) WHERE  sid = " . (int) $data['sid']);

        return $query;
    }

    public function UpdateSendorderPay($sids) {
        if (is_array($sids)) {
            foreach ($sids as $sid) {
                $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  state = 1 , uptime = unix_timestamp(now()) WHERE  sid = " . (int) $sid);
            }
        } else {
            $query = $this->db->query("UPDATE `" . DB_PREFIX . "sendorder`   SET  state = 1 , uptime = unix_timestamp(now())  WHERE  sid = " . (int) $sids);
        }
    }

    public function select_send_porduct($data) {

        $sql = "SELECT * FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data['username_id']) && !is_null($data['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data['username_id'] . "'";
        }

        if (!empty($data['order_status_id'])) {
            $sql .= " AND o.state = '" . (int) $data['order_status_id'] . "'";
        }


        if (!empty($data['consignee'])) {
            $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data['consignee']) . "%'";
        }

        $sql .= " ORDER BY sid DESC";

        $query = $this->db->query($sql);
        return $query->rows;
    }

    public function total_send_porduct($data) {
        $sql = "SELECT count(*) AS total FROM `" . DB_PREFIX . "sendorder` o";
        if (isset($data['username_id']) && !is_null($data['username_id'])) {
            $sql .= " WHERE o.uid = '" . (int) $data['username_id'] . "'";
        }
        if (!empty($data['order_status_id'])) {
            $sql .= " AND o.state = '" . (int) $data['order_status_id'] . "'";
        }
        if (!empty($data['consignee'])) {
            $sql .= " AND CONCAT(o.consignee) LIKE '%" . $this->db->escape($data['consignee']) . "%'";
        }
        $query = $this->db->query($sql);
        return $query->row['total'];
    }

    public function express_guoji($uid) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "dg_delivery WHERE  did = " . (int) $uid);
        $areaname = $query->rows;
        return $areaname[0]['deliveryname'];
    }

    public function sendorder_status() {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder_status");
        return $query->rows;
    }

    public function sendorder_status_id($uid) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "sendorder_status WHERE  id = " . (int) $uid);
        return $query->rows;
    }

    public function guoji_quxiao($sid, $user_balance, $customer_id) {

        $this->db->query("UPDATE  `" . DB_PREFIX . "customer` set money =  '" . (float)$user_balance . "'  WHERE  customer_id = " . (int) $customer_id);

        $query = $this->db->query("delete  from`" . DB_PREFIX . "sendorder`    WHERE  sid = " . (int) $sid);
    }

	
	public function no_payment_guoji_quxiao($sid, $customer_id) {

        $query = $this->db->query("delete  from`" . DB_PREFIX . "sendorder`    WHERE  sid = " . (int) $sid ." and uid=".(int)$customer_id);
    }
	
    public function totalSignalStatus($order_status_id, $customerId, $sign) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "order WHERE order_status_id = '" . (int) $order_status_id . "' AND customer_id = '" . (int) $customerId . "' AND order_status_buy = '" . $sign . "'");
        return $query->row;
    }

    public function totalYundanSignalStatus($order_status_id, $customerId) {
        $query = $this->db->query("SELECT COUNT(*) as total FROM " . DB_PREFIX . "sendorder WHERE state = '" . (int) $order_status_id . "' AND uid = '" . (int) $customerId . "'");
        return $query->row;
    }

    //获取订单商品差额
    public function getdifferencetotal($order_id) {

        //$query = $this->db->query("SELECT SUM(difference) AS differencetotal FROM `" . DB_PREFIX . "order_product` WHERE order_id = '". (int)$order_id . "'");
        //return $query->row['differencetotal'];
        $query = $this->db->query("SELECT total,difference FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int) $order_id . "'");

        return $query->rows;
    }

    //获取订单总额和差值
    public function getOrderdifference($order_id) {

        $query = $this->db->query("SELECT total,difference,order_shipping FROM " . DB_PREFIX . "order WHERE order_id = '" . (int) $order_id . "'");

        return $query->row;
    }

    public function getNewProductInfo($limitation) {
        $query = $this->db->query("SELECT *  FROM " . DB_PREFIX . "order_product WHERE price>0 ORDER BY order_product_id DESC LIMIT " . (int) $limitation);

        return $query->rows;
    }

    public function getcountbyid($order_id) {

        $query = $this->db->query("SELECT COUNT(*) as countfee FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int) $order_id . "'");

        return $query->row['countfee'];
    }

}

?>
