<?php

class ControllerInformationComments extends Controller {

    public function index() {
        $this->load->model('order/sendorder');
        $limit = 10;
        $url = '';

        if (isset($this->request->get ['page'])) {
            $page = $this->request->get ['page'];
        } else {
            $page = 1;
        }

        $data = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        //好评率详情 guanzhiqiang 20150526
        $good_rate_detail = $this->model_order_sendorder->getGoodRateDetail();
        $this->data ['good_rate_detail'] = $good_rate_detail;

        $results = $this->model_order_sendorder->getComments($data);
        foreach ($results as $result) {
            if (strpos($result ['multyimg'], ',') !== false) {
                $result ['multyimg'] = explode(',', $result ['multyimg']);
                $this->data ['curImg'] = $result ['multyimg'] [0];
            }
            $this->data ['comments'] [] = array(
                'face' => $result ['face'],
                'uname' => $result ['uname'],
                'from' => $result ['country'],
                'reply' => $result ['reply'],
                'utype' => $result ['utype'],
                'message' => $result ['comment'],
                'multyimg' => $result ['multyimg']
                // 'sendtime' => date("Y-m-d H:i:s", $result['commenttime']),
            );
        }
        
        //大家最爱
        $this->load->model('catalog/product');
        $this->data['love_products']= $this->model_catalog_product->getLoveProducts(array(201,212,222,63),8);

        $record_total = $this->model_order_sendorder->totalComments();

        $pagination = new Pagination ();

        $pagination->total = $record_total;

        $pagination->page = $page;

        $pagination->limit = $limit;

        $pagination->url = $this->url->link('information/comments', $url . '&page={page}');

        $this->data ['pagination'] = $pagination->render();

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/user_comments.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/information/user_comments.tpl';
        } else {
            $this->template = 'default/template/information/user_comments.tpl';
        }
        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/information/user_comments_list.tpl';
        }
        $this->children = array(
            'common/footer',
            'common/header',
            'common/header_transport'
        );

        $this->response->setOutput($this->render());
    }

}

?>