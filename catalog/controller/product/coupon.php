<?php
class ControllerProductCoupon extends Controller {

    public function index() {
        $this->load->model('account/coupon');
	
	$results = $this->model_account_coupon->getFavourables();

	foreach ($results as $result) {
		$action = array();

		$this->data['favourables'][] = array(
			'favourable_id' => $result['favourable_id'],
			'name'            => $result['name'],
			'des'      => $result['des'],
			'selected'        => isset($this->request->post['selected']) && in_array($result['favourable_id'], $this->request->post['selected']),
			'add_time'          => date('Y年m月d日',$result['add_time']),
			'image'      => "/image/".$result['image'],
			'source'      => $result['source'],
			'url'      => $result['url']
		);
	}
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/coupon.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/product/coupon.tpl';
        } else {
            $this->template = 'default/template/product/coupon.tpl';
        }
        
        $this->children = array(
            'common/footer',
            'common/header'
        );
        
        $this->response->setOutput($this->render());
    }

}
    
?>