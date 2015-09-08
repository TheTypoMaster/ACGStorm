<?php

class ModelCatalogCategory extends Model {

    public function getSingalBigCategory($big_id) {
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $big_id . "' AND language_id = '" . (int) $this->config->get('config_language_id') . "'");
        if (isset($query->row['name']))
            return $query->row['name'];
    }

    public function getSingalSmallCategory($small_id) {
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "category_description WHERE category_id = '" . (int) $small_id . "' AND language_id = '" . (int) $this->config->get('config_language_id') . "'");
        if (isset($query->row['name']))
            return $query->row['name'];
    }

    public function getSingalProduct($product_id) {
        $query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int) $product_id . "' AND language_id = '" . (int) $this->config->get('config_language_id') . "'");
        if (isset($query->row['name']))
            return $query->row['name'];
    }

    public function getProductCategory($product_id) {
        $product_id = (int) $product_id;
        $sql = <<<EOF
             SELECT a.product_id,a.category_id,b.parent_id,c.name FROM oc_product_to_category a 
LEFT JOIN oc_category b ON(b.category_id=a.category_id)
LEFT JOIN oc_category_description c ON(c.language_id=2 AND c.category_id=a.category_id)
WHERE a.product_id={$product_id}           
EOF;
        $query = $this->db->query($sql);
        $product_category = $query->rows;
        $category = array();
        return $this->getProductCategorySort($product_category, 0, $category);
    }

    public function getProductCategorySort($product_category, $parent_id = 0, $category) {

        for ($i = 0; $i < count($product_category); $i++) {
            if ($product_category[$i]['parent_id'] == $parent_id) {
                if ($parent_id == 0) {
                    $category[] = array(
                        "category_id" => 0,
                        "parent_id" => $product_category[$i]['category_id'],
                        "name" => $product_category[$i]['name']
                    );
                } else {
                    $category[] = array(
                        "category_id" => $product_category[$i]['category_id'],
                        "parent_id" => $product_category[$i]['parent_id'],
                        "name" => $product_category[$i]['name']
                    );
                }
                if (count($category) == count($product_category)) {
                    break;
                }
                $category = $this->getProductCategorySort($product_category, $product_category[$i]['category_id'], $category);
            }
        }
        return $category;
    }

    public function getCategory($category_id) {
        $query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.category_id = '" . (int) $category_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1'");

        return $query->row;
    }

    public function getCategories($parent_id = 0) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND cd.language_id = '" . (int) $this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)");
        //echo $sql="SELECT * FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int)$parent_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "'  AND c.status = '1' ORDER BY c.sort_order, LCASE(cd.name)";

        return $query->rows;
    }

    public function getCategoryFilters($category_id) {
        $implode = array();

        $query = $this->db->query("SELECT filter_id FROM " . DB_PREFIX . "category_filter WHERE category_id = '" . (int) $category_id . "'");

        foreach ($query->rows as $result) {
            $implode[] = (int) $result['filter_id'];
        }


        $filter_group_data = array();

        if ($implode) {
            $filter_group_query = $this->db->query("SELECT DISTINCT f.filter_group_id, fgd.name, fg.sort_order FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_group fg ON (f.filter_group_id = fg.filter_group_id) LEFT JOIN " . DB_PREFIX . "filter_group_description fgd ON (fg.filter_group_id = fgd.filter_group_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND fgd.language_id = '" . (int) $this->config->get('config_language_id') . "' GROUP BY f.filter_group_id ORDER BY fg.sort_order, LCASE(fgd.name)");

            foreach ($filter_group_query->rows as $filter_group) {
                $filter_data = array();

                $filter_query = $this->db->query("SELECT DISTINCT f.filter_id, fd.name FROM " . DB_PREFIX . "filter f LEFT JOIN " . DB_PREFIX . "filter_description fd ON (f.filter_id = fd.filter_id) WHERE f.filter_id IN (" . implode(',', $implode) . ") AND f.filter_group_id = '" . (int) $filter_group['filter_group_id'] . "' AND fd.language_id = '" . (int) $this->config->get('config_language_id') . "' ORDER BY f.sort_order, LCASE(fd.name)");

                foreach ($filter_query->rows as $filter) {
                    $filter_data[] = array(
                        'filter_id' => $filter['filter_id'],
                        'name' => $filter['name']
                    );
                }

                if ($filter_data) {
                    $filter_group_data[] = array(
                        'filter_group_id' => $filter_group['filter_group_id'],
                        'name' => $filter_group['name'],
                        'filter' => $filter_data
                    );
                }
            }
        }

        return $filter_group_data;
    }

    public function getCategoryLayoutId($category_id) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "category_to_layout WHERE category_id = '" . (int) $category_id . "' AND store_id = '" . (int) $this->config->get('config_store_id') . "'");

        if ($query->num_rows) {
            return $query->row['layout_id'];
        } else {
            return false;
        }
    }

    public function getTotalCategoriesByCategoryId($parent_id = 0) {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "category c LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) WHERE c.parent_id = '" . (int) $parent_id . "' AND c2s.store_id = '" . (int) $this->config->get('config_store_id') . "' AND c.status = '1'");

        return $query->row['total'];
    }

}

?>