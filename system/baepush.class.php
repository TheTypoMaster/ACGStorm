<?php

/**
 * @description：百度云推送
 * @author：fc@cnstorm.com
 * @date：2014-9-19
 */
Class Baepush {
	
	// public static function inst() {
	// 	static $singleton;
	// 	if (null == $singleton) {
	// 		$singleton = new Baepush();
	// 	}
	// }

	// private function __construct() {}

	
	public function push($data) {
		require_once(DIR_SYSTEM.'/baidu/Channel.class.php');
		// var_dump(BAE_API_KEY);
		$channel = new Channel(BAE_API_KEY, BAE_SECRET_KEY);

		if (array_key_exists('description', $data)) {
			if (mb_strlen($data['description'], 'utf-8') > 39)
				$data['description'] = mb_substr($data['description'], 0, 37, 'utf-8') . '...';
		}

		//推送类型，1单人(必须指定user_id和channel_id)、2群组(必须指定tag_name)、3所有人
		$push_type = $data['push_type'];

		$message["title"] = array_key_exists('title', $data) ? $data['title'] : '';//android必选
		$message["description"] = $data['description'];//android必选
		// $message["custom_content"] = array ("jump_id" => array_key_exists('jump_id', $data) ? $data['jump_id'] : '', "url" => array_key_exists('url', $data) ? $data['url'] : '');//android自定义字段
		$message["aps"] = array("alert" => $data['description'], "sound" => "", "badge" => 1);//ios特有字段

		if (array_key_exists('custom_content', $data)) {
			if ($data['device_type'] == 3) {//android
				$message["custom_content"] = $data['custom_content'];
			} elseif ($data['device_type'] == 4) {//ios
				foreach ($data['custom_content'] as $key => $value) {
					$message[$key] = $value;
				}
			}
		}

		$message_key = "msg_key";//不支持ios

		//1：浏览器设备、2：pc设备、3：Android设备、4：ios设备、5：windows phone设备
		$optional[Channel::DEVICE_TYPE] = $data['device_type'];

		//Channel::USER_ID，标识用户的ID，分为百度账号与无账号体系：无账号体系的user_id根据端上属性生成；百度账号体系根据账号生成user_id。
		$optional[Channel::USER_ID] = array_key_exists('user_id', $data) ? $data['user_id'] : '';

		//Channel::MESSAGE_TYPE，消息类型，0：消息（透传），1：通知
		$optional[Channel::MESSAGE_TYPE] = array_key_exists('message_type', $data) ? $data['message_type'] : 1;

		//ios部署状态，1开发状态，默认是2生产状态
		$optional[Channel::DEPLOY_STATUS] = array_key_exists('deploy_status', $data) ? $data['deploy_status'] : '';

		$ret = $channel->pushMessage($push_type, $message, $message_key, $optional);
		if (false === $ret) {
			// $err = 'ERROR NUMBER: ' . $channel->errno() . '; ERROR MESSAGE: ' . $channel->errmsg() . '; REQUEST ID: ' .
			// 	 $channel->getRequestId() . ";";
			// Log::record($err);
			// var_dump( array ("ret" => SYS_RET_ERR, "err" => $err) );
		} else {
			// var_dump( array ("ret" => 0, "err" => "") );
		}
	}
}