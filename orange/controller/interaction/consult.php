<?php

class ControllerInteractionConsult extends Controller {

    public function index() {
	$this->language->load('interaction/consult');
        $this->document->setTitle("咨询建议");
        $this->load->model('interaction/interaction');

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_gid'])) {
            $filter_gid = $this->request->get['filter_gid'];
        } else {
            $filter_gid = null;
        }

        if (isset($this->request->get['filter_uname'])) {
            $filter_uname = $this->request->get['filter_uname'];
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

        $url = '';

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('interaction/consult', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
        
        if (isset($this->request->get['reply'])) {
            if (isset($this->request->get['gid'])) {
                $reply_gid = $this->request->get['gid'];
            } else {
                $reply_gid = null;
            }

            if (isset($this->request->get['reply'])) {
                $reply_msg = $this->request->get['reply'];
            } else {
                $reply_msg = null;
            }

            $this->model_interaction_interaction->replyConsult($reply_gid, $reply_msg);

            //手机推送消息
            $consult = $this->model_interaction_interaction->getConsult($reply_gid);
            $this->load->model('sale/order');
            $apps = $this->model_sale_order->getOnlineAppByCustomer($consult['uid']);
            if ($apps) {
                $custom_content = array(
                    'gid' => $reply_gid,
                    'state' => 6
                    );
                include_once(DIR_SYSTEM . 'baepush.class.php');
                $baepush = new Baepush();
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
                        'description' => 'cnstorm客服：' . $reply_msg,
                        'deploy_status' => 2,
                        'custom_content' => $custom_content
                        );
                    $baepush->push($pm);
                }
            }
        }

        if (isset($this->request->post['selected']) && isset($this->request->post['filter_order_status_id'])) {
            $select = $this->request->post['selected'];
            $filter_order_status_id = $this->request->post['filter_order_status_id'];
        } else {
            $order = 'DESC';
        }

        $this->data['token'] = $this->session->data['token'];
        $this->data['manager'] = $this->user->getUserName();
        $this->data['orders'] = array();

        $data = array(
            'gid' => $filter_gid,
            'uname' => $filter_uname,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );


        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_interaction_interaction->getConsults($data);

        foreach ($results as $result) {

            $this->data['orders'][] = array(
                'mid' => $result['gid'],
                'fromuname' => $result['uname'],
                'type' => $result['type'],
                'reply' => $result['reply'],
                'hasview' => $result['state'],
                'message' => $result['msg'],
                'sendtime' => date("Y-m-d H:i:s", $result['addtime']),
                'selected' => isset($this->request->post['selected']) && in_array($result['sid'], $this->request->post['selected']),
            );
        }

        $record_total = $this->model_interaction_interaction->totalConsults();


        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('interaction/consult', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'interaction/consult.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

	public function autocomplete() {
		$this->load->model('interaction/interaction');
		if (isset($this->request->get['q'])){
			$q = $this->request->get['q'];
			$results = $this->model_interaction_interaction->getUname($q);
			if (empty($results)){
				$results = $this->model_interaction_interaction->getUname(trim($q));
			}
			if (isset($results)&&!empty($results)){
				foreach ($results as $v){
					echo $v['uname'] . "\n";
				}
			}else{
				echo "--无--" . "\n";
			}
		}
    }

}

?>