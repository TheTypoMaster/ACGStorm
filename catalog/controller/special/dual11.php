<?php
class ControllerSpecialDual11 extends Controller {

    public function index() {

        $this->data['logged'] = $this->customer->isLogged();
        //$this->data['text_logged'] = sprintf("您好，", HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['text_logged'] = "您好，<a href='/order.html' target='_blank'>".$this->customer->getFirstName()."</a>（<a href='/account-logout.html'>退出</a>）";
        

        $this->load->model('order/order');
        
        $order_product_info = $this->model_order_order->getNewProductInfo(18);

        $this->data['products'] = $order_product_info;
        
        //var_dump($order_product_info);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/dual11.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/dual11.tpl';
        } else {
            $this->template = 'default/template/specialtpl/dual11.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>
