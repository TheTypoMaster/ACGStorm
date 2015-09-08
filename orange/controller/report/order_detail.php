<?php 
//订单详情统计(代购、自助购、代邮寄)
class ControllerReportOrderDetail extends Controller {

	public function index(){
	
	/* 	error_reporting(E_ALL);
		ini_set( 'display_errors', 'On' );
 */
		$this->load->model('report/order_detail');	
		$this->load->model('localisation/order_status');
		if(isset($this->request->get['token'])){
			$token=$this->request->get['token'];
		}
		
		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d',time());
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d',time()+3600*24);;
		}

		if (isset($this->request->get['filter_group'])) {
			$filter_group = $this->request->get['filter_group'];
		} else {
			$filter_group = 1;
		}
		
		if (isset($this->request->get['type_group'])) {
			$type_group = $this->request->get['type_group'];
		} else {
			$type_group = 1;
		}
		
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		

		if(isset($this->request->get['page'])){
			$page=$this->request->get['page'];
		}else{
			$page=1;
		}
		
		$pnum=$this->config->get('config_admin_limit');
		$limit=" limit ".($page-1)*$pnum.",".$pnum;
		
		$rows=$this->model_report_order_detail->getDesignatedInfo($filter_group,$type_group,$filter_date_start,$filter_date_end,$limit);
		
		$order_total=$this->model_report_order_detail->getDesignatedTotal($filter_group,$type_group,$filter_date_start,$filter_date_end);
		
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/order_detail', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();		
		
		
		
		$this->data['filter_group']=array(1=>'日',2=>'周',3=>'月');
		$this->data['type_group']=array(1=>'代购',2=>'自助',3=>'代寄');
		
		
		$this->data['filter']=$filter_group;
		$this->data['type']=$type_group;
		$this->data['country']="国家";
		$this->data['total']="运单数";
		$this->data['column_date_start']='开始时间';
		$this->data['column_date_end']='结束时间';
		$this->data['date_start']=$filter_date_start;
		$this->data['date_end']=$filter_date_end;
		$this->data['text_no_results']='没有对应信息';
		$this->data['rows']=$rows;
		
		$this->data['heading_title']='订单量统计';
		$this->data['entry_date_start']='开始时间';
		$this->data['entry_date_end']='结束时间';
		$this->data['button_filter']='搜索';
		$this->data['entry_group']='按';
		$this->data['filter_date_start']=$filter_date_start;
		$this->data['filter_date_end']=$filter_date_end;
		$this->data['token']=$token;
		$this->data['column_orderNum']='订单数';
		$this->data['breadcrumbs'] = array();
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		
		$this->data['breadcrumbs'][] = array(
			'text'      =>'订单量统计',
			'href'      => $this->url->link('report/order_detail', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
	
		$url = '';

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		
	
		$this->template = 'report/order_detail.tpl';
		
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}
}
	
?>