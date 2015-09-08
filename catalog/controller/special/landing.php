<?php
class ControllerSpecialLanding extends Controller {

    public function index() {

        //网站评论
        $this->load->model('order/sendorder');
        $limit = 3;
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
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/landing1.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/landing1.tpl';
        } else {
            $this->template = 'default/template/specialtpl/landing1.tpl';
        }
        
        $this->children = array(
            'common/footer_business',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>