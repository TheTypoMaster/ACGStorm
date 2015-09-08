<?php
class ControllerReportOrderForm extends Controller {
	public function index() {
		$this->language->load ( 'report/orderForm' );
		$this->document->setTitle ( $this->language->get ( 'heading_title' ) );
		$this->data ['breadcrumbs'] = array ();
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'text_home' ),
				'href' => $this->url->link ( 'common/home', 'token=' . $this->session->data ['token'], 'SSL' ),
				'separator' => false 
		);
		$this->data ['breadcrumbs'] [] = array (
				'text' => $this->language->get ( 'heading_title' ),
				'href' => $this->url->link ( 'report/orderForm', 'token=' . $this->session->data ['token'], 'SSL' ),
				'separator' => ' :: ' 
		);
		$this->data ['heading_title'] = $this->language->get ( 'heading_title' );
		$this->data ['text_no_results'] = $this->language->get ( 'text_no_results' );
		$this->data ['entry_group'] = $this->language->get ( 'entry_group' );
		$this->data ['button_filter'] = $this->language->get ( 'button_filter' );
		$this->data ['token'] = $this->session->data ['token'];
		$this->load->model ( 'report/orderForm' );
		$orderForms = $this->model_report_orderForm->getOrderForm ();
		
		$min = explode ( '-', $orderForms ['minDate'] );
		$max = explode ( '-', $orderForms ['maxDate'] );
		$min = $this->data ['minDate'] = $min [0];
		$max = $this->data ['maxDate'] = $max [0];
		//var_dump($min.'-'.$max);
		$this->data ['groups'] = array ();
		for($i = $min; $i <= $max; $i ++) {
			$this->data ['groups'] [] = array (
					'year' => $i,
					'value' => $i 
			);
		}
		//print($orderForms ['totalPrice']);
		$this->data ['totalPrice'] = $orderForms ['totalPrice'];
		$url = '';
		if (isset ( $this->request->get ['filter_group'] )) {
			$min = $this->data ['filter_group'] = $this->request->get ['filter_group'];
			$url .= '&filter_group=' . $this->request->get ['filter_group'];
		} else {
			$this->data ['filter_group'] = $max;
		}
		
		$curYear = $max;
		//print_r($curYear );
		$this->data ['orderFormsByMonth'] = $this->model_report_orderForm->getOrderFormByMonth ( $curYear );
		$this->data ['wayBillsByMonth'] = $this->model_report_orderForm->getWayBillByMonth ( $curYear );
		//echo "<pre>";
		//var_dump ( $this->data ['wayBillsByMonth'] );//运单
		//var_dump ( $this->data ['orderFormsByMonth'] );//订单
		$this->template = 'report/orderForm.tpl';
		$this->children = array (
				'common/header',
				'common/footer' 
		);
		$this->response->setOutput ( $this->render () );
	}
}
?>