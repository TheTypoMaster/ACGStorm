<?php
class ControllerReportProductSource extends Controller { 
	public function index() {   
		$this->language->load('report/product_purchased');
		$this->document->setTitle($this->language->get('heading_title'));
		$url = '';
		$this->data['breadcrumbs'] = array();
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);
		$this->load->model('report/product');
		$this->data['total1'] = $this->model_report_product->getTotalByType(1,0);
		$this->data['total2'] = $this->model_report_product->getTotalByType(2,0);
		$this->data['total3'] = $this->model_report_product->getTotalByType(3,0);
		$this->data['total4'] = $this->model_report_product->getTotalByType(1,1);
		$this->data['total5'] = $this->model_report_product->getTotalByType(2,1);
		$this->data['total6'] = $this->model_report_product->getTotalByType(3,1);
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_buy_type'] = $this->language->get('text_buy_type');
	        $this->data['text_buy_type_web'] = $this->language->get('text_buy_type_web');
	        $this->data['text_buy_type_app'] = $this->language->get('text_buy_type_app');
		$this->data['token'] = $this->session->data['token'];
		$this->template = 'report/product_source.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
		$this->response->setOutput($this->render());
	}	
}
?>