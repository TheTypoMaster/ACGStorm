<?php 
	
	class ControllerPromotionFriendsManage extends Controller { 
	
		public function index(){
		
			$this->getList();
			
		}		
				
		public function getList(){

			$this->load->model( 'promotion/promotion' );
			
			if (isset($this->request->get['page'])) {
			
				$page = $this->request->get['page'];
				
			} else {
			
				$page = 1;
				
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
			
			if (isset($this->request->get['username'])) {
			
				$username = $this->request->get['username'];
				
			} else {
			
				$username = "";
				
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
			$start=($page - 1) * 10;
			$limit=$start.',10';
			$row=array();
			$rows=array();
			$promotion_total=0;
			
			if($username){
			
				$row=$this->model_promotion_promotion->getPromotionPerson($username);
				
				if($row['customer_id']!= NULL){
					$efftime = $this->model_promotion_promotion->getUserEff($row['customer_id']);
					$rows=$this->model_promotion_promotion->getCommission($username,$limit,$filter_date_start,$filter_date_end);
					if($rows ){
						foreach($rows as $k=>$v){
							$rows[$k]['yongjin']= $this->model_promotion_promotion->getTotalCommission($v['customer_id'],$efftime);
						}
					}
					$promotion_total = $this->model_promotion_promotion->getCommissionTotal($row['customer_id']);
				}else{
					$row='';
				}
				
			}
	
			$pagination = new Pagination();
			
			$pagination->total = $promotion_total;
			
			$pagination->page = $page;
			
			$pagination->limit = 1;
			
			$pagination->text = $this->language->get('text_pagination');
			
			$pagination->url = $this->url->link('promotion/friends_manage', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			
			$this->data['username']=$username;
			
			$this->data['pagination'] = $pagination->render();
			
			$this->data['filter_date_start']=$filter_date_start;
			
			$this->data['filter_date_end']=$filter_date_end;
			
			$this->data['entry_date_start']='开始时间';  
			
			$this->data['entry_date_end']='结束时间';  
			
			$this->data['PromotionPerson']=$row;
			
			$this->data['chid']=$rows;
			
			$this->data['token']=$this->session->data['token'];
			
			$this->data['heading_title']='推广员好友管理';
			
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
				'text' => '推广员好友管理',
				'href' => $this->url->link('promotion/friends_manage', 'token=' . $this->session->data['token'] . $url, 'SSL'),
				'separator' => ' :: '
			);
			
			$this->template = 'promotion/friends_manage.tpl';
			
			$this->children = array(
				'common/header',
				'common/footer'
			);
			
			$this->response->setOutput($this->render());
		}		
		
		public function remove_child(){
		
				error_reporting(E_ALL);
				ini_set( 'display_errors', 'On' );
				$this->load->model( 'promotion/promotion' );
				if(isset($this->request->post['c_id']))
					$cid=$this->request->post['c_id'];
				
				if(isset($this->request->post['p_id']))
					$pid=$this->request->post['p_id'];
				if($cid && $pid){
					 $this->model_promotion_promotion->remove_child($cid,$pid);
					 echo "true";
					
				}else{
					echo 'false';
				}
		}
	
		
	}
?>