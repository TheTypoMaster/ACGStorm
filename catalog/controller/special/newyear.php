<?php
class ControllerSpecialNewYear extends Controller {

    public function index() {

        $this->data['logged'] = $this->customer->isLogged();
        //$this->data['text_logged'] = sprintf("您好，", HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['text_logged'] = "您好，<a href='/order.html' target='_blank'>".$this->customer->getFirstName()."</a>（<a href='/account-logout.html'>退出</a>）";
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/newyear.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/newyear.tpl';
        } else {
            $this->template = 'default/template/specialtpl/newyear.tpl';
        }
        
        $this->response->setOutput($this->render());
    }

    public function lucky_spin() {
        
        //验证是否登录
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('special/newyear/lucky_spin', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $this->load->model('account/luckyspin');
        
        $customer_id = $this->customer->getId();
        
        $flag = $this->model_account_luckyspin->getluckyspin($customer_id);
        
        if($flag) {
            
            $ymd = date('Y-m-d', $flag);
            
            $now = date('Y-m-d',time());
            
            if($ymd == $now) {
                $this->data['click_flag'] = 2;
            } else {
                $this->data['click_flag'] = 1;
            }
            
        }else {
            
            $this->data['click_flag'] = 0;
        }
        
        $this->data['luckyspin_info'] = $this->model_account_luckyspin->getluckyspininfo();

        $this->data['logged'] = $this->customer->isLogged();
        //$this->data['text_logged'] = sprintf("您好，", HTTP_SERVER . 'order.html', $this->customer->getFirstName(), HTTP_SERVER . 'account-logout.html');
        $this->data['text_logged'] = "您好，<a href='/order.html' target='_blank'>".$this->customer->getFirstName()."</a>（<a href='/account-logout.html'>退出</a>）";
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/lucky_spin.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/lucky_spin.tpl';
        } else {
            $this->template = 'default/template/specialtpl/lucky_spin.tpl';
        }
        
        $this->response->setOutput($this->render());
    }

    public function eggs() {
    	if (!$this->customer->isLogged()) {
            $this->session->data['redirect'] = $this->url->link('account/newyear', '', 'SSL');
            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
    	$this->data['logged'] = $this->customer->isLogged();
	$custormer_name = $this->customer->getFirstName();
        //$this->data['text_logged'] = sprintf("您好，", HTTP_SERVER . 'order.html', $custormer_name, HTTP_SERVER . 'account-logout.html');
        $this->data['text_logged'] = "您好，<a href='order.html' target='_blank'>".$custormer_name."</a>（<a href='account-logout.html'>退出</a>）";
	$this->data['customer_id'] = $this->customer->getId();
    	$customer_id = $this->data['customer_id'];
	$this->load->model('account/customer');
	$egg = $this->model_account_customer->getEggDate($customer_id);
	$egg_date = date("Y-m-d",strtotime($egg));
	$time = date("Y-m-d",time());
	$time1 = date("ymdHsi",time());
	$this->data['egg_sign'] = $egg_date == $time?1:0;
	
	//var_dump(strtotime(date("2015-01-08 00:00:00")));
	//var_dump(strtotime(date("2015-02-01 00:00:00")));
	//敲打金蛋,2015-01-08时间戳为1420646400	
	if (/*time() < 1420646400 && */!$this->data['egg_sign'] && isset($this->request->get['customer_id'])){
		$prize_arr = array(
			'0' => array('id'=>1,'prize'=>'100元现金券','v'=>1),
			'1' => array('id'=>2,'prize'=>'10元现金券','v'=>10),
			'2' => array('id'=>3,'prize'=>'5元现金券','v'=>30),
			'3' => array('id'=>4,'prize'=>'2元现金券','v'=>50),
			'4' => array('id'=>5,'prize'=>'1元现金券','v'=>55),
			'5' => array('id'=>6,'prize'=>'下次没准就能中哦','v'=>50),
		);
		foreach ($prize_arr as $key => $val) {
			$arr[$val['id']] = $val['v'];
		}
		$rid = getRand($arr); /*根据概率获取奖项id*/
		switch ($rid){
		case 1:  $money = 100;break;  
		case 2:  $money = 10;break;
		case 3:  $money = 5;break;
		case 4:  $money = 2;break;
		case 5:  $money = 1;break;
		default: $money = 0;break;
		}
		$data = array(
			"sn"=>$time1,
			"firstname"=>$custormer_name,
			"getway"=>3,
			"endtime"=>1422720000,
			"addtime"=>time(),
			"money"=>$money,
			"sellmoney"=>null,
			"state"=>1
		);
		$res['msg'] = ($rid==6)?0:1; 
		if ($res['msg']){
			$Getresult = $this->model_account_customer->editEggDate($customer_id);
			if ($Getresult){
				$this->model_account_customer->addCoupon($data);
			}
		}else{
			$this->model_account_customer->editEggDate($customer_id);
		}
		$res['prize'] = $prize_arr[$rid-1]['prize']; /*中奖项*/
		echo json_encode($res);exit;
	}
	date_default_timezone_set("Asia/Shanghai");
	$this->data['rewards'] = $this->model_account_customer->getCouponsGetway();
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/specialtpl/eggs.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/specialtpl/eggs.tpl';
        } else {
            $this->template = 'default/template/specialtpl/eggs.tpl';
        }

        $this->response->setOutput($this->render());
    }
	
	public function get_corona() {
	   
       //验证是否登录
        if (!$this->customer->isLogged()) {

            $this->session->data['redirect'] = $this->url->link('special/newyear/lucky_spin', '', 'SSL');

            $this->redirect($this->url->link('account/login', '', 'SSL'));
        }
        
        $this->load->model('account/luckyspin');
        $this->load->model('account/record');
        $this->load->model('account/customer');
        
        
        $uid = $this->customer->getId();
        
        $uname = $this->customer->getFirstName();
        
        $this->model_account_luckyspin->updateluckyspin();
        
        $data1 = array(
			'isHasChance' => true,
			'rotate' => 340,
			'results' => '很遗憾,明天再来吧！'
		);
        
        $data2 = array(
			'isHasChance' => true,
			'rotate' => 290,
			'results' => '恭喜您，中奖获得10积分！'
		);
        
        $data3 = array(
			'isHasChance' => true,
			'rotate' => 250,
			'results' => '恭喜您，中奖获得100积分！'
		);
        
        $data4 = array(
			'isHasChance' => true,
			'rotate' => 200,
			'results' => '恭喜您，中奖获得价值20元的优惠卷！'
		);
        
        $index  = rand(1,100);
        $data = array();
        if($index >= 1 &&  $index <= 80) {
            
            $data = $data1;
            
        } else if($index > 80 && $index <= 90) {
            
            $data = $data2;
            
            //插入积分记录
            $score = $this->customer->getScore();
            
            $newscore = $score + 10;
            
            $this->model_account_customer->editScores($newscore);
    
            $insert_score_record = array(
                'uid' => $uid,
                'firstname' => $uname,
                'remark' => '转轮盘中奖获得积分10',
                'score' => '10',
                'type' => '1',
                'totalscore' => $newscore
            );

            $this->model_account_record->addScoreRecord($insert_score_record);
            
            //插入中奖记录
            
            
            $spin_data = array(
                'uid' => $uid,
                'uname' => $uname,
                'remark' => "转轮盘中奖获得10积分",
                'addtime' => time()
            );
            
            $this->model_account_luckyspin->addspinrecord($spin_data);
            
            
        } else if($index > 90 && $index <= 95) {
            
            $data = $data3;
            
            //插入积分记录
            $score = $this->customer->getScore();
            
            $newscore = $score + 100;
            
            $this->model_account_customer->editScores($newscore);
    
            $insert_score_record = array(
                'uid' => $uid,
                'firstname' => $uname,
                'remark' => "转轮盘中奖获得100积分",
                'score' => '100',
                'type' => '1',
                'totalscore' => $newscore
            );

            $this->model_account_record->addScoreRecord($insert_score_record);
            
            //插入中奖记录
            $this->load->model('account/luckyspin');
            
            $spin_data = array(
                'uid' => $uid,
                'uname' => $uname,
                'remark' => "中奖获得100积分",
                'addtime' => time()
            );
            
            $this->model_account_luckyspin->addspinrecord($spin_data);
                
        } else if($index > 95 && $index <= 98) {
            
            $data = $data4;
            
            //插入优惠卷记录
            $coupon_data = array(
                'uid' => $uid,
                'uname' => $uname,
                'money' => 20,
                'date_start' => date('Y-m-d',time()),
                'date_end' => date('Y-m-d',strtotime('1 months')),
                'status' => 1
            );
            
            
            $this->model_account_luckyspin->addCoupon($coupon_data);
            
            //插入中奖记录
            $this->load->model('account/luckyspin');
            
            $spin_data = array(
                'uid' => $uid,
                'uname' => $uname,
                'remark' => "中奖获得20元优惠卷",
                'addtime' => time()
            );
            
            $this->model_account_luckyspin->addspinrecord($spin_data);
        }
	    
		$this->response->setOutput(json_encode($data));
	}

}
    
?>