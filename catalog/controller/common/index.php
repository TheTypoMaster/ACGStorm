<?php

class ControllerCommonIndex extends Controller {

    public function index() {

        //登陆模块
        $this->data['logged'] = $this->customer->isLogged();
        $this->data['face'] = $this->customer->getFace();
        $this->data['text_logged'] = sprintf('<a href=' . HTTP_SERVER . 'order.html>' . $this->customer->getFirstName() . "</a>");  

                //最新订单
        $this->load->model('order/order');      
        $order_product_info = $this->model_order_order->getNewProductInfo(10);
        $this->data['products'] = $order_product_info;

                //网站公告
        $this->load->model('help/help');
        $bulletins = $this->model_help_help->getHomeBulletins();
        $this->data['bulletins'] = $bulletins;

        //网站评论
        $this->load->model('order/sendorder');
        $limit = 4;
        $data = array(
            'start' => 0,
            'limit' => $limit
        );

        $results = $this->model_order_sendorder->getComments($data);
        foreach ($results as $result) {

            $this->data ['comments'] [] = array(
                'face' => $result ['face'],
                'uname' => $result ['uname'],
                'from' => $result ['country'],
                'utype' => $result ['utype'],
                'message' => $result ['comment'],
            );
        }

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/index.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/index.tpl';
        } else {
            $this->template = 'default/template/specialtpl/index.tpl';
        }
        $this->children = array(
            'common/footer',
            'common/header2'
        );
        $this->response->setOutput($this->render());
    }

}

?>