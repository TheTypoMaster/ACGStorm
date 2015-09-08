<?php

class ControllerCommunityCommentshow extends Controller {

    public function index() {

        $this->document->setTitle("晒单吐槽");
        $this->load->model('community/community');

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
            'href' => $this->url->link('record/record', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->request->get['reply'])) {

            $reply_sid = $this->request->get['tosid'];
	    $reply_msg = $this->request->get['message'];

            $this->model_community_community->replyComments($reply_msg,$reply_sid);
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
            'sid' => $filter_gid,
            'uname' => $filter_uname,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );


        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_community_community->getComments($data);

        foreach ($results as $result) {

            $this->data['orders'][] = array(
                'sid' => $result['sid'],
                'fromuname' => $result['uname'],
                'showcomment' => $result['showcomment'],
                'type' => 1,
                'reply' => $result['reply'],
                'hasview' => $result['state'],
                'message' => $result['comment'],
                'sendtime' => date("Y-m-d H:i:s", $result['commenttime']),
                'selected' => isset($this->request->post['selected']) && in_array($result['sid'], $this->request->post['selected']),
            );
        }

        $record_total = $this->model_community_community->totalComments();


        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('community/commentshow', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'community/commentshow.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function showComments() {
        $this->load->model('community/community');
        if (isset($this->request->post['sid'])) {
            $sid = $this->request->post['sid'];
            $comment_state = $this->model_community_community->commentState($sid);
            if ($comment_state == 0) {
                $state = 1;
            } else {
                $state = 0;
            };
            $this->model_community_community->showComments($state, $sid);

            $this->response->setOutput($comment_state);
        }
    }

}

?>