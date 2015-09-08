<?php
class ControllerSocialSocial extends Controller {
	public function index() {
		$this->load->model ( 'social/social' );
		
		// 判断用户是否登陆
		if ($this->customer->isLogged ()) {
			
			$this->data ['logged'] = 1;
			// 记录登入时间
			$this->model_social_social->setSnstime ();
		} else {
            $this->data['error_login'] = "";
            $this->data['action'] = $this->url->link('account/login', '', 'SSL');
            $this->data['register'] = $this->url->link('account/register', '', 'SSL');
            $this->data['forgotten'] = $this->url->link('account/forgotten', '', 'SSL');    
            $this->data['email'] = '';
            $this->data['password'] = '';
            include_once(DIR_SYSTEM . 'weibo/config.php');
            include_once(DIR_SYSTEM . 'weibo/saetv2.ex.class.php');

            $o = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
            $this->data['code_url'] = $o->getAuthorizeURL(WB_CALLBACK_URL);
		}
		
		// 回复的脸
		$this->data ['face'] = $this->customer->getface ();
		if (! $this->data ['face']) {
			$this->data ['face'] = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
		}
        
        // 回复用户的昵称
        $this->data['firstname'] = $this->customer->getFirstName();
        if(! $this->data['firstname']) {
            
            $this->data['firstname'] = '';
        }
		
		// 回复的用户id
		$this->data ['customer_id'] = $this->customer->getId ();
		if (! $this->data ['customer_id']) {
			
			$this->data ['customer_id'] = 0;
		}
		
		if ((isset ( $this->request->post ['search'] ) && ($this->request->post ['search'])) || (isset ( $this->request->get ['search'] ) && ($this->request->get ['search']))) {
			$key_word = isset ( $this->request->post ['search'] ) ? $this->request->post ['search'] : $this->request->get ['search'];
                        $this->data['post_key_word'] =  $key_word;
		} else {
			$key_word = '';
		}
		
		// 从消息评论表获取所有评论消息并按时间排序
		$this->data ['moreall'] = $this->url->link ( 'social/social', 'sort=all', 'SSL' );
		$this->data ['morepoints'] = $this->url->link ( 'social/social', 'sort=points', 'SSL' );
		$this->data ['morecomments'] = $this->url->link ( 'social/social', 'sort=comments', 'SSL' );
		
		if (isset ( $this->request->get ['sort'] ) && ($this->request->get ['sort'])) {
			$sort = $this->request->get ['sort'];
			$this->data ['sort'] = $sort;
		} else {
			$this->data ['sort'] = 'zhiding';
			$sort = 'zhiding';
		}
		
		if (isset ( $this->request->get ['page'] )) {
			$page = $this->request->get ['page'];
		} else {
			$page = 1;
		}
		
		$limit = 10;
		
		$data = array (
				'limit' => $limit,
				'start' => ($page - 1) * $limit,
				'sort' => $sort,
				'search' => $key_word 
		);
		$message_info = $this->model_social_social->getMessage ( $data );
		$message_total = $this->model_social_social->getTotalMessage ();

		include_once (DIR_SYSTEM . 'VideoUrlParser.class.php');
		foreach ($message_info as &$message ) {
			$data = array (
					'message_id' => $message ['message_id'],
					'start' => 0,
					'limit' => 10 
			);
			$message ['comment_info'] = $this->model_social_social->getComment($data);
			if ($message ['videourl']) {
				$message ['videoMassage'] = VideoUrlParser::parse ( $message ['videourl'] );
			}
			$message ['comment_total'] = $this->model_social_social->getTotalComment ( $message ['message_id'] );
                        $imgs = explode("|" , $message['imgurl']);
                        if (!empty($imgs[0])){
                          $countFirstImg = count($imgs);
                          foreach ( $imgs as $k => $v) {
                                   $posDot = strrpos ( $v, '.' );
                                   $strExt = substr ( $v, $posDot );
                                   $posXie = strrpos ( $v, '/' );
                                   $strFile = substr ( $v, $posXie );
                                   $strFile = explode ( '-', $strFile );
                                   $strFile = $strFile[0];
                                   if ($k == 0) {
                                       $message['strFile'] = "uploads/big" . $strFile . $strExt;
                                       $strFiles = '';
                                   } 
                                   if ($countFirstImg > 1 && $k <= $countFirstImg-2){
                                       $strFiles .= "uploads/big" . $strFile . $strExt . '|';
                                   }
                          }
                          $message['imgurls'] = $strFiles . "uploads/big" . $strFile . $strExt;
                        }
		}
		
		$this->data ['message_info'] = $message_info;
		
		// var_dump($message_info);
		
		// $this->data['action'] = $this->url->link('social/social/deliver');
		
		// $this->data['filesrc'] = $this->url->link('social/upfile');
		
		//轮播图
		$this->data['lunbopics'] = $this->model_social_social->getLunboPics();

		// 载入所有主题
		$theme_array = array ();
		$theme_info = $this->model_social_social->getTheme (1);
		
		foreach ( $theme_info as $info ) {
			$theme_array [$info ['theme_id']] = $info ['description'];
		}
		
		$this->data ['theme_array'] = $theme_array;
		
		$pagination = new Pagination ();
		$pagination->total = $message_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->num_links = 7;
		$pagination->text = $this->language->get ( 'text_pagination' );
		if (! empty ( $key_word )) {
			$pagination->url = $this->url->link ( 'social/social', 'page={page}&search=' . $key_word, 'SSL' );
		} else {
			$pagination->url = $this->url->link ( 'social/social', 'page={page}&sort=' . $sort, 'SSL' );
		}
		
		$this->data ['pagination'] = $pagination->render ();
		
		if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/social/social_list.tpl' )) {
			$this->template = $this->config->get ( 'config_template' ) . '/template/social/social_list.tpl';
		} else {
			$this->template = 'default/template/social/social_list.tpl';
		}
		
