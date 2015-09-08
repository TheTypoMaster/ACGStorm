<?php
class ControllerCommonSocialright extends Controller {
    
	protected function index() {
	   //语言部分
		$this->language->load("common/social_right");
        $this->data['text_Seemore'] = $this->language->get('text_Seemore');
		$this->data['text_Bulletin'] = $this->language->get('text_Bulletin');
		$this->data['text_Suggestedanswer'] = $this->language->get('text_Suggestedanswer');
		$this->data['text_showOrder'] = $this->language->get('text_showOrder');
		$this->data['text_Writemood'] = $this->language->get('text_Writemood');
		$this->data['text_SynchronizationSina'] = $this->language->get('text_SynchronizationSina');
		$this->data['text_opportunity'] = $this->language->get('text_opportunity');
		$this->data['text_curious'] = $this->language->get('text_curious');
		$this->data['text_word'] = $this->language->get('text_word');
		$this->data['text_successful'] = $this->language->get('text_successful');
		$this->data['text_Localupload'] = $this->language->get('text_Localupload');
		$this->data['text_photos'] = $this->language->get('text_photos');
		$this->data['text_videoaddress'] = $this->language->get('text_videoaddress');
		$this->data['text_videowebsite'] = $this->language->get('text_videowebsite');
		$this->data['text_notvalid'] = $this->language->get('text_notvalid');
		$this->data['text_playback'] = $this->language->get('text_playback');
		$this->data['text_Choosetheme'] = $this->language->get('text_Choosetheme');
		$this->data['text_powered'] = $this->language->get('text_powered');
		$this->data['text_Release'] = $this->language->get('text_Release');
		$this->data['text_rec'] = $this->language->get('text_rec');
		$this->data['text_Comment'] = $this->language->get('text_Comment');
		$this->data['text_Master'] = $this->language->get('text_Master');
		$this->data['text_answer'] = $this->language->get('text_answer');

		$this->load->model ( 'order/order' );
        //判断用户是否登陆
        if ($this->customer->isLogged()) {
            
          $this->data['logged'] = 1;
        } else {
            
          $this->data['logged'] = 0;
        }

      //日历
		if (isset ( $this->session->data ['customer_id'] )) {
			$this->data ['customer_id'] = $this->session->data ['customer_id'];
			
			$signFlag = $this->model_order_order->getSignFlag ( $this->session->data ['customer_id'] );
			if ($signFlag ['qiandao'] == date ( 'Y-m-d', time () ))
				$this->data ['signFlag'] = 1;
			else
				$this->data ['signFlag'] = 0;
			$customer = $this->customer->getFirstname ();
			$product = $this->model_order_order->monthQiandao ( $this->data ['customer_id'] );
			$count = 0;
			if (is_array ( $product ) && !empty($product)) {
				foreach ( $product as $v ) {
					$v ['addtime'] = date ( 'Y-m-d', $v ['addtime'] );
					$v = $v ['addtime'];
					$temp [] = $v;
				}
				$temp = array_unique ( $temp );
				foreach ( $temp as $k => $v ) {
				    $ex1 = explode("-",$v);
					$ex = $ex1[1];
					if ($ex == date ( 'm', time () )) {
						$count ++;
					}
				}
			}
			$this->data ['count'] = $count;
		} else {
			$this->data ['session'] = 1;
			$customer = "";
		}
		$this->data ['customer_name'] = $customer;
		
		$this->data ['filesrc'] = $this->url->link ( 'social/upfile' );

        //晒尔公告
        $this->load->model('help/help');
        $bulletins = $this->model_help_help->getBulletins(1);
        $this->data['bulletins'] = $bulletins;
        
         //晒尔推荐
         $this->load->model ( 'social/saiercomment' );
         $saiercomment = $this->model_social_saiercomment->getShowComments();
         $this->data['saiercomment'] = array();
         foreach ($saiercomment as $saier ){
             if ( $firstImg = explode('|',$saier['imgurl'] )){
                 $countFirstImg = count($firstImg);
                 $saier['imgurl'] = $firstImg[0];
                 $strFile = '';
                 foreach ($firstImg as $k => $v){
                   $posDot = strrpos ( $v, '.' );
                   $strExt = substr ( $v, $posDot );
                   $posXie = strrpos ( $v, '/' );
                   $strFiles = substr ( $v, $posXie );
                   $strFiles = explode ( '-', $strFiles );
                   $strFiles = $strFiles[0];
                   if ($countFirstImg > 1 && $k <= $countFirstImg-2){
                       $strFiles = "uploads/big" . $strFiles . $strExt;
                       $strFile .= $strFiles.'|';
                   }
                 }
                 $strFile .= "uploads/big" . $strFiles . $strExt;
             }
             if (!empty($saier['videourl'])){
                 include_once (DIR_SYSTEM . 'VideoUrlParser.class.php');
                 $videourl = VideoUrlParser::parse ( $saier['videourl'] );
                 $video = $videourl;
             }else{
                 $video = '';
             }
             $this->data['saiercomment'][] = array(
                 'if_show'    =>    $saier['if_show'],
                 'message_id' =>    $saier['message_id'],
                 'firstname'  =>    $saier['firstname'],
                 'face'       =>    $saier['face'],
                 'country'    =>    $saier['country'],
                 'message_text'       =>    $saier['message_text'],
                 'imgurl'       =>    $saier['imgurl'],
                 'strFile'      =>    $strFile,
                 'videourl'     =>    $video,
                 'comments'       =>    $saier['comments'],
             	 'points'      =>   $saier['points'],
                 'utype'     =>    $saier['utype']
             );
         }
        
        //达人榜
        $this->load->model('social/social');
        
        $darens = $this->model_social_social->getDaren();
        
        foreach($darens as &$daren) {
            
            
            if(!$daren['face']) {
                
                $daren['face'] = "uploads/big/0b4a96400b2372d25da769647bfe4059.jpg";
            }
           
        } 
        
        $this->data['daren_info'] = $darens;

		$this->template = 'cnstorm/template/common/social_right.tpl';
	
		
		$this->render ();
	}
}

?>
