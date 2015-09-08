<?php

class ControllerCommunitySaiercomment extends Controller {

    public function index() {

        $this->document->setTitle("晒尔推荐");
        $this->load->model('community/saiercomment');

        $this->getList();
    }

    // ajax删除获取指定消息的评论
	public function delMessage() {
		if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			$message_id = $this->request->post ['message_id'];
			$this->load->model ( 'community/saiercomment' );	
                        $imagesAdd = $this->model_community_saiercomment->deleteImages ( $message_id );
                      if (!empty($imagesAdd)){
                        if ($imagesAdd = explode('|',$imagesAdd)){
                            foreach($imagesAdd as $v){
                                $v = explode(".com/",$v);
                                $bigv = explode("thumb/",$v[1]);
                                $bigv = str_replace('-76x76','',$bigv[1]);
                                $bigv = "../uploads/big/".$bigv;
                                $v = "../".$v[1];
                                //file_put_contents('./1.log',$v."\r\n",FILE_APPEND);
                                //file_put_contents('./1.log',$bigv."\r\n",FILE_APPEND);
                                unlink($v);
                                unlink($bigv);
                            }
                        }
                      }
			$this->model_community_saiercomment->deleteMessage ( $message_id );
			$this->response->setOutput ( 1 );
		}
	}
        
        //置顶消息
        public function zhidingMessage(){
            if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			$message_id = $this->request->post ['message_id'];
			$this->load->model ( 'community/saiercomment' );	
			$this->model_community_saiercomment->zhidingMessage ( $message_id );
			$this->response->setOutput ( 1 );
		}
        }

//取消置顶
        public function cancelZhidingMessage(){
            if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			$message_id = $this->request->post ['message_id'];
			$this->load->model ( 'community/saiercomment' );	
			$this->model_community_saiercomment->cancelZhidingMessage ( $message_id );
			$this->response->setOutput ( 1 );
		}
        }

	public function showMessage(){
            	if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
		        $message_id = $this->request->post ['message_id'];
			$this->load->model ( 'community/saiercomment' );
                        $commentState = $this->model_community_saiercomment->messageState($message_id);
                        if ($commentState == 0) {
                            $this->model_community_saiercomment->showMessage(1, $message_id);
                            echo 0;
                        }
                        if ($commentState == 1) {
                            $this->model_community_saiercomment->showMessage(0, $message_id);
                            echo 1;
                        }
	        }
        }

	public function showRecomment(){
            	if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
		        $message_id = $this->request->post ['message_id'];
			$this->load->model ( 'community/saiercomment' );
                        $commentState = $this->model_community_saiercomment->recState($message_id);
                        if ($commentState == 0) {
                            $this->model_community_saiercomment->showRecomment(1, $message_id);
                            echo 0;
                        }
                        if ($commentState == 1) {
                            $this->model_community_saiercomment->showRecomment(0, $message_id);
                            echo 1;
                        }
	        }
        }

    protected function getList() {
         $url = '';
        if (isset($this->request->get['filter_gid'])) {
            $filter_gid = $this->request->get['filter_gid'];
        } else {
            $filter_gid = null;
        }

        if (isset($this->request->get['filter_uname'])) {
            $filter_uname = $this->request->get['filter_uname'];
            $url .= "&filter_uname=".$filter_uname;
            $record_total = $this->model_community_saiercomment->messageTotalName($filter_uname);
        } else {
            $filter_uname = null;
        }

        if (isset($this->request->get['appr'])) {
            $appr = $this->request->get['appr'];
            $record_total = 5;
        } else {
            $appr = null;
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
            'text' => "晒尔推荐",
            'href' => $this->url->link('community/saiercomment', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (isset($this->request->get['reply'])) {

            $reply_sid = $this->request->get['tosid'];
	    $reply_msg = $this->request->get['message'];

            $this->model_community_saiercomment->replyComments($reply_msg,$reply_sid);
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
            'appr' => $appr,
            'sort' => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );


        date_default_timezone_set('Asia/Shanghai');
        $results = $this->model_community_saiercomment->getComments($data);

        include_once (DIR_SYSTEM . 'VideoUrlParser.class.php');

        foreach ($results as $result) {
            $imgurl = explode('|',$result['imgurl']);
            if(is_array($imgurl)&&!empty($imgurl[0])){$result['imgurl'] = $imgurl;}        

            if($result['videourl']){
                $result['videoMassage'] = VideoUrlParser::parse($result['videourl']);
            }else{
               $result['videoMassage']['img'] = '';
            }
            $this->data['orders'][] = array(
                'message_id' => $result['message_id'],
                'fromuname' => $result['firstname'],
                'if_show' => $result['if_show'],
                'message' => $result['message_text'],
                'sendtime' => date("Y-m-d H:i:s", $result['addtime']),
                'imgurl'        =>  $result['imgurl'],
                'videourl'              =>  $result['videourl'],
                'videoMassage'   =>   $result['videoMassage']['img'],
                'country'          =>    $result['country'],
                'approved'        =>    $result['approved'],
                'zhiding'         =>    $result['zhiding'],
				'recomment'       =>    $result['recomment'],
                'selected' => isset($this->request->post['selected']) && in_array($result['message_id'], $this->request->post['selected']),
            );
        }
        $record_total = isset($record_total)?$record_total:$this->model_community_saiercomment->totalComments();


        $pagination = new Pagination();
        $pagination->total = $record_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('community/saiercomment', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->template = 'community/saiercomment.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function showComments() {
        $this->load->model('community/saiercomment');
        if (isset($this->request->post['message_id'])) {
            $message_id = $this->request->post['message_id'];
            $commentState = $this->model_community_saiercomment->commentState($message_id);
            $totalShowComments = $this->model_community_saiercomment->totalShowComments();
            if ($commentState == 0 && $totalShowComments < 5) {
                $this->model_community_saiercomment->showComments(1, $message_id);
                echo 0;
            } else if ($commentState == 1 && $totalShowComments <= 5) {
                $this->model_community_saiercomment->showComments(0, $message_id);
                echo 1;
            }else if($commentState == 1 && $totalShowComments>5) {
                $this->model_community_saiercomment->showComments(0, $message_id);
                echo 1;
            }
            else if($commentState == 0 && $totalShowComments>=5) {
                echo 2;
            }
        }
    }

    public function modifyCountry(){
         $this->load->model('community/saiercomment');
         if (isset($this->request->post['message_id'])) {
             $message_id = $this->request->post['message_id'];
             $country = $this->request->post['country'];
             $state = $this->model_community_saiercomment->modifyCountry($message_id,$country);
             if ($state){
                  echo '1';
             }else{
                  echo '0';
             }
         }
    }

}

?>