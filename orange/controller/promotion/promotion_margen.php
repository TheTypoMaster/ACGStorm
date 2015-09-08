<?php

class ControllerPromotionPromotionMargen extends Controller { 
	private $error = array();
	public function index(){
	
		error_reporting(E_ALL);
		ini_set( 'display_errors', 'On' );

	//	$this->language->load ( 'sale/order' );
		$this->getList();
	}
	public function getList(){

		$this->load->model( 'promotion/promotion' );
		if (isset($this->request->get['page'])) {
				$page = $this->request->get['page'];
			} else {
				$page = 1;
			}

		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		$start=($page - 1) * 20;
		$limit=$start.',20';
		$promotion_total=$this->model_promotion_promotion->getPromotionTotal();
		$products=$this->model_promotion_promotion->getPromotion($limit);
		
		foreach($products as $key=>$v){
			$sid=$this->model_promotion_promotion->getChildSid($v['uid']);
			$efftime=$this->model_promotion_promotion->getUserEff($v['uid']);
			if($sid){
				$products[$key]['childBuyNum']=$this->model_promotion_promotion->getChildBuyNum($sid);
				$products[$key]['ChildBuyMoney']=$this->model_promotion_promotion->getChildBuyMoney($sid);
				$products[$key]['yongjin']=$this->model_promotion_promotion->getChildLastMonth($sid,$efftime);	
				$products[$key]['money']=$this->model_promotion_promotion->getTixianMoney($v['uid']);
			}else{
				$products[$key]['childBuyNum']=0;
				$products[$key]['ChildBuyMoney']=0;
				$products[$key]['yongjin']=0;
				$products[$key]['money']=0;
			}
		}
		
		$this->data['products']=$products;
		$pagination = new Pagination();
		$pagination->total = $promotion_total;
		$pagination->page = $page;
		$pagination->limit = 20;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
		$this->data['pagination'] = $pagination->render();
		$this->data['token']= $this->session->data['token'];
		$this->data['heading_title']='推广人管理';
		$this->data['button_reset']='编辑';
		$this->data['pro_name']='推广人名称';
		$this->data['id']='ID';
		$this->data['reg_time']='注册时间';
		$this->data['last_login']='最后登录时间';
		$this->data['login_ip']='IP';
		$this->data['url']='邀请链接';
		$this->data['grade']='推广员等级';
		$this->data['reg_level']='注册下线数';
		$this->data['bug_level']='消费下线数';
		$this->data['money_level']='下线消费金额';
		$this->data['yjbili']='佣金比例';
		$this->data['rewardyj']='奖励佣金';
		$this->data['tixian']='已提现金额';
		$this->data['success']='编辑成功';
		$this->data['start']='是否启用';
		$this->data['text_no_results']='没有数据';
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
		
		$this->template = 'promotion/promotion_margen.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}
	
		
	public function update() {
		$this->language->load('sale/coupon');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('promotion/promotion');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
		        //var_dump($this->request->get['cid']);
		        //var_dump($this->request->post);
		        
		//	$this->model_sale_coupon->editCoupon($this->request->get['cid'], $this->request->post);

			$this->model_promotion_promotion->setPromotionPerson($this->request->post['uid'], $this->request->post['grade'],$this->request->post['commission_ratio']);
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	protected function validateForm() {

		if (empty($this->request->post['uid'])) {
			$this->error['warning'] ='12121';
		}else {
		
			$this->load->model('promotion/promotion');
			
			$uid = trim($this->request->post['uid']);
			
            $uid = $this->model_promotion_promotion->selectUid($uid);
			
             if(!$uid) {   
                 $this->error['warning'] = $this->language->get('error_exists');
              }
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function getForm() {
		$this->data['heading_title'] = '推广人管理';

		$this->data['entry_uname'] = '用户名';
		$this->data['entry_commission_ratio'] = '佣金比例';
		$this->data['entry_grade'] = '等级';
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');

		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_history'] = $this->language->get('tab_history');

		$this->data['token'] = $this->session->data['token'];
               
                
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['uname'])) {
			$this->data['error_uname'] = $this->error['uname'];
		} else {
			$this->data['error_uname'] = '';
		}

		if (isset($this->error['money'])) {
			$this->data['error_money'] = $this->error['money'];
		} else {
			$this->data['error_money'] = '';
		}		


		$url = '';

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (isset($this->request->get['uid'])) {
			$this->data['action'] = $this->url->link('promotion/promotion_margen/update', 'token=' . $this->session->data['token'] . '&cid=' . $this->request->get['cid'] . $url, 'SSL');
			$this->data['uid'] = $this->request->get['uid'];
		}

		$this->data['cancel'] = $this->url->link('promotion/promotion_margen', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['uid']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
			$customer_info = $this->model_promotion_promotion->getPromotionPersonById($this->request->get['uid']);
		
		}
		
		$this->data['uname'] = $customer_info['firstname'];
	
		if (isset($this->request->post['uid'])) {
			$this->data['uid'] = $this->request->post['uid'];
		} elseif (!empty($customer_info)) {
			$this->data['uid'] = $customer_info['customer_id'];
		} else {
			$this->data['uid'] = '';
		}

		if (isset($this->request->post['grade'])) {
			$this->data['grade'] = $this->request->post['grade'];
		} elseif (!empty($coupon_info)) {
			$this->data['grade'] = $customer_info['grade'];
		} else {
			$this->data['grade'] = 1;
		}
              
		if (isset($this->request->post['commission_ratio'])) {
			$this->data['commission_ratio'] = $this->request->post['commission_ratio'];
		} elseif (!empty($coupon_info)) {
			$this->data['commission_ratio'] = $customer_info['commission_ratio'];
		} else {
			$this->data['commission_ratio'] = 4;
		}

		$this->template = 'promotion/promotion_margen_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);

		$this->response->setOutput($this->render());		
	}
	
}
?>