<?php

class ControllerAccountWebnews extends Controller {

    public function index() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/webnews', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $this->load->model('account/pm');

        if (isset($this->request->get['mid'])) {
            $msg_did = $this->request->get['mid'];
            $this->model_account_pm->deletePm($msg_did);
        }

        $pm_info = $this->model_account_pm->getPm(3);

        $pm_info_total = $this->model_account_pm->getTotalPm(3);
        $this->data['pm_info'] = $pm_info;
        $this->data['pm_info_total'] = $pm_info_total;

        $business = $this->model_account_pm->getPm(2);
        $business_total = $this->model_account_pm->getTotalPm(2);
        $this->data['business_info'] = $business;
        $this->data['business_info_total'] = $business_total;

        $system = $this->model_account_pm->getPm(1);
        $system_total = $this->model_account_pm->getTotalPm(1);
        $this->data['system_info'] = $system;
        $this->data['system_info_total'] = $system_total;
        
        $this->template = 'cnstorm/template/account/webnews_business.tpl';

        $this->children = array(
			'common/header_cart',
            'common/footer',
            'common/uc_business');
       

        $this->response->setOutput($this->render());
    }

    public function view() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/webnews_reply', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $mid = str_replace("'", "", base64_decode($_GET['mid']));

        $this->load->model('account/pm');
        $pm_info = $this->model_account_pm->getPm2($mid);
        $this->data['pm_info'] = $pm_info[0];
        $pm_infos = $pm_info[0];
        $this->model_account_pm->updatePm($mid);
        $this->data['rply_lists'] = $this->model_account_pm->getPm3($this->customer->getId(), $mid);
        $this->data['mrply_lists'] = $this->model_account_pm->getPm3($pm_info[0]['fromuid'], $mid);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/webnews_reply.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/account/webnews_reply.tpl';
        } else {
            $this->template = 'default/template/account/webnews_reply.tpl';
        }

        $this->children = array(
            'common/column_left',
            'common/footer',
            'common/uc_business'
        );

        $this->response->setOutput($this->render());
    }

    public function reply() {
        if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/webnews_reply', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }

        $mid = $this->request->post['mid'];
        $this->load->model('account/pm');
        $pm_info = $this->model_account_pm->getPm2($mid);
        $pm_infos = $pm_info[0];

        $msg = array(
            'fromuid' => $pm_infos['touid'],
            'fromuname' => $pm_infos['touname'],
            'touid' => $pm_infos['fromuid'],
            'touname' => $pm_infos['fromuname'],
            'type' => $pm_infos['type'],
            'subject' => $this->request->post['title'] . $pm_infos['touid'] . "原标题：" . $pm_infos['subject'],
            'sendtime' => time(),
            'writetime' => $mid,
            'hasview' => 0,
            'isadmin' => 0,
            'message' => $this->request->post['msg']
        );

        $pm_info = $this->model_account_pm->addPm($msg);

        //$this->response->setOutput($this->render());
    }

}

?>