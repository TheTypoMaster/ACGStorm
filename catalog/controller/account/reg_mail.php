<?php

class ControllerAccountRegmail extends Controller {

    public function index() {
        //用户已提供邮箱
        if (isset($this->request->post['email']) || isset($this->request->get['email'])) {
            if (isset($this->request->post['email'])) {
                $email = $this->request->post['email'];
            } else {
                $email = $this->request->get['email'];
            }

            $cid = $this->session->data['customer_id'];

            $this->load->model('account/customer');
            $this->model_account_customer->editEmail($email, $cid);

            unset($this->session->data['guest']);

            //注册送积分
            $this->model_account_customer->editScores(200);

            $this->load->model('account/record');
            //增加送积分记录
            $insert_score_record = array(
                'uid' => $this->customer->getId(),
                'firstname' => $this->customer->getFirstName(),
                'remark' => '新用户注册送200积分',
                'score' => '+200',
                'type' => '1',
                'totalscore' => 200
            );

            $this->model_account_record->addScoreRecord($insert_score_record);
            
            $this->redirect($this->url->link('account/success'));
        } else {

            $this->data['login_from'] = $this->request->get['code'];

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/reg_mail.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/account/reg_mail.tpl';
            } else {
                $this->template = 'default/template/account/reg_mail.tpl';
            }

            $this->response->setOutput($this->render());
        }
    }

}

?>