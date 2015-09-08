<?php 
	class ControllerPromotionCommission extends Controller { 
	
	public function index(){
			$this->getList();
	}
		
	public function getList(){

	error_reporting(E_ALL);
	ini_set( 'display_errors', 'On' );
	
		$this->load->model( 'promotion/promotion' );
		
		if (isset($this->request->get['page'])) {
		
			$page = $this->request->get['page'];
			
		} else {
		
			$page = 1;
			
		}

	
		
		
		if (isset($this->request->get['username'])) {
		
			$username = $this->request->get['username'];
			
		} else {
		
			$username = '';
			
		}
		

		if (isset($this->request->get['filter_date_start'])) {
		
			$filter_date_start = $this->request->get['filter_date_start'];
			
		} else {
		
			$filter_date_start = '';
			
		}
		
		if (isset($this->request->get['filter_date_end'])) {
		
			$filter_date_end = $this->request->get['filter_date_end'];
			
		} else {
		
			$filter_date_end = '';
			
		}
		
		
		if (isset($this->request->get['money'])) {
		
			$money = $this->request->get['money'];
			
		} else {
		
			$money = '';
			
		}
		
		if (isset($this->request->get['filter_date_start'])) {
		
			$filter_date_start = $this->request->get['filter_date_start'];
		}else{
		
			$filter_date_start = '';
		}
		
		if (isset($this->request->get['filter_date_end'])) {
		
			$filter_date_end = $this->request->get['filter_date_end'];
		}else{
		
			$filter_date_end = '';
		}
		
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		if (isset($this->request->get['username'])) {
			$url .= '&username='.$this->request->get['username'];
		} 
		
		if (isset($this->request->get['filter_date_start'])) {
		
			$url .= '&filter_date_start='.$this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
		
			$url .= '&filter_date_end='.$this->request->get['filter_date_end'];
		} 
		
		$promotion_total=0;
		
		$start=($page - 1) * 1;
		
		$limit=$start.',1';
		
		$products=array();

		if($username){
		
			$row=$this->model_promotion_promotion->getPromotionPerson($username);
			$efftime = $this->model_promotion_promotion->getUserEff($row['customer_id']);
			$promotion_total=$this->model_promotion_promotion->getCommissionTotal($username,$filter_date_start,$filter_date_end);
			$products=$this->model_promotion_promotion->getCommission($username,$limit,$filter_date_start,$filter_date_end);
				foreach($products as $k=>$v){
				
					$products[$k]['yongjin']= $this->model_promotion_promotion->getTotalCommission($v['customer_id'],$efftime);
				}
				
			
		}
		$this->data['filter_date_start']=$filter_date_start;
		$this->data['filter_date_end']=$filter_date_end;
		$this->data['username']=$username;
		$this->data['products']=$products;
		$pagination = new Pagination();
		$pagination->total = $promotion_total;
		$pagination->page = $page;
		$pagination->limit = 1;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
		$this->data['pagination'] = $pagination->render();
		$this->data['token']=$this->session->data['token'];
		$this->data['heading_title']='佣金管理';
		$this->data['id']='ID';
		$this->data['button_reset']='编辑';
		$this->data['uname']='用户名';
		$this->data['sendorder']='国际运单消费';
		$this->data['add_time']='消费时间';
		$this->data['yjbl']='佣金比例';
		$this->data['yjgx']='佣金贡献 ';
		$this->data['text_no_results']='没有数据';
		$this->data['success']='';
		$this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => '推广员管理',
            'href' => $this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
		
		$this->template = 'promotion/commission.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	
	
	
}
?>is->render());
	}
	
	
	
}
?>