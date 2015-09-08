<?php 
	class ControllerPromotionTixianManage extends Controller { 
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
			
			if (isset($this->request->get['username'])) {
				$username = $this->request->get['username'];
			} else {
				$username = '';
			}

			if (isset($this->request->get['filter_date_end'])) {
				$filter_date_end = $this->request->get['filter_date_end'];
			} else {
				$filter_date_end ='';
			}
			
			if (isset($this->request->get['status'])) {
				$status = $this->request->get['status'];
			} else {
				$status ='';
			}
			
			if (isset($this->request->get['type'])) {
				$type = $this->request->get['type'];
			} else {
				$type ='';
			}
			
			
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			if (isset($this->request->get['status'])) {
				$url .= '&status=' . $this->request->get['status'];
			}
			if (isset($this->request->get['username'])) {
				$url .= '&username=' . $this->request->get['username'];
			}
			if (isset($this->request->get['type'])) {
				$url .= '&type=' . $this->request->get['type'];
			}
			
			$start=($page - 1) * 1;
			$limit=$start.',1';
			$promotion_total=$this->model_promotion_promotion->getTixianMargenTotal($filter_date_start,$filter_date_end,$type,$status,$username);
			$row=$this->model_promotion_promotion->getTixianMargen($filter_date_start,$filter_date_end,$type,$status,$username,$limit);
			
			$pagination = new Pagination();
			$pagination->total = $promotion_total;
			$pagination->page = $page;
			$pagination->limit = 1;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('promotion/tixian_manage', 'token=' . $this->session->data['token'] . '&page={page}', 'SSL');
			$this->data['pagination'] = $pagination->render();
			$this->data['products']=$row;
			$this->data['heading_title']='提现管理';
			$this->data['button_reset']='编辑';
			$this->data['id']='ID';
			$this->data['uname']='用户名';
			$this->data['money']='申请提现';
			$this->data['actual_money']='实际提现';
			$this->data['serial_no']='流水号';
			$this->data['entry_date_start']='开始时间';
			$this->data['entry_date_end']='结束时间';
			$this->data['addtime']='申请时间';
			$this->data['title_status']='是否成功';	
			$this->data['remark']='备注';	
			$this->data['type']='提现类型';	
			$this->data['eff_time']='生效时间';	
			$this->data['Acceptance_state']='是否受理';	
			$this->data['button_reset']='修改';
			$this->data['success']='';
			$this->data['username']=$username;
			$this->data['from_type']=$type;
			$this->data['form_status']=$status;
			$this->data['filter_date_end']=$filter_date_end;
			$this->data['filter_date_start']=$filter_date_start;	
			$this->data['token'] = $this->session->data['token'];
			$this->data['text_no_results']='没有数据';
			$this->data['breadcrumbs'] = array();
			$this->data['breadcrumbs'][] = array(
				'text' => $this->language->get('text_home'),
				'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => '提现查询管理',
            'href' => $this->url->link('promotion/tixian_manage', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
		
			$this->template = 'promotion/tixian_manage.tpl';
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

			$this->model_promotion_promotion->editTixian($this->request->get['id'], $this->request->post);

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

			$this->redirect($this->url->link('promotion/tixian_manage', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}
		
	protected function validateForm() {

		if (empty($this->request->post['id'])) {
			$this->error['warning'] ='12121';
		}else {
		
			$this->load->model('promotion/promotion');
			
			$id = trim($this->request->post['id']);
			
            $id = $this->model_promotion_promotion->selectid($id);
			
             if(!$id) {   
                 $this->error['warning'] = $this->language->get('error_exists');
              }
			
		}

		if(!$this->error){
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
			'href'      => $this->url->link('promotion/tixian_manage', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (isset($this->request->get['id'])) {
			$this->data['action'] = $this->url->link('promotion/tixian_manage/update', 'token=' . $this->session->data['token'] . '&id=' . $this->request->get['id'] . $url, 'SSL');
			$this->data['id'] = $this->request->get['id'];
		}

		$this->data['cancel'] = $this->url->link('promotion/tixian_manage', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['id']) && (!$this->request->server['REQUEST_METHOD'] != 'POST')) {
		
			$tixian_info = $this->model_promotion_promotion->getOneTixian($this->request->get['id']);
		
		}
		
		$this->data['uname'] = $tixian_info['firstname'];
		$this->data['money'] = $tixian_info['money'];
		$this->data['add_time'] = $tixian_info['add_time'];
		$this->data['type'] = $tixian_info['type'];
		$this->data['serial_no'] = $tixian_info['serial_no'];
		if (isset($this->request->post['id'])) {
			$this->data['id'] = $this->request->post['id'];
		} elseif (!empty($tixian_info)) {
			$this->data['id'] = $tixian_info['id'];
		} else {
			$this->data['id'] = '';
		}

		if (isset($this->request->post['uid'])) {
			$this->data['uid'] = $this->request->post['uid'];
		} elseif (!empty($tixian_info)) {
			$this->data['uid'] = $tixian_info['uid'];
		} else {
			$this->data['uid'] = '';
		}

		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($tixian_info)) {
			$this->data['status'] = $tixian_info['status'];
		} else {
			$this->data['status'] = '';
		}

		if (isset($this->request->post['Acceptance_state'])) {
			$this->data['Acceptance_state'] = $this->request->post['Acceptance_state'];
		} elseif (!empty($tixian_info)) {
			$this->data['Acceptance_state'] = $tixian_info['Acceptance_state'];
		} else {
			$this->data['Acceptance_state'] = '';
		}
		
		if (isset($this->request->post['remark'])) {
			$this->data['remark'] = $this->request->post['remark'];
		} elseif (!empty($tixian_info)) {
			$this->data['remark'] = $tixian_info['remark'];
		} else {
			$this->data['remark'] = '';
		}
		
		$this->template = 'promotion/tixian_manage_form.tpl';
		$this->children = array(
			'common/header',	
			'common/footer'	
		);
		$this->response->setOutput($this->render());		
	}	
		
		
	}
?>