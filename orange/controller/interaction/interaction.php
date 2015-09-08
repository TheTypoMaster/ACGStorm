<?php

class ControllerInteractionInteraction extends Controller {

    public function index() {
	$this->language->load('interaction/interaction');
        $this->document->setTitle("业务信息");
        $this->load->model('interaction/interaction');

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['filter_mid'])) {
            $filter_mid = $this->request->get['filter_mid'];
        } else {
            $filter_mid = null;
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
            'href' => $this->url->link('interaction/interaction', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->request->post['selected']) && isset($this->request->post['filter_order_status_id'])) {
            $select = $this->request->post['selected'];
            $filter_order_status_id = $this->request->post['filter_order_status_id'];

            //$this->model_yundan_yundan->updata_status($select, $filter_order_status_id);
        } else {
            $order = 'DESC';
        }
        
        if (isset($this->request->get['reply'])) {
            if (isset($this->request->get['fromuname'])) {
                $fromuname = $this->request->get['fromuname'];
            } else {
                $fromuname = null;
            }

            if (isset($this->request->get['touid'])) {
                $touid = $this->request->get['touid'];
            } else {
                $touid = null;
            }
            
            if (isset($this->request->get['touname'])) {
                $touname = $this->request->get['touname'];
            } else {
                $touname = null;
            }

            if (isset($this->request->get['subject'])) {
                $subject = $this->request->get['subject'];
            } else {
                $subject = null;
            }

            if (isset($this->request->get['message'])) {
                $message = $this->request->get['message'];
            } else {
                $message = null;
            }

	$data = array(
            'fromuname' => $fromuname,
            'touid' => $touid,
            'touname' => $touname,
            'subject' => $subject,
            'message' => $message
        );
        
            $mid = $this->model_interaction_interaction->replyPm($data);

            //手机推送消息
            $this->load->model('sale/order');
            $apps = $this->model_sale_order->getOnlineAppByCustomer($touid);
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
                        'description' => 'CNstorm客服：' . $message,
                        'deploy_status' => 2,
                        'custom_content' => $custom_content
                        );
                    $baepush->push($pm);
                }
            }
			$this->redirect($_SERVER['HTTP_REFERER']);
        }

	$this->data['token'] = $this->session->data['token'];
	$this->data['manager'] = $this->user->getUserName();
        $this->data['orders'] = array();

        $data = array(
            'mid' => $filter_mid,
            'uname' => $filter_uname,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

	
        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_interaction_interaction->getPms($data);

        foreach ($results as $result) {

            $this->data['orders'][] = array(
                'mid' => $result['mid'],
                'fromuname' => $result['fromuname'],
                'fromuid' => $result['fromuid'],
                'touname' => $result['touname'],
                'type' => $result['type'],
                'subject' => $result['subject'],
                'hasview' => $result['hasview'],
                'message' => $result['message'],
                'sendtime' => date("Y-m-d H:i:s", $result['sendtime']),
                'selected' => isset($this->request->post['selected']) && in_array($result['sid'], $this->request->post['selected']),
            );
        }

        $record_total = $this->model_interaction_interaction->totalPms();


        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('interaction/interaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'interaction/interaction.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }
    
    public function announcement(){
    	$this->language->load('interaction/interaction');
    	$url = '';
    	$this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title1'),
            'href' => $this->url->link('interaction/interaction/announcement', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );
        $record_total = 0;
        $page = '';
        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('interaction/interaction', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
        
        $this->data['pagination'] = $pagination->render();
            $this->template = 'interaction/announcement.tpl';
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
			$results = $this->model_interaction_interaction->getFirstUname($q);
			if (empty($results)){
				$results = $this->model_interaction_interaction->getFirstUname(trim($q));
			}
			if (isset($results)&&!empty($results)){
				foreach ($results as $v){
					echo $v['fromuname'] . "\n";
				}
			}else{
				echo "--无--" . "\n";
			}
		}
    }
}

?>