<?php

class ControllerRecordRcrecord extends Controller {

    public function index() {

        $this->document->setTitle("消费充值日志");
        $this->load->model('record/record');

        $this->getList();
    }

    protected function getList() {
		$url = '';
        if (isset($this->request->get['filter_rid'])) {
            $filter_rid = $this->request->get['filter_rid'];
        } else {
            $filter_rid = null;
        }
        
        if (isset($this->request->get['filter_uname'])) {
            $filter_uname = $this->request->get['filter_uname'];
			$url .= "&filter_uname=".$filter_uname;
        } else {
            $filter_uname = null;
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'o.order_id';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'DESC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }
        $this->data['breadcrumbs'] = array();
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => '消费充值日志',
            'href' => $this->url->link('record/record', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        if (isset($this->request->post['selected']) && isset($this->request->post['filter_order_status_id'])) {
            $select = $this->request->post['selected'];
            $filter_order_status_id = $this->request->post['filter_order_status_id'];
        } else {
            $order = 'DESC';
        }

        $this->data['token'] = $this->session->data['token'];
        $this->data['orders'] = array();

        $data = array(
            'rid' => $filter_rid,
            'uname' => $filter_uname,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
            );

        date_default_timezone_set('Asia/Shanghai');

        $results = $this->model_record_record->getRCRecords($data);

        foreach ($results as $result) {

            $this->data['orders'][] = array(
                'rid' => $result['rid'],
                'name' => $result['name'],
                'firstname' => $result['firstname'],
                'type' => $result['type'],
                'payname' => $result['payname'],
                'currency' => $result['currency'],
                'amount' => $result['amount'],
                'money' => $result['money'],
                'accountmoney' => $result['accountmoney'],
                'remark' => $result['remark'],
                'addtime' => date("Y-m-d H:i:s", $result['addtime']),
                'successtime' => $result['successtime'] == '-' ? '-' : date("Y-m-d H:i:s", $result['successtime']),
                'selected' => isset($this->request->post['selected']) && in_array($result['sid'], $this->request->post['selected'])
            );
        }

        $record_total = $this->model_record_record->totalRCRecords($data);

        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('record/rcrecord', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'record/rcrecord.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

}

?>