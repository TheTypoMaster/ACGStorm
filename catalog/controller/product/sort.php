<?php

class ControllerProductSort extends Controller {

    //請注意ControllerCompanyMain Company是文件夹名，Main是文件名
    public function index() {
        $parent_id = 0;
        if (isset($this->request->get['parent_id'])) {
            $parent_id = $this->request->get['parent_id'];
        }
        $category_id = 0;
        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        }
        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = "";
        if (isset($this->request->get['keyword'])) {
            $keyword = $this->request->get['keyword'];
            $url .= '&keyword=' . urlencode(html_entity_decode($this->request->get['keyword'], ENT_QUOTES, 'UTF-8'));
        } else {
            $keyword = '';
        }

        $banner_url = "";
        $banner_color = "";
        switch ($parent_id) {
            case 201:$banner_url = "images/site/mall/banner_hometown.jpg";
                $banner_color = "#ffc593";
                break;
            case 212:$banner_url = "images/site/mall/banner_fengshui.jpg";
                $banner_color = "#ffef94";
                break;
            case 222:$banner_url = "images/site/mall/banner_lipin.jpg";
                $banner_color = "#ff6969";
                break;
            case 193:$banner_url = "images/site/mall/banner_qingqu.jpg";
                $banner_color = "#d094ff";
                break;
            case 63:$banner_url = "images/site/mall/banner_shenghuo.jpg";
                $banner_color = "#ceff94";
                break;
            default:$banner_url = "images/site/mall/banner_hometown.jpg";
                $banner_color = "#ffc593";
                break;
        }
        $this->data['banner_url'] = $banner_url;
        $this->data['banner_color'] = $banner_color;





        $this->load->model('catalog/category');
        $this->data['category'] = $this->model_catalog_category->getCategories($parent_id);
        $this->data['parent_id'] = $parent_id;
        $this->data['category_id'] = $category_id;
        $this->data['keyword'] = $keyword;
        //dump($this->data['category']);

        $search_category_id = 0;
        if ($category_id <= 0) {
            $search_category_id = $parent_id;
        } else {
            $search_category_id = $category_id;
        }


        $data = array();
        $data['filter_category_id'] = $search_category_id;
        $data['filter_name'] = $keyword;
        $data['limit'] = 10;
        $data['start'] = ($page - 1) * $data['limit'];


        require_once(DIR_SYSTEM . '/cache.class.php');
        $pcache = new MyCache();
        $products_categoryid_info = $pcache->file2array('pc', $search_category_id);

        //  if (null == $products_categoryid_info) {
        // echo('11111111111');
        $this->load->model('catalog/product');
        // $results = $this->model_catalog_category->getCategories();
        $products_categoryid_info = $this->model_catalog_product->getProducts($data);
        $products_total = $this->model_catalog_product->getTotalProducts($data);
        $pcache->array2file($products_categoryid_info, 'pc', $search_category_id);
        //}
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
                    'category_product_id' => $search_category_id,
                    'product_id' => $product_categoryid_info['product_id'],
                    'thumb' => $image,
                    'name' => $product_categoryid_info['name'],
                    'price' => $price,
                    'href' => $product_categoryid_info['product_id'] . ".html"
                );
            }
        }

        //  dump($this->data['products_categoryid_info']);

        $pagination = new Pagination();
        $pagination->total = $products_total;
        $pagination->page = $page;
        $pagination->limit = 10;
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link("product/sort&parent_id={$parent_id}&category_id={$category_id}{$url}&page={page}");

        $this->data['pagination'] = $pagination->render();

//头部 title,keyword description
        $category_info = $this->model_catalog_category->getCategory($search_category_id);
        if (!empty($category_info)) {
            $this->document->setTitle($category_info['name']."-CNstorm");
            $this->document->setDescription($category_info ['meta_description']);
            $this->document->setKeywords($category_info['meta_keyword']);
        }else{
            $this->document->setTitle($keyword."- CNstorm商品搜索");
            $this->document->setDescription($keyword."- CNstorm商品搜索");
            $this->document->setKeywords($keyword."- CNstorm商品搜索");
        }




        //以下代码定义模版文件路径
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/sort.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/sort.tpl';
        } else {
            $this->template = 'default/template/product/sort.tpl';
        }

        //以下代码定义头尾文件路径
        $this->children = array(
            'common/header_mall',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

}

?>