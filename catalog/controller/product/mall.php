<?php

class ControllerProductMall extends Controller {

    public function index() {



        $this->data['login'] = $this->url->link('account/login');

        $this->data['home'] = $this->url->link('common/home');

        $this->load->model('catalog/product');
        //轮播图
        $this->data['lunbopics'] = $this->model_catalog_product->getLunboPics();


        $this->load->model('help/help');
        //取公告列表
        $this->data['bulletins'] = array_slice($this->model_help_help->getBulletins(), 0, 5);
        krsort($this->data['bulletins']);



       // dump($this->data['bulletins']);
        //小C推荐
        $this->data['xiaoc'] = $this->model_catalog_product->getLunboPics(2);
        //大家最爱
        $this->data['zuiai'] = $this->model_catalog_product->getLunboPics(2, 0);
        $this->load->model('catalog/category');

        $this->load->model('tool/image');

        $this->data['products'] = array();

        //add by weikun 从数据表中获取所有分类的数据
        $this->data['products_categoryid_info'] = array();

        $this->data['categoryids'] = array();

        $this->data['s_categoryids'] = array();

        $results = $this->model_catalog_category->getCategories();
       // dump($results);

        $categoryid_all = array();

        foreach ($results as $result) {
            if ($result) {
                $categoryid_all[] = $result['category_id'];

                $s_results = $this->model_catalog_category->getCategories($result['category_id']);

                if ($s_results) {
                    foreach ($s_results as $s_result) {
                        $this->data['s_categoryids'][] = array(
                            's_category_id' => $s_result['category_id'],
                            'name' => $s_result['name'],
                            's_parent_category_id' => $result['category_id'],
                            'href' => $result['category_id'] . "_" . $s_result['category_id'] . ".html"
                        );
                    }
                }

                $this->data['categoryids'][] = array(
                    'category_id' => $result['category_id'],
                    'name' => $result['name']
                );
            }
        }
        
       // dump($categoryid_all);

        //var_dump($this->data['s_categoryids']);
        //var_dump($this->data['categoryids']);
        //add by weikun 以商品分类ID从数据库中获取相应的6条数据显示
        foreach ($categoryid_all as $categoryid_all_info) {
            $data = array();
            $data['filter_category_id'] = $categoryid_all_info;
            $data['start'] = 0;
            $data['limit'] = 9;

            require_once(DIR_SYSTEM . '/cache.class.php');
            $pcache = new MyCache();
            $products_categoryid_info = $pcache->file2array('pc', $categoryid_all_info);

          //  if (null == $products_categoryid_info) {
                // echo('11111111111');
                // $results = $this->model_catalog_category->getCategories();
                $products_categoryid_info = $this->model_catalog_product->getProducts($data);
                $pcache->array2file($products_categoryid_info, 'pc', $categoryid_all_info);
          //  }
            //dump($products_categoryid_info);

            foreach ($products_categoryid_info as $product_categoryid_info) {
                if ($product_categoryid_info) {

                    if ($product_categoryid_info['image'])
                        $image = substr("cache/" . $product_categoryid_info['image'], 0, -4) . "-222x222.jpg";
                    else
                        $image = '';

                    if ($product_categoryid_info['price'])
                        $price = $product_categoryid_info['price'];
                    else
                        $price = '';


                    $this->data['products_categoryid_info'][] = array(
                        'category_product_id' => $categoryid_all_info,
                        'product_id' => $product_categoryid_info['product_id'],
                        'thumb' => $image,
                        'name' => $product_categoryid_info['name'],
                        'price' => $price,
                        'href' => $product_categoryid_info['product_id'] . ".html"
                    );
                }
            }
        }


        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/mall.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/mall.tpl';
        } else {
            $this->template = 'default/template/product/mall.tpl';
        }

        $this->children = array(
            'common/footer',
            'common/header_mall'
        );

        $this->response->setOutput($this->render());
    }

}

?>