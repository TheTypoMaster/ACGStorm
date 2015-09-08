<?php
class ControllerReportProductPurchased extends Controller { 
	public function index() {   
		$this->language->load('report/product_purchased');

		$this->document->setTitle($this->language->get('heading_title'));
        
        
        if (isset($this->request->get['filter_source'])) {
			$filter_source = $this->request->get['filter_source'];
		} else {
			$filter_source = 0;
		}
        
        if (isset($this->request->get['filter_order_come'])) {
			$filter_order_come = $this->request->get['filter_order_come'];
		} else {
			$filter_order_come = 0;
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

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
        
        if (isset($this->request->get['filter_source'])) {
			$url .= '&filter_source=' . $this->request->get['filter_source'];
		}

		if (isset($this->request->get['filter_order_come'])) {
			$url .= '&filter_order_come=' . $this->request->get['filter_order_come'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

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

		$this->data['products'] = array();

		$data = array(
            'filter_source'          => $filter_source,
            'filter_order_come'      => $filter_order_come,
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);

		$product_total = $this->model_report_product->getTotalPurchased($data);

		$results = $this->model_report_product->getPurchased($data);

		foreach ($results as $result) {
			$this->data['products'][] = array(
				'name'       => $result['name'],
				'producturl'      => $result['producturl'],
				'quantity'   => $result['quantity'],
				'total'      => $this->currency->format($result['total'], $this->config->get('config_currency'))
			);
		}
        

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_buy_type'] = $this->language->get('text_buy_type');
        $this->data['text_buy_type_web'] = $this->language->get('text_buy_type_web');
        $this->data['text_buy_type_app'] = $this->language->get('text_buy_type_app');
        $this->data['text_buy_from'] = $this->language->get('text_buy_from');
        $this->data['text_buy_from_favorite'] = $this->language->get('text_buy_from_favorite');
        $this->data['text_buy_from_snatch'] = $this->language->get('text_buy_from_snatch');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_producturl'] = $this->language->get('column_producturl');
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_total'] = $this->language->get('column_total');

		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

	
		$url = '';
        
        if (isset($this->request->get['filter_source'])) {
			$url .= '&filter_source=' . $this->request->get['filter_source'];
		}

		if (isset($this->request->get['filter_order_come'])) {
			$url .= '&filter_order_come=' . $this->request->get['filter_order_come'];
		}

		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}

		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}

	

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/product_purchased', 'token=' . $this->session->data['token'] . $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();
        		
        
        $this->data['filter_source'] = $filter_source;
        $this->data['filter_order_come'] = $filter_order_come;
		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;
        		
		

		$this->template = 'report/product_purchased.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}	
}
?>