		if ((in_array($sort,array('all','points','comments')) && array_key_exists('HTTP_REFERER', $_SERVER) && !isset($this->request->get ['page'])) || isset($this->request->get ['page'])) {
			if (file_exists ( DIR_TEMPLATE . $this->config->get ( 'config_template' ) . '/template/social/social_list_ajax.tpl' )) {
				echo "<script src='catalog/view/javascript/jquery2/sns_fangda.js'></script>";
				$this->template = $this->config->get ( 'config_template' ) . '/template/social/social_list_ajax.tpl';
			} else {
				$this->template = 'default/template/social/social_list_ajax.tpl';
			}
		}

		$this->children = array (
				'common/footer',
				'common/social_right',
				'common/header_sns' 
                                //'common/header'
		);
		
		$this->response->setOutput ( $this->render () );
	}
	
	// 发表晒单或者发表心情
	public function deliver() {
		
		// var_dump($this->request->post);
		// 判断用户是否登陆
		if (! $this->customer->isLogged ()) {
			
			$this->response->setOutput ( 2 );
		}
		// 获取用户id
		$customer_id = $this->customer->getId ();
		
		// 获取用户的昵称
		$firstname = $this->customer->getFirstname ();
		
		// 获取用户的等级
		$utype = $this->customer->getUtype ();
		
		// 获取用户的脸
		$face = $this->customer->getface ();
		if (! $face) {
			$face = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
 
		}
		
		// 获取主题Id
		if (isset ( $this->request->post ['theme'] ) && ($this->request->post ['theme'])) {
			$theme_id = $this->request->post ['theme'];
		} else {
			$theme_id = '';
		}
		
		// 根据IP获取国家
		$ip = $this->request->server ['REMOTE_ADDR'];
		$info = file_get_contents ( 'http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip );
		$info = json_decode ( $info, true );
		if ($info ['code'] == 0) {
			$country = $info ['data'] ['country'];
		} else {
			$country = '';
		}
		
		// 获取消息正文 发晒单 bask 写心情 mood
		if (isset ( $this->request->post ['bask'] ) && ($this->request->post ['bask'])) {
			$message_text = $this->request->post ['bask'];
			$message_flag = 1;
		} else if (isset ( $this->request->post ['mood'] ) && ($this->request->post ['mood'])) {
			$message_text = $this->request->post ['mood'];
			$message_flag = 2;
		} else {
			$message_text = '';
			$message_flag = 0;
		}
		
		// 是否同步到微博
		if (isset ( $this->request->post ['sync_sina'] ) && ($this->request->post ['sync_sina'])) {
			$sync_sina = $this->request->post ['sync_sina'];
		} else {
			$sync_sina = 0;
		}
		
		// 同步到微博
		// 将数据放到session中
		if ($sync_sina) {
			
			$this->session->data ['wb'] ['message_text'] = utf8_substr ( $message_text, 0, 125 );
			$this->session->data ['wb'] ['message_text'] .= 'http://www.acgstorm.com/social.html';
			if (isset ( $this->request->post ['image'] ) && ($this->request->post ['image'])) {
				$picurl = $this->request->post ['image'];
				if (strpos ( $picurl, '|' ) !== false)
					$this->session->data ['wb'] ['imgurl'] = 'http://www.acgstorm.com/' . substr ( $picurl, 0, strpos ( $picurl, '|' ) );
			}
		}
		
		// var_dump("kenne");
		// 获取图片url地址
		if (isset ( $this->request->post ['image'] ) && ($this->request->post ['image'])) {
			$imgurl = $this->request->post ['image'];
			$signal_img = explode ( "|", $imgurl );
			$signal_img = array_filter ( $signal_img );
			foreach ( $signal_img as $k => $signal ) {
				$this->load->model ( 'tool/image' );
				$filename = explode ( "/", $signal );
				copy ( $signal, DIR_IMAGE . "thumb/" . $filename [2] );
				$image = $this->model_tool_image->resize ( "thumb/" . $filename [2], 76, 76 );
				$imgs [$k] = $image;
			}
			$imgurl = implode ( '|', $imgs );
		} else {
			$imgurl = '';
		}
		// 获取视频url地址
		if (isset ( $this->request->post ['video'] ) && ($this->request->post ['video'])) {
			$videourl = $this->request->post ['video'];
		} else {
			$videourl = '';
		}
		
		// 组装插入数据表数据
		$data = array ();
		$data ['customer_id'] = $customer_id;
		$data ['firstname'] = $firstname;
		$data ['utype'] = $utype;
		$data ['face'] = $face;
		$data ['theme_id'] = $theme_id;
		$data ['country'] = $country;
		$data ['message_text'] = $message_text;
		$data ['message_flag'] = $message_flag;
		$data ['imgurl'] = $imgurl;
		$data ['videourl'] = $videourl;
		$data ['sync_sina'] = $sync_sina;
		
		// 调用判断提交数据有效性后写入数据表
		$this->load->model ( 'social/social' );
		
		$message_id = $this->model_social_social->addMessage ( $data );
		
		if ($message_id) {
			$data = array (
					'message_id' => $message_id,
					'firstname' => $firstname,
					'face' => $face,
					'utype' => $utype,
					'country' => $country,
					'videourl' => $videourl 
			);
			
			$this->response->setOutput ( json_encode ( $data ) );
		}
	}
	
	// 发消息时同步到新浪微博
	public function sendwb() {
		// 获取消息正文 发晒单 bask 写心情 mood
		/*
		 * if(isset($this->request->post['bask']) && ($this->request->post['bask'])) { $message_text = $this->request->post['bask']; $message_flag = 1; } else if(isset($this->request->post['mood']) && ($this->request->post['mood'])) { $message_text = $this->request->post['mood']; $message_flag = 2; } else { $message_text = ''; $message_flag = 0; } //获取图片url地址 $this->session->data['token'] if(isset($this->request->post['image']) && ($this->request->post['image'])) { $imgurl = $this->request->post['image']; } else { $imgurl = ''; } //获取视频url地址 if(isset($this->reuqest->post['video']) && ($this->request->post['video'])) { $videourl = $this->request->post['video']; } else { $videourl = ''; } //之前已经登录微博并授权 if (isset($_SESSION['token'])) { } //未登录微博授权 else { include_once(DIR_SYSTEM . 'weibo/config.php'); include_once(DIR_SYSTEM . 'weibo/saetv2.ex.class.php'); if (isset($_GET['code'])) { $keys = array(); $keys['code'] = $_GET['code']; $keys['redirect_uri'] = WBS_CALLBACK_URL; try { $token = $o->getAccessToken('code', $keys); } catch (OAuthException $e) { } } else { echo "<script language=\"javascript\">window.open ('https://api.weibo.com/oauth2/authorize?client_id=".WB_AKEY."&redirect_uri=".WBS_CALLBACK_URL."&response_type=code','newwindow','height=440,width=630,top=150,left=300,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no')</script>"; } }
		 */
		include_once (DIR_SYSTEM . 'weibo/config.php');
		include_once (DIR_SYSTEM . 'weibo/saetv2.ex.class.php');
		$o = new SaeTOAuthV2 ( WB_AKEY, WB_SKEY );
		// 之前未登录微博授权
		if (isset ( $_GET ['code'] )) {
			$keys = array ();
			$keys ['code'] = $_GET ['code'];
			$keys ['redirect_uri'] = WBS_CALLBACK_URL;
			
			try {
				$token = $o->getAccessToken ( 'code', $keys );
				// $this->session->data['token'] = $token;
			} catch ( OAuthException $e ) {
			}
		}
		if (isset($token)&&!empty($token)) {
			$this->session->data ['token'] = $token;
			$c = new SaeTClientV2 ( WB_AKEY, WB_SKEY, $_SESSION ['token'] ['access_token'] );
			$ms = $c->home_timeline (); // done
			$uid_get = $c->get_uid ();
			/*
			 * var_dump($token); var_dump($uid_get);
			 */
			$uid = $uid_get ['uid'];
			$user_message = $c->show_user_by_id ( $uid ); // 根据ID获取用户等基本信息
			                                              
			// 图片微博
			if (isset ( $this->session->data ['wb'] ['imgurl'] )) {
				$ret = $c->upload ( $this->session->data ['wb'] ['message_text'] . ' @信恩世通CNstorm', $this->session->data ['wb'] ['imgurl'] );
			} else // 文字微博
				$ret = $c->update ( $this->session->data ['wb'] ['message_text'] . ' @信恩世通CNstorm' );
				// 返回信息
			$msg = '';
			if (isset ( $ret ['error_code'] ) && $ret ['error_code'] > 0) {
				$err = '微博同步失败，';
				if ($ret ['error_code'] == 20003)
					$msg = $err . "用户不存在";
				elseif ($ret ['error_code'] == 20005)
					$msg = $err . "目前仅支持JPG、GIF、PNG的图片";
				elseif ($ret ['error_code'] == 20006)
					$msg = $err . "图片太大";
				elseif ($ret ['error_code'] == 20012)
					$msg = $err . "输入文字太长，请不要超过140字";
				elseif ($ret ['error_code'] == 20015)
					$msg = $err . "账号、IP或应用非法，暂时无法完成此操作";
				elseif ($ret ['error_code'] == 20016)
					$msg = $err . "发布内容过于频繁";
				elseif ($ret ['error_code'] == 20017)
					$msg = $err . "提交相似的信息";
				elseif ($ret ['error_code'] == 20018)
					$msg = $err . "包含非法网址";
				elseif ($ret ['error_code'] == 20019)
					$msg = $err . "提交相同的信息";
				elseif ($ret ['error_code'] == 20020)
					$msg = $err . "包含广告信息";
				elseif ($ret ['error_code'] == 20021)
					$msg = $err . "包含非法内容";
				elseif ($ret ['error_code'] == 20022)
					$msg = $err . "此IP地址上的行为异常";
				elseif ($ret ['error_code'] == 20032)
					$msg = "发布成功，目前服务器可能会有延迟，请耐心等待1-2分钟";
				else
					$msg = "微博同步失败";
			} else {
				unset ( $this->session->data ['wb'] ['message_text'] );
				if (isset ( $this->session->data ['wb'] ['imgurl'] ))
					unset ( $this->session->data ['wb'] ['imgurl'] );
				$msg = "微博同步成功";
			}
			echo <<<Eof
<script type="text/javascript">  
  var i = 3;
  function check(){
       if(i>0){
            i = i - 1;
            document.getElementById("time").innerHTML = i;
            setTimeout("check()",1000);
         }else{
          window.opener = null;
          window.close();
         }
   }
     setTimeout("check()",1000);
  
  </script>
  
  <body>
     <div><p>{$msg}</p></div>

     <div>本页面<span id="time">3</span>秒后自动关闭</div>

     <div><p><a href="http://www.weibo.com/" target="_blank">查看微博</a></p></div>

     <a href="javascript:window.opener=null;window.close();">直接关闭本页面</a>
  </body>
Eof;
		}
	}
	
	// 发表消息的回复信息
	public function messagereply() {
		
		// var_dump($this->request->post);
		// 判断用户是否登陆
		if (! $this->customer->isLogged ()) {
			
			$this->response->setOutput ( 2 );
		}
		
		// 获取消息message_id
		if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			
			$message_id = $this->request->post ['message_id'];
		}
		
		// 获取评论人ID,用户名,头像
		$customer_id = $this->customer->getId ();
		
		$firstname = $this->customer->getFirstname ();
		
		$face = $this->customer->getface ();
		if (! $face) {
			$face = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
		}
		
		// 获取回复正文
		if (isset ( $this->request->post ['comment_text'] ) && ($this->request->post ['comment_text'])) {
			
			$comment_text = $this->request->post ['comment_text'];
		}
		
		// 0是评论
		$type = 0;
		
		$reply_name = '';
		
		$reply_id = '';
		
		// 组装插入数据表数据
		$data = array ();
		$data ['message_id'] = $message_id;
		$data ['customer_id'] = $customer_id;
		$data ['firstname'] = $firstname;
		$data ['face'] = $face;
		$data ['comment_text'] = $comment_text;
		$data ['type'] = $type;
		$data ['reply_name'] = $reply_name;
		$data ['reply_id'] = $reply_id;
		
		// 调用判断提交数据有效性后写入数据表
		$this->load->model ( 'social/social' );
		
		$comment_id = $this->model_social_social->addComment ( $data );
		
		if ($comment_id) {
			// 消息的评论数加1，评论ID加进去
			$this->model_social_social->updateComments ( $message_id );
			
			// 返回值
			$this->response->setOutput ( $comment_id );
		}
	}
	
	// 发表评论的回复信息
	public function commentreply() {
		
		// var_dump($this->request->post);
		// 判断用户是否登陆
		if (! $this->customer->isLogged ()) {
			
			$this->response->setOutput ( 2 );
		}
		
		// 获取消息message_id
		if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			
			$message_id = $this->request->post ['message_id'];
		}
		
		if ($message_id) {
			$customer_id = $this->customer->getId ();
			
			$firstname = $this->customer->getFirstname ();
			
			$face = $this->customer->getface ();
			if (! $face) {
				$face = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
			}
			
			// 获取被回复用户名
			if (isset ( $this->request->post ['reply_name'] ) && ($this->request->post ['reply_name'])) {
				
				$reply_name = $this->request->post ['reply_name'];
			}
			
			// 获取被评论id 被回复标志flag
			if (isset ( $this->request->post ['reply_id'] ) && ($this->request->post ['reply_id'])) {
				
				$reply_id = $this->request->post ['reply_id'];
			}
			
			// 获取回复正文
			if (isset ( $this->request->post ['comment_text'] ) && ($this->request->post ['comment_text'])) {
				
				$comment_text = $this->request->post ['comment_text'];
			}
			
			// 1是回复消息
			$type = 1;
			
			// 组装插入数据表数据
			$data = array ();
			$data ['message_id'] = $message_id;
			$data ['customer_id'] = $customer_id;
			$data ['firstname'] = $firstname;
			$data ['face'] = $face;
			$data ['comment_text'] = $comment_text;
			$data ['type'] = $type;
			$data ['reply_name'] = $reply_name;
			$data ['reply_id'] = $reply_id;
			
			// 调用判断提交数据有效性后写入数据表
			$this->load->model ( 'social/social' );
			
			$comment_id = $this->model_social_social->addComment ( $data );
			
			if ($comment_id) {
				$this->model_social_social->updateComments ( $message_id );
				$this->response->setOutput ( $comment_id );
			}
		}
	}
	
	// 判断数据有效性
	public function validate() {
	}
	
	// ajax获取所有主题
	public function getTheme() {
		
		// 判断用户是否登陆
		if ($this->customer->isLogged ()) {
			
			$this->load->model ( 'social/social' );
			
			$theme_info = $this->model_social_social->getTheme ();
			
			$this->response->setOutput ( json_encode ( $theme_info ) );
		}
	}
	
	// ajax获取所有的更新条数
	public function getTotalUpdate() {
		
		// 判断用户是否登陆
		if ($this->customer->isLogged ()) {
			
			$this->load->model ( 'social/social' );
			
			$social_time = $this->model_social_social->getSnstime ();
			
			$new_total = $this->model_social_social->getTotalUpdate ( $social_time );
			
			if ($new_total) {
				
				$this->response->setOutput ( $new_total );
			}
		}
	}
	
	// ajax删除获取指定消息的评论
	public function delMessage() {
		if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			
			$message_id = $this->request->post ['message_id'];
			
			$this->load->model ( 'social/social' );
			
			$this->model_social_social->deleteMessage ( $message_id );
			
			$this->response->setOutput ( 1 );
		}
	}
	
	// ajax删除指定的评论
	public function delComment() {
		if (isset ( $this->request->post ['comment_id'] ) && ($this->request->post ['comment_id'])) {
			
			$comment_id = $this->request->post ['comment_id'];
			$message_id = isset($this->request->post ['message_id'])?$this->request->post ['message_id']:'';
			$this->load->model ( 'social/social' );
			
			$this->model_social_social->deleteComment ( $comment_id );
			$this->model_social_social->dupdateComments( $message_id );
			$this->response->setOutput ( 1 );
		}
	}
	
	// ajax增加给指定消息的点赞数
	public function addPoints() {
		
		// var_dump($this->reqeust->post);
		
		// 判断用户是否登陆
		if (! $this->customer->isLogged ()) {
			
			$this->response->setOutput ( 2 );
		}
		
		if (isset ( $this->request->post ['message_id'] ) && ($this->request->post ['message_id'])) {
			
			$message_id = $this->request->post ['message_id'];
			
			$this->load->model ( 'social/social' );
			
			$customer_array = $this->model_social_social->getPoints ( $message_id );
			
			if ($customer_array) {
				
				$customers = explode ( "|", $customer_array );
				
				$customers = array_filter ( $customers );
				
				if (! in_array ( $this->customer->getId (), $customers )) {
					
					$this->model_social_social->updatePoints ( $message_id );
					
					$this->response->setOutput ( 1 );
				}
			} else {
				
				$this->model_social_social->updatePoints ( $message_id );
				
				$this->response->setOutput ( 1 );
			}
		}
	}
}
?>
