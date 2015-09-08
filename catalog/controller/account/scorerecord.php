<?php

class ControllerAccountScorerecord extends Controller {

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/coupons', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        if (isset($this->request->get['page'])) {

            $page = $this->request->get['page'];
        } else {

            $page = 1;
        }

        $url = '';
        $this->load->model('account/scorerecord');
        $limit = 20;
        $data = array(
            'start' => ($page - 1) * $limit,
            'limit' => $limit
        );

        $scorerecord_info = $this->model_account_scorerecord->getScorerecord($data);
        $scorerecord_total = $this->model_account_scorerecord->getTotalScorerecord();
        $pagination = new Pagination();
        $pagination->total = $scorerecord_total;
        $pagination->page = $page;
        $pagination->limit = $limit;
        $pagination->url = $this->url->link('account/scorerecord', $url . '&page={page}');

        $this->data['pagination'] = $pagination->render();

        $this->data['scorerecord_info'] = $scorerecord_info;

        $this->template = 'cnstorm/template/account/scorerecord_business.tpl';
       
        if (isset($this->request->get['page']) && array_key_exists('HTTP_REFERER', $_SERVER)) {
            $this->template = 'cnstorm/template/account/scorerecord_business_list.tpl';
        }
        
        /*
        $this->children = array(
            'common/header_business',
            'common/footer_business',
            'common/uc_business');
       */
	    $this->children = array(
			'common/header_cart',
			'common/footer',
			'common/uc_business'
		);   

        $this->response->setOutput($this->render());
    }

}

?>