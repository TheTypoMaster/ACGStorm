<?php

class ControllerInteractionPm extends Controller {

    private $error = array();

    public function index() {
	$this->language->load('interaction/pm');
        $this->document->setTitle("站内信");

        $this->data['token'] = $this->session->data['token'];

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('interaction/pm', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );


        if (isset($this->request->get['send'])) {

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

            if (isset($this->request->get['title'])) {
                $title = $this->request->get['title'];
            } else {
                $title = null;
            }

            $data = array(
                'fromuname' => 'CNstorm客服',
                'touid' => $receiver_id,
                'touname' => $receiver,
                'subject' => $title,
                'message' => $message
                );
        
            $this->load->model('interaction/interaction');

            $mid = $this->model_interaction_interaction->replyPm($data);

            if ($mid) {
                $this->data['result_message'] = '操作成功';

                //手机推送消息
                $this->load->model('sale/order');
                $apps = $this->model_sale_order->getOnlineAppByCustomer($receiver_id);
                if ($apps) {
                    include_once(DIR_SYSTEM . 'baepush.class.php');
                    $baepush = new Baepush();
                    $custom_content = array(
                        'mid' => $mid,
                        'state' => 4
                        );
                    foreach ($apps as $app) {
                        if ($app['device_type'] == 1) {//ios
                            $device_type = 4;
                        }
                        elseif ($app['device_type'] == 2) {//android
                            $device_type = 3;
                        }

                        $pm = array(
                            'push_type' => 1,
                            'user_id' => $app['user_id'],
                            'device_type' => $device_type,
                            'description' => 'CNstorm客服：' . $title,
                            'deploy_status' => 2,
                            'custom_content' => $custom_content
                            );
                        $baepush->push($pm);
                    }
                }
            } else {
                $this->data['result_message'] = '发送失败，请重试！';
            }

        }

        $this->template = 'interaction/pm.tpl';
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

            $data1 = array(
                'filter_name' => $this->request->get['filter_name']
            );
			$data2 = array(
                'filter_name' => trim($this->request->get['filter_name'])
            );

            $results = $this->model_sale_customer->getCustomersByName($data1);
			//$results2 = $this->model_sale_customer->getCustomersByName($data2);
		//	$results = array_merge($results1,$results2);
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