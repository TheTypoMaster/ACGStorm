<?php

class ControllerSaleIntegral extends Controller {

    private $error = array();

    public function index() {

        $this->document->setTitle("积分管理");

        $this->data['token'] = $this->session->data['token'];

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => '积分管理',
            'href' => $this->url->link('sale/integral', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );


        if (isset($this->request->get['pay'])) {

            if (isset($this->request->get['receiver'])) {
                $receiver = $this->request->get['receiver'];
            } else {
                $receiver = null;
            }

            if (isset($this->request->get['receiver_id'])) {
                $receiver_id = $this->request->get['receiver_id'];
            } else {
                $receiver_id = null;
            }

            if (isset($this->request->get['message'])) {
                $message = $this->request->get['message'];
            } else {
                $message = null;
            }

            if (isset($this->request->get['integral'])) {
                $integral = $this->request->get['integral'];
            } else {
                $integral = null;
            }

            $this->load->model('record/record');
            $this->load->model('sale/customer');

            $results = $this->model_sale_customer->getCustomer($receiver_id);


            $cid = $receiver_id;
            $scores = $results['scores'];

            $type = (int)$integral < 0 ? 2 : 1;

            $newscores = $scores + $integral;
            if ($newscores < 0) {
                $this->data['result_message'] = '用户积分不足';
            } else {
                $this->data['result_message'] = '操作成功';

                $this->model_sale_customer->editScoresById($newscores, $receiver_id);

                $data = array(
                    'uid' => $cid,
                    'uname' => $receiver,
                    'type' => $type, // 1 获得 2 消费
                    'score' => $integral,
                    'totalscore' => $newscores,
                    'remark' => $message,
                );

                $this->model_record_record->addScoreRecord($data);
            }
        }

        $this->template = 'sale/integral.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function autocomplete() {
        $json = array();

        if (isset($this->request->get['filter_name'])) {
            $this->load->model('sale/customer');

            $data = array(
                'filter_name' => $this->request->get['filter_name']
            );

            $results = $this->model_sale_customer->getCustomersByName($data);

            foreach ($results as $result) {
                $json[] = array(
                    'receiver_id' => $result['customer_id'], 
                    'receiver'    => strip_tags(html_entity_decode($result['firstname'], ENT_QUOTES, 'UTF-8'))
                );
            }       
        }

        $sort_order = array();

        foreach ($json as $key => $value) {
            $sort_order[$key] = $value['receiver'];
        }

        array_multisort($sort_order, SORT_ASC, $json);

        $this->response->setOutput(json_encode($json));
    }

}

?>